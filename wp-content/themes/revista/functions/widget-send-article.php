<?php
/***********************************************************************************************/
/* Widget that displays a list with social icons */
/***********************************************************************************************/

  class Revista_Send_Article_Widget extends WP_Widget
  {
    public function __construct()
    {
      parent::__construct(
        'revista_send_article_w',
        'Custom Widget: Enviar Artículo',
        array('description' => __('Formulario para envio de artículo por correo electrónico', THEMEDOMAIN))
      );
    }

    public function form($instance)
    {
      $defaults = array(
        'title' => __('Enviar artículo', THEMEDOMAIN),
        'description' => __('Ingresa tu correo para enviar el artículo.', THEMEDOMAIN)
      );

      $instance = wp_parse_args((array) $instance, $defaults);

      ?>
      <!-- The Title -->
      <p>
        <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Título:', THEMEDOMAIN); ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
      </p>

      <!-- The Description -->
      <p>
        <label for="<?php echo $this->get_field_id('description') ?>"><?php _e('Descripción:', THEMEDOMAIN); ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" value="<?php echo $instance['description']; ?>" />
      </p>

      <?php
    }

    public function update($new_instance, $old_instance)
    {
      $instance = $old_instance;

      // The Title
      $instance['title'] = strip_tags($new_instance['title']);

      // The Description
      $instance['description'] = $new_instance['description'];

      return $instance;
    }

    public function widget($args, $instance) {
      extract($args);

      // Get the title and prepare it for display
      $title = apply_filters('widget_title', $instance['title']);

      // Get the description
      $description = $instance['description'];

      echo $before_widget;

      if ($title) {
        echo $before_title . $title . $after_title;
      }

      if ($description) {
        echo '<p>' . $description . '</p>';
      }

      ?>

      <form action="" method="POST" class="Form" id="js-form-send-article">
        <div class="Page-loader Page-loader--50 text-center hidden" id="js-form-send-article-loader">
          <span class="animated rotateIn glyphicon glyphicon-refresh text--white" aria-hidden="true"></span>
        </div>
        <!-- <p class="text-center" ></p> -->
        <div class="alert text-center hidden" id="js-form-send-article-msg" role="alert"></div>

        <div class="form-group">
          <label for="email" class="sr-only">Ingresa tu correo</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Ingresa tu correo" required />
        </div>

        <?php global $post; ?>
        <input type="hidden" name="post" value="<?php echo $post->ID; ?>" />
        <p class="text-center">
          <button type="submit" class="Button Button--red">enviar</button>
        </p>
      </form><!-- end Form -->

      <?php

      echo $after_widget;
    }
  }

  register_widget('Revista_Send_Article_Widget');
