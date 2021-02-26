<?php

namespace App\Http\Controllers\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use App\Models\NFeModel;
use App\Models\FornecedorModel;

class NFe implements FromView
{

	public function view(): View {

		$dados['nfe'] = new NFeModel();
		return view('relatorios.downloads.nfe.xls', $dados);

	}

}
