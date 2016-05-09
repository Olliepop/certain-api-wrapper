<?php

namespace Wabel\CertainAPI;

use Wabel\CertainAPI\Interfaces\CertainResourceInterface;
use Wabel\CertainAPI\Interfaces\CertainResponseInterface;

/**
 * CertainResourceAbstract for common action about Resource
 *
 * @author rbergina
 */
abstract class CertainResourceAbstract implements CertainResourceInterface, CertainResponseInterface
{
    /**
     *
     */
    const NOT_FOUND = 404;

    /**
     * CertainApiService
     * @var CertainApiService
     */
    protected $certainApiService;

    /**
     * array of results with information about the request
     * @var array
     */
    protected $results;

    /**
     *
     * @var string
     */
    protected $resourceCalled;

    /**
     * @param CertainApiService $certainApiService
     */
    public function __construct(CertainApiService $certainApiService)
    {
        $this->certainApiService = $certainApiService;
    }

    /**
     * Get information about resource
     * @param string $resourceId
     * @param array $params
     * @param boolean $assoc
     * @param string $contentType
     * @return CertainResourceAbstract
     * @throws Exceptions\ResourceException
     */
    public function get($resourceId = null, $params = [], $assoc = false,
                        $contentType = 'json')
    {
        $resourceName = $this->getResourceName();;
        if ($resourceName == '' || is_null($resourceName)) {
            throw new Exceptions\ResourceException('No resource name provided.');
        }
        $this->results = $this->certainApiService->get($resourceName,
            $this->resourceCalled, $resourceId, $params, $assoc, $contentType);
        return $this;
    }

    /**
     * Add/Update information to certain
     * @param array $bodyData
     * @param array $query
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     * @throws Exceptions\ResourceException
     * @throws Exceptions\ResourceMandatoryFieldException
     */
    public function post($bodyData, $query = [], $resourceId = null,
                         $assoc = false, $contentType = 'json')
    {
        $resourceName = $this->getResourceName();;
        if ($resourceName == '' || is_null($resourceName)) {
            throw new Exceptions\ResourceException('No resource name provided.');
        }
        if ($resourceId === null && count($this->getMandatoryFields()) > 0) {
            foreach ($this->getMandatoryFields() as $field) {
                if (!in_array($field, array_keys($bodyData))) {
                    throw new Exceptions\ResourceMandatoryFieldException(sprintf('The field %s is required',
                        $field));
                }
            }
        }
        $this->results = $this->certainApiService->post($resourceName,
            $this->resourceCalled, $resourceId, $bodyData, $query, $assoc,
            $contentType);
        return $this;
    }

    /**
     * Update information to certain
     * @param array $bodyData
     * @param array $query
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     * @throws Exceptions\ResourceException
     * @throws Exceptions\ResourceMandatoryFieldException
     */
    public function put($bodyData, $query = [], $resourceId = null,
                        $assoc = false, $contentType = 'json')
    {
        $resourceName = $this->getResourceName();;
        if ($resourceName == '' || is_null($resourceName)) {
            throw new Exceptions\ResourceException('No resource name provided.');
        }
        if (!is_null($resourceId) && count($this->getMandatoryFields()) > 0) {
            foreach ($this->getMandatoryFields() as $field) {
                if (!in_array($field, array_keys($bodyData))) {
                    throw new Exceptions\ResourceMandatoryFieldException(sprintf('The field %s is required',
                        $field));
                }
            }
        } else {
            throw new Exceptions\ResourceMandatoryFieldException(sprintf('The id field is required'));
        }
        $this->results = $this->certainApiService->put($resourceName,
            $this->resourceCalled, $resourceId, $bodyData, $query, $assoc,
            $contentType);
        return $this;
    }

    /**
     * Delete information from certain
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     * @throws Exceptions\ResourceException
     */
    public function delete($resourceId, $assoc = false, $contentType = 'json')
    {
        $resourceName = $this->getResourceName();
        if ($resourceName == '' || is_null($resourceName)) {
            throw new Exceptions\ResourceException('No resource name provided.');
        }
        $this->results = $this->certainApiService->delete($resourceName,
            $this->resourceCalled, $resourceId, $assoc, $contentType);
        return $this;
    }

