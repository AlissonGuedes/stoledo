@extends('_layouts.app')

{? $titulo = 'Importação de Arquivos'; ?}

@section('page-title', $titulo)

@section('search', '')

@section('container')

    <div class="row">

        <div class="col s12">

            <div class="card">

                <form novalidate id="import-files" method="post" enctype="multipart/form-data"
                    action="{{ route('imports.submit') }}">

                    <div class="card-content">

                        <div class="row">
                            <div class="col s12 l6">
                                <div class="input-field">
                                    <label for="" class="grey-text">Tipo de Arquivo</label>
                                    <select name="arquivo" @if (session()->has('import_txt')) {{ 'disabled="disabled"' }} @endif required="required">
                                        <option value="" disabled="disabled" selected="selected">Informe o tipo de arquivo
                                        </option>
                                        <option value="spedfiscal">Sped Fiscal</option>
                                        <option value="notasfiscais">Notas Fiscal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 l6">
                                <div class="file-field input-field">
                                    <div class="btn blue" @if (session()->has('import_txt')) {{ 'disabled="disabled"' }} @endif>
                                        <span>Adicionar Arquivos</span>
                                        <input type="file" name="files[]" multiple required="required">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" @if (session()->has('import_txt')) {{ 'disabled="disabled"' }} @endif
                                            placeholder="Insira um ou vários arquivos">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 l6 mb-2">
                                <p>
                                    Quantidade máxima de arquivos permitidos:
                                    <b style="color: #ff0000"> {{ ini_get('max_file_uploads') }} </b>
                                    <br>
                                    <small>Acesse o arquivo de configuração do servidor web para alterar essa
                                        quantidade</small>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 l6">
                                <button type="submit" class="btn waves-effect green" @if (session()->has('import_txt')) {{ 'disabled="disabled"' }} @endif>
                                    <i class="material-icons left">
                                        @if (session()->has('import_txt'))
                                            <div class="preloader-wrapper small active">
                                                <div class="spinner-layer spinner-blue-only">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="gap-patch">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            send
                                        @endif
                                    </i>
                                    Importar Arquivo
                                </button>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col s12">
                                @if (session()->has('import_txt'))
                                    A importação está sendo executada em background.
                                @endif
                            </div>
                        </div> --}}

                    </div>

                    @method('post')
                    @csrf

                </form>

            </div>

        </div>

    </div>

    <div id="log" class="row" style="display:none;">
        <div class="col s12">

            <div class="card">
                <div class="card-content" style="padding: 15px;">

                    <div class="card-title">Log de importação</div>

                </div>

                <div
                    style="background: rgba(0, 0, 0, 0.1); width: 100%; height: 300px; border: 1px solid #ccc; bottom: 0;z-index: 9999; right: 0; color: #000 !important; overflow-y: scroll;">
                    <div id="console" style="position: relative; overflow: hidden; padding: 15px;"></div>
                </div>
            </div>

        </div>
    </div>

@endsection
