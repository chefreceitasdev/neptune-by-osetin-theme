<?php // Opening PHP tag - nothing should be before this, not even whitespace
add_action( 'wp_enqueue_scripts', 'neptune_child_enqueue_styles' );
function neptune_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/***
 * 
 * 	ADD osetin_recipe, custom post type in Rest API
 *  Url: http://newchefreceitas.local/wp-json/wp/v2/recip
 * 
 */
/* 
add_action( 'init', 'add_recipes_to_json_api', 30 );
function add_recipes_to_json_api(){
    global $wp_post_types;
    $wp_post_types['osetin_recipe']->show_in_rest = true;
    $wp_post_types['osetin_recipe']->rest_base = 'recip';
    $wp_post_types['osetin_recipe']->rest_controller_class = 'WP_REST_Posts_Controller';
}  */




/****
 *	RANDON POST SESSION 
 * 
 */
function prefix_start_session() {
    if( !session_id() ) {
        session_start();
    }
}
add_action( 'init', 'prefix_start_session' );

/********
 * 
 * 
 * 	SHORTCODE CREATE BY Diego Fernandes
 * 
 * 
 */


function showChef_menu() {

	$menuchef = '<div class="chefadminApi">
		 <a href="/wp-admin/" rel="nofollow noopener noreferrer" title="Chef Admin">
		 <i class="fa fa-user-circle-o" aria-hidden="true"></i>
		 </a>
		</div>		
		<div class="submitreceitaApi">
		 <a href="/wp-admin/post-new.php?post_type=osetin_recipe" rel="nofollow noopener noreferrer" title="Envie um Receita!">
		 <i class="fa fa-cutlery" aria-hidden="true"></i>
		 </a>
		</div>			
		<div class="ingredientesApi">
		 <a href="/wp-admin/edit-tags.php?taxonomy=recipe_ingredient&post_type=osetin_recipe" rel="nofollow noopener noreferrer" title="Add Ingredientes">
		 <i class="fa fa-table" aria-hidden="true"></i>
		 </a>
		</div>';

	if ( is_user_logged_in() ) {
		$user = wp_get_current_user();
		
		//echo "<hr>User id: ";
		//print_r( $user );
		
		$roles = ( array ) $user->roles; // obtaining the role 
		/* switch ( $roles[0] ) {

			case 'administrator' :
				return $menuchef;
				break;
			case 'chef' :
				return $menuchef;
			} */
		
		//echo '<pre>' . print_r($roles) . '</pre>';  //     or $roles[0] == 'administrator' 
		if ($roles[0] == 'chef' or $roles[0] == 'administrator') {
			return $menuchef;
		}
		
	}


	$menuchef = '';
	return $menuchef;
	
	}

add_shortcode( 'show_chef_menu', 'showChef_menu' );


/**
 * 
 *  Button open modal My list of Favorites
 * 
 *  By: Diego Fernandes
 */
function showMyFavorites() {
	$autohidden_script = '<script>function showBtnFavorites() {
		var btnFavorites = document.getElementById("btn-user-favorites-recipes");	
		btnFavorites.classList.add("show-btn-user-favorites");
		
		setTimeout(function() {
			btnFavorites.classList.remove("show-btn-user-favorites");
		}, 6000 /* miliseconds */);
	  }	  
	  //window.onscroll = function() {
	  //showBtnFavorites();	  
	  //};
	  function btnMouseOver(x) {
			x.style.display = "block";
			x.style.opacity = 1;
			var btnFavorites = document.getElementById("btn-user-favorites-recipes");
			btnFavorites.classList.add("show-btn-user-favorites");
		}
		function btnMouseOut(x) {
			x.style.opacity = 0.5;
			var btnFavorites = document.getElementById("btn-user-favorites-recipes");	
			setTimeout(function() {
				btnFavorites.classList.remove("show-btn-user-favorites");
			}, 6000 /* miliseconds */);
		  }	  
	  </script>';

	$btn_favorites_list = '<div class="modal-user-favorites-list">
		 <a href="#" rel="nofollow noopener noreferrer" title="Lista de Favoritos">
		 <i class="sf-icon-star-full" aria-hidden="true"></i>
		 </a></div>';

	if ( is_user_logged_in() ) {
		    echo '<div class="modal-user-favorites-list" id="btn-user-favorites-recipes" onmouseover="btnMouseOver(this)" onmouseout="btnMouseOut(this)">';
			echo do_shortcode('[popup_anything id="19871"]');
			echo '</div>';
			echo $autohidden_script;

			//return $btn_favorites_list;	
	}
	else {
			$btn_favorites_list = '';
			return $btn_favorites_list;
	}
}

