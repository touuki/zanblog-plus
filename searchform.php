<?php
/**
 * Template for displaying search forms in ZanBlog Plus
 *
 * @package WordPress
 * @subpackage ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 * @version 1.0
 */

?>
<div class="search panel">
    <form role="search" class="search-form form-inline clearfix" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
        <label class="sr-only">
            <span class="screen-reader-text"><?php echo _x('Search for:', 'label', 'default'); ?></span>
        </label>
        <input type="search" class="search-field form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'default'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="search-submit btn btn-danger"><i class="fa fa-search"></i><span class="screen-reader-text"><?php echo _x('Search', 'submit button', 'default'); ?></span></button>
    </form>
</div>