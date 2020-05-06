<?php
/**
 * Template Name: Full Width Template
 * Template Post Type: page
 *
 * @package WordPress
 * @subpackage ZanBlog_plug
 * @since ZanBlog-Plug 1.0
 */
get_header(); ?>
<main>
	<?php
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
<?php get_footer();