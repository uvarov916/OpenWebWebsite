<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $title = $t->layout->pageTitle ? $t->layout->pageTitle : get_the_title(); ?>
<?php $title = empty($title) ? __("The blog.",'Pixelentity Theme/Plugin') : $title; ?>
<?php $bg = empty($meta->hero->background) ? $t->options->get('hero_bg') : $meta->hero->background; ?>
<?php $style = (empty($bg) || $bg === 'none') ? '' : sprintf('style="background-image: url(%s)"',$bg); ?>

<section class="hero small accent parallax" <?php echo $style; ?>>

	<!-- Heading -->
	<div class="hero-content container">
		<h1><?php echo $title; ?></h1>
	</div><!-- END -->

	<!-- Button -->
	<div class="sub-hero container">
		<span class="line"></span>
	</div><!-- END -->

</section>