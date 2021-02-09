<?php

namespace App\Models {

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Support\Facades\DB;

	use App\Models\Entities\Fornecedor;

	class FornecedorModel extends Authenticatable {

		use HasFactory, Notifiable;

		protected $fillable = [];

		protected $hidden = [];

		protected $casts = [];

		protected $table = 'tb_fornecedor';

		protected $order = [];

		public function __construct() {
			$this -> fornecedor = new Fornecedor();
		}

		public function insertFornecedor($emit) {

			$fornecedor = $this -> fornecedor -> fill($emit);

			$hasFornecedor = $this -> select('id', 'cnpj', 'nome', 'xLgr', 'fone', 'ie', 'crt')
								   -> from('tb_fornecedor')
								   -> where('cnpj', $emit -> CNPJ)
								   -> first();

			if ( ! isset($hasFornecedor) ) {

				$data = array(
					'cnpj' => $fornecedor -> getCNPJ(),
					'nome' => $fornecedor -> getXNome(),
					'xFant' => $fornecedor -> getXFant(),
					'xBairro' => $fornecedor -> getEnderEmit('bairro'),
					'xLgr' => $fornecedor -> getEnderEmit('xLgr'),
					'cMun' => $fornecedor -> getEnderEmit('cMun'),
					'cep' => $fornecedor -> getEnderEmit('CEP'),
					'cPais' => $fornecedor -> getEnderEmit('cPais'),
					'nro' => $fornecedor -> getEnderEmit('nro'),
					'fone' => $fornecedor -> getEnderEmit('fone'),
					'email' => $fornecedor -> getEmail(),
					'ie' => $fornecedor -> getIE(),
					'crt' => $fornecedor -> getCRT()
				);

				$this -> insert($data);

			}

			// return $hasPais -> id;

		}

		public function insertDestinatario($dest) {

			$destinatario = $this -> fornecedor -> fill($dest);

			$hasDestinatario = $this -> select('id', 'cnpj', 'nome', 'xLgr', 'fone', 'ie', 'crt')
								   -> from('tb_fornecedor')
								   -> where('cnpj', $dest -> CNPJ)
								   -> first();

			if ( ! isset($hasDestinatario) ) {

				$data = array(
					'cnpj' => $destinatario -> getCNPJ(),
					'nome' => $destinatario -> getXNome(),
					'xFant' => $destinatario -> getXFant(),
					'xBairro' => $destinatario -> getEnderEmit('bairro'),
					'xLgr' => $destinatario -> getEnderEmit('xLgr'),
					'cMun' => $destinatario -> getEnderEmit('cMun'),
					'cep' => $destinatario -> getEnderEmit('CEP'),
					'cPais' => $destinatario -> getEnderEmit('cPais'),
					'nro' => $destinatario -> getEnderDest('nro'),
					'fone' => $destinatario -> getEnderDest('fone'),
					'email' => $destinatario -> getEmail(),
					'ie' => $destinatario -> getIE(),
					'indIEDest' => $destinatario -> getindIEDest(),
					'crt' => $destinatario -> getCRT()
				);

				$this -> insert($data);

			}

		}

		public function getAll($num_rows = false) {

			$this -> table = 'tb_fornecedor AS F';

			$get = $this -> select(
							'F.id',
							DB::raw('(select sum(tb_nfe.vNF)  from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS totais'),
							DB::raw('(select count(tb_nfe.id) from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS qtd_nf'),
							DB::raw('(IF(F.cnpj!="",F.cnpj,F.cpf) ) AS cnpj'),
							'F.nome'
						 );

			if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {

				$search = $_GET['search']['value'];

				$get -> orWhere('F.cnpj', 'like', '%' . $search . '%')
					 -> orWhere('F.cpf', 'like', '%' .  $search . '%')
					 -> orWhere('F.ie', 'like', '%' .  $search . '%')
					 -> orWhere('F.nome', 'like', $search . '%');
        	}

			$this -> order = [
				null,
				'F.nome',
				'F.cnpj',
				DB::raw('(select count(tb_nfe.id) from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90)'),
				DB::raw('(select sum(tb_nfe.vNF)  from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90)'),
				null
			];

			if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
				$get  -> orderBy($this -> order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
			} else {
				$get  -> orderBy($this -> order[1], 'ASC');
			}

			if ( isset($_GET['length']))
				$get  -> limit($_GET['length']);

			if ( isset($_GET['start']) ) {
				$get  -> offset($_GET['start']);
			}

			$get -> orderBy('nome', 'asc');

			return $get;

		}

		public function getSupplierById($id) {

			$this -> table = 'tb_fornecedor AS F';
			return $this -> select(
							DB::raw('(select sum(tb_nfe.vNF)  from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS totais'),
							DB::raw('(select count(tb_nfe.id) from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS qtd_nf'),
							DB::raw('(IF(F.cnpj!="",F.cnpj,F.cpf) ) AS cnpj'),
							'F.nome'
						 )
						 -> where('F.cnpj', '=', $id)
						 -> orWhere('F.cpf', '=', $id)
						 -> first();

		}

		public function getNFe($cnpj) {

			$this -> table = 'tb_nfe AS F';


		}

		public function getTotalNFe() {

			return $this -> getAll() -> count();

		}

	}

}
