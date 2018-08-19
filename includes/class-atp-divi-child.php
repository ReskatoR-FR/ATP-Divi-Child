<?php defined( 'ABSPATH' ) || exit;
/**
 * Holds the ATP Divi Child Theme class
 *
 * @package ATP Divi Child Theme
 * @since 1.0
 */

if( ! class_exists( 'APT_Divi_Child') ) :
class ATP_Divi_Child {
/*
 * ATP Child Theme class
 *
 * This class contains properties and methods common to the front-end.
 *
 * @since 1.0
 */


	public $plugin_version;
	public $plugin_name;
	public $plugin_display_name;
	public $plugin_page;
	public $plugin_result = false;

	public $is_divi_installed = false;
	public $is_divi_activated = false;

	public $form_action;
	public $form_nonce;
	public $form_atp_name;
	public $form_atp_author;
	public $form_atp_author_url;
	public $form_atp_version = '1.0';
	public $form_atp_color = 'turtledove';
	public $form_atp_colors = array(
		'abricot'       => 'Apricot',
		'brown'         => 'Brown',
		'girly'         => 'Girly',
		'lagon'         => 'Lagoon',
		'navy'          => 'Navy',
		'serious'       => 'Serious',
		'sienne'        => 'Sienne',
		'sky'           => 'sky',
		'sunny'         => 'Sunny',
		'turtledove'    => 'Turtledove',
	);

	public $rr_msg = array(
		'updated' => array(),
		'notice'  => array(),
		'error'   => array(),
	); // msg

	public $gd_loaded;
	public $img_stamp_left = 'et_logo_110x50.png';
	public $img_stamp_right = 'atp_logo_208x50.png';

	/**
	 * The plugin instance.
	 *
	 * @var ATP_Divi_Child
	 */
	private static $_instance;


	/**
	 * Get the instance.
	 *
	 * @since 1.0
	 *
	 * @return ATP_Divi_Child
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		$this->_define_constants();
		$this->_define_plugin_info();
		$this->_form_init();

		$this->_plugin_init();
	}

	/**
	 * Define plugin plugin infos.
	 *
	 * @return void
	 */
	private function _define_plugin_info() {
		$plugin_info = get_file_data( ATP_DC_PLUGIN_FILE, array( 'Version' => 'Version', 'Name' => 'Plugin Name'), false );
		$this->plugin_version = $plugin_info['Version'];
		$this->plugin_display_name = $plugin_info['Name'];
		$this->plugin_name = 'rr-' . strtolower( str_replace('_', '-', get_class( $this ) ) );
		$this->plugin_db_welcome_key = $this->plugin_name . '_welcome-key';
		$plugin_css_info = get_file_data( ATP_DC_ABSPATH. 'admin/css/atp-dc-style.css', array( 'Version' => 'Version'), false );
		$this->plugin_css_version = $plugin_css_info['Version'];
		$this->gd_loaded = $this->_is_gd_loaded();
	}

	/**
	 * Define plugin constants.
	 *
	 * @return void
	 */
	private function _define_constants() {
		$this->_define( 'ATP_DC_ABSPATH', plugin_dir_path( ATP_DC_PLUGIN_FILE ) );
		$this->_define( 'ATP_DC_PLUGIN_BASENAME', plugin_basename( ATP_DC_PLUGIN_FILE ) );
		$this->_define( 'ATP_DC_CSS_URL', plugin_dir_url( ATP_DC_PLUGIN_FILE ) . 'admin/css/');
		$this->_define( 'ATP_DC_IMAGE_URL', plugin_dir_url( ATP_DC_PLUGIN_FILE ) . 'admin/images/' );
	}

	/*
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function _define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Plugin initialisation
	 *
	 * @return void
	 */
	private function _plugin_init() {
		load_plugin_textdomain( $this->plugin_name, false, dirname(ATP_DC_PLUGIN_BASENAME) . '/languages' );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_init', array( $this, 'register_plugin_css' ) ) ;
		add_action( 'admin_notices', array( $this, 'dashboard_notice' ) );
		add_action( 'wp_ajax_' . $this->plugin_name . '_dismiss-dashboard-notice', array( $this, 'dismiss_dashboard_notice' ) );
	}

