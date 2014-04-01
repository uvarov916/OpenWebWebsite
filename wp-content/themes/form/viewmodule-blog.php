<?php $t =& peTheme(); ?>
<?php list($settings,$bid) = $t->template->data(); ?>

<section class="content container" id="section-<?php echo $bid; ?>">
	<div class="row">
		<div class="col-sm-8">
			<?php $t->template->data($settings); ?>
			<?php $t->get_template_part("loop"); ?>
		</div>
		<div class="col-sm-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>
