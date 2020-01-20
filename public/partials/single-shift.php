<?php
/**
 * Single Shift view
 *
 * Display all the information on the single shift view.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/public/partials
 */

$this->maybe_clock_in( get_the_id() );
$this->maybe_clock_out( get_the_id() );

$employee = $this->helper->get_shift_connection( get_the_id(), 'employee', 'name' );
if ( $employee && '' !== $employee ) {
	?>
	<p>
		<strong><?php echo esc_html( apply_filters( 'shiftee_employee_label', __( 'Staff', 'employee-scheduler' ) ) ); ?></strong>:
		<?php echo esc_html( $employee ); ?>
	</p>
<?php } ?>

<?php
$job = $this->helper->get_shift_connection( get_the_id(), 'job', 'ID' );
if ( $job && '' !== $job ) {
	?>
	<p>
		<strong><?php echo esc_html( apply_filters( 'shiftee_job_label', __( 'Job', 'employee-scheduler' ) ) ); ?></strong>:
		<a href="<?php the_permalink( $job ); ?>"><?php echo esc_html( get_the_title( $job ) ); ?></a>
	</p>
<?php } ?>

<p>
	<strong><?php esc_html_e( 'When', 'employee-scheduler' ); ?></strong>:
	<?php echo esc_html( $this->helper->show_shift_date_and_time( get_the_id(), 'scheduled' ) ); ?>
</p>

<?php if ( '' !== get_post_meta( get_the_id(), '_shiftee_clock_in', true ) && '' !== get_post_meta( get_the_id(), '_shiftee_clock_out', true ) ) { ?>
	<p>
		<strong><?php esc_html_e( 'Hours Worked', 'employee-scheduler' ); ?></strong>:
		<?php echo esc_html( $this->helper->show_shift_date_and_time( get_the_id(), 'worked' ) ); ?>
	</p>
<?php } ?>

<?php
if ( '1' === $this->options['track_breaks'] ) {
	$breaks = get_post_meta( get_the_id(), '_shiftee_breaks', true );
	if ( isset( $breaks ) && is_array( $breaks ) && ! empty( $breaks ) ) {
		?>
		<p>
			<strong><?php esc_html_e( 'Breaks', 'employee-scheduler' ); ?></strong>:
			<?php
			foreach ( $breaks as $break ) {
				if ( isset( $break['break_start'] ) && isset( $break['break_end'] ) ) {
					echo esc_html( $this->helper->display_datetime( $break['break_start'], 'time' ) ) . '&nbsp;&ndash;&nbsp;' . esc_html( $this->helper->display_datetime( $break['break_end'], 'time' ) ) , ',&nbsp;';
				}
			}
			?>
		</p>

		<?php
	}
}

echo wp_kses_post( $this->helper->display_shift_terms( 'location' ) );
echo wp_kses_post( $this->helper->display_shift_terms( 'shift_type' ) );
echo wp_kses_post( $this->helper->display_shift_terms( 'shift_status' ) );
$this->display_shift_notes();
$this->display_shift_note_form();
