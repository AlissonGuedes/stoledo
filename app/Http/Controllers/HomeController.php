<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;

	class HomeController extends Controller {

		public function index() {

			return view('home');

		}

		public function shell(Request $request) {

			$db = $_ENV['DB_DATABASE'];
			$pass = '20180808';

			$file = 'sped_fiscal.log';
			$path = storage_path('logs/imports/');

			// if ( ! $request -> session() -> exists('import_txt')) {

				// $request -> session() -> forget('import_txt');
				$request -> session() -> put('import_txt', 'log_file');
				$request -> session() -> put('import_txt.log_file', $path.$file);

				if ( !is_dir($path)) {
					shell_exec('mkdir ' . $path);
				}

				shell_exec ('touch ' . $file);

				return response(shell_exec('/usr/bin/bash ../app/Console/import.sh ' . $pass . ' ' . $db . ' ' . $path . $file . ' && mv ' .  $path . $file . ' ' . date('Y-m-d_His') . '.log'), 200);

			// } else {
			// 	return $this -> log($request);
			// }

		}

		private function exec($path, $file) {

			if ( !is_dir($path)) {
				shell_exec('mkdir ' . $path);
			}
			echo '=======' . $file;

			shell_exec ('touch ' . $file);

			response(shell_exec('/usr/bin/bash ../app/Console/import.sh ' . $path . $file), 200);

		}

		public function log(Request $request) {

			if ( $request -> session() -> exists('import_txt') && $request -> remove) {
				return $request -> session() -> forget('import_txt');
			}

			echo json_encode(['log' => (shell_exec('tail ' . storage_path('logs/imports/sped_fiscal.log')) ?? null)]);

		}

	}

}