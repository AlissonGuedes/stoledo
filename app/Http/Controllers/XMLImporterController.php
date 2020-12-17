<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\XMLImporterModel;

class XMLImporterController extends Controller
{

    public function __construct()
    {

       $this -> xml_model = new XMLImporterModel();

    }

    /**
     * Show the system home page
     */
    public function index() {

        $dados['xml'] = $this -> xml_model -> getXML();
        return view('index', $dados);

    }

    /**
     * Run from the import process
     */
    public function import(Request $request) {

        if( $request -> hasFile('files') && $request -> file('files') ) 
        {

            foreach ( $request -> file('files') as $file ) {

                $name = $file -> getClientOriginalName();
                $file -> storeAs('public/files/' . $file -> getClientOriginalExtension(), $name);

            }

            return 'Importação finalizada!!!';

        }

        else {
            return 'Arquvios inválidos';
        }

    }

}
