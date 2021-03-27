<?php


namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\SpedfiscalModel;
	use App\Models\FornecedorModel;
	use App\Models\NFeModel;

	class SpedController extends Controller {

		public function __construct()
		{
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
			return view('spedfiscal.notas_fiscais', $dados);

		}

		public function detalhes_nfe(Request $request, $emitente, $chave_nfe) {

			$dados['pdf'] = '';
			$dados['spedfiscal'] = $this -> spedfiscal_model -> getSpedfiscal($emitente);
			$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
			return view('spedfiscal.nfe', $dados);

		}

	}

}