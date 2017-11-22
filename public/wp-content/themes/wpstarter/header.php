<?php 

global $state;
$state['lang'] = get_language_attributes();
$state['charset'] = get_bloginfo( 'charset' );
$state['siteTitle'] = get_bloginfo( 'name' );
$state['siteDescription'] = get_bloginfo( 'description', 'display' );
$state['bodyClass'] = 'class="' . implode( ' ', get_body_class() ) . '"';
$state['homeURL'] = esc_url( home_url( '/' ) );

// Let's build some menu data! It's harder than it needs to be!
$locations = get_nav_menu_locations();
$menu_term = get_term( $locations['primary'], 'nav_menu' );
$state['menu'] = wps_get_nav_menu_items( $menu_term->term_id, ['order' => 'DESC'] );

echo '<pre>';
print_r( $state['menu'] );
echo '</pre>';

ob_start();
wp_head();
$state['wpHead'] = ob_get_clean();

render_view( 'head' );