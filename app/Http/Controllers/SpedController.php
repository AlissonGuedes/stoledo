<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\SpedfiscalModel;
	use App\Models\FornecedorModel;
	use App\Models\NFeModel;

	class SpedController extends Controller {

		public function __construct() 	{
			$this -> nfe_model = new NFeModel();
			$this -> spedfiscal_model = new SpedfiscalModel();
			$this -> fornecedor_model = new FornecedorModel();
		}

		public function index(Request $request) {

			if ( $request -> ajax() ) {

				$dados['tipo'] = request() -> route() -> parameters['tipo'];
				$dados['paginate'] = $this -> spedfiscal_model -> getSpedfiscal();
				return view('spedfiscal.list.spedfiscal', $dados);

			}

			return view('spedfiscal.spedfiscal');

		}

		/**
		 * Onde
		 * Tipo = 0 : Notas não escrituradas
		 * Tipo = 1 : Notas Escrituradas
		 */
		public function notas_fiscais(Request $request, $tipo, $cnpj, $data_inicial, $data_final) {

			if ( $request -> ajax() ) {

				$dados['paginate'] = $this -> spedfiscal_model -> getNotas($tipo, $cnpj, $data_inicial, $data_final);

				return view('spedfiscal.list.notas_fiscais', $dados);

			}

			$dados['fornecedor'] = $this -> fornecedor_model -> getFornecedor($cnpj);
			$dados['row'] = [
				'tipo' => $tipo,
				'cnpj' => $cnpj,
				'data_inicio' => $data_inicial,
				'data_fim' => $data_final
			];
			return view('spedfiscal.notas_fiscais', $dados);

		}

		public function detalhes_nfe(Request $request, $emitente, $chave_nfe) {

			$dados['pdf'] = '';
			$dados['spedfiscal'] = $this -> spedfiscal_model -> getSpedfiscal($emitente);
			$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
			return view('spedfiscal.nfe', $dados);

		}

		public function export(Request $request) {

			$database = $_ENV['DB_DATABASE'];
			$username = $_ENV['DB_USERNAME'];
			$password = $_ENV['DB_PASSWORD'];

			$datetime = strtotime(date('Y-m-d His'));
			$tipo = $request -> tipo;
			$cnpj = $request -> cnpj;
			$data_inicio = convert_to_date($request -> data_inicio, 'Y-m-d');
			$data_fim = convert_to_date($request -> data_fim, 'Y-m-d');

			$diretorio = 'app/public/files/exports/spedfiscal/';
			$filename = $diretorio . $cnpj . '-' . $data_inicio . '-' . $data_fim . '-' . $datetime . '.csv';

			if ( ! is_dir(storage_path($diretorio)) )
				mkdir(storage_path($diretorio), 0755, true);

			if ( ! file_exists(storage_path($filename)) )
				touch(storage_path($filename));

			$filename = '../storage/' . $filename;

			echo shell_exec("/usr/bin/bash ../app/Console/compacta_arquivos.sh $database $username $password $tipo $cnpj $data_inicio $data_fim $filename");

			header('Content-Type: application/octet-stream');
			header('Content-Size: ' . filesize($filename));
			header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
			header('Content-Length: ' . filesize($filename));
			header('Content-Transfer-Encoding: binary');
			header('Cache-Control: private, no-transform, no-store, must-revalidate');

			return readfile($filename);

		}

	}

}