<?php 

global $state;

ob_start();
wp_footer();
$state['wpFooter'] = ob_get_clean();

render_view();