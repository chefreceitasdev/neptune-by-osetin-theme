<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Neptune
 * @since Neptune
 */

get_header(); 
$cat_id =  get_query_var('cat');
$category_bg_image_url = osetin_get_field('category_header_bg', "category_{$cat_id}");
$css_extra_class = ($category_bg_image_url) ? 'with-background' : 'without-background';
$term_description = term_description();

$layout_type_for_term_archive = osetin_get_field('layout_type_for_term_archive', "category_{$cat_id}");
if($layout_type_for_term_archive && ($layout_type_for_term_archive != 'default')){
  $layout_type_for_index = $layout_type_for_term_archive;
}else{
  $layout_type_for_index = osetin_get_settings_field('layout_type_for_index');
}
if(empty($category_bg_image_url)){
  $header_arr['description'] = $term_description;
  $header_arr['title'] = ucwords(single_cat_title( '', false ));
}else{
  $header_arr = false;
}

$header_arr = false;

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
     * Summary of bg_cat_random: FUNÇÃO QUE RETORNA UMA URL DE ALGUMA IMAGEM DE RECEITA NA CATEGORIA - PAGINA DE ARQUIVO
     * @return mixed
     */
    function bg_cat_random($titulo_categoria)
    {
      
      //$titulo_categoria = ucwords(single_cat_title( '', false ));

      $args = array(
        'post_type' => 'osetin_recipe',
        'orderby' => 'rand',
        'post_status' => 'publish',
        'category_name' => $titulo_categoria,
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
    <div class="top-bar <?php if(empty($category_bg_image_url)) echo 'bordered'; ?>">
      <?php osetin_output_breadcrumbs(); ?>
      <?php osetin_social_share_icons('header'); ?>
    </div>
    <?php if(!empty($category_bg_image_url)){ ?>
     
        <div class="page-intro-header <?php echo esc_attr($css_extra_class); ?>" style="<?php echo osetin_get_css_prop('background-image', $category_bg_image_url, false, 'background-repeat: no-repeat; background-position: left; background-size: cover; padding: 10%'); ?>">
		 <h1 class="archive-title-h1"><?php echo 'Receita da Categoria: ' . ucwords(single_cat_title( '', false )); ?></h1>
          <h2><?php echo ucwords(single_cat_title( '', false )); ?></h2>
          <?php 
            if ( ! empty( $term_description ) ) { ?>
              <div class="page-intro-description"><?php echo $term_description; ?></div>
            <?php } ?>
        </div>
      <?php }
      else {
        $titulo_categoria = ucwords(single_cat_title( '', false ));
        $url_bg_random = bg_cat_random($titulo_categoria); 
        $css_extra_class = ($url_bg_random) ? 'with-background' : 'without-background';
        ?>

      <div class="page-intro-header <?php echo esc_attr($css_extra_class); ?>" style="<?php echo osetin_get_css_prop('background-image', $url_bg_random, false, 'background-repeat: no-repeat; background-position: left; background-size: cover; padding: 10%'); ?>">
		  <h1 class="archive-title-h1"><?php echo 'Receita da Categoria: ' . ucwords(single_cat_title( '', false )); ?></h1>
            <h2><?php echo ucwords(single_cat_title( '', false )); ?></h2>
            <?php 
              if ( ! empty( $term_description ) ) { ?>
                <div class="page-intro-description"><?php echo $term_description; ?></div>
            <?php } ?>
      </div>
        
    <?php } ?>
  
  </div>

  <div class="os-container">
    <?php global $wp_query; ?>
    <?php echo build_index_posts($layout_type_for_index, 'sidebar-index', $wp_query, false, $header_arr); ?>
  </div>
<?php get_footer(); ?>