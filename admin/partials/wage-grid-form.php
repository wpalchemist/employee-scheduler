<?php
/**
 * Wage Grid Form
 *
 * Form to edit wages.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.2.2
 *
 * @package    Shiftee
 * @subpackage Shiftee/admin/partials
 */

?>
<table class="shiftee-wage-grid">
	<tbody>
	<?php if ( 'options' === $form ) { ?>
		<tr>
			<th><?php esc_html_e( 'Template name', 'employee-scheduler' ); ?></th>
			<td colspan="2">
				<input name="<?php echo esc_attr( $name ); ?>[template_name]" type="text" value="<?php echo esc_attr( $grid['template_name'] ); ?>" required>
			</td>
		</tr>
	<?php } ?>
	<tr>
		<th><?php esc_html_e( 'Location', 'employee-scheduler' ); ?></th>
		<th><?php esc_html_e( 'Job', 'employee-scheduler' ); ?></th>
		<th><?php esc_html_e( 'Wage', 'employee-scheduler' ); ?></th>
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
			<th scope="row"><?php echo esc_attr( $location['name'] ); ?></th>
			<td><?php echo esc_html( $job['name'] ); ?></td>
			<td><input name="<?php echo esc_attr( $name ) . '[regular][' . esc_attr( $location_id ) . '][jobs][' . esc_attr( $job_id ) . '][wage]'; ?>" value="<?php echo esc_attr( $value ); ?>" type="number" min="0" step=".01" <?php echo esc_attr( $disabled ); ?>></td>
		</tr>

			<?php
		}
	}
	?>
	<tr>
		<th colspan="2"><?php esc_html_e( 'Default Wage', 'employee-scheduler' ); ?></th>
		<?php
		if ( isset( $grid['default'] ) ) {
			$value = $grid['default'];
		} else {
			$value = '';
		}
		?>
		<td><input name="<?php echo esc_attr( $name ) . '[default]'; ?>" value="<?php echo esc_attr( $value ); ?>" type="number" min="0" step=".01" <?php echo esc_attr( $disabled ); ?> required>
		</td>
	</tr>
	</tbody>
</table>