add_shortcode( 'show_my_favorites_list', 'showMyFavorites' );



/**
 * Add Delete Link to Display Posts Shortcode plugin
 * @see https://displayposts.com/2019/01/19/add-delete-post-link-if-user-has-permission-to-edit-content/
  */
  function be_dps_delete_link( $output, $atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class, $author, $category_display_text ) {

	if( empty( $atts['include_delete'] ) || true !== filter_var( $atts['include_delete'], FILTER_VALIDATE_BOOLEAN ) )
		return $output;

	if( ! current_user_can( 'edit_post', get_the_ID() ) )
		return $output;

	$edit_button = '<div class="btn-admin-chef"><a title="Editar Post" class="edit-post" href="' . get_edit_post_link( get_the_ID() ) . '"><i class="fa fa-edit" id="botao-edit"> </i></a>';
	
	
	$delete_button = '<a title="Deletar Post" class="delete-post" href="' . get_delete_post_link( get_the_ID() ) . '"><i class="fa fa-close" id="botao-delete"> </i></a></div>';
	$output = '<' . $inner_wrapper . ' class="' . implode( ' ', $class ) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . $edit_button . $delete_button . '</' . $inner_wrapper . '>';

	$output = $output1 . $output;

	return $output;
}
add_filter( 'display_posts_shortcode_output', 'be_dps_delete_link', 10, 11 );





/**
 * Plugin Name: Display Posts - Pagination
 * Plugin URI: https://github.com/billerickson/Display-Posts-Pagination
 * Description: Allow results of Display Posts to be paginated
 * Version: 1.0.0
 * Author: Bill Erickson
 * Author URI: https://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

/**
 * Display Posts -  Pagination Links
 *
 */
function be_dps_pagination_links( $output, $atts, $listing ) {
	if( empty( $atts['pagination'] ) || !empty( $atts['offset'] ) )
		return $output;

	global $wp;
	$base = home_url( $wp->request );

	$format = 'dps_paged';
	if( intval( $atts['pagination'] ) > 1 )
		$format .= '_' . intval( $atts['pagination'] );
	$format = '?' . $format . '=%#%';

	$current = !empty( $listing->query['paged'] ) ? $listing->query['paged'] : 1;

	$args = array(
		'base'		=> trailingslashit( $base ) . $format,
		'format'    => $format,
		'current'   => $current,
		'total'     => $listing->max_num_pages,
		'prev_text' => 'Anteriores <i class="fa fa-angle-double-left"></i>',
		'next_text' => '<i class="fa fa-angle-double-right"></i> Próximos',
	);

	$nav_output = '';
	$navigation = paginate_links( apply_filters( 'display_posts_shortcode_paginate_links', $args, $atts ) );
	if( $navigation ) {
    	$nav_output .= '<br><nav class="display-posts-pagination" role="navigation">';
        	$nav_output .= '<h2 class="screen-reader-text">Páginas</h2>';
        	$nav_output .= '<div class="nav-links">' . $navigation . '</div>';
		$nav_output .= '</nav>';
	}

	if( !empty( $atts['pagination_inside'] ) && filter_var( $atts['pagination_inside'], FILTER_VALIDATE_BOOLEAN ) )
		$output = $nav_output . $output;
	else
		$output .= $nav_output;

	return $output;
}
add_filter( 'display_posts_shortcode_wrapper_close', 'be_dps_pagination_links', 10, 3 );

