<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;

	class HomeController extends Controller {

		public function index() {

			return view('home');

		}

		public function shell(Request $request) {

			$db = $_ENV['DB_DATABASE'];
			$user = $_ENV['DB_USERNAME'];
			$pass = $_ENV['DB_PASSWORD'];

			$pathfile   = public_path('/logs/');
			$pathbackup = storage_path('logs/imports/');

			$logfile = $pathfile . 'sped_fiscal.log';
			$logbackup = $pathbackup . 'sped_fiscal_' . date('Y-m-d_His') . '.log';

			// $request -> session() -> forget('import_txt');
			$request -> session() -> put('import_txt', 'log_file');
			$request -> session() -> put('import_txt.log_file', $logfile);

			if ( !is_dir($pathbackup)) {
				shell_exec('mkdir ' . $pathbackup);
			}

			shell_exec('touch ' . $logfile);

			return response( shell_exec("/usr/bin/bash ../app/Console/import.sh $user $pass $db $logfile $logbackup"), 200);

		}

		public function log(Request $request) {

			if ( $request -> session() -> exists('import_txt') && $request -> remove) {
				return $request -> session() -> forget('import_txt');
			}

			$logfile = public_path('/logs/sped_fiscal.sql');
			// $logfile = storage_path('logs/imports/sped_fiscal.log');

			echo json_encode(['log' => (shell_exec('tail ' . $logfile) ?? null)]);

		}

	}

}