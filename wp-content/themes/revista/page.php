<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <figure class="Page-figure">
      <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block hidden-xs']); ?>
      <h2 class="Title Title--white"><?php the_title(); ?></h2>
    </figure><!-- end Page-figure -->

    <section class="Page">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php custom_breadcrumbs(); ?>

            <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>

            <?php the_content(); ?>
          </div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
