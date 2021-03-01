<?php


namespace App\Http\Controllers {

class ApiController extends Controller {

		public function index() {

			$db = $_ENV['DB_DATABASE'];
			$pass = '20180808';

			$file = exec('/bin/bash ' . app_path() . '/Console/read.sh ' . $pass . ' ' . $db);
			echo $file;

		}

	}

}
