<?php
    //require '../../vendor/autoload.php';
    require("/home/u268055314/vendor/sendpulse/rest-api/src/ApiInterface.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/ApiClient.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/Storage/TokenStorageInterface.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/Storage/FileStorage.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/Storage/SessionStorage.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/Storage/MemcachedStorage.php");
    require("/home/u268055314/vendor/sendpulse/rest-api/src/Storage/MemcacheStorage.php");
    use Sendpulse\RestApi\ApiClient;
    use Sendpulse\RestApi\Storage\FileStorage;
    include_once 'dbConnect.php';

    $SPApiClient = new ApiClient($apiUserID, $apiSecret, new FileStorage());
    $email = "";
    if (isset($_POST["email"])){
        $email = $_POST["email"];
    }
    $requestBody = array("emails"=> $email);

    $SPApiClient->addEmails($spID, $requestBody);

?>