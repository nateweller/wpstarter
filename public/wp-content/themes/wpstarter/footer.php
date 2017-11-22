<?php 

global $state;

// debugger
if ( ENV === 'development' ) { 
    ob_start(); debugger(); 
    $state['debugger'] = ob_get_clean();
}

render_view();