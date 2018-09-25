<?php

/**
 * Class WP_Hummingbird_Dashboard_Page.
 */
class WP_Hummingbird_Dashboard_Page extends WP_Hummingbird_Admin_Page {

	/**
	 * Uptime report.
	 *
	 * @since 1.7.0
	 * @var   array $uptime_report
	 */
	private $uptime_report = array();

	/**
	 * Function triggered when the page is loaded
	 * before render any content
	 */
	public function on_load() {
		if ( is_multisite() && ! is_network_admin() ) {
			/* @var WP_Hummingbird_Module_Minify $minify_module */
			$minify_module = WP_Hummingbird_Utils::get_module( 'minify' );

			if ( ! $minify_module->scanner->is_scanning() ) {
				$minify_module->scanner->finish_scan();
			}
		}

		if ( isset( $_GET['wphb-clear-files'] ) && current_user_can( WP_Hummingbird_Utils::get_admin_capability() ) ) {
			check_admin_referer( 'wphb-clear-files' );

			if ( WP_Hummingbird_Utils::can_execute_php() ) {
				/* @var WP_Hummingbird_Module_Minify $minify_module */
				$minify_module = WP_Hummingbird_Utils::get_module( 'minify' );
				if ( $minify_module->is_active() ) {
					$minify_module->clear_files();
				}
			}

			/* @var WP_Hummingbird_Module_GZip $gzip_module */
			$gzip_module = WP_Hummingbird_Utils::get_module( 'gzip' );
			if ( $gzip_module->is_active() ) {
				$gzip_module->clear_cache();
			}
			/* @var WP_Hummingbird_Module_Page_Cache $pc_module */
			$pc_module = WP_Hummingbird_Utils::get_module( 'page_cache' );
			if ( $pc_module->is_active() ) {
				$pc_module->clear_cache();
			}
			/* @var WP_Hummingbird_Module_Gravatar $gc_module */
			$gc_module = WP_Hummingbird_Utils::get_module( 'gravatar' );
			if ( $gc_module->is_active() ) {
				$gc_module->clear_cache();
			}
			$url = remove_query_arg( array( 'wphb-clear-files', 'updated', '_wpnonce' ) );

			/* @var WP_Hummingbird_Module_Cloudflare $cf_module */
			$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
			if ( $cf_module->is_active() ) {
				$cf_module->clear_cache();
				wp_safe_redirect( add_query_arg( 'wphb-cache-cleared-with-cloudflare', 'true', $url ) );
			} else {
				wp_safe_redirect( add_query_arg( 'wphb-cache-cleared', 'true', $url ) );
			}
			exit;
		}
	}

	/**
	 * Overwrites parent class render_header method.
	 *
	 * Renders the template header that is repeated on every page.
	 * From WPMU DEV Dashboard
	 */
	public function render_header() {
		$clear_cache_url = add_query_arg( 'wphb-clear-files', 'true' );
		$clear_cache_url = wp_nonce_url( $clear_cache_url, 'wphb-clear-files' );

		if ( isset( $_GET['wphb-cache-cleared'] ) ) {
			$this->admin_notices->show( 'updated', __( 'Your cache has been successfully cleared. Your assets will regenerate the next time someone visits your website.', 'wphb' ), 'success', true );
		}

		if ( isset( $_GET['wphb-cache-cleared-with-cloudflare'] ) ) {
			$this->admin_notices->show( 'updated', __( 'Your local and Cloudflare caches have been successfully cleared. Your assets will regenerate the next time someone visits your website.', 'wphb' ), 'success', true );
		}
		$tooltip = '';
		$modules = WP_Hummingbird_Utils::get_active_cache_modules();
		$show_clear_cache = false;
		if ( count( $modules ) > 0 ) {
			$show_clear_cache = true;
			if ( count( $modules ) === 1 ) {
				/* translators: %s: module name. */
				$tooltip = sprintf( __( 'This will clear your %s cache', 'wphb' ), array_pop( $modules ) );
			} else {
				$last = array_pop( $modules );
				$module_names = implode( ', ', $modules ) . ' & ' . $last;
				/* translators: %s: module name. */
				$tooltip = sprintf( __( 'This will clear your %s caches', 'wphb' ), $module_names );
			}
		}
		?>
		<div class="wphb-notice wphb-notice-success wphb-dash-settings-updated" id="wphb-notice-settings-updated" style="display: none">
			<p><?php esc_html_e( 'Settings Updated', 'wphb' ); ?></p>
		</div>
		<section id="header">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<div class="actions">
				<?php if ( $show_clear_cache ) { ?>
					<a href="<?php echo esc_url( $clear_cache_url ); ?>" class="button button-grey tooltip-l tooltip-bottom" tooltip="<?php echo esc_attr( $tooltip ); ?>" aria-hidden="true">
						<?php esc_html_e( 'Clear Cache', 'wphb' ); ?>
					</a>
				<?php } ?>
				<a href="<?php echo esc_url( WP_Hummingbird_Utils::get_documentation_url( $this->slug, $this->get_current_tab() ) ); ?>" target="_blank" class="button button-ghost documentation-button">
					<?php esc_html_e( 'View Documentation', 'wphb' ); ?>
				</a>
			</div>
		</section><!-- end header -->
		<?php
	}

