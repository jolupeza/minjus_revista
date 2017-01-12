<?php $options = get_option('revista_custom_settings'); ?>

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
