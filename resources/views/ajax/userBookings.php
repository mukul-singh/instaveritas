<?php
$months = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec");
?>
<div class="b-back pad-15">
	<h4 class="nomar">
	Your bookings
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</h4>
</div>
<div class="pad-15 lgrey in-scroll">
	<?php if(count($bookings) == 0) { ?>
		No bookings found
	<?php }
	else {?>
	<table class="table">
		<tr>
			<th>Sr</th>
			<th>Studio</th>
			<th>Time slot</th>
		</tr>
		<?php foreach ($bookings as $key => $b) {?>
		<tr>
			<td><?=($key + 1);?></td>
			<td><?=$b->name;?></td>
			<td><?=$b->bookingTime;?>, <?=substr($b->dateOfBooking, 8, 2)."-".$months[intval(substr($b->dateOfBooking, 5, 2))]."-".substr($b->dateOfBooking, 0, 4);?></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
</div>
<div class="pad-15">
	<button class="btn btn-default pull-right min-w100" data-dismiss="modal">Ok</button>
</div>