/**
 * Display Posts - Pagination Args
 *
 */
function be_dps_pagination_args( $args, $atts ) {
	if( empty( $atts['pagination'] ) )
		return $args;

	$format = 'dps_paged';
	if( intval( $atts['pagination'] ) > 1 )
		$format .= '_' . intval( $atts['pagination'] );

	if( ! empty( $_GET[ $format ] ) )
		$args['paged'] = intval( $_GET[ $format ] );

	return $args;
}
add_filter( 'display_posts_shortcode_args', 'be_dps_pagination_args', 10, 2 );




/**
 * Display Posts - Post Count Title Placeholder
 * [dps_dynamic_post_count] will be filtered later after the query has run
 *
 * @see https://displayposts.com/2019/08/14/display-post-count-as-title-of-listing/
 *
 * @param array $out, the output array of shortcode attributes (after user-defined and defaults have been combined)
 * @param array $pairs, the supported attributes and their defaults
 * @param array $atts, the user defined shortcode attributes
 * @return array $out, modified output of shortcode attributes
 */

/* function be_dps_post_count_title_placeholder( $out, $pairs, $atts ) {
	if( empty( $atts['title'] ) )
		$out['title'] = '[dps_dynamic_post_count]';
	return $out;
}
add_filter( 'shortcode_atts_display-posts', 'be_dps_post_count_title_placeholder', 10, 3 ); */

/**
 * Display Posts - Post Count Title
 * Replace [dps_dynamic_post_count] with actual post count from $dps_listing
 * 
 * @see https://displayposts.com/2019/08/14/display-post-count-as-title-of-listing/
 *
 * @param string $output, the shortcode output
 * @param string $tag, the shortcode tag
 * @return string $output, the modified shortcode output
 */
function be_dps_post_count_title( $output, $tag ) {
	if( 'display-posts' !== $tag )
		return $output;

	global $dps_listing;
	if( !empty( $dps_listing->post_count ) ) {
		$title = sprintf( _n( '%d Post', '%d Posts', $dps_listing->post_count ), $dps_listing->post_count );
	} else {
		$title = '';
	}

	$output = str_replace( '[dps_dynamic_post_count]', $title, $output );
	return $output;
}
add_filter( 'do_shortcode_tag', 'be_dps_post_count_title', 10, 2 );


/**
 * Display Posts, use first attached image
 * @link https://displayposts.com/2019/10/16/display-image-from-post-content-if-no-featured-image/
 */
function be_dps_first_image( $output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class, $author, $category_display_text ) {

	// Only run if image_size is set and no featured image
	if( empty( $original_atts['image_size'] ) || !empty( $image ) )
		return $output;

	$images = new WP_Query( array(
		'post_parent'			=> get_the_ID(),
		'post_type'			=> 'attachment',
		'post_mime_type'		=> 'image',
		'post_status'			=> 'inherit',
		'posts_per_page'		=> 1,
		'order'				=> 'ASC',
		'fields'			=> 'ids',
	));

	if( !empty( $images->posts ) ) {
		$image = '<a href="' . get_permalink() . '" class="image1">' . wp_get_attachment_image( $images->posts[0], $original_atts['image_size'] ) . '</a>';
		$output = '<' . $inner_wrapper . ' class="' . implode( ' ', $class ) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . '</' . $inner_wrapper . '>';
	}

	return $output;
}
add_filter( 'display_posts_shortcode_output', 'be_dps_first_image', 10, 11 );



/*
*   INSERE O font-awesome no thema
*
*/

add_action( 'wp_enqueue_scripts', 'tthq_add_custom_fa_css' );

