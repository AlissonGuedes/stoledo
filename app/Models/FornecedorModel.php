<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class FornecedorModel extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	/**
	 * The columns that define the order the results
	 *
	 * @var array
	 */
	private $order = [];

	public function getFornecedor($cnpj = null) {

		$this -> table = 'tb_fornecedor AS F';

		$get = $this -> select(
			'F.*',
			DB::raw('(SELECT xMun FROM tb_municipio WHERE cMun = F.cMun) AS xMun'),
			DB::raw('(select sum(tb_nfe.vNF)  from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS totais'),
			DB::raw('(select count(tb_nfe.id) from tb_nfe where tb_nfe.cEmi = F.cnpj AND tb_nfe.tPag <> 90) AS qtd_nf'),
			DB::raw('(IF(F.cnpj!="",F.cnpj,F.cpf) ) AS cnpj'),
		);

		if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {

			$search = $_GET['search']['value'];

			$get -> orWhere('F.cnpj', 'like', '%' . $search . '%')
					-> orWhere('F.cpf', 'like', '%' .  $search . '%')
					-> orWhere('F.ie', 'like', '%' .  $search . '%')
					-> orWhere('F.nome', 'like', $search . '%');
		}

		if ( !is_null($cnpj) ) {
			$get -> where('F.cnpj', $cnpj);

			return $get -> first();
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

		return $get -> paginate($_GET['length'] ?? null);

	}

}
