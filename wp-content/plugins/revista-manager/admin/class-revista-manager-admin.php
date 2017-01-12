<?php

/**
 * The Revista Manager Admin defines all functionality for the dashboard
 * of the plugin.
 */

/**
 * The Revista Manager Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Revista_Manager_Admin
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    private $allowed;

    private $domain;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
        $this->allowed = array(
            'h2' => array(
              'style' => array(),
            ),
            'h3' => array(
              'style' => array(),
            ),
            'h4' => array(
              'style' => array(),
            ),
            'h5' => array(
              'style' => array(),
            ),
            'p' => array(
              'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => array(),
        );

        $this->domain = 'revista-framework';
//        add_action('wp_ajax_generate_pdf', array(&$this, 'generate_pdf'));
//        add_action('wp_ajax_download_cv', array(&$this, 'download_cv'));
    }

    /**
     * Enqueues the style sheet responsible for styling the contents of this
     * meta box.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'revista-manager-admin',
            plugin_dir_url(__FILE__).'css/revista-manager-admin.css',
            array(),
            $this->version,
            false
        );
    }

    /**
     * Enqueues the scripts responsible for functionality.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'revista-manager-admin',
            plugin_dir_url(__FILE__).'js/revista-manager-admin.js',
            array('jquery'),
            $this->version,
            true
        );
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type team.
     */
    public function cd_mb_team_add()
    {
        add_meta_box(
            'mb-team-id', 'Configuraciones', array($this, 'render_mb_team'), 'team', 'normal', 'core'
        );
    }

    public function cd_mb_team_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'team_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Job
        if( isset( $_POST['mb_job'] ) && !empty($_POST['mb_job']) ) {
            update_post_meta( $post_id, 'mb_job', esc_attr( $_POST['mb_job'] ) );
        } else {
            delete_post_meta($post_id, 'mb_job');
        }
        
        // Name
        if (isset($_POST['mb_name']) && !empty($_POST['mb_name'])) {
            update_post_meta($post_id, 'mb_name', esc_attr($_POST['mb_name']));
        } else {
            delete_post_meta($post_id, 'mb_name');
        }
        
        // Study
        if (isset($_POST['mb_study']) && !empty($_POST['mb_study'])) {
            update_post_meta($post_id, 'mb_study', esc_attr($_POST['mb_study']));
        } else {
            delete_post_meta($post_id, 'mb_study');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_team()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/revista-mb-team.php';
    }
    
    public function custom_columns_team($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'job' => __('Cargo'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_team($column)
    {
        global $post;

        // Setup some vars
        $edit_link = get_edit_post_link($post->ID);
        $post_type_object = get_post_type_object($post->post_type);
        $can_edit_post = current_user_can('edit_post', $post->ID);
        $values = get_post_custom($post->ID);

        switch ($column) {
            case 'name':
                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';

                // Display the name
                if (!empty($name)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $name . '</a>';
                    } else {
                        echo "$name";
                    }
                }

                // Add admin actions
                $actions = array();
                if ($can_edit_post && 'trash' != $post->post_status) {
                    $actions['edit'] = '<a href="' . get_edit_post_link($post->ID, true) . '" title="' . esc_attr(__( 'Editar este elemento')) . '">' . __('Editar') . '</a>';
                }

                if (current_user_can('delete_post', $post->ID)) {
                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr(__('Restaurar este elemento desde la papelera')) . "' href='" . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=untrash', $post->ID)), 'untrash-post_' . $post->ID) . "'>" . __('Restaurar') . "</a>";
                    } elseif(EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Mover este elemento a la papelera')) . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Papelera') . "</a>";
                    }

                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Borrar este elemento permanentemente')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Borrar permanentemente') . "</a>";
                    }
                }

                $html = '<div class="row-actions">';
                if (isset($actions['edit'])) {
                    $html .= '<span class="edit">' . $actions['edit'] . ' | </span>';
                }
                if (isset($actions['trash'])) {
                    $html .= '<span class="trash">' . $actions['trash'] . '</span>';
                }
                if (isset($actions['untrash'])) {
                    $html .= '<span class="untrash">' . $actions['untrash'] . ' | </span>';
                }
                if (isset($actions['delete'])) {
                    $html .= '<span class="delete">' . $actions['delete'] . '</span>';
                }
                $html .= '</div>';

                echo $html;
                break;
            case 'job':
                $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
                echo $job;
                break;
        }
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type page.
     */
    public function cd_mb_pages_add()
    {
        add_meta_box(
            'mb-pages-id',
            'Otras Configuraciones',
            array($this, 'render_mb_pages'),
            'page',
            'normal',
            'core'
        );
    }

    public function cd_mb_pages_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'pages_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Display home
