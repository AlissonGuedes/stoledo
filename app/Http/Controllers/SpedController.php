<?php


namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\SpedfiscalModel;
	use App\Models\NFeModel;

	class SpedController extends Controller {

		public function __construct()
		{
			$this -> nfe_model = new NFeModel();
			$this -> spedfiscal_model = new SpedfiscalModel();
		}

		public function index(Request $request) {

			if ( $request -> ajax() ) {

				$dados['paginate'] = $this -> spedfiscal_model -> getSpedfiscal();
				return view('spedfiscal.list.spedfiscal', $dados);

			}

			return view('spedfiscal.spedfiscal');

		}

		public function notas_fiscais(Request $request, $cnpj) {

			if ( $request -> ajax() ) {
				$dados['paginate'] = $this -> nfe_model -> getNFe(null, $cnpj);
				return view('spedfiscal.list.notas_fiscais', $dados);
			}

			$dados['spedfiscal'] = $this -> spedfiscal_model -> getSpedfiscal($cnpj);
			return view('spedfiscal.notas_fiscais', $dados);

		}

		public function detalhes_nfe(Request $request, $emitente, $chave_nfe) {

			$dados['pdf'] = '';
			$dados['spedfiscal'] = $this -> spedfiscal_model -> getSpedfiscal($emitente);
			$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
			return view('spedfiscal.nfe', $dados);

		}

	}

}