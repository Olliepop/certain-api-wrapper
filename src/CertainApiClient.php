<?php

namespace Wabel\CertainAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Wabel\CertainAPI\Response\CertainResponse;
use GuzzleHttp\Message\ResponseInterface;

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
    public function __construct($baseUri = null, $username, $password,
                                $accountCode)
    {
        if ($baseUri !== null) {
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
    public function getAccountCode()
    {
        return $this->accountCode;
    }

    /**
     * Build the URI to request
     * @param string|array $resourceName
     * @param null $resourcePath
     * @param string $resourceId
     * @return string
     */
    private function buildPathToCall($resourceName, $resourcePath = null, $resourceId = null)
    {
        $resourceAdded = '';
        if (!is_null($resourcePath) && $resourcePath != '') {
            $resourceAdded .= '/'. $resourcePath;
        }

        if ($resourceId !== null) {
            $resourceAdded .= '/' . $resourceId;
        }

        return $resourceName . '/' . $this->getAccountCode() . $resourceAdded;
    }

    /**
     * Make "GET" request with the client.
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function get($resourceName, $resourcePath = null, $resourceId = null, $query = [],
                        $assoc = false, $contentType = 'json')
    {
        try {
            $urlResource = $this->buildPathToCall($resourceName, $resourcePath, $resourceId);

            $response = $this->getClient()->get($urlResource,
                [
                    'headers' => ['Accept' => "application/$contentType"],
                    'query' => $query
                ]);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
        }
        return $this->makeCertainApiResponse($response, $contentType, $assoc);
    }

    /**
     * Make "POST" request with the client.
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function post($resourceName, $resourcePath = null, $resourceId = null,
                         $bodyData = [], $query = [], $assoc = false,
                         $contentType = 'json')
    {
        if ($contentType !== 'json') {
            throw new \Exception('Use only json to update or create');
        }
        try {
            $urlResource = $this->buildPathToCall($resourceName, $resourcePath, $resourceId);
            $response = $this->getClient()->post($urlResource,
                [
                    'headers' => ['Accept' => "application/$contentType"],
                    'json' => $bodyData,
                    'query' => $query
                ]);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
        }
        return $this->makeCertainApiResponse($response, $contentType, $assoc);
    }

    /**
     * Make "PUT" request with the client.
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     * @throws \Exception
     */
    public function put($resourceName, $resourcePath = null, $resourceId = null,
                        $bodyData = [], $query = [], $assoc = false,
                        $contentType = 'json')
    {
        if ($contentType !== 'json') {
            throw new \Exception('Use only json to update or create');
        }
        try {
            $urlResource = $this->buildPathToCall($resourceName, $resourcePath, $resourceId);
            $response = $this->getClient()->put($urlResource,
                [
                    'headers' => ['Accept' => "application/$contentType"],
                    'json' => $bodyData,
                    'query' => $query
                ]);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
        }
        return $this->makeCertainApiResponse($response, $contentType, $assoc);
    }

    /**
     * Make "DELETE" request with the client.
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function delete($resourceName, $resourcePath = null, $resourceId = null, $assoc = false,
                           $contentType = 'json')
    {
        try {
            $urlResource = $this->buildPathToCall($resourceName, $resourcePath, $resourceId);
            $response = $this->getClient()->delete($urlResource,
                [
                    'headers' => ['Accept' => "application/$contentType"],
                ]);
        } catch (ClientException $ex) {
            $response = $ex->getResponse();
        }
        return $this->makeCertainApiResponse($response, $contentType, $assoc);
    }

    /**
     * Make the  Certain Api repsonse.
     * @param ResponseInterface $response
     * @param string $contentType
     * @param boolean $assoc
     * @return array
     */
    private function makeCertainApiResponse(ResponseInterface $response, $contentType = 'json', $assoc = false)
    {

        $responseCertainApi = new CertainResponse($response);
        return $responseCertainApi->getResponse($contentType, $assoc);
    }
}