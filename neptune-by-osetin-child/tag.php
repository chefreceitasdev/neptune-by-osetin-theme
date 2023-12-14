<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since Neptune 1.0
 */
?>

<?php
get_header(); 
$layout_type_for_index = osetin_get_settings_field('layout_type_for_index');
$tag_title = ucwords(single_tag_title( '', false ));
$term_description = $tag_description = term_description();

?>
<?php 
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
     * Summary of bg_tag_random: FUNÇÃO QUE RETORNA UMA URL DE ALGUMA IMAGEM DE RECEITA NA TAG - PAGINA DE ARQUIVO
     * @return mixed
     */
    function bg_tag_random($titulo_tag)
    {
      
      //$titulo_categoria = ucwords(single_cat_title( '', false ));

      $args = array(
        'post_type' => 'osetin_recipe',
        'orderby' => 'rand',
        'post_status' => 'publish',
        'post_tag' => $titulo_tag,
        'posts_per_page' => 5
      );

      $query = new WP_Query($args);

      if ($query->have_posts()):
        while ($query->have_posts()):
          $query->the_post();       

          $thumb_url = get_the_post_thumbnail_url(null, 'full');

          if (get_imagebg_width($thumb_url) > 799) {
            return $thumb_url;
          }
        
        endwhile;
      else:
        echo 'No posts';
      endif;

    }
?>

<div class="os-container top-bar-w">
  <div class="top-bar bordered">
    <?php osetin_output_breadcrumbs(); ?>
    <?php osetin_social_share_icons('header'); ?>
  </div>
	
	 <?php if(!empty($tag_bg_image_url)){ ?>
     
        <div class="page-intro-header <?php echo esc_attr($css_extra_class); ?>" style="<?php echo osetin_get_css_prop('background-image', $category_bg_image_url, false, 'background-repeat: no-repeat; background-position: left; background-size: cover; padding: 10%'); ?>">
		 <h1 class="archive-title-h1"><?php echo 'Receita da Tag: ' . ucwords(single_tag_title( '', false )); ?></h1>
          <h2><?php echo ucwords(single_tag_title( '', false )); ?></h2>
          <?php 
            if ( ! empty( $term_description ) ) { ?>
              <div class="page-intro-description"><?php echo $term_description; ?></div>
            <?php } ?>
        </div>
      <?php }
      else {
        $titulo_tag = ucwords(single_tag_title( '', false ));
        $url_bg_random = bg_tag_random($titulo_tag); 
        $css_extra_class = ($url_bg_random) ? 'with-background' : 'without-background';
        ?>

      <div class="page-intro-header <?php echo esc_attr($css_extra_class); ?>" style="<?php echo osetin_get_css_prop('background-image', $url_bg_random, false, 'background-repeat: no-repeat; background-position: left; background-size: cover; padding: 10%'); ?>">
		  <h1 class="archive-title-h1"><?php echo 'Receita da Tag: ' . ucwords(single_tag_title( '', false )); ?></h1>
            <h2><?php echo ucwords(single_tag_title( '', false )); ?></h2>
            <?php 
              if ( ! empty( $term_description ) ) { ?>
                <div class="page-intro-description"><?php echo $term_description; ?></div>
            <?php } ?>
      </div>
        
    <?php } ?>
  
  </div>
	

<div class="os-container">
  <?php global $wp_query; ?>
  <?php echo build_index_posts($layout_type_for_index, 'sidebar-index', $wp_query, false, array('title' => $tag_title, 'description' => $tag_description)); ?>
</div>
<?php get_footer(); ?>