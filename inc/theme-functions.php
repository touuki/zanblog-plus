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