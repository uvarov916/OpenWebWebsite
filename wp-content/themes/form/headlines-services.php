<?php $t =& peTheme(); ?>
<?php $content =& $t->content; ?>
<?php $meta = $t->content->meta(); ?>
<?php 

$homepage = array(
	'services'   => $meta->bg->services,
);

if ( $loop = $t->data->customLoop( (object) array( "post_type"=>"service", "id" => $homepage['services'], "orderby" => "post__in", ) ) ) :

	echo '<ul class="home-menu">';

	while ( $content->looping() ) : $meta = $content->meta(); ?>

		<li>
			<a <?php if ( ! empty( $meta->info->link ) ) echo 'href="' . esc_attr( $meta->info->link ) . '" class="smoothscroll"'; ?>>
				<?php if ( ! empty( $meta->info->icon ) ) echo '<i class="' . esc_attr( $meta->info->icon ) . '"></i>'; ?>
				<b><?php $content->title(); ?></b>
				<?php if ( ! empty( $meta->info->subtitle ) ) echo '<em>' . $meta->info->subtitle . '</em>'; ?>
			</a>
		</li>

	<?php 
	endwhile;

	echo '</ul>';

	$content->resetLoop();

endif;