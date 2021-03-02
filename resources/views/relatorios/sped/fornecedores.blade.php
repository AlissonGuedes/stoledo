 @extends('layouts.app')

 @php
     if (!isset($row)):
         header('Location: ' . url('reports/sped'));
         die();
     endif;
 @endphp

 @section('container')

     <!-- Header search bar starts -->
     <div class="row">

         <div class="col s6">

             <div class="page_title">
                 <button data-href="{{ route('reports.sped') }}"
                     class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
                     <i class="material-icons black-text">arrow_back</i>
                 </button>
                 <h5>{{ cnpj($row->cnpj) }} - {{ $row->nome }}</h5>
             </div>

         </div>

         <div class="col s6">
             <div class="input-field">
                 <i class="material-icons prefix">search</i>
                 <label for="">Pesquisar arquivo</label>
                 <input type="search" class="dataTable_search black-text">
             </div>
         </div>

     </div>
     <!-- Header search bar Ends -->

     <div class="row">

         <table class="datatable"
             data-link="{{ url('reports/sped/' . $row->cnpj . '/' . convert_to_date($row->dt_ini, 'dmY') . '-' . convert_to_date($row->dt_fin, 'dmY')) }}">

             <thead>
                 <tr>
                     <th class="disabled" width="1%" data-orderable="false">
                         <label>
                             <input type="checkbox" class="amber" id="check-all" disabled>
                             <span> </span>
                         </label>
                     </th>
                     <th class="center-align">CNPJ</th>
                     <th class="center-align" data-class="left-align">Nome</th>
                     <th class="center-align" data-class="right-align">Aquisições</th>
                     <th class="center-align" data-class="center-align" data-orderable="false">Qtd. Notas</th>
                     <th class="center-align" data-class="center-align" data-orderable="false">Não Escrituradas</th>
                     <th data-class="center-align hide-on-large-only" data-orderable="false">Não Escrituradas</th>
                 </tr>
             </thead>

         </table>

     </div>

 @endsection
