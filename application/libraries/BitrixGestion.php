<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * client_id приложения
 */
define('CLIENT_ID', 'app.00000000000000.00000000');
/**
 * client_secret приложения
 */
define('CLIENT_SECRET', '00000000000000000000000000000000');
/**
 * относительный путь приложения на сервере
 */
define('PATH', '/bitrix/');
/**
 * полный адрес к приложения
 */
define('REDIRECT_URI', 'http://app.winnub.com/'.PATH);
/**
 * scope приложения
 */
define('SCOPE', 'crm,log,user');

/**
 * протокол, по которому работаем. должен быть https
 */
define('PROTOCOL', "https");

class BitrixGestion{
    
    
    
    function __construct(){
            // clear auth session
            if(isset($_REQUEST["clear"]) || $_SERVER["REQUEST_METHOD"] == "POST")
            {
                    unset($_SESSION["query_data"]);
            }
    }
    
    
    function authorize(){
        
    }
    
    

/**
 * Производит перенаправление пользователя на заданный адрес
 *
 * @param string $url адрес
 */
function redirect($url)
{
	Header("HTTP 302 Found");
	Header("Location: ".$url);
	die();
}

/**
 * Совершает запрос с заданными данными по заданному адресу. В ответ ожидается JSON
 *
 * @param string $method GET|POST
 * @param string $url адрес
 * @param array|null $data POST-данные
 *
 * @return array
 */
function query($method, $url, $data = null)
{
	$query_data = "";

	$curlOptions = array(
		CURLOPT_RETURNTRANSFER => true
	);

	if($method == "POST")
	{
		$curlOptions[CURLOPT_POST] = true;
		$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($data);
	}
	elseif(!empty($data))
	{
		$url .= strpos($url, "?") > 0 ? "&" : "?";
		$url .= http_build_query($data);
	}

	$curl = curl_init($url);
	curl_setopt_array($curl, $curlOptions);
	$result = curl_exec($curl);

	return json_decode($result, 1);
}

/**
 * Вызов метода REST.
 *
 * @param string $domain портал
 * @param string $method вызываемый метод
 * @param array $params параметры вызова метода
 *
 * @return array
 */
function call($domain, $method, $params)
{
	return query("POST", PROTOCOL."://".$domain."/rest/".$method, $params);
}
    
    
    
}