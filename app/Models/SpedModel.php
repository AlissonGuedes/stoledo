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

    public function __construct()
    {
        $this->nfe = new NFe();
    }

	/**
	 * Lista todos os arquivos importados do Sped Fiscal
	 */
    public function getSped($cnpj = null, $data_inicio = null, $data_fim = null)
    {
        $get = $this->from('tb_spedfiscal', 'S')
					->select(
						'S.id',
						'cnpj_fornecedor',
						'id_contabilista',
						'cod_ver',
						'cod_fin',
						'dt_ini',
						'dt_fin',
						'ind_perfil',
						DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = S.cnpj_fornecedor) AS nome'),
						DB::raw('(SELECT cnpj FROM tb_fornecedor WHERE cnpj = S.cnpj_fornecedor) AS cnpj')
					);

        if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
            $search = $_GET['search']['value'];
            $get->orWhere('S.cnpj_fornecedor', 'like', '%' . $search);

            $date = date('dmY', strtotime(str_replace('/', '-', $search)));
            $get->orWhere('S.dt_ini', 'like', '%' . $date . '%')
				->orWhere('S.dt_fin', 'like', '%' . $date . '%');
        }

        if (!is_null($cnpj) && !is_null($data_inicio) && !is_null($data_fim)) {
            $get->where('S.cnpj_fornecedor', $cnpj)
                ->where('S.dt_ini', $data_inicio)
                ->where('S.dt_fin', $data_fim);
        }

        $this->order = [
			null,
			DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = S.cnpj_fornecedor)'),
			DB::raw('(SELECT cnpj FROM tb_fornecedor WHERE cnpj = S.cnpj_fornecedor)'),
			'S.dt_ini',
			'S.dt_fin',
			'S.ind_perfil'
		];

        if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
            $get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
        } else {
            $get->orderBy($this->order[1], 'ASC');
        }

        if (isset($_GET['length'])) {
            $get->limit($_GET['length']);
        }

        if (isset($_GET['start'])) {
            $get->offset($_GET['start']);
        }

        $get->orderBy('nome', 'asc');

        return $get;
    }

	/**
	 * Lista todos os Fornecedores que emitiram notas fiscais relacionados dentro do arquivo do Sped Fiscal
	 */
    public function getFornecedor($cnpj, $data_inicio, $data_fim)
    {
        $get = $this->distinct()
            ->select(
				'cpf_cnpj_emit AS cEmi',
				'nome_razao_social_emit AS xNome',
				DB::raw('(SELECT SUM(CONVERT(REPLACE(REPLACE(valor_total_da_nota, ".", ""), ",","."), DECIMAL(11,2))) FROM tb_lista_nfe WHERE cpf_cnpj_emit = N.cpf_cnpj_emit GROUP by cpf_cnpj_emit) AS totalAquisicoes')
			)
            ->from('tb_lista_nfe AS N');

        $get->where('N.cpf_cnpj_dest', cnpj($cnpj))
			->whereBetween('N.data_de_emissao',
				[
					convert_to_date($data_inicio, 'Y-m-d'),
					convert_to_date($data_fim, 'Y-m-d')
				]
			);

        $this->order = [
			null,
			'cpf_cnpj_emit',
			'nome_razao_social_emit',
			DB::raw('(SELECT SUM(CONVERT(REPLACE(REPLACE(valor_total_da_nota, ".", ""), ",","."), DECIMAL(11,2))) FROM tb_lista_nfe WHERE cpf_cnpj_emit = N.cpf_cnpj_emit GROUP by cpf_cnpj_emit)'),
			null
		];

        if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
            $get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
        } else {
            $get->orderBy($this->order[2], 'ASC');
        }

        if (isset($_GET['length'])) {
            $get->limit($_GET['length']);
        }

        if (isset($_GET['start'])) {
            $get->offset($_GET['start']);
        }

        return $get;
    }

	/**
	 * Lista todos os emitentes relacionados dentro do arquivo do Sped Fiscal
	 */
    public function getEmitente($cnpj, $data_inicio, $data_fim)
    {
        $get = $this->distinct()
            ->select(
				'cpf_cnpj_emit AS cEmi',
				'nome_razao_social_emit AS xNome',
				DB::raw('(SELECT SUM(CONVERT(REPLACE(REPLACE(valor_total_da_nota, ".", ""), ",","."), DECIMAL(11,2))) FROM tb_lista_nfe WHERE cpf_cnpj_emit = N.cpf_cnpj_emit GROUP by cpf_cnpj_emit) AS totalAquisicoes')
			)
            ->from('tb_lista_nfe AS N');

        $get->where('N.cpf_cnpj_emit', cnpj($cnpj))
			->whereBetween('N.data_de_emissao',
				[
					convert_to_date($data_inicio, 'Y-m-d'),
					convert_to_date($data_fim, 'Y-m-d')
				]
			);

        $this->order = [
			null,
			'cpf_cnpj_emit',
			'nome_razao_social_emit',
			DB::raw('(SELECT SUM(CONVERT(REPLACE(REPLACE(valor_total_da_nota, ".", ""), ",","."), DECIMAL(11,2))) FROM tb_lista_nfe WHERE cpf_cnpj_emit = N.cpf_cnpj_emit GROUP by cpf_cnpj_emit)'),
			null
		];

        if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
            $get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
        } else {
            $get->orderBy($this->order[2], 'ASC');
        }

        if (isset($_GET['length'])) {
            $get->limit($_GET['length']);
        }

        if (isset($_GET['start'])) {
            $get->offset($_GET['start']);
        }

        return $get;
    }

    /**
     * Faz o cruzamento das informações de notas fiscais com as Chaves da NFe dentro do Sped Fiscal
     */
    public function getNFeNaoEscrituradas($emitente = null, $data_inicio = null, $data_fim = null)
    {
        $this->emitente = $emitente;

        $get = $this->distinct()
            ->select(
				'chave_de_acesso AS chv_nfe',
				DB::raw('CONCAT(numero, "-", serie) AS numero'),
				'cpf_cnpj_emit AS cEmit',
				'nome_razao_social_emit AS xNome',
				DB::raw('DATE_FORMAT(data_de_emissao, "%d/%m/%Y") AS dt_emi'),
				'hora_de_emissao',
				'valor_total_da_nota',
				'valor_do_icms'
			)
            ->from('tb_lista_nfe AS L')
            ->whereNotIn('chave_de_acesso', function ($q) {
                $q->select('chv_nfe')
                    ->from('tb_spedfiscal_nfe AS N')
                    ->whereColumn('N.chv_nfe', '=', 'L.chave_de_acesso')
                    ->where('L.cpf_cnpj_emit', cnpj($this->emitente));
            })
            ->where('L.cpf_cnpj_emit', cnpj($emitente))
            ->whereBetween('L.data_de_emissao', [convert_to_date($data_inicio, 'Y-m-d'), convert_to_date($data_fim, 'Y-m-d')]);

        if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
            $get->where(function ($get) {
                $search = $_GET['search']['value'];
                $get->orWhere('L.chave_de_acesso', 'like', $search . '%')
                    ->orWhere('L.numero', 'like', $search . '%')
                    ->orWhere('L.nome_razao_social_emit', 'like', $search . '%');
            });
        }

        $this->order = [
			null,
			'L.chave_de_acesso',
			'L.numero',
			'L.cpf_cnpj_emit',
			'L.nome_razao_social_emit',
			'L.data_de_emissao',
			'L.hora_de_emissao',
			'L.valor_total_da_nota',
			'L.valor_do_icms'
		];

        if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
            $get->orderBy($this->order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
        } else {
            $get->orderBy($this->order[4], 'ASC');
        }

        $get->orderBy('data_de_emissao', 'ASC');
        $get->orderBy('hora_de_emissao', 'ASC');

        if (isset($_GET['length'])) {
            $get->limit($_GET['length']);
        }

        if (isset($_GET['start'])) {
            $get->offset($_GET['start']);
        }

        return $get;
    }

    // public function getXMLvsTXT($cnpj = null, $data_inicio = null, $data_fim = null, $count = false) {

    // $get = $this -> select('S.cnpj_fornecedor', 'S.dt_ini', 'S.dt_fin', 'N.id AS idNFe', 'N.cEmi', 'N.nNF',DB::raw('(select nome from tb_fornecedor where N.cEmi = tb_fornecedor.cnpj) AS emitente'), 'N.serie', 'N.vOrig','N.vBC', 'N.vICMS')
    // -> from('tb_spedfiscal_nfe AS SN')
    // -> join('tb_nfe AS N', 'N.chNFe', '=', 'SN.chv_nfe')
    // -> join('tb_spedfiscal AS S', 'S.id', '=', 'SN.id_sped', 'inner');

    // if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {

    // $search = $_GET['search']['value'];
    // $get -> orWhere('S.cnpj_fornecedor', 'like', '%' . $search)
    // -> orWhere('S.dt_ini', 'like', '%' . $search)
    // -> orWhere('S.dt_fin', 'like', '%' . $search);

    // }

    // if ( !is_null($cnpj) && !is_null($data_inicio) && !is_null($data_fim) ) {
    // $get -> where('S.cnpj_fornecedor', $cnpj)
    // -> where('S.dt_ini', $data_inicio)
    // -> where('S.dt_fin', $data_fim);
    // }

    // $this -> order = [
    // null,
    // 'N.chNFe',
    // 'N.nNF',
    // 'N.cEmi',
    // DB::raw('(select nome from tb_fornecedor where N.cEmi = tb_fornecedor.cnpj)'),
    // 'N.vOrig',
    // 'N.vBC',
    // 'N.vICMS',
    // null
    // ];

    // if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
    // $get -> orderBy($this -> order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
    // } else {
    // $get -> orderBy($this -> order[1], 'ASC');
    // }

    // if ( ! $count) {

    // if ( isset($_GET['length'])) {
    // $get -> limit($_GET['length']);
    // }

    // if ( isset($_GET['start']) ) {
    // $get -> offset($_GET['start']);
    // }

    // }

    // return $get;

    // }

	/**
	 * Pega as informações da nota fiscal dentro do arquivo de notas.
	 */
    public function getNFeById($chNFe)
    {
        return $this->select('*')
            ->from('tb_lista_nfe', 'N')
            ->where('chave_de_acesso', $chNFe)
            ->first();
    }

    public function getTotalRows($cnpj = null, $data_inicio = null, $data_fim = null)
    {
        // return $this -> getXMLvsTXT($cnpj, $data_inicio, $data_fim) -> count();
    }

    // public function getReport($id)
    // {
    //     return $this->getSped($id);
    // }
}