//        $display_home = isset($_POST['mb_display_home']) && $_POST['mb_display_home'] ? 'on' : 'off';
//        update_post_meta($post_id, 'mb_display_home', $display_home);
        
        // Image Responsive
//        if (isset($_POST['mb_responsive']) && !empty($_POST['mb_responsive'])) {
//            update_post_meta($post_id, 'mb_responsive', esc_attr($_POST['mb_responsive']));
//        } else {
//            delete_post_meta($post_id, 'mb_responsive');
//        }
        
        // Files
        if (isset($_POST['mb_files']) && count($_POST['mb_files'])) {
            $files = $_POST['mb_files'];
            $files_title = $_POST['mb_files_title'];

            $save = false;
            $newArrFiles = array();
            $newArrTitle = array();
            $i = 0;

            foreach ($files as $file) {
                if (!empty($file)) {
                    $save = true;
                    $newArrFiles[] = $file;
                    $newArrTitle[] = $files_title[$i];
                }

                ++$i;
            }

            if ($save) {
                update_post_meta($post_id, 'mb_files', $newArrFiles);
                update_post_meta($post_id, 'mb_files_title', $newArrTitle);
            } else {
                delete_post_meta($post_id, 'mb_files');
                delete_post_meta($post_id, 'mb_files_title');
            }
        }
        
        // How
//        if (isset($_POST['mb_how']) && !empty($_POST['mb_how'])) {
//            update_post_meta($post_id, 'mb_how', wp_kses($_POST['mb_how'], $this->allowed));
//        } else {
//            delete_post_meta($post_id, 'mb_how');
//        }

        
        // Gallery
