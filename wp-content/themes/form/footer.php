<?php $t =& peTheme(); ?>
<?php $layout =& $t->layout; ?>
<?php $content =& $t->content; ?>
<?php $meta =& $content->meta(); ?>

<?php $display_logos = $display_cta = is_page(); ?>
<?php $display_logos = ( empty( $meta->footerSections->logos ) ) ? false : true; ?>
<?php $display_cta = ( empty( $meta->footerSections->cta ) ) ? false : true; ?>

<?php if ( $display_logos ) : ?>

	<?php 

	$logos_gallery = $t->options->get("logosGallery");

	if ( intval( $logos_gallery ) ) :

		$loop = $t->gallery->getSliderLoop( $logos_gallery );

		if ( $loop ): 

		?>

			<section class="clients container">
				<div class="row">

					<?php while ($item =& $loop->next()): ?>

						<div class="logo animated fade col-sm-3" data-appear-bottom-offset="100">
							<img src="<?php echo $t->image->resizedImgUrl( $item->img, 150, 0 ); ?>" alt="<?php echo esc_attr($item->caption_title); ?>" />
						</div>

					<?php endwhile; ?>

				</div>
			</section>


		<?php 

		endif;

	endif;

	?>

<?php endif; ?>

<?php if ( $display_cta ) : ?>

<section class="call-to-action content light">
	<div class="container">

		<div class="row">
			<div class="title col-lg-12">

				<?php if ( $t->options->get("ctaTitle") ) : ?>

					<h2><?php echo $t->options->get("ctaTitle"); ?></h2>

				<?php endif; ?>

				<?php if ( $t->options->get("ctaSubtitle") ) : ?>

					<p><?php echo $t->options->get("ctaSubtitle"); ?></p>

				<?php endif; ?>

			</div>
		</div>

		<div class="row">
			<div class="actions padded col-lg-12">

				<?php if ( $t->options->get("ctaButton1Text") ) : ?>

					<a class="button accent-alt" href="<?php echo esc_attr( $t->options->get("ctaButton1Link") ); ?>">
						<?php echo $t->options->get("ctaButton1Text"); ?>
					</a>

				<?php endif; ?>

				<?php if ( $t->options->get("ctaButtonsSeparator") ) : ?>

					<span class="choice"><?php echo $t->options->get("ctaButtonsSeparator"); ?></span>

				<?php endif; ?>

				<?php if ( $t->options->get("ctaButton2Text") ) : ?>

					<a class="button gray" href="<?php echo esc_attr( $t->options->get("ctaButton2Link") ); ?>">
						<?php echo $t->options->get("ctaButton2Text"); ?>
					</a>

				<?php endif; ?>
				
			</div>
		</div>
	</div>
</section>

<?php endif; ?>

<footer>
	<div class="container">
		<div class="row">

			<!-- Contact List -->
			<ul class="contact-list col-md-8">

				<?php if ( $t->options->get("contactEmailFooter") ) : ?>

					<li><i class="fa fa-envelope-o"></i><a target="_blank" href="mailto:<?php echo esc_attr( $t->options->get("contactEmailFooter") ); ?>"><?php echo antispambot( $t->options->get("contactEmailFooter") ); ?></a></li>

				<?php endif; ?>

				<?php if ( $t->options->get("contactPhone") ) : ?>

					<li><i class="fa fa-phone"></i><a href="<?php echo wp_is_mobile() ? 'tel:' . str_replace( array( '+', ' ' ), '', $t->options->get("contactPhone") ) : 'javascript:void(0);'; ?>"><?php echo $t->options->get("contactPhone"); ?></a></li>

				<?php endif; ?>

				<?php if ( $t->options->get("contactAddress") ) : ?>

					<li><i class="fa fa-map-marker"></i><a target="_blank" href="<?php echo esc_attr( $t->options->get("contactAddressLink") ); ?>"><?php echo esc_attr( $t->options->get("contactAddress") ); ?></a></li>

				<?php endif; ?>

			</ul><!-- END -->

			<!-- Social List -->
			<ul class="social-list col-md-4">
				<?php $t->content->socialLinks($t->options->get("footerSocialLinks"),"footer"); ?>
				<li class="copyright"><?php echo $t->options->get("footerCopyright"); ?></li>
			</ul><!-- END -->

		</div>
	</div>
</footer>

<?php $t->footer->wp_footer(); ?>

</body>
</html>