	private function _form_init() {
		$this->form_action = '';
		$this->form_nonce = $this->plugin_name . '_nonce';
	}

	/**
	 * Register the plugin stylesheet.
	 */
	public function register_plugin_css() {
		wp_register_style( 'atp-dc-common-stylesheet', ATP_DC_CSS_URL . 'atp-dc-style.css', array(), $this->plugin_css_version, 'all' );
	}

	/**
	 * Register the plugin page and hook stylesheet loading
	 * @return void
	 */
	public function admin_menu() {
		$hook_page = add_submenu_page('themes.php', $this->plugin_display_name, $this->plugin_display_name, 'edit_themes', $this->plugin_name, array( $this, 'admin_panel' ) );

		add_action( 'admin_print_styles-' . $hook_page, array($this, 'plugin_admin_css' ) ) ;
		add_action( 'admin_footer-' . $hook_page, array( $this, 'change_footer_admin' ) );
	}

	/**
	 * Enqueue the plugin stylesheet.
	 *
	 * @return void
	 */
	public function plugin_admin_css() {
		wp_enqueue_style( 'atp-dc-common-stylesheet' );
	}

	public function change_footer_admin() {
		global $wp_version;
		$output = '<div id="atpfooter" role="contentinfo">';
		$output .= '<p id="atp-footer-left" class="alignleft">';
		$output .= '<span id="footer-thankyou"> Plugin réalisé pour <a href="https://www.adopte-ton-plugin.fr" target="_blank">Adopte Ton Plugin</a> par <a href="https://www.reskator.fr" target="_blank">ReskatoR</a></span>';
		$output .= '</p>';
		$output .= '<p id="atp-footer-upgrade" class="alignright">';
		$output .= '<a href="wpfr.net">WordPress</a> Version ' . $wp_version;
		$output .= '</p>';
		$output .= '<div class="clear"></div>';
		$output .= '</div>';
		echo $output;
	}

	function plugin_footer() {
		add_filter('admin_footer_text', array($this, 'change_footer_admin' ) );
	}


	/**
	 * Show relevant plugin notice.
	 *
	 * @return void
	 */
	public function dashboard_notice() {
		global $pagenow;

		$option = get_option( $this->plugin_db_welcome_key );

		if ( "yes" == $option ) :
			if ( ! ( $pagenow == 'themes.php' && isset( $_GET['page'] ) && $_GET['page'] == 'rr-atp-divi-child' ) ) :
				$this->plugin_page = admin_url( 'themes.php?page=' . $this->plugin_name );
				// load the notices view
				include_once( dirname( ATP_DC_PLUGIN_FILE )
				              . '/admin/template-dashboard-notice.php' );
			endif;
		endif;
	}

	/**
	 * Dismiss the welcome plugin notice.
	 *
	 * @return void
	 */
	public function dismiss_dashboard_notice() {
		check_ajax_referer( $this->plugin_name . '-nonce', 'nonce' );
		update_option( $this->plugin_db_welcome_key, 'no', false );
	}

