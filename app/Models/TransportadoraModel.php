<?php

namespace App\Models {

    use App\Http\Middleware\Authenticate;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	use Illuminate\Notifications\Notifiable;

	use App\Models\Entities\Transportadora;

	class TransportadoraModel extends Authenticatable {

		use HasFactory, Notifiable;

		protected $fillable = [];

		protected $hidden = [];

		protected $casts = [];

		protected $table = 'tb_transportadora';

		public function __construct() {
			$this -> transportadora = new Transportadora();
		}

		public function insertTransportadora($transp) {

			if ( empty($transp) )
				return false;

			$transportadora = $this -> transportadora -> fill($transp);

			$hasTransportadora = $this -> select('id', 'cnpj', 'xNome', 'ie', 'xEnder', 'xMun', 'uf')
								   -> from('tb_transportadora')
								   -> where('cnpj', $transportadora -> getCNPJ())
								   -> first();

			if ( ! isset($hasTransportadora) ) {

				$data = array(
					'cnpj' => $transportadora -> getCNPJ(),
					'xNome' => $transportadora -> getXNome(),
					'ie' => $transportadora -> getIE(),
					'xEnder' => $transportadora -> getXEnder(),
					'xMun' => $transportadora -> getXMun(),
					'uf' => $transportadora -> getUF(),
				);

				$this -> insert($data);

			}

			// return $hasTransportadora -> id;

		}

	}

}
