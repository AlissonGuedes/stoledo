<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\SpedModel;
use App\Models\NFeModel;

use Barryvdh\DomPDF\Facade;

class SpedController extends Controller {

	public function __construct() {

		$this -> sped_model = new SpedModel();
		$this -> nfe_model = new NFeModel();

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

	// public function show($cnpj, $data_inicio, $data_fim) {

	// 	if (request() -> ajax()) {
	// 		$dados['rows'] = $this -> sped_model -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> get();
	// 		$dados['numRows'] = $this -> sped_model -> getTotalRows($cnpj);
	// 		return view('relatorios.sped.datatables.show', $dados);
	// 	}

	// 	$dados['row'] = $this -> sped_model -> getSped($cnpj, $data_inicio, $data_fim) -> first();
	// 	return view('relatorios.sped.show', $dados);

	// }

	// public function detalhamento($cnpj, $data_inicio, $data_fim, $emitente) {

	// 	if ( request() -> ajax() ) {
	// 		$dados['rows'] = $this -> sped_model -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> get();
	// 		$dados['numRows'] = $this -> sped_model -> getTotalRows($cnpj, $data_inicio, $data_fim);
	// 	}

	// 	$dados['row'] = $this -> sped_model -> getSped($cnpj, $data_inicio, $data_fim, $emitente) -> first();
	// 	return view('relatorios.sped.detalhamento', $dados);

	// }

	/**
	 * Relação de todas as notas não escrituradas
	 * Busca as notas que têm no arquivo de Lista NFe TXT mas não têm no Sped Fiscal
	 */
	public function nao_escrituradas($cnpj, $data_inicio, $data_fim) {

		if ( request() -> ajax()) {

			$dados['rows'] = $this -> sped_model -> getNFeNaoEscrituradas($cnpj, $data_inicio, $data_fim);
		    $totalRows = $this -> sped_model -> getNFeNaoEscrituradas($cnpj, $data_inicio, $data_fim) -> count();
			$dados['recordsFiltered'] = $dados['rows'] -> paginate($totalRows) -> count();

			return view('relatorios.sped.datatables.nao_escrituradas.index', $dados);

		}

		$dados['cnpj'] = $cnpj;
		$dados['data_inicio'] = convert_to_date($data_inicio, 'dmY');
		$dados['data_fim'] = convert_to_date($data_fim, 'dmY');

		return view('relatorios.sped.nao_escrituradas.index', $dados);

	}

	/**
	 * Exibe detalhes da nota fiscal que ainda não foi escriturada
	 */
	public function show_nfe($cnpj, $data_inicio, $data_fim, $nfe) {

		if ( request() -> ajax() ) {
			$dados['rows'] = $this -> sped_model -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> get();
			$dados['numRows'] = $this -> sped_model -> getTotalRows($cnpj, $data_inicio, $data_fim);
		}

		$dados['cnpj'] = $cnpj;
		$dados['nfe']  = $nfe;
		$dados['nome'] = 'Teste';
		$dados['data_inicio'] = convert_to_date($data_inicio, 'dmY');
		$dados['data_fim'] = convert_to_date($data_fim, 'dmY');

		$dados['row'] = $this -> sped_model -> getNFeById($nfe);
		$dados['pdf'] = $this -> baixar_pdf($nfe);
        return view('relatorios.sped.nao_escrituradas.show_nfe', $dados);

	}

	public function baixar_xls($xml) {

		$sped = new \App\Http\Controllers\Exports\Sped();
		return Excel::download(new \App\Http\Controllers\Exports\Sped, 'nfe.xlsx');

	}

	public function baixar_pdf($xml) {

		$dados['nfe']  = $xml;
		$dados['sped_model'] = $this -> sped_model;
		$dados['row'] = $this -> sped_model -> getNFeById($xml);

		// if ( ! file_exists(storage_path('app/public/files/pdf/' . $xml . '.pdf')) )
			\PDF::loadView('relatorios.downloads.sped.nfe.pdf', $dados) -> setPaper('a4') -> save( storage_path('app/public/files/pdf/' . $xml . '.pdf'));

		return 'files/pdf/' . $xml . '.pdf';

	}


}
