<?php /* Template Name: categorias-modal */ ?>


<head>
    <style>
    .count-categorias {
        padding: 2.5px;
        background-color: #fff;
        color: #ffcc11;
        font-weight: bold;
        border-radius: 10px;
        margin-left: 6px;
    }



    /* width */
    ::-webkit-scrollbar {
        width: 14px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 10px;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #ffcc00;
        opacity: 0.6;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: green;
    }


    .column-categorias {
        float: left;
        width: 25%;
        height: 350px;
    }

    /* Clear floats after the columns */
    .row-categorias:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive layout - when the screen is less than 600px wide, make the three columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .column-categorias {
            width: 100%;
        }
    }

/*     * {
        box-sizing: border-box
    } */

    /* Container needed to position the overlay. Adjust the width as needed */
    .container {
        position: relative;
        width: 100%;
        max-width: 300px;
       
        box-sizing: border-box;
    }

    /* Make the image to responsive */
    .image-categorias {
        display: block;
        width: 100%;
        height: auto;
    }

    .image-categorias2 {
        display: none;
        width: 100%;
        height: auto;
        transition: 0.3s;
    }

    /* The overlay effect - lays on top of the container and over the image */
    .overlay-categorias {
        position: relative;

        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.5);
        /* Black see-through */
        color: #f1f1f1;
        width: 100%;
        transition: .5s ease;
        opacity: 1;
        color: white;
        font-size: 20px;
        padding: 0px;
        text-align: center;
        z-index: 9;
    }

    .card-categorias:hover .overlay-categorias {
        opacity: 0.4;
    }


    /* When you mouse over the container, fade in the overlay title */

    .card-categorias:hover .image-categorias {
        /* filter: grayscale(90%); */
        display: none;
    }

    .card-categorias:hover .image-categorias2 {
        display: block;
    }



    .title-cat {

        position: relative;
        bottom: 180px;
        text-align: center;
        opacity: 0;
        transition: 0.3s;
        z-index: 9;

        color: #ffffff;
        font-size: 1.2em;
        padding: 10px;

    }

    .card-categorias:hover .title-cat {

        opacity: 0.685;
        position: relative;


        position: relative;
        animation: myfirst 0.3s;
        animation-direction: normal;


    }



    @keyframes myfirst {

        0% {

            left: 0px;
            top: -150px;
        }

        100% {

            left: 0px;
            top: -180px;
        }
    }
    </style>
</head>

<body>
  

    <div class="container-modal">
        <?php    
        
            $post_type = 'osetin_recipe';

            $taxonomies = get_object_taxonomies( array( 'post_type' => $post_type ) );

            //print_r($taxonomies[0]);
            $terms = get_terms( $taxonomies[0] );

            //print_r($terms);

            echo '<div id="row-categorias">';

            foreach( $terms as $term ) :
                
                //print_r($term);

                $image_id = get_term_meta( $term->term_id );
                
            /*   echo '<pre>';
                print_r( $image_id );
                echo '</pre>'; */ 

                $cat_img_id = $image_id['category_icon'];
                
                $catbg2 = $image_id['category_tile_bg'];
                $bg2 =  wp_get_attachment_image_src( $catbg2[0], 'full' );

                $id_bgimg = $image_id['category_page_background_image'];
                $bgimg = wp_get_attachment_image_src( $id_bgimg[0], 'full' );

                //echo $bg2[0];


                if ($cat_img_id != '') {                       
            
                    //echo $cat_img_id[0];

                    $post_thumbnail_img = wp_get_attachment_image_src( $cat_img_id[0], 'full' );

                    $image_src = get_category_link( $term->term_id);

                    //print_r($image_src);                

                    echo '<div class="column-categorias">';

                    echo '<a href="' . $image_src . '" target="_parent">';
                    echo '<div class="card-categorias">';
                    echo '<img title="'. $term->name . '" src="' . $post_thumbnail_img[0] . '" alt="' . $term->name . '" class="image-categorias" />';
                    echo '<img title="'. $term->name . '" src="' . $bg2[0] . '" alt="' . $term->name . '" class="image-categorias2" />';
                    echo '<div class="overlay-categorias">' . $term->name . '<span class="count-categorias">'. $term->count . '</span></div>';
                    echo '<h2 class="title-cat">' . $term->description . '</h2></div></a></div>';
                }
        
            endforeach;
            
            echo '</div>';
            
    
    ?>
    </div>

</body>