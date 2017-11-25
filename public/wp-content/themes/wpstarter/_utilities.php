<?php 

# # # # # # # # # # # # # # # # # # # # 
// DEVELOPMENT TOOLS \\ ~ * ~ * ~ * ~ *
# # # # # # # # # # # # # # # # # # # # 

// Show all PHP messages
if ( ENV === 'development' ) {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}

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

// TODO: these fns use get_backtrace_filename() with a fixed trace # which is not good

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
 * Create an array of data for Timber
 * Includes Timber::get_context, Timber::get_post, global $state, and args
 */
function load_timber_data ( string $view = '', array $variables = [] ) {
    global $state;
    $view = ($view !== '') ? $view : get_backtrace_filename( 2, '.php' );
    $context = Timber::get_context();
    $context['post'] = Timber::get_post();
    $context['posts'] = new Timber\PostQuery();
    foreach ( $state as $key => $value ) {
        $context[$key] = $value;
    }
    foreach ( $variables as $key => $value ) {
        $context[$key] = $value;
    }
    return [ 'view' => $view, 'context' => $context ];
}

/**
 * Shortcut for Timber::render
 */
function render_view ( string $view = '', array $variables = [] ) {
    $timber_data = load_timber_data( $view, $variables );
    // debug( $timber_data );
    Timber::render( "/views/{$timber_data['view']}.twig", $timber_data['context'] );
}

/**
 * Shortcut for Timber::compile
 */
function compile_view ( string $view = '', array $variables = [] ) {
    $timber_data = load_timber_data( $view, $variables );
    return Timber::compile( "/views/{$timber_data['view']}.twig", $timber_data['context'] );
}

/**
 * Render the current template's view with the header and footer
 * Use this for any template that doesn't need extra logic (i.e. 404.php)
 */
function render_template ( string $view = '' ) {
    $view = ($view !== '') ? $view : get_backtrace_filename( 4, '.php' );
    get_header();
    render_view( $view );
    get_footer();
}

/**
 * Return the output of a function.
 */
function catch_output ( $fn ) {
    ob_start(); $fn();
    return ob_get_clean();
}