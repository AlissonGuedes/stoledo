 @extends('layouts.app')

<?php
 if (!isset($row)):

 	header('Location: ' . url('reports/sped'));
	die();

 endif;
 ?>

 @section('container')

     <div>

         <!-- Header search bar starts -->
         <div class="page_title">

             <button data-href="{{ route('reports.sped') }}"
                 class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
                 <i class="material-icons black-text">arrow_back</i>
             </button>

             <h5>{{ cnpj($row -> cnpj) }} - {{ $row->nome }}</h5>

         </div>
         <!-- Header search bar Ends -->

         <table class="">

             <thead>
                 <tr>
                     <th>Chave NF-e</th>
                     <th>Nº NF-e</th>
                     <th>CNPJ</th>
                     <th>Emitente</th>
                     <th>V. Orig.</th>
                     <th>V. Base Cálculo</th>
                     <th>ICMS21</th>
                     <th></th>
                 </tr>
             </thead>

         </table>

     </div>

 @endsection
