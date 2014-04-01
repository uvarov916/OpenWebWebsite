<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $title = $meta->hero->title; ?>
<?php $subtitle = $meta->hero->subtitle; ?>
<?php $new_window = 'yes' === $meta->hero->button_new_window ? 'target="_blank"' : 'target="_self"'; ?>
<?php $bg = empty($meta->hero->background) ? $t->options->get('hero_bg') : $meta->hero->background; ?>
<?php $style = (empty($bg) || $bg === 'none') ? '' : sprintf('style="background-image: url(%s)"',$bg); ?>

<section class="hero accent parallax" <?php echo $style; ?>>

	<!-- Heading -->
	<div class="hero-content container">
		<p><em><?php echo $subtitle; ?></em></p>
		<h1><?php echo $title; ?></h1>
	</div><!-- END -->

	<?php if ( ! empty( $meta->hero->button_text ) ) : ?>

		<div class="sub-hero container">
			<span class="line"></span>
			<a href="<?php echo esc_attr( $meta->hero->button_url ); ?>" <?php echo $new_window; ?> class="button white"><?php echo $meta->hero->button_text; ?></a>
		</div>

	<?php endif; ?>

</section>