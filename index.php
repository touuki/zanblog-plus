<?php get_header(); ?>
<div class="row">
	<main id="mainstay" class="col-md-8">

		<?php if (is_home()) : ?>
			<div id="ie-warning" class="alert alert-danger fade in">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<i class="fa fa-warning"></i> 请注意，<?php bloginfo('name'); ?>并不支持低于IE8的浏览器，为了获得最佳效果，请下载最新的浏览器，推荐下载 <i class="fa fa-compass"></i> Chrome浏览器
			</div>

			<!-- 公告 -->
			<?php if (get_option('zan_notice') && is_home()) { ?>
				<div class="well fade in">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<?php echo stripslashes(get_option('zan_notice')); ?>
				</div>
			<?php } ?>
			<!-- 公告结束 -->

			<!-- 幻灯片 -->
			<aside id="slider">
				<?php dynamic_sidebar('slide-sidebar'); ?>
			</aside>
			<!-- 幻灯片结束-->
		<?php endif; ?>
		<!-- 面包屑 -->
		<?php zan_breadcrumb(); ?>
		<!-- 面包屑 -->

		<!-- 内容主体 -->
		<div id="article-list">
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
		</div>
		<!-- 内容主体结束 -->

	</main>

	<?php get_sidebar(); ?>
</div>
<?php get_footer();
