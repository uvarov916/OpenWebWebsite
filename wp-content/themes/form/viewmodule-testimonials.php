<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>

<section class="content container" id="section-<?php echo $bid; ?>">

	<div class="row">
		<div class="title center col-sm-12">
			<?php if (!empty($data->title)): ?>
			<h2><?php echo $data->title; ?></h2>
			<?php endif; ?>
			<?php if (!empty($data->content)): ?>
			<?php echo $data->content; ?>
			<?php endif; ?>
			<div class="testimonial-pager"></div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 animated fade" data-appear-bottom-offset="100">
			<ul class="testimonials">

				<?php foreach ($items as $item): ?>
				<li>
					<p class="testimonial"><?php echo $item->content; ?></p>
					<p class="highlighted">
						<?php echo $item->title; ?>
						<small><?php echo $item->via; ?></small>
					</p>
				</li>
				<?php endforeach; ?>

			</ul>
		</div>
	</div>

</section>