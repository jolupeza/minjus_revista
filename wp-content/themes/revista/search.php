<?php get_header(); ?>

<figure class="Page-figure">
  <img src="<?php echo IMAGES; ?>/page-about.jpg" alt="" class="img-responsive center-block hidden-xs">
  <h2 class="Title Title--white">Buscador</h2>
</figure><!-- end Page-figure -->

<section class="Page">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php custom_breadcrumbs(); ?>

        <?php get_search_form(); ?>

        <section class="Search-wrapper">
          <?php if (have_posts()) : ?>
            <?php while (have_posts()) : ?>
              <?php the_post(); ?>
              <article class="Search">
                <h3 class="helvMedium"><a class="red" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p class="hidden-xs"><a href="<?php the_permalink(); ?>"><?php echo get_permalink(); ?></a></p>
                <?php the_content(''); ?>
              </article><!-- end Search -->
            <?php endwhile; ?>

            <?php
              global $wp_query;
              $total = $wp_query->max_num_pages;

              if ( $total > 1 ) :
            ?>
              <nav aria-label="Page navigation" class="Page-navigation text-center">
                <?php
                  $current_page = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
                  $format = '&paged=%#%';

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
          <?php else : ?>
            <div class="alert alert-danger" role="alert">No se encontró coincidencias con su parámetro de búsqueda.</div>
          <?php endif; ?>
        </section><!-- end Search-wrapper -->
      </div><!-- end col-md-12 -->
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end Welcome -->

<?php get_footer(); ?>
