<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $t->layout->pageTitle = __("Not Found",'Pixelentity Theme/Plugin'); ?>
<?php get_header(); ?>

<section class="content container">
	<p><?php _e("The page you're looking for doesn't exist.",'Pixelentity Theme/Plugin'); ?></p>
</section>

<?php get_footer(); ?>