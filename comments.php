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
    <h2 class="comments-title alert alert-warning">
      <i class="fas fa-comments"></i> <?php comments_number(); ?>
    </h2>
    <ol class="commentlist">
      <?php
      wp_list_comments(
        array(
          'avatar_size' => 70,
          'style'       => 'ol',
          'short_ping'  => true,
          'reply_text'  => '<i class="fas fa-reply"></i> ' . __('Reply', 'default'),
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

  if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="no-comments"><?php _e('Comments are closed.', 'default'); ?></p>
  <?php endif;
  zan_comment_form();
  ?>
</div>