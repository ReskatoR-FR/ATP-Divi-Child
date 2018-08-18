<?php defined( 'ABSPATH' ) || exit;
/**
 * Fired during plugin uninstallation.
 *
 * This class defines all code necessary to run during the plugin's uninstallation.
 *
 * @since      1.0.0
 * @package    ATP Divi Child
 * @subpackage ATP Divi Child/includes
 * @author     ReskatoR <plugins@reskator.fr>
 */
defined( 'ABSPATH' ) || exit;

class ATP_DC_uninstall {
	public static function uninstall() {
		delete_option( 'rr-atp-divi-child_welcome-key' );
	}
}