<?php
/**
 * An extension for the Connections plugin which adds login content box and a widget for a single entry page.
 *
 * @package   Connections Login
 * @category  Extension
 * @author    Steven A. Zahm
 * @license   GPL-2.0+
 * @link      http://connections-pro.com
 * @copyright 2014 Steven A. Zahm
 *
 * @wordpress-plugin
 * Plugin Name:       Connections Login
 * Plugin URI:        http://connections-pro.com
 * Description:       An extension for the Connections plugin which adds login content box and a widget for a single entry page.
 * Version:           1.1
 * Author:            Steven A. Zahm
 * Author URI:        http://connections-pro.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       connections_login
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists('Connections_Login') ) {

	class Connections_Login {

		// Define version.
		const VERSION = '1.1';

		public function __construct() {

			self::defineConstants();
			self::loadDependencies();

			// This should run on the `plugins_loaded` action hook. Since the extension loads on the
			// `plugins_loaded action hook, call immediately.
			self::loadTextdomain();

			// Add the business hours option to the admin settings page.
			// This is also required so it'll be rendered by $entry->getContentBlock( 'login_form' ).
			add_filter( 'cn_content_blocks', array( __CLASS__, 'settingsOption') );

			// Add the action that'll be run when calling $entry->getContentBlock( 'login_form' ) from within a template.
			add_action( 'cn_entry_output_content-login_form', array( __CLASS__, 'block' ), 10, 3 );

			// Register the widget.
			add_action( 'widgets_init', create_function( '', 'register_widget( "CN_Login_Form_Widget" );' ) );

			// Register the shortcode.
			add_shortcode( 'connections_login', array( __CLASS__, 'shortcode' ) );
		}

		/**
		 * Define the constants.
		 *
		 * @access  private
		 * @static
		 * @since  1.0
		 *
		 * @return void
		 */
		private static function defineConstants() {

			define( 'CNL_DIR_NAME', plugin_basename( dirname( __FILE__ ) ) );
			define( 'CNL_BASE_NAME', plugin_basename( __FILE__ ) );
			define( 'CNL_PATH', plugin_dir_path( __FILE__ ) );
			define( 'CNL_URL', plugin_dir_url( __FILE__ ) );
		}

		/**
		 * The widget.
		 *
		 * @access private
		 * @since  1.0
		 * @static
		 *
		 * @return void
		 */
		private static function loadDependencies() {

			require_once( CNL_PATH . 'includes/class.widgets.php' );
		}

		/**
		 * Load the plugin translation.
		 *
		 * Credit: Adapted from Ninja Forms / Easy Digital Downloads.
		 *
		 * @access private
		 * @since  1.0
		 * @static
		 *
		 * @uses   apply_filters()
		 * @uses   get_locale()
		 * @uses   load_textdomain()
		 * @uses   load_plugin_textdomain()
		 */
		public static function loadTextdomain() {

			// Plugin textdomain. This should match the one set in the plugin header.
			$domain = 'connections_login';

			// Set filter for plugin's languages directory
			$languagesDirectory = apply_filters( "{$domain}_directory", CNL_DIR_NAME . '/languages/' );

			// Traditional WordPress plugin locale filter
			$locale   = apply_filters( 'plugin_locale', get_locale(), $domain );
			$fileName = sprintf( '%1$s-%2$s.mo', $domain, $locale );

			// Setup paths to current locale file
			$local  = $languagesDirectory . $fileName;
			$global = WP_LANG_DIR . "/{$domain}/" . $fileName;

			if ( file_exists( $global ) ) {

				// Look in global `../wp-content/languages/{$languagesDirectory}/` folder.
				load_textdomain( $domain, $global );

			} elseif ( file_exists( $local ) ) {

				// Look in local `../wp-content/plugins/{plugin-directory}/languages/` folder.
				load_textdomain( $domain, $local );

			} else {

				// Load the default language files
				load_plugin_textdomain( $domain, false, $languagesDirectory );
			}
		}

		/**
		 * Add the custom meta as an option in the content block settings in the admin.
		 * This is required for the output to be rendered by $entry->getContentBlock().
		 *
		 * @access private
		 * @since  1.0
		 * @static
		 * @param  array  $blocks An associtive array containing the registered content block settings options.
		 *
		 * @return array
		 */
		public static function settingsOption( $blocks ) {

			$blocks['login_form'] = 'Login Form';

			return $blocks;
		}

		/**
		 * Echos or returns the core WP login form.
		 *
		 * @access private
		 * @since  1.0
		 * @static
		 * @uses   wp_login_form()
		 * @param  array  $atts An associative array passed to wp_login_form()
		 *
		 * @return string
		 */
		public static function loginForm( $atts = array() ) {

			$defaults = array(
				'echo'           => TRUE,
				'redirect'       => get_permalink(),
				'form_id'        => 'loginform',
				'label_username' => __( 'Username', 'connections_login' ),
				'label_password' => __( 'Password', 'connections_login' ),
				'label_remember' => __( 'Remember Me', 'connections_login' ),
				'label_log_in'   => __( 'Login', 'connections_login' ),
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'remember'       => TRUE,
				'value_username' => NULL,
				'value_remember' => FALSE,
			);

			$atts = shortcode_atts( $defaults, $atts, 'connections_login' );

			return wp_login_form( $atts );
		}

		/**
		 * Callback function run when using the shortcode.
		 *
		 * @access private
		 * @since  1.0
		 * @static
		 * @uses   self::loginForm()
		 * @param  array  $atts    The shortcode attributes array.
		 * @param  string $content
		 * @param  string $tag     The shortcode tag.
		 *
		 * @return string
		 */
		public static function shortcode( $atts, $content = '', $tag = 'connections_login' ) {

			if ( is_user_logged_in() ) return;

			// The wp_login_form() must return the form in shortcodes.
			$atts['echo'] = FALSE;

			return self::loginForm( $atts );
		}

		/**
		 * Renders the login form content block.
		 *
		 * Called by the cn_meta_output_field-login_form action in cnOutput->getMetaBlock().
		 *
		 * @access  private
		 * @since  1.0
		 * @static
		 * @uses   self::loginForm()
		 * @param  object $entry          An instance of the cnEntry object.
		 * @param  object $shortcode_atts The shortcode $atts array.
		 * @param  array  $template       An instance of the cnTemplate object.
		 *
		 * @return string
		 */
		public static function block( $entry, $shortcode_atts = array(), $template = FALSE ) {

			if ( is_user_logged_in() ) return;

			// The wp_login_form() must echo the form in the content block.
			$shortcode_atts['echo'] = TRUE;

			self::loginForm( $shortcode_atts );
		}

	}

	/**
	 * Start up the extension.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @return mixed object | bool
	 */
	function Connections_Login() {

			if ( class_exists('connectionsLoad') ) {

					return new Connections_Login();

			} else {

				add_action(
					'admin_notices',
					 create_function(
						 '',
						'echo \'<div id="message" class="error"><p><strong>ERROR:</strong> Connections must be installed and active in order use Connections Login.</p></div>\';'
						)
				);

				return FALSE;
			}
	}

	/**
	 * Since Connections loads at default priority 10, and this extension is dependent on Connections,
	 * we'll load with priority 11 so we know Connections will be loaded and ready first.
	 */
	add_action( 'plugins_loaded', 'Connections_Login', 11 );

}
