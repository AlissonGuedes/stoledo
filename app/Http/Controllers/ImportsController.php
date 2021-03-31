<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;
	use Illuminate\Support\Facades\Session;

	use App\Models\ImportModel;

	class ImportsController extends Controller {

		public function __construct() {

			$this -> import_model = new ImportModel();

		}

		/**
		 * Show the system home page
		 */
		public function index() {

			// Session::forget('import_txt');
			return view('imports.index');

		}

		private $logfile;

		/** Importação do arquivo SPED Fiscal */
		public function import(Request $request){

			$this -> logfile = $request -> arquivo;

			if ( is_null($this -> logfile) ) {
				$filetype = DS;
			} else {
				$filetype = DS . $this -> logfile . DS;
			}

			$request -> validate([
				'arquivo' => [ 'required' ],
				'files' => [ 'required' ]
			]);

			foreach ( $request -> file('files') as $file) {

				switch( limpa_string($file -> getClientOriginalExtension()) ) {

					case 'xml' :
						$this -> import_model -> import_nfe($file);
					break;

					case 'txt' :

						$name = explode('.', $file -> getClientOriginalName());
						$extension = strtolower($file -> getClientOriginalExtension());
						$path = 'public/files/' . $extension . $filetype;

						$filename  = limpa_string($name[count($name) - 2]);
						$filename  = $filename . '.' . $extension;

						if ( $file -> storeAs($path, $filename) ) {
							$success = true;
						} else {
							$success = false;
						}

					break;

					default:

						$success = false;
						$status = 'error';
						$message = 'Você inseriu arquivos válidos. Utilize apenas TXT ou XML.';
						// Session::forget('import_txt');

					break;

				}

			}

			if ( isset($success) && $success === TRUE) {

				$this -> import_model -> readFiles( $request -> arquivo);

				$status = 'success';
				$message = 'Importação finalizada com sucesso!';

			}

			// Remover a sessão para parar de exibir o Log.
			Session::forget('import_txt');

			return json_encode(['status' => $status, 'message' => $message]);

		}

		public function log(Request $request) {

			if ( ! Session::exists('import_txt') && $request -> arquivo ) {

				$file = public_path('/logs/') . $request -> arquivo;
				Session::put('import_txt', 'log_file');
				Session::put('import_txt.log_file', $file);

			}

			echo $this -> import_model -> log($request -> remove);

		}

	}

}