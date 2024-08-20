<?php

namespace SAFW\Plugin;

/**
 * Scripts class
 *
 * @since   1.0
 */

defined('ABSPATH') || exit;

class Scripts
{

    /**
     * The single instance of the class.
     *
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Class constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        // Load Backend CSS and JS
        add_action('admin_enqueue_scripts', array($this, 'load_front_end_styles_and_scripts'));

        // Load Frontend CSS and JS
        add_action('wp_enqueue_scripts', array($this, 'load_front_end_styles_and_scripts'));

        // For compatibility with oxygen plugin
        // add_action('oxygen_enqueue_frontend_scripts', array($this, 'load_oxygen_scripts'));
        add_action('wp_print_footer_scripts', array($this, 'load_oxygen_scripts'), 99999);
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
     * Only load scripts on page that is being used
     *
     * @since 1.0
     */
    public function load_front_end_styles_and_scripts()
    {

        global $post;

        $usa_gas_prices_chart_exist = false;
        $usa_gas_prices_table_exist = false;
        $display_current_average_price_exist = false;
        $usa_padd_prices_exist = false;

        if ($post && $post->ID) {
            $shortcodes = get_post_meta($post->ID, "_ct_builder_shortcodes", true);
            if (strpos($shortcodes, 'usa_gas_prices_chart') !== false) {
                $usa_gas_prices_chart_exist = true;
            }
            if (strpos($shortcodes, 'usa_gas_prices_table') !== false) {
                $usa_gas_prices_table_exist = true;
            }
            if (strpos($shortcodes, 'display_current_average_price') !== false) {
                $display_current_average_price_exist = true;
            }
            if (strpos($shortcodes, 'usa_padd_prices') !== false) {
                $usa_padd_prices_exist = true;
            }
        }

        if ($usa_gas_prices_chart_exist || $usa_gas_prices_table_exist || $display_current_average_price_exist || $usa_padd_prices_exist) {
            wp_enqueue_style('safw-style', SAFW_CSS_ROOT_URL . 'style.min.css');
        }

        if ($usa_gas_prices_chart_exist || ($post && has_shortcode($post->post_content, 'usa_gas_prices_chart'))) {

            $this->gas_prices_chart_scripts();
        }

        if ($usa_padd_prices_exist || ($post && has_shortcode($post->post_content, 'usa_padd_prices'))) {

            $this->usa_padd_prices_scripts();
        }

        // Backend Settings Page React App
        if (isset($_GET['page']) && $_GET['page'] == 'gas_prices_settings') {
            wp_enqueue_style('safw-setting-style', SAFW_JS_ROOT_URL . 'settings/build/index.css');
            wp_enqueue_script('safw-setting-script', SAFW_JS_ROOT_URL . 'settings/build/index.js', array('wp-element', 'wp-i18n'), '1.0.0', true);
            wp_localize_script('safw-setting-script', 'safw_settings', array(
                'rest_url'   => esc_url_raw(get_rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'ajax_url' => admin_url('admin-ajax.php'),
                'settings_nonce' => wp_create_nonce('settings_nonce'),
                'delete_cache_nonce' => wp_create_nonce('delete_cache_nonce'),
            ));
        }
    }

    /**
     * Load scripts
     *
     * @since 1.0
     */
    public function gas_prices_chart_scripts()
    {

        wp_enqueue_style('safw-chart-style', SAFW_JS_ROOT_URL . 'safw-chart/build/index.css');
        wp_enqueue_script('safw-chart-script', SAFW_JS_ROOT_URL . 'safw-chart/build/index.js', array('wp-element', 'wp-i18n'), '1.0.0', true);
        wp_localize_script('safw-chart-script', 'safw_gas_prices_chart', array(
            'rest_url'   => esc_url_raw(get_rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'colors_nonce' => wp_create_nonce('colors_nonce'),
        ));
    }

    /**
     * Load scripts
     *
     * @since 1.0
     */
    public function usa_padd_prices_scripts()
    {

        wp_enqueue_style('usa-padd-prices-style', SAFW_JS_ROOT_URL . 'usa-padd-prices/build/index.css');
        wp_enqueue_script('usa-padd-prices-script', SAFW_JS_ROOT_URL . 'usa-padd-prices/build/index.js', array('wp-element', 'wp-i18n'), '1.0.0', true);
        wp_localize_script('usa-padd-prices-script', 'safw_padd_prices', array(
            'rest_url'   => esc_url_raw(get_rest_url()),
            'nonce' => wp_create_nonce('wp_rest'),
            'ajax_url' => admin_url('admin-ajax.php'),
            'gas_and_diesel_week_data_nonce' => wp_create_nonce('gas_and_diesel_week_data_nonce'),
            'colors_nonce' => wp_create_nonce('colors_nonce'),
        ));
    }

    /**
     * Load scripts
     *
     * @since 1.0
     */
    public function load_oxygen_scripts()
    {

        global $post;

        if ($post && $post->ID) {
            $shortcodes = get_post_meta($post->ID, "_ct_builder_shortcodes", true);
            if (strpos($shortcodes, 'usa_gas_prices_chart') !== false) {
                $this->gas_prices_chart_scripts();
            }
            if (strpos($shortcodes, 'usa_padd_prices') !== false) {
                $this->usa_padd_prices_scripts();
            }
        }
    }
}
