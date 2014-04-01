<?php $t =& peTheme();?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>

<?php $template = is_page() ? $t->content->pageTemplate() : false; ?>

<!-- Menu -->
<nav class="mobile">
	
	<div class="search-trigger"></div>
	<div class="search-form disabled">
		<form action="<?php echo esc_url(home_url("/")); ?>">
			<input name="s" id="search" type="text" class="search" onfocus="if(this.value == '<?php _e("Search...",'Pixelentity Theme/Plugin'); ?>') { this.value = ''; }" onblur="if(this.value == '') { this.value = '<?php _e("Search...",'Pixelentity Theme/Plugin'); ?>'; }" value="<?php _e("Search...",'Pixelentity Theme/Plugin'); ?>" />
		</form>
	</div>

	<?php $t->menu->show("main"); ?>
		
</nav>
<header class="mobile">

	<?php $logo = $t->options->get("logo"); ?>

	<?php if ( ! empty( $logo ) ) : ?>

		<a href="<?php echo home_url(); ?>" class="logo"><?php $t->image->retina($logo); ?></a>

	<?php endif; ?>

	<button type="button" class="nav-button">
		<div class="button-bars"></div>
	</button>

</header>

<div class="sticky-head"></div>