	/**
	 * Output the Administration Panel
	 */
	public function admin_panel() {
		// only for an authorized user
		if ( current_user_can( 'install_themes' ) ) :
			// Form submitting
			if ( isset( $_POST[ 'submit' ] ) ) {
				// Check nonce
				if ( ! isset( $_POST[ $this->form_nonce ] ) || ! wp_verify_nonce( $_POST[$this->form_nonce], $this->plugin_name ) ) {
					$msg = __( 'Missing field ‘nonce’ : Action not performed.', 'rr-atp-divi-child' );
					$this->_set_msg( $msg, 'error');
				} elseif ( ! wp_verify_nonce( $_POST[ $this->form_nonce ], $this->plugin_name ) ) {
					$msg = __( 'Invalid nonce specified. Settings NOT saved.', 'rr-atp-divi-child' );
					$this->_set_msg( $msg,'error' );
				} else {
					switch ( $_POST[ 'action' ] ) {
						case 'donothing':
							break;
						case 'switch':
							switch_theme( 'Divi' );
							$msg = __( 'Divi’s theme was activated.', 'rr-atp-divi-child' );
							$this->_set_msg($msg, 'updated' );
							break;
						case 'create':
							$this->form_atp_name        = $_POST[ 'form_atp_name' ];;
							$this->form_atp_author      = $_POST[ 'form_atp_author' ];
							$this->form_atp_author_url  = $_POST[ 'form_atp_author_url' ];
							$this->form_atp_version     = $_POST[ 'form_atp_version' ];
							if ( $this->gd_loaded ) {
								$this->form_atp_color
									= $_POST['form_atp_color'];
							}

							if ( empty( $this->form_atp_name ) || !preg_match("/^[a-zA-Z0-9 ]{1,25}/", $this->form_atp_name) ) {
								$msg = __( 'Child theme’s Name is invalid, empty or contains too much characters (25 max).', 'rr-atp-divi-child' );
								$this->_set_msg( $msg,'error');
							} else {
								$value = trim( $this->form_atp_name );
								$this->form_atp_name = filter_var( $value, FILTER_SANITIZE_STRING );
							}

							if ( empty( $this->form_atp_author ) ) {
								$msg = __( 'Author’s Name has not been entered.', 'rr-atp-divi-child' );
								$this->_set_msg( $msg, 'notice' );
							} else {
								$value = trim( $this->form_atp_author );
								$this->form_atp_author = filter_var( $value, FILTER_SANITIZE_STRING );
							}

							if ( empty ( $this->form_atp_author_url ) ) {
								$this->form_atp_author_url = $this->_get_home_url();
								$msg = __( 'Author’s URL has not been entered.', 'rr-atp-divi-child' );
								$this->_set_msg( $msg, 'notice' );
							} else {
								$value = trim( $this->form_atp_author_url );
								if ( ! preg_match( '/^\bhttps?:\/\/.*\b/i', $value ) ) {
									$value = 'http://' . $value;
								}
								$value = filter_var( $value, FILTER_SANITIZE_URL );
								$this->form_atp_author_url = filter_var( $value, FILTER_VALIDATE_URL );
								if( wp_http_validate_url( $this->form_atp_author_url ) ) {
								} else {
									$msg = __( 'Author’s URL is invalid. It contains invalid characters or does not start by ‘http://’ or ‘https://’', 'rr-atp-divi-child' );
									$this->_set_msg( $msg, 'error' );
								}
							}
							if ( empty ( $this->form_atp_version ) ) {
								$msg = __( 'Child theme’s version has not been entered.', 'rr-atp-divi-child' );
								$this->_set_msg( $msg, 'notice');

							} else {
								$version = $this->_version_number( $this->form_atp_version );
								if ( $version ) {
									$this->form_atp_version = $version;
								} else {
									$msg = __( 'The version number is invalid… or with too many subversions.', 'rr-atp-divi-child' );
									$this->_set_msg( $msg, 'error' );
								}
							}
							if ( $this->_get_msg( 'error' ) ) {
								$msg = __( 'ERROR: Due to a problem with one of the fields, the child theme was not created.', 'rr-atp-divi-child' );
								$this->_set_msg( $msg, 'error' );
								$this->plugin_result = true;
								contine;
							} else {

								$name_sanitized = sanitize_file_name( $this->form_atp_name );
								$theme_dir = get_theme_root() . '/' . $name_sanitized;

								if ( @mkdir( $theme_dir, 0755 ) ) {
									$msg = __('The child theme’s directory has been created.', 'rr-atp-divi-child' );
									$this->_set_msg( $msg, 'notice' );
								} else {
									$msg = sprintf( __( 'Error: The child theme’s directory %s has NOT been created.', 'rr-atp-divi-child' ), $name_sanitized );
									$this->_set_msg( $msg, 'error' );
									$this->_error_end(); //on arrête là et on affiche la page de résultat
									continue;
								}

								$style_file = ATP_DC_ABSPATH . 'admin/assets/style.css';
								$functions_file = ATP_DC_ABSPATH . 'admin/assets/functions.php';
								if( file_exists( $style_file) && file_exists( $functions_file ) ) {
									$style_content = file_get_contents( $style_file );
									$themeURI = site_url() . '/' . strtolower( $name_sanitized ) . '/';
									//NextV : Ajouter la gestion des Tags, et l'ajout ou non de la license GPLv2
									$search = array(
										'%Name%',
										'%ThemeURI%',
										'%Author%',
										'%AuthorURI%',
										'%Description%',
										'%Template%',
										'%Version%',
										'%Tags%',
										'%TextDomain%',
									);
									$replace = array(
										$this->form_atp_name,
										$themeURI,
										$this->form_atp_author,
										$this->form_atp_author_url,
										'Divi child theme',
										'Divi',
										$this->form_atp_version,
										'',
										'divi-child',
									);
									$style_content = str_replace( $search, $replace, $style_content );
									$file = $theme_dir . '/style.css';
									if ( file_put_contents( $file, $style_content) ) {
										$msg = __( 'The style.css file has been created.', 'rr-atp-divi-child' );
										$this->_set_msg( $msg, 'notice' );
									} else {
										$msg = __( 'The style.css file has NOT been created.', 'rr-atp-divi-child' );
										$this->_set_msg( $msg );
										$this->_error_end(); //on arrête là et on affiche la page de résultat
										continue;
									}

									$search = array(
										'%Name%',
										'%parent_style%',
									);
									$replace = array(
										$this->form_atp_name,
										'divi-style',
									);
									$functions_content = file_get_contents( $functions_file );
									$functions_content = str_replace( $search, $replace, $functions_content );
									$file = $theme_dir . '/functions.php';
									if ( file_put_contents( $file, $functions_content ) ) {
										$msg = __( 'The functions.php file has been created.', 'rr-atp-divi-child' );
										$this->_set_msg( $msg, 'notice' );
									} else {
										$msg = __( 'The functions.php file has NOT been created.', 'rr-atp-divi-child' );
										$this->_set_msg( $msg, 'error' );
										$this->_error_end(); //on arrête là et on affiche la page de résultat
										continue;
									}
									if ( $this->gd_loaded ) {
										$this->form_atp_color = ( empty ( $this->form_atp_color ) ) ? 'turtledove' : $this->form_atp_color;
										$img_dir = ATP_DC_ABSPATH . 'admin/images/';
										$img_stamp = $img_dir . $this->img_stamp_right;
										$img_src = $img_dir . 'screenshot-' . $this->form_atp_color . '.jpg';
										$img_dest = $theme_dir . '/screenshot.png'; // First, in .png for best quality (will be converted to .jpg a bit later)
										$text = array(
											$this->form_atp_name . ' : a Divi Child Theme create by ' . $this->form_atp_author,
											15,
											25,
										);
										if ( $this->_add_stamp_to_img( $img_stamp, $img_src, $img_dest, $text ) ) {
											$msg = __( 'The image file has been created.', 'rr-atp-divi-child' );
											$this->_set_msg( $msg, 'notice' );
										} else {
											$msg = __( 'The image could not be created, but it does not matter: the child theme is operational.', 'rr-atp-divi-child' );
											$this->_set_msg( $msg, 'notice' );
										}
										if( file_exists( $img_dest ) ) {
											if ( $this->_png2jpeg( $img_dest, 99, true ) ) {
												$msg =__( 'The size image has been compressed.', 'rr-atp-divi-child' );
												$this->_set_msg( $msg, 'notice' );
											}
										}
									}
								}
								else {
									$msg = __( 'ERROR: It seems that some files are missing. Thank you to reinstall the plugin.');
									$this->_set_msg( $msg, 'error' );
								}

								$this->_set_form_action( array( 'action'=> 'activate' ) );
								$this->plugin_result = true;
							}
						break;
						case 'activate':
							//$child = trim( str_replace( ' ', '-', $_POST[ 'child' ] ) );
							//switch_theme( $_POST[ $child ] );
							$redirect = admin_url( 'themes.php');
							wp_redirect( $redirect );
							exit();
						default:
					} // end switch
				}
			} // end Form Submit

			//update_option( $this->plugin_db_welcome_key, 'no', false ); // Hide welcome notice if user doesn't do

			if ( $this->plugin_result ) {
				require_once( dirname( ATP_DC_PLUGIN_FILE ) . '/admin/template-admin-result.php' );
			}
			else {

				$themes = wp_get_themes( array('Name','Version', 'ThemeURI' ) );
				foreach ( $themes as $theme ) {
					if ( 'Divi' == $theme['Name'] ) {
						$this->is_divi_installed = true;
					};
				}
				unset($themes, $theme); // Frees memory

				$current_theme = wp_get_theme();
				if( 'Divi' == $current_theme ) {
					$this->is_divi_activated = true;
					$this->_set_form_action( array( 'action'=> 'create' ) );
				} else {
					$this->_set_form_action( array( 'action'=> 'switch' ) );
				}

				if ( $this->is_divi_activated ) {
					$current_user = wp_get_current_user();
					if ( ! ( $current_user instanceof WP_User ) ) {
						return;
					}

					// Child theme's name field
					$this->form_atp_name = get_bloginfo( 'name' );

					// Author field
					if ( ! empty ( $current_user->user_firstname ) && ! empty ( $current_user->user_lastname )
					) {
						$this->form_atp_author = $current_user->user_firstname . ' ' . $current_user->user_lastname;
					} elseif ( ! empty ( $current_user->display_name ) ) {
						$this->form_atp_author = $current_user->display_name;
					} else {
						$this->form_atp_author = $current_user->user_login;
					}

					// Author url field
					$this->form_atp_author_url = $this->_get_home_url();
				}

				require_once( dirname( ATP_DC_PLUGIN_FILE ) . '/admin/template-admin-panel.php' );
			}
		else :
			printf( '<p>' . __( 'Sorry, you are not allowed to access this page. Return to <a href="%s">Home</a>', 'rr-atp-divi-child' ) . '</p>', $this->_get_home_url() );
		endif;
	}

