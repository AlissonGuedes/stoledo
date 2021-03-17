<?php

namespace App\Models\Entities {

	use App\Models\Entities\Endereco;
	use App\Models\EnderecoModel;

	class Transportadora extends AppEntity {

		private $cnpj;
		private $xNome;
		private $xEnder;
		private $xMun;
		private $IE;
		private $UF;

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

		/** Obtém IE */
		public function setIE($ie) {
			$this -> IE = $ie;
		}

		public function getIE() {
			return $this -> IE;
		}

		/** Obtém o Endereço do Emitente */
		public function setXEnder($endereco) {
			$this -> xEnder = $endereco;
		}

		public function getXEnder() {
			return $this -> xEnder;
		}

		/** Obtém o IND IE do Destinatário */
		public function setXMun($xMun) {
			$this -> xMun = $xMun;
		}

		public function getXMun() {
			return $this -> xMun;
		}

		/** Obtém CRT */
		public function setUF($uf) {
			$this -> UF = $uf;
		}

		public function getUF() {
			return $this -> UF;
		}
	}

}