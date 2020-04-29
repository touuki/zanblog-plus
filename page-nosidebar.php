<?php
/*
	Template Name: 全屏页面(不带侧边栏)
	*/
get_header(); ?>
<!-- 内容主体 -->
<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	<article class="article well clearfix">
		<?php the_content(); ?>
	</article>
<?php endwhile; ?>
<!-- 内容主体结束 -->
<?php get_footer();