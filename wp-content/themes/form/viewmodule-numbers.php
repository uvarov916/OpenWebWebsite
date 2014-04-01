<?php $t =& peTheme(); ?>
<?php list($data,$bid) = $t->template->data(); ?>

<section class="container" id="section-<?php echo $bid; ?>">

	<?php if (!empty($data->numbers)): ?>
	<div class="row">
		<?php foreach($data->numbers as $number):  ?>
		<?php $number = (object) $number; ?>
		<div class="milestone col-sm-4">
			<span class="timer value" data-from="0" data-to="<?php echo absint($number->number); ?>" data-speed="1000" data-refresh-interval="100">0</span>
			<h6><?php echo $number->description; ?></h6>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

</section>