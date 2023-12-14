<?php

/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Neptune
 */
?>

<?php if (is_active_sidebar('sidebar-footer')) { ?>
  <div class="os-container">
    <div class="pre-footer widgets-count-<?php echo osetin_count_sidebar_widgets('sidebar-footer'); ?>" style="<?php echo osetin_get_css_prop('background-color', osetin_get_field('pre_footer_section_background_color', 'option')) . osetin_get_css_prop('background-image', osetin_get_field('pre_footer_section_background_image', 'option'), 'background-repeat: repeat; background-position: top left;'); ?>">
      <?php dynamic_sidebar('sidebar-footer'); ?>
    </div>
  </div>
<?php } ?>
<div class="os-container">
  <div class="main-footer with-social color-scheme-<?php echo osetin_get_field('footer_section_background_color_type', 'option'); ?>" style="<?php echo osetin_get_css_prop('background-color', osetin_get_field('footer_section_background_color', 'option')) . osetin_get_css_prop('background-image', osetin_get_field('footer_section_background_image', 'option'), 'background-repeat: repeat; background-position: top left;'); ?>">
    <div class="footer-copy-and-menu-w">
      <?php wp_nav_menu(array('theme_location' => 'footer', 'menu_id' => 'footer-menu', 'container_class' => 'footer-menu', 'fallback_cb' => false)); ?>
      <div class="footer-copyright"><?php echo osetin_get_field('extra_footer_html', 'option'); ?></div>
    </div>
    <div class="footer-social-w">
      <?php osetin_social_share_icons('footer'); ?>
		<br>
		<span class="lemonpepper-backlink">
		<a href="https://www.lemonpepperdesign.com.br" title="Criação de Site em Goiânia - Lemon Pepper Design | Websites" class="lpd-links" target="_blank">Design by </a>
		<a href="https://www.lemonpepperdesign.com.br" title="Webdesign - Lemon Pepper Design | Websites | Web Design" target="_blank">
			<img width="50" height="50" src="https://www.chefreceitas.com/wp-content/uploads/2023/11/lemon-pepper-design.png" class="lpd-logo entered lazyloaded" alt="LEMON PEPPER DESIGN" title="Criação de Sites em Goiânia - Lemon Pepper Design | Web design | Sites" data-lazy-src="https://www.chefreceitas.com/wp-content/uploads/2023/11/lemon-pepper-design.png" data-ll-status="loaded"><noscript><img width="50" height="50" src="https://www.chefreceitas.com/wp-content/uploads/2023/11/lemon-pepper-design.png" class="lpd-logo" alt="LEMON PEPPER DESIGN" title="Criação de Site em Goiânia - Consultoria SEO | Web design | Brasil" ></noscript></a>
		</span>
    </div>
  </div>
</div>
<div class="main-search-form-overlay">
</div>
<div class="main-search-form">
  <?php get_search_form(true); ?>
  <div class="autosuggest-results"></div>
</div>
<div class="display-type"></div>
</div>
<?php wp_footer(); ?>
  <!--   Adicionado o Lemon Pepper Design Link    -->
<span class="lemon-pepper-widget"><a href="https://www.lemonpepperdesign.com.br" title="Criação de Site em Goiânia - Lemon Pepper Design | Websites" target="_blank" rel="noopener">
    <img src="https://www.chefreceitas.com/wp-content/uploads/2023/11/lemon-pepper-design.png" class="lpd-logo" alt="LEMON PEPPER DESIGN" title="Criação de Sites, webdesign, websites - Lemon Pepper Design | Web design" width="50" height="50">
  </a>
  <a href="https://www.lemonpepperdesign.com.br" title="Criação de Site Webdesign - Lemon Pepper Design | Websites" class="lpd-links" id="link-texto" target="_blank" rel="noopener">Web Design</a>
</span>
</body>

</html>