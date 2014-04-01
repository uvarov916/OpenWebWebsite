<?php $t =& peTheme(); ?>
<?php list($data,$bid) = $t->template->data(); ?>

<section class="container content" id="section-<?php echo $bid; ?>">

	<?php if ( ! empty( $data->info ) ) : ?>

		<div class="row">
			<div class="center title col-sm-12">
				
				<?php echo $data->info; ?>

			</div>
		</div>

	<?php endif; ?>

	<form method="post" name="contactform" class="peThemeContactForm row contactform" id="contactform-<?php echo $bid; ?>">

		<fieldset>
			<div class="form-field col-sm-6">
				<label for="name-<?php echo $bid; ?>"><?php _e("Name",'Pixelentity Theme/Plugin'); ?></label>
				<span><input type="text" name="author" id="name-<?php echo $bid; ?>" /></span>
			</div>
			<div class="form-field col-sm-6">
				<label for="email-<?php echo $bid; ?>"><?php _e("Email",'Pixelentity Theme/Plugin'); ?></label>
				<span><input type="email" name="email" id="email-<?php echo $bid; ?>" /></span>
			</div>
			<div class="form-field col-sm-12">
				<label for="message-<?php echo $bid; ?>"><?php _e("Message",'Pixelentity Theme/Plugin'); ?></label>
				<span><textarea name="message" id="message-<?php echo $bid; ?>"></textarea></span>
			</div>
		</fieldset>
		<div class="form-click center col-sm-12">
			<span><input type="submit" name="submit" value="<?php _e("Send it",'Pixelentity Theme/Plugin'); ?>" id="submit" /></span>
		</div>

		<div id="contactFormSent" class="notification-wrap clearfix formSent">
			<div class="notification success clearfix"><p><?php echo $data->msgOK; ?></p></div>
		</div>
		<div id="contactFormError" class="notification-wrap clearfix formError">
			<div class="notification error clearfix"><p><?php echo $data->msgKO; ?></p></div>
		</div>

	</form>

</section>

<?php if ($data->show == "yes"): ?>

	<section class="gmap" data-latitude="<?php echo $data->latitude; ?>" data-longitude="<?php echo $data->longitude; ?>" data-zoom="<?php echo $data->zoom; ?>" ></section>

<?php endif; ?>