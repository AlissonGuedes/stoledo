<?php

namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ConfigModel extends Authenticatable
{

    use HasFactory, Notifiable;

	protected $table = 'tb_sys_config';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	private $order = [
		null,
		'descricao',
		'status',
	];

	public function getConfig($find = null) {

		$get = $this -> select('id', 'config', 'value');

		if ( !is_null($find) ) {
			$get -> where('config', $find);
			$get -> orWhere('id', $find);
			return $get ;
		}

		// if (isset($_GET['search']['value']) && !empty($_GET['search']['value'])) {
        //     $get->where(function ($get) {
        //         $search = $_GET['search']['value'];
        //         $get->orWhere('id', 'like', $search . '%')
        //             ->orWhere('config', 'like', $search . '%')
        //             ->orWhere('value', 'like', $search . '%');
        //     });
        // }

		// Order By
		if (isset($_GET['order']) && $_GET['order'][0]['column'] != 0 ) {
			$orderBy[$this -> order[$_GET['order'][0]['column']]] = $_GET['order'][0]['dir'];
		} else {
			$orderBy[$this -> order[1]] = 'desc';
		}

		foreach($orderBy as $key => $val) {
			$get -> orderBy($key, $val);
		}

		return $get -> paginate($_GET['length'] ?? null);

	}

	public function create($request) {

		$data   = [];
		$path = 'assets/embaixada/img/configracoes/';
		$origName = null;
		$fileName = null;
		$imagem = null;

		if ( $request -> file('site_logo') ){

			$file = $request -> file('site_logo');

			$fileName = sha1($file -> getClientOriginalName());
			$fileExt  = $file -> getClientOriginalExtension();

			$imgName  = explode('.', ($file -> getClientOriginalName()));

			$origName = limpa_string($imgName[count($imgName) - 2], '_') . '.' . $fileExt;
			$imagem = limpa_string($fileName) . '.' . $fileExt;

			$file -> storeAs($path, $imagem);

		}

		$traducao	= [];

		// Salva a imagem da logo
		$data[] = ['config' => 'site_logo', 'value' => (!is_null($imagem) ? $path . $imagem : null)];
		$data[] = ['config' => 'original_logo_name', 'value' =>  (!is_null($imagem) ? $origName : null)];

		foreach($_POST as $ind => $val) {
			if($ind !== 'site_logo')
				$data[] = ['config' => $ind, 'value' => (!empty($val) ? $val : null)];
		}

		for ( $i = 0; $i < count($data); $i ++ ) {

			$issetConfig = $this -> select('config', 'value') -> where('config', $data[$i]['config']) -> first();

			if( isset($issetConfig) ) {
				if ( $data[$i]['value'] != $issetConfig -> value){
					$this -> where('config', $data[$i]['config']) -> update($data[$i]);
				}
			} else {
				$this -> insert($data[$i]);
			}

		}

		return true;

	}

}
