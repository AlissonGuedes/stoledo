<?php

namespace App\Models {

    use App\Http\Middleware\Authenticate;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;

	class EnderecoModel extends Authenticatable {

		use HasFactory, Notifiable;

		protected $fillable = [];

		protected $hidden = [];

		protected $casts = [];

		protected $table = 'tb_logradouro';

		public function insertPais($pais) {

			$id = null;

			$hasPais = $this -> select('cPais', 'xPais') -> from('tb_pais') -> where('cPais', $pais -> cPais) -> first();

			if ( ! isset($hasPais) ) {

				$this -> table = 'tb_pais';
				return $this -> insert(['xPais' => $pais -> xPais, 'cPais' => $pais -> cPais]);

			}

			return $hasPais -> id;

		}

		public function insertUF($uf) {

			$id_pais = null;
			$pais = $this -> select('cPais') -> from('tb_pais');

			if ( isset($uf -> cPais) ) $pais -> where('cPais', $uf -> cPais);
			if ( isset($uf -> xPais) ) $pais -> where('xPais', $uf -> xPais);

			$id_pais = $pais -> first();

			$hasUF = $this -> select('id', 'uf', 'cPais')
						   -> from('tb_uf')
						   -> where('uf', $uf -> UF)
						   -> where('cPais', $id_pais -> cPais)
						   -> first();

			if ( ! isset($hasUF) ) {
				$this -> table = 'tb_uf';
				return $this -> insert(['uf' => $uf -> UF, 'cPais' => $id_pais -> cPais]);
			}

			return $hasUF -> id;

		}

		public function insertMunicipio($pais) {

			$id = null;

			$hasEndereco = $this -> select('cMun', 'xMun') -> from('tb_municipio') -> where('cMun', $pais -> cMun) -> where('cMun', $pais -> cMun) -> first();

			if ( ! isset($hasEndereco) ) {
				$this -> table = 'tb_municipio';
				return $this -> insert(['cMun' => $pais -> cMun, 'xMun' => $pais -> xMun, 'uf' => $pais -> UF]);
			}

			return $hasEndereco -> id;

		}

		public function insertBairro($pais) {

			$id = null;

			$hasBairro = $this -> select('id', 'xBairro', 'cMun') -> from('tb_bairro') -> where('cMun', $pais -> cMun) -> where('xBairro', $pais -> xBairro) -> first();

			if ( ! isset($hasBairro) ) {
				$this -> table = 'tb_bairro';
				return $id = $this -> insert(['cMun' => $pais -> cMun, 'xBairro' => $pais -> xBairro]);
			}

			return $hasBairro -> id;

		}

		public function insertLogradouro($pais) {

			$id = null;

			if ( isset($pais -> cPais) && isset($pais -> xPais) )
				$this -> insertPais($pais);

			$this -> insertUF($pais);
			$this -> insertMunicipio($pais);

			$id_bairro = $this -> insertBairro($pais);

			return ['xLgr' => $pais -> xLgr, 'id_bairro' => $id_bairro, 'nro' => $pais -> nro, 'fone' => $pais -> fone];

		}

	}

}
