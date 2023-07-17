<?php
/**
 * Plugin Name:       EV Freight
 * Description:       EV freight custom block
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Eimantas Vaidotas
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ev-freight
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ev_freight_block_block_init() {

	register_block_type(
		( __DIR__ ) . '/build/block.json',
		array(
			'render_callback' => 'ev_freight_dynamic_block_render_callback',
		)
	);
}
add_action( 'init', 'ev_freight_block_block_init' );

function ev_freight_dynamic_block_render_callback( $attributes, $content, $block_instance ) {
	ob_start();
	require ( __DIR__ ) . '/template.php';
	return ob_get_clean();
}
