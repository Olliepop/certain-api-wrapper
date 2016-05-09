<?php

namespace Wabel\CertainAPI;

/**
 * Class CertainApiService
 */
class CertainApiService
{
    /**
     * An instance of the CertainApiClient
     * @var CertainApiClient
     */
    private $certainClient;

    /**
     * Service constructor
     * @param CertainApiClient $certainClient
     */
    public function __construct(CertainApiClient $certainClient)
    {
        $this->setCertainClient($certainClient);
    }

    /**
     * @param CertainApiClient $certainClient
     * @return $this
     */
    public function setCertainClient(CertainApiClient $certainClient)
    {
        $this->certainClient = $certainClient;
        return $this;
    }

    /**
     * Get Account Code
     * @return string
     */
    public function getAccountCode()
    {
        return $this->getCertainClient()->getAccountCode();
    }

    /**
     * Get the certain api client
     * @return CertainApiClient
     */
    public function getCertainClient()
    {
        return $this->certainClient;
    }

    /**
     * Send a "GET" request to get information about resource;
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $params
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function get($resourceName, $resourcePath = null, $resourceId = null, $params = [], $assoc = false, $contentType = 'json')
    {
        return $this->getCertainClient()->get($resourceName, $resourcePath, $resourceId, $params, $assoc, $contentType);
    }

    /**
     * Send a "POST" request to put information to certain;
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function post($resourceName, $resourcePath = null, $resourceId = null, $bodyData = [], $query = [], $assoc = false, $contentType = 'json')
    {
        return $this->getCertainClient()->post($resourceName, $resourcePath, $resourceId, $bodyData, $query, $assoc, $contentType);
    }


    /**
     * Send a "PUT" request to put information to certain;
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function put($resourceName, $resourcePath = null, $resourceId = null, $bodyData = [], $query = [], $assoc = false, $contentType = 'json')
    {
        return $this->getCertainClient()->put($resourceName, $resourcePath, $resourceId, $bodyData, $query, $assoc, $contentType);
    }

    /**
     * Send a "DELETE" request to delete information from certain;
     * @param string $resourceName
     * @param string $resourcePath
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return array
     */
    public function delete($resourceName, $resourcePath = null, $resourceId = null, $assoc = false, $contentType = 'json')
    {
        return $this->getCertainClient()->delete($resourceName, $resourcePath, $resourceId, $assoc, $contentType);
    }


}