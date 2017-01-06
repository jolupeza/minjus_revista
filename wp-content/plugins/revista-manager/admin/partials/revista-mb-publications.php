<?php
/**
 * Displays the user interface for the Revista Manager meta box by type content Publications.
 *
 * This is a partial template that is included by the Revista Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-publications-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        
        $pdf = isset( $values['mb_pdf'] ) ? esc_attr($values['mb_pdf'][0]) : '';
        $image = isset( $values['mb_image'] ) ? esc_attr($values['mb_image'][0]) : '';
        $text = (isset($values['mb_text'])) ? $values['mb_text'][0] : '';
        
        wp_nonce_field('publications_meta_box_nonce', 'meta_box_nonce');
    ?>
       
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Archivo PDF</legend>

        <div class="container-upload-file GroupForm-wrapperImage">
            <p class="btn-add-file">
                <a title="Agregar pdf" href="javascript:;" class="set-file button button-primary">Añadir PDF</a>
            </p>

            <div class="hidden media-container">
                <p>
                    <span class="dashicons dashicons-media-default"></span>
                    <span class="name"><?php echo $pdf; ?></span>
                </p>
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Qutar pdf" href="javascript:;" class="remove-file button button-secondary">Quitar PDF</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_pdf" value="<?php echo $pdf; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->
    </fieldset><!-- end GroupFrm -->
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imagen Slider</legend>

        <div class="container-upload-file GroupForm-wrapperImage">
            <p class="btn-add-file">
                <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir</a>
            </p>

            <div class="hidden media-container">
                <img src="<?php echo $image; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Qutar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_image" value="<?php echo $image; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->
    </fieldset><!-- end GroupFrm -->
    
    <fieldset>
        <legend>Texto de Slider</legend>
        <p>
            <label for="mb_text"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_text',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($text, 'mb_text', $settings);
            ?>
        </p>
    </fieldset>
</div><!-- #single-post-meta-manager -->
