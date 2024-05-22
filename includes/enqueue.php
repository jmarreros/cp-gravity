<?php

namespace dcms\cpgravity\includes;

class Enqueue {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
	}

	// Register scripts frontend
	public function register_scripts(): void {
		wp_register_style( 'cp-gravity-style', DCMS_CPGRAVITY_URL . 'assets/style.css', [], DCMS_CPGRAVITY_VERSION );
		wp_register_script( 'cp-gravity-script', DCMS_CPGRAVITY_URL . 'assets/script.js', [ 'jquery' ], DCMS_CPGRAVITY_VERSION, true );

		wp_localize_script( 'cp-gravity-script',
			'cpgravity_var',
			[
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'nonce'           => wp_create_nonce( 'ajax-cp-nonce' ),
			] );

		wp_enqueue_style( 'cp-gravity-style' );
		wp_enqueue_script( 'cp-gravity-script' );
	}
}