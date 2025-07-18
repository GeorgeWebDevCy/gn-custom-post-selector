<?php

class GNWEBDEVCY_GnCustomPostSelector extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'gnwebdevcy-gn-custom-post-selector';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'gn-custom-post-selector';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
       public $version = '1.0.9';

	/**
	 * GNWEBDEVCY_GnCustomPostSelector constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'gn-custom-post-selector', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );
	}
}

new GNWEBDEVCY_GnCustomPostSelector;
