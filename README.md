wp_menu_breadcrumbs
===================

Wordpress-Plugin to display breadcrumbs that are based on the nav menu structure, rather than on the page hierarchy

Code
----

  <?php
    if (function_exists('menu_breadcrumbs')) {
      echo menu_breadcrumbs('main');
    }
  ?>
