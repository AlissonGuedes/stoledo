<?php

namespace App\Models\Entities {

	use App\Models\Entities\Endereco;
	use App\Models\EnderecoModel;

	class Fornecedor extends AppEntity {

		private $cnpj;
		private $xNome;
		private $xFant;
		private $enderEmit;
		private $nro;
		private $fone;
		private $email;
		private $IE;
		private $indIEDest;
		private $CRT;

		public function __construct() {
			$this -> endereco_model = new EnderecoModel();
		}

		/** Obtém o CNPJ do Emitente */
		public function setCNPJ($cnpj) {
			$this -> cnpj = $cnpj;
			return $this;
		}

		public function getCNPJ() {
			return $this -> cnpj;
		}

		/** Obtém o Nome do Emitente */
		public function setXNome($nome) {
			$this -> xNome = $nome;
			return $this;
		}

		public function getXNome() {
			return $this -> xNome;
		}

		/** Obtém o Nome Fantasia do Emitente */
		public function setXFant($nome = null) {
			$this -> xFant = $nome;
			return $this;
		}

		public function getXFant() {
			return $this -> xFant;
		}

		/** Obtém o Endereço do Emitente */
		public function setEnderEmit($endereco) {
			$this -> enderEmit = $endereco;
		}

		public function getEnderEmit($field = null) {

			if ( ! is_null($field) )
				return $this -> enderEmit[$field];

			return $this -> enderEmit;

		}

		/** Obtém o Endereço do Emitente */
		public function setEnderDest($endereco) {
			$this -> enderDest = $this -> endereco_model -> insertLogradouro($endereco);
		}

		public function getEnderDest($field = null) {

			if ( ! is_null($field) )
				return $this -> enderDest[$field];

			return $this -> enderDest;

		}

		/** Obtém o número do endereço */
		public function setNro($nro) {
			return $this -> nro = $nro;
		}

		public function getNro(){
			return $this -> nro;
		}
	
		/** Obtém o número do telefone */
		public function setFone($fone = null) {
			$this -> fone = $fone;
		}

		public function getFone() {
			return $this -> fone;
		}

		/** Obtém o número do telefone */
		public function setEmail($email = null) {
			$this -> email = $email;
		}

		public function getEmail() {
			return $this -> email;
		}

		/** Obtém IE */
		public function setIE($ie) {
			$this -> IE = $ie;
		}

		public function getIE() {
			return $this -> IE;
		}

		/** Obtém o IND IE do Destinatário */
		public function setIndIEDest($ie) {
			$this -> indIEDest = $ie;
		}

		public function getIndIEDest() {
			return $this -> indIEDest;
		}

		/** Obtém CRT */
		public function setCRT($crt) {
			$this -> CRT = $crt;
		}

		public function getCRT() {
			return $this -> CRT;
		}
	}

}