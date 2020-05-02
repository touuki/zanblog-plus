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
