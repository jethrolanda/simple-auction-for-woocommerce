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
        add_action('admin_enqueue_scripts', array($this, 'backend_script_loader'));

        // Load Frontend CSS and JS
        add_action('wp_enqueue_scripts', array($this, 'frontend_script_loader'));
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
     * Load wp admin backend scripts
     *
     * @since 1.0
     * @return bool
     */
    public function backend_script_loader()
    {

        // datetimepicker
        wp_enqueue_script('safw-datetimepicker-script', SAFW_PLUGIN_URL . 'js/lib/datetimepicker/jquery.datetimepicker.full.min.js', array(), '', true);
        wp_enqueue_style('safw-datetimepicker-style', SAFW_PLUGIN_URL . 'js/lib/datetimepicker/jquery.datetimepicker.min.css');

        wp_enqueue_script('safw-edit-product-script', SAFW_PLUGIN_URL . 'js/edit-product.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '', true);
    }

    /**
     * Load wp frontend scripts
     *
     * @since 1.0
     * @return bool
     */
    public function frontend_script_loader()
    {
        global $product;

        if ($product && $product->get_type() === 'auction') {

            // Styles
            wp_enqueue_style('safw-frontend-styles', SAFW_PLUGIN_URL . 'css/style.min.css', array(), '');

            // Countdown
            wp_enqueue_script('safw-product-countdown-script', SAFW_PLUGIN_URL . 'js/countdown.js', array(), '', true);

            // Bid
            wp_enqueue_script('safw-product-bid-script', SAFW_PLUGIN_URL . 'js/bid.js', array(), '', true);
            wp_localize_script('safw-product-bid-script', 'bid_script', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'uid' => get_current_user_id(),
                'pid' => $product->get_id(),
            ));

            // Interactivity api // wp_register_script_module
            wp_enqueue_script_module('clickme', SAFW_PLUGIN_URL . 'js/clickme.js', ['@wordpress/interactivity'], false);
        }
    }
}
