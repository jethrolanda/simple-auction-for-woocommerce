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
            'Auctions',
            'Auctions',
            'edit_posts',
            'auction_settings',
            array($this, 'auction_settings_page'),
            'dashicons-hammer'
        );
    }

    /**
     * Display content to the new added custom wp admin menu.
     * 
     * @since 1.0
     */
    public function auction_settings_page()
    {
?>
        <div class="wrap">
            <div id="auctions-settings">
                <h2>Loading...</h2>
            </div>
        </div>
<?php
    }
}
