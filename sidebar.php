<aside class="col-md-4" id="sidebar">
  <?php
  if (is_single()) dynamic_sidebar('single-sidebar');
  if (is_home()) dynamic_sidebar('index-sidebar');
  if (is_archive() || is_search()) dynamic_sidebar('archive-sidebar');
  if (is_page()) dynamic_sidebar('page-sidebar');
  ?>
</aside>