<?php

# # # # # # # # # # # # # # # # # # # #
# GLOBALS ~ * ~ * ~ * ~ * ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # #

define( 'DIR', get_stylesheet_directory() );
define( 'ENV', getenv(WP_ENVIRONMENT) );
$state = [];

# # # # # # # # # # # # # # # # # # # #
# INCLUDES ~ * ~ * ~ * ~ * ~ * ~ * ~ * 
# # # # # # # # # # # # # # # # # # # #
require_once( DIR . '/_utilities.php' );

# # # # # # # # # # # # # # # # # # # #
# THEME SETUP ~ * ~ * ~ * ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # #

add_theme_support( 'post-thumbnails' ); 

# # # # # # # # # # # # # # # # # # # #
# PAGE TITLES ~ * ~ * ~ * ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # #

function custom_page_title () {
    if ( is_front_page() )  return get_bloginfo( 'description' );
    if ( is_home() )        return 'Posts';
    if ( is_archive() )     return 'Archive';
    if ( is_404() )         return 'Error 404 Not Found';
    if ( is_category() )    return 'Category Archive for ' . single_cat_title();
    if ( is_tag() )         return 'Tag Archive for ' . single_tag_title();
    if ( is_search() )      return 'Search Results for ' . wp_specialchars( $s );
    return get_the_title();
}

# # # # # # # # # # # # # # # # # # # #
# MENUS & NAVIGATION ~ * ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # #

// Create Menus
function wps_register_nav_menus () {
    register_nav_menu( 'primary', 'Primary Menu');
    register_nav_menu( 'footer', 'Footer Menu');
}

add_action( 'after_setup_theme', 'wps_register_nav_menus' );

// Get Nested Menu Items (alternate to wp_get_nav_menu_items)
function wps_get_nav_menu_items ( $menu, $args ) {
    $menu = wp_get_nav_menu_items( $menu, $args );
    
    function move_to_parents ( $target, $current_item ) {
        foreach ( $target as $key => $value ) {
            if ( $value->ID == $current_item->menu_item_parent ) {
                if ( ! $target[$key]->subMenu ) $target[$key]->{"subMenu"} = [];
                $target[$key]->subMenu[] = $current_item;
                return true;
            }
            if ( $value->subMenu ) {
                move_to_parents( $value->subMenu, $current_item );
            }
        }
        return false;
    }

    $i = 0;
    $loops = 0;
    $max_loops = count($menu);
    while ( $loops <= $max_loops ) {
        // If parent exists, find and nest it
        if ( $menu[$i]->menu_item_parent != '0' ) {
            move_to_parents($menu, $menu[$i]);
            // Remove the original item, and add another loop
            unset($menu[$i]);
            $loops++;
        }
        $i++;
        $loops++;
    }

    return $menu;
}