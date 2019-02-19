<?php
/**
 * Settings
 *
 * @package         EDD\StoreHours\Admin\Settings
 * @since           1.1.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Add settings section
 *
 * @since       1.1.0
 * @param       array $sections The existing extensions sections
 * @return      array The modified extensions settings
 */
function edd_store_hours_add_settings_section( $sections ) {
	$sections['store-hours'] = __( 'Store Hours', 'edd-store-hours' );

	return $sections;
}
add_filter( 'edd_settings_sections_extensions', 'edd_store_hours_add_settings_section' );


/**
 * Add settings
 *
 * @since       1.1.0
 * @param       array $settings the existing plugin settings
 * @return      array
 */
function edd_store_hours_register_settings( $settings ) {
	if( EDD_VERSION >= '2.5' ) {
		$new_settings = array(
			'store-hours' => array(
				array(
					'id'   => 'edd_store_hours_settings',
					'name' => '<strong>' . __( 'Store Hours', 'edd-store-hours' ) . '</strong>',
					'desc' => __( 'Configure Store Hours', 'edd-store-hours' ),
					'type' => 'header'
				),
				array(
					'id'            => 'edd_store_hours_monday',
					'name'          => __( 'Monday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_tuesday',
					'name'          => __( 'Tuesday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_wednesday',
					'name'          => __( 'Wednesday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_thursday',
					'name'          => __( 'Thursday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_friday',
					'name'          => __( 'Friday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_saturday',
					'name'          => __( 'Saturday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'            => 'edd_store_hours_sunday',
					'name'          => __( 'Sunday', 'edd-store-hours' ),
					'desc'          => '',
					'type'          => 'hours',
					'tooltip_title' => __( 'Setting Hours', 'edd-store-hours' ),
					'tooltip_desc'  => __( 'Wondering where the hours fields are? Days must be set to \'Open\' to set hours!', 'edd-store-hours' )
				),
				array(
					'id'   => 'edd_store_hours_closed_now',
					'name' => __( 'Close Store', 'edd-store-hours' ),
					'desc' => __( 'Override the pre-defined schedule and close the store now', 'edd-store-hours' ),
					'type' => 'checkbox'
				),
				array(
					'id'   => 'edd_store_hours_display_settings',
					'name' => '<strong>' . __( 'Display Settings', 'edd-store-hours' ) . '</strong>',
					'desc' => __( 'Configure Store Hours Display Settings', 'edd-store-hours' ),
					'type' => 'header'
				),
				array(
					'id'   => 'edd_store_hours_hide_buttons',
					'name' => __( 'Hide Purchase Buttons', 'edd-store-hours' ),
					'desc' => __( 'Hide purchase buttons instead of simply disabling them', 'edd-store-hours' ),
					'type' => 'checkbox'
				),
				array(
					'id'   => 'edd_store_hours_closed_label',
					'name' => __( 'Closed Button Label', 'edd-store-hours' ),
					'desc' => edd_store_hours_get_template_tags(),
					'type' => 'text',
					'std'  => __( 'Store Closed', 'edd-store-hours' ),
				),
				array(
					'id'   => 'edd_store_hours_show_admin_bar',
					'name' => __( 'Admin Bar Notification', 'edd-store-hours' ),
					'desc' => __( 'Displays a notification in the admin bar when the site is closed', 'edd-store-hours' ),
					'type' => 'checkbox',
					'std'  => '1'
				)
			)
		);

		$settings = array_merge( $settings, $new_settings );
	}

	return $settings;
}
add_filter( 'edd_settings_extensions', 'edd_store_hours_register_settings', 1 );


/**
 * Add settings (pre-2.5)
 *
 * @since       1.1.60
 * @param       array $settings The existing plugin settings
 * @return      array The modified plugin settings
 */
function edd_store_hours_add_settings_pre25( $settings ) {
	if( EDD_VERSION < '2.5' ) {
		$new_settings = array(
			array(
				'id'   => 'edd_store_hours_settings',
				'name' => '<strong>' . __( 'Store Hours', 'edd-store-hours' ) . '</strong>',
				'desc' => __( 'Configure Store Hours', 'edd-store-hours' ),
				'type' => 'header'
			),
			array(
				'id'   => 'edd_store_hours_monday',
				'name' => __( 'Monday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours'
			),
			array(
				'id'   => 'edd_store_hours_tuesday',
				'name' => __( 'Tuesday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_wednesday',
				'name' => __( 'Wednesday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_thursday',
				'name' => __( 'Thursday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_friday',
				'name' => __( 'Friday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_saturday',
				'name' => __( 'Saturday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_sunday',
				'name' => __( 'Sunday', 'edd-store-hours' ),
				'desc' => '',
				'type' => 'hours',
			),
			array(
				'id'   => 'edd_store_hours_closed_now',
				'name' => __( 'Close Store', 'edd-store-hours' ),
				'desc' => __( 'Override the pre-defined schedule and close the store now', 'edd-store-hours' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'edd_store_hours_display_settings',
				'name' => '<strong>' . __( 'Store Hours - Display Settings', 'edd-store-hours' ) . '</strong>',
				'desc' => __( 'Configure Store Hours Display Settings', 'edd-store-hours' ),
				'type' => 'header'
			),
			array(
				'id'   => 'edd_store_hours_hide_buttons',
				'name' => __( 'Hide Purchase Buttons', 'edd-store-hours' ),
				'desc' => __( 'Hide purchase buttons instead of simply disabling them', 'edd-store-hours' ),
				'type' => 'checkbox'
			),
			array(
				'id'   => 'edd_store_hours_closed_label',
				'name' => __( 'Closed Button Label', 'edd-store-hours' ),
				'desc' => edd_store_hours_get_template_tags(),
				'type' => 'text',
				'std'  => __( 'Store Closed', 'edd-store-hours' ),
			),
			array(
				'id'   => 'edd_store_hours_show_admin_bar',
				'name' => __( 'Show Admin Bar Notification', 'edd-store-hours' ),
				'desc' => __( 'Displays a notification in the admin bar when the site is closed', 'edd-store-hours' ),
				'type' => 'checkbox',
				'std'  => '1'
			)
		);

		$settings = array_merge( $settings, $new_settings );
	}

	return $settings;
}
add_filter( 'edd_settings_extensions', 'edd_store_hours_add_settings_pre25' );


/**
 * Hours Callback
 *
 * Renders hours fields.
 *
 * @since		1.0.0
 * @param 		array $args Arguments passed by the setting
 * @global 		$edd_options Array of all the EDD Options
 * @return 		void
 */
function edd_hours_callback( $args ) {
	global $edd_options;

	$status = ( isset( $edd_options[$args['id'] . '_status'] ) ? $edd_options[$args['id'] . '_status'] : 'open' );
	$open   = ( isset( $edd_options[$args['id'] . '_open'] ) && ! empty( $edd_options[$args['id'] . '_open'] ) ? date( 'g:i a', strtotime( $edd_options[$args['id'] . '_open'] ) ) : '' );
	$close  = ( isset( $edd_options[$args['id'] . '_close'] ) && ! empty( $edd_options[$args['id'] . '_close'] ) ? date( 'g:i a', strtotime( $edd_options[$args['id'] . '_close'] ) ) : '' );

	$html  = '<select id="edd_settings[' . $args['id'] . '_status]" name="edd_settings[' . $args['id'] . '_status]" class="edd_store_hours_day_status" />';
	$html .= '<option value="open" ' . selected( 'open', $status, false ) . '>' . __( 'Open', 'edd-store-hours' ) . '</option>';
	$html .= '<option value="closed" ' . selected( 'closed', $status, false ) . '>' . __( 'Closed', 'edd-store-hours' ) . '</option>';
	$html .= '</select>';
	$html .= '<span class="edd-store-hours-input">';
	$html .= '<input type="text" class="edd-store-hours" id="edd_settings[' . $args['id'] . '_open]" name="edd_settings[' . $args['id'] . '_open]" value="' . esc_attr( stripslashes( $open ) ) . '" placeholder="' . __( 'Opening Time', 'edd-store-hours' ) . '" />';
	$html .= ' - ';
	$html .= '<input type="text" class="edd-store-hours" id="edd_settings[' . $args['id'] . '_close]" name="edd_settings[' . $args['id'] . '_close]" value="' . esc_attr( stripslashes( $close ) ) . '" placeholder="' . __( 'Closing Time', 'edd-store-hours' ) . '" />';
	$html .= '</span>';
	$html .= '<label for="edd_settings[' . $args['id'] . ']"> '  . $args['desc'] . '</label>';

	echo apply_filters( 'edd_after_setting_output', $html, $args );
}


/**
 * The hours fields need special sanitization... time
 * formats are a bitch!
 *
 * @since       1.1.0
 * @param       array $input The settings we are sanitizing
 * @global      array $edd_options The EDD settings array
 * @return      array $input The sanitized settings
 */
function edd_hours_sanitize( $input ) {
	global $edd_options;

	$days = array( 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday' );

	foreach( $days as $day ) {
		if( isset( $input['edd_store_hours_' . $day . '_open'] ) && ! empty( $input['edd_store_hours_' . $day . '_open'] ) ) {
			$input['edd_store_hours_' . $day . '_open'] = date( 'Hi', strtotime( $input['edd_store_hours_' . $day . '_open'] ) );
		}

		if( isset( $input['edd_store_hours_' . $day . '_close'] ) && ! empty( $input['edd_store_hours_' . $day . '_close'] ) ) {
			$input['edd_store_hours_' . $day . '_close'] = date( 'Hi', strtotime( $input['edd_store_hours_' . $day . '_close'] ) );
		}
	}

	return $input;
}
add_filter( 'edd_settings_hours_sanitize', 'edd_hours_sanitize', 1 );