function tthq_add_custom_fa_css() {
wp_enqueue_style( 'custom-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
}


/*
*	INSERE CUSTOM STYLE AND SCRIPTS NO TEMA
*/
function add_estilos_e_scripts() { 
	//wp_enqueue_script( 'toplikes-widget-script', get_stylesheet_directory_uri() . '/assets/js/toplikes-widget.js', array ( 'jquery' ), 1.1, true );
	//wp_enqueue_style( 'toplikes-widget',  get_stylesheet_directory_uri() . '/assets/css/toplikes-widget.css' );
	  
	// Insere scripts /  styles apenas da primeira pagina
	 if ( is_search() or is_front_page() or is_page('sobre') or is_page('contato') or is_page('password-reset') or is_page('gastronomia') or is_page('login') or is_category() or is_tax('recipe_feature') or is_tax('recipe_cuisine') or is_tag() ) {
		wp_enqueue_script( 'toplikes-widget-script', get_stylesheet_directory_uri() . '/assets/js/toplikes-widget.js', array ( 'jquery' ), 1.1, true );
		wp_enqueue_style( 'toplikes-widget',  get_stylesheet_directory_uri() . '/assets/css/toplikes-widget.css' );
	} 
  }
add_action( 'wp_enqueue_scripts', 'add_estilos_e_scripts' );

/* 
function enqueuing_admin_scripts(){
 
	// Global Admin Variable, It tells which page is on now.
	global $pagenow; 
	 
	// Global Admin Variable, It tells which post type is on now.
	global $post_type;
	 
	if($pagenow == 'search.php') {
		wp_enqueue_script( 'toplikes-widget-script', get_stylesheet_directory_uri() . '/assets/js/toplikes-widget.js', array ( 'jquery' ), 1.1, true );
		wp_enqueue_style( 'toplikes-widget',  get_stylesheet_directory_uri() . '/assets/css/toplikes-widget.css' );
	}
	 
}
	 
add_action( 'admin_enqueue_scripts', 'enqueuing_admin_scripts' ); */



add_action( 'wp_head', 'njengah_get_current_user_role'); 
 
function njengah_get_current_user_role() {
	
 if( is_user_logged_in() ) { // check if there is a logged in user 
	 
	 $user = wp_get_current_user(); // getting & setting the current user 
	 $roles = ( array ) $user->roles; // obtaining the role 
	 
		return $roles; // return the role for the current user 
	 
	 } else {
		 
		return array(); // if there is no logged in user return empty array  
	 
	 }
}

// [upo-author-posts-count] use [upo-author-posts-count author-id="[wpv-user field="user_id"]"] to retrieve
  
add_shortcode('upo-author-posts-count', 'count_user_posts_function');
function count_user_posts_function () {
    $usuario = wp_get_current_user();
    return count_user_posts( $usuario->id );
}




/**
 * Sets a forced admin color scheme based on user. Admins get one color scheme, whereas everyone else gets another.
 * 	FORÇA O ESQUEMA DE COR sunrise PARA TODOS USUARIOS QUEM TEM ACESSO ADMIN
 * @param string $color The current forced admin color scheme. Empty string indicates no forced admin color scheme.
 * @return string
 */
function my_c2c_force_admin_color_scheme( $color ) {
    return current_user_can( 'manage_options' ) ? 'sunrise' : 'sunrise';
}
add_filter( 'c2c_force_admin_color_scheme', 'my_c2c_force_admin_color_scheme' );




/*
*
* Add Featured Image Column to Admin Area and Quick Edit menu
* Source: https://rudrastyh.com/wordpress/quick-edit-featured-image.html
*
*/

/*
 * This action hook allows to add a new empty column
 */

/* add_filter('manage_posts_columns', 'add_thumbnail_column', 5);
 
function add_thumbnail_column($columns){
  $columns['new_post_thumb'] = __('Imagem');
  return $columns;
}
 
add_action('manage_posts_custom_column', 'display_thumbnail_column', 5, 2);
 
function display_thumbnail_column($column_name, $post_id){
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
  }
}
 */

// ADD ICON-CATEGORY IN RECIPE_CUISINE TAXONOMY ADMIN COLUMNS
// Register the column
function recipe_cuisine_add_dynamic_hooks() {
	$taxonomy = 'recipe_cuisine'; //shopp_department
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'recipe_cuisine_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'recipe_cuisine_taxonomy_columns' );
	}
	add_action( 'admin_init', 'recipe_cuisine_add_dynamic_hooks' );
	
	function recipe_cuisine_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	// 2 é a posição da coluna
	array_splice( $new_columns, 2 );
	$new_columns['bandeiras'] = esc_html__( 'Bandeiras', 'category_icon' );
	return array_merge( $new_columns, $original_columns );
	}
	
	function recipe_cuisine_taxonomy_rows( $row, $column_name, $term_id ) {
	
		$term = get_term($term_id);
		$category_icons = get_field('category_icon', $term);
		
		//$t_id = $term_id;
		//$meta = get_option( "taxonomy_$t_id" );
		if ( 'bandeiras' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_icons == true) {
				//return $row . 'Yes';
				echo '<img width="60" src="' . $category_icons . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}
	}


