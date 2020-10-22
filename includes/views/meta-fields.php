<?php
/**
 * View for meta fields.
 *
 * @author  Ajit Bohra <ajit@lubus.in>
 * @license MIT
 *
 * @see   https://www.lubus.in/
 *
 * @copyright 2019 LUBUS
 * @package   aba
 */

wp_nonce_field( 'aba_author_title', '_aba_title_nonce' );
wp_nonce_field( 'aba_author_meta', '_aba_meta_nonce' );
?>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="first_name">First Name</label></th>
			<td><input type="text" id="first_name" name="first_name" value="<?php echo esc_attr( $post->first_name ); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last Name</label></th>
			<td><input type="text" id="last_name" name="last_name" value="<?php echo esc_attr( $post->last_name ); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="biography">Biogrpahy</label></th>
			<td><textarea name="biography" id="biography" cols="30" rows="5" class="regular-text"><?php echo esc_attr( $post->biography ); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Facebook URL</label></th>
			<td><input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_attr( $post->facebook_url ); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="linkedin_url">Linkedin URL</label></th>
			<td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr( $post->linkedin_url ); ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="user_id">User</label></th>
			<td>
				<?php
				$user_args = array(
					'id'               => 'user_id',
					'name'             => 'user_id',
					'show_option_all'  => 'select user',
					'selected'         => $post->user_id,
					'include_selected' => true,
				);
				wp_dropdown_users( $user_args );
				?>
			</td>
		</tr>
		<tr id="author-image-container">
			<th>Image</th>
			<td>
				<?php
				$image = wp_get_attachment_image_src( $post->image_id, 'medium' );
				if ( $image ) :
					?>
					<a href="#" class="author-image"><img src="<?php echo esc_attr( $image[0] ); ?>" /></a>
					<a href="#" class="author-image-remove">Remove</a>
					<input type="hidden" id="image_id" name="image_id" value="<?php echo esc_attr( $post->image_id ); ?>">
				<?php else : ?>
					<a class="author-image button media-button">Upload</a>
					<a href="#" class="author-image-remove" style="display: none">Remove</a>
					<input type="hidden" id="image_id" name="image_id" value="">
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>Gallery</th>
			<td id="author-gallery-container">
				<ul class="author-gallery">
					<?php
					$gallery_image_ids = explode( ',', $post->gallery_image_ids );
					$gallery_args      = array(
						'post_type'      => 'attachment',
						'orderby'        => 'post__in',
						'order'          => 'ASC',
						'post__in'       => $gallery_image_ids,
						'numberposts'    => -1,
						'post_mime_type' => 'image',
					);
					$images            = get_posts( $gallery_args );

					if ( $images ) :
						foreach ( $images as $image ) :
							$image_src = wp_get_attachment_image_src( $image->ID, 'thumbnail' );

							?>

							<li>
								<img src="<?php echo esc_attr( $image_src[0] ); ?>" />
								<a href="#" data-id="<?php echo esc_attr( $image->ID ); ?>" class="author-gallery-remove">Remove</a>
							</li>

							<?php
						endforeach;
					endif;
					?>

				</ul>
				<input type="hidden" id="gallery_image_ids" name="gallery_image_ids" value="<?php echo esc_attr( $post->gallery_image_ids ); ?>">
				<a class="author-gallery-add button media-button">Add Images</a>
			</td>
		</tr>
	</tbody>
</table>
