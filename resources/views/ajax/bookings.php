<?php
$today = date("Y-m-d");	// minimum date to select should be restrected to today
function zeroFormat($i) {
	if($i < 10) {
		return '0'.$i;
	}
	else {
		return $i;
	}
} ?>

<div class="b-back pad-15">
	<h4 class="nomar">
		<?=$studio->name;?>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</h4>
</div>
<div class="pad-15">
	<div class="col-xs-12 col-sm-6 col-md-6 nopad">
		<label class="llgrey small">Date of booking</label>
		<input type="date" id="slot-date" class="form-control" value="<?=$date;?>" min="<?=$today;?>" onchange="getBookingSlots('<?=base64_encode(base64_encode($studio->sid));?>', this.value)">
	</div>
	<div class="clearfix"></div>
	<div class="bot-15"></div>
	<small class="llgrey">Select time slots</small><br/>
	<?php for($i = intval(substr($studio->openingTime, 0, 2)); $i < intval(substr($studio->closingTime, 0, 2)); $i++) { ?>
	<span class="col-xs-4 col-sm-4 col-md-4 round-2 bordered slot <?=(in_array(zeroFormat($i), $bookings) ? 'lllgrey' : 'pointer');?>" id="slot-<?=$i;?>" title="<?=(in_array(zeroFormat($i), $bookings) ? 'Slot already booked' : 'Slot available');?>"><?=zeroFormat($i);?>:00 - <?=zeroFormat($i + 1);?>:00</span>
	<?php } ?>
	<div class="clearfix"></div>
	<div class="bot-15"></div>
	<div>Total slots: <span class="b-color total-slots">0</span></div>
	<div class="bot-15"></div>
	<button class="btn prl-back-color trans" onclick="confBooking(this, '<?=base64_encode(base64_encode($studio->sid));?>')">Confirm booking</button>
</div>
