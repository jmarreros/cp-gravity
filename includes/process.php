<?php

namespace dcms\cpgravity\includes;

class Process {

	public function __construct() {
		add_action( 'wp_ajax_dcms_get_data_cp', [ $this, 'dcms_get_data_cp' ] );
		add_action( 'wp_ajax_nopriv_dcms_get_data_cp', [ $this, 'dcms_get_data_cp' ] );
	}

	public function dcms_get_data_cp(): void {
		$nonce = $_POST['nonce'] ?? '';
		if ( ! wp_verify_nonce( $nonce, 'ajax-cp-nonce' ) ) {
			wp_send_json_error( 'Invalid nonce' );
		}

		$cp = $_POST['code'] ?? '';

		$db = new Database();
		$data = $db->get_data_from_code( $cp );

		wp_send_json_success( $data );
	}
}