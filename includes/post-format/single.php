<!-- 广告 -->
<?php if ( get_option( 'zan_single_top_ad' ) ) : ?>
  <div class="ad hidden-xs">
    <?php echo stripslashes( get_option( 'zan_single_top_ad' ) ); ?>
  </div>
<?php endif; ?>
<!-- 广告结束 -->	

<!-- 内容主体 -->
<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
<article class="article container well">

	<!-- 面包屑 -->
	<div class="breadcrumb">
	    <?php 
	    	if(function_exists('bcn_display')) {
	        	echo '<i class="fa fa-home"></i> ';
	        	bcn_display();
	    	}
	    ?>
	</div>
	<!-- 面包屑结束 -->	

	<!-- 大型设备文章属性 -->
	<div class="hidden-xs">
		<div class="title-article">
			<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		</div>
		<div class="tag-article container">
			<span class="label label-zan"><i class="fa fa-tags"></i> <?php the_time('n'. '-' .'d'); ?></span>
			<span class="label label-zan"><i class="fa fa-tags"></i> <?php the_category(','); ?></span>
			<span class="label label-zan"><i class="fa fa-user"></i> <?php the_author_posts_link(); ?></span>
			<span class="label label-zan"><i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?></span>
			<?php edit_post_link( '<span class="label label-zan"><i class="fa fa-edit"></i> 编辑', ' ', '</span>'); ?>
		</div>
	</div>
	<!-- 大型设备文章属性结束 -->

	<!-- 小型设备文章属性 -->
	<div class="visible-xs">
		<div class="title-article">
			<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
		</div>
		<p>
			<i class="fa fa-calendar"></i> <?php the_time('n'); ?>-<?php the_time('d'); ?>
			<i class="fa fa-eye"></i> <?php if(function_exists('the_views')) { the_views(); } ?>
		</p>
	</div>
	<!-- 小型设备文章属性结束 -->

	<div class="centent-article">
		<figure class="thumbnail hidden-xs"><?php the_post_thumbnail( 'full' ); ?></figure>							                 
		<?php the_content(); ?>

		<!-- 分页 -->
		<div class="zan-page bs-example">
      <ul class="pager">
				<li class="previous"><?php previous_post_link('%link', '上一篇', TRUE); ?></li>
				<li class="next"><?php next_post_link('%link', '下一篇', TRUE); ?></li>
			</ul>
    </div>
    <!-- 分页 -->
		
		<!-- 文章版权信息 -->
		<div class="copyright alert alert-success">
			<p>
				版权属于:
				<?php
					if( get_post_meta( $post->ID, "版权属于", true ) ) {
						echo get_post_meta( $post->ID, "版权属于", true );
					}else {
						echo '<a href="';
						bloginfo('url');
						echo '">';
						bloginfo('name');
						echo '</a>';
					}
				?>
			</p>
			<p>
				原文地址:
				<?php
					if( get_post_meta( $post->ID, "原文地址", true ) ) {
						echo get_post_meta( $post->ID, "原文地址", true );
					} else {
						echo '<a href="';
						echo the_permalink().'">';
						echo the_permalink().'</a>';
					}
				?>
			</p>
			<p>转载时必须以链接形式注明原始出处及本声明。</p>
		</div>
		<!-- 文章版权信息结束 -->

		<!-- 文章分享 -->
		<div class="clearfix" id="bdshare">
			<div class="bdsharebuttonbox pull-right">
				<a href="#" class="bds_more" data-cmd="more"></a>
				<a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
				<a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
				<a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
			</div>
		</div>
		<!-- 文章分享结束 -->

		<script>
		window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"1","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		</script>
		<!-- Baidu Button END -->
	</div>				
</article>
<?php endwhile; ?>
<!-- 内容主体结束 -->

<!-- 广告 -->
<?php if ( get_option( 'zan_single_down_ad' ) ) : ?>
  <div class="ad hidden-xs">
    <?php echo stripslashes( get_option( 'zan_single_down_ad' ) ); ?>
  </div>
<?php endif; ?>
<!-- 广告结束 -->
				
<!-- 相关文章 -->
<div class="bs-example visible-md visible-lg" id="post-related">
	<div class="row">
		<div class="alert alert-danger related-title text-center"><i class="fa fa-heart"></i> 您可能也喜欢:</div>
			<?php 
			global $post;
			$cats = wp_get_post_categories( $post->ID );

			if ( $cats ) {
				$args = array(
								'category__in' => array( $cats[0] ),
								'post__not_in' => array( $post->ID ),
								'showposts' => 3,
				);
				query_posts( $args );

	    if ( have_posts()  ) {
						while ( have_posts() ) {
							the_post(); update_post_caches( $posts ); ?>				            
	            <div class="col-md-4">
	            <div class="thumbnail">
	              <div class="caption clearfix">
										<p class="post-related-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></p>
										<p class="post-related-content"><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 150,"..."); ?></p>
										<p><a class="btn btn-danger pull-right read-more" href="<?php the_permalink() ?>"  title="详细阅读 <?php the_title(); ?>">阅读全文</a></p>							
									</div>
	            </div>					                
	            </div>
	            <?php
	          }
	        }
			wp_reset_query(); } ?>
	</div>
</div>
<!-- 相关文章结束 -->