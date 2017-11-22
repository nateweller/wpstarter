<?php 

# # # # # # # # # # # # # # # # # # # # 
// DEVELOPMENT TOOLS \\ ~ * ~ * ~ * ~ *
# # # # # # # # # # # # # # # # # # # # 

// Print formatted output at the top of the page.
$debugger = [];
function debug ( $output ) { global $debugger; $debugger[] = $output; }
function debugger () { 
    global $debugger;
    echo '<div id="debugger">';
    foreach ( $debugger as $output ) {
        if ( is_iterable( $output ) ) {
            echo '<pre>';
            print_r( $output );
            echo '</pre>';
        } else {
            echo $output;
        }
        echo '<hr>';
    }
    echo '</div>';
    echo '
        <script>
        (function () {
            var debug = document.querySelector("#debugger");
            var body = document.querySelector("body");
            while (debug.childNodes.length > 0) {
                body.prepend(debug.childNodes[debug.childNodes.length - 1]);
            }
        }());
        </script>
    ';
}

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
 */
function render_view ( string $view = '', array $variables = [] ) {
    global $state;
    $view = ($view !== '') ? $view : get_backtrace_filename( 1, '.php' );
    $context = Timber::get_context();
    foreach ( $state as $key => $value ) {
        $context[$key] = $value;
    }
    foreach ( $variables as $key => $value ) {
        $context[$key] = $value;
    }
    Timber::render( "/views/$view.twig", $context );
}

/**
 * Shortcut for Timber::compile
 */
function compile_view ( string $view = '', array $variables = [] ) {
    global $state;
    $view = ($view !== '') ? $view : get_backtrace_filename( 1, '.php' );
    $context = Timber::get_context();
    foreach ( $state as $key => $value ) {
        $context[$key] = $value;
    }
    return Timber::compile( "views/$view.twig", $context );
}

/**
 * Return the output of a function.
 */
function catch_output ( $fn ) {
    ob_start(); $fn();
    return ob_get_clean();
}

# # # # # # # # # # # # # # # # # # # # 
// DATA OPERATIONS \\ ~ * ~ * ~ * ~ * ~
# # # # # # # # # # # # # # # # # # # # 

/**
 * Find an array or object in another array, by array/object key value
 * Returns array/object index (int) or false
 */
function search_2D_array ( $arr, string $search_key, string $search_value ) {
    foreach ( $arr as $key => $value ) {
        $match_check = is_array( $value ) 
                    ? $value['search_key'] == $search_value
                    : $value->{"$search_key"} == $search_value;
        if ( $match_check ) return $key;
    }
    return false;
}

// function search_multiD_array ( $arr, string $search_key, string $search_value ) {
//     $target = $arr;
//     $matched = false;
//     foreach ( $arr as $key => $value ) {
//         while ( ! $matched ) {
//             $search = search_2D_array( $target, $search_key, $search_value );

//         }
//     }
// }