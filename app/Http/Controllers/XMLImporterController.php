<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\XMLImporter;

class XMLImporterController extends Controller
{

    public function __construct()
    {
     
       $this -> xml_model = new XMLImporter();

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
    public function import() {

        echo ('<pre>');
        print_r($_FILES);

    }

}
