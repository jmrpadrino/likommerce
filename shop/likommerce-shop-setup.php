<?php

functionlk24_template_redirect_checkout( ){
    if ($_SERVER['REQUEST_URI'] == 'schnellbugel-checkout') {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(LIKOMMERCE_PLUGIN_DIR . 'shop/templates/likommerce-checkout.php');
        exit();
    }
}
add_action( 'template_redirect', 'lk24_template_redirect_checkout' );

function schn_force_template( $template )
{	
    if( is_post_type_archive( 'schtra_events' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR 
            . 'frontend/templates/archive-schtra_events.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        
        $archive_file = scandir($active_template);
        $found = array_search('archive-schtra_events.php', $archive_file);
        
        if ($found){
            $template = $active_template . '/archive-schtra_events.php';
        }
    }
        
    if( is_post_type_archive( 'schtra_expert' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR 
            . 'frontend/templates/archive-schtra_expert.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        
        $archive_file = scandir($active_template);
        $found = array_search('archive-schtra_expert.php', $archive_file);
        
        if ($found){
            $template = $active_template . '/archive-schtra_expert.php';
        }
    }
    
    if( is_post_type_archive( 'schtra_training' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR 
            . 'frontend/templates/archive-schtra_training.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        
        $archive_file = scandir($active_template);
        $found = array_search('archive-schtra_training.php', $archive_file);
        
        if ($found){
            $template = $active_template . '/archive-schtra_training.php';
        }
    }
    if( is_singular( 'schtra_training' ) || is_single( 'schtra_training' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'frontend/templates/single-schtra_training.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-schtra_training.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-schtra_training.php';
        }
    }
    if( is_singular( 'schtra_expert' ) || is_single( 'schtra_expert' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'frontend/templates/single-schtra_expert.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-schtra_expert.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-schtra_expert.php';
        }
    }
    
    if( is_singular( 'schtra_events' ) || is_single( 'schtra_events' ) ) {
        // Use Plugin template
        $template = LIKOMMERCE_PLUGIN_DIR
            . 'frontend/templates/single-schtra_events.php';
        // to override archive template
        $active_template = TEMPLATEPATH;
        if (is_child_theme()){
            $active_template = STYLESHEETPATH;
        }
        $archive_file = scandir($active_template);
        $found = array_search('single-schtra_events.php', $archive_file);
        if ($found){
            $template = $active_template . '/single-schtra_events.php';
        }
    }
    return $template;
}
add_filter( 'template_include', 'schn_force_template' );