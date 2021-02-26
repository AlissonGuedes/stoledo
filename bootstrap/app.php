<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/


function cnpj($str) {

	$tipo = null;
	$cnpj = preg_replace('/[^0-9]/', '', $str);

	if ( strlen($str) === 11 )
		$tipo = 'cpf';

	if ( strlen($str) === 14 )
		$tipo = 'cnpj';

	switch($tipo) {
		default:
			return $str;
		break;

		case 'cpf' :
			return substr($cnpj, 0, 3) . '.' . substr($cnpj, 3, 3) . '.' . substr($cnpj, 6, 3) . '-' . substr($cnpj, -2);
		break;

		case 'cnpj' :
			return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj,-2);
		break;

	}

}

function convert_to_date($date, $format = 'd/m/Y') {

	if ( strlen($date) === 7 ) {
		$dia = '0' . substr($date, 0, 1);
		$mes = substr($date, 1, 2);
	} else {
		$dia = substr($date, 0, 2);
		$mes = substr($date, 2, 2);
	}

	$ano = substr($date, -4);
	$date = $ano . '-' . $mes . '-' . $dia;

	return date($format, strtotime($date));

}

function chave($chave)
{
    $conv = '';

    for ($i = 0; $i < strlen($chave); $i++) {
        if ($i % 4 === 0) {
            $conv .= substr($chave, $i, 4) . ' ';
        }
    }

    return trim($conv);
}

function cep($cep)
{
    return substr($cep, 0, 5) . '-' . substr($cep, -3);
}

return $app;
