<?php

/**
 * Wage Grid Form
 *
 * Form to edit wages.
 *
 * @link       http://ran.ge
 * @since      2.2.2
 *
 * @package    Shiftee
 * @subpackage Shiftee/admin/partials
 */
?>
<table class="shiftee-wage-grid">
	<tbody>
	<?php if ( 'options' == $form ) { ?>
		<tr>
			<th><?php _e( 'Template name', 'employee-scheduler' ); ?></th>
			<td colspan="2">
				<input name="<?php echo $name; ?>[template_name]" type="text" value="<?php echo $grid['template_name']; ?>" required>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<th><?php _e( 'Location', 'employee-scheduler' ); ?></th>
		<th><?php _e( 'Job', 'employee-scheduler' ); ?></th>
		<th><?php _e( 'Wage', 'employee-scheduler' ); ?></th>
	</tr>
	<?php
	foreach ( $grid['regular'] as $location_id => $location ) {
		foreach ( $location['jobs'] as $job_id => $job ) {
			if ( isset( $grid['regular'][ $location_id ]['jobs'][ $job_id ]['wage'] ) ) {
				$value = floatval( $grid['regular'][ $location_id ]['jobs'][ $job_id ]['wage'] );
			} else {
				$value = '';
			}
			?>
		<tr>
			<th scope="row"><?php echo $location['name']; ?></th>
			<td><?php echo $job['name']; ?></td>
			<td><input name="<?php echo $name . '[regular][' . $location_id . '][jobs][' . $job_id . '][wage]'; ?>" value="<?php echo $value; ?>" type="number" min="0" step=".01" <?php echo $disabled; ?>></td>
		</tr>

			<?php
		}
	}
	?>
	<tr>
		<th colspan="2"><?php _e( 'Default Wage', 'employee-scheduler' ); ?></th>
		<?php
		if ( isset( $grid['default'] ) ) {
			$value = $grid['default'];
		} else {
			$value = '';
		}
		?>
		<td><input name="<?php echo $name . '[default]'; ?>" value="<?php echo $value; ?>" type="number" min="0" step=".01" <?php echo $disabled; ?> required>
		</td>
	</tr>
	</tbody>
</table>
