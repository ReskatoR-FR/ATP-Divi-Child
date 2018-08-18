<?php defined( 'ABSPATH' ) || exit;
/*
Plugin Name: ATP Divi Child
Plugin URI: https://www.reskator.fr
Description: To easily create a Divi child theme.
Version: 1.0
Author: ReskatoR
Author URI: http://www.reskator.fr
Text Domain: rr-atp-divi-child
Domain Path: /languages
License: GPLv2 or later
*/

if ( is_admin() ) :
	// Define ATP_PLUGIN_FILE.
	if ( ! defined( 'ATP_DC_PLUGIN_FILE' ) ) {
		define( 'ATP_DC_PLUGIN_FILE', __FILE__ );
	}

	/**
	 * The code that runs during plugin activation.
	 */
	function activate_atp_divi_child() {
		require_once dirname( ATP_DC_PLUGIN_FILE ) . '/includes/class-atp-dc-activate.php';
		ATP_DC_activate::activate();

		register_uninstall_hook( ATP_DC_PLUGIN_FILE, 'uninstall_atp_divi_child' );
	}

	/**
	 * The code that runs during plugin deactivation.
	 */
	function deactivate_atp_divi_child() {
		require_once dirname( ATP_DC_PLUGIN_FILE ) . '/includes/class-atp-dc-deactivate.php';
		ATP_DC_deactivate::deactivate();
	}

	function uninstall_atp_divi_child() {
		require_once dirname( ATP_DC_PLUGIN_FILE) . '/includes/class-atp-dc-uninstall.php';
		ATP_DC_uninstall::uninstall();
	}
	register_activation_hook( ATP_DC_PLUGIN_FILE, 'activate_atp_divi_child' );
	register_deactivation_hook( ATP_DC_PLUGIN_FILE, 'deactivate_atp_divi_child' );

	// Include the main ATP Divi Child class.
	if ( ! class_exists( 'ATP_Divi_Child' ) ) {
		require_once dirname( ATP_DC_PLUGIN_FILE ) . '/includes/class-atp-divi-child.php';

	} else {
		// TODO : gérer l'erreur
		echo 'le fichier de la classe n’a pas été chargé.<br>';
		exit;
	}


	if ( class_exists( 'ATP_Divi_Child') ) {
		$ATP_Divi_Child = ATP_Divi_Child::get_instance();

	} else {
		echo 'L’objet n’a pas été instancié.<br/>';
		exit;
	}
endif;