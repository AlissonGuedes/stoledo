<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class SpedfiscalModel extends Authenticatable
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

	public function getSpedfiscal() {

$this -> table = 'tb_spedfiscal AS S';

			$get = $this -> select(
							'S.*',
							// DB::raw('dt_ini, dt_fin) AS periodo'),
							DB::raw('(select nome  from tb_fornecedor where tb_fornecedor.cnpj = S.cnpj_fornecedor) AS empresa'),
							DB::raw('(select nome from tb_contabilista where tb_contabilista.id = S.id) AS contador')
						 );

			if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {

				$search = $_GET['search']['value'];

				$get -> orWhere('S.cnpj_fornecedor', 'like', '%' . $search . '%')
					 -> orWhere('F.cpf', 'like', '%' .  $search . '%')
					 -> orWhere('F.ie', 'like', '%' .  $search . '%')
					 -> orWhere('F.nome', 'like', $search . '%');
        	}

			$this -> order = [
				null,
				DB::raw('(select nome from tb_fornecedor where tb_fornecedor.cnpj = S.cnpj_fornecedor)'),
				'S.cnpj_fornecedor',
				DB::raw('(select nome from tb_contabilista where tb_contabilista.id = S.id)'),
				DB::raw('CONCAT(dt_ini, dt_fin)'),
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

			return $get -> paginate($_GET['length'] ?? null );

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

}