	/**
	 * Run Performance, Asset optimization, Uptime...
	 *
	 * @param string $type  Action type.
	 */
	private function run_actions( $type ) {
		check_admin_referer( 'wphb-run-dashboard' );

		if ( ! current_user_can( WP_Hummingbird_Utils::get_admin_capability() ) ) {
			return;
		}

		/* @var WP_Hummingbird_Module_Uptime $uptime */
		$uptime = WP_Hummingbird_Utils::get_module( 'uptime' );

		// Check if Uptime is active in the server.
		if ( WP_Hummingbird_Module_Uptime::is_remotely_enabled() ) {
			$uptime->enable_locally();
		} else {
			$uptime->disable_locally();
		}

		if ( 'performance' === $type ) {
			// Start performance test.
			/* @var WP_Hummingbird_Module_Performance $perf_module */
			$perf_module = WP_Hummingbird_Utils::get_module( 'performance' );
			$perf_module->init_scan();

			wp_safe_redirect( remove_query_arg( array( 'run', '_wpnonce' ), WP_Hummingbird_Utils::get_admin_menu_url( 'performance' ) ) );
			exit;
		}

		if ( 'minification' === $type ) {
			/* @var WP_Hummingbird_Module_Minify $minify_module */
			$minify_module = WP_Hummingbird_Utils::get_module( 'minify' );
			$minify_module->init_scan();

			wp_safe_redirect( remove_query_arg( array( 'run', '_wpnonce' ), WP_Hummingbird_Utils::get_admin_menu_url( 'minification' ) ) );
			exit;
		}

		if ( 'uptime' === $type ) {
			// Uptime reports.
			$uptime->get_last_report( 'week', true );
			wp_safe_redirect( remove_query_arg( array( 'run', '_wpnonce' ) ) );
			exit;
		}

	}

