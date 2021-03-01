<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\FornecedorModel;
use App\Models\NFeModel;

class FornecedoresController extends Controller
{

    public function __construct() {

        $this -> fornecedor_model = new FornecedorModel();
        $this -> nfe_model = new NFeModel();

    }

    /**
     * Show the system home page
     */
    public function index(Request $request) {

        if ($request -> ajax()) {
            $dados['rows'] = $this -> fornecedor_model -> getAll();
            $dados['recordsFiltered'] = $this -> fornecedor_model -> paginate() -> total();
            return view('relatorios.fornecedores.datatables.index', $dados);
        }

        return view('relatorios.fornecedores.index');

    }

    public function show($cnpj) {

		if(request() -> ajax()){
			$dados['rows'] = $this -> nfe_model -> getNFeBySupplier($cnpj);
			$dados['numRows'] = 0;
			$dados['totalRecords'] = 0;
			return view('relatorios.fornecedores.datatables.show', $dados);
		}


        $dados['row'] = $this -> fornecedor_model -> getSupplierById($cnpj);
        return view('relatorios.fornecedores.show', $dados);

    }

    public function show_nfe($cnpj, $nfe) {

		$dados['row'] = $this -> nfe_model -> getNFeById($nfe);
        return view('relatorios.fornecedores.show_nfe', $dados);

    }

	public function baixar_xls() {

		return Excel::download(new \App\Http\Controllers\Exports\NFe, 'nfe.xlsx');

	}

}
