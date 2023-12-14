<?php 
 function total_receitasPublicadas() {
  $total = wp_count_posts("osetin_recipe")->publish;
  //$format_total = '<p>Total: ' . $total . '</p>';
  $format_total = $total;
  return $format_total;
}
add_shortcode( 'total_receitas_publicadas', 'total_receitasPublicadas' );
