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

    public function getLocation($search) {

        $response = $this->httpClient->request('GET', "/search?q=$search&format=json&limit=1", [
            'verify_peer' => false,
        ]);

        return json_decode($response->getContent(), true);
    }
}