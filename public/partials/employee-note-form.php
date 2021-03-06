<?php
/**
 * Employee Note Form.
 *
 * Display a note on the single shift view where employees can leave notes.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/public/partials
 */

?>
<form method="post" action="<?php the_permalink(); ?>" id="shiftee-shift-note">
	<input type="hidden" name="shift-id" value="<?php echo esc_attr( get_the_id() ); ?>">
	<label><?php esc_html_e( 'Add a note about this shift, such as corrections to your clock-in and clock-out times.', 'employee-scheduler' ); ?></label>
	<?php if ( isset( $this->options['admin_notify_note'] ) && 1 === $this->options['admin_notify_note'] ) { ?>
		<p><?php esc_html_e( 'The site admin will receive an email with your note', 'employee-scheduler' ); ?></p>
	<?php } ?>
	<textarea name="note"></textarea>
	<?php wp_nonce_field( 'shiftee_employee_note', 'shiftee_employee_note_nonce' ); ?>
	<input type="submit" name="shiftee-employee-shift-note" value="<?php esc_html_e( 'Save Note', 'employee-scheduler' ); ?>">
</form>
