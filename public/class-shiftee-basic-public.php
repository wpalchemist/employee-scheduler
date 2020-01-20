<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/public
 */

if ( ! class_exists( 'Shiftee_Basic_Public' ) ) {
	/**
	 * The public-facing functionality of the plugin.
	 *
	 * @package    Shiftee Basic
	 * @subpackage Shiftee Basic/public
	 * @author     Range <support@shiftee.co>
	 */
	class Shiftee_Basic_Public {

		/**
		 * The ID of this plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;

		/**
		 * The plugin settings.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string    options    The settings for this plugin.
		 */
		private $options;

		/**
		 * The plugin helper.
		 *
		 * @since    2.0.0
		 * @access   private
		 * @var      string    options    The settings for this plugin.
		 */
		private $helper;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    2.0.0
		 *
		 * @param      string $plugin_name The name of the plugin.
		 * @param      string $version The version of this plugin.
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;

			$helper        = new Shiftee_Helper();
			$this->helper  = $helper;
			$this->options = $helper->shiftee_options();

		}

		/**
		 * Register the stylesheets for the public-facing side of the site.
		 *
		 * @since    2.0.0
		 */
		public function enqueue_styles() {

			wp_register_style( $this->plugin_name, SHIFTEE_BASIC_DIR_URL . 'public/css/shiftee-public.css', array(), $this->version, 'all' );

			if ( is_singular( 'shift' ) ) {
				wp_enqueue_style( $this->plugin_name );
			}

			wp_register_style( 'fullcalendar', SHIFTEE_BASIC_DIR_URL . 'libraries/fullcalendar/fullcalendar.css', array(), $this->version, 'all' );

		}

		/**
		 * Register the JavaScript for the public-facing side of the site.
		 *
		 * @since    2.0.0
		 */
		public function enqueue_scripts() {

			wp_register_script(
				'timepicker-addon',
				SHIFTEE_BASIC_DIR_URL . 'libraries/cmb2/js/jquery-ui-timepicker-addon.min.js',
				array(
					'jquery',
					'jquery-ui-datepicker',
				),
				$this->version,
				true
			);

			wp_register_script(
				$this->plugin_name,
				SHIFTEE_BASIC_DIR_URL . 'public/js/shiftee-public.js',
				array(
					'jquery',
					'jquery-ui-datepicker',
					'timepicker-addon',
				),
				$this->version,
				true
			);

			if ( isset( $this->options['geolocation'] ) && 1 === $this->options['geolocation'] && is_singular( 'shift' ) ) {
				wp_enqueue_script( 'geolocation', SHIFTEE_BASIC_DIR_URL . 'public/js/geolocation.js', '', $this->version, true );
			}

			wp_register_script( 'moment', SHIFTEE_BASIC_DIR_URL . 'libraries/fullcalendar/lib/moment.min.js', array( 'jquery' ), $this->version, false );
			wp_register_script(
				'fullcalendar',
				SHIFTEE_BASIC_DIR_URL . 'libraries/fullcalendar/fullcalendar.js',
				array(
					'jquery',
					'moment',
				),
				$this->version,
				false
			);
			wp_register_script(
				$this->plugin_name . '_no_datepicker',
				SHIFTEE_BASIC_DIR_URL . 'public/js/shiftee-public.js',
				array(
					'jquery',
					'moment',
					'fullcalendar',
				),
				$this->version,
				true
			);
			wp_localize_script( $this->plugin_name . '_no_datepicker', 'shiftee_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		}

		/**
		 * Register shortcodes.
		 *
		 * @since 2.0.0
		 */
		public function register_shortcodes() {
			add_shortcode( 'master_schedule', array( $this, 'master_schedule_shortcode' ) );
			add_shortcode( 'your_schedule', array( $this, 'your_schedule_shortcode' ) );
			add_shortcode( 'employee_profile', array( $this, 'employee_profile_shortcode' ) );
			add_shortcode( 'today', array( $this, 'today_shortcode' ) );
			add_shortcode( 'extra_work', array( $this, 'extra_work_shortcode' ) );
			add_shortcode( 'record_expense', array( $this, 'record_expense_shortcode' ) );
		}

		/**
		 * Display a login form
		 *
		 * @since 2.0.0
		 *
		 * @param bool $echo  Whether to echo or return the result.
		 *
		 * @return string
		 */
		public function show_login_form( $echo = false ) {

			$login_form  = '<p>' . esc_html__( 'You must be logged in to view this page.', 'employee-scheduler' ) . '</p>';
			$args        = array(
				'echo' => false,
			);
			$login_form .= wp_login_form( $args );

			if ( $echo ) {
				$allowed_html = array(
					'form'  => array(
						'id'     => array(),
						'name'   => array(),
						'action' => array(),
						'method' => array(),
					),
					'p'     => array(
						'class' => array(),
					),
					'label' => array(
						'for' => array(),
					),
					'input' => array(
						'id'    => array(),
						'class' => array(),
						'type'  => array(),
						'name'  => array(),
						'value' => array(),
						'size'  => array(),
					),
				);
				echo wp_kses( $allowed_html, $login_form );
			} else {
				return $login_form;
			}

		}

		/**
		 * Single Shift Title.
		 *
		 * Change the title on the single shift view to "Shift Details."
		 *
		 * @since 1.0
		 *
		 * @param string $title The post title.
		 *
		 * @return string $title The filtered post title
		 */
		public function single_shift_title( $title ) {
			global $post;
			if ( is_singular( 'shift' ) && $title === $post->post_title && is_main_query() ) {
				$title = __( 'Shift Details', 'employee-scheduler' );
			}

			return $title;
		}

		/**
		 * Filter the single shift view
		 *
		 * @since 1.0
		 *
		 * @param string $content The shift content.
		 *
		 * @return string
		 */
		public function single_shift_view( $content ) {

			if ( is_singular( 'shift' ) && is_main_query() ) {

				if ( ! $this->helper->user_is_allowed() ) {
					return $this->show_login_form();
				}

				// phpcs:ignore
				if ( ! empty( $_POST ) ) { // we'll check for the nonce in process_single_shift_forms().
					$this->process_single_shift_forms();
				}

				ob_start();
				include 'partials/single-shift.php';
				$shift_content = ob_get_clean();

				$content .= apply_filters( 'shiftee_single_shift', $shift_content, 10, get_the_id() );

			}

			return $content;

		}

		/**
		 * On the single shift view, process forms if needed
		 *
		 * @since 2.0.0
		 */
		public function process_single_shift_forms() {

			// if employee left a note.
			// phpcs:ignore
			if ( isset( $_POST['shiftee-employee-shift-note'] ) && 'Save Note' === ( $_POST['shiftee-employee-shift-note'] ) ) { // We'll verify the nonce in save_employee_note()
				$confirmation = $this->save_employee_note();
				if ( ! empty( $confirmation ) ) {
					echo '<p class="' . esc_attr( $confirmation['status'] ) . '">' . esc_html( $confirmation['message'] ) . '</p>';
				}
			}

			// If employee just pushed the clock in button.
			// phpcs:ignore
			if ( isset( $_POST['shiftee-clock-in-form'] ) && 'Clock In' === ( $_POST['shiftee-clock-in-form'] ) ) { // we're just checking if this exists - we'll sanitize it before using it.
				$this->clock_in();
			}

			// If employee just pushed the clock out button.
			// phpcs:ignore
			if ( isset( $_POST['shiftee-clock-out-form'] ) && 'Clock Out' === ( $_POST['shiftee-clock-out-form'] ) ) { // we're just checking if this exists - we'll sanitize it before using it.
				$this->clock_out();
			}

		}

		/**
		 * Display the clock-in form if needed.
		 *
		 * If the shift date is today, and if the current user is assigned to the shift and has not clocked in, show the clock in form
		 *
		 * @param int $shift ID of the shift we're updating.
		 */
		public function maybe_clock_in( $shift ) {

			$assigned_employee = $this->helper->get_shift_connection( $shift, 'employee' );
			$current_user      = wp_get_current_user();

			$start_date = get_post_meta( $shift, '_shiftee_shift_start', true );
			$end_date   = get_post_meta( $shift, '_shiftee_shift_end', true );

			if ( $assigned_employee === $current_user->ID // employee assigned to the shift is viewing the shift.
				&& ( current_time( 'Ymd' ) === gmdate( 'Ymd', $start_date ) || current_time( 'Ymd' ) === gmdate( 'Ymd', $end_date ) ) // shift is scheduled for today.
				&& '' === get_post_meta( $shift, '_shiftee_clock_in', true ) // employee has not clocked in already.
			) {
				include 'partials/clock-in.php';
			}
		}

		/**
		 * Clock in.
		 *
		 * When employee clicks the "clock in" link, save the time and, if relevant, the location
		 *
		 * @since 2.0.0
		 */
		private function clock_in() {
			if ( ! isset( $_POST['shiftee_clock_in_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_clock_in_nonce'] ) ), 'shiftee_clock_in' ) ) {
				exit( 'Permission error.' );
			}

			if ( ! isset( $_POST['shift-id'] ) ) {
				$error = __( 'Could not find your shift.  Please go back and try again.', 'employee-scheduler' );
				wp_die( esc_html( $error ) );
			}
			$shift = get_post( intval( $_POST['shift-id'] ) );
			if ( ! isset( $shift->post_type ) || 'shift' !== $shift->post_type ) {
				$error = __( 'Could not clock in.  Please go back and try again.', 'employee-scheduler' );
				wp_die( esc_html( $error ) );
			}

			// save clock in time.
			update_post_meta( $shift->ID, '_shiftee_clock_in', current_time( 'timestamp' ) ); // phpcs:ignore

			$testing_meta = get_post_meta( $shift->ID, '_shiftee_clock_in', true );
			if ( ! isset( $testing_meta ) || '' === $testing_meta ) {
				wp_die( esc_html__( 'Something has gone wrong.  Please use the back button to try to clock in again.  If you continue to receive this error, contact the site administrator.', 'employee-scheduler' ) );
			}

			// save address.
			if ( isset( $_POST['latitude'] ) && isset( $_POST['longitude'] ) ) {

				$address = $this->get_address( sanitize_text_field( wp_unslash( $_POST['latitude'] ) ), sanitize_text_field( wp_unslash( $_POST['longitude'] ) ) );
				update_post_meta( $shift->ID, '_shiftee_location_clock_in', sanitize_text_field( $address ) );

			}

			do_action( 'shiftee_clock_in_action', $shift );

			unset( $_POST );
		}

		/**
		 * Given latitude and longitude, get a street address
		 *
		 * @param string $lat Latitude.
		 * @param string $long Longitude.
		 *
		 * @since 2.0.0
		 *
		 * @return string|void
		 */
		private function get_address( $lat, $long ) {

			$response = wp_remote_get( 'http://maps.google.com/maps/api/geocode/json?latlng=' . $lat . ',' . $long );

			if ( is_wp_error( $response ) ) {
				$error = __( 'Unable to retrieve location data', 'employee-scheduler' );

				return $error;
			} else {
				$body = wp_remote_retrieve_body( $response );
				$json = json_decode( $body );
				if ( isset( $json->status ) && 'OK' === $json->status ) {
					$address = $json->results[0]->formatted_address;

					return $address;
				} else {
					$error = __( 'Unable to retrieve location data', 'employee-scheduler' );

					return $error;
				}
			}

		}

		/**
		 * Show the clock out form if needed.
		 *
		 * If the shift date is today, and the current user is assigned to the shift and has already clocked in, show the clock out button.
		 *
		 * @param int $shift The shift we're updating.
		 */
		public function maybe_clock_out( $shift ) {

			$assigned_employee = $this->helper->get_shift_connection( $shift, 'employee' );
			$current_user      = wp_get_current_user();

			$start_date = get_post_meta( $shift, '_shiftee_shift_start', true );
			$end_date   = get_post_meta( $shift, '_shiftee_shift_end', true );

			if ( $assigned_employee === $current_user->ID // employee assigned to the shift is viewing the shift.
				&& ( current_time( 'Ymd' ) === gmdate( 'Ymd', $start_date ) || current_time( 'Ymd' ) === gmdate( 'Ymd', $end_date ) ) // shift is scheduled for today.
				&& '' !== get_post_meta( $shift, '_shiftee_clock_in', true ) // employee clocked in already.
				&& '' === get_post_meta( $shift, '_shiftee_clock_out', true ) // employee has not clocked out.
			) {
				include 'partials/clock-out.php';
			}

		}

		/**
		 * Clock out.
		 *
		 * When employee clicks the "clock out" link, save the time and, if relevant, the location
		 *
		 * @since 2.0.0
		 */
		private function clock_out() {
			if ( ! isset( $_POST['shiftee_clock_out_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_clock_out_nonce'] ) ), 'shiftee_clock_out' ) ) {
				exit( 'Permission error.' );
			}

			if ( ! isset( $_POST['shift-id'] ) ) {
				$error = __( 'No shift found.  Please go back and try again.', 'employee-scheduler' );
				wp_die( esc_html( $error ) );
			}

			$shift = get_post( intval( $_POST['shift-id'] ) );
			if ( ! isset( $shift->post_type ) || 'shift' !== $shift->post_type ) {
				$error = __( 'Could not clock out.  Please go back and try again.', 'employee-scheduler' );
				wp_die( esc_html( $error ) );
			}

			// save clock out time.
			update_post_meta( $shift->ID, '_shiftee_clock_out', current_time( 'timestamp' ) ); // phpcs:ignore

			$testing_meta = get_post_meta( $shift->ID, '_shiftee_clock_out', true );
			if ( ! isset( $testing_meta ) || '' === $testing_meta ) {
				wp_die( esc_html__( 'Something has gone wrong.  Please use the back button to try to clock out again.  If you continue to receive this error, contact the site administrator.', 'employee-scheduler' ) );
			}

			// save worked duration.
			$duration = $this->helper->get_shift_duration( $shift->ID, 'worked', 'hours' );
			update_post_meta( $shift->ID, '_shiftee_worked_duration', $duration );

			// save address.
			if ( isset( $_POST['latitude'] ) && isset( $_POST['longitude'] ) ) {

				$address = $this->get_address( sanitize_text_field( wp_unslash( $_POST['latitude'] ) ), sanitize_text_field( wp_unslash( $_POST['longitude'] ) ) );
				update_post_meta( $shift->ID, '_shiftee_location_clock_out', sanitize_text_field( $address ) );

			}

			// change shift status to "worked".
			wp_set_object_terms( $shift->ID, 'worked', 'shift_status' );

			do_action( 'shiftee_clock_out_action', $shift );

			unset( $_POST );
		}

		/**
		 * Display the shift's notes
		 *
		 * @return string
		 */
		public function display_shift_notes() {

			// don't show this to On Demand customers.
			$current_user = wp_get_current_user();
			$roles        = $current_user->roles;
			if ( is_array( $roles ) && ! empty( $roles ) ) {
				if ( in_array( 'shiftee_customer', $roles, true ) ) {
					return;
				}
			}

			$notes = get_post_meta( get_the_id(), '_shiftee_shift_notes', true );
			if ( isset( $notes ) && is_array( $notes ) ) {
				?>
				<p>
					<strong><?php esc_html_e( 'Notes', 'employee-scheduler' ); ?></strong>
					<ul>
					<?php
					foreach ( $notes as $note ) {
						if ( isset( $note['notedate'] ) && isset( $note['notetext'] ) ) {
							?>
							<li><strong><?php echo esc_html( $this->helper->display_datetime( $note['notedate'], 'date' ) ); ?>:</strong>&nbsp;<?php echo esc_html( $note['notetext'] ); ?></li>
							<?php
						}
					}
					?>
					</ul>
				</p>
				<?php
			}

		}

		/**
		 * Display employee note form on single shift.
		 *
		 * If the employee who is viewing the site is assigned to the shift, show them the note form.
		 *
		 * @since 2.0.0
		 */
		public function display_shift_note_form() {

			$assigned_employee = $this->helper->get_shift_connection( get_the_id(), 'employee' );

			$current_user = wp_get_current_user();

			if ( $assigned_employee === $current_user->ID ) {
				include 'partials/employee-note-form.php';
			}
		}

		/**
		 * Save employee note.
		 *
		 * If employee filled out the "leave shift note" form, save the data.
		 *
		 * @since 1.0
		 *
		 * @return array confirmation message
		 */
		public function save_employee_note() {

			if ( ! isset( $_POST['shiftee_employee_note_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_employee_note_nonce'] ) ), 'shiftee_employee_note' ) ) {
				exit( 'Permission error.' );
			}

			if ( ! isset( $_POST['note'] ) || '' === $_POST['note'] ) {
				wp_die( esc_html__( 'Your note is empty!  Please go back and enter a note.', 'employee-scheduler' ) );
			}

			// Make sure we actually have a shift.
			if ( isset( $_POST['shift-id'] ) ) {
				$shift = get_post( intval( $_POST['shift-id'] ) );
			} else {
				$error = array(
					'status'  => 'shiftee-failure',
					'message' => esc_html__( 'We couldn\'t find the shift to associate with this note.  Please contact the site administrator.', 'employee-scheduler' ),
				);

				unset( $_POST );

				return $error;
			}
			if ( ! isset( $shift->post_type ) || 'shift' !== $shift->post_type ) {
				$error = array(
					'status'  => 'shiftee-failure',
					'message' => esc_html__( 'There was an error saving your note.  Please contact the site administrator.', 'employee-scheduler' ),
				);

				unset( $_POST );

				return $error;
			}

			$old_notes = get_post_meta( $shift->ID, '_shiftee_shift_notes', true );

			if ( ! isset( $old_notes ) || ! is_array( $old_notes ) ) {
				$old_notes = array();
			}

			$new_note = array(
				'notedate' => time(),
				'notetext' => sanitize_text_field( wp_unslash( $_POST['note'] ) ),
			);

			array_push( $old_notes, $new_note );

			delete_post_meta( $shift->ID, '_shiftee_shift_notes' );
			$saved_note = add_post_meta( $shift->ID, '_shiftee_shift_notes', $old_notes );

			if ( ! $saved_note ) {
				$error = array(
					'status'  => 'shiftee-failure',
					'message' => __( 'There was an error saving your note.  Please contact the site administrator.', 'employee-scheduler' ),
				);

				unset( $_POST );

				return $error;
			}

			do_action( 'shiftee_save_employee_note_action', $shift, sanitize_text_field( wp_unslash( $_POST['note'] ) ) );

			$confirmation = array(
				'status'  => 'shiftee-success',
				'message' => __( 'Your note has been saved.', 'employee-scheduler' ),
			);

			unset( $_POST );

			return $confirmation;
		}

		/**
		 * Master Schedule Shortcode.
		 *
		 * [master_schedule] displays a weekly work schedule with all employees' shifts.
		 *
		 * @since 1.0
		 *
		 * @param array $atts {
		 *      type
		 *      status
		 *      location
		 *      public
		 *      manager
		 * }.
		 *
		 * @return string  HTML for master schedule.
		 */
		public function master_schedule_shortcode( $atts ) {

			$args = shortcode_atts(
				array(
					'type'     => '',
					'status'   => '',
					'location' => '',
					'job'      => '',
					'public'   => 'false',
					'manager'  => '',
					'employee' => '',
				),
				$atts
			);

			$calendar_options = $this->get_calendar_options();

			wp_enqueue_script( 'moment' );
			wp_enqueue_script( 'fullcalendar' );
			wp_enqueue_script( $this->plugin_name . '_no_datepicker' );
			wp_enqueue_style( $this->plugin_name );
			wp_enqueue_style( 'fullcalendar' );
			wp_localize_script( $this->plugin_name . '_no_datepicker', 'calendar_options', $calendar_options );

			if ( ! $this->helper->user_is_allowed() && 'false' === $public ) {
				return $this->show_login_form();
			}

			$data = 'data-type="' . $args['type'] . '"
					data-status="' . $args['status'] . '"
					data-location="' . $args['location'] . '"
					data-job="' . $args['job'] . '"
					data-employee="' . $args['employee'] . '"
					data-manager="' . $args['manager'] . '"
					data-nonce="' . wp_create_nonce( 'shiftee_calendar_nonce' ) . '"';

			return $this->display_calendar( $data );

		}

		/**
		 * Get the calendar options to localize the calendar script
		 *
		 * @since 2.2.0
		 *
		 * @return mixed|void
		 */
		public function get_calendar_options() {
			$calendar_options = apply_filters(
				'shiftee_calendar_options',
				array(
					'first_day'   => $this->helper->numerical_first_day_of_week(),
					'right'       => '',
					'time_format' => $this->helper->convert_php_datetime_to_js_datetime( $this->options['time_format'], 'moment' ),
					'unassigned'  => '',
				)
			);

			return $calendar_options;
		}

		/**
		 * Generate the HTML to display the calendar
		 *
		 * @since 2.2.0
		 *
		 * @param string $data The parameters of what to display in the calendar, sent through AJAX.
		 *
		 * @return string
		 */
		public function display_calendar( $data ) {

			$error    = __( 'No shifts found', 'employee-scheduler' );
			$calendar = '<div id="shiftee-calendar" ' . $data . '>
							<div id="shiftee-calendar-loader" style="display:none;">
								<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 50 50"><path d="M43.935 25.145c0-10.318-8.364-18.683-18.683-18.683-10.318 0-18.683 8.365-18.683 18.683h4.068c0-8.071 6.543-14.615 14.615-14.615s14.615 6.543 14.615 14.615h4.068z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></path></svg>
							</div>
							<div id="shiftee-calendar-error" class="shiftee-failure" style="display:none;">' . $error . '</div>
						</div>';

			return apply_filters( 'shiftee_calendar_container', $calendar );

		}

		/**
		 * Get a list of events to display in the calendar
		 *
		 * @since 2.2.0
		 */
		public function get_calendar_events() {
			$events = array();

			$args = $this->make_query_args();

			$the_query = new WP_Query( $args );

			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$title       = $this->get_shift_title( get_the_id() );
					$startstring = gmdate( 'c', intval( get_post_meta( get_the_id(), '_shiftee_shift_start', true ) ) );
					$endstring   = gmdate( 'c', intval( get_post_meta( get_the_id(), '_shiftee_shift_end', true ) ) );

					$event_info = array(
						'title'  => $title,
						'start'  => $startstring,
						'end'    => $endstring,
						'allDay' => false,
						'url'    => get_the_permalink(),
						'id'     => get_the_id(),
					);

					$staff = $this->get_shift_staff_avatar( get_the_id() );
					if ( '' !== $staff ) {
						$event_info['staff'] = $staff;
					}

					$location = $this->get_shift_location( get_the_id() );
					if ( '' !== $location ) {
						$event_info['location'] = $location;
					}

					$events[] = $event_info;
				endwhile;
			endif;

			wp_reset_postdata();

			wp_send_json( $events );
			die;
		}

		/**
		 * Get the shift title to display in the calendar
		 *
		 * @since 2.2.0
		 *
		 * @param int $id  ID of the shift.
		 *
		 * @return string
		 */
		public function get_shift_title( $id ) {
			$job = $this->helper->get_shift_connection( $id, 'job', 'name' );
			if ( '' === $job ) {
				$job = get_the_title( $id );
			}

			return esc_html( $job );
		}

		/**
		 * Get the shift location to display in the calendar
		 *
		 * @since 2.2.0
		 *
		 * @param int $id ID of the location.
		 *
		 * @return string
		 */
		public function get_shift_location( $id ) {
			$locations = get_the_terms( $id, 'location' );
			$location  = '';
			if ( is_array( $locations ) ) {
				foreach ( $locations as $this_location ) {
					$location = esc_html( $this_location->name );
				}
			}

			return $location;
		}

		/**
		 * Get the staff avatar to display in the calendar
		 *
		 * @since 2.2.0
		 *
		 * @param int $id ID of employee.
		 *
		 * @return string
		 */
		public function get_shift_staff_avatar( $id ) {
			$staff = $this->helper->get_shift_connection( $id, 'employee', 'ID' );

			if ( ! $staff ) {
				return '';
			}

			$name = $this->helper->get_shift_connection( $id, 'employee', 'name' );

			$html = '<span class="shiftee-staff">' . $name . '</span>';
			return $html;

		}

		/**
		 * Generate the query args to find all the shifts for the master schedule and your schedule shortcodes.
		 *
		 * @param string $employee Employee whose shifts to show.
		 *
		 * @return array
		 */
		private function make_query_args( $employee = '' ) {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'shiftee_calendar_nonce' ) ) {
				$args = array();
				return $args;
			}

			$start = strtotime( $_POST['start'] ); // phpcs:ignore
			$end   = strtotime( $_POST['end'] ) + 86399; //phpcs:ignore

			$args = array(
				'post_type'      => 'shift',
				'posts_per_page' => -1,
				'meta_query'     => array( // phpcs:ignore
					'key'     => '_shiftee_shift_start',
					'value'   => array( $start, $end ),
					'type'    => 'numeric',
					'compare' => 'BETWEEN',
				),
			);

			if ( ( isset( $_POST['shift_type'] ) && '' !== $_POST['shift_type'] ) ||
				( isset( $_POST['status'] ) && '' !== $_POST['status'] ) ||
				( isset( $_POST['location'] ) && '' !== $_POST['location'] )
			) {

				// phpcs:ignore
				$args['tax_query'] = array( // Sorry, phpcs, but we need a tax_query here.
					'relation' => 'AND',
				);
				if ( isset( $_POST['shift_type'] ) && '' !== $_POST['shift_type'] ) {
					$args['tax_query'][] =
						array(
							'taxonomy' => 'shift_type',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( wp_unslash( $_POST['shift_type'] ) ),
						);
				}
				if ( isset( $_POST['status'] ) && '' !== $_POST['status'] ) {
					$args['tax_query'][] =
						array(
							'taxonomy' => 'shift_status',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( wp_unslash( $_POST['status'] ) ),
						);
				}
				if ( isset( $_POST['location'] ) && '' !== $_POST['location'] ) {
					$args['tax_query'][] =
						array(
							'taxonomy' => 'location',
							'field'    => 'slug',
							'terms'    => sanitize_text_field( wp_unslash( $_POST['location'] ) ),
						);
				}
			}

			if ( isset( $_POST['job'] ) && '' !== $_POST['job'] ) {
				$job                     = get_page_by_path( sanitize_text_field( wp_unslash( $_POST['job'] ) ), '', 'job' );
				$args['connected_type']  = 'shifts_to_jobs';
				$args['connected_items'] = $job->ID;
			}

			if ( isset( $_POST['manager'] ) && '' !== $_POST['manager'] ) {
				// get manager's employees.
				$manager_obj = get_user_by( 'login', intval( $_POST['manager'] ) );
				if ( $manager_obj ) {
					$managers_employees = new WP_User_Query(
						array(
							'connected_type'      => 'manager_to_employee',
							'connected_items'     => $manager_obj->ID,
							'connected_direction' => 'to',
						)
					);

					if ( ! empty( $managers_employees->results ) ) {
						$employee_ids = array();
						foreach ( $managers_employees->results as $employee ) {
							$employee_ids[] = $employee->ID;
						}
						if ( ! empty( $employee_ids ) ) {
							$args['connected_type']  = 'shifts_to_employees';
							$args['connected_items'] = $employee_ids;
						}
					}
				}
			}

			if ( isset( $_POST['employee'] ) && '' !== $_POST['employee'] ) {
				$args['connected_type']  = 'shifts_to_employees';
				$args['connected_items'] = intval( $_POST['employee'] );
			}

			return $args;

		}


		/**
		 * Your Schedule Shortcode.
		 *
		 * [your_schedule] displays a weekly work schedule for the currently logged-in user.
		 *
		 * @since 1.0
		 *
		 * @param array $atts Shortcode attributes: begin date, end date, employee ID.
		 *
		 * @return string  HTML for your schedule.
		 */
		public function your_schedule_shortcode( $atts ) {

			$args = shortcode_atts(
				array(
					'employee' => '',
					'type'     => '',
					'status'   => '',
					'location' => '',
				),
				$atts
			);

			$calendar_options = $this->get_calendar_options();

			wp_enqueue_script( 'moment' );
			wp_enqueue_script( 'fullcalendar' );
			wp_enqueue_script( $this->plugin_name . '_no_datepicker' );
			wp_enqueue_style( $this->plugin_name );
			wp_enqueue_style( 'fullcalendar' );
			wp_localize_script( $this->plugin_name . '_no_datepicker', 'calendar_options', $calendar_options );

			if ( ! $this->helper->user_is_allowed() ) {
				return $this->show_login_form();
			}

			if ( '' === $args['employee'] ) {
				$args['employee'] = get_current_user_id();
			}

			$data = 'data-type="' . $args['type'] . '"
					data-status="' . $args['status'] . '"
					data-location="' . $args['location'] . '"
					data-employee="' . $args['employee'] . '"';

			return $this->display_calendar( $data );

		}

		/**
		 * Output buffer.
		 *
		 * Add output buffer so that when an employee saves their profile, we can redirect to show them their updated profile.
		 *
		 * @since 1.3
		 */
		public function output_buffer() {
			// @todo - there has got to be a better way to do this.
			ob_start();
		}

		/**
		 * Employee Profile Shortcode.
		 *
		 * [employee_profile] lets employees edit some of their profile information.
		 *
		 * @see http://wordpress.stackexchange.com/questions/9775/how-to-edit-a-user-profile-on-the-front-end
		 *
		 * @since 1.0
		 * @return string HTML to display profile form.
		 */
		public function employee_profile_shortcode() {

			wp_enqueue_style( $this->plugin_name );
			wp_enqueue_script( $this->plugin_name );
			$datetimepicker_options = $this->helper->get_datetimepicker_options();
			wp_localize_script( $this->plugin_name, 'datetimepicker_options', $datetimepicker_options );

			if ( ! $this->helper->user_is_allowed() ) {
				return $this->show_login_form();
			}

			global $current_user;

			$error = array();
			// If profile was saved, update profile.
			// phpcs:ignore
			if ( ! empty( $_POST['action'] ) && 'update-user' === $_POST['action'] ) { // We aren't processing the form yet - we'll verify the nonce in save_user_profile().

				$this->save_user_profile();

				// Redirect so the page will show updated info.
				if ( count( $error ) === 0 ) {
					// action hook for plugins and extra fields saving.
					do_action( 'edit_user_profile_update', $current_user->ID );
					wp_safe_redirect( get_permalink() );
					exit;
				}
			}

			ob_start();
			include 'partials/shortcode-employee-profile.php';

			return ob_get_clean();
		}

		/**
		 * When an employee edits their profile, save the information
		 *
		 * @since 2.0.0
		 */
		private function save_user_profile() {
			if ( ! isset( $_POST['shiftee_update_user_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_update_user_nonce'] ) ), 'shiftee_update_user' ) ) {
				wp_die( esc_html__( 'Permission error.  Please go back and try again.', 'employee-scheduler' ) );
			}

			global $current_user;

			/* Update user password. */
			if ( ! empty( $_POST['pass1'] ) && ! empty( $_POST['pass2'] ) ) {
				if ( $_POST['pass1'] === $_POST['pass2'] ) {
					wp_update_user(
						array(
							'ID'        => $current_user->ID,
							// phpcs:ignore
							'user_pass' => $_POST['pass1'], // Sanitizing a password will just confuse things.
						)
					);
				} else {
					$error[] = __( 'The passwords you entered do not match.  Your password was not updated.', 'profile' );
				}
			}

			/* Update user information. */
			if ( ! empty( $_POST['url'] ) ) {
				update_user_meta( $current_user->ID, 'user_url', esc_url_raw( wp_unslash( $_POST['url'] ) ) );
			}
			if ( ! empty( $_POST['email'] ) ) {
				$usable_email = sanitize_email( wp_unslash( $_POST['email'] ) );
				if ( ! is_email( $usable_email ) ) {
					$error[] = __( 'The Email you entered is not valid.  please try again.', 'profile' );
				} elseif ( email_exists( $usable_email ) !== $current_user->id ) {
					$error[] = __( 'This email is already used by another user.  try a different one.', 'profile' );
				} else {
					wp_update_user(
						array(
							'ID'         => $current_user->ID,
							'user_email' => sanitize_text_field( wp_unslash( $_POST['email'] ) ),
						)
					);
				}
			}

			if ( ! empty( $_POST['first-name'] ) ) {
				update_user_meta( $current_user->ID, 'first_name', sanitize_text_field( wp_unslash( $_POST['first-name'] ) ) );
			}
			if ( ! empty( $_POST['last-name'] ) ) {
				update_user_meta( $current_user->ID, 'last_name', sanitize_text_field( wp_unslash( $_POST['last-name'] ) ) );
			}
			if ( ! empty( $_POST['description'] ) ) {
				update_user_meta( $current_user->ID, 'description', sanitize_text_field( wp_unslash( $_POST['description'] ) ) );
			}
			if ( ! empty( $_POST['address'] ) ) {
				update_user_meta( $current_user->ID, 'address', sanitize_text_field( wp_unslash( $_POST['address'] ) ) );
			}
			if ( ! empty( $_POST['city'] ) ) {
				update_user_meta( $current_user->ID, 'city', sanitize_text_field( wp_unslash( $_POST['city'] ) ) );
			}
			if ( ! empty( $_POST['state'] ) ) {
				update_user_meta( $current_user->ID, 'state', sanitize_text_field( wp_unslash( $_POST['state'] ) ) );
			}
			if ( ! empty( $_POST['zip'] ) ) {
				update_user_meta( $current_user->ID, 'zip', sanitize_text_field( wp_unslash( $_POST['zip'] ) ) );
			}
			if ( ! empty( $_POST['phone'] ) ) {
				update_user_meta( $current_user->ID, 'phone', sanitize_text_field( wp_unslash( $_POST['phone'] ) ) );
			}

			do_action( 'shiftee_save_additional_user_profile_fields', $current_user->ID );
		}

		/**
		 * Today shortcode.
		 *
		 * [today] shows the currently logged-in employee the shift(s) they are scheduled to work today.
		 *
		 * @since 1.0
		 *
		 * @return string HTML to display today's shifts.
		 */
		public function today_shortcode() {

			if ( ! $this->helper->user_is_allowed() ) {
				return $this->show_login_form();
			}

			$viewer = wp_get_current_user();
			$now    = current_time( 'timestamp' ); // phpcs:ignore
			$args   = array(
				'post_type'       => 'shift',
				'posts_per_page'  => - 1,
				'order'           => 'DESC',
				'meta_key'        => '_shiftee_shift_start', // phpcs:ignore
				'orderby'         => 'meta-value',
				'meta_query'      => array( // phpcs:ignore
					$this->helper->date_meta_query( current_time( $now, false ) ),
				),
				'connected_type'  => 'shifts_to_employees',
				'connected_items' => $viewer->ID,

			);

			$todayquery = new WP_Query( $args );

			ob_start();
			include 'partials/shortcode-today.php';

			return apply_filters( 'shiftee_today_shortcode', ob_get_clean() );
		}

		/**
		 * Extra Work shortcode.
		 *
		 * [extra_work] shortcode displays a form where employees can record work they did that was not a scheduled shift.
		 *
		 * @since 1.0
		 *
		 * @return string HTML to display extra work form.
		 */
		public function extra_work_shortcode() {

			wp_enqueue_style( $this->plugin_name );
			wp_enqueue_script( $this->plugin_name );
			$datetimepicker_options = $this->helper->get_datetimepicker_options();
			wp_localize_script( $this->plugin_name, 'datetimepicker_options', $datetimepicker_options );

			if ( ! $this->helper->user_is_allowed() ) {
				return $this->show_login_form();
			}

			$message = '';

			// phpcs:ignore
			if ( isset( $_POST['shiftee-extra-work'] ) && 'Record Work' === ( $_POST['shiftee-extra-work'] ) ) { // We're not processing this form, just checking if it's there.
				$message = $this->save_extra_work();
			}

			ob_start();

			echo wp_kses_post( $message );

			include 'partials/shortcode-extra-work.php';

			return ob_get_clean();

		}

		/**
		 * If the "Extra" shift type has children, display a drop-down menu of those children.
		 *
		 * @return string
		 */
		public function extra_type_dropdown() {

			$extratype = get_term_by( 'slug', 'extra', 'shift_type' );
			// if extra has children, show dropdown of children.
			$extra_children = get_term_children( $extratype->term_id, 'shift_type' );
			if ( ! empty( $extra_children ) ) {
				$extra_dropdown =
					'<p>
					<label>' . __( 'Type of Work', 'employee-scheduler' ) . '</label>
					<select name="shiftee-shift-type" id="shiftee-shift-type">
						<option value=""> </option>';
				foreach ( $extra_children as $child ) {
					$childterm       = get_term_by( 'id', $child, 'shift_type' );
					$extra_dropdown .=
						'<option value="' . esc_attr( $childterm->slug ) . '">' . esc_attr( $childterm->name ) . '</option>';
				}
				$extra_dropdown .= '</select></p>';

				return $extra_dropdown;
			}
		}

		/**
		 * If there are jobs, display a dropdown field of jobs on the extra work shortcode or expense report shortcode.
		 *
		 * @return string|void
		 */
		public function job_dropdown() {

			$args = array(
				'post_type'      => 'job',
				'posts_per_page' => - 1,
				'order'          => 'ASC',
				'orderby'        => 'title',
			);
			$jobs = get_posts( $args );

			if ( $jobs ) {
				$job_dropdown = '<p id="shiftee-job">
				<label>' . __( 'Job', 'employee-scheduler' ) . '</label>
				<select name="shiftee-job" id="shiftee-job">
					<option value=""> </option>';
				foreach ( $jobs as $job ) {
					$job_dropdown .= '<option value="' . intval( $job->ID ) . '">' . esc_attr( $job->post_title ) . '</option>';
				}
				$job_dropdown .= '</select></p>';

				return $job_dropdown;
			}
		}

		/**
		 * If there are locations, display a dropdown list of locations on the extra work shortcode.
		 *
		 * @return string
		 */
		public function location_dropdown() {

			$locations = get_terms( 'location' );
			if ( $locations ) {
				$locations_dropdown = '<p id="shiftee-location">
				<label>' . __( 'Location', 'employee-scheduler' ) . '</label>
				<select name="shiftee-location" id="shiftee-location">
					<option value=""> </option>';
				foreach ( $locations as $location ) {
					$locations_dropdown .= '<option value="' . intval( $location->term_id ) . '">' . esc_attr( $location->name ) . '</option>';
				}
				$locations_dropdown .= '</select></p>';

				return $locations_dropdown;
			}

		}

		/**
		 * When an employee fills out the extra work form, save their entry
		 *
		 * @return string
		 */
		private function save_extra_work() {
			if ( ! isset( $_POST['shiftee_extra_work_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_extra_work_nonce'] ) ), 'shiftee_extra_work' ) ) {
				$message = '<p class="shiftee-failure">' . __( 'Permission Error', 'employee-scheduler' ) . '</p>';

				return $message;
			}

			$current_user = wp_get_current_user();

			if ( ! $current_user ) {
				$message = '<p class="shiftee-failure">' . __( 'Could not find user account.', 'employee-scheduler' ) . '</p>';

				return $message;
			}

			$username  = $current_user->display_name;
			$extrawork = array(
				'post_type'   => 'shift',
				// Translators: employee name.
				'post_title'  => sprintf( __( 'Extra shift by %s', 'employee-scheduler' ), $username ),
				'post_status' => 'publish',
			);
			if ( isset( $_POST['shiftee-description'] ) ) {
				$extrawork['post_content'] = sanitize_text_field( wp_unslash( $_POST['shiftee-description'] ) );
			}
			$extrashift = wp_insert_post( $extrawork );

			// check whether admins need to approve extra shifts.
			if ( '1' === $this->options['extra_shift_approval'] ) {
				// mark the shift as pending approval.
				wp_set_object_terms( $extrashift, 'pending-approval', 'shift_status' );

			} else {
				// we don't need admin approval, so mark the shift as worked.
				wp_set_object_terms( $extrashift, 'worked', 'shift_status' );
			}

			wp_set_object_terms( $extrashift, 'extra', 'shift_type' );

			// also add subcategory, if they selected one from the drop-down.
			if ( isset( $_POST['shiftee-shift-type'] ) ) {
				wp_set_object_terms( $extrashift, sanitize_text_field( wp_unslash( $_POST['shiftee-shift-type'] ) ), 'shift_type' );
			}
			if ( isset( $_POST['shiftee-location'] ) ) {
				wp_set_object_terms( $extrashift, intval( $_POST['shiftee-location'] ), 'location' );
			}
			wp_set_object_terms( $extrashift, 'worked', 'shift_status' );

			// phpcs:disable
			//  strtotime will sanitize these inputs.
			if ( isset( $_POST['shiftee-start'] ) ) {
				add_post_meta( $extrashift, '_shiftee_shift_start', strtotime( wp_unslash( $_POST['shiftee-start'] ) ) );
				add_post_meta( $extrashift, '_shiftee_clock_in', strtotime( wp_unslash( $_POST['shiftee-start'] ) ) );
			}

			if ( isset( $_POST['shiftee-end'] ) ) {
				add_post_meta( $extrashift, '_shiftee_shift_end', strtotime( wp_unslash( $_POST['shiftee-end'] ) ) );
				add_post_meta( $extrashift, '_shiftee_clock_out', strtotime( wp_unslash( $_POST['shiftee-end'] ) ) );
			}
			// phpcs:enable

			add_post_meta( $extrashift, '_shiftee_scheduled_duration', $this->helper->get_shift_duration( $extrashift, 'scheduled', 'hours' ) );
			add_post_meta( $extrashift, '_shiftee_worked_duration', $this->helper->get_shift_duration( $extrashift, 'worked', 'hours' ) );
			add_post_meta( $extrashift, '_shiftee_wage', $this->helper->calculate_shift_wage( $extrashift ) );

			// connect shift to employee.
			p2p_type( 'shifts_to_employees' )->connect(
				$extrashift,
				$current_user->ID,
				array(
					'date' => current_time( 'mysql' ),
				)
			);
			// connect shift to job.
			if ( isset( $_POST['shiftee-job'] ) && '' !== $_POST['shiftee-job'] ) {
				p2p_type( 'shifts_to_jobs' )->connect(
					$extrashift,
					intval( $_POST['shiftee-job'] ),
					array(
						'date' => current_time( 'mysql' ),
					)
				);
			}

			if ( $extrashift ) {
				$message = '<p class="shiftee-success">' . __( 'Your extra work has been recorded.  ', 'employee-scheduler' ) . '<a href="' . get_the_permalink( $extrashift ) . '">' . __( 'View extra work shift', 'employee-scheduler' ) . '</a></p>';
			} else {
				$message = '<p class="shiftee-failure">' . __( 'Sorry, there was an error recording your work.', 'employee-scheduler' ) . '</p>';
			}

			do_action( 'shiftee_add_extra_work_action', $extrashift, $current_user );

			return $message;
		}

		/**
		 * Record Expense shortcode.
		 *
		 * [record_expense] displays a form where employees can record mileage and expenses.
		 *
		 * @since 1.0.0
		 *
		 * @return string HTML to display form.
		 */
		public function record_expense_shortcode() {

			wp_enqueue_style( $this->plugin_name );
			wp_enqueue_script( $this->plugin_name );
			$datetimepicker_options = $this->helper->get_datetimepicker_options();
			wp_localize_script( $this->plugin_name, 'datetimepicker_options', $datetimepicker_options );

			if ( ! $this->helper->user_is_allowed() ) {
				return $this->show_login_form();
			}

			$message = '';

			// phpcs:ignore
			if ( isset( $_POST['shiftee-expense-form'] ) && 'Record Expense' === ( $_POST['shiftee-expense-form'] ) ) { //  We aren't actually processing this form data, just checking if it exists.
				$message = $this->add_expense();
			}

			ob_start();

			echo wp_kses_post( $message );

			include 'partials/shortcode-record-expense.php';

			return ob_get_clean();

		}


		/**
		 * Expense category dropdown.
		 *
		 * Expense category is a hierarchical taxonomy: this displays the top-level expense categories.
		 *
		 * @since 1.0
		 *
		 * @see record_expense_shortcode()
		 *
		 * @return string HTML for dropdown.
		 */
		public function expense_category_dropdown() {
			$dropdown = '';

			// Get all taxonomy terms.
			$terms = get_terms(
				'expense_category',
				array(
					'hide_empty' => false,
					'parent'     => 0,
				)
			);

			if ( isset( $terms ) ) {
				foreach ( $terms as $term ) {
					$dropdown .= '<option value="' . $term->slug . '">' . $term->name . '</option>';
					$dropdown .= $this->get_term_children( $term->term_id, 1 );
				}
			}

			return $dropdown;
		}

		/**
		 * Expense category dropdown: child terms.
		 *
		 * Display the children and grandchildren in the expense category dropdown.
		 *
		 * @since 1.0
		 *
		 * @see expense_category_dropdown()
		 *
		 * @param int $termid ID of taxonomy term.
		 * @param int $depth how deep in the hierarchy we are.
		 *
		 * @return string HTML for dropdown.
		 */
		public function get_term_children( $termid, $depth ) {

			$children   = '';
			$childterms = get_terms(
				'expense_category',
				array(
					'hide_empty' => false,
					'parent'     => $termid,
				)
			);

			if ( isset( $childterms ) ) {
				$depth ++;
				foreach ( $childterms as $childterm ) {

					$children .= '<option value="' . $childterm->slug . '"> ';
					for ( $i = 0; $i < $depth; $i ++ ) {
						$children .= '--';
					}
					$children .= ' ' . $childterm->name . '</option>';
					$children .= $this->get_term_children( $childterm->term_id, $depth );
				}
			}

			return $children;
		}

		/**
		 * Record expense.
		 *
		 * When employee fills out the "record expense" form, save the expense.
		 *
		 * @since 1.0
		 *
		 * @see record_expense_shortcode()
		 *
		 * @return string  Success or failure message.
		 */
		private function add_expense() {

			if ( ! isset( $_POST['shiftee_record_expense_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['shiftee_record_expense_nonce'] ) ), 'shiftee_record_expense' ) ) {
				$message = '<p class="shiftee-failure">' . __( 'Permission Error', 'employee-scheduler' ) . '</p>';

				return $message;
			}

			$current_user = wp_get_current_user();

			if ( ! $current_user ) {
				$message = '<p class="shiftee-failure">' . __( 'Could not find user account.', 'employee-scheduler' ) . '</p>';

				return $message;
			}

			$username = $current_user->display_name;

			$this_expense = array(
				'post_type'   => 'expense',
				// Translators: Name of the employee who is reporting the expense.
				'post_title'  => sprintf( __( 'Expense reported by %s', 'employee-scheduler' ), $username ),
				'post_status' => 'publish',
			);
			if ( isset( $_POST['shiftee-expense-description'] ) ) {
				$this_expense['post_content'] = sanitize_text_field( wp_unslash( $_POST['shiftee-expense-description'] ) );
			}
			$new_expense = wp_insert_post( $this_expense );

			if ( isset( $_POST['shiftee-expense-date'] ) ) {
				// phpcs:ignore
				add_post_meta( $new_expense, '_shiftee_date', strtotime( wp_unslash( $_POST['shiftee-expense-date'] ) ) );  // strtotime will sanitize this input.
			}

			if ( isset( $_POST['shiftee-expense-amount'] ) ) {
				add_post_meta( $new_expense, '_shiftee_amount', floatval( $_POST['shiftee-expense-amount'] ) );
			}

			if ( isset( $_POST['shiftee-expense-type'] ) ) {
				wp_set_object_terms( $new_expense, sanitize_text_field( wp_unslash( $_POST['shiftee-expense-type'] ) ), 'expense_category' );
			}

			// attach image.
			if ( isset( $_FILES['shiftee-expense-receipt'] ) && is_array( $_FILES['shiftee-expense-receipt'] ) ) {

				if ( ! isset( $_FILES['shiftee-expense-receipt']['name'] ) && ! isset( $_FILES['shiftee-expense-receipt']['tmp_name'] ) ) {
					wp_die( esc_html__( 'Invalid file.  Please go back and try again.', 'employee-schedule-manager' ) );
				}

				$file_name     = sanitize_file_name( wp_unslash( $_FILES['shiftee-expense-receipt']['name'] ) );
				$file_tmp_name = sanitize_file_name( wp_unslash( $_FILES['shiftee-expense-receipt']['tmp_name'] ) );

				// make sure this is an image.
				$allowed_types = array( IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF );
				$detected_type = exif_imagetype( $file_tmp_name );
				$allowed       = in_array( $detected_type, $allowed_types, true );
				if ( ! $allowed ) {
					wp_die( esc_html__( 'Invalid file.  Please go back and try again.', 'employee-schedule-manager' ) );
				}

				$upload = wp_upload_bits(
					$file_name,
					null,
					// phpcs:ignore
					file_get_contents( $file_tmp_name ) // this isn't a remote file, so we don't want to use wp_remote_get().
				);

				$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );

				$wp_upload_dir = wp_upload_dir();

				$attachment = array(
					'guid'           => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $upload['file'] ),
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $upload['file'] ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);

				$attach_id = wp_insert_attachment( $attachment, $upload['file'], $new_expense );

				require_once ABSPATH . 'wp-admin/includes/image.php';

				$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );

				update_post_meta( $new_expense, '_thumbnail_id', $attach_id );
			}

			// connect shift to employee.
			p2p_type( 'expenses_to_employees' )->connect(
				$new_expense,
				$current_user->ID,
				array(
					'date' => current_time( 'mysql' ),
				)
			);
			// connect shift to job.
			if ( isset( $_POST['shiftee-job'] ) && '' !== $_POST['shiftee-job'] ) {
				p2p_type( 'expenses_to_jobs' )->connect(
					$new_expense,
					intval( $_POST['shiftee-job'] ),
					array(
						'date' => current_time( 'mysql' ),
					)
				);
			}

			if ( $new_expense ) {
				$message = '<p class="shiftee-success">' . __( 'Your expense has been recorded.', 'employee-scheduler' ) . '</p>';
			} else {
				$message = '<p class="shiftee-failure">' . __( 'Sorry, there was an error recording your expense.', 'employee-scheduler' ) . '</p>';
			}

			do_action( 'shiftee_add_expense_action' );

			return $message;
		}

		/**
		 * Leave forward-slashes in file names
		 *
		 * @since 2.3.0
		 *
		 * @param array $special_chars List of special characters that WordPress strips out by default.
		 * @return array
		 */
		public function allow_slashes( $special_chars ) {
			$new_special_chars = array_diff( $special_chars, array( '/' ) );
			return $new_special_chars;
		}

	}

}
