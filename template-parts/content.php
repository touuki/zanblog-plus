<article id="post-<?php the_ID(); ?>" <?php post_class('article panel panel-default clearfix'); ?>>
	<header class="entry-header">
		<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
		<div class="entry-meta">
			<?php if (is_sticky()) : ?>
				<i class="fas fa-bookmark article-stick hidden-xs"></i>
				<span class="label label-meta visible-xs-inline"><i class="fas fa-bookmark"></i> 置顶文章</span>
			<?php endif; ?>
			<div class="date-mark hidden-xs">
				<span class="month"><?php echo __(get_the_date('M'), 'default') ?></span>
				<span class="day"><?php echo get_the_date('d') ?></span>
			</div>
			<?php zan_entry_meta(); ?>
		</div>
	</header>
	<?php zan_post_thumbnail(); ?>
	<div class="entry-summary well">
		<?php the_excerpt();?>
	</div>
	<footer>
		<?php zan_entry_tag_list(); ?>
		<a class="btn btn-danger pull-right more-link" href="<?php the_permalink() ?>" title="详细阅读 <?php the_title_attribute(); ?>">阅读全文
		<?php if (function_exists('the_views')) the_views(true, '<span class="badge">', '</span>'); ?></a>
	</footer>

</article>