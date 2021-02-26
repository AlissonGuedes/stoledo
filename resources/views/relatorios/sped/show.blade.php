 @extends('layouts.app')

 <?php if (!isset($row)):
 header('Location: ' . url('reports/sped'));
 die();
 endif; ?>

 @section('container')

     <div>

         <!-- Header search bar starts -->
         <div class="page_title">

             <button data-href="{{ route('reports.sped') }}"
                 class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
                 <i class="material-icons black-text">arrow_back</i>
             </button>

             <h5>{{ cnpj($row->cnpj) }} - {{ $row->nome }}</h5>

         </div>
         <!-- Header search bar Ends -->

         <table class="datatable"
             data-link="{{ url('reports/sped/' . $row->cnpj . '/' . convert_to_date($row->dt_ini, 'dmY') . '-' . convert_to_date($row->dt_fin, 'dmY')) }}">

             <thead>
                 <tr>
                     <th class="disabled white-text" width="1%" data-orderable="false">
                         <label>
                             <input type="checkbox" class="amber" id="check-all" disabled>
                             <span> </span>
                         </label>
                     </th>
                     <th class="align-left">Chave NF-e</th>
                     <th>Nº NF-e</th>
                     <th>CNPJ</th>
                     <th>Emitente</th>
                     <th>V. Orig.</th>
                     <th>B. Cálculo</th>
                     <th>ICMS</th>
                     <th data-orderable="false"></th>
                 </tr>
             </thead>

         </table>

     </div>

 @endsection
