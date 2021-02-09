<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\NFeModel;
use App\Models\FornecedorModel;
use App\Models\TransportadoraModel;
use App\Models\ProdutoModel;

class NFeController extends Controller {

	public function __construct() {

		$this -> nfe_model = new NFeModel();
		$this -> fornecedor_model = new FornecedorModel();
		$this -> transportadora_model = new TransportadoraModel();
		$this -> produto_model = new ProdutoModel();

	}

	public function index(Request $request) {

		if ($request -> ajax()) {
			$dados['xml'] = $this -> nfe_model -> getXML() -> get();
			$dados['numRows'] = $this -> nfe_model -> getXML(true);
			return view('relatorios.nfe.datatables.index', $dados);
		}

		$dados['xml'] = $this -> nfe_model -> getXML();
		return view('relatorios.nfe.index', $dados);

	}

	public function details_nfe($id) {

		if ( request() -> ajax()){
			return json_encode([]);
		}
		$dados['row'] = $this -> nfe_model -> getNFeById($id);
		return view('relatorios.nfe.details', $dados);

	}

}