	/**
	 * Register available metaboxes on the Dashboard page.
	 */
	public function register_meta_boxes() {
		if ( isset( $_GET['run'] ) && isset( $_GET['type'] ) ) {
			$this->run_actions( $_GET['type'] );
		}

		$this->add_meta_box( 'dashboard/welcome', null , array( $this, 'dashboard_welcome_metabox' ), null, null, 'main', array(
			'box_class' => 'dev-box content-box content-box-two-cols-image-left',
		));

		$last_report = WP_Hummingbird_Module_Performance::get_last_report();

		// Check to see if there's a fresh report on the server (but don't update it on quick setup dialog).
		$quick_setup = get_option( 'wphb-quick-setup' );
		if ( false === $last_report && true === $quick_setup['finished'] ) {
			WP_Hummingbird_Module_Performance::refresh_report();
			$last_report = WP_Hummingbird_Module_Performance::get_last_report();
		}

		$report_dismissed = WP_Hummingbird_Module_Performance::report_dismissed();
		if ( WP_Hummingbird_Module_Performance::is_doing_report() ) {
			$this->add_meta_box( 'dashboard/performance/running-test', __( 'Performance test in progress', 'wphb' ), null, null, null, 'box-dashboard-left' );
		} elseif ( ! WP_Hummingbird_Module_Performance::is_doing_report() && $last_report && ! is_wp_error( $last_report ) && ! $report_dismissed ) {
			$this->add_meta_box(
				'dashboard-performance-module',
				__( 'Performance Report', 'wphb' ),
				array( $this, 'dashboard_performance_module_metabox' ),
				array( $this, 'dashboard_performance_module_metabox_header' ),
				array( $this, 'dashboard_performance_module_metabox_footer' ),
				'box-dashboard-left',
				array(
					'box_content_class' => 'box-content no-padding',
				)
			);
		} elseif ( is_wp_error( $last_report ) ) {
			$this->add_meta_box(
				'dashboard-performance-module-error',
				__( 'Performance Report', 'wphb' ),
				array( $this, 'dashboard_performance_module_error_metabox' ),
				null,
				null,
				'box-dashboard-left',
				array(
					'box_class' => 'dev-box content-box content-box-one-col-center',
				)
			);
		} elseif ( $report_dismissed ) {
			$this->add_meta_box(
				'dashboard-performance-module',
				__( 'Performance Report', 'wphb' ),
				array( $this, 'dashboard_performance_module_metabox_dismissed' ),
				array( $this, 'dashboard_performance_module_metabox_header' ),
				array( $this, 'dashboard_performance_module_metabox_footer' ),
				'box-dashboard-left',
				array(
					'box_class' => 'dev-box content-box content-box-one-col-center',
				)
			);
		} else {
			$this->add_meta_box(
				'dashboard-performance-disabled',
				__( 'Performance Report', 'wphb' ),
				array( $this, 'dashboard_performance_disabled_metabox' ),
				null,
				null,
				'box-dashboard-left',
				array(
					'box_class' => 'dev-box content-box content-box-one-col-center',
				)
			);
		} // End if().

		/* Page caching */
		/* @var WP_Hummingbird_Module_Page_Cache $module */
		$module = WP_Hummingbird_Utils::get_module( 'page_cache' );
		$footer = null;
		if ( $module->is_active() ) {
			$footer = array( $this, 'dashboard_page_caching_module_metabox_footer' );
		}
		$this->add_meta_box(
			'dashboard-caching-page-module',
			__( 'Page Caching', 'wphb' ),
			array( $this, 'dashboard_page_caching_module_metabox' ),
			null,
			$footer,
			'box-dashboard-left'
		);

		/* Browser caching */
		$browser_caching_args = array(
			'box_content_class' => 'box-content no-background-image',
		);
		/** @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
		if ( ! ( $cf_module->is_connected() && $cf_module->is_zone_selected() ) ) {
			if ( ! get_site_option( 'wphb-cloudflare-dash-notice' ) && 'dismissed' !== get_site_option( 'wphb-cloudflare-dash-notice' ) ) {
				$browser_caching_args = array();
			}
		}

		$this->add_meta_box(
			'dashboard-browser-caching-module',
			__( 'Browser Caching', 'wphb' ),
			array( $this, 'dashboard_browser_caching_module_metabox' ),
			array( $this, 'dashboard_browser_caching_module_metabox_header' ),
			array( $this, 'dashboard_browser_caching_module_metabox_footer' ),
			'box-dashboard-left',
			$browser_caching_args
		);

		/* Gravatar caching */
		/* @var WP_Hummingbird_Module_Gravatar $module */
		$module = WP_Hummingbird_Utils::get_module( 'gravatar' );
		$footer = null;
		if ( $module->is_active() ) {
			$footer = array( $this, 'dashboard_gravatar_caching_module_metabox_footer' );
		}
		$this->add_meta_box(
			'dashboard-caching-gravatar-module',
			__( 'Gravatar Caching', 'wphb' ),
			array( $this, 'dashboard_gravatar_caching_module_metabox' ),
			null,
			$footer,
			'box-dashboard-left'
		);

		/* GZIP */
		$this->add_meta_box(
			'dashboard-gzip-module',
			__( 'GZIP Compression', 'wphb' ),
			array( $this, 'dashboard_gzip_module_metabox' ),
			array( $this, 'dashboard_gzip_module_metabox_header' ),
			array( $this, 'dashboard_gzip_module_metabox_footer' ),
			'box-dashboard-right'
		);

		/* Asset Optimization */
		if ( ! WP_Hummingbird_Utils::can_execute_php() ) {
			$this->add_meta_box( 'dashboard/minification/cant-execute-php', __( 'Asset Optimization', 'wphb' ), null, null, null, 'box-dashboard-right', array(
				'box_class' => 'dev-box content-box content-box-one-col-center',
			) );
		} elseif ( is_multisite() && is_network_admin() ) {
			// Asset optimization metabox is different on network admin
			$this->add_meta_box( 'dashboard/minification/network-module', __( 'Asset Optimization', 'wphb' ), array( $this, 'dashboard_minification_network_module_metabox' ), null, null, 'box-dashboard-right', array(
				'box_class' => 'dev-box content-box content-box-one-col-center',
			) );
		} else {
			/* @var WP_Hummingbird_Module_Minify $module */
			$module = WP_Hummingbird_Utils::get_module( 'minify' );
			$collection = $module->get_resources_collection();

			if ( ( ! empty( $collection['styles'] ) || ! empty( $collection['scripts'] ) ) && ( $module->is_active() ) ) {
				$this->add_meta_box(
					'dashboard/minification-module',
					__( 'Asset Optimization', 'wphb' ),
					array( $this, 'dashboard_minification_module_metabox' ),
					null,
					array( $this, 'dashboard_minification_module_metabox_footer' ),
					'box-dashboard-right'
				);
			} else {
				$this->add_meta_box( 'dashboard/minification-disabled', __( 'Asset Optimization', 'wphb' ), array( $this, 'dashboard_minification_disabled_metabox' ), null, null, 'box-dashboard-right', array(
					'box_class' => 'dev-box content-box content-box-one-col-center',
				) );
			}
		}

		/* Advanced tools */
		// At the moment advanced tools is only for non network installs.
		if ( ! is_multisite() ) {
			$this->add_meta_box(
				'dashboard/advanced-tools',
				__( 'Advanced Tools', 'wphb' ),
				array( $this, 'dashboard_advanced_metabox' ),
				null,
				array( $this, 'dashboard_advanced_metabox_footer' ),
				'box-dashboard-right'
			);
		}

		/* Smush */
		$smush_id = WP_Hummingbird_Utils::is_member() ? 'dashboard-smush' : 'dashboard/smush/no-membership';
		$smush_footer = array( $this, 'dashboard_smush_metabox_footer' );
		if ( ! WP_Hummingbird_Module_Smush::is_smush_installed() || ! WP_Hummingbird_Module_Smush::is_smush_active() ) {
			$smush_footer = null;
		}
		$this->add_meta_box(
			$smush_id,
			__( 'Image Optimization', 'wphb' ),
			array( $this, 'dashboard_smush_metabox' ),
			array( $this, 'dashboard_smush_metabox_header' ),
			$smush_footer,
			'box-dashboard-right'
		);

		/* Uptime */
		/* @var WP_Hummingbird_Module_Uptime $uptime_module */
		$uptime_module = WP_Hummingbird_Utils::get_module( 'uptime' );
		$is_active = $uptime_module->is_active();
		if ( $is_active ) {
			$this->uptime_report = $uptime_module->get_last_report();
		}

		if ( ! WP_Hummingbird_Utils::is_member() ) {
			$this->add_meta_box(
				'dashboard/uptime/no-membership',
				__( 'Uptime Monitoring', 'wphb' ),
				null,
				array( $this, 'dashboard_uptime_module_metabox_header' ),
				null,
				'box-dashboard-right'
			);
		} elseif ( is_wp_error( $this->uptime_report ) && $is_active ) {
			$this->add_meta_box(
				'dashboard-uptime-error',
				__( 'Uptime', 'wphb' ),
				array( $this, 'dashboard_uptime_error_metabox' ),
				null,
				null,
				'box-dashboard-right'
			);
		} elseif ( ! $is_active ) {
			$this->add_meta_box(
				'dashboard-uptime-disabled',
				__( 'Uptime', 'wphb' ),
				array( $this, 'dashboard_uptime_disabled_metabox' ),
				null,
				null,
				'box-dashboard-right'
			);
		} else {
			$this->add_meta_box(
				'dashboard-uptime',
				__( 'Uptime', 'wphb' ),
				array( $this, 'dashboard_uptime_metabox' ),
				array( $this, 'dashboard_uptime_module_metabox_header' ),
				array( $this, 'dashboard_uptime_module_metabox_footer' ),
				'box-dashboard-right',
				null
			);
		} // End if().

		/* Reports */
		if ( ! WP_Hummingbird_Utils::is_member() || ( defined( 'WPHB_WPORG' ) && WPHB_WPORG ) ) {
			$this->add_meta_box(
				'dashboard/reports/no-membership',
				__( 'Reporting', 'wphb' ),
				null,
				array( $this, 'dashboard_reports_module_metabox_header' ),
				null,
				'box-dashboard-right'
			);
		}
	}

