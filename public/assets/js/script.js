var HTTP_SERVER = "http://localhost/instaveritas/public/";
var spinnerwhitexs = ' <div class="spinner white xs"></div>';
var studios = [];   // to store studio results and their visibility status

$(document).on("click", ".search-box", function() {
    $(".search-modal").fadeIn("fast");
    $(".search-wrap .s-input").focus();
});

$(document).on("click", ".search-modal .x-icon", function() {
    $(".search-modal").fadeOut("fast");
});

$(document).on("click", "#login", function() {
    var username = $("#username").val().trim();
    var password = $("#password").val();
    if(username == "") {
        showPopover("#username", "top", "Please enter a valid username");
        return;
    }
    if(password == "") {
        showPopover("#password", "top", "Please enter your password");
        return;
    }
    var e = this;
    loadButton(e, spinnerwhitexs);
    $.ajax({
		url: HTTP_SERVER+'actions',
		type: 'POST',
		data: {'action':"login", 'username':username, 'password':password},
		success: function(data) {
            if(data == -1) {
                showPopover("#username", "top", "Wrong username or password");
            }
            else {
                location.reload();
            }
            unloadButton(e, ".spinner");
        }
	});
});

$(document).on("click", ".logout", function() {
    $.ajax({
		url: HTTP_SERVER+'actions',
		type: 'POST',
		data: {'action':"logout"},
		success: function(data) {
            location.reload();
        }
	});
});

$(document).on("click", "#myModal .slot", function() {
    if($(this).hasClass("pointer")) {
        $(this).toggleClass("b-back");
        $("#myModal .total-slots").html($("#myModal .slot.b-back").length);
    }
});

$(document).ready(function() {
    $(".f-price").each(function() {
        studios.push({
            "id": $(this).parent().parent().attr("id"),
            "price": parseInt($(this).val()),
            "open": parseInt($(this).parent().find(".f-open").val()),
            "close": parseInt($(this).parent().find(".f-close").val()),
            "display": 1
        });
    });

    $(".studio-more-details").click(function() {
        $(this).parents().eq(5).find(".extra-details").slideToggle("fast");
        if($(this).find(".glyphicon").hasClass("glyphicon-menu-down")) {
            $(this).find(".glyphicon").removeClass("glyphicon-menu-down");
            $(this).find(".glyphicon").addClass("glyphicon-menu-up");
        }
        else {
            $(this).find(".glyphicon").removeClass("glyphicon-menu-up");
            $(this).find(".glyphicon").addClass("glyphicon-menu-down");
        }
    });
});

// function to open sidenav
function openNav() {
    document.getElementById("mySidenav").style.left = "0";
}

// function to close sidenav
function closeNav() {
    document.getElementById("mySidenav").style.left = "-70%";
}

function searchStudio(e) {
    var keyword = e.value;
    $("#studio-wrap").html('<center class="pad-15 page-start"><div class="spinner pad-15"></div></center>');
    $.ajax({
        url: HTTP_SERVER+'actions',
        type: 'POST',
        data: {'action':"searchStudio", 'keyword':keyword},
        success: function(data) {
            $("#studio-wrap").html(data);
        }
    });
}

function getUserBookings() {
    $("#myModal .modal-content").html('<center class="pad-15"><div class="spinner pad-15"></div></center>');
    $.ajax({
        url: HTTP_SERVER+'actions',
        type: 'POST',
        data: {'action':"getUserBookings"},
        success: function(data) {
            $("#myModal .modal-content").html(data);
        }
    });
}

function getBookingSlots(sid, date) {
    $("#myModal .modal-content").html('<center class="pad-15"><div class="spinner pad-15"></div></center>');
    $.ajax({
        url: HTTP_SERVER+'actions',
        type: 'POST',
        data: {'action':"getBookingSlots", 'sid':sid, 'date':date},
        success: function(data) {
            $("#myModal .modal-content").html(data);
        }
    });
}

function confBooking(e, sid) {
    var slots = [];
    $("#myModal .slot.b-back").each(function() {
        slots.push($(this).attr("id").substring(5));
    });
    var date = $("#slot-date").val();
    loadButton(e, spinnerwhitexs);
    $.ajax({
        url: HTTP_SERVER+'actions',
        type: 'POST',
        data: {'action':"confBooking", 'sid':sid, 'slots':slots, 'date':date},
        success: function(data) {
            $("#myModal").modal("hide");
        }
    });
}

// function to sort on the basis of price, opening time and closing time
function sortResults(type, e) {
    var order = e.value;    // order to sort (ascending or descending)
    // perform selection sort and re-order the results
    var i, j;
    for(i = 0; i < studios.length - 1; i++) {
        for(j = i + 1; j < studios.length; j++) {
            if(studios[i]["display"] == 1 && studios[j]["display"] == 1) {
                if(studios[i][type] > studios[j][type]) {
                    var temp = studios[i];
                    studios[i] = studios[j];
                    studios[j] = temp;
                }
            }
        }
    }
    if(order == "desc") {
        studios.reverse();
    }
    for(i = 0; i < studios.length; i++) {
        if(studios[i]["display"] == 1) {
            var html = '<div class="clear-back res-wrap shad pad-l15" id="' + studios[i]["id"] + '">' + $("#" + studios[i]["id"]).html() + '</div>';
            $("#result-wrap").find("#" + studios[i]["id"]).remove();
            $("#result-wrap").append(html);
        }
    }
    // reset all other sorting categories
    $(".sort-cat").each(function() {
        $(this).val($(this).find("option:first").val());
    });
    $(e).val(order);
}

function filterResults() {
    var i;
    for(i = 0; i < studios.length; i++) {
        studios[i]["display"] = 1;
    }
    // studio opening time filter
    if($('.open-time-filter:checkbox:checked').length > 0) {
        for(i = 0; i < studios.length; i++) {
            // from the filtered list, remove all the studios which does not match the opening time criteria
            if(studios[i]["display"] == 1) {
                var dep = $("#" + studios[i]["id"] + " .filter-variables .f-open").val();
                var display = 0;    // let the default visible status of each studio be hidden
                $('.open-time-filter:checkbox:checked').each(function() {
                    if(this.value == dep) {
                        display = 1;    // set visible status of this studio be shown
                        return;
                    }
                });
                studios[i]["display"] = display;
            }
        }
    }

    // studio closing time filter
    if($('.close-time-filter:checkbox:checked').length > 0) {
        for(i = 0; i < studios.length; i++) {
            // from the filtered list, remove all the studios which does not match the closeing time criteria
            if(studios[i]["display"] == 1) {
                var arrival = $("#" + studios[i]["id"] + " .filter-variables .f-close").val();
                var display = 0;    // let the default visible status of each studio be hidden
                $('.close-time-filter:checkbox:checked').each(function() {
                    if(this.value == arrival) {
                        display = 1;    // set visible status of this studio be shown
                        return;
                    }
                });
                studios[i]["display"] = display;
            }
        }
    }

    // show/hide result set as per visibility status
    for(i = 0; i < studios.length; i++) {
        if(studios[i].display == 1) {
            // if visible status is 1 then show this studio
            $("#" + studios[i]["id"]).show(200);
        }
        else {
            // if visible status is 0 then hide this studio
            $("#" + studios[i]["id"]).hide(200);
        }
    }
}

/*
/ loadButton: function to switch button to loading state
*/

function loadButton(e, sp) {
    $(e).attr("disabled", true).html($(e).html() + sp);
}

/*
/ unloadButton: function to switch button to normal state
*/

function unloadButton(e, classes) {
    $(e).attr("disabled", false).find(classes).remove();
}
