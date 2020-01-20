<?php
/**
 * Employee profile fields
 *
 * Extra fields displayed in the employee profile for contact information.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/admin/partials
 */

?>
<h3><?php esc_html_e( 'Contact Information', 'employee-scheduler' ); ?></h3>

<table class="form-table">
	<tr>
		<th><label for="address"><?php esc_html_e( 'Street Address', 'employee-scheduler' ); ?></label></th>
		<td>
			<input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>
	<tr>
		<th><label for="city"><?php esc_html_e( 'City', 'employee-scheduler' ); ?></label></th>
		<td>
			<input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>
	<tr>
		<th><label for="state"><?php esc_html_e( 'State/Province', 'employee-scheduler' ); ?></label></th>
		<td>
			<input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>
	<tr>
		<th><label for="zip"><?php esc_html_e( 'Zip/Postal Code', 'employee-scheduler' ); ?></label></th>
		<td>
			<input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>
	<tr>
		<th><label for="phone"><?php esc_html_e( 'Phone Number', 'employee-scheduler' ); ?></label></th>
		<td>
			<input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
		</td>
	</tr>

</table>
