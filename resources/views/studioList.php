<div class="col-xs-12 col-sm-11 col-md-10 center xs-nopad page-start">
    <div class="col-xs-12 col-sm-4 col-md-4">
        <?php if(count($studios) > 0) {?>
        <h5 class="lgrey">Filters</h5>
        <div id="filter-wrap">
            <div class="col-xs-12 col-sm-12 col-md-12 clear-back pad-15 filter shad">
                <h5 class="mar-t0">
                    <img src="assets/images/clock.png" class="mar-r5" alt="clock-icon">
                    Opening Time
                </h5>
                <ul class="list-unstyled nomar">
                    <?php foreach ($openingTime as $key => $t) { ?>
                        <li><label class="pointer"><input type="checkbox" class="open-time-filter" value="<?=((int)substr($t, 0, 2) * 60) + ((int)substr($t, 3, 2));?>" onchange="filterResults()"><span class="pad-l10"><?=$t;?></span></label></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 clear-back pad-15 filter shad">
                <h5 class="mar-t0">
                    <img src="assets/images/clock.png" class="mar-r5" alt="clock-icon">
                    Closing Time
                </h5>
                <ul class="list-unstyled nomar">
                    <?php foreach ($closingTime as $key => $t) { ?>
                        <li><label class="pointer"><input type="checkbox" class="close-time-filter" value="<?=((int)substr($t, 0, 2) * 60) + ((int)substr($t, 3, 2));?>" onchange="filterResults()"><span class="pad-l10"><?=$t;?></span></label></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="clearfix"></div>
            <div class="bot-15 visible-xs"></div>
        </div>
        <?php } ?>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-8">
        <div class="sort-wrap">
            <div class="col-xs-12 col-sm-3 col-md-3 nopad lgrey">
                <h5 class="mar-b0"><?=(count($studios) == 0) ? 'No' : count($studios);?> studio<?=(count($studios) > 1 || count($studios) == 0) ? 's' : '';?> found</h5>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 text-right nopad sort-var">
                <small class="b-color">Sort by</small>
                <div class="col-xs-3 col-sm-3 col-md-3 pad-r0 pull-right">
                    <select class="form-control sort-cat" onchange="sortResults('close', this)" title="Sort by price">
                        <option disabled selected>Close time</option>
                        <option value="asc">Low to high</option>
                        <option value="desc">High to low</option>
                    </select>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 pad-r0 pull-right">
                    <select class="form-control sort-cat" onchange="sortResults('open', this)" title="Sort by price">
                        <option disabled selected>Open time</option>
                        <option value="asc">Low to high</option>
                        <option value="desc">High to low</option>
                    </select>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 pad-r0 pull-right">
                    <select class="form-control sort-cat" onchange="sortResults('price', this)" title="Sort by price">
                        <option disabled selected>Price</option>
                        <option value="asc">Low to high</option>
                        <option value="desc">High to low</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="result-wrap">
            <?php foreach ($studios as $key => $s) { ?>
            <div class="clear-back res-wrap pad-l15 shad" id="studio-<?=$key;?>">
                <div class="hidden filter-variables">
                    <input type="hidden" class="f-price" value="<?=$s->rate;?>">
                    <input type="hidden" class="f-open" value="<?=((int)substr($s->openingTime, 0, 2) * 60) + ((int)substr($s->openingTime, 3, 2));?>">
                    <input type="hidden" class="f-close" value="<?=((int)substr($s->closingTime, 0, 2) * 60) + ((int)substr($s->closingTime, 3, 2));?>">
                </div>
                <div class="col-xs-12 col-sm-2 col-md-2 air-logo-wrap pad-15">
                    <img src="<?=$s->profilePic;?>" class="img-responsive center" alt="studio-logo">
                </div>
                <div class="col-xs-12 col-sm-7 col-md-7 pad-15 pad-r0 bordered-r fd-wrap">
                    <h4 class="trip-title"><?=$s->name;?></h4>
                    <small class="llgrey"><?=$s->address;?></small>
                    <hr>
                    <div class="col-xs-4 col-sm-4 col-md-4 nopad">
                        <table>
                            <tr>
                                <td>
                                    <img src="assets/images/time-icon.png" alt="clock-icon">
                                </td>
                                <td class="studio-details" title="Opening time">
                                    <span class="small llgrey">Opening</span>
                                    <br/>
                                    <span class="b-color"><?=substr($s->openingTime, 0, 5);?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 nopad">
                        <table>
                            <tr>
                                <td>
                                    <img src="assets/images/time-icon.png" alt="clock-icon">
                                </td>
                                <td class="studio-details" title="Closing time">
                                    <span class="small llgrey">Closing</span>
                                    <br/>
                                    <span class="b-color"><?=substr($s->closingTime, 0, 5);?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 nopad">
                        <table>
                            <tr>
                                <td>
                                    <img src="assets/images/help-icon.png" alt="help-icon">
                                </td>
                                <td class="studio-more-details studio-details pointer" title="Check details">
                                    <span class="small llgrey">Details <small class="glyphicon glyphicon-menu-down"></small></span>
                                    <br/>
                                    <small class="seat-count">34 slots</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 pad-15 xs-pad-lr0">
                    <div class="col-xs-6 col-sm-12 col-md-12 nopad">
                        <h4 class="nomar prl-color" title="Ticket fare">Rs. <?=number_format($s->rate, 2);?></h4>
                        <small class="llgrey">Per hour</small>
                    </div>
                    <div class="hidden-xs">
                        <div class="clearfix"></div>
                        <div class="bot-15"></div>
                    </div>
                    <div class="col-xs-6 col-sm-12 col-md-12 nopad">
                        <button class="btn prl-back-color trans" data-toggle="modal" onclick="getBookingSlots('<?=base64_encode(base64_encode($s->sid));?>')" data-target="#myModal">Book Now</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="extra-details bordered-t small pad-15">
                    <div class="col-xs-12 col-sm-6 col-md-6 pad-l0 ex-info">
                        <div class="llgrey">Amenities</div>
                        <p><?=substr($s->amenities, 0, 200);?></p>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 ex-info">
                        <div class="llgrey">Equipments</div>
                        <p><?=substr($s->equipments, 0, 200);?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>