	private function _set_form_action($query = '') {
		$form_action = $this->_get_current_url( $query );

		if( ! empty( $query ) ) {
			$form_action .= '';
		}

		$this->form_action = esc_url( $form_action );
	}

	private static function _get_current_url( $query = '' ) {
		$url = remove_query_arg( array( 'action' ), false );
		if ( ! empty( $query ) ) {
			$result = wp_parse_args( $query );
			foreach ( $result as $key => $value ) {
				// if space, encode it !
				if ( strpos( $value, ' ' ) !== false )
					$result[ $key ] = rawurlencode( $value );
			}
			$url = add_query_arg( $result, $url );
		}

		return $url;
	}

	private function _get_home_url() {
		return untrailingslashit(network_site_url( '/' ) );
	}

	private function _set_msg( $msg, $type = 'info' ) {
		$this->rr_msg[ $type ][] = $msg;
	}

	private function _get_msg($type = 'notice' ) {
		$msg = '';
		$nb_msg = count($this->rr_msg[ $type ] );
		if ( $nb_msg ) {
			$msg = ( $type == 'notice' ) ? '<p>' . __('For your information:', 'rr-atp-divi-child') . '</p>' : '';
			$i = 0;
			foreach ( $this->rr_msg[ $type ] as $value ) {
				$i++;
				$msg .= ( $type == 'notice') ? '• '. $value : $value;
				if ( $i < $nb_msg ) {
					$msg .= '<br/>';
				}
			}
		}

		return $msg;
	}

