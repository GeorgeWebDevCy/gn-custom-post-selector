<?php

class GNWEBDEVCY_CustomGNPostSelector extends ET_Builder_Module {
    public $slug       = 'gnwebdevcy_custom_gn_post_selector';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://www.georgenicolaou.me/plugins/gn-custom-post-selector',
        'author'     => 'George Nicolaou',
        'author_uri' => 'https://www.georgenicolaou.me',
    );

    public function init() {
        $this->name = esc_html__( 'GN Custom Post Selector', 'gnwebdevcy-gn-custom-post-selector' );
    }

    public function get_fields() {
        return array(
            'title' => array(
                'label'           => esc_html__( 'Title', 'gnwebdevcy-gn-custom-post-selector' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Enter the title for the module.', 'gnwebdevcy-gn-custom-post-selector' ),
                'toggle_slug'     => 'main_content',
            ),
            'post_type' => array(
                'label'           => esc_html__( 'Post Type', 'gnwebdevcy-gn-custom-post-selector' ),
                'type'            => 'select',
                'options'         => $this->get_post_types(),
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Select the post type.', 'gnwebdevcy-gn-custom-post-selector' ),
                'toggle_slug'     => 'main_content',
            ),
            'posts' => array(
                'label'           => esc_html__( 'Posts', 'gnwebdevcy-gn-custom-post-selector' ),
                'type'            => 'multiple_checkboxes',
                'options'         => array(), // This will be populated dynamically based on selected post type
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Select posts to display.', 'gnwebdevcy-gn-custom-post-selector' ),
                'toggle_slug'     => 'main_content',
            ),
        );
    }

    public function get_post_types() {
        $post_types = get_post_types(array('public' => true), 'objects');
        $options = array();

        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }

        return $options;
    }

    public function render($attrs, $content = null, $render_slug) {
        $title = $this->props['title'];
        $post_type = $this->props['post_type'];
        $posts = explode('|', $this->props['posts']);

        // Fetch the posts
        $selected_posts = get_posts(array(
            'post_type' => $post_type,
            'post__in' => $posts,
        ));

        $output = '<div class="custom-gn-post-selector">';
        if ($title) {
            $output .= sprintf('<h2>%1$s</h2>', esc_html($title));
        }

        if (!empty($selected_posts)) {
            $output .= '<ul>';
            foreach ($selected_posts as $post) {
                $output .= sprintf('<li><a href="%1$s">%2$s</a></li>', get_permalink($post->ID), esc_html($post->post_title));
            }
            $output .= '</ul>';
        }

        $output .= '</div>';

        return $output;
    }
}

new GNWEBDEVCY_CustomGNPostSelector;

// Enqueue script to handle dynamic updates
function gnwebdevcy_enqueue_scripts() {
    wp_enqueue_script(
        'gnwebdevcy-custom-gn-post-selector',
        plugin_dir_url(__FILE__) . 'includes/modules/CustomGNPostSelector/CustomGNPostSelector.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script('gnwebdevcy-custom-gn-post-selector', 'gnwebdevcy_data', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gnwebdevcy_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'gnwebdevcy_enqueue_scripts');

// Handle AJAX request to get posts based on post type
function gnwebdevcy_get_posts_by_type() {
    check_ajax_referer('gnwebdevcy_nonce', 'nonce');

    $post_type = sanitize_text_field($_POST['post_type']);
    $posts = get_posts(array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
    ));

    $options = array();
    foreach ($posts as $post) {
        $options[$post->ID] = $post->post_title;
    }

    wp_send_json_success($options);
}
add_action('wp_ajax_gnwebdevcy_get_posts_by_type', 'gnwebdevcy_get_posts_by_type');
add_action('wp_ajax_nopriv_gnwebdevcy_get_posts_by_type', 'gnwebdevcy_get_posts_by_type');