	/**
	 * Display dashboard welcome metabox.
	 */
	public function dashboard_welcome_metabox() {
		$caching_status = WP_Hummingbird_Utils::get_status( 'caching' );
		$caching_issues = WP_Hummingbird_Utils::get_number_of_issues( 'caching' );

		$gzip_status = WP_Hummingbird_Utils::get_status( 'gzip' );
		$gzip_issues = WP_Hummingbird_Utils::get_number_of_issues( 'gzip' );

		$uptime_module = WP_Hummingbird_Utils::get_module( 'uptime' );
		$uptime_active = $uptime_module->is_active();
		$uptime_report = $this->uptime_report;
		$site_date = '';
		if ( WP_Hummingbird_Utils::is_member() && isset( $uptime_report->up_since ) && false !== $uptime_report->up_since ) {
			$gmt_date = date( 'Y-m-d H:i:s', $uptime_report->up_since );
			$site_date = get_date_from_gmt( $gmt_date, get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
		}

		$last_report = WP_Hummingbird_Module_Performance::get_last_report();
		$report_dismissed = WP_Hummingbird_Module_Performance::report_dismissed();
		$is_doing_report = WP_Hummingbird_Module_Performance::is_doing_report();
		/* @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
		$cf_active = false;

		$cf_current = '';
		if ( $cf_module->is_connected() && $cf_module->is_zone_selected() ) {
			$cf_active = true;
			$cf_current = $cf_module->get_caching_expiration();
			if ( is_wp_error( $cf_current ) ) {
				$cf_current = '';
			}
		}

		$args = compact(
			'caching_status',
			'caching_issues',
			'gzip_status',
			'gzip_issues',
			'uptime_active',
			'uptime_report',
			'last_report',
			'cf_active',
			'cf_current',
			'site_date',
			'report_dismissed',
			'is_doing_report'
		);
		$this->view( 'dashboard/welcome/meta-box', $args );
	}

	/**
	 * Dashboard welcome metabox header.
	 */
	public function dashboard_welcome_metabox_header() {
		/* Translators: %s: username */
		$title = sprintf( __( 'Welcome %s', 'wphb' ), WP_Hummingbird_Utils::get_current_user_info() );
		$this->view( 'dashboard/welcome/meta-box-header', compact( 'title' ) );
	}

	/*******************
	 * CACHING         *
	 *******************/

	/**
	 * Display browser caching metabox.
	 */
	public function dashboard_browser_caching_module_metabox() {
		$caching_status = WP_Hummingbird_Utils::get_status( 'caching' );
		$recommended = WP_Hummingbird_Utils::get_recommended_caching_values();
		$expiration = 0;
		// Get expiration setting values.
		/* @var WP_Hummingbird_Module_Cloudflare $caching */
		$caching = WP_Hummingbird_Utils::get_module( 'caching' );
		$options = $caching->get_options();
		$expires = array(
			'css'        => $options['expiry_css'],
			'javascript' => $options['expiry_javascript'],
			'media'      => $options['expiry_media'],
			'images'     => $options['expiry_images'],
		);

		/* @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
		$cf_server = $cf_module->has_cloudflare();
		$cf_active = false;
		$cf_current_human = '';
		$cf_tooltip = '';
		$cf_current = '';
		$show_cf_notice = false;
		if ( $cf_module->is_connected() && $cf_module->is_zone_selected() ) {
			$cf_active = true;
			$cf_current = $cf_module->get_caching_expiration();
			$expiration = $cf_current;
			if ( is_wp_error( $cf_current ) ) {
				$cf_current = '';
			}

			$cf_tooltip = 691200 == $cf_current ? __( 'Caching is enabled', 'wphb' ) : __( "Caching is enabled but you aren't using our recommended value", 'wphb' );
			$cf_current_human = WP_Hummingbird_Utils::human_read_time_diff( $cf_current );

			// Fill the report with values from Cloudflare.
			$caching_status = array_fill_keys( array_keys( $expires ), $expiration );
		} elseif ( ! get_site_option( 'wphb-cloudflare-dash-notice' ) && 'dismissed' !== get_site_option( 'wphb-cloudflare-dash-notice' ) ) {
			$show_cf_notice = true;
		}
		$cf_notice = $cf_server ? __( 'Ahoi, we’ve detected you’re using CloudFlare!', 'wphb' ) : __( 'Using CloudFlare?', 'wphb' );

		// Get number of issues for notification box.
		if ( ! $cf_active ) {
			$issues = WP_Hummingbird_Utils::get_number_of_issues( 'caching' );
		} elseif ( 691200 > $expiration ) {
			count( $caching_status );
			$issues = count( $caching_status );
			// Add an issue for the CloudFlare type.
			$issues++;
		} else {
			$issues = 0;
		}
		$human_results = array_map( array( 'WP_Hummingbird_Utils', 'human_read_time_diff' ), $caching_status );

		$args = array(
			'results'                => $caching_status,
			'recommended'            => $recommended,
			'human_results'          => $human_results,
			'cf_tooltip'             => $cf_tooltip,
			'cf_current'             => $cf_current,
			'cf_current_human'       => $cf_current_human,
			'cf_active'              => $cf_active,
			'issues'                 => $issues,
			'cf_notice'              => $cf_notice,
			'show_cf_notice'         => $show_cf_notice,
			'cf_connect_url'         => WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) . '&view=browser&connect-cloudflare=true',
			'caching_type_tooltips'  => WP_Hummingbird_Utils::get_browser_caching_types(),
			'configure_caching_url'  => WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) . '&view=browser#wphb-box-caching-settings',
		);
		if ( $cf_active ) {
			$this->view( 'dashboard/caching/cloudflare-module-meta-box', $args );
		} else {
			$this->view( 'dashboard/caching/module-meta-box', $args );
		}
	}

	/**
	 * Display browser caching metabox header.
	 */
	public function dashboard_browser_caching_module_metabox_header() {
		$title = __( 'Browser Caching', 'wphb' );
		$issues = WP_Hummingbird_Utils::get_number_of_issues( 'caching' );

		/* @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
		$cf_active = false;

		$cf_current = '';
		if ( $cf_module->is_connected() && $cf_module->is_zone_selected() ) {
			$cf_active = true;
			$cf_current = $cf_module->get_caching_expiration();
			if ( is_wp_error( $cf_current ) ) {
				$cf_current = '';
			}
		}

		$args = compact( 'title', 'issues', 'cf_active', 'cf_current' );
		$this->view( 'dashboard/caching/module-meta-box-header', $args );
	}

	/**
	 * Display browser caching metabox footer.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_browser_caching_module_metabox_footer() {
		/** @var WP_Hummingbird_Module_Cloudflare $cf_module */
		$cf_module = WP_Hummingbird_Utils::get_module( 'cloudflare' );
		$this->view( 'dashboard/caching/module-meta-box-footer', array(
			'caching_url' => WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) . '&view=browser',
			'cf_active'   => $cf_module->is_connected() && $cf_module->is_zone_selected(),
		) );
	}

	/**
	 * Display page caching metabox.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_page_caching_module_metabox() {
		/* @var WP_Hummingbird_Module_Page_Cache $module */
		$module = WP_Hummingbird_Utils::get_module( 'page_cache' );
		$activate_url = add_query_arg( array(
			'type' => 'pc-activate',
			'run'  => 'true',
		), WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) );
		$activate_url = wp_nonce_url( $activate_url, 'wphb-run-caching' );

		$is_active = $module->is_active();

		$admins_can_disable_page_caching = false;
		if ( 'blog-admins' === $is_active ) {
			$is_active = true;
			$admins_can_disable_page_caching = true;
		}

		$this->view( 'dashboard/caching/page-caching-module-meta-box', compact( 'is_active', 'activate_url', 'admins_can_disable_page_caching' ) );
	}

