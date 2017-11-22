<?php 

global $state;

// menu
$locations = get_nav_menu_locations();
$menu_term = get_term( $locations['primary'], 'nav_menu' );
$state['menu'] = wps_get_nav_menu_items( $menu_term->term_id, ['order' => 'DESC'] );

render_view( 'head' );