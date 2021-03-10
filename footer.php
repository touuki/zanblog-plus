<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

</div>
<footer class="site-footer" role="contentinfo">
	<?php
	wp_nav_menu(
		array(
			'theme_location' => 'social',
			'container' => '',
			'menu_class' => 'social-links in-footer',
			'depth' => 1,
			'fallback_cb' => false
		)
	);
	?>
	<p class="site-info in-footer">
		Copyright © 2019-<?php echo current_time('Y') ?>.
		<span class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a>.</span>
		Powered by <a href="<?php echo esc_url(__('https://wordpress.org/')); ?>" target="_blank">WordPress</a>.
		Theme by <a href="http://github.com/touuki/zanblog-plus/" target="_blank">ZanBlog Plus</a>.
	</p><!-- .site-info -->
</footer>

<div class="goto-top">
	<i class="fas fa-angle-up"></i>
</div><!-- .goto-top -->

<?php wp_footer(); ?>

</body>

</html>