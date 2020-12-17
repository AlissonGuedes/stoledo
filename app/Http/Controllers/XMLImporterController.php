<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\XMLImporterModel;

use App\Http\Controllers\NFeController;

class XMLImporterController extends Controller
{

    public function __construct()
    {

        $this -> nfe = new NFeController;
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
               
               
                $this -> readFile($name);

            }

            return 'Importação finalizada!!!';

        }

        else {
            return 'Arquvios inválidos';
        }

    }

    /**
     * Start reading the file line by line
     */
    public function readFile($file) {

        $xml = simplexml_load_file('../storage/app/public/files/xml/' . $file);

        $this -> nfe -> getId($xml);

    }

}
