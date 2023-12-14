<?php 


    $user_id = do_shortcode('[ID]');
    $where_query = get_posts_by_author_sql('osetin_review', $user_id);
    
  
    // get post ID with title "Hello world!" query
    global $wpdb;
    $query = "SELECT ID FROM $wpdb->posts $where_query ORDER BY ID DESC LIMIT 1";
    $review_id = $wpdb->get_var( $wpdb->prepare( $query ) );

    $post_id = get_post_meta($review_id, 'recipe', true);;

    echo '<div></strong>Receita:</strong> <a href="'.get_permalink( $post_id ).'#osetinRecipeReviews">'.get_the_title( $post_id ).'</a></div>';
    
    

?>