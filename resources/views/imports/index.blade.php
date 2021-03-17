@extends('_layouts.app')

@section('container')

    <div class="row">

        <div class="col s12">

            <form method="post" enctype="multipart/form-data" action="{{ url('/imports') }}">

                <div class="row">
                    <div class="col s6 mb-3">
                        <div class="file-field input-field">
                            <div class="btn blue">
                                <span>Adicionar Arquivos</span>
                                <input type="file" name="files[]" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>

                        <p>
                            Quantidade máxima de arquivos permitidos:
                            <b style="color: #ff0000"> {{ ini_get('max_file_uploads') }} </b>
							<br>
							<small>Acesse o arquivo de configuração do servidor web para alterar essa quantidade</small>
                        </p>

                    </div>

                </div>

                <div class="row">
                    <div class="col s3">
                        <button type="submit" class="btn waves-effect green">
                            <i class="material-icons left">send</i>
                            Importar Arquivo
                        </button>
                    </div>
                </div>

                @method('post')
                @csrf

            </form>

        </div>
    </div>


@endsection
