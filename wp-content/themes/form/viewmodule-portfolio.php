<?php $t =& peTheme(); ?>
<?php $project =& $t->project; ?>
<?php list($portfolio,$id) = $t->template->data(); ?>
<?php $lightbox = !empty($portfolio->lightbox) && $portfolio->lightbox === 'yes'; ?>

<section class="portfolio-block" id="section-<?php echo $id; ?>">

	<div class="container">

		<?php if (!empty($portfolio->title) || !empty($portfolio->title)): ?>
		<div class="row">
			<div class="center title col-lg-12">
				<?php if (!empty($portfolio->title)): ?>
				<h2><?php echo $portfolio->title; ?></h2>
				<?php endif; ?>
				<?php if (!empty($portfolio->content)): ?>
				<?php echo $portfolio->content; ?>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>

		<div class="row">
			<ul class="filtering col-lg-12">
				<?php $project->filter('',"filter","active"); ?>
			</ul>
		</div>
	</div>

	<?php $content =& $t->content; ?>

	<ul class="portfolio-grid">

		<?php while ($content->looping()): ?>

		<?php $meta =& $content->meta(); ?>
		<?php $class = $lightbox && isset( $meta->config->lightbox ) && $meta->config->lightbox === 'yes' ? 'lightbox' : ''; ?>
		<?php $href = $class ? $t->image->resizedImgUrl( wp_get_attachment_url( get_post_thumbnail_id() ), 9999, 9999 ) : get_permalink(); ?>
		<?php $format = get_post_format(); ?>
		<?php $formatClass = $format ? 'single-' . $format : 'single-image' ; ?>

		<li class="thumbnail mix <?php $project->filterClasses(); ?> mix_all">
			<a href="<?php echo $href; ?>" class="<?php echo $class; ?>">
				<?php $content->img( 577, 383 ); ?>
				<div class="projectinfo">
					<div class="meta">
						<h4><?php $content->title(); ?></h4>
					</div>
				</div>
			</a>
		</li>

		<?php endwhile; ?>

	</ul>

	<?php if ($portfolio->pager === "yes"): ?>
	<?php $t->content->pager(); ?>
	<?php endif; ?>

</section>