<?php

namespace jc\ParisOiseBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use jc\ParisOiseBundle\Entity\Document;
use jc\ParisOiseBundle\Entity\Construction;
use GuzzleHttp\Client;
use Google_Auth_AssertionCredentials;
use Google_Auth_OAuth2;
use Google_Client;
use Google_Service_Drive;

class TestController extends Controller {

    /**
     * @Route("/test")
     */
    public function testAction(Request $request) {

        $client = new Google_Client();

        $client->setAuthConfigFile('D:/Eclipse/html/client_secret_service.json');
        $client->useApplicationDefaultCredentials();
        $client->setScopes('https://www.googleapis.com/auth/drive');

        $guzzleClient = new Client(['verify' => false]);
        $client->setHttpClient($guzzleClient);

        $httpClient = $client->authorize();
        //var_dump($httpClient);

        $drive_service = new Google_Service_Drive($client);

        $files_list = $drive_service->files->listFiles(array())->getFiles();

        return $this->render('jcParisOiseBundle:document:list.html.twig', array('construction' => $construction, 'documentList' => $documentList));
    }
}
