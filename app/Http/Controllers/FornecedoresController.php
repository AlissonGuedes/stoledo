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
            $dados['totalRecords'] = $this -> fornecedor_model -> all();
            $dados['numRows'] = $this -> fornecedor_model -> getTotalNFe();
            return view('relatorios.fornecedores.datatables.index', $dados);
        }

        return view('relatorios.fornecedores.index');

    }

    public function show($cnpj) {

        $dados['row'] = $this -> fornecedor_model -> getSupplierById($cnpj);
        $dados['rows'] = $this -> nfe_model -> getNFeBySupplier($cnpj);
        return view('relatorios.fornecedores.show', $dados);

    }

    public function show_nfe($cnpj, $nfe) {

		$dados['row'] = $this -> nfe_model -> getNFeById($nfe);
        return view('relatorios.fornecedores.show_nfe', $dados);

    }

	public function baixar_xls() {

		return Excel::download(new \App\Http\Controllers\ExportsController, 'nfe.xlsx');

	}

}
