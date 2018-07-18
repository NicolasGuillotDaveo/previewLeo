<?php
//on lit notre code avec la base de donnée MangoDB
/*
 * Copyright (c) 2017 ObjectLabs Corporation
 * Distributed under the MIT license - http://opensource.org/licenses/MIT
 *
 * Written with extension mongodb ^1.1 & php7.1
 * Documentation: http://docs.mongodb.org/ecosystem/drivers/php/
 * A PHP script connecting to a MongoDB database given a MongoDB Connection URI.
 */
//require 'vendor/autoload.php'; // include Composer's autoloader
// Create seed data
//$seedData =
//        array(
 //   "_id" => array( "$oid" => "5b4db11b76e8f426dcaad304")
  //  ,
  //  "LinkedInID"=> "LinkedInIdExemple3",
  //  "email"=> "Exemple@gmail.com",
  //  "firstname"=> "FirstNameExemple",
  //"lastname"=> "LastNameExemple",
  //  "image"=> "https://media.licdn.com/dms/image/C4E00AQGI1Fgn87sDdw/profile-originalphoto-shrink_900_1200/0?e=1531908000&v=beta&t=Hic2EeXt0gMHR0-fuI6YN3CtKy0X_CkqiPKZBCgm6jw",
  //  "headline"=> "HeadLineExemple",
  //  "__v"=> 0
//);
// echo json_encode($seedData);
/*
 * Standard single-node URI format:
 * mongodb://[username:password@]host:port/[database]
 */
//$uri="mongodb://Daveo:Daveo2017@ds157809.mlab.com:57809/books2-auth";
//$client = new MongoDB\Client($uri);
/*
 * First we'll add a few songs. Nothing is required to create the songs
 * collection; it is created automatically when we insert.
 */
//$users = $client->db->users;
// To insert a dict, use the insert method.
//$users->insertMany($seedData);
/*
 * Then we need to give Boyz II Men credit for their contribution to
 * the hit "One Sweet Day".
*/
//$songs->updateOne(
//    array('artist' => 'Mariah Carey'),
//    array('$set' => array('artist' => 'Mariah Carey ft. Boyz II Men'))
//);
/*
 * Finally we run a query which returns all the hits that spent 10
 * or more weeks at number 1.
*/
//$query = array('weeksAtOne' => array('$gte' => 10));
//$options = array(
 //   "sort" => array('decade' => 1),
//);
//$cursor = $songs->find($query,$options);
//foreach($cursor as $doc) {
 //   echo 'In the ' .$doc['decade'];
   // echo ', ' .$doc['song'];
   // echo ' by ' .$doc['artist'];
   // echo ' topped the charts for ' .$doc['weeksAtOne'];
   // echo ' straight weeks.', "\n";
//}
// Since this is an example, we'll clean up after ourselves.
//$users->drop();


//On définit dans $method la méthode d'envoie utilisée
$method= $_SERVER['REQUEST_METHOD'];
//on accepte que si la méthode est "POST"
if($method = "POST"){

	$requestBody= file_get_contents('php://input');
    //on décode le JSON
	$json= json_decode($requestBody);
    //on prend la valeur de l'action
	$text= $json->queryResult->action;
    //on prend la valeur de la réponse que DialogFlow nous propose
	$DFresult= $json->queryResult->fulfillmentText;


	switch($text){

        case 'GetPresentation':
            //on réécrit la réponse de DialogFlow
            $speech= $DFresult;
            break;

        case 'enchante':
            $speech="Hellllooo wooorld";
            break;

		case 'GiveInfo':
            //ici:algorithme recherche d'info de la personne
			$speech= "tu es riadh- bien reçu";//réponse très simple pour l'instant
			break;

		case 'TakeInfo':
            //ici: algorithme qui insère les données dans la BD
            //on réécrit la valeur de DialogFlow qui ici nous convient
			$speech= $DFresult;
			break;

        case 'PrendreRdv':
            //ici: algorithme qui insère les données dans la BD
            //on réécrit la valeur de DialogFlow qui ici nous convient
			$speech=$DFresult;
			break;

        case 'GetNonExp':
            $speech="vous n'avez pas d'expérience, ce n'est pas grave. Dites m'en plus sur vous.";
            break;

		default;
        // si l'action n'est pas connue
			$speech=$DFresult+"héhé";
			break;

	}
    //on créée la réponse
	$response = new \stdClass();
    //on insère le speech dans la réponse
	$response-> fulfillmentText = $speech;

    //on écrit ici la source de la réponse : ici : webhook
	$response->source= "webhook2";
    //on encode $reponse pour l'avoir au format JSON
	echo json_encode($response);

}else{

	echo "method not allowed";
}





?>
