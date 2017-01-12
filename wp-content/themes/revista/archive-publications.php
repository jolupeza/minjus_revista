<?php get_header(); ?>

<?php
  $lastPost = 0;
?>

<figure class="Page-figure">
  <img class="img-responsive center-block hidden-xs" src="<?php echo IMAGES; ?>/archivosbg.jpg" alt="" />
  <h2 class="Title Title--white">Publicaciones</h2>
</figure><!-- end Page-figure -->

<section class="Page Page--nopdbt">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php custom_breadcrumbs(); ?>

        <?php
          $args = [
            'post_type' => 'publications',
            'posts_per_page' => 1
          ];
          $the_query = new WP_Query($args);

          if ($the_query->have_posts()) :
            while ($the_query->have_posts()) :
              $the_query->the_post();

              $lastPost = get_the_id();
        ?>
            <section class="LastFile">
              <div class="row">
                <div class="col-sm-4">
                  <?php if (has_post_thumbnail()) : ?>
                    <figure>
                      <?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
                    </figure>
                  <?php endif; ?>
                </div>
                <div class="col-sm-8">
                  <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>
                  <?php the_content(''); ?>
                  <p class="Page-button"><a href="<?php the_permalink(); ?>" class="Button Button--red">Leer revista ></a></p>
                </div>
              </div><!-- end row -->
            </section><!-- end LastFile -->
          <?php endwhile; ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php
          if ($lastPost > 0) :

            global $wp_query;
            $args = [
              'post__not_in' => [$lastPost],
            ];
            $args = array_merge($wp_query->query_vars, $args);
            query_posts($args);

            if (have_posts()) :
        ?>
              <h3 class="Title Title--red Title--bdb Title--bdbGray">Publicaciones anteriores</h3>
          <?php endif; ?>
        <?php endif; ?>
      </div><!-- end col-md-12 -->
    </div><!-- end row -->
  </div><!-- end container -->

  <?php if (have_posts()) : ?>
    <section class="OldFiles">
      <div class="container">
        <div class="row">
          <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <div class="col-md-4 col-sm-6">
              <article class="OldFiles-item Flex Flex--justify">
                <?php if (has_post_thumbnail()) : ?>
                  <figure class="Flex-40">
                    <?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
                  </figure>
                <?php endif; ?>
                <div class="OldFiles-item-info Flex-50">
                  <h4 class="red helvMedium"><?php the_title(); ?> <?php the_date('M Y'); ?></h4>
                  <p class="Page-button">
                    <a href="<?php the_permalink(); ?>" class="Button Button--red">Leer revista ></a>
                  </p>
                </div>
              </article>
            </div>
          <?php endwhile; ?>
        </div><!-- end row -->

        <?php
          $total = $wp_query->max_num_pages;

          if ( $total > 1 ) :
        ?>
          <nav aria-label="Page navigation" class="Page-navigation text-center">
            <?php
              $current_page = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
              $format = ( get_option('permalink_structure' ) == '/%postname%/') ? 'page/%#%/' : '&paged=%#%';

              echo paginate_links(array(
                'base'      =>    get_pagenum_link(1) . '%_%',
                'format'    =>    $format,
                'current'   =>    $current_page,
                'prev_next' =>    True,
                'prev_text' =>    __('&laquo;', THEMEDOMAIN),
                'next_text' =>    __('&raquo;', THEMEDOMAIN),
                'total'     =>    $total,
                'mid_size'  =>    4,
                'type'      =>    'list'
              ));
            ?>
          </nav>
        <?php endif; ?>
      </div><!-- end container -->
    </section><!-- end OldFiles -->
  <?php endif; ?>
</section><!-- end Page -->

<?php
  $filepath = TEMPLATEPATH . '/includes/contribute.php';

  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