// ADD ICON-CATEGORY IN RECIPE CATEGORY TAXONOMY ADMIN COLUMNS
// Register the 2 columns - ICON CATEGORY E TILE BG CATEGORY
function recipe_category_add_dynamic_hooks() {
	$taxonomy = 'category'; 
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'recipe_category_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'recipe_category_taxonomy_columns' );
	}
	add_action( 'admin_init', 'recipe_category_add_dynamic_hooks' );
	
	function recipe_category_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	array_splice( $new_columns, 2 );
	
	$new_columns['icones'] = esc_html__( 'Icones', 'category_icon' );
	$new_columns['tile_bg'] = esc_html__( 'Fundo', 'category_tile_bg' );

	return array_merge( $new_columns, $original_columns );
	}
	
	function recipe_category_taxonomy_rows( $row, $column_name, $term_id ) {
	
		$term = get_term($term_id);
		$category_icons = get_field('category_icon', $term);
		$category_tile_bg = get_field('category_tile_bg', $term);
		
		//$t_id = $term_id;
		//$meta = get_option( "taxonomy_$t_id" );
		if ( 'icones' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_icons == true) {
				//return $row . 'Yes';
				echo '<img width="70" src="' . $category_icons . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}

		if ( 'tile_bg' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_tile_bg == true) {
				//return $row . 'Yes';
				echo '<img width="70" src="' . $category_tile_bg . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}
	}




// ADD ICON-CATEGORY IN RECIPE_FEATURE TAXONOMY ADMIN COLUMNS
// Register the column
function recipe_feature_add_dynamic_hooks() {
	$taxonomy = 'recipe_feature'; 
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'recipe_feature_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'recipe_feature_taxonomy_columns' );
	}
	add_action( 'admin_init', 'recipe_feature_add_dynamic_hooks' );
	
	function recipe_feature_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	// 2 é a posição da coluna
	array_splice( $new_columns, 2 );
	$new_columns['icon_feature'] = esc_html__( 'Ícones', 'category_icon' );
	return array_merge( $new_columns, $original_columns );
	}
	
	function recipe_feature_taxonomy_rows( $row, $column_name, $term_id ) {
	
		$term = get_term($term_id);
		$category_icons = get_field('category_icon', $term);
		
		//$t_id = $term_id;
		//$meta = get_option( "taxonomy_$t_id" );
		if ( 'icon_feature' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_icons == true) {
				//return $row . 'Yes';
				echo '<img width="60" src="' . $category_icons . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}
	}

	

// ADD ICON-CATEGORY IN post_tag TAXONOMY ADMIN COLUMNS
// Register the column
function recipe_post_tag_add_dynamic_hooks() {
	$taxonomy = 'post_tag'; 
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'recipe_post_tag_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'recipe_post_tag_taxonomy_columns' );
	}
	add_action( 'admin_init', 'recipe_post_tag_add_dynamic_hooks' );
	
	function recipe_post_tag_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	// 2 é a posição da coluna
	array_splice( $new_columns, 2 );
	$new_columns['icon_post_tag'] = esc_html__( 'Ícones', 'category_icon' );
	return array_merge( $new_columns, $original_columns );
	}
	
	function recipe_post_tag_taxonomy_rows( $row, $column_name, $term_id ) {
	
		$term = get_term($term_id);
		$category_icons = get_field('category_icon', $term);
		
		//$t_id = $term_id;
		//$meta = get_option( "taxonomy_$t_id" );
		if ( 'icon_post_tag' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_icons == true) {
				//return $row . 'Yes';
				echo '<img width="60" src="' . $category_icons . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}
	}


		

