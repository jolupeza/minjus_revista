<?php get_header(); ?>

<figure class="Page-figure">
  <img class="img-responsive center-block" src="<?php echo IMAGES; ?>/archivosbg.jpg" alt="" />
  <h2 class="Title Title--white">Publicaciones</h2>
</figure><!-- end Page-figure -->

<section class="Page Page--nopdbt">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php custom_breadcrumbs(); ?>

        <?php if (have_posts()) : ?>
          <?php while (have_posts()) : ?>
            <?php the_post(); ?>
            <?php
              $values = get_post_custom(get_the_id());
              $pdf = isset( $values['mb_pdf'] ) ? esc_attr($values['mb_pdf'][0]) : '';
            ?>
            <section class="LastFile">
              <div class="row">
                <div class="col-md-4">
                  <?php if (has_post_thumbnail()) : ?>
                    <figure>
                      <?php the_post_thumbnail('full', ['class' => 'img-responsive']); ?>
                    </figure>
                  <?php endif; ?>
                </div>
                <div class="col-md-8">
                  <h2 class="Title Title--red Title--bdb Title--bdbGray"><?php the_title(); ?></h2>
                  <?php the_content(); ?>

                  <?php if (!empty($pdf)) : ?>
                    <p class="Page-button">
                      <a href="<?php echo $pdf; ?>" class="Button Button--red" target="_blank" rel="noopener noreferrer">ver revista PDF ></a>
                    </p>
                  <?php endif; ?>
                </div>
              </div><!-- end row -->
            </section><!-- end LastFile -->
          <?php endwhile; ?>
        <?php endif; ?>

        <hr>

        <h3 class="Title Title--red Title--bdb Title--bdbGray">Índice de contenido</h3>

        <article class="Sections">
          <h4><a href="">Sección 1: Derecho Administrativo: Decimoquinto aniversario de la Ley del Procedimiento Administrativo General</a></h4>
          <ul>
            <li>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique.</li>
            <li>2. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>3. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>4. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse minima fugiat eaque.</li>
            <li>5. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit delectus assumenda.</li>
          </ul>
          <h4><a href="">Sección 2: Derecho Administrativo: Decimoquinto aniversario de la Ley del Procedimiento Administrativo General</a></h4>
          <ul>
            <li>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique.</li>
            <li>2. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>3. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>4. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse minima fugiat eaque.</li>
            <li>5. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit delectus assumenda.</li>
          </ul>
          <h4><a href="">Sección 3: Derecho Administrativo: Decimoquinto aniversario de la Ley del Procedimiento Administrativo General</a></h4>
          <ul>
            <li>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique.</li>
            <li>2. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>3. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>4. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse minima fugiat eaque.</li>
            <li>5. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit delectus assumenda.</li>
          </ul>
          <h4><a href="">Sección 4: Derecho Administrativo: Decimoquinto aniversario de la Ley del Procedimiento Administrativo General</a></h4>
          <ul>
            <li>1. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique.</li>
            <li>2. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>3. Lorem ipsum dolor sit amet, consectetur adipisicing elit. </li>
            <li>4. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse minima fugiat eaque.</li>
            <li>5. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit delectus assumenda.</li>
          </ul>
        </article>
      </div><!-- end col-md-12 -->
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end Page -->

<?php get_footer(); ?>
