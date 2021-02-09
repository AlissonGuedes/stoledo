<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SpedModel;

class SpedController extends Controller {

	public function __construct() {

	$this -> sped_model = new SpedModel();

	}

	public function index(Request $request) {

		if ($request -> ajax()) {
		$dados['rows'] = $this -> sped_model -> getSped() -> get();
		$dados['numRows'] = $this -> sped_model -> getTotalRows(true);
		return view('relatorios.sped.datatables.index', $dados);
		}

		$dados['xml'] = $this -> sped_model -> getSped();
		return view('relatorios.sped.index', $dados);

	}

	public function show($cnpj, $data_inicio, $data_fim) {

		if (request() -> ajax()) {
			$dados['rows'] = $this -> sped_model -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> get();
			$dados['numRows'] = $this -> sped_model -> getTotalRows($cnpj);
			return view('relatorios.sped.datatables.show', $dados);
		}

		$dados['row'] = $this -> sped_model -> getSped($cnpj, $data_inicio, $data_fim) -> first();
		return view('relatorios.sped.show', $dados);

	}

	public function detalhamento($cnpj, $data_inicio, $data_fim, $emitente) {

		// if ( request() -> ajax() ) {
		// 	$dados['rows'] = $this -> sped_model -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> get();
		// 	$dados['numRows'] = $this -> sped_model -> getTotalRows($cnpj, $data_inicio, $data_fim);
		// }

		$dados['row'] = $this -> sped_model -> getSped($cnpj, $data_inicio, $data_fim, $emitente) -> first();
		return view('relatorios.sped.detalhamento', $dados);

	}

}
