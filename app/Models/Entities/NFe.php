<?php

namespace App\Models\Entities {

	use \App\Models\Entities\AppEntity;

	class NFe extends AppEntity {

		private $versao;
		private $Id;
		private $cUF;
		private $mod;
		private $chNFe;

		public function setId($id) {
			$this -> Id = $id;
			return $this;
		}

		public function getId() {
			return $this -> id;
		}

		public function setVersao($ver) {
			$this -> versao = $ver;
		}

		public function setCUF($nfe) {
			$this -> cUF = $nfe;
			return $this;
		}

		public function getCUF() {
			return $this -> infNFe -> ide -> cUF ?? null;
		}

		public function setCNF($nfe) {
			$this -> cNF = $nfe;
			return $this;
		}

		public function getCNF() {
			return $this -> infNFe -> ide -> cNF ?? null;
		}

		public function setNatOp($nfe) {
			$this -> natOp = $nfe;
			return $this;
		}

		public function getNatOp() {
			return $this -> infNFe -> ide -> natOp ?? null;
		}

		public function setMod($nfe) {
			$this -> mod = $nfe;
			return $this;
		}

		public function getMod() {
			return $this -> infNFe -> ide -> mod ?? null;
		}

		public function setSerie($nfe) {
			$this -> serie = $nfe;
			return $this;
		}

		public function getSerie() {
			return $this -> infNFe -> ide -> serie ?? null;
		}

		public function setNNF($nfe) {
			$this -> nNF = $nfe;
			return $this;
		}

		public function getNNF() {
			return $this -> infNFe -> ide -> nNF ?? null;
		}

		public function setDhEmi($nfe) {
			$this -> dhEmi = $nfe;
			return $this;
		}

		public function getDhEmi() {
			return isset($this -> infNFe -> ide -> dhEmi) ? date('Y-m-d H:i:s', strtotime($this -> infNFe -> ide -> dhEmi)) : null;
		}

		public function setDhSaiEnt($nfe) {
			$this -> dhSaiEnt = $nfe;
			return $this;
		}

		public function getDhSaiEnt() {
			return isset($this -> infNFe -> ide -> dhSaiEnt) ? date('Y-m-d H:i:s', strtotime($this -> infNFe -> ide -> dhSaiEnt)) : null;
		}

		public function setTpNF($nfe) {
			$this -> tpNF = $nfe;
			return $this;
		}

		public function getTpNF() {
			return $this -> infNFe -> ide -> tpNF ?? null;
		}

		public function setIdDest($nfe) {
			$this -> idDest = $nfe;
			return $this;
		}

		public function getIdDest() {
			return $this -> infNFe -> ide -> idDest ?? null;
		}

		public function setCMunFG($nfe) {
			$this -> cMunFG = $nfe;
			return $this;
		}

		public function getCMunFG() {
			return $this -> infNFe -> ide -> cMunFG ?? null;
		}

		public function setTpImp($nfe) {
			$this -> tpImp = $nfe;
			return $this;
		}

		public function getTpImp() {
			return $this -> infNFe -> ide -> tpImp ?? null;
		}

		public function setTpEmis($nfe) {
			$this -> tpEmis = $nfe;
			return $this;
		}

		public function getTpEmis() {
			return $this -> infNFe -> ide -> tpEmis ?? null;
		}

		public function setCDV($nfe) {
			$this -> cDV = $nfe;
			return $this;
		}

		public function getCDV() {
			return $this -> infNFe -> ide -> cDV ?? null;
		}

		public function setTpAmb($nfe) {
			$this -> tpAmb = $nfe;
			return $this;
		}

		public function getTpAmb() {
			return $this -> protNFe -> tpAmb ?? null;
		}

		public function setFinNFe($nfe) {
			$this -> finNFe = $nfe;
			return $this;
		}

		public function getFinNFe() {
			return $this -> infNFe -> ide -> finNFe ?? null;
		}

		public function setIndFinal($nfe) {
			$this -> indFinal = $nfe;
			return $this;
		}

		public function getIndFinal() {
			return $this -> infNFe -> ide -> indFinal ?? null;
		}

		public function setIndPres($nfe) {
			$this -> indPres = $nfe;
			return $this;
		}

		public function getIndPres() {
			return $this -> infNFe -> ide -> indPres ?? null;
		}

		public function setProcEmi($nfe) {
			$this -> procEmi = $nfe;
			return $this;
		}

		public function getProcEmi() {
			return $this -> infNFe -> ide -> procEmi ?? null;
		}

		public function setVerProc($nfe) {
			$this -> verProc = $nfe;
			return $this;
		}

		public function getVerProc() {
			return $this -> infNFe -> ide -> verProc ?? null;
		}

		public function getCEmi() {
			return $this -> infNFe -> emit ->  CNPJ ?? null;
		}

		public function getCDest() {
			return $this -> infNFe -> dest -> CNPJ ?? null;
		}

		// Tags do XML -------------------------------------------------------

		private $protNFe;
		private $infNFe;
		private $total;

		public function setInfProt($nfe) {
			$this -> protNFe = $nfe;
		}

		public function getInfProt() {
			return $this -> protNFe;
		}

		public function setInfNFe($nfe) {
			return $this -> infNFe = $nfe;
		}

		public function getInfNFe() {
			return $this -> infNFe;
		}

		// Informações da Nota -------------------------------------------------------

		public function getInfNFeId() {
			return $this -> infNFe -> attributes() -> Id;
		}

		public function getVersao() {
			return $this -> infNFe -> attributes() -> versao;
		}

		public function getVersao2() {
			// return $this -> infNFe -> ide -> versao2;
		}

