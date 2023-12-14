<?php /* Template Name: readYoastkeyfrase */ ?>

<?php

function printlee($arr){
    echo '<pre>' . print_r($arr) . '</pre>';
}
function hr(){
    print('<hr>');
}

function focuskeyredux($txt){
	$x = explode("(",$txt);
	$fk = $x[0];
	$x = explode(" e ",$fk);
	$fkredux = $x[0];
	$x = explode(",",$fk);
	$fkredux = $x[0];
	$x = explode(" de ",$fk);
	if (count($x)>1){
		$fkredux = $x[0] . ' de ' . $x[1];	
	}
	return ($fkredux);
}

/*
//ANTERIOR

function focuskeyredux_title($txt){
	$x = explode("(",$txt);
	$fk = $x[0];
	$x = explode(" e ",$fk);
	$fkredux = $x[0];
	$x = explode(",",$fk);
	$fkredux = $x[0];
	return ($fkredux . ' - Chef Receitas');
} */

function focuskeyredux_title($txt){
	$x = explode("(",$txt);
	$fk = $x[0];
	$x = explode(" e ",$fk);
	$fkredux = $x[0];
	$x = explode(",",$fk);
	$fkredux = $x[0];
	return ($fkredux);
}

// USO 
// https://chefreceitasblog.local/teste/?senha=tchunai99%2021&n=1&up=1

// https://chefreceitasblog.local/teste/?senha=2021Tchunai99%&n=1&up=0&post_status=any

//   http://localhost/chefreceitas/loopseo/?senha=2021Tchunai99%&n=1&up=0&post_status=any&tipo=osetin_recipe
//	http://localhost/chefreceitas/loopseo/?senha=2021Tchunai99%&n=1&up=1&post_status=publish&tipo=osetin_recipe
// n = numero de receitas que quer ler/editar
// up = 1 = edita as receitas  se nao setar entao up = 0

if (isset($_GET['senha']) && ($_GET['senha'] == '2021Tchunai99%')) {
	echo "<p><b>Acesso Autorizado!</b></p>";
}
else {
	echo $_GET['senha'];
	echo '<p style="color:red"><b>Acesso NÃO Autorizado!</b></p><br>Busca inválida';
	exit;	
}


if (isset($_GET['n'])) {
	$count = (int) $_GET['n'];
	//echo "Quantidade: " . gettype($count);
}
else {
	echo "Busca inválida";
	exit;
	$count = 10;
}

if (isset($_GET['up'])) {
	$up = $_GET['up'];
	if ((int)$up == 1) {
		echo "Parâmetro de Edição configurado, up = $up";
	}
}
else {
	$up = 0;
	echo "Parâmetro de Edição não configurado, up = $up";

}


if (isset($_GET['post_status'])) {
	$post_status = $_GET['post_status'];
}
else {
	$post_status = 'publish';
}
echo "<p><b>Post Status: $post_status</b></p>";


if (isset($_GET['tipo'])) {
	$tipo = $_GET['tipo'];
}
else {
	$tipo = 'post';
}
echo "<p><b>Post Type: $tipo</b></p>";

$args = array(
	'post_type' => $tipo,
	'post_status' => $post_status,
	'posts_per_page' => 1
);

$posts_query = new WP_Query( $args );

	// CONTADORES DOS ATRIBUTOS DAS IMAGENS ATTACHMENTS DO POSTS
	$c_total_posts = 0;
	$c_title = 0;
	$c_alt = 0;
    $c_img_src = 0;
	$c_keyfocus = 0;

	hr();

    while($posts_query->have_posts()) : $posts_query->the_post();
        $title = get_the_title();
        $post_id = get_the_ID();

		// insere a palavra chave
        if ($up == 1){
			update_post_meta($post_id, '_yoast_wpseo_focusk??w', focuskeyredux($title));
		}

		
		// Pega o custom field do Yoast - focus keyphrase
        $keyfrase = get_post_meta( $id, '_yoast_wpseo_focusk??w', true );

		// Pega o custom field do Yoast - meta description
		$wpseo_metadesc = get_post_meta( $id, '_yoast_wpseo_metadesc', true ); 
		
		
        echo 'keyfrase: ' . $keyfrase . '<br />';		

		echo 'SEO_metadescription: ' . $wpseo_metadesc . '<br />';
		
		if ($up == 1){
			// Conserta o titulo SEO se ele for muito grande
			if (strlen($title) > 33){
				$new_title = focuskeyredux_title($title);
				if(strlen($new_title) < 30) {
					$new_title = 'Receita de ' . $new_title . ' - Chef Receitas';
				}
				update_post_meta($post_id, '_yoast_wpseo_title', $new_title );
			}
			else {
				if(strlen($title) < 30) {
					$new_title = 'Receita de ' . $title . ' - Chef Receitas';					
				} 
				
				update_post_meta($post_id, '_yoast_wpseo_title', $new_title);
			}
		} 

		$yoast_title = get_post_meta($id, '_yoast_wpseo_title', true);
        echo '<hr>YOAST Title: ' . $yoast_title . '<br />';

		// TITULO DA POSTAGEM
		echo 'Titulo: ' . $title . '<br />';

		// pega o id do ATTCHMENT
		$image_id = get_post_thumbnail_id();

		
		//UPDATE ALT ATTCHMENTES BY POST TITLE
		if ($up == 1){
			update_post_meta($image_id, '_wp_attachment_image_alt', $title);
		}

		$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
    	$image_title = get_the_title($image_id);	 	
		echo "Titulo da Imagem: " . $image_title; 
		hr(); 

		// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
		$my_image_meta = array(
			'ID'		=> $image_id, //$post_ID,			// Specify the image (ID) to be updated
			'post_title'	=> $title,		// Set image Title to sanitized title
			'post_excerpt'	=> $title,		// Set image Caption (Excerpt) to sanitized title
			'post_content'	=> $title,		// Set image Description (Content) to sanitized title
		);


		// Set the image meta (e.g. Title, Excerpt, Content)
		if ($up == 1){
			wp_update_post( $my_image_meta ); 
		}
		
		$image_src = wp_get_attachment_image_src($image_id, $size)[0];

		echo "Alt: ";

		if ($image_alt == "") {
			echo "not found";
			$c_alt++;
		}
		else {
			echo $image_alt;
		}

		echo "<br>Titulo: ";

		if($image_title == "") {
			echo "not found";
			$c_title++;
		}
		else {
			echo $image_title;
		}

		echo "<br>Img Src: ";
		if ($image_src == "") {
			echo "not found";
			$c_img_src++;
		}
		else {
			echo "Attchament: $image_src";
		}


		// insere a palavra chave foco
        if ($up == 1){
			WPSEO_Meta::set_value( 'focuskw', focuskeyredux($title), $post_id );
		}		

        $focuskw_val = WPSEO_Meta::get_value( 'focuskw', $post_id );

        //post_to_response($post);
		if ($focuskw_val == "") {
			$c_keyfocus++;
		}
		
        echo "<br>Keyfrase focus: $focuskw_val <br><br>";



        echo '<hr style="border: 3px solid green; border-radius: 5px;">';
        //print_r($post);

        $c_total_posts++;

         if($c_total_posts == $count) {
            break;
		 } 




    endwhile;

	echo "<hr><hr><br>";
	echo "Total de Posts: $c_total_posts <br>";
	echo "Imgs sem ALT: $c_alt <br>";
	echo "Imgs sem TITLE: $c_title <br>";
	echo "<b>Posts sem imagem:</b> $c_img_src<br>";
	echo "Sem KeyFraseFocus: $c_keyfocus";

    ?>
