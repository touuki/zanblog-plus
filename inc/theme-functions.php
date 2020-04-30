<?php

/**
 * Theme-Functions 主要函数
 *
 * @package     ZanBlog
 * @subpackage  Include
 * @since       2.1.0
 * @author      YEAHZAN
 */

/**
 * ZanBlog 自定义子菜单类
 *
 * @since Zanblog 2.0.0
 *
 * @return void
 */
class Zan_Nav_Menu extends Walker_Nav_Menu
{

  function start_lvl(&$output, $depth = 0, $args = array())
  {
    $indent  = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";

    return $output;
  }
}

/**
 * 获取评论列表
 *
 * @since 2.1.0
 * @return array [评论列表]
 */
function zan_get_commments_list($size)
{
  $args = array(
    'walker'            => null,
    'max_depth'         => '',
    'style'             => 'ol',
    'callback'          => null,
    'end-callback'      => null,
    'type'              => 'all',
    'reply_text'        => '回复',
    'page'              => '',
    'avatar_size'       => $size,
    'reverse_top_level' => null,
    'reverse_children'  => '',
    'format'            => 'html5',
    'short_ping'        => false,
    'echo'              => true
  );

  return wp_list_comments($args);
}

/**
 * 获取评论分页
 *
 * @since 2.1.0
 * @return array [评论分页]
 */
function zan_comments_pagination()
{
  $args = array(
    'prev_text'    => __('«'),
    'next_text'    => __('»')
  );

  return paginate_comments_links($args);
}

/**
 * 评论表单
 *
 * @since 2.1.0
 * @return array [自定义表单]
 */
function zan_comments_form()
{
  $args = array(
    'title_reply'          => '<i class="fa fa-pencil"></i> 欢迎留言',
    'title_reply_to'       => __('回复 %s'),
    'cancel_reply_link'    => __('取消回复'),
    'fields'               => array(
      'author' => '<div class="row"><div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" name="author" id="author" placeholder="* 昵称"></div></div>',
      'email'  => '<div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope-o"></i></span><input type="text" name="email" id="email" placeholder="* 邮箱"></div></div>',
      'url'    => '<div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input type="text" name="url" id="url" placeholder="网站"></div></div></div>'
    ),
    'comment_field'        => '<textarea id="comment" placeholder="赶快发表你的见解吧！" name="comment" cols="45" rows="8" aria-required="true"></textarea>',
    'comment_notes_before' => '<div id="commentform-error" class="alert hidden"></div>',
    'comment_notes_after' => ''

  );
  return comment_form($args);
}

/**
 * 彩色云标签
 *
 * @since Zanblog 2.0.0
 *
 * @return tags.
 */
function zan_color_cloud($text)
{
  $text = preg_replace_callback('|<a (.+?)>|i', 'zan_color_cloud_callback', $text);
  return $text;
}

function zan_color_cloud_callback($matches)
{
  $text = $matches[1];
  $color = dechex(rand(0, 16777215));
  $pattern = '/style=(\'|\")(.*)(\'|\")/i';
  $text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);

  return "<a $text>";
}
add_filter('wp_tag_cloud', 'zan_color_cloud', 1);

/**
 *   文章存档函数
 *
 * @since Zanblog 2.0.5
 *
 * @return archives.
 */
function zan_archives_list()
{
  if (!$output = get_option('zan_archives_list')) {
    $output = '<div id="archives">';
    $the_query = new WP_Query('posts_per_page=-1&ignore_sticky_posts=1');
    $year = 0;
    $mon = 0;
    $i = 0;
    $j = 0;
    while ($the_query->have_posts()) : $the_query->the_post();
      $year_tmp = get_the_time('Y');
      $mon_tmp = get_the_time('m');
      $y = $year;
      $m = $mon;
      if ($mon != $mon_tmp && $mon > 0) $output .= '</div></div></div>';
      if ($year != $year_tmp && $year > 0) $output .= '</div>';
      if ($year != $year_tmp) {
        $year = $year_tmp;
        $output .= '<h3 class="year">' . $year . ' 年</h3><div class="panel-group" id="accordion">';
      }
      if ($mon != $mon_tmp) {
        $mon = $mon_tmp;
        $output .= '<div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $year . $mon . '">
                                  ' . $mon . ' 月</a></h4></div>
                      <div id="collapse' . $year . $mon . '" class="panel-collapse collapse">
                          <div class="panel-body">';
      }
      $output .= '<p>' . get_the_time('d日: ') . '<a href="' . get_permalink() . '">' . get_the_title() . '</a> <span class="badge">' . get_comments_number('0', '1', '%') . '</span></p>';

    endwhile;
    wp_reset_postdata();
    $output .= '</div></div></div></div></div>';
    update_option('zan_archives_list', $output);
  }
  echo $output;
}
function clear_zal_cache()
{
  update_option('zan_archives_list', '');
}
add_action('save_post', 'clear_zal_cache');
