(function( $ ) {
	'use strict';

	$( document ).ready(
		function() {

			if ( $.isFunction( $.fn.datepicker ) && typeof datetimepicker_options != 'undefined' ) {
				$( '.shiftee-date-picker' ).datepicker(
					{
						dateFormat: datetimepicker_options.date_format,
					}
				);

			}

			if ( $.isFunction( $.fn.datetimepicker ) && typeof datetimepicker_options != 'undefined' ) {

				$( '.shiftee-time-picker' ).datetimepicker(
					{
						timeOnly: true,
						dateFormat: datetimepicker_options.date_format,
						timeFormat: datetimepicker_options.time_format,
						stepMinute: 5,
					}
				);

				$( '.shiftee-datetime-picker' ).datetimepicker(
					{
						dateFormat: datetimepicker_options.date_format,
						timeFormat: datetimepicker_options.time_format,
						firstDay: datetimepicker_options.first_day_of_week,
						stepMinute: 5,
					}
				);
			}

			if ( $.isFunction( $.fn.fullCalendar ) && typeof calendar_options != 'undefined' ) {
				window.mobilecheck = function() {
					var check = false;
					(function(a){if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test( a ) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test( a.substr( 0,4 ) )) {
							check = true;
					}})( navigator.userAgent || navigator.vendor || window.opera );
					return check;
				};

				$( '#shiftee-calendar' ).fullCalendar(
					{
						loading: function( isLoading, view ) {
							if (isLoading) {
								$( '#shiftee-calendar-loader' ).show();
							} else {
								$( '#shiftee-calendar-loader' ).hide();
							}
						},
						header: {
							left: 'prev,next today',
							center: 'title',
							right: calendar_options.right,
						},
						defaultView: window.mobilecheck() ? "basicDay" : "basicWeek",
						editable: false,
						displayEventEnd: true,
						height: 'auto',
						firstDay: calendar_options.first_day,
						events: {
							url: shiftee_ajax.ajaxurl,
							type: 'POST',
							data: {
								action: 'Shiftee_Basic_Public',
								shift_type: $( '#shiftee-calendar' ).attr( 'data-type' ),
								status: $( '#shiftee-calendar' ).attr( 'data-status' ),
								location: $( '#shiftee-calendar' ).attr( 'data-location' ),
								job: $( '#shiftee-calendar' ).attr( 'data-job' ),
								manager: $( '#shiftee-calendar' ).attr( 'data-manager' ),
								employee: $( '#shiftee-calendar' ).attr( 'data-employee' ),
							},
							error: function(result) {
								$( '#shiftee-calendar-error' ).show();
							},
							success: function( result ){

							}
						},
						timeFormat: calendar_options.time_format,
						eventRender: function(event, element) {
							var ntoday     = new Date().getTime();
							var eventEnd   = moment( event.end ).valueOf();
							var eventStart = moment( event.start ).valueOf();
							if ( ! event.end) {
								if (eventStart < ntoday) {
									element.addClass( "past-event" );
									element.children().addClass( "past-event" );
								}
							} else {
								if (eventEnd < ntoday) {
									element.addClass( "past-event" );
									element.children().addClass( "past-event" );
								}
							}

							element.attr( 'data-id', event.id );

							if ( typeof event.staff != 'undefined' ) {
								var staff = event.staff;
							} else {
								var staff = calendar_options.unassigned;
							}

							if ( typeof event.location != 'undefined' ) {
								var location = '<strong>Location: </strong>' + event.location + '<br/>';
							} else {
								var location = '';
							}

							var new_description =
							staff
							+ location;
							element.append( new_description );
						}

					}
				);

				$( '.shiftee-calendar-filter' ).on(
					'change',
					function(e) {

						// add the value to the data attributes
						var attribute      = $( this ).data( 'name' );
						var attributeValue = $( this ).val();
						$( '#shiftee-calendar' ).attr( 'data-' + attribute, attributeValue );
						$( '#shiftee-calendar-error' ).hide();

						// reload the calendar events
						var events = {
							url: shiftee_ajax.ajaxurl,
							type: 'POST',
							data: {
								action: 'Shiftee_Basic_Public',
								shift_type: $( '#shiftee-calendar' ).attr( 'data-type' ),
								status: $( '#shiftee-calendar' ).attr( 'data-status' ),
								location: $( '#shiftee-calendar' ).attr( 'data-location' ),
								job: $( '#shiftee-calendar' ).attr( 'data-job' ),
								manager: $( '#shiftee-calendar' ).attr( 'data-manager' ),
								employee: $( '#shiftee-calendar' ).attr( 'data-employee' ),
							},
							error: function() {
								$( '#shiftee-calendar-error' ).show();
							},
							success: function( result ){

							}
						}

						$( '#shiftee-calendar' ).fullCalendar( 'removeEventSource', events );
						$( '#shiftee-calendar' ).fullCalendar( 'addEventSource', events );
					}
				);

			}

			$( 'body' ).on(
				'click',
				'.shiftee-take-shift',
				function(e) {
					e.preventDefault();
					$( this ).addClass( 'taking-shift' );
					var url  = shiftee_ajax.ajaxurl;
					var id   = $( this ).closest( '.fc-event' ).attr( 'data-id' );
					var data = {
						'action': 'pick_up_shift_ajax',
						'id': id,
					};

					$.post(
						url,
						data,
						function (response) {
							$( '.taking-shift' ).html( response );
						}
					);

				}
			);

			// Add a new repeating section
			jQuery( '.shiftee-repeat' ).click(
				function(e){
					var repeatingTemplate = jQuery( '#date-time-template' ).html();
					e.preventDefault();
					var repeating          = jQuery( repeatingTemplate );
					var lastRepeatingGroup = jQuery( '.repeating-unavailability' ).last();
					var idx                = lastRepeatingGroup.index();
					var attrs              = ['for', 'id', 'name'];
					var tags               = repeating.find( 'input, label, select' );
					tags.each(
						function() {
							var section = jQuery( this );
							jQuery.each(
								attrs,
								function(i, attr) {
									var attr_val = section.attr( attr );
									if (attr_val) {
										section.attr( attr, attr_val.replace( /unavailable\[\d+\]\[/, 'unavailable\[' + (idx + 1) + '\]\[' ) )
									}
								}
							)
						}
					);

					jQuery( '#date-time-template' ).after( repeating );
					repeating.find( '.shiftee-time-picker' ).datetimepicker(
						{
							timeOnly: true,
							timeFormat: "h:mm tt"
						}
					);
				}
			);

			var repeatingTemplate = jQuery( '#availability-template' ).html();

			// Add a new repeating section
			jQuery( '.shiftee-repeat-availability' ).click(
				function(e){
					e.preventDefault();
					var repeating          = jQuery( repeatingTemplate );
					var lastRepeatingGroup = jQuery( '.repeating-availability' ).last();
					var idx                = lastRepeatingGroup.index();
					var attrs              = ['for', 'id', 'name'];
					var tags               = repeating.find( 'input, label, select' );
					tags.each(
						function() {
							var section = jQuery( this );
							jQuery.each(
								attrs,
								function(i, attr) {
									var attr_val = section.attr( attr );
									if (attr_val) {
										section.attr( attr, attr_val.replace( /unavailable\[\d+\]\[/, 'unavailable\[' + (idx + 1) + '\]\[' ) )
									}
								}
							)
						}
					);

					jQuery( '#availability-template' ).after( repeating );
					repeating.find( '.shiftee-time-picker-min' ).datetimepicker(
						{
							datepicker:false,
							format:'H:i',
							step: 1,
						}
					);
					repeating.find( '.shiftee-datetime-picker' ).datetimepicker(
						{
							timeFormat: "h:mm tt"
						}
					);
				}
			);

			jQuery( 'body' ).on(
				'click',
				'a.remove-availability',
				function (e){
					e.preventDefault();
					jQuery( this ).closest( '.repeating-unavailability' ).remove();
					jQuery( this ).closest( '.repeating-availability' ).remove();
				}
			);

			$( '.shiftee-show-more-unassigned' ).on(
				'click',
				function (e){
					e.preventDefault();
					$( this ).next( '.shiftee-more-unassigned' ).show();
					$( this ).hide();
				}
			);

			$( '#shiftee-od-employer-work-request' ).on(
				'submit',
				function (e){
					$( '#shiftee-loading' ).show();
				}
			);
		}
	);

})( jQuery );
