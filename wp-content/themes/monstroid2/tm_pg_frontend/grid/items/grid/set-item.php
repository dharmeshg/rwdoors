<?php
/**
 * Set item
 *
 * @package templates/frontend/grid/items
 */

$folder = $data->gallery_folder;

?>

<div class="tm_pg_gallery-item col-xs-12 col-lg-<?php echo $data->size . ' ' . apply_filters( 'tm-pg-gallery-item-class', '' ) ?>"
	 data-id="<?php echo $data->ID ?>"  data-type="set">
	<div class="tm_pg_gallery-item-wrapper">
		<a href="<?php do_action( 'tm-pg-the_post_link', $data ) ?>" class="tm_pg_gallery-item_link" data-effect="fadeIn">
			<img src="<?php echo !empty( $data->cover[0] ) ? $data->cover[0] : TM_PG_IMG_URL . 'no-image.png' ?>" alt="">
			<?php if ( $data->display['labels'][$folder] ): ?>
				<div class="tm_pg_gallery-item_label"><?php echo $data->display['album_label'][$folder] ?></div>
			<?php endif; ?>
			<div class="tm_pg_gallery-item_icon-wrapper">
				<?php $show_default_icon = true; ?>
				<?php if ( $data->display['icon'][$folder] ): ?>
					<i class="tm_pg_gallery-item_icon linearicon linearicon-pictures"></i>
					<?php $show_default_icon = false; ?>
				<?php endif; ?>
				<?php if ( $show_default_icon ): ?>
					<i class="tm_pg_gallery-item_default_icon"></i>
				<?php endif; ?>
			</div>
		</a>
		<?php if ( $data->display['title'][$folder] || $data->display['counter'][$folder] || $data->display['description'][$folder] ): ?>
			<div class="tm_pg_gallery-item_meta">
				<?php if ( $data->display['title'][$folder] ): ?>
					<h3 class="tm_pg_gallery-item_title"><?php echo $data->post_title ?></h3>
					<?php $show_default_icon = false; ?>
				<?php endif; ?>
				<?php if ( $data->display['counter'][$folder] ): ?>
					<p class="tm_pg_gallery-item_counter"><?php
							printf(
								esc_html( _nx( '1 photo', '%1$s photos', $data->img_count['images'], 'set images', 'monstroid2' ) ),
								number_format_i18n( $data->img_count['images'] )
							);
							if ( 0 < $data->img_count['albums'] ) {
								?>, <?php
								printf(
									esc_html( _nx( '1 album', '%1$s albums', $data->img_count['albums'], 'set albums', 'monstroid2' ) ),
									number_format_i18n( $data->img_count['albums'] )
								);
							}
					?></p>
					<?php $show_default_icon = false; ?>
				<?php endif; ?>
				<?php if ( $data->display['description'][$folder] ): ?>
					<p class="tm_pg_gallery-item_description"><?php echo wp_trim_words( $data->post_content, intval( $data->display['description_trim'][$folder] ) ); ?></p>
					<?php $show_default_icon = false; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
