<?php

namespace App\Models\Entities {

	use \App\Models\Entities\AppEntity;

	class NFe extends AppEntity {

		private $versao;
		private $Id;
		private $cUF;
		private $mod;

		public function getData($xml) {
	
			// $this -> setVersao($xml -> NFe -> infNFe -> attributes() -> versao);
	        $this -> fill($xml -> NFe -> infNFe -> ide);

			return $this;

		}
	
		public function setVersao($ver) {
			$this -> versao = $ver;
		}

		public function getVersao() {
			return $this -> versao;
		}

		public function setId($id) {
			$this -> Id = $id;
			return $this;
		}

		public function getId() {
			return $this -> id;
		}

		public function setCUF($nfe) {
			$this -> cUF = $nfe;
			return $this;
		}

		public function getCUF() {
			return $this -> cUF;
		}

		public function setCNF($nfe) {
			$this -> cNF = $nfe;
			return $this;
		}

		public function getCNF() {
			return $this -> cNF;
		}

		public function setNatOp($nfe) {
			$this -> natOp = $nfe;
			return $this;
		}

		public function getNatOp() {
			return $this -> natOp;
		}

		public function setMod($nfe) {
			$this -> mod = $nfe;
			return $this;
		}

		public function getMod() {
			return $this -> mod;
		}

		public function setSerie($nfe) {
			$this -> serie = $nfe;
			return $this;
		} 

		public function getSerie() {
			return $this -> serie;
		}

		public function setNNF($nfe) {
			$this -> nNF = $nfe;
			return $this;
		}

		public function getNNF() {
			return $this -> nNF;
		}

		public function setDhEmi($nfe) {
			$this -> dhEmi = $nfe;
			return $this;
		}

		public function getDhEmi() {
			return $this -> dhEmi;
		}

		public function setDhSaiEnt($nfe) {
			$this -> dhSaiEnt = $nfe;
			return $this;
		}

		public function getDhSaiEnt() {
			return $this -> dhSaiEnt;
		}

		public function setTpNF($nfe) {
			$this -> tpNF = $nfe;
			return $this;
		}

		public function getTpNF() {
			return $this -> tpNF;
		}

		public function setIdDest($nfe) {
			$this -> idDest = $nfe;
			return $this;
		}

		public function getIdDest() {
			return $this -> idDest;
		}

		public function setCMunFG($nfe) {
			$this -> cMunFG = $nfe;
			return $this;
		}

		public function getCMunFG() {
			return $this -> cMunFG;
		}

		public function setTpImp($nfe) {
			$this -> tpImp = $nfe;
			return $this;
		}

		public function getTpImp() {
			return $this -> tpImp;
		}

		public function setTpEmis($nfe) {
			$this -> tpEmis = $nfe;
			return $this;
		}

		public function getTpEmis() {
			return $this -> tpEmis;
		}

		public function setCDV($nfe) {
			$this -> cDV = $nfe;
			return $this;
		}

		public function getCDV() {
			return $this -> cDV;
		}

		public function setTpAmb($nfe) {
			$this -> tpAmb = $nfe;
			return $this;
		}

		public function getTpAmb() {
			return $this -> tpAmb;
		}

		public function setFinNFe($nfe) {
			$this -> finNFe = $nfe;
			return $this;
		}

		public function getFinNFe() {
			return $this -> finNFe;
		}

		public function setIndFinal($nfe) {
			$this -> indFinal = $nfe;
			return $this;
		}
		
		public function getIndFinal() {
			return $this -> indFinal;
		}

		public function setIndPres($nfe) {
			$this -> indPres = $nfe;
			return $this;
		}

		public function getIndPres() {
			return $this -> indPres;
		}

		public function setProcEmi($nfe) {
			$this -> procEmi = $nfe;
			return $this;
		}

		public function getProcEmi() {
			return $this -> procEmi;
		}

		public function setVerProc($nfe) {
			$this -> verProc = $nfe;
			return $this;
		}

		public function getVerProc() {
			return $this -> verProc;
		}
	}

}