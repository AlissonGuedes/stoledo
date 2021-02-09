<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Models\NFeModel;
use App\Models\FornecedorModel;

class ExportsController implements FromView
{

	public function __construct() {
		$this -> nfe_model = new NFeModel();
		$this -> fornecedor_model = new FornecedorModel();
	}

	public function view(): View {

		$dados['nfe'] = $this -> nfe_model;
		$dados['fornecedor'] = $this -> fornecedor_model;
		return view('relatorios.fornecedores.xls', $dados);

	}

	public function fornecedores() {

		return null;

	}

}
