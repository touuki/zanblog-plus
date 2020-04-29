<div class="article well clearfix">
	<?php if( is_sticky() ) echo '<i class="fa fa-bookmark article-stick visible-md visible-lg"></i>';?>
	
	<div class="data-article hidden-xs">
		<span class="month"><?php the_time('n月') ?></span>
		<span class="day"><?php the_time('d') ?></span>
	</div>

	<!-- 大型设备文章属性 -->
	<section class="hidden-xs">
		<div class="title-article">
			<h1><a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
			</a></h1>
		</div>
		<div class="tag-article">
			<span class="label label-zan"><i class="fa fa-tags"></i> <?php the_category(','); ?></span>
			<span class="label label-zan"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
			<span class="label label-zan"><i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?></span>
		</div>
		<div class="content-article">					
			<figure class="thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'full' ); ?></a></figure>							
			<div class="alert alert-zan">				
				<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 250,"..."); ?>
			</div>
		</div>
		<a class="btn btn-danger pull-right read-more" href="<?php the_permalink() ?>"  title="详细阅读 <?php the_title(); ?>">阅读全文 <span class="badge"><?php comments_number( '0', '1', '%' ); ?></span></a>
	</section>
	<!-- 大型设备文章属性结束 -->

	<!-- 小型设备文章属性 -->
	<section class="visible-xs">
		<div class="title-article">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
		</div>
		<p>
			<i class="fa fa-calendar"></i> <?php the_time('n'); ?>-<?php the_time('d'); ?>
			<i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
		</p>
		<div class="content-article">					
			<figure class="thumbnail"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'full' ); ?></a></figure>							
			<div class="alert alert-zan">					
				<?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150,"..."); ?>
			</div>
		</div>
		<a class="btn btn-danger pull-right read-more btn-block" href="<?php the_permalink() ?>"  title="详细阅读 <?php the_title(); ?>">阅读全文 <span class="badge"><?php comments_number( '0', '1', '%' ); ?></span></a>
	</section>
	<!-- 小型设备文章属性结束 -->

</div>