	/**
	 * Page caching meta box footer.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_page_caching_module_metabox_footer() {
		$url = WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) . '&view=main';
		$this->view( 'dashboard/caching/page-caching-module-meta-box-footer', compact( 'url' ) );
	}

	/**
	 * Display gravatar caching meta box.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_gravatar_caching_module_metabox() {
		/* @var WP_Hummingbird_Module_Gravatar $module */
		$module = WP_Hummingbird_Utils::get_module( 'gravatar' );
		$activate_url = add_query_arg( array(
			'type' => 'gc-activate',
			'run'  => 'true',
			'view' => 'gravatar',
		), WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) );
		$activate_url = wp_nonce_url( $activate_url, 'wphb-run-caching' ) . '#wphb-box-dashboard-gravatar';

		$is_active = $module->is_active();

		$this->view( 'dashboard/caching/gravatar-module-meta-box', compact( 'is_active', 'activate_url' ) );
	}

	/**
	 * Display gravatar caching meta box footer.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_gravatar_caching_module_metabox_footer() {
		$url = WP_Hummingbird_Utils::get_admin_menu_url( 'caching' ) . '&view=gravatar';
		$this->view( 'dashboard/caching/gravatar-module-meta-box-footer', compact( 'url' ) );
	}

	/*******************
	 * UPTIME          *
	 *******************/
	/**
	 * Uptime meta box.
	 */
	public function dashboard_uptime_metabox() {
		$uptime_stats = $this->uptime_report;
		$this->view( 'dashboard/uptime/module-meta-box', compact( 'uptime_stats' ) );
	}

	/**
	 * Uptime header meta box.
	 */
	public function dashboard_uptime_module_metabox_header() {
		$title = __( 'Uptime Monitoring', 'wphb' );
		$this->view( 'dashboard/uptime/module-meta-box-header', compact( 'title' ) );
	}

	/**
	 * Uptime footer meta box.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_uptime_module_metabox_footer() {
		$url = WP_Hummingbird_Utils::get_admin_menu_url( 'uptime' );
		$this->view( 'dashboard/uptime/module-meta-box-footer', compact( 'url' ) );
	}

	public function dashboard_uptime_disabled_metabox() {
		$enable_url = add_query_arg( 'action', 'enable', WP_Hummingbird_Utils::get_admin_menu_url( 'uptime' ) );
		$enable_url = wp_nonce_url( $enable_url, 'wphb-toggle-uptime' );
		$this->view( 'dashboard/uptime/disabled-meta-box', compact( 'enable_url' ) );
	}
	public function dashboard_uptime_error_metabox() {
		$report = $this->uptime_report;
		$retry_url = add_query_arg(
			array(
				'run'  => 'true',
				'type' => 'uptime',
			),
			WP_Hummingbird_Utils::get_admin_menu_url()
		);
		$retry_url = wp_nonce_url( $retry_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-uptime-module';
		$support_url = WP_Hummingbird_Utils::get_link( 'support' );
		$error = $report->get_error_message();

		$this->view( 'dashboard/uptime/error-meta-box', compact( 'retry_url', 'support_url', 'error' ) );
	}

	/**********************
	 * ASSET OPTIMIZATION *
	 **********************/
	/**
	 * Asset optimization meta box.
	 */
	public function dashboard_minification_module_metabox() {
		/* @var WP_Hummingbird_Module_Minify $minify_module */
		$minify_module = WP_Hummingbird_Utils::get_module( 'minify' );
		$collection = $minify_module->get_resources_collection();

		// Remove those assets that we don't want to display
		foreach ( $collection['styles'] as $key => $item ) {
			if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'styles' ) ) {
				unset( $collection['styles'][ $key ] );
			}
		}
		foreach ( $collection['scripts'] as $key => $item ) {
			if ( ! apply_filters( 'wphb_minification_display_enqueued_file', true, $item, 'scripts' ) ) {
				unset( $collection['scripts'][ $key ] );
			}
		}

		$enqueued_files = count( $collection['scripts'] ) + count( $collection['styles'] );

		$original_size_styles = array_sum( @wp_list_pluck( $collection['styles'], 'original_size' ) );
		$original_size_scripts = array_sum( @wp_list_pluck( $collection['scripts'], 'original_size' ) );

		$original_size = $original_size_scripts + $original_size_styles;

		$compressed_size_styles = array_sum( @wp_list_pluck( $collection['styles'], 'compressed_size' ) );
		$compressed_size_scripts = array_sum( @wp_list_pluck( $collection['scripts'], 'compressed_size' ) );
		$compressed_size = $compressed_size_scripts + $compressed_size_styles;

		if ( ( $original_size_scripts + $original_size_styles ) <= 0 ) {
			$percentage = 0;
		} else {
			$percentage = 100 - (int) $compressed_size * 100 / (int) $original_size;
		}
		$percentage = number_format_i18n( $percentage, 1 );

		$compressed_size_styles = number_format( $original_size_styles - $compressed_size_styles, 0 );
		$compressed_size_scripts = number_format( $original_size_scripts - $compressed_size_scripts, 0 );

		// Internalization numbers.
		$original_size = number_format_i18n( $original_size, 1 );
		$compressed_size = number_format_i18n( $compressed_size, 1 );

		$args = compact( 'enqueued_files', 'original_size', 'compressed_size', 'compressed_size_scripts', 'compressed_size_styles', 'percentage' );
		$this->view( 'dashboard/minification/module-meta-box', $args );
	}

	/**
	 * Asset optimization footer meta box.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_minification_module_metabox_footer() {
		$url = WP_Hummingbird_Utils::get_admin_menu_url( 'minification' );

		/* @var WP_Hummingbird_Module_Minify $minify */
		$minify = WP_Hummingbird_Utils::get_module( 'minify' );
		$cdn_status = $minify->get_cdn_status();

		$this->view( 'dashboard/minification/module-meta-box-footer', compact( 'url', 'cdn_status' ) );
	}

	public function dashboard_minification_network_module_metabox() {
		/* @var WP_Hummingbird_Module_Minify $minify */
		$minify = WP_Hummingbird_Utils::get_module( 'minify' );
		$options = $minify->get_options();

		$args = array(
			'enabled' => $options['enabled'],
			'use_cdn' => $minify->get_cdn_status(),
			'use_cdn_disabled' => ! WP_Hummingbird_Utils::is_member() || ! $options['enabled'],
		);

		$this->view( 'dashboard/minification/network-module-meta-box', $args );
	}

	public function dashboard_minification_disabled_metabox() {
		$minification_url = add_query_arg(
			array(
				'run'  => 'true',
				'type' => 'minification',
			),
			WP_Hummingbird_Utils::get_admin_menu_url()
		);
		$minification_url = wp_nonce_url( $minification_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-minification-checking-files';
		$this->view( 'dashboard/minification/disabled-meta-box', compact( 'minification_url' ) );
	}

	/*******************
	 * ADVANCED TOOLS  *
	 *******************/
	/**
	 * Advanced tools meta box.
	 *
	 * @since 1.8
	 */
	public function dashboard_advanced_metabox() {
		/* @var WP_Hummingbird_Module_Advanced $adv_module */
		$adv_module = WP_Hummingbird_Utils::get_module( 'advanced' );

		$fields = WP_Hummingbird_Module_Advanced::get_db_fields();

		$count = 0;
		foreach ( $fields as $type => $data ) {
			$count += $adv_module->get_db_count( $type );
		}

		$this->view( 'dashboard/advanced/module-meta-box', array(
			'count' => $count,
		) );
	}

	/**
	 * Advanced tools meta box footer.
	 *
	 * @since 1.8
	 */
	public function dashboard_advanced_metabox_footer() {
		$this->view( 'dashboard/advanced/module-meta-box-footer', array(
			'url' => WP_Hummingbird_Utils::get_admin_menu_url( 'advanced' ) . '&view=db',
		) );
	}

	/*******************
	 * GZIP            *
	 *******************/
	public function dashboard_gzip_module_metabox() {
		$this->view( 'dashboard/gzip/module-meta-box', array(
			'status'         => WP_Hummingbird_Utils::get_status( 'gzip' ),
			'inactive_types' => WP_Hummingbird_Utils::get_number_of_issues( 'gzip' ),
		) );
	}

	public function dashboard_gzip_module_metabox_header() {
		$this->view( 'dashboard/gzip/module-meta-box-header', array(
			'title'  => __( 'GZIP Compression', 'wphb' ),
			'issues' => WP_Hummingbird_Utils::get_number_of_issues( 'gzip' ),
		) );
	}

	public function dashboard_gzip_module_metabox_footer() {
		$this->view( 'dashboard/gzip/module-meta-box-footer', array(
			'gzip_url' => WP_Hummingbird_Utils::get_admin_menu_url( 'gzip' ),
		) );
	}

	/********************
	 * PERFORMANCE      *
	 ********************/
	/**
	 * Performance disabled meta box.
	 */
	public function dashboard_performance_disabled_metabox() {
		$run_url = add_query_arg(
			array(
				'run'  => 'true',
				'type' => 'performance',
			),
			WP_Hummingbird_Utils::get_admin_menu_url()
		);
		$run_url = wp_nonce_url( $run_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';

		$this->view( 'dashboard/performance/disabled-meta-box', compact( 'run_url' ) );
	}

	/**
	 * Performance meta box.
	 */
	public function dashboard_performance_module_metabox() {
		$report = WP_Hummingbird_Module_Performance::get_last_report();
		$report = $report->data;

		$viewreport_link = WP_Hummingbird_Utils::get_admin_menu_url( 'performance' );

		$this->view( 'dashboard/performance/module-meta-box', compact( 'report', 'viewreport_link' ) );
	}

	/**
	 * Performance meta box dismissed.
	 */
	public function dashboard_performance_module_metabox_dismissed() {
		$notifications = false;
		if ( WP_Hummingbird_Utils::is_member() ) {
			/* @var WP_Hummingbird_Module_Performance $performance */
			$performance = WP_Hummingbird_Utils::get_module( 'performance' );
			$options = $performance->get_options();
			$notifications = $options['reports'];
		}

		$this->view( 'dashboard/performance/module-meta-box-dismissed', compact( 'notifications' ) );
	}

	/**
	 * Performance meta box header.
	 */
	public function dashboard_performance_module_metabox_header() {
		$title = __( 'Performance Test', 'wphb' );

		$last_report = WP_Hummingbird_Module_Performance::get_last_report();
		if ( $last_report && ! is_wp_error( $last_report ) ) {
			$last_report = $last_report->data;
		}
		$report_dismissed = WP_Hummingbird_Module_Performance::report_dismissed();
		$scan_link = add_query_arg(
			array(
				'run'  => 'true',
				'type' => 'performance',
			),
			WP_Hummingbird_Utils::get_admin_menu_url()
		);
		$scan_link = wp_nonce_url( $scan_link, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';
		$can_run_scan = WP_Hummingbird_Module_Performance::can_run_test();

		$this->view( 'dashboard/performance/module-meta-box-header', compact( 'title', 'last_report', 'scan_link', 'can_run_scan', 'report_dismissed' ) );
	}

	/**
	 * Performance footer meta box.
	 *
	 * @since 1.7.0
	 */
	public function dashboard_performance_module_metabox_footer() {
		$url = WP_Hummingbird_Utils::get_admin_menu_url( 'performance' );

		$notifications = false;

		/* @var WP_Hummingbird_Module_Performance $perf_module */
		$perf_module = WP_Hummingbird_Utils::get_module( 'performance' );

		if ( WP_Hummingbird_Utils::is_member() ) {
			$options = $perf_module->get_options();
			$notifications = $options['reports'];
		}

		$this->view( 'dashboard/performance/module-meta-box-footer', compact( 'url', 'notifications' ) );
	}

	/**
	 * Performance errors meta box.
	 */
	public function dashboard_performance_module_error_metabox() {
		/* @var WP_Error $last_report */
		$last_report = WP_Hummingbird_Module_Performance::get_last_report();
		$retry_url = add_query_arg(
			array(
				'run'  => 'true',
				'type' => 'performance',
			),
			WP_Hummingbird_Utils::get_admin_menu_url()
		);
		$retry_url = wp_nonce_url( $retry_url, 'wphb-run-dashboard' ) . '#wphb-box-dashboard-performance-running-test';

		$support_url = WP_Hummingbird_Utils::get_link( 'support' );
		$error = $last_report->get_error_message();

		$this->view( 'dashboard/performance/module-error-meta-box', compact( 'error', 'retry_url', 'support_url' ) );
	}

	/*********************************
	/** SMUSH                        *
	 *********************************/
	/**
	 * Smush meta box.
	 */
	public function dashboard_smush_metabox() {
		global $wpsmushit_admin, $wpsmush_db;

		$smush_data = array(
			'human'   => '',
			'percent' => 0,
		);
		$unsmushed_images = 0;
		if ( ( $wpsmushit_admin instanceof WpSmushitAdmin ) && method_exists( $wpsmushit_admin, 'global_stats' ) ) {
			/* @var WpSmushitAdmin $wpsmushit_admin */
			$smush_data = $wpsmushit_admin->global_stats();
		}
		if ( ( $wpsmush_db instanceof WpSmushDB ) && method_exists( $wpsmush_db, 'get_unsmushed_attachments' ) ) {
			/* @var WpSmushDB $wpsmush_db */
			$unsmushed_images = count( $wpsmush_db->get_unsmushed_attachments() );
		}

		$this->view(
			'dashboard/smush/meta-box',
			array(
				'activate_url'     => wp_nonce_url( 'plugins.php?action=activate&amp;plugin=wp-smushit/wp-smush.php', 'activate-plugin_wp-smushit/wp-smush.php' ),
				'activate_pro_url' => wp_nonce_url( 'plugins.php?action=activate&amp;plugin=wp-smush-pro/wp-smush.php', 'activate-plugin_wp-smush-pro/wp-smush.php' ),
				'is_active'        => WP_Hummingbird_Module_Smush::is_smush_active(),
				'is_installed'     => WP_Hummingbird_Module_Smush::is_smush_installed(),
				'smush_data'       => $smush_data,
				'is_pro'           => WP_Hummingbird_Module_Smush::$is_smush_pro,
				'unsmushed'        => $unsmushed_images,
			)
		);
	}

	/**
	 * Smush meta box haeder.
	 */
	public function dashboard_smush_metabox_header() {
		$title = __( 'Image Optimization', 'wphb' );
		$this->view( 'dashboard/smush/meta-box-header', compact( 'title' ) );
	}

	/**
	 * Smush meta box footer.
	 */
	public function dashboard_smush_metabox_footer() {
		$url = admin_url( 'upload.php?page=wp-smush-bulk' );
		$this->view( 'dashboard/smush/meta-box-footer', compact( 'url' ) );
	}

	/*********************************
	/** REPORTS                      *
	 *********************************/
	/**
	 * Reports header meta box
	 *
	 * @since 1.4.5
	 */
	public function dashboard_reports_module_metabox_header() {
		$title = __( 'Reports', 'wphb' );
		$this->view( 'dashboard/reports/meta-box-header', compact( 'title' ) );
	}

}