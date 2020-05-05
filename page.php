<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

get_header(); ?>
<div class="row">
	<main class="col-md-8">
		<?php
		get_sidebar('head');
		// Start the Loop.
		while (have_posts()) :
			the_post();
		
			get_template_part('template-parts/content', 'page');

			// If comments are open or we have at least one comment, load up the comment template.
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;

		endwhile; // End the loop.
		?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php get_footer();
