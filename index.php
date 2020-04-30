<?php get_header(); ?>
<div class="row">
	<main id="mainstay" class="col-md-8" role="main">

		<?php if (is_home() && is_front_page()) : ?>
			<!-- 公告 -->
			<?php if (get_option('zan_notice')) { ?>
				<div class="well fade in">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo stripslashes(get_option('zan_notice')); ?>
				</div>
			<?php } ?>
			<!-- 公告结束 -->

			<!-- Home Banner Start -->
			<header id="banner" role="banner" class="widget-area" aria-label="<?php esc_attr_e('Banner', 'default'); ?>">
				<?php dynamic_sidebar('sidebar-2') ?>
			</header>
			<!-- Home Banner End-->
		<?php else : ?>
			<!-- 面包屑 -->
			<?php zan_breadcrumb(); ?>
			<!-- 面包屑 -->
		<?php endif; ?>

		<!-- 内容主体 -->
		<?php
		if (have_posts()) :

			// Start the Loop.
			while (have_posts()) :
				the_post();

				/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that
					 * will be used instead.
					 */
				get_template_part('template-parts/content', get_post_format());

			endwhile;

			the_posts_pagination(array(
				'prev_text'          => '«',
				'next_text'          => '»',
			));
		else :

			get_template_part('template-parts/content', 'none');

		endif;
		?>
		<!-- 内容主体结束 -->

	</main>

	<?php get_sidebar(); ?>
</div>
<?php get_footer();
