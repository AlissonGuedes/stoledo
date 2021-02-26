<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\Entities\NFe;

class NFeModel extends Authenticatable
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
	protected $casts = [];

	protected $table = 'tb_nfe';

	protected $order = [null, 'tb_nfe.cNF', 'tb_nfe.nNF', 'tb_nfe.cEmi', 'tb_fornecedor.nome', 'tb_nfe.vOrig', 'tb_nfe.vBC', 'tb_nfe.vICMS'];

	public function __construct() {
		$this -> nfe = new NFe();
	}

	public function getXML($num_rows = null) {

		$get = $this -> from('tb_nfe')
					 -> join('tb_fornecedor', 'tb_nfe.cEmi', '=', 'tb_fornecedor.cnpj');


		if ( isset($_GET['search']['value']) && ! empty($_GET['search']['value'])) {

			$search = $_GET['search']['value'];

			$get -> orWhere('tb_nfe.cEmi', 'like', '%' . $search . '%')
				 -> orWhere('tb_nfe.nNF', 'like', '%' .  $search . '%')
				 -> orWhere('tb_nfe.cNF', 'like', '%' .  $search . '%')
				 -> orWhere('tb_nfe.id', 'like', '%' . $search . '%')
				 -> orWhere('tb_fornecedor.nome', 'like', '%' . $search . '%');

		}

		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0) {
			$get  -> orderBy($this -> order[$_GET['order'][0]['column']], $_GET['order'][0]['dir']);
		} else {
			$get  -> orderBy($this -> order[6], 'ASC');
		}

		if ( isset($_GET['length'])) {
			$get  -> limit($_GET['length']);
		}

		if ( isset($_GET['start']) ) {
			$get  -> offset($_GET['start']);
		}

		return $get;

	}

	public function getCount() {
		return $this -> all();
	}

	public function insertNFe($nfe, $file) {

		$id = null;
		$nf = $this -> nfe -> fill($nfe);

		$this -> nfe -> setFileName($file);

		$hasNFe = $this -> select('id')
							-> from('tb_nfe')
							-> where('id', $nf -> getInfNFeId())
							-> first();

		if ( ! isset($hasNFe) ) {

			$data = array(
				'id' => $nf -> getInfNFeId(),
				'versao' => $nf -> getVersao(),
				'versao2' => $nf -> getVersao2(),
				'cUF' => $nf -> getCUF(),
				'cNF' => $nf -> getCNF(),
				'natOp' => $nf -> getNatOp(),
				'mod' => $nf -> getMod(),
				'serie' => $nf -> getSerie(),
				'nNF' => $nf -> getNNF(),
				'dhEmi' => $nf -> getDhEmi(),
				'dhSaiEnt' => $nf -> getDhSaiEnt(),
				'tpNf' => $nf -> getTpNf(),
				'idDest' => $nf -> getIdDest(),
				'cMunFG' => $nf -> getCMunFG(),
				'tpImp' => $nf -> getTpImp(),
				'tpEmis' => $nf -> getTpEmis(),
				'cDV' => $nf -> getCDV(),
				'cEmi' => $nf -> getCEmi(),
				'cDest' => $nf -> getCDest(),
				'tpAmb' => $nf -> getTpAmb(),
				'chNFe' => $nf -> getChNFe(),
				'dhRecbto' => $nf -> getDhRecbto(),
				'nProt' => $nf -> getNProt(),
				'digVal' => $nf -> getNProt(),
				'cStat' => $nf -> getCStat(),
				'xMotivo' => $nf -> getXMotivo(),
				'vBC' => $nf -> getVBC(),
				'vICMS' => $nf -> getVICMS(),
				'vICMSDeson' => $nf -> getVICMSDeson(),
				'vFCP' => $nf -> getVFCP(),
				'vBCST' => $nf -> getVBCST(),
				'vST' => $nf -> getVST(),
				'vFCPST' => $nf -> getVFCPST(),
				'vFCPSTRet' => $nf -> getVFCPSTRet(),
				'vProd' => $nf -> getVProd(),
				'vFrete' => $nf -> getFrete(),
				'vSeg' => $nf -> getVSeg(),
				'vDesc' => $nf -> getVDesc(),
				'vII' => $nf -> getVII(),
				'vIPI' => $nf -> getVIPI(),
				'vIPIDevol' => $nf -> getVIPIDevol(),
				'vPIS' => $nf -> getVPIS(),
				'vCOFINS' => $nf -> getVCOFINS(),
				'vOutro' => $nf -> getVOutro(),
				'vNF' => $nf -> getVNF(),
				'vTotTrib' => $nf -> getVTotTrib(),
				'modFrete' => $nf -> getModFrete(),
				'cTransportadora' => $nf -> getTransportadora(),
				'veicTranspPlaca' => $nf -> getVeicTranspPlaca(),
				'veicTranspUF' => $nf -> getVeicTranspUF(),
				'qVol' => $nf -> getQVol(),
				'nVol' => $nf -> getNVol(),
				'pesoL' => $nf -> getPesoL(),
				'pesoB' => $nf -> getPesoB(),
				'nFat' => $nf -> getNFat(),
				'vOrig' => $nf -> getVOrig(),
				'vDescFat' => $nf -> getVDescFat(),
				'vLiq' => $nf -> getVLiq(),
				'indPag' => $nf -> getIndPag(),
				'tPag' => $nf -> getTPag(),
				'vPag' => $nf -> getVPag(),
				'xml_file' => $nf -> getFileName()
			);

			DB::beginTransaction();

			$id =  $nf -> getInfNFeId();
			$this -> insert($data);

			if ( $id ) $this -> insertDuplicatas($id);

			DB::commit();

		} else {

			$id = $hasNFe -> id;

		}

		return $id;

	}

	public function insertDuplicatas($id) {

		if ( $this -> nfe -> issetDup() ) {

			$data = [];
			$duplicatas = $this -> nfe -> getDup();

			foreach ($duplicatas as $dup) {

				$data[] = [
					'id_nfe' =>  (string) $id,
					'nDup' => (string) $dup -> nDup,
					'dVenc' => (string) $dup -> dVenc,
					'vDup' => (string) $dup -> vDup
				];

			}

			$this -> from('tb_nfe_duplicata') -> insert($data);

		}


	}

	/**
	 *
	 * public function getNFeBySupplier($supplier) {
	 *
	 *	return $this -> select(
	 *						'N.id',
	 *						'N.cEmi',
	 *						'N.cDest',
	 *						'N.nNF',
	 *						'N.serie',
	 *						'N.vBC',
	 *						'N.tPag',
	 *						'N.chNFe',
	 *						DB::raw('(SELECT COUNT(cEmi) from tb_nfe WHERE cEmi = N.cEmi) AS totalNFe'),
	 *						DB::raw('(SELECT SUM(vPag) from tb_nfe WHERE cEmi = N.cEmi) AS totalPago'),
	 *						DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = cDest) AS nome')
	 *					)
	 *				 -> from('tb_nfe AS N')
	 *				//  -> join('tb_fornecedor AS F', 'F.cnpj', '=', 'N.cDest')
	 *				-> where('N.cEmi', $supplier)
	 *				// -> groupBy('N.cEmi')
	 *				 -> get();
	 *
	 * }
	 */

	public function getNFeBySupplier($supplier) {

		return $this -> select(
							'N.id',
							'N.cDest',
							'N.cEmi',
							'N.nNF',
							'N.serie',
							'N.vBC',
							'N.vPag',
							'N.chNFe',
							DB::raw('(SELECT descricao FROM tb_tipo_pagamento WHERE codigo = N.tPag) AS tPag'),
							DB::raw('(SELECT nome FROM tb_fornecedor WHERE cnpj = N.cDest) AS nome'),
							DB::raw('(SELECT COUNT(id) FROM tb_nfe_duplicata WHERE id_nfe = N.id) AS totalDup')
						)
					 -> from('tb_nfe AS N')
					 -> where('N.cEmi', $supplier);

	}

	public function getNFeById($chNFe) {

		return $this -> select(
							'*',
							'tb_nfe.id AS idNFe', DB::raw('(SELECT descricao FROM tb_tipo_pagamento WHERE codigo = tb_nfe.tPag) AS tPag')
						)
					 -> from('tb_nfe') -> join('tb_fornecedor AS F', 'F.cnpj', '=', 'tb_nfe.cEmi')
					 -> where('chNFe', $chNFe)
					 -> first();

	}

	public function getDuplicatasByNFe($nfe) {
		return $this -> from('tb_nfe_duplicata') -> where('id_nfe', $nfe) -> get();
	}

}
