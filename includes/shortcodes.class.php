<?php

namespace SAFW\Plugin;

/**
 * @since   1.0
 */

defined('ABSPATH') || exit;

/**
 * WP Settings Class.
 */
class Shortcodes
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
    public function __construct() {}

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
}
