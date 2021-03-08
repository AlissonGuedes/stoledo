<?php

namespace App\Models {

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
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

		/**
		* Run from the import process
		*/
		public function import_nfe($file) {

			$name = strtolower($file -> getClientOriginalName());;
			$file -> storeAs('public/files/' . $file -> getClientOriginalExtension(), $name);

			$this -> readXMLFile($name);

			// echo json_encode(['status' => 'success', 'message' => 'Importação finalizada com sucesso!']);

		}

		/** Importação do arquivo SPED Fiscal */
		public function import_sped($file){

			$name = strtolower($file -> getClientOriginalName());
			$file -> storeAs('public/files/' . $file -> getClientOriginalExtension(), $name);

			$this -> readTXTFile($name);

			// echo json_encode(['status' => 'success', 'message' => 'Importação finalizada com sucesso!']);

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
		private function readTXTFile($file) {

			// $txt = fopen(storage_path('../storage/app/public/files/txt/' . $file), 'r');

			// while(!feof($txt)) {
			// 	echo fgets($txt) . '<br>';
			// }

			$exec = shell_exec("/usr/bin/python3 ../app/Console/read_file.py");

		}

	}

}
