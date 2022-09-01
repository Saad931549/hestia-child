<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();
?>

<main id="site-content" role="main">

	<?php

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
		}
	}
	echo "this is test crappp<br>";
    /*get_template_part('template-parts/nest-chart');*/
/*	if(is_page('Nest Data') ) get_template_part('template-parts/nest-chart');*/
	if(is_page('Nest Data') ) echo "TJTLKJWEEEEEEEEEEEEEEE<br>";

	?>

</main><!-- #site-content -->

<?php get_template_part( 'template-parts/footer-menus-widgets' );
	echo "this is test crappp templante part<br>";
 ?>

<?php get_footer(); 
	echo "this is test crappp footer<br>";
?>
