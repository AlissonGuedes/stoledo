<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Entities\NFe;

class SpedModel extends Authenticatable
{
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $table = 'tb_spedfiscal';
	protected $order = [];

	public function __construct() {
		$this -> nfe = new NFe();
	}

	public function getSped($cnpj = null, $data_inicio = null, $data_fim = null) {

		$get = $this -> from('tb_spedfiscal', 'S')
						-> select('S.id', 'cnpj_fornecedor', 'id_contabilista', 'cod_ver', 'cod_fin', 'dt_ini', 'dt_fin', 'ind_perfil', 'F.nome', 'F.cnpj')
						-> join('tb_fornecedor as F', 'F.cnpj', '=', 'S.cnpj_fornecedor');

		if ( !is_null($cnpj) )
			$get -> where('S.cnpj_fornecedor', $cnpj);

		if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {
			$search = $_GET['search']['value'];
			$get -> orWhere('S.cnpj_fornecedor', 'like', '%' . $search)
				-> orWhere('S.dt_ini', 'like', '%' .  $search)
				-> orWhere('S.dt_fin', 'like', '%' .  $search)
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

	public function getXMLvsTXT($cnpj = null, $data_inicio = null, $data_fim = null){

		$get = $this -> select(
							'S.id', 'S.cnpj_fornecedor', 'S.cod_ver', 'S.cod_fin', 'S.dt_ini', 'S.dt_fin', 'ind_perfil',
							'N.id AS idNFe', 'N.chNFe', 'N.nNF', 'N.serie', 'N.cEmi', DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = N.cEmi) AS nome_fornecedor'), 'F.cnpj', 'N.vOrig', 'N.vBC', 'N.vICMS')
					 -> from('tb_spedfiscal AS S')
					 -> join('tb_spedfiscal_nfe AS SN', 'SN.id_sped', '=', 'S.id', 'inner')
					 -> join('tb_nfe AS N', 'N.chNFe', '=', 'SN.chv_nfe', 'inner')
					 -> join('tb_fornecedor AS F', 'F.cnpj', '=', 'S.cnpj_fornecedor', 'left');

		if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {
			$search = $_GET['search']['value'];
			$get -> orWhere('S.cnpj_fornecedor', 'like', '%' . $search)
				-> orWhere('S.dt_ini', 'like', '%' .  $search)
				-> orWhere('S.dt_fin', 'like', '%' .  $search)
				-> orWhere('F.nome', 'like', $search . '%');
		}

		if ( !is_null($cnpj) && !is_null($data_inicio) && !is_null($data_fim) ) {
			$get -> where('S.cnpj_fornecedor', $cnpj)
				  -> where('S.dt_ini', $data_inicio)
				  -> where('S.dt_fin', $data_fim);
		}

		$this -> order = [
			'N.id',
			'N.nNF',
			'N.cEmi',
			DB::raw('(select nome from tb_fornecedor where N.cEmi = tb_fornecedor.cnpj)'),
			'N.vOrig',
			'N.vBC',
			'N.vICMS',
			null
		];

		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get -> orderBy($this -> order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get -> orderBy($this -> order[1], 'ASC');
		}

		if ( isset($_GET['length']))
			$get -> limit($_GET['length']);

		if ( isset($_GET['start']) ) {
			$get -> offset($_GET['start']);
		}

		return $get;

	}

	public function getTotalRows($cnpj = null, $data_inicio = null, $data_fim = null) {

		return $this -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> count();

	}

	public function getReport($id) {

		return $this -> getSped($id);

	}

}
