<?php 

# # # # # # # # # # # # # # # # # # # # 
// TEMPLATE RENDERING \\ ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # # 

/**
 * Get the filename of the previous file in the backtrace.
 * Use $level to move further through the backtrace.
 * Provide $extension to remove from return value.
 */
function get_backtrace_filename ( int $level = 0, string $extension = '' ) {
    $backtrace = debug_backtrace();
    $last_file = $backtrace[$level]['file'];
    $path_arr = explode( '/', $last_file );
    $file = end( $path_arr );
    if ( strlen( $extension ) > 0 ) {
        $file = str_replace( $extension, '', $file );
    }
    return $file;
}

/**
 * Shortcut for Timber::render
 * Context generated from global $state array
 */
function render_view () {
    global $state;
    $view = get_backtrace_filename( 1, '.php' );
    $context = Timber::get_context();
    foreach ( $state as $key => $value ) {
        $context[$key] = $value;
    }
    Timber::render( "/views/$view.twig", $context );
}

/**
 * Shortcut for Timber::compile
 * Context generated from global $state array
 */
function compile_view () {
    global $state;
    $view = get_backtrace_filename( 1, '.php' );
    $context = Timber::get_context();
    foreach ( $state as $key => $value ) {
        $context[$key] = $value;
    }
    return Timber::compile( "views/$view.twig", $context );
}