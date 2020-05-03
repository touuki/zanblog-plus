<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('panel panel-default clearfix'); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>