//        if (isset($_POST['mb_gallery']) && count($_POST['mb_gallery'])) {
//            $images = $_POST['mb_gallery'];
//
//            $save = false;
//            $newArrImages = array();
//            $i = 0;
//
//            foreach ($images as $image) {
//                if (!empty($image)) {
//                    $save = true;
//                    $newArrImages[] = $image;
//                }
//
//                ++$i;
//            }
//
//            if ($save) {
//                update_post_meta($post_id, 'mb_gallery', $newArrImages);
//            } else {
//                delete_post_meta($post_id, 'mb_gallery');
//            }
//        } else {
//            delete_post_meta($post_id, 'mb_gallery');
//        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_pages()
    {
        require_once plugin_dir_path(__FILE__).'partials/revista-mb-pages.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type publications.
     */
    public function cd_mb_publications_add()
    {
        add_meta_box(
            'mb-publications-id',
            'Otras Configuraciones',
            array($this, 'render_mb_publications'),
            'publications',
            'normal',
            'core'
        );
    }

    public function cd_mb_publications_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'publications_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // PDF
        if (isset($_POST['mb_pdf']) && !empty($_POST['mb_pdf'])) {
            update_post_meta($post_id, 'mb_pdf', esc_attr($_POST['mb_pdf']));
        } else {
            delete_post_meta($post_id, 'mb_pdf');
        }
        
        // Image
        if (isset($_POST['mb_image']) && !empty($_POST['mb_image'])) {
            update_post_meta($post_id, 'mb_image', esc_attr($_POST['mb_image']));
        } else {
            delete_post_meta($post_id, 'mb_image');
        }
        
        // Responsive
        if (isset($_POST['mb_responsive']) && !empty($_POST['mb_responsive'])) {
            update_post_meta($post_id, 'mb_responsive', esc_attr($_POST['mb_responsive']));
        } else {
            delete_post_meta($post_id, 'mb_responsive');
        }
        
        // Text
        if (isset($_POST['mb_text']) && !empty($_POST['mb_text'])) {
            update_post_meta($post_id, 'mb_text', wp_kses($_POST['mb_text'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_text');
        }
        
        // Index
        if (isset($_POST['mb_index']) && !empty($_POST['mb_index'])) {
            update_post_meta($post_id, 'mb_index', wp_kses($_POST['mb_index'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_index');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_publications()
    {
        require_once plugin_dir_path(__FILE__).'partials/revista-mb-publications.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type post.
     */
    public function cd_mb_posts_add()
    {
        add_meta_box(
            'mb-posts-id',
            'Otras Configuraciones',
            array($this, 'render_mb_posts'),
            'post',
            'normal',
            'core'
        );
    }

    public function cd_mb_posts_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'posts_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // PDF
        if (isset($_POST['mb_pdf']) && !empty($_POST['mb_pdf'])) {
            update_post_meta($post_id, 'mb_pdf', esc_attr($_POST['mb_pdf']));
        } else {
            delete_post_meta($post_id, 'mb_pdf');
        }
        
        // Publication
        if( isset( $_POST['mb_publication'] ) && !empty($_POST['mb_publication']) ) {
            update_post_meta( $post_id, 'mb_publication', esc_attr( $_POST['mb_publication'] ) );
        } else {
            delete_post_meta($post_id, 'mb_publication');
        }
        
        // Author
        if( isset( $_POST['mb_author'] ) && !empty($_POST['mb_author']) ) {
            update_post_meta( $post_id, 'mb_author', esc_attr( $_POST['mb_author'] ) );
        } else {
            delete_post_meta($post_id, 'mb_author');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_posts()
    {
        require_once plugin_dir_path(__FILE__).'partials/revista-mb-posts.php';
    }
    
    /**
     * Add custom content type slides.
     */
    public function add_post_type()
    {
        $labels = array(
            'name'               => __('Equipo Editorial', $this->domain),
            'singular_name'      => __('Equipo Editorial', $this->domain),
            'add_new'            => __('Nuevo Miembro', $this->domain),
            'add_new_item'       => __('Agregar nuevo Equipo Editorial', $this->domain),
            'edit_item'          => __('Editar Equipo Editorial', $this->domain),
            'new_item'           => __('Nuevo Equipo Editorial', $this->domain),
            'view_item'          => __('Ver Equipo Editorial', $this->domain),
            'search_items'       => __('Buscar Equipo Editorial', $this->domain),
            'not_found'          => __('Miembro no encontrado', $this->domain),
            'not_found_in_trash' => __('Miembro no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todo el Equipo Editorial', $this->domain),
  //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
  //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
  //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
  //          'featured_image' - Default is Featured Image.
  //          'set_featured_image' - Default is Set featured image.
  //          'remove_featured_image' - Default is Remove featured image.
  //          'use_featured_image' - Default is Use as featured image.
  //          'menu_name' - Default is the same as `name`.
  //          'filter_items_list' - String for the table views hidden heading.
  //          'items_list_navigation' - String for the table pagination hidden heading.
  //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Equipo Editorial',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-groups',
            // 'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('team', $args);
        
        $labels = array(
            'name'               => __('Archivos', $this->domain),
            'singular_name'      => __('Archivo', $this->domain),
            'add_new'            => __('Nuevo Archivo', $this->domain),
            'add_new_item'       => __('Agregar nuevo Archivo', $this->domain),
            'edit_item'          => __('Editar Archivo', $this->domain),
            'new_item'           => __('Nuevo Archivo', $this->domain),
            'view_item'          => __('Ver Archivo', $this->domain),
            'search_items'       => __('Buscar Archivo', $this->domain),
            'not_found'          => __('Archivo no encontrado', $this->domain),
            'not_found_in_trash' => __('Archivo no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Archivos', $this->domain),
  //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
  //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
  //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
  //          'featured_image' - Default is Featured Image.
  //          'set_featured_image' - Default is Set featured image.
  //          'remove_featured_image' - Default is Remove featured image.
  //          'use_featured_image' - Default is Use as featured image.
  //          'menu_name' - Default is the same as `name`.
  //          'filter_items_list' - String for the table views hidden heading.
  //          'items_list_navigation' - String for the table pagination hidden heading.
  //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Archivos',
            'public' => true,
            // 'exclude_from_search' => false,
            // 'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-book',
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            'has_archive' => true,
            'rewrite'     => array('slug' => 'archivos')
        );
        register_post_type('publications', $args);
        
//        flush_rewrite_rules();
    }

    public function unregister_post_type()
    {
        global $wp_post_types;

        if (isset($wp_post_types[ 'videos' ])) {
            unset($wp_post_types[ 'videos' ]);

            return true;
        }

        return false;
    }

    /**
     * Set custom post type publications from search results.
     */
    public function set_publications_wp_search($query)
    {
        if ($query->is_search() && $query->is_main_query()) {
            $query->set('post_type', 'publications');
        }
    }
    
    /**
     * Add custom taxonomies category to post type contacts.
     */
    public function add_taxonomies_contacts()
    {
        $labels = array(
            'name' => _x('Asuntos', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Asunto', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Asunto', THEMEDOMAIN),
            'popular_items' => __('Asuntos Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Asuntos', THEMEDOMAIN),
            'parent_item' => __('Asunto Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Asunto Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Asunto', THEMEDOMAIN),
            'update_item' => __('Actualizar Asunto', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Asunto', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Asunto', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Asunto', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Asunto', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('subjects', 'contacts', $args);
    }
    
    /**
     * Add custom taxonomies category to post type directories.
     */
    public function add_taxonomies_directories()
    {
        $labels = array(
            'name' => _x('Secciones', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Sección', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Sección', THEMEDOMAIN),
            'popular_items' => __('Secciones Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Secciones', THEMEDOMAIN),
            'parent_item' => __('Sección Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Sección Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Sección', THEMEDOMAIN),
            'update_item' => __('Actualizar Sección', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Sección', THEMEDOMAIN),
            'new_item_name' => __('Nueva Sección', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Sección', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Secciones', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('sections', 'directories', $args);
    }
    
    /**
     * Add custom taxonomies category to post type authorities.
     */
    public function add_taxonomies_authorities()
    {
        $labels = array(
            'name' => _x('Roles', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Rol', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Rol', THEMEDOMAIN),
            'popular_items' => __('Roles Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Roles', THEMEDOMAIN),
            'parent_item' => __('Rol Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Rol Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Rol', THEMEDOMAIN),
            'update_item' => __('Actualizar Rol', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Rol', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Rol', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Rol', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Roles', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('roles', 'authorities', $args);
    }
    
    /**
     * Add custom taxonomies category to post type pages.
     */
    public function add_taxonomies_pages()
    {
        $labels = array(
            'name' => _x('Servicios', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Servicio', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Servicio', THEMEDOMAIN),
            'popular_items' => __('Servicios Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Servicios', THEMEDOMAIN),
            'parent_item' => __('Servicio Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Servicio Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Servicio', THEMEDOMAIN),
            'update_item' => __('Actualizar Servicio', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Servicio', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Servicio', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Servicio', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Servicios', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('services', 'page', $args);
    }
    
    /**
     * Add custom taxonomies category to post type documents.
     */
    public function add_taxonomies_deliveries()
    {
        $labels = array(
            'name' => _x('Formas de Entrega', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Forma de Entrega', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Forma de Entrega', THEMEDOMAIN),
            'popular_items' => __('Formas de Entrega Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Formas de Entrega', THEMEDOMAIN),
            'parent_item' => __('Forma de Entrega Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Forma de Entrega Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Forma de Entrega', THEMEDOMAIN),
            'update_item' => __('Actualizar Forma de Entrega', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Forma de Entrega', THEMEDOMAIN),
            'new_item_name' => __('Nueva Forma de Entrega', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Forma de Entrega', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Formas de Entrega', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('deliveries', 'informations', $args);
    }
}
