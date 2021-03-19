<?php


namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\FornecedorModel;
	use App\Models\NFeModel;

	class FornecedoresController extends Controller {

		public function __construct()
		{
			$this -> nfe_model = new NFeModel();
			$this -> fornecedor_model = new FornecedorModel();
		}

		public function index(Request $request) {

			if ( $request -> ajax() ) {

				$dados['paginate'] = $this -> fornecedor_model -> getFornecedor();
				return view('fornecedores.list.fornecedores', $dados);

			}

			return view('fornecedores.fornecedores');

		}

		public function notas_fiscais(Request $request, $cnpj) {

			if ( $request -> ajax() ) {
				$dados['paginate'] = $this -> nfe_model -> getNFe(null, $cnpj);
				return view('fornecedores.list.notas_fiscais', $dados);
			}

			$dados['fornecedor'] = $this -> fornecedor_model -> getFornecedor($cnpj);
			return view('fornecedores.notas_fiscais', $dados);

		}

		public function danfe(Request $request, $emitente, $chave_nfe) {

			$dados['pdf'] = '';
			$dados['fornecedor'] = $this -> fornecedor_model -> getFornecedor($emitente);
			$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
			return view('fornecedores.danfe', $dados);

		}

	}

}