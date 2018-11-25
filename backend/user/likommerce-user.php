<?php

function lk24_sales_management_role() {
    add_role('lk24shopadmin',
        __('Shop Administrator', 'likommerce'),
        array(
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'publish_posts' => false,
            'upload_files' => false,
        )
    );
}
add_action('admin_init','lk24_sales_management_role',50);

function go_add_role_caps() {
 
     // Add the roles you'd like to administer the custom post types
     $roles = array('lk24shopadmin', 'administrator');
     // Loop through each role and assign capabilities
     foreach($roles as $the_role) { 
          $role = get_role($the_role);
          $role->add_cap( 'read' );
          $role->add_cap( 'read_lk24-sale');
          $role->add_cap( 'read_private_lk24-sale' );
          $role->add_cap( 'edit_lk24-sale' );
          $role->add_cap( 'edit_lk24-sale' );
          $role->add_cap( 'edit_others_lk24-sale' );
          $role->add_cap( 'edit_published_lk24-sale' );
          $role->add_cap( 'delete_others_lk24-sale' );
          $role->add_cap( 'delete_private_lk24-sale' );
          $role->add_cap( 'delete_published_lk24-sale' );
          $role->remove_cap( 'publish_lk24-sale' );
    }
}
add_action('admin_init','go_add_role_caps',999);