// ADD ICON-CATEGORY IN recipe_ingredient TAXONOMY ADMIN COLUMNS
// Register the column
function recipe_ingredient_add_dynamic_hooks() {
	$taxonomy = 'recipe_ingredient'; 
	add_filter( 'manage_' . $taxonomy . '_custom_column', 'recipe_ingredient_taxonomy_rows',15, 3 );
	add_filter( 'manage_edit-' . $taxonomy . '_columns',  'recipe_ingredient_taxonomy_columns' );
	}
	add_action( 'admin_init', 'recipe_ingredient_add_dynamic_hooks' );
	
	function recipe_ingredient_taxonomy_columns( $original_columns ) {
	$new_columns = $original_columns;
	// 2 é a posição da coluna
	array_splice( $new_columns, 2 );
	$new_columns['icon_ingredient'] = esc_html__( 'Ícones', 'category_icon' );
	return array_merge( $new_columns, $original_columns );
	}
	
	function recipe_ingredient_taxonomy_rows( $row, $column_name, $term_id ) {
	
		$term = get_term($term_id);
		$category_icons = get_field('category_icon', $term);
		
		//$t_id = $term_id;
		//$meta = get_option( "taxonomy_$t_id" );
		if ( 'icon_ingredient' === $column_name ) {
			//echo '<img width="80" src="' . $post_thumbnail_img[0] . '" />';
			
			if ($category_icons == true) {
				//return $row . 'Yes';
				echo '<img width="60" src="' . $category_icons . '" />';
			} else {
				return $row . 'Não Tem';
			} 
		}
	}


	
// ADD osetin_review admin columns
// Add the custom columns to the book post type:


/* function add_author_support_to_posts() {
	add_post_type_support( 'osetin_review', 'author' ); 
 }
 add_action( 'init', 'add_author_support_to_posts' ); */


add_filter( 'manage_osetin_review_posts_columns', 'set_custom_edit_osetin_review_columns' );
function set_custom_edit_osetin_review_columns($columns) {
    unset( $columns['author'] );
    $columns['review_author'] = __( 'Author', 'your_text_domain' );
    //$columns['publisher'] = __( 'Publisher', 'your_text_domain' );

    return $columns;
}

// Add the data to the custom columns for the osetin_review post type:
// Adiciona o nome do usuário que fez a review na coluna admin das reviews
add_action( 'manage_osetin_review_posts_custom_column' , 'custom_osetin_review_column', 10, 2 );
function custom_osetin_review_column( $column, $post_id ) {
    switch ( $column ) {

        case 'review_author' :
			echo get_the_author_meta( 'display_name' );
            //$terms = get_the_term_list( $post_id , '' , '' , ',' , '' );
            //if ( is_string( $terms ) )
                //echo $terms;
            //else
				//echo $post_id;
				//echo get_the_author_meta( 'display_name' );
				//echo gettype($terms);
               // _e( 'Unable to get author(s)', 'your_text_domain' );
            break;

        case 'publisher' :
            //echo get_post_meta( $post_id , 'author' , true ); 
            break;

    }
} 



// FUNCOES QUE ADICIONAM A POSSIBILIDADE DE PUBLICAR A REVISAO 

function rudr_custom_status_creation(){
	register_post_status( 'publish', array(
		'label'                     => _x( 'Publish', 'osetin_review' ), // I used only minimum of parameters
		'label_count'               => _n_noop( 'Published <span class="count">(%s)</span>', 'Published <span class="count">(%s)</span>'),
		'public'                    => true
	));
}
add_action( 'init', 'rudr_custom_status_creation' );