    /**
     * Check is a successful request
     * @return boolean
     */
    public function isSuccessFul()
    {
        return $this->results['success'];
    }

    /**
     * Check is not found.
     * @return boolean
     */
    public function isNotFound()
    {
        if (isset($this->results['statusCode']) && $this->results['statusCode'] == self::NOT_FOUND) {
            return true;
        } elseif (isset($this->results['statusCode']) && $this->results['statusCode']
            != self::NOT_FOUND
        ) {
            return false;
        }
        return null;
    }

    /**
     * Get the results
     * @return \stdClass|\stdClass[]|array
     */
    public function getResults()
    {
        return $this->results['results'];
    }

    /**
     * Get the succes value, results,  success or fail reason
     * @return array
     */
    public function getCompleteResults()
    {
        return $this->results;
    }

    /**
     * @return string
     */
    public function getResourceCalled()
    {
        return $this->resourceCalled;
    }

    /**
     * @param null $resourceCalledParameters
     * @return $this
     */
    public function createResourceCalled($resourceCalledParameters = null)
    {
        $this->resourceCalled = '';
        if (is_array($resourceCalledParameters) && !empty($resourceCalledParameters)) {
            foreach ($resourceCalledParameters as $segmentKey => $segmentValue) {
                if ($segmentValue != '') {
                    $this->resourceCalled .= '/' . $segmentKey . '/' . $segmentValue;
                } else {
                    $this->resourceCalled .= '/' . $segmentKey;
                }
            }
        }

        return $this;
    }

    /**
     *
     * @param string $eventCode
     * @param string $resourceId
     * @param array $params
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     */
    public function getWithEventCode($eventCode, $resourceId, $params = [],
                                     $assoc = false, $contentType = 'json')
    {
        $resourceId = $eventCode . '/' . $resourceId;
        return $this->get($resourceId, $params, $assoc, $contentType);
    }

    /**
     *
     * @param string $eventCode
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     */
    public function postWithEventCode($eventCode, $resourceId, $bodyData,
                                      $query = [], $assoc = false,
                                      $contentType = 'json')
    {
        $resourceId = $eventCode . '/' . $resourceId;
        return $this->post($bodyData, $query, $resourceId, $assoc, $contentType);
    }

    /**
     *
     * @param string $eventCode
     * @param string $resourceId
     * @param array $bodyData
     * @param array $query
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     */
    public function putWithEventCode($eventCode, $resourceId, $bodyData,
                                     $query = [], $assoc = false,
                                     $contentType = 'json')
    {
        $resourceId = $eventCode . '/' . $resourceId;
        return $this->put($bodyData, $query, $resourceId, $assoc, $contentType);
    }

    /**
     *
     * @param type $eventCode
     * @param string $resourceId
     * @param boolean $assoc
     * @param string $contentType
     * @return \Wabel\CertainAPI\CertainResourceAbstract
     */
    public function deleteWithEventCode($eventCode, $resourceId,
                                        $assoc = false, $contentType = 'json')
    {
        $resourceId = $eventCode . '/' . $resourceId;
        return $this->delete($resourceId, $assoc, $contentType);
    }

    /**
     * Return the size.
     * @return int
     */
    public function getSize()
    {
        $result = $this->getResults();
        if (!isset($result->size)) {
            return null;
        }
        return $result->size;
    }

    /**
     * Return the completeCollectionSizet.
     * @return int
     */
    public function getCompleteCollectionSize()
    {
        $result = $this->getResults();
        if (!isset($result->size)) {
            return null;
        }
        return $result->completeCollectionSize;
    }

    /**
     * Return the maxResults.
     * @return int
     */
    public function getMaxResults()
    {
        $result = $this->getResults();
        if (!isset($result->size)) {
            return null;
        }
        return $result->maxResults;
    }
}