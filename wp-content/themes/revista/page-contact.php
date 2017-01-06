<?php
  /*
   *  Template Name: Page Contact
   */
?>
<?php get_header(); ?>

<?php $options = get_option('revista_custom_settings'); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-figure">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
        <h2 class="Title Title--white"><?php the_title(); ?></h2>
      </figure><!-- end Page-figure -->
    <?php endif; ?>

    <section class="Page Page--info">
      <div class="container">
        <div class="row">
          <div class="col-md-5">
            <?php custom_breadcrumbs(); ?>

            <h2 class="Title Title--red Title--bdb Title--bdbGray">Contacto</h2>

            <?php if (!empty($options['address'])) : ?>
              <h4 class="Title-legend black">Dirección Postal</h4>

              <p><?php echo $options['address']; ?></p>
            <?php endif; ?>

            <?php if (!empty($options['main_contact'])) : ?>
              <h4 class="Title-legend black">Contacto principal</h4>
              <p><?php echo $options['main_contact']; ?></p>
            <?php endif; ?>

            <?php if (!empty($options['asistance_contact'])) : ?>
              <h4 class="Title-legend black">Contacto de asistencia</h4>
              <p><?php echo $options['asistance_contact']; ?></p>
            <?php endif; ?>
          </div><!-- end col-md-5 -->
          <div class="col-md-7">
            <?php
              $lat = $options['latitud'];
              $long = $options['longitud'];
            ?>
            <figure class="Footer-map" id="map" data-lat="<?php echo $lat; ?>" data-long="<?php echo $long; ?>"></figure>
          </div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Welcome -->
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
