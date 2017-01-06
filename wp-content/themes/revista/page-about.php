<?php
  /*
   *  Template Name: Page About
   */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-figure">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
        <h2 class="Title Title--white"><?php the_title(); ?></h2>
      </figure><!-- end Page-figure -->
    <?php endif; ?>

    <section class="Page Page--bgi Page--bgiLeft Page--bgiContain" style="background-image: url('<?php echo IMAGES; ?>/welcome.jpg');">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <?php custom_breadcrumbs(); ?>

            <?php the_content(); ?>
          </div><!-- end col-md-6 -->
          <div class="col-md-6">&nbsp;</div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Welcome -->
  <?php endwhile; ?>
<?php endif; ?>

<section class="Page Page--graySoft">
  <h2 class="text-center Title Title--red Title--bdb Title--bdbSpan Title--bdbGray"><span>Equipo editorial</span></h2>

  <div class="Page-loader text-center hidden">
    <span class="glyphicon glyphicon-repeat animated rotateIn" aria-hidden="true"></span>
  </div>

  <?php
    $args = [
      'post_type' => 'team',
      'posts_per_page' => 9,
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ];
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :
  ?>
    <div class="container Page-team">
      <section class="Flex Flex--justify Flex--wrap">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <article class="Cards Cards--flex Cards--33">
            <?php if (has_post_thumbnail()) : ?>
              <figure class="Cards-figure">
                <?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
              </figure>
            <?php endif; ?>
            <div class="Cards-info">
              <?php
                $values = get_post_custom( get_the_ID() );
                $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $study = isset($values['mb_study']) ? esc_attr($values['mb_study'][0]) : '';
              ?>
              <h3 class="red"><?php echo $job; ?></h3>
              <h4><?php echo $name; ?></h4>
              <p><?php echo $study; ?></p>
            </div>
          </article>
        <?php endwhile; ?>
      </section>

      <?php
        $total = $the_query->max_num_pages;
        if ($total > 1) :
          $format = '';
          $page = 1;
      ?>
        <nav aria-label="Page navigation" class="Page-navigation text-center" id="js-nav-team">
          <?php
            echo paginate_links(array(
              'base'      =>    '/',
              'format'    =>    $format,
              'current'   =>    $page,
              'prev_next' =>    True,
              'prev_text' =>    '&laquo;',
              'next_text' =>    '&raquo;',
              'total'     =>    $total,
              'show_all'  =>    TRUE,
              'type'      =>    'list'
            ));
          ?>
        </nav>
      <?php endif; ?>
    </div><!-- end container -->
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</section>

<?php get_footer(); ?>
