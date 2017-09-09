<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$route["^(\w{2})/switchlang"]="welcome/switchlang/$1";


$route['default_controller'] = 'welcome';

/*
$route['^(\w{2})/amministrazione'] = 'amministrazione';
$route['^(\w{2})/amministrazione/(:any)/'] = 'amministrazione/$1';
$route['^(\w{2})/amministrazione/(:any)/(:any)'] = 'amministrazione/$1/$2';
*/



$route["img/(:any)"]="/public/img/$1";

//NOT VIEWD

$route['^(\w{2})/invoice'] = 'invoice';
$route['^(\w{2})/invoice/(:any)'] = 'invoice/$2';
$route['^(\w{2})/invoice/(:any)/(:any)'] = 'invoice/$2/$3';


//fornitori  
$route['^(\w{2})/fornitori'] = 'fornitori';
$route['^(\w{2})/fornitori/(:any)'] = 'fornitori/$2';
$route['^(\w{2})/fornitori/delete/(:any)'] = 'fornitori/delete/$2';
$route['^(\w{2})/fornitori/edit/(:any)'] = 'fornitori/edit/$2';
$route['^(\w{2})/fornitori/(:any)/(:any)'] = 'fornitori/$2/$3';

//Contatto  
$route['^(\w{2})/contacts'] = 'contatto/contacts';
$route['^(\w{2})/contatto'] = 'contatto';
$route['^(\w{2})/contatto/(:any)'] = 'contatto/$2';
$route['^(\w{2})/contatto/delete/(:any)'] = 'contatto/delete/$2';
$route['^(\w{2})/contatto/contattolist/(:any)'] = 'contatto/contattolist/$2';
$route['^(\w{2})/contatto/contattoexcle/(:any)'] = 'contatto/contattoexcle/$2';
$route['^(\w{2})/contatto/getcontact/(:any)'] = 'contatto/getcontact/$2';
$route['^(\w{2})/contatto/(:any)/(:any)'] = 'contatto/$2/$3';

//routing del profilo

$route['^(\w{2})/api/v1'] = 'api/index';
$route['^(\w{2})/api/v1/(:any)'] = 'api/$2';
$route['^(\w{2})/api/v1/(:any)'] = 'api/$2';
$route['^(\w{2})/api/v1/(:any)/(:any)'] = 'api/$2/id/$3';

//compito  duplicato
$route['^(\w{2})/progetti'] = 'compito';
$route['^(\w{2})/progetti/(:any)'] = 'compito/$2';
$route['^(\w{2})/progetti/delete/(:any)'] = 'compito/delete/$2';
$route['^(\w{2})/progetti/contattolist/(:any)'] = 'compito/compitolist/$2';
$route['^(\w{2})/progetti/getcontact/(:any)'] = 'compito/gettask/$2';
$route['^(\w{2})/progetti/(:any)/(:any)'] = 'compito/$2/$3';


//compito  
$route['^(\w{2})/compito'] = 'compito';
$route['^(\w{2})/compito/(:any)'] = 'compito/$2';
$route['^(\w{2})/compito/delete/(:any)'] = 'compito/delete/$2';
$route['^(\w{2})/compito/contattolist/(:any)'] = 'compito/compitolist/$2';
$route['^(\w{2})/compito/getcontact/(:any)'] = 'compito/gettask/$2';
$route['^(\w{2})/compito/(:any)/(:any)'] = 'compito/$2/$3';


//Purchases  
$route['^(\w{2})/purchases'] = 'purchases';
$route['^(\w{2})/purchases/(:any)'] = 'purchases/$2';
$route['^(\w{2})/purchases/edit/(:any)'] = 'purchases/edit/$2';
$route['^(\w{2})/purchases/delete/(:any)'] = 'purchases/delete/$2';


//messaggi
$route['^(\w{2})/message'] = 'messaggi';
$route['^(\w{2})/message/(:any)'] = 'messaggi/$2';
$route['^(\w{2})/message/(:any)/(:num)'] = 'messaggi/$2/$3';


$route['^(\w{2})/clienti'] = 'clienti';
$route['^(\w{2})/clienti/(:any)'] = 'clienti/$2';
$route['^(\w{2})/clienti/delete/(:any)'] = 'clienti/delete/$2';
$route['^(\w{2})/clienti/edit/(:any)'] = 'clienti/edit/$2';
$route['^(\w{2})/clienti/(:any)/(:any)'] = 'clienti/$2/$3';


//media image
$route['^media/(:any)/(:any)'] = 'media/index/$1/$2';
//media sezione
$route['^(\w{2})/media'] = 'media/index';
$route['^(\w{2})/media/(:any)'] = 'media/$2';
$route['^(\w{2})/media/(:any)/(:any)'] = 'media/$2/$3';//es: media/images/file.png...
$route['^(\w{2})/media/shared/(:any)'] = 'media/shared/$2';
$route['^(\w{2})/media/(:any)/(:num)'] = 'media/$2/$3';

$route['^(\w{2})/download/(:any)/(:any)'] = 'generatore/scarica/$2/$3';

$route['preventivo/conferma/(:num)'] = 'welcome/confermaordine/$1';
$route['preventivo/elimina/(:any)'] = 'welcome/eliminaordine/$1';


$route['^(\w{2})/ordine/(:num)'] = 'profile/ordine/$2';
$route['^(\w{2})/ordini/(:any)'] = 'profile/ordini/$2';


