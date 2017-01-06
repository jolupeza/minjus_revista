<?php get_header(); ?>

<?php $options = get_option('revista_custom_settings'); ?>

<?php
  $args = [
    'post_type' => 'publications',
    'posts_per_page' => 5,
  ];
  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    $i = 0;
?>
    <section id="carousel-home" class="carousel slide Carousel Carousel--home" data-ride="carousel">
      <div class="carousel-inner" role="listbox">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <?php $active = ($i === 0) ? 'active' : ''; ?>

          <?php
            $values = get_post_custom(get_the_id());
            $image = isset( $values['mb_image'] ) ? esc_attr($values['mb_image'][0]) : '';
            $text = (isset($values['mb_text'])) ? $values['mb_text'][0] : '';
          ?>

          <div class="item <?php echo $active; ?>">
            <?php if (!empty($image)) : ?>
              <img src="<?php echo $image; ?>" alt="<?php the_title(); ?>" class="img-responsive center-block">
            <?php endif; ?>
            <div class="carousel-caption text-center">
              <?php
                if (!empty($text)) {
                  echo $text;
                }
              ?>
              <p>
                <a href="<?php the_permalink(); ?>" class="Button Button--white">Ver edición</a>
              </p>
            </div>
          </div>
          <?php $i++; ?>
        <?php endwhile; ?>
      </div>

      <?php if ($the_query->post_count > 1) : ?>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      <?php endif; ?>
    </section><!-- end Carousel -->
<?php endif; ?>

<?php
  $aboutPage = get_page_by_title('Acerca de la revista');
  $pageKids = get_pages("child_of=" . $aboutPage->ID."&sort_column=menu_order");
  $firstChild = $pageKids[0];

  $args = [
    'p' => $firstChild->ID,
    'posts_per_page' => 1,
    'post_type' => 'page'
  ];
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
      $the_query->the_post();
?>
    <section class="Welcome Page Page--bgi Page--bgiLeft Page--bgiContain" style="background-image: url('<?php echo IMAGES; ?>/welcome.jpg');">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h2 class="h2 Title Title--red Title--bdb Title--bdbGray">
              <?php if (has_excerpt()) : ?>
                <?php echo get_the_excerpt(); ?>
              <?php else : ?>
                <?php the_title(); ?>
              <?php endif; ?>
            </h2>
            <?php the_content(''); ?>
            <p class="Page-button"><a href="<?php the_permalink(); ?>" class="Button Button--white Button--white--bd">conocer más ></a></p>
          </div><!-- end col-md-6 -->
          <div class="col-md-6">&nbsp;</div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Welcome -->
  <?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>

<?php if (!empty($options['text_contribute']) && !empty($options['link_contribute'])) : ?>
  <aside class="Contribute Page Page--bgi Page--bgiCenter Page--bgiCover" style="background-image: url('<?php echo IMAGES; ?>/contribute.jpg');">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h2 class="Title Title--white Title--bdb Title--bdbWhite"><?php echo $options['text_contribute']; ?></h2>
        </div>
        <div class="col-md-4">
          <?php
            $permalink = get_permalink((int)$options['link_contribute']);
          ?>
          <p class="text-center"><a href="<?php echo $permalink; ?>" class="Button Button--transparent">Sí deseo participar</a></p>
        </div>
      </div><!-- end row -->
    </div><!-- end container -->
  </aside><!-- end Contribute -->
<?php endif; ?>

<?php get_footer(); ?>
