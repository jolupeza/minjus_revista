<?php
  /*
   *  Template Name: Page Politics
   */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-figure">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block hidden-xs']); ?>
        <h2 class="Title Title--white"><?php the_title(); ?></h2>
      </figure><!-- end Page-figure -->
    <?php endif; ?>

    <section class="Page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php custom_breadcrumbs(); ?>

            <?php
              global $post;
              $pageKids = get_pages("child_of=" . get_the_id() . "&sort_column=menu_order");

              if (count($pageKids)) :
                $i = 0;
            ?>
                <div class="panel-group PanelGroup" id="accordion-politics" role="tablist" aria-multiselectable="true">
                  <?php foreach ($pageKids as $post) : ?>
                    <?php setup_postdata($post); ?>
                    <div class="panel Panel">
                      <div class="panel-heading active" role="tab" id="heading-<?php echo $i; ?>">
                        <h2 class="Title Title--red Title--bdb Title--bdbGray panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion-politics" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>"><?php the_title(); ?></a>
                        </h2>
                      </div>
                      <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
                        <div class="panel-body">
                          <?php the_content(); ?>
                        </div>
                      </div>
                    </div><!-- end Panel -->
                    <?php $i++; ?>
                  <?php endforeach; ?>
                </div><!-- end PanelGroup -->
            <?php endif; ?>
          </div><!-- end col-md-12 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Welcome -->
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
