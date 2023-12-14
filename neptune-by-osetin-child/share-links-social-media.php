<?php

function current_url()
{
    // Dentro do loop
    $url      = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    //$url      = "https://" . $_SERVER['HTTP_HOST'];
    $validURL = str_replace("&", "&amp;", $url);
    return $validURL;
}

$post_link = current_url();
$title = get_the_title();

// pega o id do ATTCHMENT
$image_id = get_post_thumbnail_id();
$image_src = wp_get_attachment_image_src($image_id, $size)[0];

/* $url      = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_path = parse_url( $url, PHP_URL_PATH );
$slug = pathinfo( $url_path, PATHINFO_BASENAME ); */
?>

<?php //echo "slug: $slug<br>"; ?>
<?php //echo "title: $title<br>"; ?>
<?php //echo "post_link: $post_link<br>"; ?>
<?php //echo "Imagem: $image_src<br>"; ?>
<?php //echo '<div class="fb-share-button" data-href="' . $post_link . '"></div>'; ?>

<div class="chefreceitas-social-share-shortcode">
   <div class="chefreceitas-shortcode chefreceitas-m chefreceitas-social-share clear chefreceitas-layout--text">
        <span class="chefreceitas-social-title chefreceitas-custom-label">Share:</span>
        <ul class="chefreceitas-shortcode-list">
            <li class="chefreceitas-facebook-share">
                <a itemprop="url" class="chefreceitas-share-link" href="#" onclick="window.open('https://www.facebook.com/sharer.php?u=<?php echo $post_link; ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');">
                    <span class="chefreceitas-social-network-text">fb</span>
                </a>
            </li>
            <li class="chefreceitas-twitter-share">
                <a itemprop="url" class="chefreceitas-share-link" href="#" onclick="window.open('https://twitter.com/intent/tweet?text=<?php echo $title; ?><?php echo $post_link; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');">
                    <span class="chefreceitas-social-network-text">tw</span>
                </a>
            </li>
            <li class="chefreceitas-linkedin-share">
                <a itemprop="url" class="chefreceitas-share-link" href="#" onclick="popUp=window.open('https://linkedin.com/shareArticle?mini=true&amp;url=<?php echo $post_link; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                    <span class="chefreceitas-social-network-text">ln</span>
                </a>
            </li>
            <li class="chefreceitas-pinterest-share">
                <a itemprop="url" class="chefreceitas-share-link" href="#" onclick="popUp=window.open('https://pinterest.com/pin/create/button/?url=<?php echo $post_link; ?>&amp;description=<?php echo $title; ?>&amp;media=<?php echo $image_src; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                    <span class="chefreceitas-social-network-text">p</span>
                </a>
            </li>
            <li class="chefreceitas-whatsapp-share">
                <a itemprop="url" class="chefreceitas-share-link" href="#" onclick="popUp=window.open('https://api.whatsapp.com/send?phone=&amp;text=%2A<?php echo $title; ?>%2A%0A%0A%0A%0A Aprenda a preparar esta deliciosa Receita no Chef Receitas Blog%3A%0A%0A<?php echo $post_link; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                    <span class="chefreceitas-social-network-text">Whatsapp</span>
                </a>
            </li>
        </ul>
    </div>
</div>



<?php 


//MODIFICADA 05/02/2022
// NOVA FUNÇÃO COM JANELA POPUP
function osetin_get_sharing_icons(){
    $id_post = get_the_ID();
    $sharing_url = get_the_permalink();
    $img_to_pin = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id() ) : "";
    $osetin_current_title = is_front_page() ? get_bloginfo('description') : wp_title('', false);
  
    $facebook_share_link = 'https://www.facebook.com/sharer.php?u='.urlencode($sharing_url);
    $pinterest_share_link = '//www.pinterest.com/pin/create/button/?url='.$sharing_url.'&amp;media='.$img_to_pin.'&amp;description='.$osetin_current_title;
    $twitter_share_link = 'https://twitter.com/share?url='.$sharing_url.'&amp;text='.urlencode($osetin_current_title);
    
    ?>
    <a href="#share-face-<?php echo $id_post; ?>" id="#share-face-<?php echo $id_post; ?>" class="archive-item-share-link aisl-facebook" onclick="window.open('<?php echo esc_url($facebook_share_link); ?>', 'sharer', 'toolbar=0,status=0,width=620,height=280');"><i class="os-icon os-icon-facebook"></i></a>
  
    <a href="#share-twitter-<?php echo $id_post; ?>"  class="archive-item-share-link aisl-twitter" onclick="window.open('<?php echo $twitter_share_link; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');"><i class="os-icon os-icon-twitter"></i></a>
  
    <a href="#share-pinterest-<?php echo $id_post; ?>" onclick="popUp=window.open('<?php echo esc_url($pinterest_share_link); ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;" class="archive-item-share-link aisl-pinterest"><i class="os-icon os-icon-pinterest"></i></a>
  
    <a href="#share-zap-<?php echo $id_post; ?>" id="#share-zap-<?php echo $id_post; ?>" class="archive-item-share-link aisl-mail" onclick="popUp=window.open('https://api.whatsapp.com/send?phone=&amp;text=%2A<?php echo urlencode($osetin_current_title); ?>%2A%0A%0A%0A%0A Aprenda a preparar esta deliciosa Receita no Chef Receitas Blog%3A%0A%0A<?php echo esc_url($sharing_url); ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false;"><i class="fa fa-whatsapp" aria-hidden="true" style="color: #ff6666;"></i></a>
  
    <a href="<?php echo 'mailto:?Subject='.$osetin_current_title.'&amp;Body=%20'.$sharing_url ?>" target="_blank" class="archive-item-share-link aisl-mail"><i class="os-icon os-icon-basic-mail-envelope"></i></a>
    <?php  
    //<i class="fa fa-whatsapp" aria-hidden="true"></i>
  } 
  

?>