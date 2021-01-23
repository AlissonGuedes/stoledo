<?php

namespace App\Models {

    use App\Http\Middleware\Authenticate;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;

	use App\Models\Entities\Fornecedor;

	class FornecedorModel extends Authenticatable {

		use HasFactory, Notifiable;

		protected $fillable = [];

		protected $hidden = [];

		protected $casts = [];

		protected $table = 'tb_fornecedor';

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
					'id_bairro' => $fornecedor -> getEnderEmit('id_bairro'),
					'xLgr' => $fornecedor -> getEnderEmit('xLgr'),
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

		public function insertDestinatario($emit) {

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
					'id_bairro' => $fornecedor -> getEnderDest('id_bairro'),
					'xLgr' => $fornecedor -> getEnderDest('xLgr'),
					'nro' => $fornecedor -> getEnderDest('nro'),
					'fone' => $fornecedor -> getEnderDest('fone'),
					'email' => $fornecedor -> getEmail(),
					'ie' => $fornecedor -> getIE(),
					'indIEDest' => $fornecedor -> getindIEDest(),
					'crt' => $fornecedor -> getCRT()
				);

				$this -> insert($data);

			}

			// return $hasPais -> id;

		}

		// public function insertUF($pais) {

		// 	$id = null;

		// 	$hasUF = $this -> select('id', 'uf', 'cPais') -> from('tb_uf') -> where('uf', $pais -> UF) -> where('cPais', $pais -> cPais) -> first();

		// 	if ( ! isset($hasUF) ) {
		// 		$this -> table = 'tb_uf';
		// 		return $this -> insert(['uf' => $pais -> UF, 'cPais' => $pais -> cPais]);
		// 	}

		// 	return $hasUF -> id;

		// }

		// public function insertMunicipio($pais) {

		// 	$id = null;

		// 	$hasEndereco = $this -> select('cMun', 'xMun') -> from('tb_municipio') -> where('cMun', $pais -> cMun) -> where('cMun', $pais -> cMun) -> first();

		// 	if ( ! isset($hasEndereco) ) {
		// 		$this -> table = 'tb_municipio';
		// 		return $this -> insert(['cMun' => $pais -> cMun, 'xMun' => $pais -> xMun, 'uf' => $pais -> UF]);
		// 	}

		// 	return $hasEndereco -> id;

		// }

		// public function insertBairro($pais) {

		// 	$id = null;

		// 	$hasBairro = $this -> select('id', 'xBairro', 'cMun') -> from('tb_bairro') -> where('cMun', $pais -> cMun) -> where('xBairro', $pais -> xBairro) -> first();

		// 	if ( ! isset($hasBairro) ) {
		// 		$this -> table = 'tb_bairro';
		// 		return $id = $this -> insert(['cMun' => $pais -> cMun, 'xBairro' => $pais -> xBairro]);
		// 	}

		// 	return $hasBairro -> id;

		// }

		// public function insertLogradouro($pais) {

		// 	$id = null;
		// 	$this -> insertPais($pais);
		// 	$this -> insertUF($pais);
		// 	$this -> insertMunicipio($pais);
		// 	$id_bairro = $this -> insertBairro($pais);

		// 	$hasLgr = $this -> select('id', 'xLgr', 'cep', 'id_bairro') -> from('tb_logradouro') -> where('xLgr', $pais -> xLgr) -> where('id_bairro', $id_bairro) -> first();

		// 	if ( ! isset($hasLgr) ) {
		// 		$this -> table = 'tb_logradouro';
		// 		$id = $this -> insert(['xLgr' => $pais -> xLgr, 'cep' => $pais -> CEP, 'id_bairro' => $id_bairro]);
		// 	} else {
		// 		$id = $hasLgr -> id;
		// 	}

		// 	return ['xLgr' => $id, 'nro' => $pais -> nro, 'fone' => $pais -> fone];

		// }

	}

}
