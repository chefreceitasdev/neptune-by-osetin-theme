<?php 



    /*
    *  FUNCTION: Display widget showing total views for each recipe
    *
    *   @param   mixed   $id     Post ID.
    *   @param   bool    $blog_id Blog ID.
    *   @return  int     Post count
    */
    function recipe_visualizations( $id = false, $blog_id = false ) {
        global $wpdb;

        $table_name       = $wpdb->base_prefix . 'top_ten';

        if ( empty( $blog_id ) ) {
            $blog_id = get_current_blog_id();
        }
        
        if ( $id > 0 ) {
        
            $resultscount = $wpdb->get_row( $wpdb->prepare( "SELECT postnumber, cntaccess as visits FROM {$table_name} WHERE postnumber = %d AND blog_id = %d ", $id, $blog_id ) );
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
 
            $visits = ( $resultscount ) ? $resultscount->visits : 0;
            $string = tptn_number_format_i18n( $visits );

            return apply_filters( 'tptn_post_count_only', $string, $id, 'total', $blog_id );
	
        } else {
            return 0;
        }
    }
	/*
	 * Display widget that shows top 5 more likes = MAIS CURTIDAS
	 */

    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM wp_posts LEFT JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id WHERE wp_posts.post_type = 'osetin_recipe' AND wp_postmeta.meta_key = '_osetin_vote' AND wp_posts.ID > 310 ORDER BY wp_posts.ID DESC" );

    
    foreach( $results as $post) {
        
        $id = $post->ID;
        $titulo = $post->post_title;
        $meta_curtidas = get_post_meta($id, '_osetin_vote', true);
        // $meta_bookmark = get_post_meta($id, 'post_bookmark_count', true);
        $meta_bookmark = get_post_meta($id, 'simplefavorites_count', true);
        $meta_link = get_permalink( $id ); 
        
        if ((int)$meta_curtidas > 0) {

            $newdata =  array (
                'curtidas' => (int)$meta_curtidas,
                'favoritos' => (int)$meta_bookmark,
                'titulo' => $titulo,
                'id' => $id,
                'link' => $meta_link
            );
        
            // for recipe        
           $md_array["receitas_mais_votadas"][] = $newdata;
        }        
    }

    // Reordena o array decrescente o numero de curtidas
   if ($md_array["receitas_mais_votadas"]) {
     arsort($md_array["receitas_mais_votadas"]);  
   }
   
   $count_list = 0;

    // DIV DO CONTAINER DO WIDGET
    echo '<div class="top5-curtidas-widget">';

    foreach( $md_array["receitas_mais_votadas"] as $lista ) {
        $count_list++;
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $lista['id'] ), 'large' );    
        
        if ( ! empty( $large_image_url[0] ) ) {

            echo '<div class="closed" id="container-'.$count_list.'">
            <header id="toggle-'.$count_list.'" style="background-image: url('. $large_image_url[0] .');  background-size: cover; background-position-x: center;">
            <div class="toplikes-header"></div>
            <div class="toplikes-title">'. $lista['titulo'] . '</div></header>';       
        }       
        
        echo '<article class="toplikes-row article-toplikes"><div class="toplikes-column">';
        echo '<ul class="toplikes-status">
        <li> 
          <div class="toplike-titulo">Visualizações:</div>
          <div class="toplike-status">';
        echo recipe_visualizations($lista['id']);          
        echo '</div>
        </li>
        <li> 
          <div class="toplike-titulo">Curtidas:</div>
          <div class="toplike-status">';
        echo $lista['curtidas'];
        echo '</div>
        </li>
        <li> 
          <div class="toplike-titulo">Favoritada:</div>
          <div class="toplike-status">';
        echo $lista['favoritos'];     
        echo '</div></li></ul></div>';

        echo '<div class="toplikes-column">';      
        
        echo '<div><div class="div-recipe-template-snippet-button-chef-receitas"><a href="' . $lista['link'] . '" title="Aprenda agora a fazer a Receita de ' . $lista['titulo'] . '" class="link-recipe-template-snippet-button-chef-receitas" data-smooth-scroll="500"><span class="toplikes-btn-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 24 24"><g><path data-color="color-2" fill="#ff0000" d="M13,21h-2H5v2c0,0.6,0.4,1,1,1h12c0.6,0,1-0.4,1-1v-2H13z"></path><path fill="#ff0000" d="M18,4c-0.1,0-0.2,0-0.3,0c-0.8-2.3-3-4-5.7-4S7.2,1.7,6.3,4C6.2,4,6.1,4,6,4c-3.3,0-6,2.7-6,6c0,3,2.2,5.4,5,5.9V19h6v-4h2v4h6v-3.1c2.8-0.5,5-2.9,5-5.9C24,6.7,21.3,4,18,4z"></path></g></svg></span> Visualizar</a></div></div></div></article></div>';

        if($count_list == 5) {
            break;
        }        
    }   

    // FINAL DIV CONTAINER DO WIDGET
    echo '</div>';

?>