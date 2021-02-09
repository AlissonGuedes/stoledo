<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ImportModel;

class ImportsController extends Controller {

    public function __construct() {

        $this -> import_model = new ImportModel();

    }

    /**
     * Show the system home page
     */
    public function index() {

        return view('imports.index');

    }

    /** Importação do arquivo SPED Fiscal */
    public function import(Request $request){

        foreach ( $request -> file('files') as $file) {

            switch( $file -> getClientOriginalExtension() ) {
                case 'xml' :
                    $this -> import_model -> import_nfe($file);
                break;

                case 'txt':
                    $this -> import_model -> import_sped($file);
                break;

                default:
                    return json_encode(['status' => 'error', 'message' => 'Você inseriu arquivos válidos. Utilize apenas TXT ou XML.' ]);
                break;

            }

        }

        return json_encode(['status' => 'success', 'message' => 'Importação finalizada com sucesso!']);

    }

    // public function import_sped($file = null) {

    //     // $campo = explode('|', $file);

    //     // foreach( $campo as $ind => $val ) {
    //         // echo $ind . ' ----- ' . $val . "\t";
    //     // }
    //     // print_r($file);
    //     // $this -> import_model -> insertSped($file);

    //     echo json_encode(['status' => 'error', 'message' => 'Esta página não foi disponibilizada']);

    // }


}
