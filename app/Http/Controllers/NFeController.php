<?php


namespace App\Http\Controllers {

	use Illuminate\Http\Request;
	use Maatwebsite\Excel\Facades\Excel;

	use App\Models\SpedfiscalModel;
	use App\Models\NFeModel;

	class NFeController extends Controller {

		public function __construct()
		{
			$this -> nfe_model = new NFeModel();
			$this -> spedfiscal_model = new SpedfiscalModel();
		}

		public function index(Request $request) {

			if ( $request -> ajax() ) {

				$dados['paginate'] = $this -> nfe_model -> getNFe();
				return view('nfe.list.notas_fiscais', $dados);

			}

			return view('nfe.notas_fiscais');

		}

		public function notas_fiscais() {

			return view('home');

		}

		public function sped_fiscal(Request $request, $escriturada = false, $cnpj = null, $data_inicio = null, $data_fim = null) {

			if ( $request -> ajax() ) {
				$dados['paginate'] = $this -> nfe_model -> getNFe(null, $cnpj);
				return view('nfe.list.notas_fiscais', $dados);
			}

			if (  $escriturada === '0' ) {
				$dados['tipo'] = 'Não Escrituradas';
			} else {
				$dados['tipo'] = 'Escrituradas';
			}

			$dados['nfe'] = $this -> nfe_model -> getNFeSpedFiscal($escriturada, $cnpj, $data_inicio, $data_fim);

			return view('nfe.teste', $dados);
			// return view('nfe.notas_fiscais', $dados);

		}

		// public function detalhes_nfe(Request $request, $emitente, $chave_nfe) {

		// 	$dados['pdf'] = '';
		// 	$dados['spedfiscal'] = $this -> spedfiscal_model -> getSpedfiscal($emitente);
		// 	$dados['nfe'] = $this -> nfe_model -> getNFe($chave_nfe) -> first();
		// 	return view('spedfiscal.nfe', $dados);

		// }

	}

}