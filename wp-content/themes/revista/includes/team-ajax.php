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
