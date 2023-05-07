<?php

namespace App\HttpClient;

use App\Factory\XmlResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class NominatimHttpClient
 * @package App\Client
 */
class NominatimHttpClient extends AbstractController {
    /**
     * @var array HttpClientInterface
     */
    private $httpClient;

    /**
     * NominatimHttpClient constructor
     * 
     * @param HttpClientInterface $nominatim
     */
    public function __construct(HttpClientInterface $nominatim) {
        $this->httpClient = $nominatim;
    }
    // création d'une fonction 
    public function getLocation($search) {
        // préparation d'une requête HTTP avec une méthode GET et un URL en format JSON
        $response = $this->httpClient->request('GET', "/search?q=$search&format=json&limit=1", [
            // désactive la vérification du certificat SSL (chiffrement des données)
            'verify_peer' => false,
        ]);
        // retourne une reponse en tableau JSON
        return json_decode($response->getContent(), true);
    }
}