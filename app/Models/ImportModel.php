<?php

namespace App\Models {

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Facades\DB;

	use App\Models\Entities\NFe;
	use App\Models\Entities\Fornecedor;

	use App\Models\NFeModel;
	use App\Models\FornecedorModel;
	use App\Models\TransportadoraModel;
	use App\Models\ProdutoModel;

	class ImportModel extends Authenticatable {

		use HasFactory, Notifiable;

		protected $fillable = [];

		protected $hidden = [];

		protected $casts = [];

		protected $table = '';

		public function __construct() {

			$this -> nfe = new NFe();
			$this -> nfe_model = new NFeModel();
			$this -> fornecedor_model = new FornecedorModel();
			$this -> transportadora_model = new TransportadoraModel();
			$this -> produto_model = new ProdutoModel();

		}

		/** Importação do arquivo SPED Fiscal */
		public function import_file($file, $arquivo = null) {

			if ( is_null($arquivo) ) {
				$filetype = DS;
			} else {
				$filetype = DS . $arquivo . DS;
			}

			$name = explode('.', $file -> getClientOriginalName());
			$extension = strtolower($file -> getClientOriginalExtension());
			$path = 'public/files/' . $extension . $filetype;

			$filename  = limpa_string($name[count($name) - 2]);
			$filename  = $filename . '.' . $extension;

			if ( $file -> storeAs($path, $filename) ) {
				return true;
			}

			return false;

		}

		/**
		* Start reading the file line by line
		*/
		private function readXMLFile($file) {

			$xml = simplexml_load_file('../storage/app/public/files/xml/' . $file);

			/**
			* (...) First, we will read the NFe data to save it in the Database
			*/

			// Register supplier together with your data individually in the table `tb_fornecedor`
			$this -> fornecedor_model -> insertFornecedor($xml -> NFe -> infNFe -> emit);

			// Register the invoice recipient. Basically, it's the same information.
			$this -> fornecedor_model -> insertDestinatario($xml -> NFe -> infNFe -> dest);

			// Register carrier separately to maintain organization
			$this -> transportadora_model -> insertTransportadora($xml -> NFe -> infNFe -> transp -> transporta);

			// Register the NFe data in the database
			$this -> nfe_model -> insertNFe($xml, $file);

			// Register NFe items
			$this -> produto_model -> insertItens($xml -> NFe -> infNFe);

		}

		/**
		 * Start reading the file line by line
         */
		public function readFiles($file) {

			$database = $_ENV['DB_DATABASE'];
			$username = $_ENV['DB_USERNAME'];
			$password = $_ENV['DB_PASSWORD'];

			if ( !is_dir('logs')) {
				shell_exec('mkdir logs');
			}

			if ( ! file_exists('logs/imports.log') )
				shell_exec('touch logs/imports.log');

			// if ( $file == 'spedfiscal' ) {
				return response( shell_exec("/usr/bin/bash ../app/Console/import.sh $database $username $password"), 200);
			// 	return response( shell_exec("/usr/bin/bash ../app/Console/import.sh $database $username $password"), 200);
			// } elseif ( $file == 'notasfiscais' ) {
			// 	return response( shell_exec("/usr/bin/bash ../app/Console/NFe/import.sh $database $username $password"), 200);
			// }

		}

		public function log($remove = false) {

			if ( Session::has('import_txt') ) {

				if ( $remove ) {
					Session::forget('import_txt');
				}

				$logfile = shell_exec('tail ' . public_path('logs/imports.log'));

			}

			if ( isset($logfile) ) {
				return json_encode(['log' => ( $logfile ?? null ) ]);
			} else {
				return json_encode(['status' => 'success', 'message' => 'Importação finalizada com sucesso!']);
			}

		}

	}

}