		public function getChNFe() {
			return $this -> protNFe -> chNFe;
		}

		public function getDhRecbto() {
			return isset($this -> protNFe -> dhRecbto) ? date('Y-m-d H:i:s', strtotime($this -> protNFe -> dhRecbto)) : null;
		}

		public function getNProt() {
			return $this -> protNFe -> nProt;
		}

		public function getDigVal() {
			return $this -> protNFe -> digVal;
		}

		public function getCStat() {
			return $this -> protNFe -> cStat;
		}

		public function getXMotivo() {
			return $this -> protNFe -> xMotivo;
		}

		// Valores -------------------------------------------------------

		public function setTotal($nfe) {
			$this -> total = $nfe -> infNFe -> total;
		}

		public function getTotal() {
			return $this -> total;
		}

		public function getVBC() {
			return $this -> infNFe -> total -> ICMSTot -> vBC ?? 0;
		}

		public function getVICMS() {
			return $this -> infNFe -> total -> ICMSTot -> vICMS ?? 0;
		}

		public function getVICMSDeson() {
			return $this -> infNFe -> total -> ICMSTot -> vICMSDeson ?? 0;
		}

		public function getVFCP() {
			return $this -> infNFe -> total -> ICMSTot -> vFCP ?? 0;
		}

		public function getVBCST() {
			return $this -> infNFe -> total -> ICMSTot -> vBCST ?? 0;
		}

		public function getVST() {
			return $this -> infNFe -> total -> ICMSTot -> vST ?? 0;
		}

		public function getVFCPST() {
			return $this -> infNFe -> total -> ICMSTot -> vFCPST ?? 0;
		}

		public function getVFCPSTRet() {
			return $this -> infNFe -> total -> ICMSTot -> vFCPSTRet ?? 0;
		}

		public function getVProd() {
			return $this -> infNFe -> total -> ICMSTot -> vProd ?? 0;
		}

		public function getFrete() {
			return $this -> infNFe -> total -> ICMSTot -> vFrete ?? 0;
		}

		public function getVSeg() {
			return $this -> infNFe -> total -> ICMSTot -> vSeg ?? 0;
		}

		public function getVDesc() {
			return $this -> infNFe -> total -> ICMSTot -> vDesc ?? 0;
		}

		public function getVII() {
			return $this -> infNFe -> total -> ICMSTot -> vII ?? 0;
		}

		public function getVIPI() {
			return $this -> infNFe -> total -> ICMSTot -> vIPI ?? 0;
		}

		public function getVIPIDevol() {
			return $this -> infNFe -> total -> ICMSTot -> vIPIDevol ?? 0;
		}

		public function getVPIS() {
			return $this -> infNFe -> total -> ICMSTot -> vPIS ?? 0;
		}

		public function getVCOFINS() {
			return $this -> infNFe -> total -> ICMSTot -> vCOFINS ?? 0;
		}

		public function getVOutro() {
			return $this -> infNFe -> total -> ICMSTot -> vOutro ?? 0;
		}

		public function getVNF() {
			return $this -> infNFe -> total -> ICMSTot -> vNF ?? 0;
		}

		public function getVTotTrib() {
			return $this -> infNFe -> total -> ICMSTot -> vTotTrib ?? 0;
		}

		public function getModFrete() {
			return $this -> infNFe -> transp -> modFrete ?? null;
		}

		public function getTransportadora() {
			return $this -> infNFe -> transp -> transporta -> CNPJ ?? null;
		}

		public function getVeicTranspPlaca() {
			return $this -> infNFe -> transp -> veicTransp -> placa ?? null;
		}

		public function getVeicTranspUF() {
			return $this -> infNFe -> transp -> veicTransp -> UF ?? null;
		}

		public function getQVol() {
			return $this -> infNFe -> transp -> vol -> qVol ?? null;
		}

		public function getNVol() {
			return $this -> infNFe -> transp -> vol -> nVol ?? null;
		}

		public function getPesoL() {
			return $this -> infNFe -> transp -> vol -> pesoL ?? null;
		}

		public function getPesoB() {
			return $this -> infNFe -> transp -> vol -> pesoB ?? null;
		}

		public function getNFat() {
			return $this -> infNFe -> cobr -> fat -> nFat ?? 0;
		}

		public function getVOrig() {
			return $this -> infNFe -> cobr -> fat -> vOrig ?? 0;
		}

		public function getVDescFat() {
			return $this -> infNFe -> cobr -> fat -> vDesc ?? 0;
		}

		public function getVLiq() {
			return $this -> infNFe -> cobr -> fat -> vLiq ?? 0;
		}

		public function issetDup() {

			return isset($this -> infNFe -> cobr -> dup);
		}

		public function getDup() {

			return $this -> infNFe -> cobr -> dup;

		}

		public function getDVenc() {
			return isset($this -> infNFe -> cobr -> dup -> dVenc) ? date('Y-m-d', strtotime($this -> infNFe -> cobr -> dup -> dVenc)) : null;
		}

		public function getVDup() {
			return $this -> infNFe -> cobr -> dup -> vDup ?? 0;
		}

		public function getIndPag() {
			return $this -> infNFe -> pag -> detPag -> indPag ?? 0;
		}

		public function getTPag() {
			return $this -> infNFe -> pag -> detPag -> tPag ?? 0;
		}

		public function getVPag() {
			return $this -> infNFe -> pag -> detPag -> vPag ?? 0;
		}

		private $file_name;

		public function setFileName($file) {
			$this -> file_name = $file;
		}

		public function getFileName() {
			return $this -> file_name;
		}

	}

}
