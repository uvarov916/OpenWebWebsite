<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php $t->layout->pageTitle = __("The blog.",'Pixelentity Theme/Plugin'); ?>
<?php get_header(); ?>

<section class="content container">
	<div class="row">
		<div class="col-sm-8">
			<?php $t->content->loop(); ?>
		</div>
		<div class="col-sm-4">
			<?php get_sidebar(); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>