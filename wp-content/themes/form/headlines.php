<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php 

$homepage = array(
	'type'         => $meta->bg->type,
	'size'         => $meta->bg->size,
	'background'   => $meta->bg->background,
	'title'        => $meta->bg->title,
	'subtitle'     => $meta->bg->subtitle,
	'look'         => $meta->bg->look,
	'logo'         => $meta->bg->logo,
	'services'     => $meta->bg->services,
	'usevideo'     => $meta->bg->usevideo,
	'video'        => $meta->bg->video,
	'autoplay'     => $meta->bg->autoplay,
	'loop'         => $meta->bg->loop,
	'vid_button'   => $meta->bg->vid_button,
	'mute'         => $meta->bg->mute,
	'playhide'     => $meta->bg->playhide,
	'gallery'      => $meta->bg->gallery,
	'gal_look'     => $meta->bg->gal_look,
	'gal_fallback' => $meta->bg->gal_fallback,
	'controls'     => $meta->bg->controls,
);

if ( 'image' === $homepage['type'] ) : ?>

	<?php $homeclass = 'full' === $homepage['size'] || 'yes' === $homepage['usevideo'] ? 'home-wrap' : 'home-wrap-short'; ?>
	<?php $homeclass = 'yes' === $homepage['usevideo'] ? $homeclass . ' video' : $homeclass; ?>
	<?php $homeclass = 'yes' === $homepage['autoplay'] ? $homeclass . ' is-autoplay' : $homeclass; ?>
	<?php $homeclass = 'yes' === $homepage['playhide'] ? $homeclass . ' playhide' : $homeclass; ?>
	<?php $homeclass = 'yes' === $homepage['loop'] ? $homeclass . ' video-loop' : $homeclass; ?>

	<section id="<?php $content->slug(); ?>" class="<?php echo $homeclass; ?>">
		<div class="home-content text-white">

			<?php if ( 'simple' === $homepage['look'] ) : ?>

				<hr>

				<?php if ( ! empty( $homepage['title'] ) ) echo '<h5 class="bigtext serif italic margin-bottom">' . $homepage['title'] . '</h5>'; ?>
				<?php if ( ! empty( $homepage['subtitle'] ) ) echo '<h1 class="fittext uppercase bold">' . $homepage['subtitle'] . '</h1>'; ?>

				<?php if ( 'no' === $homepage['autoplay'] && '' === $homepage['vid_button'] && 'yes' === $homepage['usevideo'] ) echo '<a class="play-btn" onclick="jQuery(\'#video\').playYTP()"><i class="fa fa-play"></i></a>'; ?>
				<?php if ( 'no' === $homepage['autoplay'] && '' !== $homepage['vid_button'] && 'yes' === $homepage['usevideo'] ) echo '<a class="button white play-btn-normal margin-bottom" onclick="jQuery(\'#video\').playYTP()"><i class="fa fa-play-circle-o"></i>' . $homepage['vid_button'] . '</a>'; ?>

				<hr>

			<?php else : ?>

				<?php if ( ! empty( $homepage['logo'] ) ) echo '<img src="' . $homepage['logo'] . '" alt="' . __("Home",'Pixelentity Theme/Plugin') . '">'; ?>
				<?php if ( ! empty( $homepage['title'] ) ) echo '<h1 class="bigtext letterspace uppercase bold no-margin">' . $homepage['title'] . '</h1>'; ?>
				<?php if ( ! empty( $homepage['subtitle'] ) ) echo '<h6 class="bigtext serif italic margin-bottom">' . $homepage['subtitle'] . '</h6>'; ?>

				<?php if ( 'no' === $homepage['autoplay'] && '' === $homepage['vid_button'] && 'yes' === $homepage['usevideo'] ) echo '<a class="play-btn" onclick="jQuery(\'#video\').playYTP()"><i class="fa fa-play"></i></a>'; ?>
				<?php if ( 'no' === $homepage['autoplay'] && '' !== $homepage['vid_button'] && 'yes' === $homepage['usevideo'] ) echo '<a class="button white play-btn-normal margin-bottom" onclick="jQuery(\'#video\').playYTP()"><i class="fa fa-play-circle-o"></i>' . $homepage['vid_button'] . '</a>'; ?>

				<?php if ( ! empty( $homepage['services'] ) && is_array( $homepage['services'] ) ) : ?>

					<?php get_template_part( 'headlines', 'services' ); ?>

				<?php endif; ?>

			<?php endif; ?>

		</div>
	</section>

	<?php if ( 'yes' === $homepage['usevideo'] && -1 !== $homepage['video'] ) : ?>

		<?php 

			$video = get_post_meta( $homepage['video'], 'pe_theme_meta', true );

			$settings = "quality: 'highres',";

			$settings .= 'yes' === $homepage['autoplay'] ? 'autoPlay:true,' : 'autoPlay:false,';
			$settings .= 'yes' === $homepage['mute'] ? 'mute:true,' : 'mute:false,';
			$settings .= 'yes' === $homepage['loop'] ? 'loop:true' : 'loop:false';

		?>

		<div class="video-container">
			<a id="video" class="fullscreen-video" data-property="{videoURL:'<?php echo $video->video->url; ?>', <?php echo $settings; ?>}"></a>
		</div>

		<div class="video-controls">
			<button class="small-play-btn" onclick="jQuery('#video').playYTP()"><i class="fa fa-play"></i></button>
			<button class="small-pause-btn" onclick="jQuery('#video').pauseYTP()"><i class="fa fa-pause"></i></button>
			<button onclick="jQuery('#video').toggleVolume()"><i class="fa fa-volume-up"></i></button>
		</div>

	<?php endif; ?>

	<?php if ( ! empty( $homepage['background'] ) ) echo '<div style="background-image: url(\'' . $homepage['background'] . '\');" class="fullscreen-img"></div>'; ?>