$route['^(\w{2})/profilo'] = 'profile/index';
$route['^(\w{2})/profilo/(:any)'] = 'profile/$2';

//chiama più generica possibile con profile...
$route['^(\w{2})/profile'] = 'profile/index';
$route['^(\w{2})/profile/(:any)'] = 'profile/$2';
$route['^(\w{2})/profile/(:any)/(:any)'] = 'profile/$2/$3';
$route['^(\w{2})/profile/(:any)/(:any)/(:any)'] = 'profile/$2/$3/$4';


$route['^(\w{2})/network'] = 'network/index';
//$route['^(\w{2})/network/detail/(:any)']="network/datail/$2";

$route['^(\w{2})/network/(:any)'] = 'network/$2';
$route['^(\w{2})/network/user/(:any)'] = 'network/getuser/$2';
$route['^(\w{2})/network/detail/(:num)'] = 'network/detail/$2';

$route["(\w{2})/network/getnetworkmessage/(:any)"]="network/getnetworkmessage/$2";
//$route['^(\w{2})/network/(:any)/(:any)/(:any)'] = 'network/$2/$3/$4';


/*
$route['^(\w{2})/hauth'] = 'hauth';
$route['^(\w{2})/hauth/(:any)'] = 'hauth/$2';
$route['^(\w{2})/hauth/(:any)/(:any)'] = 'hauth/$2/$3';
*/

$route['^(\w{2})/logout'] = 'welcome/logout';

/*$route["guestlogin"]="welcome/guestlogin";

$route["carrello"]='welcome/carrello';
$route["ajx_carrello"]="welcome/ajx_carrello";
*/

$route['^(\w{2})/restore'] = 'registrazione/restore';
$route['^(\w{2})/signup'] = 'registrazione/signup';
$route['^(\w{2})/signup/(:any)'] = 'registrazione/signup/$2';

$route['^(\w{2})/signin'] = 'welcome/signin';

$route['^(\w{2})/validate/(:any)'] = 'welcome/validate/$2';

$route['^(\w{2})/quote'] = 'quote';
$route['^(\w{2})/quote/(:any)'] = 'quote/$2';
$route['^(\w{2})/quote/(:any)/(:any)'] = 'quote/$2/$3';
//-------------------->modo->sezione->codicesezione
$route['^(\w{2})/quote/(:any)/(:any)/(:any)'] = 'quote/$2/$3/$4';


//per la modifica dal preventivo con caricamento di altri prodotti
//$2 -> codicepreventivo - $3 ->  modod - $4 -> categoria
$route['^(\w{2})/quote/edit/(:any)'] = 'quote/editing/$2';
$route['^(\w{2})/quote/edit/(:any)/(:any)'] = 'quote/editing/$2/$3';
$route['^(\w{2})/quote/edit/(:any)/(:any)/(:any)'] = 'quote/editing/$2/$3/$4';
$route['^(\w{2})/quote/edit/(:any)/(:any)/(:any)/(:any)'] = 'quote/editing/$2/$3/$4/$5';

//-->

$route['registrazione'] = 'registrazione/singup';
$route['auth/(:any)'] = 'registrazione/$1';


$route['404_override'] = 'welcome/error';
$route['access-error'] = 'welcome/error';


//$route['switchLang/(:any)'] = 'welcome/switchLang/$1';

$route['^(\w{2})/prodotti'] = 'prodotto';
$route['^(\w{2})/prodotti/(.*)'] = 'prodotti/$2';

$route['^(\w{2})/prodotti/seleziona-prodotto/'] = 'prodotto/seleziona_prodotto';
$route['^(\w{2})/prodotti/seleziona-prodotto/(:any)/(:num)'] = 'dashboard/seleziona_prodotto/$2/$3';
//sezione editing prodotto del carrello 
$route['^(\w{2})/prodotti/seleziona-prodotto/(:any)/(:num)/(.*)'] = 'dashboard/seleziona_prodotto/$2/$3/$4';


$route['^(\w{2})/dashboard'] = 'dashboard';
$route['^(\w{2})/dashboard/(.*)'] = 'dashboard/$2';
$route['^(\w{2})/dashboard/configura/(:any):(:num)'] = 'dashboard/configura/$2/$3';


$route['^(\w{2})/admin'] = 'admin';
$route['^(\w{2})/admin/(:any)'] = 'admin/$2';
$route['^(\w{2})/admin/(:any)/(:any)'] = 'admin/$2/$3';
$route['^(\w{2})/admin/(:any)/(:any)/'] = 'admin/$2/$3/$4';
$route['^(\w{2})/admin/configura/(:any):(:num)'] = 'dashboard/configura/$2/$3';

$route['^(\w{2})/qdetail/(.*)'] = 'welcome/qdetail/$2';





$route['^(\w{2})/(:any)'] = 'welcome/$2';
$route['^(\w{2})/(:any)/(:any)'] = 'welcome/$2/$3';
$route['^(\w{2})/(:any)/(:num)'] = 'welcome/$2/$3';
$route['validate/(:any)'] = 'welcome/validate/$1';

$route['^(\w{2})/(.*)$'] = 'welcome/$2';


$route['^(\w{2})$'] = $route['default_controller'];


$route['translate_uri_dashes'] = TRUE;