<?php

namespace App\Http\Controllers\Exports;

use  Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

use App\Models\SpedModel;

class Sped implements FromView
{

	public function view(): View {

		$dados['sped_model'] = new SpedModel();
		return view('relatorios.downloads.sped.nfe.xls', $dados);

	}

}