<?php else : // gallery ?>

	<?php if ( 'simple' === $homepage['gal_look'] ) : ?>

		<?php $homeclass = 'full' === $homepage['size'] || 'yes' === $homepage['usevideo'] ? 'home-wrap' : 'home-wrap-short'; ?>

		<?php $controls = $homepage['controls']; ?>

		<section id="<?php $content->slug(); ?>" class="<?php echo $homeclass; ?> splash-gallery-slider splash-gallery-slider-simple splash-<?php echo $controls; ?>">
			<div class="home-content text-white">

				<?php if ( ! empty( $homepage['logo'] ) ) echo '<img src="' . $homepage['logo'] . '" alt="' . __("Home",'Pixelentity Theme/Plugin') . '">'; ?>
				<?php if ( ! empty( $homepage['title'] ) ) echo '<h1 class="bigtext letterspace uppercase bold no-margin">' . $homepage['title'] . '</h1>'; ?>
				<?php if ( ! empty( $homepage['subtitle'] ) ) echo '<h6 class="bigtext serif italic margin-bottom">' . $homepage['subtitle'] . '</h6>'; ?>

				<?php if ( ! empty( $homepage['services'] ) && is_array( $homepage['services'] ) ) : ?>

					<?php get_template_part( 'headlines', 'services' ); ?>

				<?php endif; ?>

			</div>

			<?php if ( 'arrows' === $homepage['controls'] || 'both' === $homepage['controls'] ) : ?>

				<div id="home-controls">
					<a class="prev" href="javascript:void(0)"></a>
					<a class="next" href="javascript:void(0)"></a>
				</div>

			<?php endif; ?>

		</section>

		<?php if ( ! empty( $homepage['gal_fallback'] ) ) : ?>

			<div style="background-image: url('<?php echo esc_attr( $homepage['gal_fallback'] ); ?>');" class="fullscreen-img fallback-image"></div>

		<?php endif; ?>

		<?php if ( ! empty( $homepage['background'] ) ) echo '<div style="background-image: url(\'' . $homepage['background'] . '\');" class="fullscreen-img fallback-image"></div>'; ?>

		<?php $loop = $t->gallery->getSliderLoop( $homepage['gallery'] ); ?>

		<?php if ( $loop ): ?>

			<?php while ($slide =& $loop->next()): ?>

				<div class="hiddenslide" data-src="<?php echo $slide->img; ?>" data-title="<?php echo esc_attr( $slide->ititle ); ?>" data-description="<?php echo esc_attr( $slide->caption ); ?>"></div>

			<?php endwhile; ?>

		<?php else: ?>

			<p><?php _e("Gallery you selected as a Slider Gallery in Home page settings contains no slides, make sure to upload at least one image for selected gallery.",'Pixelentity Theme/Plugin'); ?></p>

		<?php endif; ?>

	<?php else : ?>

		<?php $homeclass = 'full' === $homepage['size'] || 'yes' === $homepage['usevideo'] ? 'home-wrap' : 'home-wrap-short'; ?>

		<?php $controls = $homepage['controls']; ?>

		<section id="<?php $content->slug(); ?>" class="<?php echo $homeclass; ?> splash-gallery-slider splash-gallery-slider-notsimple splash-<?php echo $controls; ?>">
			<div id="slides">
				<ul class="slides-container">

					<?php $loop = $t->gallery->getSliderLoop( $homepage['gallery'] ); ?>

					<?php if ( $loop ): ?>

						<?php while ($slide =& $loop->next()): ?>

							<li>
								<div class="home-content">
									<div class="centerdiv text-white">
										<hr>
										<?php if ( ! empty( $slide->ititle ) ) echo '<h1 class="bigtext uppercase no-margin">' . $slide->ititle . '</h1>'; ?>
										<?php if ( ! empty( $slide->caption ) ) echo '<h6 class="bigtext serif italic">' . $slide->caption . '</h6>'; ?>
										<hr>
									</div>
								</div>
								<div style="background-image: url('<?php echo $slide->img; ?>');" class="slides-fullscreen-img"></div>
							</li>

						<?php endwhile; ?>

					<?php else: ?>

						<p><?php _e("Gallery you selected as a Slider Gallery in Home page settings contains no slides, make sure to upload at least one image for selected gallery.",'Pixelentity Theme/Plugin'); ?></p>

					<?php endif; ?>

				</ul>

				<?php if ( 'arrows' === $homepage['controls'] || 'both' === $homepage['controls'] ) : ?>

					<nav class="slides-navigation">
						<a class="prev" href="javascript:void(0)"></a>
						<a class="next" href="javascript:void(0)"></a>
					</nav>

				<?php endif; ?>

			</div>
		</section>

	<?php endif; ?>

<?php endif; ?>