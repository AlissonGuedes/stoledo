<?php

namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\ProdutoModel;
	use App\Models\NFeModel;

	class ProdutosController extends Controller {

		public function __construct()
		{
			$this -> nfe_model = new NFeModel();
			$this -> produto_model = new ProdutoModel();
		}

		public function index(Request $request) {

			if ( $request -> ajax() ) {

				$dados['paginate'] = $this -> produto_model -> getProduto();
				return view('produtos.list.produtos', $dados);

			}

			return view('produtos.produtos');

		}

		public function notas_fiscais(Request $request, $cnpj) {

			if ( $request -> ajax() ) {
				$dados['paginate'] = $this -> nfe_model -> getNFe(null, $cnpj);
				return view('produtos.list.notas_fiscais', $dados);
			}

			$dados['produto'] = $this -> produto_model -> getProduto($cnpj);
			return view('produtos.notas_fiscais', $dados);

		}

		public function danfe(Request $request, $emitente, $chave_nfe) {

			$dados['pdf'] = '';
			$dados['produto'] = $this -> produto_model -> getProduto($emitente);
			$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
			return view('produtos.danfe', $dados);

		}

	}

}