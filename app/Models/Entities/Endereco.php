<?php

namespace App\Models\Entities {

	class Endereco extends AppEntity {

		private $xBairro;
		private $cMun;
		private $xMun;
		private $UF;
		private $CEP;
		private $cPais;
		private $xPais;

		/** Obtém a String do Bairro */
		public function setXBairro() {
			return $this -> xBairro;
		}

		public function getXBairro() {
			return $this -> xBairro;
		}

		/** Obtém o código do Município */
		public function setCMun() {
			return $this -> cMun;
		}

		public function getCMun() {
			return $this -> cMun;
		}

		/** Obtém a String do Município */
		public function setXMun() {
			return $this -> xMun;
		}

		public function getXMun() {
			return $this -> xMun;
		}

		/** Obtém a sigla do Estado */
		public function setUF($endereco) {
			return $this -> UF = $endereco -> UF;
		}

		public function getUF() {
			return $this -> UF;
		}

		/** Obtém o CEP */
		public function setCEP($endereco) {
			return $this -> CEP = $endereco -> CEP;
		}

		public function getCEP() {
			return $this -> CEP;
		}

		/** Obtém o código do País */
		public function setCPais($endereco) {
			$this -> cPais = $endereco -> cPais;
		}

		public function getCPais() {
			return $this -> cPais;
		}

		/** Obtém a String do País */
		public function setXPais($endereco) {
			$this -> xPais = $endereco -> xPais;
		}

		public function getXPais() {
			return $this -> xPais;
		}

	}
}
