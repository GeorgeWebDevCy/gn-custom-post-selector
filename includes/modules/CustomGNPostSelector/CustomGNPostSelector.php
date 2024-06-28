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
				'options'         => $this->get_posts_options(),
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

	public function get_posts_options($post_type = 'post') {
		$posts = get_posts(array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
		));

		$options = array();

		foreach ($posts as $post) {
			$options[$post->ID] = $post->post_title;
		}

		return $options;
	}

	public function render( $attrs, $content = null, $render_slug ) {
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