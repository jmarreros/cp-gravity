<?php

namespace dcms\cpgravity\includes;

class Gravity {
	public function __construct() {
		add_action( 'gform_loaded', [ $this, 'load_scripts' ] );
	}

	// Load scripts frontend
	public function load_scripts(): void {
		wp_enqueue_style( 'cp-gravity-style' );
		wp_enqueue_script( 'cp-gravity-script' );
	}
}