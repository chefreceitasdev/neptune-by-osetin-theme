<?php
/**
 * The template for displaying author pages
 *
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); 
$cat_id =  get_query_var('cat');
$category_bg_image_url = osetin_get_field('category_header_bg', "category_{$cat_id}");
$css_extra_class = ($category_bg_image_url) ? 'with-background' : 'without-background';

$layout_type_for_index = osetin_get_settings_field('layout_type_for_index');
$archive_class = osetin_get_archive_class($layout_type_for_index);
$masonry_layout_mode = osetin_get_masonry_layout_mode($layout_type_for_index);
$term_description = term_description();
$not_my_posts = true;
?>
<div class="os-container top-bar-w">
    <div class="top-bar bordered">
        <?php osetin_output_breadcrumbs(); ?>
        <?php osetin_social_share_icons('header'); ?>
    </div>
</div>

<div class="os-container">
    <div class="pagina-do-autor">

    <?php 




    ?>

    </div>
</div>
<?php get_footer(); ?>