add_action('admin_footer-edit.php','rudr_status_into_inline_edit');
 
function rudr_status_into_inline_edit($post_id) { // ultra-simple example
	global $post; // we need it to check current post type osetin_review
	
	if($post->post_type == 'osetin_review'){
		// ADD REVIEW AUTHOR 16/02/2022
		$author_id = $post->post_author;		
		$review_author = get_the_author_meta( 'display_name', $author_id );	
		echo "<script>
		jQuery(document).ready( function() {
			jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"publish\">Published</option>' );
			jQuery( 'select[name=\"post_author\"]' ).append( '<option value=\"$author_id\">$review_author</option>' );
		});
		</script>";
	}
}

function rudr_display_status_label( $statuses ) {
	global $post; // we need it to check current post status
	if(($post->post_type == 'osetin_review') or ($post->post_type == 'osetin_recipe')){	
			
		if( get_query_var( 'post_status' ) != 'publish' ){ // not for pages with all posts of this status
			if( $post->post_status == 'publish' ){ // если статус поста - Архив
				return array('Publish'); // returning our status label
			}
		}
		return $statuses; // returning the array with default statuses
	}
}
 
add_filter( 'display_post_states', 'rudr_display_status_label' );


/* Nuvem de tags custom */
function erikasarti_personaliza_widget_tags($args){

	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag') {
	
		// Veja todos os parametros disponiveis no Codex do WordPress
		// http://codex.wordpress.org/Template_Tags/wp_tag_cloud
	
		$args['number'] = 12;
		$args['smallest'] = 5;
		$args['largest'] = 30;
		$args['order'] = 'DESC';

	}
	
	return $args;

}

add_filter('widget_tag_cloud_args', 'erikasarti_personaliza_widget_tags');


/* 
	
add_theme_support( 'custom-header' );

function themename_custom_header_setup() {
    $defaults = array(
        // Default Header Image to display
        'default-image'         => get_template_directory_uri() . '/images/headers/default.jpg',
        // Display the header text along with the image
        'header-text'           => false,
        // Header text color default
        'default-text-color'        => '000',
        // Header image width (in pixels)
        'width'             => 1000,
        // Header image height (in pixels)
        'height'            => 198,
        // Header image random rotation default
        'random-default'        => false,
        // Enable upload of image file in admin 
        'uploads'       => false,
        // function to be called in theme head section
        'wp-head-callback'      => 'wphead_cb',
        //  function to be called in preview page head section
        'admin-head-callback'       => 'adminhead_cb',
        // function to produce preview markup in the admin screen
        'admin-preview-callback'    => 'adminpreview_cb',
        );
}
add_action( 'after_setup_theme', 'themename_custom_header_setup' ); */

/* add_action('um_theme_header_profile_before', 'custom_add_last_login_time' );
function custom_add_last_login_time(){
  echo '<div class="small alert alert-light" role="alert">';
  echo "Last Login : ";
  echo um_user_last_login( get_current_user_id() );
  echo '</div>';
}
 */

// Add a Custom Post Type to a feed
function add_cpt_to_feed( $qv ) {
  if ( isset($qv['feed']) && !isset($qv['post_type']) )
    $qv['post_type'] = array('post', 'osetin_recipe');
  return $qv;
}

add_filter( 'request', 'add_cpt_to_feed' );


add_action('pre_get_posts','users_own_attachments');
function users_own_attachments( $wp_query_obj ) {

	global $current_user, $pagenow;

	if( !is_a( $current_user, 'WP_User') )
		return;

	if( ( 'upload.php' != $pagenow ) && ( ( 'admin-ajax.php' != $pagenow ) || ( $_REQUEST['action'] != 'query-attachments' ) ) )
		return;

	if( !current_user_can('delete_pages') )
		$wp_query_obj->set('author', $current_user->id );

	return;
}

	
// END ENQUEUE PARENT ACTION
