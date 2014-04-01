<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<?php while ($content->looping() ) : ?>

	<section class="center-mobile overview-block content container">

		<?php $content->content(); ?>

	</section>

	<?php $format = get_post_format(); ?>

	<?php switch( $format ) :

		case( false ) : ?>

			<section class="project-image">

					<?php $content->img( 1920,0 ); ?>
			</section>

		<?php break; ?>

		<?php case( 'gallery' ) : ?>

			<?php $loop = $t->gallery->getSliderLoop($meta->gallery->id); ?>

			<?php if ( $loop ): ?>

				<section class="project-gallery">
					<ul class="project-slider">

						<?php while ($item =& $loop->next()): ?>

							<li><?php echo $t->image->resizedImg( $item->img, 1920, 1080 ); ?></li>

						<?php endwhile; ?>

					</ul>
					<div class="project-prev"></div>
					<div class="project-next"></div>
					<div class="project-controls"></div>
				</section>

			<?php endif; ?>

		<?php break; ?>

		<?php case( 'video' ) : ?>

			<section class="project-video">

					<?php $videoID = $meta->video->id; ?>
					<?php if ($video = $t->video->getInfo($videoID)): ?>

					<div class="vendor">

						<?php switch($video->type): case "youtube": ?>

							<iframe width="1920" height="1080" src="http://www.youtube.com/embed/<?php echo $video->id; ?>?autohide=1&modestbranding=1&showinfo=0" class="fullwidth-video" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						
						<?php break; case "vimeo": ?>

							<iframe src="http://player.vimeo.com/video/<?php echo $video->id; ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" class="fullwidth-video" width="1920" height="1080" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
						
						<?php endswitch; ?>

					</div>

					<?php endif; ?>
			</section>

		<?php break; ?>

	<?php endswitch; ?>

	<?php if ( ! empty( $meta->config->numbers ) && is_array( $meta->config->numbers ) ) : ?>

		<section class="container">
			<div class="row">

				<?php foreach ( $meta->config->numbers as $number ) : ?>

					<div class="milestone col-sm-4">
						<span class="timer value" data-from="0" data-to="<?php echo absint( $number['number'] ); ?>" data-speed="1000" data-refresh-interval="100">0</span>
						<h6><?php echo $number['description']; ?></h6>
					</div>

				<?php endforeach; ?>

			</div>
		</section>

	<?php endif; ?>

	
	<section class="feature-box light absolute clearfix">
		
		<div class="center-mobile content container">

			<?php if ( ! empty( $meta->config->intro ) ) : ?>

			<div class="row">
				<div class="title col-sm-6 col-sm-push-6">

					<?php echo $meta->config->intro; ?>

				</div>
			</div>

			<?php endif; ?>

			<?php if ( ! empty( $meta->config->features ) && is_array( $meta->config->features ) ) : ?>

				<?php foreach ( $meta->config->features as $feature ) : ?>

					<div class="row">
						<div class="feature col-sm-6 col-sm-push-6 clearfix">
							<i class="<?php echo $feature['icon']; ?>"></i><h3><?php echo $feature['title']; ?></h3>
							<p class="small"><?php echo $feature['description']; ?></p>
						</div>
					</div>

				<?php endforeach; ?>

		<?php endif; ?>

		</div>

		<?php if ( ! empty( $meta->config->featuresImg ) ) : ?>

			<div class="image-absolute">
				<img src="<?php echo $meta->config->featuresImg; ?>" alt="features image" />				
			</div>

		<?php endif; ?>

	</section>

	<?php get_template_part( 'sharingbuttons' ); ?>

<?php endwhile; ?>

<?php get_footer(); ?>