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
			<td><input type="text" id="first_name" name="first_name" value="" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="last_name">Last Name</label></th>
			<td><input type="text" id="last_name" name="last_name" value="" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="biography">Biogrpahy</label></th>
			<td><textarea name="biography" id="biography" cols="30" rows="5" class="regular-text"></textarea></td>
		</tr>
		<tr>
			<th><label for="facebook_url">Facebook URL</label></th>
			<td><input type="url" id="facebook_url" name="facebook_url" value="" class="regular-text"></td>
		</tr>
		<tr>
			<th><label for="linkedin_url">Linkedin URL</label></th>
			<td><input type="url" id="linkedin_url" name="linkedin_url" value="" class="regular-text"></td>
		</tr>
	</tbody>
</table>
