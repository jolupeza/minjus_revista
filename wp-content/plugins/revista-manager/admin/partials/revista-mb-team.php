<?php
/**
 * Displays the user interface for the Revista Manager meta box by type content Team.
 *
 * This is a partial template that is included by the Revista Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-team-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
        $name = isset($values['mb_name']) ?  $values['mb_name'][0]  :  '';
        $study = isset($values['mb_study']) ?  $values['mb_study'][0]  :  '';

        wp_nonce_field('team_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Name -->
    <p class="content-mb">
        <label for="mb_name">Nombre: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>

    <!-- Job -->
    <p class="content-mb">
        <label for="mb_job">Cargo: </label>
        <input type="text" name="mb_job" id="mb_job" value="<?php echo $job; ?>" />
    </p>
    
    <!-- Study -->
    <p class="content-mb">
        <label for="mb_study">Centro de Estudio: </label>
        <input type="text" name="mb_study" id="mb_study" value="<?php echo $study; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
