<?php

namespace SAFW\Plugin;

defined('ABSPATH') || exit(); // Exit if accessed directly.

class Auction_CPT
{

  /**
   * The single instance of the class.
   *
   * @since 1.0
   */
  protected static $_instance = null;

  /**
   * Auction_CPT constructor
   *   
   * @access public
   * @since 1.0
   */
  public function __construct()
  {
    add_action('init', array($this, 'auctions_post_type'), 0);

    // Register new custom meta fields
    // add_action('rest_api_init', array($this, 'register_custom_meta_fields'));
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
   * Register custom post type 'Auctions'
   *   
   * @access public
   * @since 1.0
   */
  public function auctions_post_type()
  {

    $labels = array(
      'name'                  => _x('Auctions', 'Post Type General Name', 'simple-auctions-for-woocommerce'),
      'singular_name'         => _x('Auction', 'Post Type Singular Name', 'simple-auctions-for-woocommerce'),
      'menu_name'             => __('Auctions', 'simple-auctions-for-woocommerce'),
      'name_admin_bar'        => __('Auction', 'simple-auctions-for-woocommerce'),
      'archives'              => __('Item Archives', 'simple-auctions-for-woocommerce'),
      'attributes'            => __('Item Attributes', 'simple-auctions-for-woocommerce'),
      'parent_item_colon'     => __('Parent Item:', 'simple-auctions-for-woocommerce'),
      'all_items'             => __('All Auctions', 'simple-auctions-for-woocommerce'),
      'add_new_item'          => __('Add New Item', 'simple-auctions-for-woocommerce'),
      'add_new'               => __('Add New', 'simple-auctions-for-woocommerce'),
      'new_item'              => __('New Item', 'simple-auctions-for-woocommerce'),
      'edit_item'             => __('Edit Item', 'simple-auctions-for-woocommerce'),
      'update_item'           => __('Update Item', 'simple-auctions-for-woocommerce'),
      'view_item'             => __('View Item', 'simple-auctions-for-woocommerce'),
      'view_items'            => __('View Auctions', 'simple-auctions-for-woocommerce'),
      'search_items'          => __('Search Item', 'simple-auctions-for-woocommerce'),
      'not_found'             => __('Not found', 'simple-auctions-for-woocommerce'),
      'not_found_in_trash'    => __('Not found in Trash', 'simple-auctions-for-woocommerce'),
      'featured_image'        => __('Featured Image', 'simple-auctions-for-woocommerce'),
      'set_featured_image'    => __('Set featured image', 'simple-auctions-for-woocommerce'),
      'remove_featured_image' => __('Remove featured image', 'simple-auctions-for-woocommerce'),
      'use_featured_image'    => __('Use as featured image', 'simple-auctions-for-woocommerce'),
      'insert_into_item'      => __('Insert into item', 'simple-auctions-for-woocommerce'),
      'uploaded_to_this_item' => __('Uploaded to this item', 'simple-auctions-for-woocommerce'),
      'items_list'            => __('Auctions list', 'simple-auctions-for-woocommerce'),
      'items_list_navigation' => __('Auctions list navigation', 'simple-auctions-for-woocommerce'),
      'filter_items_list'     => __('Filter auctions list', 'simple-auctions-for-woocommerce'),
    );

    $args = array(
      'label'                 => __('Order', 'simple-auctions-for-woocommerce'),
      'description'           => __('Fuel Logic Auctions', 'simple-auctions-for-woocommerce'),
      'labels'                => $labels,
      'supports'              => array('title', 'author'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'post',
      'show_in_rest'          => true,
    );

    register_post_type('auctions', $args);
  }

  /**
   * Register custom meta fields for 'Auctions' CPT
   *   
   * @access public
   * @since 1.0
   */
  public function register_custom_meta_fields()
  {

    // Register new custom meta
    register_rest_field(
      'orders',
      '_fuel_logic_app_order_meta',
      // NEW CODE
      array(
        // Get meta value
        'get_callback' => function ($object) {
          $meta = get_post_meta($object['id'], '_fuel_logic_app_order_meta', true);
          return $meta;
        },
        // Update meta value
        'update_callback' => function ($value, $object) {
          update_post_meta($object->ID, '_fuel_logic_app_order_meta', $value);
        },
        'schema' => array(
          'type' => 'json', // the type of value we expect to be passed back
          'sanitize_callback' => function ($value) {
            // run sanitization here
          },
          'validate_callback' => function ($value) {
            // run sanitization here
          },
        )
      )
    );

    register_rest_field(
      'orders',
      '_fuel_logic_app_order_site_contact',
      // NEW CODE
      array(
        // Get meta value
        'get_callback' => function ($object) {

          if ($object['author'] > 0) {
            $user = new \WP_User($object['author']);
            return $user->first_name . ' ' . $user->last_name;
          }
        },
        // Update meta value
        'update_callback' => function ($value, $object) {
          // update_post_meta($object->ID, '_fuel_logic_app_order_site_contact', $value);
        },
        'schema' => array(
          'type' => 'string', // the type of value we expect to be passed back
          'sanitize_callback' => function ($value) {
            // run sanitization here
          },
          'validate_callback' => function ($value) {
            // run sanitization here
          },
        )
      )
    );
  }
}
