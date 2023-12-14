
<?php

/**
 * This example shows how to add a new tab into the Profile page of the Ultimate Member. 
 * See the article https://docs.ultimatemember.com/article/69-how-do-i-add-my-extra-tabs-to-user-profiles
 *
 * This example adds the tab 'myreviews' that contains the field 'description'. You can add your own tabs and fields.
 * Important! Each profile tab has an unique key. Replace 'myreviews' to your unique key.
 *
 * You can add this code to the end of the file functions.php in the active theme (child theme) directory.
 * 
 * Ultimate Member documentation: https://docs.ultimatemember.com/
 * Ultimate Member support (for customers): https://ultimatemember.com/support/ticket/
 */
 
/**
 * Add a new Profile tab
 *
 * @param array $tabs
 * @return array
 */
function um_myreviews_add_tab( $tabs ) {

	$tabs[ 'myreviews' ] = array(
		'name'   => 'Reviews',
		'icon'   => 'um-icon-checkmark-round',
		'custom' => true
	);

	UM()->options()->options[ 'profile_tab_' . 'myreviews' ] = true;

	return $tabs;
}
add_filter( 'um_profile_tabs', 'um_myreviews_add_tab', 1000 );

/**
 * Render tab content
 *
 * @param array $args
 */
function um_profile_content_myreviews_default( $args ) {
	/* START. You can paste your content here, it's just an example. */
	// SE QUISER ADICIONAR CONTEUDO ANTES DA LISTA DE REVIEWS	
	echo '<h2>Minha Reviews</h2>';
}
add_action( 'um_profile_content_myreviews_default', 'um_profile_content_myreviews_default' );


add_action( 'um_profile_content_myreviews_default', 'add_reviews' );

function add_reviews() {
		$args = array(
			'post_type'        => array( 'osetin_review' ),
			'posts_per_page'   => 10,
			'offset'           => 0,
			'author'           => um_get_requested_user(),
			'post_status'      => array( 'publish' ),
			'um_main_query'    => true,
			'suppress_filters' => false,
		);


	/**
	 * UM hook
	 *
	 * @type filter
	 * @title um_profile_query_make_posts
	 * @description Some changes of WP_Query Posts Tab
	 * @input_vars
	 * [{"var":"$query_posts","type":"WP_Query","desc":"UM Posts Tab query"}]
	 * @change_log
	 * ["Since: 2.0"]
	 * @usage
	 * <?php add_filter( 'um_profile_query_make_posts', 'function_name', 10, 1 ); ?>
	 * @example
	 * <?php
	 * add_filter( 'um_profile_query_make_posts', 'my_profile_query_make_posts', 10, 1 );
	 * function my_profile_query_make_posts( $query_posts ) {
	 *     // your code here
	 *     return $query_posts;
	 * }
	 * ?>
	 */
	$args = apply_filters( 'um_profile_query_make_posts', $args );
	$posts = get_posts( $args );

	$args['posts_per_page'] = -1;
	$args['fields'] = 'ids';
	unset( $args['offset'] );
	$count_posts = get_posts( $args );
	if ( ! empty( $count_posts ) && ! is_wp_error( $count_posts ) ) {
		$count_posts = count( $count_posts );
	}

	//UM()->get_template( 'profile/posts.php', '', array( 'posts' => $posts, 'count_posts' => $count_posts ), true );

	UM()->get_template( 'profile/reviews.php', '', array( 'posts' => $posts, 'count_posts' => $count_posts ), true );
	//UM()->get_template( 'profile/posts.php', '', array( 'posts' => $posts, 'count_posts' => $count_posts ), true );
 }