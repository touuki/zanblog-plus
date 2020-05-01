<article class="article panel panel-default clearfix">
	<header>
		<?php if (is_sticky()) : ?>
			<i class="fa fa-bookmark article-stick hidden-xs"></i>
		<?php endif; ?>
		<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
		<div class="data-article hidden-xs">
			<span class="month"><?php the_time('n月') ?></span>
			<span class="day"><?php the_time('d') ?></span>
		</div>
		<div class="entry-meta">
			<?php if (is_sticky()) : ?>
				<span class="label label-meta visible-xs-inline"><i class="fa fa-bookmark"></i> 置顶</span>
			<?php endif; ?>
			<span class="label label-meta visible-xs-inline"><i class="fa fa-calendar-alt"></i> <?php the_time('Y-m-d'); ?></span>
			<span class="label label-meta"><i class="fa fa-folder"></i> <?php the_category(','); ?></span>
			<span class="label label-meta"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
			<?php if (function_exists('the_views')) : ?>
				<span class="label label-meta">
					<i class="fa fa-eye"></i> <?php the_views(); ?>
				</span>
			<?php endif; ?>
		</div>
	</header>
	<div class="content-article">
		<figure class="thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('full'); ?></a></figure>
		<div class="alert alert-zan">
			<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 250, "..."); ?>
		</div>
	</div>
	<a class="btn btn-danger pull-right read-more" href="<?php the_permalink() ?>" title="详细阅读 <?php the_title(); ?>">阅读全文 <span class="badge"><?php comments_number('0', '1', '%'); ?></span></a>

</article>