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
			<td><input type="text" id="first_name" name="first_name" value="<?php echo esc_attr( $post->first_name ) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last Name</label></th>
			<td><input type="text" id="last_name" name="last_name" value="<?php echo esc_attr( $post->last_name ) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="biography">Biogrpahy</label></th>
			<td><textarea name="biography" id="biography" cols="30" rows="5" class="regular-text"><?php echo esc_attr( $post->biography ) ?></textarea></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Facebook URL</label></th>
			<td><input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_attr( $post->facebook_url ) ?>" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="linkedin_url">Linkedin URL</label></th>
			<td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr( $post->linkedin_url ) ?>" class="regular-text"></td>
		</tr>
	</tbody>
</table>
