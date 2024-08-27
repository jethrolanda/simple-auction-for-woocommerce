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

        add_action('admin_enqueue_scripts', array($this, 'backend_script_loader'));
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

    public function backend_script_loader()
    {

        // datetimepicker
        wp_enqueue_script('safw-datetimepicker-script', SAFW_PLUGIN_URL . 'js/lib/datetimepicker/jquery.datetimepicker.full.min.js', array(), '', true);
        wp_enqueue_style('safw-datetimepicker-style', SAFW_PLUGIN_URL . 'js/lib/datetimepicker/jquery.datetimepicker.min.css');

        wp_enqueue_script('safw-edit-product-script', SAFW_PLUGIN_URL . 'js/edit-product.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '', true);
    }
}
