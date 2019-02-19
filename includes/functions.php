<?php
/**
 * Add Helper Functions
 *
 * @package     EDD\StoreHours\Functions
 * @since       1.0.0
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Get available template tags
 *
 * @since       1.0.0
 * @return      array $tags The available template tags
 */
function edd_store_hours_template_tags() {
	$tags = array(
		'sitename'       => __( 'Your site name', 'edd-site-hours' ),
		'open_today'     => __( 'The time your store opened today', 'edd-site-hours' ),
		'close_today'    => __( 'The time your store closed today', 'edd-site-hours' ),
		'open_tomorrow'  => __( 'The time your store opens tomorrow', 'edd-site-hours' ),
		'close_tomorrow' => __( 'The time your store closes tomorrow', 'edd-site-hours' ),
	);

	return apply_filters( 'edd_site_hours_template_tags', $tags );
}


/**
 * Get the template tags
 *
 * @since       1.0.0
 * @return      array $tags The formatted template tags
 */
function edd_store_hours_get_template_tags() {
	$template_tags = edd_store_hours_template_tags();
	$tags          = __( '<br/>This field allows several template tags:', 'edd-store-hours' );

	foreach( $template_tags as $tag => $desc ) {
		$tags .= '<br /><span class="edd-store-hours-tag-name">{' . $tag . '}</span><span class="edd-store-hours-tag-desc">' . $desc . '</span>';
	}

	return $tags;
}


/**
 * Handle template tags
 *
 * @since       1.0.0
 * @param       string $template Text before tag replacement
 * @return      string $template Text after tag replacement
 */
function edd_store_hours_parse_template_tags( $template ) {
	$has_tags = ( strpos( $template, '{' ) !== false );
	if( ! $has_tags ) {
		return $template;
	}

	$today          = strtolower( current_time( 'l' ) );
	$tomorrow       = strtolower( date( 'l', current_time( 'timestamp' ) + 86400 ) );
	$open_today     = edd_get_option( 'edd_store_hours_' . $today . '_open', '0000' );
	$close_today    = edd_get_option( 'edd_store_hours_' . $today . '_close', '2359' );
	$open_tomorrow  = edd_get_option( 'edd_store_hours_' . $tomorrow . '_open', '0000' );
	$close_tomorrow = edd_get_option( 'edd_store_hours_' . $tomorrow . '_close', '2359' );

	$template = str_replace( '{sitename}', get_bloginfo( 'name' ), $template );
	$template = str_replace( '{open_today}', date( 'g:i a', strtotime( $open_today ) ), $template );
	$template = str_replace( '{close_today}', date( 'g:i a', strtotime( $close_today ) ), $template );
	$template = str_replace( '{open_tomorrow}', date( 'g:i a', strtotime( $open_tomorrow ) ), $template );
	$template = str_replace( '{close_tomorrow}', date( 'g:i a', strtotime( $close_tomorrow ) ), $template );

	$template = apply_filters( 'edd_store_hours_parse_template_tags', $template );

	return $template;
}


/**
 * Determine whether or not the store is open
 *
 * @since 1.0.0
 * @return bool True if closed, False otherwise
 */
function edd_store_hours_is_closed() {
	$now        = (float) date_i18n( 'Gi' );
	$today      = strtolower( date_i18n( 'l' ) );

	$status     = edd_get_option( 'edd_store_hours_' . $today . '_status', 'open' );

	$open_time  = strtolower( edd_get_option( 'edd_store_hours_' . $today . '_open', '0000' ) );
	$open       = (float) preg_replace( '/[^0-9]/', '', $open_time );

	// If the time is PM we need to account for 24 hour time
	if ( $open < 1200 && strpos( $open_time, 'pm' ) ) {
		$open += 1200;
	} else if ( $open >= 1200 && strpos( $open_time, 'am' ) ) {
		$open -= 1200;
	}

	$close_time = strtolower( edd_get_option( 'edd_store_hours_' . $today . '_close', '2359' ) );
	$close      = (float) preg_replace( '/[^0-9]/', '', $close_time );

	// If the time is PM we need to account for 24 hour time
	if ( $close < 1200 && strpos( $close_time, 'pm' ) ) {
		$close += 1200;
	} else if ( $close >= 1200 && strpos( $close_time, 'am' ) ) {
		$close -= 1200;
	}

	$override   = edd_get_option( 'edd_store_hours_closed_now', false ) ? true : false;
	if( $status == 'closed' || $override === true || $now <= $open || $now >= $close ) {
		return true;
	}

	return false;
}