<?php
/**
 * View Schedules
 *
 * Admin page to view schedules
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/admin/partials
 */

?>

<div class="wrap">

	<h1><?php esc_html_e( 'View Staff Schedules', 'employee-scheduler' ); ?></h1>

	<p><?php esc_html_e( 'You can use this page to view schedules for one or all staff.  To display the schedule on your website, create a page with the <code>[master_schedule]</code> shortcode.', 'employee-scheduler' ); ?></p>

	<form method='post' action='<?php echo esc_url( admin_url( 'edit.php?post_type=shift&page=view-schedules' ) ); ?>' id='view-schedule'>
		<table class="form-table cmb2-element">
			<tr>
				<th scope="row"><?php esc_html_e( 'Staff', 'employee-scheduler' ); ?>:</th>
				<td>
					<select name="employee">
						<?php
						// @todo - if Pro is installed, this needs to get managers - probably ought to have a filter
						echo wp_kses( $this->helper->make_employee_dropdown_options(), $this->helper->dropdown_allowed_html() );
						?>
					</select>
					<p><?php esc_html_e( 'Leave this blank to see the master schedule for all staff.', 'employee-scheduler' ); ?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php esc_html_e( 'Week starting on', 'employee-scheduler' ); ?>:</th>
				<td>
					<input type="text" size="10" name="thisdate" id="thisdate" class="shiftee-date-picker" value="
					<?php
					if ( isset( $_POST['thisdate'] ) ) { // phpcs:ignore
						echo sanitize_text_field( wp_unslash( $_POST['thisdate'] ) );  // phpcs:ignore
					}
					?>
					" />
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php esc_attr_e( 'View Schedule', 'employee-scheduler' ); ?>" />
		</p>
	</form>

	<?php
	if ( $_POST ) { // phpcs:ignore
		$reportstart = sanitize_text_field( $_POST['thisdate'] );  // phpcs:ignore
		$reportend   = gmdate( 'Y-m-d', strtotime( '+6 days', strtotime( $reportstart ) ) );

		if ( !isset( $_POST['employee'] ) || '' === $_POST['employee'] ) { // phpcs:ignore
			echo do_shortcode( '[master_schedule begin="' . $reportstart . '" end="' . $reportend . '"]' );
		} else {
			echo do_shortcode( '[your_schedule begin="' . $reportstart . '" end="' . $reportend . '" employee="' . sanitize_text_field( wp_unslash( $_POST['employee'] ) ) . '"]' ); // phpcs:ignore
		}
	}
	?>

</div>
