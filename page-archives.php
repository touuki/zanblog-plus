<?php get_header(); ?>
<div class="row">
	<div class="col-md-8">
		<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
			<article class="article container well">

				<!-- 面包屑 -->
				<?php zan_breadcrumb(); ?>
				<!-- 面包屑 -->

				<?php zan_archives_list(); ?>
			</article>
		<?php endwhile; ?>
	</div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); 