<?php 

global $state;
$state['lang'] = get_language_attributes();
$state['charset'] = get_bloginfo( 'charset' );
$state['siteTitle'] = get_bloginfo( 'name' );
$state['siteDescription'] = get_bloginfo( 'description', 'display' );
$state['bodyClass'] = 'class="' . implode( ' ', get_body_class() ) . '"';
$state['homeURL'] = esc_url( home_url( '/' ) );

ob_start();
wp_head();
$state['wpHead'] = ob_get_clean();

render_view();