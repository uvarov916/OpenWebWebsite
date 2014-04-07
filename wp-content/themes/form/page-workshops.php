<?php get_header();

query_posts( array (
	'post_type' => 'workshop'
));

?>

<div class="container content">
	<div class="row">

		<?php if ( have_posts() ) : while ( have_posts() ): the_post(); ?>

			<div class="image post post-single">
				<div class="post-title">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>
			</div>

		<?php endwhile; else: ?>
			<h2>There are no workshops here</h2>
		<?php endif; ?>

	</div>
</div>

<?php get_footer(); ?>