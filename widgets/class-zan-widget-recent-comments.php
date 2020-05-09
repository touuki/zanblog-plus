<?php

/**
 * Widget API: Zan_Widget_Recent_Comments class
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

/**
 * Modified WP_Widget_Recent_Comments used to implement a Recent Comments widget.
 *
 * @since ZanBlog Plus 1.0
 *
 * @see WP_Widget_Recent_Comments
 */
class Zan_Widget_Recent_Comments extends WP_Widget_Recent_Comments
{

    /**
     * Outputs the content for the current Recent Comments widget instance.
     *
     * @since ZanBlog Plus 1.0
     *
     * @staticvar bool $first_instance
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Comments widget instance.
     */
    public function widget($args, $instance)
    {
        static $first_instance = true;

        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }

        $output = '';

        $title = (!empty($instance['title'])) ? $instance['title'] : __('Recent Comments');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        $number = (!empty($instance['number'])) ? absint($instance['number']) : 5;
        if (!$number) {
            $number = 5;
        }

        $comments = get_comments(
            /**
             * Filters the arguments for the Recent Comments widget.
             *
             * @see WP_Widget_Recent_Comments
             */
            apply_filters(
                'widget_comments_args',
                array(
                    'number'      => $number,
                    'status'      => 'approve',
                    'post_status' => 'publish',
                ),
                $instance
            )
        );

        $output .= $args['before_widget'];
        if ($title) {
            $output .= $args['before_title'] . $title . $args['after_title'];
        }

        $recent_comments_id = ($first_instance) ? 'recentcomments' : "recentcomments-{$this->number}";
        $first_instance     = false;

        $output .= '<ul id="' . esc_attr($recent_comments_id) . '">';
        if (is_array($comments) && $comments) {
            // Prime cache for associated posts. (Prime post term cache if we need it for permalinks.)
            $post_ids = array_unique(wp_list_pluck($comments, 'comment_post_ID'));
            _prime_post_caches($post_ids, strpos(get_option('permalink_structure'), '%category%'), false);
            foreach ($comments as $comment) {
                $output .= '<li>' . get_avatar($comment->comment_author_email, 40);
                $output .= '<a class="recentcomments" href="' . esc_url(get_comment_link($comment->comment_ID, $args)) . '">';
                if(post_password_required($comment->comment_post_ID)){
                    $output .= '<i class="fas fa-lock"></i> ' . __('This comment cannot be shown because it is belong to a protected post.', 'zanblog-plus');
                } else {
                    $output .= mb_strimwidth(strip_tags(apply_filters('comment_text', $comment->comment_content, $comment, array())), 0, 70, '[…]');
                }
                $output .= '</a></li>';
            }
        }
        $output .= '</ul>';
        $output .= $args['after_widget'];

        echo $output;
    }
}
