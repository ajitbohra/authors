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

?>
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="first_name">First Name</label></th>
			<td><input type="text" id="first_name" name="first_name" value="<?php echo esc_attr($post->first_name) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last Name</label></th>
			<td><input type="text" id="last_name" name="last_name" value="<?php echo esc_attr($post->last_name) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="biography">Biogrpahy</label></th>
			<td><textarea name="biography" id="biography" cols="30" rows="5" class="regular-text"><?php echo esc_attr($post->biography) ?></textarea></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Facebook URL</label></th>
			<td><input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_attr($post->facebook_url) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="linkedin_url">Linkedin URL</label></th>
			<td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr($post->linkedin_url) ?>" class="regular-text"></td>
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
				wp_dropdown_users($user_args);
				?>
			</td>
		</tr>
		<tr>
			<th>Image</th>
			<td>
				<?php
				$image = wp_get_attachment_image_src($post->image_id, 'medium');
				if ($image) :
				?>
					<a href="#" class="author-image button media-button"><img src="<?php echo $image[0]; ?>" /></a>
					<a href="#" class="author-image-remove submitdelete">Remove image</a>
					<input type="hidden" id="image_id" name="image_id" value="<?php echo $post->image_id ?>">
				<?php else : ?>
					<a class="author-image button media-button">Upload</a>
					<a href="#" class="author-image-remove submitdelete" style="display: none">Remove image</a>
					<input type="hidden" id="image_id" name="image_id" value="">
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>
