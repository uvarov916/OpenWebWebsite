<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>
<?php get_header(); ?>

<section class="portfolio-block">

	<?php if ( ! post_password_required( $post->ID ) ) : ?>
	<?php if ($loop = $t->gallery->getSliderLoop(get_the_id())): ?>
	<ul class="portfolio-grid">
		<?php while ($slide =& $loop->next()): ?>
		<li class="thumbnail mix mix_all">
			<a href="<?php echo $slide->img; ?>" class="lightbox">
				<?php echo $t->image->resizedImg($slide->img,577,383); ?>
				<div class="projectinfo">
					<div class="meta">
						<?php if (!empty($slide->ititle)): ?>
						<h4><?php echo $slide->ititle; ?></h4>
						<?php endif; ?>
					</div>
				</div>
			</a>
		</li>
		<?php endwhile; ?>
	</ul>
	<?php endif; ?>

	<?php else : ?>
	<?php echo get_the_password_form(); ?>
	<?php endif; ?>

</section>

<?php get_footer(); ?>