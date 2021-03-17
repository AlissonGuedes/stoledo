<?php

namespace App\Models\Entities {

	// use App\Models\Entities\Endereco;

	class Produto extends AppEntity {

		private $id;
		private $cProd;
		private $cEAN;
		private $xProd;
		private $ncm;
		private $cest;
		private $indEsacala;
		private $cfop;
		private $uCom;
		private $qCom;
		private $vUnCom;
		private $vProd;
		private $cEANTrib;

		// public function __construct() {
		// 	// $this -> endereco_model = new EnderecoModel();
		// }

		/** Obtém o código do produto */
		public function setCProd($cProd) {
			$this -> cProd = $cProd;
			return $this;
		}

		public function getCProd() {
			return $this -> cProd;
		}

		/** Obtém o Nome do Emitente */
		public function setCEAN($cEAN) {
			$this -> cEAN = $cEAN;
			return $this;
		}

		public function getCEAN() {
			return $this -> cEAN;
		}

		/** Obtém o Nome Fantasia do Emitente */
		public function setXProd($Prod = null) {
			$this -> xProd = $Prod;
			return $this;
		}

		public function getXProd() {
			return $this -> xProd;
		}

		/** Obtém o Endereço do Emitente */
		public function setNcm($ncm) {
			$this -> ncm = $ncm;
		}

		public function getNcm() {
			return $this -> ncm;
		}

		/** Obtém o Endereço do Emitente */
		public function setCfop($cfop) {
			$this -> cfop = $cfop;
		}

		public function getCfop() {
			return $this -> cfop;
		}

		/** Obtém o número do endereço */
		public function setUCom($uCom) {
			return $this -> uCom = $uCom;
		}

		public function getUCom(){
			return $this -> uCom;
		}

		/** Obtém o número do telefone */
		public function setQCom($qCom = null) {
			$this -> qCom = $qCom;
		}

		public function getQCom() {
			return $this -> qCom;
		}
	
		/** Obtém o número do telefone */
		public function setVUnCom($vUnCom = null) {
			$this -> vUnCom= $vUnCom;
		}

		public function getVUnCom() {
			return $this -> vUnCom;
		}

		/** Obtém IE */
		public function setVProd($vProd) {
			$this -> vProd = $vProd;
		}

		public function getVProd() {
			return $this -> vProd;
		}

		/** Obtém o IND IE do Destinatário */
		public function setCEANTrib($cEANTrib) {
			$this -> cEANTrib = $cEANTrib;
		}

		public function getCEANTrib() {
			return $this -> cEANTrib;
		}

		/** Obtém CRT */
		public function setUTrib($uTrib) {
			$this -> uTrib = $uTrib;
		}

		public function getUTrib() {
			return $this -> uTrib;
		}
	
	}

}