<?php
 
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

$entityBody = file_get_contents('php://input');
$entityBody = json_decode($entityBody, true);
//create Firebase factory object
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/budgetguru-9ed8a-firebase-adminsdk-087sb-846c2ec759.json');
$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->create();

//get a token from client 
//$idTokenString = 'eyJhbGciOiJSUzI1...';

try {
    $verifiedIdToken = $firebase->getAuth()->verifyIdToken($entityBody['token']);
} catch (InvalidToken $e) {
    echo $e->getMessage();
}

$uid = $verifiedIdToken->getClaim('sub');
$user = $firebase->getAuth()->getUser($uid);
echo $uid; 

?>