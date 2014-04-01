<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<section id="<?php $content->slug(); ?>" class="container content">
	<div class="row">
		<div class="col-sm-12">
			
			<div class="page-body pe-wp-default">
				<?php $content->content(); ?>
			</div>

		</div>
	</div>
</section>