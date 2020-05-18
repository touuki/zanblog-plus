<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */
?>

<section class="no-results not-found panel panel-default clearfix">
	<header class="page-header">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'zanblog-plus' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p>
			<?php
			/* translators: %s: Post editor URL. */
			printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'zanblog-plus' ), esc_url( admin_url( 'post-new.php' ) ) );
			?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'zanblog-plus' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we cannot find what you are looking for. Perhaps searching can help.', 'zanblog-plus' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->