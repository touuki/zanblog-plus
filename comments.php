<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
  return;
}
?>

<div id="comments" class="comments-area panel panel-default">
  <?php if (have_comments()) : ?>
    <h2 class="comments-title alert alert-info">
      <i class="fa fa-comments"></i> <?php comments_number(); ?>
    </h2>
    <div id="loading-comments"><i class="fa fa-spinner fa-spin"></i></div>
    <ol class="commentlist">
      <?php
      wp_list_comments(
        array(
          'avatar_size' => 70,
          'style'       => 'ol',
          'short_ping'  => true,
          'reply_text'  => '<i class="fa fa-reply"></i> ' . __('Reply', 'default'),
        )
      );
      ?>
    </ol>
  <?php
    the_comments_pagination(
      array(
        'prev_text' => '«',
        'next_text' => '»',
      )
    );
  endif;

  if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
  ?>

    <p class="no-comments"><?php _e('Comments are closed.', 'twentyseventeen'); ?></p>
  <?php
  endif;

  comment_form(
    array(
      'title_reply'          => '<i class="fa fa-pencil"></i> ' . __('Leave a Reply', 'default'),
      'fields'               => array(
        'author' => '<div class="row"><div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span><input type="text" name="author" id="author" placeholder="* 昵称"></div></div>',
        'email'  => '<div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span><input type="text" name="email" id="email" placeholder="* 邮箱"></div></div>',
        'url'    => '<div class="col-sm-4"><div class="input-group"><span class="input-group-addon"><i class="fa fa-link"></i></span><input type="text" name="url" id="url" placeholder="网站"></div></div></div>'
      ),
      'class_submit' => 'submit btn btn-danger btn-block'

    )
  );
  ?>
</div>