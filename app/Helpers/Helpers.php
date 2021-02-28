<?php

	function get_name_opd($organisasi_no) {
	    $org = DB::table('organisasi')->where('organisasi_jenis', 'ORG')->where('organisasi_no', $organisasi_no)->first();
	    return (isset($org->organisasi_nama) ? $org->organisasi_nama : '');
	}
