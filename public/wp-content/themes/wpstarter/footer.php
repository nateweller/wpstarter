<?php 

global $state;

// wpFooter
ob_start(); wp_footer();
$state['wpFooter'] = ob_get_clean();

// debugger
if ( ENV === 'development' ) { 
    ob_start(); debugger(); 
    $state['debugger'] = ob_get_clean();
}

render_view();