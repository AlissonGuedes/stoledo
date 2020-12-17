<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\NFeModel;

class NFeController extends Controller {

    public function __construct() {

    }

    public function getId($nfe) {

        return $nfe -> NFe -> infNFe -> attributes() -> Id;

    }

}