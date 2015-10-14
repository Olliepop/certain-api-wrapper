<?php

namespace Wabel\CertainAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Wabel\CertainAPI\Response\CertainResponse;

/**
 * CertainApiClient
 * @see http://developer.certain.com/api2docs/introduction
 */
class CertainApiClient
{
    /**
     * URL for call request
     *
     * @var string
     */
    private $baseUri = 'https://appeu.certain.com/certainExternal/service/v1/';

    /**
     *
     * @var Client
     */
    private $client;

    /**
     * AccountCode to put in the URI
     *
     * @var string
     */
    private $accountCode;

    /**
     *
     * @param string|null $baseUri
     * @param string $username
     * @param string $password
     * @param string $accountCode
     */
    public function __construct($baseUri, $username, $password,
                                $accountCode)
    {
        if ($baseUri) {
            $this->baseUri = $baseUri;
        }
        $this->accountCode = $accountCode;
        $this->setClient(new Client([
                'base_url' => $this->baseUri,
                'defaults' => [
                    'auth' => [$username, $password],
                ]
            ]
        ));
    }

    /**
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Define a client
     * @param Client $client
     * @return \Wabel\CertainAPI\CertainApiClient
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get Account Code
     * @return string
     */
    function getAccountCode()
    {
        return $this->accountCode;
    }

        /**
     * Build the URI to request
     * @param string $ressourceName
     * @param string $ressourceId
     * @return string
     */
    private function builPathToCall($ressourceName, $ressourceId=null){
        $ressourceAdded = '';
        if($ressourceId){
            $ressourceAdded = '/'.$ressourceId;
        }
        return $ressourceName.'/'.$this->getAccountCode().$ressourceAdded;
    }

    /**
     * Make "GET" request with the client.
     * @param string $ressourceName
     * @param string $ressourceId
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function get($ressourceName, $ressourceId=null, $query= array(), $assoc = false,$contentType='json'){
        try{
            $urlRessource = $this->builPathToCall($ressourceName, $ressourceId);
            $response = $this->getClient()->get($urlRessource,array(
                'headers'=> ['Accept'     => "application/$contentType"],
                'query'=> $query
            ));
        } catch (ClientException $ex) {
             $response = $ex->getResponse();
        }
        $responseCertainApi = new CertainResponse($response);
        return $responseCertainApi->getResponse($contentType,$assoc);
    }

    /**
     * Make "POST" request with the client.
     * @param string $ressourceName
     * @param string $ressourceId
     * @param array $bodyData
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function post($ressourceName, $ressourceId=null, $bodyData = array(),$query=array(), $assoc = false,$contentType='json'){
        if($contentType!=='json'){
            throw new \Exception('Use only json to update or create');
        }
        try{
            $urlRessource = $this->builPathToCall($ressourceName, $ressourceId);
            $response = $this->getClient()->post($urlRessource,array(
                'headers'=> ['Accept'     => "application/$contentType"],
                'json' => $bodyData,
                'query'=> $query
            ));  
        } catch (ClientException $ex) {
             $response = $ex->getResponse();
        }
        $responseCertainApi = new CertainResponse($response);
        return $responseCertainApi->getResponse($contentType,$assoc);
    }

     /**
     * Make "PUT" request with the client.
     * @param string $ressourceName
     * @param string $ressourceId
     * @param array $bodyData
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function put($ressourceName, $ressourceId=null, $bodyData = array(),$query=array(), $assoc = false,$contentType='json'){
        if($contentType!=='json'){
            throw new \Exception('Use only json to update or create');
        }
        try{
            $urlRessource = $this->builPathToCall($ressourceName, $ressourceId);
            $response = $this->getClient()->put($urlRessource,array(
                'headers'=> ['Accept'     => "application/$contentType"],
                'json' => $bodyData,
                'query'=> $query
            ));
        } catch (ClientException $ex) {
             $response = $ex->getResponse();
        }
        $responseCertainApi = new CertainResponse($response);
        return $responseCertainApi->getResponse($contentType,$assoc);
    }
    
    /**
     * Make "DELETE" request with the client.
     * @param string $ressourceName
     * @param string $ressourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function delete($ressourceName, $ressourceId=null, $assoc = false,$contentType='json'){
        try{
            $urlRessource = $this->builPathToCall($ressourceName, $ressourceId);
            $response = $this->getClient()->delete($urlRessource,array(
                'headers'=> ['Accept'     => "application/$contentType"],
            ));
        } catch (ClientException $ex) {
             $response = $ex->getResponse();
        }
        $responseCertainApi = new CertainResponse($response);
        return $responseCertainApi->getResponse($contentType,$assoc);
    }
}