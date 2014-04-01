<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $bg = empty($data->image) ? "" : sprintf('style="background-image: url(%s);"',$data->image) ?>

<section class="video-background content dark" id="section-<?php echo $bid; ?>" <?php echo $bg; ?>>
	<?php if (!empty($data->video)): ?>
	<div class="ytVideo" data-video="<?php echo esc_attr($data->video); ?>"></div>
	<?php endif; ?>
	<div class="container">

		<div class="row">
			<div class="center title col-lg-12">
				<?php if (!empty($data->title)): ?>
				<h2><?php echo $data->title; ?></h2>
				<?php endif; ?>
				<?php if (!empty($data->content)): ?>
				<?php echo $data->content; ?>
				<?php endif; ?>
			</div>
		</div>

		<ul class="center-mobile phases row">
			<?php while ($item1 = array_shift($items)): ?>
			<li class="col-sm-4 clearfix">
				<i class="<?php echo $item1->icon; ?>"></i><h3><?php echo $item1->title; ?></h3>
				<p class="small"><?php echo $item1->content; ?></p>
			</li>
			<?php endwhile; ?>
		</ul>


		<?php if (!empty($data->label) && !empty($data->url)): ?>
		<div class="row">
			<div class="center padded col-lg-12">
				<a href="<?php echo $data->url; ?>" class="button white"><?php echo $data->label; ?></a>
			</div>
		</div>
		<?php endif; ?>

	</div>
</section>