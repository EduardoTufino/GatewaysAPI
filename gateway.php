<?php
/**
 * Plugin Name:     	GatewayAPI
 * Description:     	Connect your CRM or APIs with no code.
 * Version:         	1.5
 * Author:          	GatewayAPI
 * Text Domain:     	GatewayAPI
 * Domain Path: 		/languages/
 * Requires at least: 	4.4
 * Tested up to: 		5.9
 * License:         	GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package         	GatewayAPI
 * @copyright       	Copyright (c) GatewayAPI
 */

/*
 * Copyright (c) GatewayAPI (info@arre.app)
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Affero General
 * Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

final class GatewayAPI {

    /**
     * @var         GatewayAPI $instance The one true GatewayAPI
     * @since       1.0.0
     */
    private static $instance;

    /**
     * @var         array $settings Stored settings
     * @since       1.0.2
     */
    public $settings = null;

    /**
     * @var         array $integrations Registered integrations
     * @since       1.0.0
     */
    public $integrations = array();

    /**
     * @var         array $triggers Registered triggers
     * @since       1.0.0
     */
    public $triggers = array();

    /**
     * @var         array $actions Registered actions
     * @since       1.0.0
     */
    public $actions = array();

    /**
     * @var         array $filters Registered filters
     * @since       1.0.0
     */
    public $filters = array();

    /**
     * @var         GatewayAPI_Database $db Database object
     * @since       1.0.0
     */
    public $db;

    /**
     * @var         array $cache Cache class
     * @since       1.0.0
     */
    public $cache = array();

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      GatewayAPI self::$instance The one true GatewayAPI
     */
    public static function instance() {

        if( ! self::$instance ) {

            self::$instance = new GatewayAPI();
            self::$instance->constants();
            self::$instance->libraries();
            self::$instance->classes();
            self::$instance->includes();
            self::$instance->hooks();
            self::$instance->load_textdomain();

        }

        return self::$instance;

    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {

        // Plugin version
        define( 'GatewayAPI_VER', '2.1.2' );

        // Plugin file
        define( 'GatewayAPI_FILE', __FILE__ );

        // Plugin path
        define( 'GatewayAPI_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'GatewayAPI_URL', plugin_dir_url( __FILE__ ) );

    }

    /**
     * Include plugin libraries
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function libraries() {

        // Custom Tables
        require_once GatewayAPI_DIR . 'libraries/ct/init.php';

        // CMB2
        require_once GatewayAPI_DIR . 'libraries/cmb2/init.php';
        require_once GatewayAPI_DIR . 'libraries/cmb2-metatabs-options/cmb2_metatabs_options.php';
        require_once GatewayAPI_DIR . 'libraries/cmb2-field-edd-license/cmb2-field-edd-license.php';
        require_once GatewayAPI_DIR . 'libraries/cmb2-field-switch/cmb2-field-switch.php';
        require_once GatewayAPI_DIR . 'libraries/cmb2-field-js-controls/cmb2-field-js-controls.php';

        // Custom CMB2 fields
        require_once GatewayAPI_DIR . 'libraries/GatewayAPI-select.php';
        require_once GatewayAPI_DIR . 'libraries/GatewayAPI-select-filter.php';

    }

    /**
     * Include plugin classes
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function classes() {

        require_once GatewayAPI_DIR . 'classes/database.php';
        require_once GatewayAPI_DIR . 'classes/integration-trigger.php';
        require_once GatewayAPI_DIR . 'classes/integration-action.php';
        require_once GatewayAPI_DIR . 'classes/integration-filter.php';

    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        // The rest of files
        require_once GatewayAPI_DIR . 'includes/admin.php';
        require_once GatewayAPI_DIR . 'includes/custom-tables.php';
        require_once GatewayAPI_DIR . 'includes/ajax-functions.php';
        require_once GatewayAPI_DIR . 'includes/filters.php';
        require_once GatewayAPI_DIR . 'includes/functions.php';
        require_once GatewayAPI_DIR . 'includes/cache.php';
        require_once GatewayAPI_DIR . 'includes/cmb2.php';
        require_once GatewayAPI_DIR . 'includes/cron.php';
        require_once GatewayAPI_DIR . 'includes/scripts.php';
        require_once GatewayAPI_DIR . 'includes/automation-ui.php';
        require_once GatewayAPI_DIR . 'includes/automations.php';
        require_once GatewayAPI_DIR . 'includes/integrations.php';
        require_once GatewayAPI_DIR . 'includes/triggers.php';
        require_once GatewayAPI_DIR . 'includes/actions.php';
        require_once GatewayAPI_DIR . 'includes/tags.php';
        require_once GatewayAPI_DIR . 'includes/events.php';
        require_once GatewayAPI_DIR . 'includes/logs.php';
        require_once GatewayAPI_DIR . 'includes/users.php';
        require_once GatewayAPI_DIR . 'includes/utilities.php';

    }

    /**
     * Include integrations files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function integrations() {

        $integrations_dir = GatewayAPI_DIR . 'integrations';

        require_once GatewayAPI_DIR . 'integrations/filter/filter.php';
        require_once GatewayAPI_DIR . 'integrations/GatewayAPI/GatewayAPI.php';
        require_once GatewayAPI_DIR . 'integrations/wordpress/wordpress.php';

        // Skip if integration is already active
        if( $this->is_integration_active( 'pro' ) ) {
            return;
        }

        $integrations = @opendir( $integrations_dir );

        while ( ( $integration = @readdir( $integrations ) ) !== false ) {

            if ( $integration === '.' || $integration === '..' || $integration === 'index.php' ) {
                continue;
            }

            if ( $integration === 'filter' || $integration === 'GatewayAPI' || $integration === 'wordpress' ) {
                continue;
            }

            /**
             * Filter to allow third party plugins skip any integration
             *
             * @since 1.0.0
             *
             * @param bool $skip
             * @param string integration The integration slug as named in GatewayAPI/includes/integrations
             *
             * @return bool
             */
            if( apply_filters( 'GatewayAPI_skip_integration', false, $integration ) ) {
                continue;
            }

            // Skip if integration is already active
            if( $this->is_integration_active( $integration ) ) {
                continue;
            }

            $integration_file = $integrations_dir . DIRECTORY_SEPARATOR . $integration . DIRECTORY_SEPARATOR . $integration . '.php';

            // Skip if no file to load
            if( ! file_exists( $integration_file ) ) {
                continue;
            }

            require_once $integration_file;

        }

        closedir( $integrations );

    }

    /**
     * Include integrations files
     *
     * @access      private
     * @since       1.0.0
     * @param       string $integration
     * @return      bool
     */
    private function is_integration_active( $integration ) {

        $plugins = array(
            "GatewayAPI-{$integration}/GatewayAPI-{$integration}.php",
            "GatewayAPI-{$integration}-integration/GatewayAPI-{$integration}.php",
        );

        foreach( $plugins as $plugin ) {

            // Check if is_plugin_active  exists
            if( function_exists( 'is_plugin_active' ) ) {

                // Bail if plugin is active
                if( is_plugin_active( $plugin ) ) {
                    return true;
                }

            } else if( function_exists( 'get_option' ) ) {
                // Fallback to get_option

                $active_plugins = (array) get_option( 'active_plugins', array() );

                // Bail if plugin is active
                if( in_array( $plugin, $active_plugins, true ) ) {
                    return true;
                }

                // Check for multi sites
                if( function_exists( 'is_plugin_active_for_network' ) ) {

                    // Bail if plugin is network wide active
                    if( is_plugin_active_for_network( $plugin ) ) {
                        return true;
                    }

                } else if( function_exists( 'get_site_option' ) ) {

                    $network_plugins = get_site_option( 'active_sitewide_plugins' );

                    // Bail if plugin is network wide active
                    if ( isset( $network_plugins[$plugin] ) ) {
                        return true;
                    }

                }


            }
        }

        return false;

    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {

        // Setup our activation and deactivation hooks
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        // Hook in all our important pieces
        add_action( 'plugins_loaded', array( $this, 'pre_init' ), 20 );
        add_action( 'plugins_loaded', array( $this, 'init' ), 50 );
        add_action( 'plugins_loaded', array( $this, 'post_init' ), 999 );
    }

    /**
     * Pre init function
     *
     * @access      private
     * @since       1.4.6
     * @return      void
     */
    function pre_init() {

        // Load all integrations
        $this->integrations();

        global $wpdb;

        $this->db = new GatewayAPI_Database();

        // Setup WordPress database tables
        $this->db->posts 				= $wpdb->posts;
        $this->db->postmeta 			= $wpdb->postmeta;
        $this->db->users 				= $wpdb->users;
        $this->db->usermeta 			= $wpdb->usermeta;

        // Setup GatewayAPI database tables
        $this->db->automations 			= $wpdb->GatewayAPI_automations;
        $this->db->automations_meta     = $wpdb->GatewayAPI_automations_meta;
        $this->db->triggers 		    = $wpdb->GatewayAPI_triggers;
        $this->db->triggers_meta 		= $wpdb->GatewayAPI_triggers_meta;
        $this->db->actions 		        = $wpdb->GatewayAPI_actions;
        $this->db->actions_meta 		= $wpdb->GatewayAPI_actions_meta;
        $this->db->logs 		        = $wpdb->GatewayAPI_logs;
        $this->db->logs_meta 		    = $wpdb->GatewayAPI_logs_meta;

        // Trigger our action to let other plugins know that GatewayAPI is getting initialized
        do_action( 'GatewayAPI_pre_init' );

    }

    /**
     * Init function
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    function init() {

        // Trigger our action to let other plugins know that GatewayAPI is ready
        do_action( 'GatewayAPI_init' );

    }

    /**
     * Post init function
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    function post_init() {

        // Trigger our action to let other plugins know that GatewayAPI has been initialized
        do_action( 'GatewayAPI_post_init' );

    }

    /**
     * Activation
     *
     * @access      private
     * @since       1.0.0
     */
    function activate() {

        // Include our important bits
        $this->libraries();
        $this->includes();

        require_once GatewayAPI_DIR . 'includes/install.php';

        GatewayAPI_install();

    }

    /**
     * Deactivation
     *
     * @access      private
     * @since       1.0.0
     */
    function deactivate() {

        // Include our important bits
        $this->libraries();
        $this->includes();

        require_once GatewayAPI_DIR . 'includes/uninstall.php';

        GatewayAPI_uninstall();

    }

    /**
     * Internationalization
     *
     * @access      public
     * @since       1.0.0
     * @return      void
     */
    public function load_textdomain() {

        // Set filter for language directory
        $lang_dir = GatewayAPI_DIR . '/languages/';
        $lang_dir = apply_filters( 'GatewayAPI_languages_directory', $lang_dir );

        // Traditional WordPress plugin locale filter
        $locale = apply_filters( 'plugin_locale', get_locale(), 'GatewayAPI' );
        $mofile = sprintf( '%1$s-%2$s.mo', 'GatewayAPI', $locale );

        // Setup paths to current locale file
        $mofile_local   = $lang_dir . $mofile;
        $mofile_global  = WP_LANG_DIR . '/GatewayAPI/' . $mofile;

        if( file_exists( $mofile_global ) ) {
            // Look in global /wp-content/languages/GatewayAPI/ folder
            load_textdomain( 'GatewayAPI', $mofile_global );
        } elseif( file_exists( $mofile_local ) ) {
            // Look in local /wp-content/plugins/GatewayAPI/languages/ folder
            load_textdomain( 'GatewayAPI', $mofile_local );
        } else {
            // Load the default language files
            load_plugin_textdomain( 'GatewayAPI', false, $lang_dir );
        }

    }

}

/**
 * The main function responsible for returning the one true GatewayAPI instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \GatewayAPI The one true GatewayAPI
 */
function GatewayAPI() {
    return GatewayAPI::instance();
}

GatewayAPI();
