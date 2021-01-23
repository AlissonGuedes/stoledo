<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\XMLImporterModel;
use App\Http\Controllers\NFeController;

use App\Models\Entities\NFe;
use App\Models\FornecedorModel;

class XMLImporterController extends Controller
{

    public function __construct() {

		$this -> xml_model = new XMLImporterModel();
		$this -> nfe = new NFe();
        $this -> fornecedor_model = new FornecedorModel();

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

		/**
		 * (...) Primeiro, iremos ler os dados da NFe e salvá-los no Banco
		 */
		// $this -> nfe -> getData($xml);
		// $this -> nfe -> setVersao($xml -> NFe -> infNFe -> attributes() -> versao);

        // Cadastrar fornecedor/emitente da nota fiscal
        $this -> fornecedor_model -> insertFornecedor($xml -> NFe -> infNFe -> emit);

        // Cadastrar o destinatário da nota fiscal. Basicamente, são as mesmas informações.
        $this -> fornecedor_model -> insertDestinatario($xml -> NFe -> infNFe -> dest);

		// $this -> nfe -> fill($xml -> NFe -> infNFe -> ide);

		echo '<br>==========================================<br>';


    }

}
