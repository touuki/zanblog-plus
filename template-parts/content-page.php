<?php

/**
 * The template used for displaying page content
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry panel panel-default clearfix'); ?>>
	<header class="entry-header">
		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
	</header>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before'      => '<div class="page-links"><span class="page-links-title screen-reader-text">' . _x('Pages:', 'link_pages', 'zanblog-plus') . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => _x('<span class="screen-reader-text">Page </span>%', 'link_pages', 'zanblog-plus'),
				'separator'   => '<span class="screen-reader-text">, </span>',
			)
		);
		?>
	</div>
</article>