<?php
/**
 * Core class.
 *
 * @package 	Leverage Browser Caching
 */

if ( ! class_exists( 'Lbrowserc_Core' ) ) {
	/**
	 * Core class of plugin.
	 */
	class Lbrowserc_Core {

		/**
		 * Store htaccess_file, used to store path of htaccess file.
		 *
		 * @var string
		 */
		public $htaccess_file;

		/**
		 * Store unique_string, used to identify codes in htaccess file.
		 *
		 * @var string
		 */
		public $unique_string;

		/**
		 * Store htaccess_cntn, used to store htaccess file content.
		 *
		 * @var string
		 */
		public $htaccess_cntn;

		/**
		 * Store valid, use to check true false.
		 *
		 * @var bool
		 */
		public $valid;

		/**
		 * Store pattern, used to remove plugin code from htaccess file.
		 *
		 * @var string
		 */
		public $pattern;

		/**
		 * Store message, used to add admin notice etc.
		 *
		 * @var string
		 */
		public $message;

		/**
		 * Store plugin action link.
		 *
		 * @var string
		 */
		public $custom_link;

		/**
		 * This will add code, if not found. and also call deactivation_hook
		 */
		public function __construct() {

			$this->htaccess_file = wp_normalize_path( ABSPATH . '.htaccess' );

			// Go ahead, if file exist.
			if ( file_exists( $this->htaccess_file ) ) {

				// Go ahead, if file readable and writable.
				if ( is_readable( $this->htaccess_file ) && is_writable( $this->htaccess_file ) ) {

					// Check if code already present in htaccess.
					$this->unique_string 	= 'LBROWSERCSTART';
					$this->htaccess_cntn 	= file_get_contents( $this->htaccess_file );
					$this->valid 			= false;

					if ( strpos( $this->htaccess_cntn, $this->unique_string ) !== false ) {
						$this->valid = true;
					}

					if ( ! $this->valid ) {
						// Code does not have in htaccess file. let add them.
						// Present code + plugin code.
						$this->htaccess_cntn = $this->htaccess_cntn . $this->code_to_add();

						file_put_contents( $this->htaccess_file, $this->htaccess_cntn );
						// Welcome.
					}
				} else {
					add_action( 'admin_notices', array( $this, 'no_htaccess_access_notice' ) );
				}
			} else {
				add_action( 'admin_notices', array( $this, 'no_htaccess_notice' ) );
			}

			register_deactivation_hook( LBROWSERC_FILE, array( $this, 'remove_code' ) );

			if( get_stylesheet() == 'seopress' || get_stylesheet() == 'seopress-child' ) {
				//nothing to do.
			} else {
				// Add action link.
				add_filter( 'plugin_action_links_' . LBROWSERC_BASE_FILE, array( $this, 'plugin_action_links' ), 10, 4 );
				// Add notice.
				add_action( 'admin_notices', array( $this, 'admin_notice' ) );
				// Handle notice.
				add_action( 'admin_init', array( $this, 'handle_notic' ) );
				// On theme switch, delete stored user meta called lbrowserc_ignore_notice.
				add_action( 'switch_theme', array( $this, 'del_um_on_theme_switch' ) );
				// On plugin deactivation, delete stored user meta called lbrowserc_ignore_notice.
				register_deactivation_hook( LBROWSERC_FILE, array( $this, 'del_um_on_theme_switch' ) );
			}
		}

		/**
		 * This will remove code form htaccess, if found.
		 */
		public function remove_code() {

			$this->htaccess_file = wp_normalize_path( ABSPATH . '.htaccess' );

			// Go ahead, if file exist.
			if ( file_exists( $this->htaccess_file ) ) {

				// Go ahead, if file readable and writable.
				if ( is_readable( $this->htaccess_file ) && is_writable( $this->htaccess_file ) ) {

					// Check if code already present.
					$this->unique_string 	= 'LBROWSERCSTART';
					$this->htaccess_cntn 	= file_get_contents( $this->htaccess_file );
					$this->valid 			= false;

					if ( strpos( $this->htaccess_cntn, $this->unique_string ) !== false ) {
						$this->valid = true;
					}

					if ( $this->valid ) {

						// Code found, remove them.
						$this->pattern 			= '/#\s?LBROWSERCSTART.*?LBROWSERCEND/s';
						$this->htaccess_cntn 	= preg_replace( $this->pattern, '', $this->htaccess_cntn );
						$this->htaccess_cntn 	= preg_replace( "/\n+/","\n", $this->htaccess_cntn );

						file_put_contents( $this->htaccess_file, $this->htaccess_cntn );
						// Bye Bye.
					}
				} else {
					// Note: no_htaccess_access_notice.
				}
			} else {
				// Note: no_htaccess_notice.
			}
		}

		/**
		 * Codes to be add.
		 */
		public function code_to_add() {
			$this->htaccess_cntn  = "\n";
			$this->htaccess_cntn .= '# LBROWSERCSTART Browser Caching' . "\n";
			$this->htaccess_cntn .= '<IfModule mod_expires.c>' . "\n";
			$this->htaccess_cntn .= 'ExpiresActive On' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType image/gif "access 1 year"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType image/jpg "access 1 year"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType image/jpeg "access 1 year"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType image/png "access 1 year"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType image/x-icon "access 1 year"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType text/css "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType text/javascript "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType text/html "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType application/javascript "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType application/x-javascript "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType application/xhtml-xml "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType application/pdf "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresByType application/x-shockwave-flash "access 1 month"' . "\n";
			$this->htaccess_cntn .= 'ExpiresDefault "access 1 month"' . "\n";
			$this->htaccess_cntn .= '</IfModule>' . "\n";
			$this->htaccess_cntn .= '# END Caching LBROWSERCEND' . "\n";

			return $this->htaccess_cntn;
		}

		/**
		 * If htaccess is not exists.
		 */
		public function no_htaccess_notice() {
			$this->message = '<div class="error"><p>';
			$this->message .= __( 'Plugin Leverage Browser Caching: htaccess file not found. This plugin works only on Apache server. If you are using Apace server, please create it.', 'lbrowserc' );
			$this->message .= '</p></div>';
			echo wp_kses_post( $this->message );
		}

		/**
		 * If htaccess is not access able.
		 */
		public function no_htaccess_access_notice() {
			$this->message = '<div class="error"><p>';
			$this->message .= __( 'Plugin Leverage Browser Caching: htaccess file is not readable or writable. Please change permission of htaccess file.', 'lbrowserc' );
			$this->message .= '</p></div>';
			echo wp_kses_post( $this->message );
		}

		/**
		 * Call back for action link.
		 *
		 * @param array links.
		 */
		public function plugin_action_links( $links ) {
			$this->custom_link = '<a title="A SEO Friendly Theme" href="theme-install.php?search=seopress">Try SEOPress Theme</a>';
			array_unshift( $links, $this->custom_link );
			return $links;
		}

		/**
		 * [admin_notice description]
		 * @return [type] [description]
		 */
		public function admin_notice() {
			global $current_user ;
			$user_id = $current_user->ID;

			// Check that the user hasn't already clicked to ignore the message.
			if( ! get_user_meta( $user_id, 'lbrowserc_ignore_notice' ) ) {
				echo '<div class="updated"><p>';
				printf( 'Recommended: SEOPress Theme, A SEO Friendly Theme <a href="%1$s">Try it for Free</a> | <a href="%2$s">No, Thanks</a>', esc_url( get_admin_url() . 'theme-install.php?search=seopress' ), '?lbrowserc_notics_ignore=0' );
				echo "</p></div>";
			}
		}

		/**
		 * [handle_notic description]
		 * @return [type] [description]
		 */
		public function handle_notic() {
			global $current_user;
			$user_id = $current_user->ID;

			if( isset( $_GET['lbrowserc_notics_ignore'] ) && '0' == $_GET['lbrowserc_notics_ignore'] ) {
				add_user_meta( $user_id, 'lbrowserc_ignore_notice', 'true', true );
			}
		}

		/**
		 * [del_um_on_theme_switch description]
		 * @return [type] [description]
		 */
		public function del_um_on_theme_switch() {
			global $current_user;
			$user_id = $current_user->ID;
			
			if( get_user_meta( $user_id, 'lbrowserc_ignore_notice' ) ) {
				delete_user_meta( $user_id, 'lbrowserc_ignore_notice' );
			}
		}
	}
} // End if().
