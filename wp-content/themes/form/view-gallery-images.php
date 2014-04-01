<?php $t =& peTheme(); ?>
<?php list($conf,$loop) = $t->template->data(); ?>

<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<?php $width = isset( $meta->gallery ) && isset( $meta->gallery->width ) && absint( $meta->gallery->width ) !== 0 ? absint( $meta->gallery->width ) : $t->media->w; ?>
<?php $height = isset( $meta->gallery ) && isset( $meta->gallery->height ) && absint( $meta->gallery->height ) !== 0 ? absint( $meta->gallery->height ) : $t->media->h; ?>


<section class="project-gallery">
	<ul class="project-slider">
		<?php while ($item =& $loop->next()): ?>
		<li><?php echo $t->image->resizedImg($item->img,$width,0); ?></li>				
		<?php endwhile; ?>
	</ul>
	<div class="project-prev"></div>
	<div class="project-next"></div>
	<div class="project-controls"></div>
</section>
