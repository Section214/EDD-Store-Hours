<?php
/**
 * Filters
 *
 * @package     EDD\StoreHours\Filters
 * @since       1.1.0
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Override the add to cart button if the store is closed
 *
 * @since       1.0.0
 * @param       string $purchase_form the actual purchase form code
 * @param       array $args the info for the specific download
 * @return      string $purchase_form if store is open
 * @return      string $closed if store is closed
 */
function edd_store_hours_override_purchase_button( $purchase_form, $args ) {
	$closed_label = edd_get_option( 'edd_store_hours_closed_label' ) ? edd_get_option( 'edd_store_hours_closed_label' ) : __( 'Store Closed', 'edd-store-hours' );
	$closed_label = edd_store_hours_parse_template_tags( $closed_label );
	$form_id      = ! empty( $args['form_id'] ) ? $args['form_id'] : 'edd_purchase_' . $args['download_id'];
	$hide_buttons = edd_get_option( 'edd_store_hours_hide_buttons', false ) ? true : false;

	if( edd_store_hours_is_closed() ) {
		if( ! $hide_buttons ) {
			$purchase_form  = '<form id="' . $form_id . '" class="edd_download_purchase_form">';
			$purchase_form .= '<div class="edd_purchase_submit_wrapper">';

			if( edd_is_ajax_enabled() ) {
				$purchase_form .= sprintf(
					'<div class="edd-add-to-cart %1$s"><span>%2$s</span></a>',
					implode( ' ', array( $args['style'], $args['color'], trim( $args['class'] ) ) ),
					esc_attr( $closed_label )
				);
				$purchase_form .= '</div>';
			} else {
				$purchase_form .= sprintf(
					'<input type="submit" class="edd-add-to-cart edd-no-js %1$s" name="edd_purchase_download" value="%2$s" disabled />',
					implode( ' ', array( $args['style'], $args['color'], trim( $args['class'] ) ) ),
					esc_attr( $closed_label )
				);
			}

			$purchase_form .= '</div></form>';
		} else {
			$purchase_form = '';
		}
	}

	return $purchase_form;
}
add_filter( 'edd_purchase_download_form', 'edd_store_hours_override_purchase_button', 200, 2 );


/**
 * Override edd_pre_add_to_cart so users can't add through direct linking
 *
 * @since       1.0.0
 * @param       int $download_id The ID of a specific download
 * @param       array $options The options for this downloads
 * @return      void
 */
function edd_store_hours_override_add_to_cart( $download_id, $options ) {
	$closed_label = edd_get_option( 'edd_store_hours_closed_label' ) ? edd_get_option( 'edd_store_hours_closed_label' ) : __( 'Store Closed', 'edd-store-hours' );
	$closed_label = edd_store_hours_parse_template_tags( $closed_label );
	$cart_items   = edd_get_cart_contents();

	if( edd_store_hours_is_closed() ) {
		wp_die( $closed_label );
	}
}
add_action( 'edd_pre_add_to_cart', 'edd_store_hours_override_add_to_cart', 200, 2 );