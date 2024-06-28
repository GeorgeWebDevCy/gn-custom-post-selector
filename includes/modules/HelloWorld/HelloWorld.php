<?php

class GNWEBDEVCY_HelloWorld extends ET_Builder_Module {

	public $slug       = 'gnwebdevcy_hello_world';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => 'https://www.georgenicolaou.me/plugins/gn-custom-post-selector',
		'author'     => 'George Nicolaou',
		'author_uri' => 'httgps://www.georgenicolaou.me',
	);

	public function init() {
		$this->name = esc_html__( 'Hello World', 'gnwebdevcy-gn-custom-post-selector' );
	}

	public function get_fields() {
		return array(
			'content' => array(
				'label'           => esc_html__( 'Content', 'gnwebdevcy-gn-custom-post-selector' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Content entered here will appear inside the module.', 'gnwebdevcy-gn-custom-post-selector' ),
				'toggle_slug'     => 'main_content',
			),
		);
	}

	public function render( $attrs, $content = null, $render_slug ) {
		return sprintf( '<h1>%1$s</h1>', $this->props['content'] );
	}
}

new GNWEBDEVCY_HelloWorld;
