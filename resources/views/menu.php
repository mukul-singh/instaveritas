<nav class="iq-nav <?=(isset($page) && $page == "home") ? 'nav-no-back':'';?> navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header lgrey">
            <img class="img-responsive in-bl" alt="Instaveritas" src="<?=HTTP_SERVER;?>assets/images/logo.png" width="120">
            <?php if(Auth::check()) {?>
            <span onclick="openNav()" class="in-bl pull-right glyphicon glyphicon-menu-hamburger visible-xs"></span>
            <?php } ?>
        </div>
        <ul class="nav navbar-nav hidden-xs">
            <li><a href="#">Studios</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right xs-nomar">
            <?php if(Auth::check()) {?>
            <li class="search-box">
                <input type="text" class="form-control" placeholder="Search by studio name" onkeyup="searchStudio(this);">
            </li>
            <li class="hidden-xs"><a href="#" data-toggle="modal" onclick="getUserBookings()" data-target="#myModal" title="Previous bookings">My Bookings</a></li>
            <li class="hidden-xs"><a href="#" class="logout" title="Logout">Logout</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
<div id="mySidenav" class="sidenav">
    <?php if(Auth::check()) {?>
    <h4 class="pad-15 b-back nomar">
        <img src="assets/images/user.jpg" class="mar-r5 bordered" width="40" height="40" alt="User avatar">
        <span class="pull-right closebtn" onclick="closeNav()">&times;</span>
        <?=ucwords(Auth::user()->username);?>
    </h4>
    <div class="bordered-r">
        <ul class="list-unstyled pad-15 nomar">
            <li><a href="#" data-toggle="modal" onclick="closeNav();getUserBookings()" data-target="#myModal">My Bookings</a></li>
            <li><a href="#">Cancel Booking</a></li>
            <li><a href="#" class="logout">Logout</a></li>
        </ul>
        <hr class="nomar"/>
        <?php } ?>
        <ul class="list-unstyled pad-15 nomar">
            <li><a href="<?=HTTP_SERVER;?>">Home</a></li>
            <li><a href="#">Book a Studio</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
        </ul>
    </div>
</div>
<div id="studio-wrap">
    