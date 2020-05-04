<?php

/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article panel panel-default clearfix'); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title screen-reader-text">' . __('Pages:', 'default') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __('Page', 'default') . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
		?>
	</div>
</article>