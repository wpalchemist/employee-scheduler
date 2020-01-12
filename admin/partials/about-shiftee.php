<?php

/**
 * About Shiftee Basic
 *
 * Page providing information about Shiftee Basic
 *
 * @link       http://ran.ge
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/admin/partials
 */

?>

<div class="wrap" id="about-shiftee">

	<h1>Shiftee Basic</h1>

	<h2 class="now-shiftee"><?php _e( 'Welcome to Shiftee Basic!', 'employee-scheduler' ); ?></h2>

	<h3><?php _e( 'And welcome to easier shift scheduling.', 'employee-scheduler' ); ?></h3>

	<p><?php printf( __( 'While we have a whole set of <a href="%1$s">support docs for Shiftee Basic</a>, here are few condensed tips to get you up and running quickly. We also have a more detailed <a href="%2$s">instructions page</a> right here in your dashboard.', 'employee-scheduler' ), 'https://shiftee.co/docs/category/shiftee-basic/?utm_source=plugin-about-page', admin_url( 'admin.php?page=instructions' ) ); ?></p>

	<h3><?php _e( 'ADD STAFF', 'employee-scheduler' ); ?></h3>
	<p><?php printf( __( 'Create a WordPress user account for each person that works a shift. When you create these accounts, give each staff member a “Shiftee Employee” <a href="%1$s">user role</a>. <a href="%2$s">Read more about adding staff</a>.', 'employee-scheduler' ), 'https://codex.wordpress.org/Roles_and_Capabilities', 'https://shiftee.co/docs/introduction/?utm_source=plugin-about-page' ); ?></p>

	<h3><?php _e( 'CREATE JOBS (optional)', 'employee-scheduler' ); ?></h3>
	<p><?php printf( __( 'To create different types of job (e.g. manager, barista, line chef) click on the <a href="%1$s">Jobs</a> tab in your admin sidebar. Click the “add new” button to create a new job and give it a description. <a href="%2$s">Read more about creating jobs</a>.', 'employee-scheduler' ), admin_url( 'edit.php?post_type=job' ), 'https://shiftee.co/docs/introduction/?utm_source=plugin-about-page' ); ?></p>

	<h3><?php _e( 'CREATE SHIFTS', 'employee-scheduler' ); ?></h3>
	<p><?php printf( __( 'Click on the new <a href="%1$s">Shifts</a> tab in your WordPress admin sidebar. Click the “add new” button to create a new shift, give that shift a status, and even assign it to a particular staff member or type of job. <a href="%2$s">Read more about creating shifts and the schedule</a>.', 'employee-scheduler' ), admin_url( 'edit.php?post_type=shift' ), 'https://shiftee.co/docs/creating-the-schedule/?utm_source=plugin-about-page' ); ?></p>

	<h3><?php _e( 'DISPLAY EVERYTHING', 'employee-scheduler' ); ?></h3>
	<p><?php printf( __( 'Congrats! Now you’re all set up to display schedules, profile forms, today’s shift and plenty else! To do any of these things you’ll need to create a new page (or pull up an existing one) and make use of our handy <a href="%s">shortcodes</a>.', 'employee-scheduler' ), 'https://shiftee.co/docs/displaying-content-with-shortcodes/?utm_source=plugin-about-page' ); ?></p>

	<p><?php _e( 'And a few other useful docs:', 'employee-scheduler' ); ?>
		<ul>
			<li><a href="https://shiftee.co/docs/clocking-in-out/?utm_source=plugin-about-page"><?php _e( 'Clocking In & Out', 'employee-scheduler' ); ?></a></li>
			<li><a href="https://shiftee.co/docs/shortcodes-display-expense-report-form/?utm_source=plugin-about-page"><?php _e( 'Expenses', 'employee-scheduler' ); ?></a></li>
		</ul>
	</p>

	<p><?php printf( __( 'If you get stuck, run into any bugs, or simply have a question that isn’t answered in <a href="%1$s">our FAQ</a>, you can post a comment in our forums. You’re also welcome to <a href="%2$s">upgrade to Shiftee</a> for email support or purchase <a href="%3$s">Priority support</a> per month or year for advanced support.', 'employee-scheduler' ), 'https://shiftee.co/docs/faq/?utm_source=plugin-about-page', 'https://shiftee.co/downloads/shiftee/?utm_source=plugin-about-page', 'https://shiftee.co/downloads/priority-support/?utm_source=plugin-about-page' ); ?></p>

	<h2><?php _e( 'Shiftee can do more for you!', 'employee-scheduler' ); ?></h2>
	<p><?php _e( 'Shiftee has more features to make it easier to manage your staff!', 'employee-scheduler' ); ?></p>
	<ul>
		<li><?php _e( 'Bulk shift creator/editor', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Automatically check for scheduling conflicts', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Payroll reports', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Filter shifts and expenses', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Compare hours scheduled to hours worked', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Manager user role', 'employee-scheduler' ); ?></li>
		<li><?php _e( 'Personalized priority support.', 'employee-scheduler' ); ?></li>
	</ul>

	<p><a href="https://shiftee.co/downloads/shiftee/?utm_source=plugin-about-page" target="_blank" class="button button-primary">
			<?php _e( 'Upgrade to Shiftee', 'employee-scheduler' ); ?>
		</a>
	</p>

	<p><?php _e( 'Thank you for choosing us and happy scheduling!', 'employee-scheduler' ); ?></p>

	<p><strong><?php _e( 'The Shiftee Team', 'employee-scheduler' ); ?></strong></p>

</div>
