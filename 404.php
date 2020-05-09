<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

get_header(); ?>
<main id="main" class="site-main" role="main">
	<section class="error-404 not-found alert alert-danger clearfix">
		<header class="page-header">
			<h1 class="page-title"><i class="fas fa-frown-open"></i> <?php _e('Oops! That page cannot be found.', 'zanblog-plus'); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'zanblog-plus'); ?></p>

			<?php get_search_form(); ?>
		</div><!-- .page-content -->
	</section><!-- .error-404 -->
</main><!-- .site-main -->
<?php get_footer();
