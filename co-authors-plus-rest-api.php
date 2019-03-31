<?php
/*
 * Plugin Name: Co-Authors Plus Rest API
 * Description: Simple plugin to include co-authors in posts via WP Rest API.
 * Version: 0.0.2
 * License: GPL2+
*/
if ( function_exists('get_coauthors') ) {
    add_action( 'rest_api_init', 'custom_register_coauthors' );
    function custom_register_coauthors() {
        register_rest_field( 'post',
            'coauthors',
            array(
                'get_callback'    => 'custom_get_coauthors',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }

    function custom_get_coauthors( $object, $field_name, $request ) {
        $coauthors = get_coauthors($object['id']);

        $authors = array();
        foreach ($coauthors as $author) {
            $authors[] = array(
                'id' => $author->id,
                'display_name' => $author->display_name,
                'user_nicename' => $author->user_nicename
            );
        };

        return $authors;
    }
}