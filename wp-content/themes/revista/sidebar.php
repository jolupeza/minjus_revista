<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) : ?>

  <article class="Sidebar-widget">

    <div class="Sideber-title">
      <h3 class="Title Title--red Title--bdb Title--bdbGray"><?php bloginfo('title'); ?></h3>
    </div>
    <p><?php bloginfo('description'); ?></p>

  </article><!-- end Sidebar-widget -->

<?php endif; ?>


