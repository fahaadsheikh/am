<?php
/**
 * Main Class
 *
 * @package default
 * @author Fahad Sheikh
 **/
class AMSettings {

	/**
	 * Start Up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_post_nopriv_am_clear_cache', array( $this, 'am_clear_cache' ) );
		add_action( 'admin_post_am_clear_cache', array( $this, 'am_clear_cache' ) );
		add_action( 'admin_notices', array( $this, 'show_am_cache_noticies' ) );
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {

		// This page will be under "Settings".
		$admin_page = add_menu_page(
			'Awesome Motives Settings',
			'Awesome Motives Settings',
			'manage_options',
			'am-settings-admin',
			array( $this, 'create_admin_page' ),
			plugins_url( '/am/assets/menu-icons.png' )
		);

		add_action( 'load-' . $admin_page, array( $this, 'load_admin_css' ) );
	}


	/**
	 * Load Admin CSS
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function load_admin_css() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css' ) );
	}

	/**
	 * Enqueue Admin CSS
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function enqueue_admin_css() {
		wp_enqueue_style( 'admin_css', plugin_dir_url( __FILE__ ) . 'css/am_admin_css.css', array(), '0.1' );
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		?>
		<div class="wrap" id="wp-mail-smtp">

			<div id="wp-mail-smtp-header">
				<!--suppress HtmlUnknownTarget -->
				<img class="wp-mail-smtp-header-logo" src="http://localhost/am/wp-content/plugins/am/assets/logo.svg" alt="WP Mail SMTP">
			</div>
			<div class="wp-mail-smtp-page wp-mail-smtp-page-general wp-mail-smtp-tab-settings">
										
					<div class="wp-mail-smtp-page-title">
							<a href="#" class="tab active">General</a>
							<a href="#" class="tab ">Email Test </a>
							<a href="#" class="tab ">Email Log  </a>
							<a href="#" class="tab ">Email Controls </a>
							<a href="#" class="tab ">Misc</a>
					</div>

					<div class="wp-mail-smtp-page-content">
						<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
							<h2></h2>
							<div class="wp-mail-smtp-setting-field">
								<table class="jspopulate">
								</table>
							</div>
							<p class="wp-mail-smtp-submit">
								<input type="hidden" name="action" value="am_clear_cache">
								<input type="submit" class="wp-mail-smtp-btn wp-mail-smtp-btn-md wp-mail-smtp-btn-orange am-refresh" value="Refresh">
							</p>
						</form>
					</div>
					
				</div>
			</div>
		<?php
	}

	/**
	 * Delete the stored transient
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function am_clear_cache() {
		$response = get_transient( 'api_ress' );

		if ( false === $response ) {
			$cleared = 0;
			?>
		<?php
		} else {
			delete_transient( 'api_ress' );
			$cleared = 1;
			?>
			
		<?php
		}
		wp_redirect( admin_url( 'admin.php?page=am-settings-admin&cleared=' . $cleared ) );
	}


	/**
	 * Show Admin Notices
	 *
	 * @return void
	 * @author Fahad Sheikh
	 **/
	public function show_am_cache_noticies() {

		if ( isset( $_GET['cleared'] ) && 1 == $_GET['cleared'] ) {
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_attr( 'The cache was successfuly cleared!', 'am' ); ?></p>
			</div>
		<?php
		} else {
		?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_attr( 'There was a problem please try again!', 'am' ); ?></p>
			</div>
		<?php
		}

	}

}

if ( is_admin() ) {
	new AMSettings();
}
