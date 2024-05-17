<?php

namespace dcms\cpgravity\includes;

use wpdb;

class Database {

	private wpdb $wpdb;
	private string $data_cp;
	private string $data_municipios;
	private string $data_ccaa_provincias;

	public function __construct() {
		global $wpdb;

		$this->wpdb                 = $wpdb;
		$this->data_cp              = 'data_cp';
		$this->data_municipios      = 'data_municipios';
		$this->data_ccaa_provincias = 'data_ccaa_provincias';
	}


	public function get_data_from_code($code):array{
		$sql = "SELECT 
				cp.cod_post, cp.cpro, cp.cmun, cp.nombre ciudad, 
				m.nombre municipio, p.provincia provincia, p.comunidad_autonoma ca 
				FROM $this->data_cp cp
				INNER JOIN $this->data_municipios m ON cp.cmun = m.cmun AND cp.cpro = m.cpro
				INNER JOIN $this->data_ccaa_provincias p ON cp.cpro = p.cpro
				WHERE cp.cod_post = $code";

		return $this->wpdb->get_results($sql, ARRAY_A);
	}

}

