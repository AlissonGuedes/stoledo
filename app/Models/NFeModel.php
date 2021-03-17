<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class NFeModel extends Authenticatable
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

	public function getNFe($xml = null, $emitente = null, $destinatario = null) {

		$get = $this -> from('tb_nfe')
					 -> select(

							'tb_nfe.*',

							// Emitente
							DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS nomeEmit'),
							DB::raw('(SELECT cnpj FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS cnpjEmit'),
							DB::raw('(SELECT ie FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS ieEmit'),
							DB::raw('(SELECT fone FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS foneEmit'),
							DB::raw('(SELECT xLgr FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS lgrEmit'),
							DB::raw('(SELECT nro FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS nroEmit'),
							DB::raw('(SELECT xBairro FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS bairroEmit'),
							DB::raw('(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = tb_nfe.cEmi) ) AS munEmit'),
							DB::raw('(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = tb_nfe.cEmi) ) AS ufEmit'),

							// Destinatário
							DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS nomeDest'),
							DB::raw('(SELECT cnpj FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS cnpjDest'),
							DB::raw('(SELECT ie FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS ieDest'),
							DB::raw('(SELECT fone FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS foneDest'),
							DB::raw('(SELECT xLgr FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS lgrDest'),
							DB::raw('(SELECT nro FROM tb_fornecedor WHERE cnpj = tb_nfe.cDest) AS nroDest'),
							DB::raw('(SELECT xBairro FROM tb_fornecedor WHERE cnpj = tb_nfe.cEmi) AS bairroDest'),
							DB::raw('(SELECT xMun FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = tb_nfe.cDest) ) AS munDest'),
							DB::raw('(SELECT uf FROM tb_municipio WHERE cMun = (SELECT cMun from tb_fornecedor WHERE cnpj = tb_nfe.cDest) ) AS ufDest'),
						);

		// $get -> join('tb_fornecedor', ['tb_fornecedor.cnpj' => 'tb_nfe.cEmi', 'tb_fornecedor.cnpj' => 'tb_nfe.cDest'], 'join');

		if ( !is_null($xml) ) {
			$get -> where('chNFe', $xml);
		}

		if ( !is_null($emitente) ) {
			$get -> where('cEmi', $emitente);
		}

		if ( !is_null($destinatario) ) {
			$get -> where('destinatario', $destinatario);
		}

		if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {
			$this -> search = $_GET['search']['value'];

			$get -> orWhere('tb_nfe.nNF', 'like', $this -> search .'%')
					-> orWhere('tb_nfe.cNF', 'like', $this -> search . '%')
					-> orWhere('tb_nfe.id', 'like', $this -> search . '%')
					-> orWhere('tb_nfe.cEmi', function($get){

						$search = $_GET['search']['value'];
						$get -> select('cnpj')
								-> from('tb_fornecedor')
								-> where('nome', 'like', $search . '%')
								-> whereColumn('tb_fornecedor.cnpj', 'tb_nfe.cEmi')
								-> whereColumn('tb_fornecedor.cnpj', 'tb_nfe.cDest');
					});

		}

		$this -> order = [
			null,
			'cDest',
			null,
			'nNFe',
			null,
			'tPag',
			'cDest'
		];

		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get  -> orderBy($this -> order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get  -> orderBy($this -> order[6], 'ASC');
		}

		// if ( isset($_GET['length'])) {
		// 	$get  -> limit($_GET['length']);
		// }

		// if ( isset($_GET['start']) ) {
		// 	$get  -> offset($_GET['start']);
		// }

		return $get -> paginate($_GET['length'] ?? null);

	}

	public function getDuplicatas($nfe){

		return $this -> from('tb_nfe');

	}

	public function getNFeSpedFiscal($escriturada = false, $cnpj = null, $data_inicio = null, $data_fim = null) {

		$get = $this -> select('*')
					 -> from('tb_spedfiscal_nfe AS SN');

		// $get -> join('tb_nfe AS N', 'N.chNFe', '=', 'SN.chv_nfe', 'left');
		// $get -> join('tb_spedfiscal AS S', 'S.id', '=', 'SN.id_sped', 'left');
		// $get -> join('tb_lista_nfe AS L', 'L.chave_de_acesso', '=', 'SN.chv_nfe');

		$get -> whereBetween('SN.dt_e_s', [$data_inicio, $data_fim] );

		if ( $escriturada === '0' ) {

		}

		return $get -> paginate($_GET['length'] ?? null);

	}

}
