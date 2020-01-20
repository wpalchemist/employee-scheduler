<?php
/**
 * Today
 *
 * Display today's shifts to logged-in employee.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/public/partials
 */

if ( $todayquery->have_posts() ) { ?>
	<p>
		<?php
		// Translators: Number of shifts.
		printf( esc_html__( 'You have %s shift(s) scheduled today.  Which would you like to view?', 'employee-scheduler' ), esc_html( $todayquery->found_posts ) );
		?>
		<ul>
		<?php
		while ( $todayquery->have_posts() ) :
			$todayquery->the_post();
			?>
			<li>
				<a href="<?php the_permalink(); ?>">
					<?php echo esc_html( $this->helper->show_shift_date_and_time( get_the_id() ) ); ?>
					<?php
					if ( $this->helper->get_shift_connection( get_the_id(), 'job' ) ) {
						echo '&ndash;&nbsp;' . esc_html( $this->helper->get_shift_connection( get_the_id(), 'job', 'name' ) );
					}
					?>
				</a>
			</li>
		<?php endwhile; ?>
		</ul>
	</p>
<?php } else { ?>
	<p><?php esc_html_e( 'You do not have any shifts scheduled today.', 'employee-scheduler' ); ?></p>
<?php } ?>
