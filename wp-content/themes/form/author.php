<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $author = $wp_query->get_queried_object(); ?>
<?php $author = empty($author->user_nicename) ? '' : $author->user_nicename; ?>
<?php $t->layout->pageTitle = sprintf(__("Author: %s",'Pixelentity Theme/Plugin'),$author); ?>
<?php $meta =& $content->meta(); ?>
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