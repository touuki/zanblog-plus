<?php

/**
 * Template for displaying search forms in ZanBlog Plus
 *
 * @package ZanBlog_Plus
 * @since ZanBlog Plus 1.0
 */

?>
<form role="search" class="search-form" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <label for="search-field" class="screen-reader-text"><?php echo _x('Search for:', 'label'); ?></label>
    <div class="input-group">
        <input type="search" id="search-field" class="search-field form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <span class="input-group-btn">
            <button type="submit" class="search-submit btn btn-danger"><i class="fas fa-search"></i><span class="screen-reader-text"><?php echo _x('Search', 'submit button'); ?></span></button>
        </span>
    </div>
</form>