<?php

namespace SAFW\Plugin;

/**
 * Plugins custom settings page that adheres to wp standard
 * see: https://developer.wordpress.org/plugins/settings/custom-settings-page/
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * WP Settings Class.
 */
class Settings
{

    /**
     * The single instance of the class.
     *
     * @since 1.0
     */
    protected static $_instance = null;

    private $colors = array(
        'padd_1a' => "#328e42",
        'padd_1b' => "#45b255",
        'padd_1c' => "#7ccb29",
        'padd_2' => "#5ca5bf",
        'padd_3' => "#162f3f",
        'padd_4' => "#8bc4d2",
        'padd_5' => "#265997"
    );

    /**
     * Class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // Add new menu
        add_action('admin_menu', array($this, 'custom_menu'), 10);

        // Fetch PADD colors via ajax 
        add_action("wp_ajax_safw_settings_fetch_padd_colors", array($this, 'safw_settings_fetch_padd_colors'));
        add_action("wp_ajax_nopriv_safw_settings_fetch_padd_colors", array($this, 'safw_settings_fetch_padd_colors'));

        // Save PADD colors via ajax 
        add_action("wp_ajax_safw_settings_save_padd_colors", array($this, 'safw_settings_save_padd_colors'));

        // Delete cache
        add_action("wp_ajax_safw_settings_delete_cache", array($this, 'safw_settings_delete_cache'));
    }

    /**
     * Main Instance.
     * 
     * @since 1.0
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Add custom wp admin menu.
     * 
     * @since 1.0
     */
    public function custom_menu()
    {
        add_menu_page(
            'Gas Prices',
            'Gas Prices',
            'edit_posts',
            'gas_prices_settings',
            array($this, 'gas_prices_settings_page'),
            'dashicons-media-spreadsheet'
        );
    }

    /**
     * Display content to the new added custom wp admin menu.
     * 
     * @since 1.0
     */
    public function gas_prices_settings_page()
    {
?>
        <div class="wrap">
            <div id="gas-prices-settings">
                <h2>Loading...</h2>
            </div>
        </div>
<?php
    }

    /**
     * Fetch PADD colors
     * 
     * @since 1.0
     */
    public function safw_settings_fetch_padd_colors()
    {

        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        /**
         * Verify nonce
         */
        if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'colors_nonce')) {
            wp_die();
        }

        try {

            $colors = get_option('safw_padd_colors');

            if (empty($colors)) {
                $colors = $this->colors;
            }

            wp_send_json(array(
                'status' => 'success',
                'colors' => $colors
            ));
        } catch (\Exception $e) {

            wp_send_json(array(
                'status' => 'error',
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Save PADD colors.
     * 
     * @since 1.0
     */
    public function safw_settings_save_padd_colors()
    {

        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        /**
         * Verify nonce
         */
        if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'colors_nonce')) {
            wp_die();
        }

        try {

            $colors = isset($_POST['data']) ? $_POST['data'] : array();

            if (empty($colors)) {
                $colors = $this->colors;
            }

            update_option('safw_padd_colors', $colors);

            wp_send_json(array(
                'status' => 'success',
                'colors' => $colors
            ));
        } catch (\Exception $e) {

            wp_send_json(array(
                'status' => 'error',
                'message' => $e->getMessage()
            ));
        }
    }

    /**
     * Delete cache
     * 
     * @since 1.0
     */
    public function safw_settings_delete_cache()
    {

        if (!defined('DOING_AJAX') || !DOING_AJAX) {
            wp_die();
        }

        /**
         * Verify nonce
         */
        if (isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'delete_cache_nonce')) {
            wp_die();
        }

        try {

            global $safw;

            $safw->cron->safw_delete_json_cache_execute();

            wp_send_json(array(
                'status' => 'success',
            ));
        } catch (\Exception $e) {

            wp_send_json(array(
                'status' => 'error',
                'message' => $e->getMessage()
            ));
        }
    }
}
