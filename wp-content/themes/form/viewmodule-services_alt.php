<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $bg = empty($data->image) ? "" : sprintf('style="background-image: url(%s);"',$data->image) ?>

<section class="feature-box light absolute clearfix" id="section-<?php echo $bid; ?>">
	<div class="center-mobile content container">
		<div class="row">
			<div class="title col-sm-6 col-sm-push-6 pe-wp-default">
				<?php if (!empty($data->title)): ?>
				<h2><?php echo $data->title; ?></h2>
				<?php endif; ?>
				<?php if (!empty($data->content)): ?>
				<?php echo $data->content; ?>
				<?php endif; ?>
			</div>
		</div>

		<?php while ($item1 = array_shift($items)): ?>
		<div class="row">
			<div class="feature col-sm-6 col-sm-push-6 clearfix">
				<i class="<?php echo $item1->icon; ?>"></i><h3><?php echo $item1->title; ?></h3>
				<p class="small"><?php echo $item1->content; ?></p>
			</div>
		</div>
		<?php endwhile; ?>

		<?php if (!empty($data->label) && !empty($data->url)): ?>
		<div class="row">
			<div class="feature col-sm-6 col-sm-offset-6">
				<a href="<?php echo $data->url; ?>" class="button gray"><?php echo $data->label; ?></a>
			</div>
		</div>
		<?php endif; ?>

	</div>
	<div class="image-absolute" <?php echo $bg; ?>></div>
</section>