	private function _version_number( $string, $sub = '' ) {
		if ( empty( $string ) ) {
			return false;
		}
		// {0,2} : until 2 subversions => v1.2.3. If need more, use $sub
		$pattern = "/^(?:(\d+)\.){0,2}(\*|\d+)$/";
		if ( ! empty( $sub ) ) {
			$pattern = str_replace('2', $sub, $pattern );
		}

		// Normalize
		$search = array(',', '-', '_');
		$replace = '.';
		$version = str_replace($search, $replace, $string);

		if ( preg_match( $pattern, $version , $matches ) ) {
			return $matches[0];
		}
	}

	private function _error_end( $action = 'donothing') {
		$this->_set_form_action( array( 'action', $action ) );
		$this->plugin_result = true;
	}

	private function _add_stamp_to_img ( $img_stamp = '', $img_src = '', $img_dest = '', $text = array() ) {
		$result = true;
		if ( empty( $img_stamp ) ) {
			return false;
		}
		if( empty( $img_dest ) ) {
			$img_dest = dirname( $img_src ) . '/myimage.jpg';
		}

		$img = $this->_create_ressource_image( $img_src); // Function to create a ressource image

		// Get size image
		$img_width = imagesx( $img );
		$img_height = imagesy( $img );

		$stamp = $this->_create_ressource_image( $img_stamp ); // Call a function to create a ressource image
		$stamp_width = imagesx( $stamp );
		$stamp_height = imagesy( $stamp );

		imagecopy( $img, $stamp, $img_width - ($stamp_width + 15),  15, 0, 0, $stamp_width, $stamp_height );

		// Frees memory
		imagedestroy( $stamp);

		// Draw a gray rectangle at the bottom
		$gray = imagecolorallocate( $img, 128, 128, 128);
		imagefilledrectangle($img, 0, $img_height - 40, $img_width, $img_height, $gray);

		// Add a white text
		list($text, $text_pos_x, $text_pos_y ) = $text;

		$white = imagecolorallocate( $img, 255, 255, 255 );
		imagestring($img, 5, $text_pos_x, $img_height - $text_pos_y, $text, $white);

		// Create and save image
		if ( ! imagepng( $img, $img_dest, 9, NULL ) ) {
			$result = false;
		};

		sleep(1); // Wait 1 second to write the file on disk, before the next action

		imagedestroy( $img ); // Frees memory

		Return $result;
	}

