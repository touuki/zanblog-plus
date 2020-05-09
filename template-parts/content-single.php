<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article panel panel-default clearfix'); ?>>
	<header class="entry-header">

		<?php zan_breadcrumb(false); ?>

		<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
		<div class="entry-meta">
			<?php zan_entry_meta(); ?>
		</div>
	</header>

	<?php zan_post_thumbnail(); ?>
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
	<?php
	if (is_singular('attachment')) {
		// Parent post navigation.
		the_post_navigation(
			array(
				'prev_text' => '<span class="meta-nav">' . __('Back to Parent Post', 'zanblog-plus') . '</span><span class="screen-reader-text">:%title</span>',
			)
		);
	} elseif (is_singular('post')) {
		// Previous/next post navigation.
		the_post_navigation(
			array(
				'next_text' => '<span class="meta-nav">' . __('Next post', 'zanblog-plus') . '</span>' .
					'<span class="screen-reader-text">' . ': %title</span> ',
				'prev_text' => '<span class="meta-nav">' . __('Previous post', 'zanblog-plus') . '</span>' .
					'<span class="screen-reader-text">' . ': %title</span> ',
				'in_same_term' => true,
			)
		);
	}
	?>
	<footer>
		<?php if (get_option('copyright_post') || is_customize_preview()) : ?>
			<div class="copyright-post alert alert-success"><?php zan_copyright_post(); ?></div>
		<?php endif; ?>
		<?php zan_entry_tag_list(); ?>
	</footer>
</article>