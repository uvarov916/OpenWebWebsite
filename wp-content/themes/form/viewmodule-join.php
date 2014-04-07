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


	<div id="mc_embed_signup">
		<form action="http://openwebbu.us3.list-manage.com/subscribe/post?u=bf325e8951cb5986b7c75cb4e&amp;id=10e27d6fc3" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate row contactform" target="_blank" novalidate>

			<fieldset>
				<div class="form-field col-sm-6 mc-field-group">
					<label for="mce-FNAME">First Name</label>
					<span><input type="text" name="FNAME" id="mce-FNAME" /></span>
				</div>

				<div class="form-field col-sm-6 mc-field-group">
					<label for="mce-LNAME">Last Name</label>
					<span><input type="text" name="LNAME" id="mce-LNAME" /></span>
				</div>

				<div class="form-field col-sm-12 mc-field-group">
					<label for="mce-EMAIL">Email</label>
					<span><input type="email" name="EMAIL" id="mce-EMAIL" /></span>
				</div>

				<div style="position: absolute; left: -5000px;">
					<input type="text" name="b_bf325e8951cb5986b7c75cb4e_10e27d6fc3" value="">
				</div>
			</fieldset>

			<div class="clear form-click center col-sm-12">
				<input type="submit" value="Join us" name="subscribe" id="mc-embedded-subscribe" class="button">
			</div>

		</form>
	</div>



</section>

<?php if ($data->show == "yes"): ?>

	<section class="gmap" data-latitude="<?php echo $data->latitude; ?>" data-longitude="<?php echo $data->longitude; ?>" data-zoom="<?php echo $data->zoom; ?>" ></section>

<?php endif; ?>