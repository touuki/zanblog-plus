<?php

/**
 * Custom ZanBlog Plus template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

if (!function_exists('zan_entry_meta')) :
    /**
     * Prints HTML with meta information for the categories, tags.
     *
     * Create your own zan_entry_meta() function to override in a child theme.
     *
     * @since ZanBlog Plus 1.0
     */
    function zan_entry_meta()
    {
        if ('post' === get_post_type()) {
            printf(
                '<span class="byline"><a href="%1$s" class="author label label-meta"><i class="fas fa-user"></i> <span class="screen-reader-text">%2$s</span>%3$s</a></span>',
                esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                _x('Author', 'Used before post author name.', 'zanblog-plus'),
                get_the_author()
            );
        }

        if (in_array(get_post_type(), array('post', 'attachment'))) {
            zan_entry_date();
        }

        if ('post' === get_post_type()) {
            zan_entry_category_list();
        }

        $comments_number = get_comments_number();
        if (!is_singular() && !post_password_required() && (comments_open() || $comments_number)) {
            echo '<span class="comments-link">';
            comments_popup_link(
                '<i class="fas fa-comments"></i> ' . __('Leave a comment', 'zanblog-plus'),
                '<i class="fas fa-comments"></i> ' . __('1<span class="screen-reader-text"> Comment</span>', 'zanblog-plus'),
                '<i class="fas fa-comments"></i> ' . sprintf(
                    /* translators: %s: Comments number. */
                    __('%s<span class="screen-reader-text"> Comments</span>', 'zanblog-plus'), 
                    $comments_number
                ),
                'label label-meta'
            );
            echo '</span>';
        }

        if (function_exists('the_views')) {
            the_views(true, '<span class="post-views"><span class="label label-meta"><i class="fas fa-eye"></i> ', '</span></span>');
        }

        zan_edit_link();
    }
endif;

if (!function_exists('zan_entry_date')) :
    /**
     * Prints HTML with date information for current post.
     *
     * Create your own zan_entry_date() function to override in a child theme.
     *
     * @since ZanBlog Plus 1.0
     */
    function zan_entry_date()
    {
        $time_string = '<time class="label label-meta entry-date published updated" datetime="%1$s"><i class="fas fa-calendar-alt"></i> %2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="label label-meta entry-date published" datetime="%1$s"><i class="fas fa-calendar-alt"></i> %2$s</time>';
            $time_string .= '<time class="label label-meta updated" datetime="%3$s"><i class="fas fa-eraser"></i> %4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date('c')),
            get_the_date(),
            esc_attr(get_the_modified_date('c')),
            get_the_modified_date()
        );

        printf(
            '<span class="posted-on"><span class="screen-reader-text">%1$s </span>%2$s</span>',
            _x('Posted on', 'Used before publish date.', 'zanblog-plus'),
            $time_string
        );
    }
endif;

if (!function_exists('zan_entry_category_list')) :
    /**
     * Prints HTML with category and tags for current post.
     *
     * Create your own zan_entry_category_list() function to override in a child theme.
     *
     * @since ZanBlog Plus 1.0
     */
    function zan_entry_category_list()
    {
        $categories_list = get_the_category_list('</span><span class="label label-meta"><i class="fas fa-folder"></i> ');
        if ($categories_list) {
            printf(
                '<span class="cat-links"><span class="screen-reader-text">%1$s </span><span class="label label-meta"><i class="fas fa-folder"></i> %2$s</span></span>',
                __('Categories'),
                $categories_list
            );
        }
    }
endif;

if (!function_exists('zan_entry_tag_list')) :
    /**
     * Prints HTML with category and tags for current post.
     *
     * Create your own zan_entry_tag_list() function to override in a child theme.
     *
     * @since ZanBlog Plus 1.0
     */
    function zan_entry_tag_list()
    {
        $tags_list = get_the_tag_list();
        if ($tags_list && !is_wp_error($tags_list)) {
            printf(
                '<span class="tags-links"><span class="screen-reader-text">%1$s</span><i class="fas fa-tags"></i> %2$s</span>',
                __('Tags: '),
                $tags_list
            );
        }
    }
endif;

if (!function_exists('zan_post_thumbnail')) :
    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     *
     * Create your own zan_post_thumbnail() function to override in a child theme.
     *
     * @since ZanBlog Plus 1.0
     */
    function zan_post_thumbnail()
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) : ?>
            <figure class="post-thumbnail thumbnail"><?php the_post_thumbnail(); ?></figure>
        <?php else : ?>
            <figure class="thumbnail">
                <a class="post-thumbnail" href="<?php the_permalink() ?>" aria-hidden="true">
                    <?php the_post_thumbnail('post-thumbnail', array('alt' => the_title_attribute('echo=0'))); ?>
                </a>
            </figure>
        <?php
        endif; // End is_singular().
    }
endif;

function zan_excerpt_length($length)
{
	if (is_singular()) {
		return 80;
	} else {
		return 250;
	}
}
add_filter('excerpt_length', 'zan_excerpt_length');

if ( ! function_exists( 'zan_excerpt_more' ) && ! is_admin() ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
	 * a 'Continue reading' link.
	 *
	 * Create your own zan_excerpt_more() function to override in a child theme.
	 *
	 * @since ZanBlog Plus 1.0
	 *
	 * @return string 'Continue reading' link prepended with an ellipsis.
	 */
	function zan_excerpt_more() {
		return ' &hellip;';
	}
	add_filter( 'excerpt_more', 'zan_excerpt_more' );
endif;

if (!function_exists('zan_edit_link')) :
    /**
     * Returns an accessibility-friendly link to edit a post or page.
     *
     * This also gives us a little context about what exactly we're editing
     * (post or page?) so that users understand a bit more where they are in terms
     * of the template hierarchy and their content. Helpful when/if the single-page
     * layout with multiple posts/pages shown gets confusing.
     */
    function zan_edit_link()
    {
        edit_post_link(
            '<i class="fas fa-edit"></i> ' . sprintf(
                /* translators: %s: Post title. */
                __('Edit') . '<span class="screen-reader-text"> "%s"</span>',
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>',
            0,
            'post-edit-link label label-meta'
        );
    }
endif;

if ( ! function_exists( 'zan_the_custom_logo' ) ) :
	/**
	 * Displays the optional custom logo.
	 *
	 * Does nothing if the custom logo is not available.
	 *
	 * @since ZanBlog Plus 1.0
	 */
	function zan_the_custom_logo() {
		if ( function_exists( 'the_custom_logo' ) ) {
			the_custom_logo();
		}
	}
endif;

if (!function_exists('wp_body_open')) :
    /**
     * Fire the wp_body_open action.
     *
     * Added for backward compatibility to support pre-5.2.0 WordPress versions.
     *
     * @since ZanBlog Plus 1.0
     */
    function wp_body_open()
    {
        /**
         * Triggered after the opening <body> tag.
         *
         * @since ZanBlog Plus 1.0
         */
        do_action('wp_body_open');
    }
endif;
