<?php


namespace App\Models\Entities {


	class AppEntity {

		public $attributes = array();

		public function fill($data) {

			$this -> attributes = [];

			if ( !$data )
				return FALSE;
			
			// Obter os dados vindos do formulário
			foreach ( $data as $key)
			{

				foreach ($key as $k => $v) {

					$set = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], '', $k)));
					$get = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], '', $k)));

					if ( method_exists($this, $set) && method_exists($this, $get) )
					{

						$this -> $set($key -> $k);

						$this -> attributes[$k]= $this -> $get();
						
						// if ( ! is_array($k) )
						// {
						// 	$this -> $set($data[$key]);
						// 	$this -> attributes[$k] = $this -> $get();
						// }
						// else
						// {

						// 	if ( isset($_POST[$key]) )
						// 	{
						// 		$this -> $set($val);
						// 		$this -> attributes[$k] = $this -> $get();
						// 	}
						// 	elseif ( isset($_FILES[$key]) )
						// 	{
						// 		$this -> $set($data);
						// 		$this -> attributes[$k] = $this -> $get();
						// 	}

						// }

					}

				}

			}

// print_r($this->attributes);

			// foreach($this -> attributes as $key => $val) {

			// 	// $this -> attributes[$key] = $val;
			// }

			return $this ;

		}

	}

}