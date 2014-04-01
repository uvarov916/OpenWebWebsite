<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php list($data,$loop,$bid) = $t->template->data(); ?>
<?php $bg = empty($data->image) ? "" : sprintf('style="background-image: url(%s);"',$data->image) ?>

<section class="recent-work content dark parallax" <?php echo $bg; ?> id="section-<?php echo $bid; ?>">

	<!-- Title and Subtitle -->
	<div class="container">
		<div class="row">
			<div class="col-sm-12 center">
				<?php if (!empty($data->title)): ?>
				<h2><?php echo $data->title; ?></h2>
				<?php endif; ?>
				<?php if (!empty($data->content)): ?>
				<?php echo $data->content; ?>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- END -->

	<?php if ($loop): ?>
	<div id="recent-gallery" class="royalSlider rsDefault visibleNearby">
		<?php while ($slide =& $loop->next()): ?>
		<a class="rsImg" href="<?php echo $t->image->resizedImgUrl($slide->img,566,375); ?>" data-rsw="566" data-rsh="375"></a>
		<?php endwhile; ?>
	</div><!-- END -->
	<?php endif; ?>

	<?php if (!empty($data->label) && !empty($data->url)): ?>
	<div class="row">
		<div class="center padded col-sm-12">
			<a href="<?php echo $data->url; ?>" class="button white"><?php echo $data->label; ?></a>
		</div>
	</div>
	<?php endif; ?>

</section>