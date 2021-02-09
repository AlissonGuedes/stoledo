@extends('layouts.app')

<?php if (!isset($row)):
header('Location: ' . url('reports/fornecedores'));
die();
endif; ?>

@section('container')

    <!-- Header search bar starts -->
    <div class="page_title">

        <button data-href="{{ route('reports.fornecedores') }}"
            class="btn btn-floating waves-effect transparent white-text bt_ac btn-flat mr-1" data-tooltip="Voltar">
            <i class="material-icons black-text">arrow_back</i>
        </button>

        <h5>{{ cnpj($row->cnpj) }} - {{ $row->nome }}</h5>

    </div>
    <!-- Header search bar Ends -->

    <div class="row">

        <div id="dadosnfe" class="col s12 mt-3 mb-3">

            <table>

                <thead>
                    <tr>
                        <th>CNPJ</th>
                        <th>Destinatário</th>
                        <th>Número Danfe</th>
                        <th>V. Total Aquisições</th>
                        <th>Tipo de Pagamento</th>
                        <th>Qtd. Duplicatas</th>
                        <th></th>
                    </tr>
                </thead>

			</table>

			<div id="table" style="overflow: auto; height: 700px;">

				<table>

					<tbody>

						@foreach ($rows as $cDest)
                        <tr>
							<td>{{ cnpj($cDest->cDest) }}</td>
                            <td>{{ strtoupper($cDest->nome) }}</td>
                            <td>{{ $cDest->nNF }}-{{ $cDest->serie }}</td>
                            <td>{{ number_format($cDest->vPag, 2, ',', '.') }}</td>
                            <td>{{ $cDest->tPag }}</td>
                            <td>{{ $cDest->totalDup }}</td>
                            <td>
								<a
								href="{{ route('reports.fornecedores.nfe', ['cnpj' => $row->cnpj, 'nfe' => $cDest->chNFe]) }}">
								Detalhes da nota
							</a>
						</td>
					</tr>
                    @endforeach

                </tbody>

            </table>

		</div>

	</div>

    </div>

@endsection
