<?php $t =& peTheme(); ?>
<?php list($data,$items,$bid) = $t->template->data(); ?>
<?php $bg = empty($data->image) ? "" : sprintf('style="background-image: url(%s);"',$data->image) ?>

<section class="feature-box feature-box-staff light" id="section-<?php echo $bid; ?>">
	<div class="feature-image" <?php echo $bg; ?>></div>
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

		<?php while ($item1 = array_shift($items)): $item2 = array_shift($items) ?>
		<div class="row">
			<div class="feature col-sm-6 col-sm-offset-6 col-md-3 clearfix">
				<h3><?php echo $item1->title; ?></h3>
				<p class="small"><?php echo $item1->content; ?></p>

				<?php if (!empty($item1->social)): ?>
				<ul class="social-list animated fade" data-appear-bottom-offset="100">
					<?php foreach($item1->social as $social): ?>
					<?php $social = (object) $social; ?>
					<li><a href="<?php echo $social->url; ?>"><i class="<?php echo preg_replace('/\|.*/',"",$social->icon); ?>"></i></a></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php if (!empty($item2)): ?>
			<div class="feature col-sm-6 col-sm-offset-6 col-md-3 col-md-offset-0 clearfix">
				<h3><?php echo $item2->title; ?></h3>
				<p class="small"><?php echo $item2->content; ?></p>

				<?php if (!empty($item2->social)): ?>
				<ul class="social-list animated fade" data-appear-bottom-offset="100">
					<?php foreach($item2->social as $social): ?>
					<?php $social = (object) $social; ?>
					<li><a href="<?php echo $social->url; ?>"><i class="<?php echo preg_replace('/\|.*/',"",$social->icon); ?>"></i></a></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>

		<?php if (!empty($data->label) && !empty($data->url)): ?>
		<div class="row">
			<div class="padded col-sm-6 col-sm-offset-6">
				<a href="<?php echo $data->url; ?>" class="button gray"><?php echo $data->label; ?></a>
			</div>
		</div>
		<?php endif; ?>

	</div>
</section>