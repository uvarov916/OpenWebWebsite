<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php $bg = empty($meta->hero->background) ? $t->options->get('hero_bg') : $meta->hero->background; ?>
<?php $style = (empty($bg) || $bg === 'none') ? '' : sprintf('style="background-image: url(%s)"',$bg); ?>
<?php $prev = $content->prevPostLink(); $prev = $prev ? $prev : '#'; ?>
<?php $next = $content->nextPostLink(); $next = $next ? $next : '#'; ?>
<?php $portfolio_link = $meta->hero->portfolio ? $meta->hero->portfolio : '#'; ?>

<section class="hero small accent parallax" <?php echo $style; ?>>

	<!-- Heading -->
	<div class="hero-content container">
		<h1><?php $content->title(); ?></h1>
	</div><!-- END -->

	<!-- Button -->
	<div class="sub-hero container">
		<ul class="project-nav">
			<li class="prev-project clearfix"><a href="<?php echo esc_attr( $prev ); ?>"><?php _e("Prev",'Pixelentity Theme/Plugin'); ?></a></li>
			<li class="all-project clearfix"><a href="<?php echo esc_attr( $portfolio_link ); ?>"><i class="icon keypad white"></i></a></li>
			<li class="next-project clearfix"><a href="<?php echo esc_attr( $next ); ?>"><?php _e("Next",'Pixelentity Theme/Plugin'); ?></a></li>
		</ul>
	</div><!-- END -->

</section>