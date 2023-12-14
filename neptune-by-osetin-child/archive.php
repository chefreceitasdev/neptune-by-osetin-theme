<?php
/**
 * The template for displaying archive pages
 *
 */

get_header(); 

$layout_type_for_index = osetin_get_settings_field('layout_type_for_index');

$archive_title = get_the_archive_title();

$archive_description = get_the_archive_description();

    /**
     * Summary of function get_imagebg_width
     * Função que retorna a largura de uma imagem através do url do arquivo
     * @param mixed $file_url
     * @return mixed
     */
    function get_imagebg_width( $file_url ) {
      $file_path = realpath($_SERVER['DOCUMENT_ROOT'] . parse_url( $file_url, PHP_URL_PATH ));
      $image_properties = getimagesize($file_path);
      // Retorna a largura da imagem
      //print($image_properties[0]);
      return $image_properties[0];
    }

    /**
     * Summary of bg_archives_random
     * Função que retorna a url (aleatória) de uma receita de acordo com taxonomia do arquivo
     * @param mixed $termo_nome
     * @param mixed $termo_taxonomia
     * @return mixed
     */
    function bg_archives_random($termo_nome, $termo_taxonomia) {
      
      $args = array(
        'post_type' => 'osetin_recipe',
        'orderby' => 'rand',
        'post_status' => 'publish',
        'tax_query' => array(
          array(
            'taxonomy' => $termo_taxonomia,
            'field'    => 'slug',
            'terms'    => $termo_nome,
          ),
        ),
        'posts_per_page' => 5
      );
  
      $query = new WP_Query($args);
  
      if ($query->have_posts()):
        while ($query->have_posts()):
          $query->the_post();       
  
          $thumb_url = get_the_post_thumbnail_url(null, 'full');
          //print($thumb_url);
          if (get_imagebg_width($thumb_url) > 799) {
            return $thumb_url;
          }
        endwhile;
      else:
        echo 'No posts';
      endif;
    }
    
	// End of function
  
    $termo_nome = ucwords(single_term_title( '', false ));
    $termo = get_queried_object();
    $termo_taxonomia = $termo->taxonomy;
    $url_bg_random = bg_archives_random($termo_nome, $termo_taxonomia);    
    $css_extra_class = ($url_bg_random) ? 'with-background' : 'without-background';

    switch ($termo_taxonomia) {
      case 'recipe_feature':
          $archive_title = 'Característica: ' . $termo_nome;
          break;
      case 'recipe_cuisine':
          $archive_title = 'Cozinha: ' . $termo_nome;
          break;
      case 'recipe_ingredient':
          $archive_title = 'Ingrediente: ' . $termo_nome;
          break;
	  case 'post_tag':
          $archive_title = 'Tag: ' . $termo_nome;
          break;
    }

?>

<div class="os-container top-bar-w">
  <div class="top-bar bordered">
    <?php osetin_output_breadcrumbs(); ?>
    <?php osetin_social_share_icons('header'); ?>
  </div>
    
  <div class="page-intro-header <?php echo esc_attr($css_extra_class); ?>" style="<?php echo osetin_get_css_prop('background-image', $url_bg_random, false, 'background-repeat: no-repeat; background-position: left; background-size: cover; padding: 12%'); ?>">
	   <h1 class="archive-title-h1"><?php echo $archive_title; ?></h1>
        <h2><?php echo ucwords(single_term_title( '', false )); ?></h2>
        <?php 
          if ( ! empty( $term_description ) ) { ?>
            <div class="page-intro-description"><?php echo $term_description; ?></div>
        <?php } ?>
  </div>

</div>

<div class="os-container">
  <?php global $wp_query; ?>
  <?php echo build_index_posts($layout_type_for_index, 'sidebar-index', $wp_query, false, array('title' => $archive_title, 'description' => $archive_description)); ?>
</div>

<?php get_footer(); ?>