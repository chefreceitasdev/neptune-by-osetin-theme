<?php

/* === Add Thumbnails to Posts/Pages List === */
if ( !function_exists('o99_add_thumbs_column_2_list') && function_exists('add_theme_support') ) {

    //  // set your post types , here it is post and page...
    add_theme_support('post-thumbnails', array( 'post', 'page' ) );

    function o99_add_thumbs_column_2_list($cols) {

        $cols['thumbnail'] = __('Thumbnail');

        return $cols;
    }

    function o99_add_thumbs_2_column($column_name, $post_id) {

            $w = (int) 60;
            $h = (int) 60;

            if ( 'thumbnail' == $column_name ) {
                // back comp x WP 2.9
                $thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
                // from gal
                $attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
                if ($thumbnail_id)
                    $thumb = wp_get_attachment_image( $thumbnail_id, array($w, $h), true );
                elseif ($attachments) {
                    foreach ( $attachments as $attachment_id => $attachment ) {
                        $thumb = wp_get_attachment_image( $attachment_id, array($w, $h), true );
                    }
                }
                    if ( isset($thumb) && $thumb ) {
                        echo $thumb;
                    } else {
                        echo __('None');
                    }
            }
    }

    // for posts
    add_filter( 'manage_posts_columns', 'o99_add_thumbs_column_2_list' );
    add_action( 'manage_posts_custom_column', 'o99_add_thumbs_2_column', 10, 2 );

    // for pages
    add_filter( 'manage_pages_columns', 'o99_add_thumbs_column_2_list' );
    add_action( 'manage_pages_custom_column', 'o99_add_thumbs_2_column', 10, 2 );
}