	private function _png2jpeg ( $img_path, $quality = 75, $delete_img = false ) {
		$result = NULL;
		$path_parts = pathinfo( $img_path );
		$img_dest = $path_parts['dirname'] . '/' . $path_parts['filename'] .'.jpg';

		$img = $this->_create_ressource_image( $img_path );
		$result = ( imagejpeg( $img, $img_dest, $quality ) ) ? true : false;

		if ( $delete_img ) {
			unlink( $img_path );
		}

		imagedestroy($img); // Frees memory

		Return $result;
	}

	private function _create_ressource_image( $img_path, $width = 880, $height = 660 ) {
		$img_info = getimagesize( $img_path );

		switch ($img_info[2]) {
			case 1 : // gif
				$img = imagecreatefromgif( $img_path );
				break;
			case 2 : // jpeg
				$img = imagecreatefromjpeg( $img_path );
				break;
			case 3 : // png
				$img = imagecreatefrompng( $img_path );
				break;
			case 6 : // bmp
				$img = imagecreatefrombmp( $img_path );
				break;
			default : // Créer une image vierge
				$img =  @imagecreatetruecolor( $width, $height )
				or die('Impossible de créer un flus d’image GD');
		}

		return $img;
	}

	private function _is_gd_loaded() {
		Return (extension_loaded( 'gd' ) ) ? true : false;
	}
}
endif; // endif class_exists()
