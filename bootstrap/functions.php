<?php

use App\Models\Admin\ConfigModel;

define('DS', DIRECTORY_SEPARATOR);

if (!function_exists('get_config')) {

	function get_config($config)
	{

		$cfg = new ConfigModel();

		return $cfg -> getConfig($config) -> first() -> value ?? null;

	}

}

function tradutor($traducao, $lang = null, $except = 'Tradução não disponível para este idioma')
{

	$idioma = is_null($lang) ? ( isset($_COOKIE['idioma']) ? $_COOKIE['idioma'] : get_config('language') ) : $lang;

	// Formata a data e hora de acordo com o Idioma
	if ( is_object($traducao)) {

		$date = (string) $traducao;

		switch($idioma) {

			case 'en' : $formato = 'Y-m-d h:ia'; break;
			case 'pt-br' : $formato = 'd/m/Y H\hi'; break;
			case 'hr' : $formato = 'd-m-y h:ia'; break;

		}

		return  date($formato, strtotime($date));

	}

	if ( is_array($traducao) ) {

		if ( !empty($traducao[$idioma]) ) {
			return $traducao[$idioma];
		} else {
			return null;
		}

	}

	return $except;

}

if (!function_exists('hashCode')) {
	function hashCode($str)
	{
		return !empty($str) ? substr(hash('sha512', $str), 0, 50) : null;
	}
}

function configuracoes() {

}

/**
 * Remove caratecres especiais
 * Converte todos os caracteres de um arquivo para caixa baixa
 * Remove espaçamentos
 */
function limpa_string($string, $replace = '-')
{
	$output = [];
	$a = ['Á' => 'a', 'À' => 'a', 'Â' => 'a', 'Ä' => 'a', 'Ã' => 'a', 'Å' => 'a', 'á' => 'a', 'à' => 'a', 'â' => 'a', 'ä' => 'a', 'ã' => 'a', 'å' => 'a', 'a' => 'a', 'Ç' => 'c', 'ç' => 'c', 'Ð' => 'd', 'É' => 'e', 'È' => 'e', 'Ê' => 'e', 'Ë' => 'e', 'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'Í' => 'i', 'Î' => 'i', 'Ï' => 'i', 'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'Ñ' => 'n', 'ñ' => 'n', 'O' => 'o', 'Ó' => 'o', 'Ò' => 'o', 'Ô' => 'o', 'Ö' => 'o', 'Õ' => 'o', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'ö' => 'o', 'õ' => 'o', 'ø' => 'o', 'œ' => 'o', 'Š' => 'o', 'Ú' => 'u', 'Ù' => 'u', 'Û' => 'u', 'Ü' => 'u', 'U' => 'u', 'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'Y' => 'y', 'Ý' => 'y', 'Ÿ' => 'y', 'ý' => 'y', 'ÿ' => 'y', 'Ž' => 'z', 'ž' => 'z'];
	$string = strtr($string, $a);
	$regx = [' ', '.', '+', '@', '#', '!', "$", '%', '¨', '&', '*', '(', ')', '_', '-', '+', '=', ';', ':', ',', '\\', '|', '£', '¢', '¬', '/', '?', '°', '´', '`', '{', '}', '[', ']', 'ª', 'º', '~', '^', "\'", "\""];

	$replacement = str_replace($regx, '|', trim(strtolower($string)));
	$explode = explode('|', $replacement);

	for ($i = 0; $i < count($explode); $i++) {
		if (!empty($explode[$i])) {
			$output[] = trim($explode[$i]);
		}
	}

	return implode($replace, $output);

}



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

function paginate($paginate) {

	$max_links = 3;
	$link = '';

	if ( $paginate ) {

	$link = '<div id="pagination">
	<ul class="pagination">
		<li>
			<button class="btn btn-small btn-floating waves-effect"
					data-href="' . ( !$paginate->onFirstPage() ? $paginate->previousPageUrl() : '#' ) . '"
					' . ( $paginate->onFirstPage() ? 'disabled' : null ) . '>
				<i class="material-icons">keyboard_arrow_left</i>
			</button>
		</li>';

		for ($i = $paginate->currentPage() - $max_links; $i <= $paginate->currentPage() - 1; $i++) :
			if ($i > 0) {
				$class = ($i === $paginate -> currentPage() ) ? 'active' : null;
			$link .= '<li>
					<button data-href="' . ( $paginate->currentPage() !== $i ? $paginate->url($i) : '#' ) . '"
							class="btn btn-small btn-floating waves-effect ' . $class . '">' . $i . '</button>
				</li>';
			}
		endfor;

		$link .= '<li>
			<button data-href="#"
					class="btn btn-small btn-floating waves-effect active">' . $paginate->currentPage() . '</button>
		</li>';

		for ($i = $paginate->currentPage() + 1; $i <= $paginate->currentPage() + $max_links; $i++) :
			$class = ($i === $paginate -> currentPage() ) ? 'active' : null;
			$link .= '<li>
				<button data-href="' . ( $paginate->currentPage() !== $i ? $paginate->url($i) : '#' ) . '"
						class="btn btn-small btn-floating waves-effect ' . $class . '">' . $i . '</button>
			</li>';
		endfor;

		$link .= '<li>
				<button class="btn btn-small btn-floating waves-effect"
						data-href="' . ( $paginate->currentPage() < $paginate->lastPage() ? $paginate->nextPageUrl() : '#' ). '" ' . ( $paginate->currentPage() === $paginate->lastPage() ? 'disabled' : null ) . '>
					<i class="material-icons">keyboard_arrow_right</i>
				</button>
			</li>

		</ul>

	</div>';

	$link .= '<div id="info">
		        <span class="">' . $paginate->firstItem() . ' - ' . $paginate->lastItem() . ' / ' . $paginate->total() . '</span>
		      </div>';

	} else {

		$link = '
		<div id="pagination">
			<ul class="pagination">
				<li>
					<button class="btn btn-small btn-floating waves-effect"
							data-href="#"
							disabled="disabled">
						<i class="material-icons">keyboard_arrow_left</i>
					</button>
				</li>
				<li>
					<button data-href="#"
							class="btn btn-small btn-floating waves-effect active">0</button>
				</li>
				<li>
					<button class="btn btn-small btn-floating waves-effect"
							data-href="#"
							disabled="disabled">
						<i class="material-icons">keyboard_arrow_right</i>
					</button>
				</li>
			</ul>
		</div>
		<div id="info">
			Nenhum registro encontrado
		</div>';

	}

	echo $link;

}
