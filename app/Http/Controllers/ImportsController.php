<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\ImportModel;

	class ImportsController extends Controller {

		public function __construct() {

			$this -> import_model = new ImportModel();

		}

		/**
		 * Show the system home page
		 */
		public function index() {

			return view('imports.index');

		}

		/**
		 * Show the system home page
		 */
		public function nfe() {

			$dados['tipo_arquivo'] = 'notasfiscais';
			return view('imports.index', $dados);

		}

		/**
		 * Show the system home page
		 */
		public function sped() {

			$dados['tipo_arquivo'] = 'spedfiscal';
			return view('imports.index', $dados);

		}

		/** Importação do arquivo SPED Fiscal */
		public function import(Request $request){

			foreach ( $request -> file('files') as $file) {

				switch( limpa_string($file -> getClientOriginalExtension()) ) {

					case 'xml' :
						$this -> import_model -> import_nfe($file);
					break;

					case 'txt' :

						$this -> import_model -> import_sped($file, $request -> arquivo);

					break;

					default:
						return json_encode(['status' => 'error', 'message' => 'Você inseriu arquivos válidos. Utilize apenas TXT ou XML.' ]);
					break;

				}

			}

			return json_encode(['status' => 'success', 'message' => 'Importação finalizada com sucesso!']);

		}

	}

}