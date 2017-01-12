<?php
/**
 * Displays the user interface for the Revista Manager meta box by type content Post.
 *
 * This is a partial template that is included by the Revista Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-posts-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        
        $pdf = isset( $values['mb_pdf'] ) ? esc_attr($values['mb_pdf'][0]) : '';
        $author = isset($values['mb_author']) ? esc_attr($values['mb_author'][0]) : '';
        $publication = isset($values['mb_publication']) ? esc_attr($values['mb_publication'][0]) : '';
        
        $args = array(
            'post_type' => 'publications',
            'posts_per_page' => -1,
        );
        $publications = get_posts($args);
        
        wp_nonce_field('posts_meta_box_nonce', 'meta_box_nonce');
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
    
    <!-- Video-->
    <p class="content-mb">
        <label for="mb_author">Autor: </label>
        <input type="text" name="mb_author" id="mb_author" value="<?php echo $author; ?>" />
    </p>
    
    <p class="content-mb">
        <label for="mb_publication">Seleccione Publicación / Revista</label>
        <select name="mb_publication" id="mb_publication">
            <option value="">-- Seleccione Publicación / Revista</option>
            <?php foreach ($publications as $pub) : ?>
                <option value="<?php echo $pub->ID; ?>" <?php selected($publication, $pub->ID); ?>><?php echo $pub->post_title; ?></option>
            <?php endforeach ?>
        </select>
    </p>
</div><!-- #single-post-meta-manager -->
