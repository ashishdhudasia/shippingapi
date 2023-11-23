<?php
/**
 * HarmonizedSystemCodesApi
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Shipping Label API
 *
 * Shipping Label application
 *
 * OpenAPI spec version: v1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.51
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Swagger\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Swagger\Client\HeaderSelector;
use Swagger\Client\ObjectSerializer;

/**
 * HarmonizedSystemCodesApi Class Doc Comment
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class HarmonizedSystemCodesApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation getHsCodes
     *
     * Get Hs codes for list of products
     *
     * @param  \Swagger\Client\Model\HsCodesRequest $body body (required)
     * @param  string $instance_id instance_id (required)
     * @param  string $connection_id connection_id (required)
     * @param  bool $test_mode test_mode (optional, default to false)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Swagger\Client\Model\HsCodesResponse
     */
    public function getHsCodes($body, $instance_id, $connection_id, $test_mode = 'false')
    {
        list($response) = $this->getHsCodesWithHttpInfo($body, $instance_id, $connection_id, $test_mode);
        return $response;
    }

    /**
     * Operation getHsCodesWithHttpInfo
     *
     * Get Hs codes for list of products
     *
     * @param  \Swagger\Client\Model\HsCodesRequest $body (required)
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Swagger\Client\Model\HsCodesResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getHsCodesWithHttpInfo($body, $instance_id, $connection_id, $test_mode = 'false')
    {
        $returnType = '\Swagger\Client\Model\HsCodesResponse';
        $request = $this->getHsCodesRequest($body, $instance_id, $connection_id, $test_mode);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\HsCodesResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 501:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation getHsCodesAsync
     *
     * Get Hs codes for list of products
     *
     * @param  \Swagger\Client\Model\HsCodesRequest $body (required)
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getHsCodesAsync($body, $instance_id, $connection_id, $test_mode = 'false')
    {
        return $this->getHsCodesAsyncWithHttpInfo($body, $instance_id, $connection_id, $test_mode)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation getHsCodesAsyncWithHttpInfo
     *
     * Get Hs codes for list of products
     *
     * @param  \Swagger\Client\Model\HsCodesRequest $body (required)
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function getHsCodesAsyncWithHttpInfo($body, $instance_id, $connection_id, $test_mode = 'false')
    {
        $returnType = '\Swagger\Client\Model\HsCodesResponse';
        $request = $this->getHsCodesRequest($body, $instance_id, $connection_id, $test_mode);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'getHsCodes'
     *
     * @param  \Swagger\Client\Model\HsCodesRequest $body (required)
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getHsCodesRequest($body, $instance_id, $connection_id, $test_mode = 'false')
    {
        // verify the required parameter 'body' is set
        if ($body === null || (is_array($body) && count($body) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $body when calling getHsCodes'
            );
        }
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null || (is_array($instance_id) && count($instance_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $instance_id when calling getHsCodes'
            );
        }
        // verify the required parameter 'connection_id' is set
        if ($connection_id === null || (is_array($connection_id) && count($connection_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $connection_id when calling getHsCodes'
            );
        }

        $resourcePath = '/instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($test_mode !== null) {
            $queryParams['testMode'] = ObjectSerializer::toQueryValue($test_mode, null);
        }

        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                '{' . 'instanceId' . '}',
                ObjectSerializer::toPathValue($instance_id),
                $resourcePath
            );
        }
        // path params
        if ($connection_id !== null) {
            $resourcePath = str_replace(
                '{' . 'connectionId' . '}',
                ObjectSerializer::toPathValue($connection_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'POST',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation isClassified
     *
     * Check products classification status
     *
     * @param  string $instance_id instance_id (required)
     * @param  string $connection_id connection_id (required)
     * @param  \Swagger\Client\Model\HsCodesClassificationStatusRequest $request request (required)
     * @param  bool $test_mode test_mode (optional, default to false)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return \Swagger\Client\Model\HsCodesClassificationStatusResponse
     */
    public function isClassified($instance_id, $connection_id, $request, $test_mode = 'false')
    {
        list($response) = $this->isClassifiedWithHttpInfo($instance_id, $connection_id, $request, $test_mode);
        return $response;
    }

    /**
     * Operation isClassifiedWithHttpInfo
     *
     * Check products classification status
     *
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  \Swagger\Client\Model\HsCodesClassificationStatusRequest $request (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \Swagger\Client\ApiException on non-2xx response
     * @throws \InvalidArgumentException
     * @return array of \Swagger\Client\Model\HsCodesClassificationStatusResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function isClassifiedWithHttpInfo($instance_id, $connection_id, $request, $test_mode = 'false')
    {
        $returnType = '\Swagger\Client\Model\HsCodesClassificationStatusResponse';
        $request = $this->isClassifiedRequest($instance_id, $connection_id, $request, $test_mode);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    $response->getBody()
                );
            }

            $responseBody = $response->getBody();
            if ($returnType === '\SplFileObject') {
                $content = $responseBody; //stream goes to serializer
            } else {
                $content = $responseBody->getContents();
                if (!in_array($returnType, ['string','integer','bool'])) {
                    $content = json_decode($content);
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\HsCodesClassificationStatusResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 501:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\Swagger\Client\Model\ErrorResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation isClassifiedAsync
     *
     * Check products classification status
     *
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  \Swagger\Client\Model\HsCodesClassificationStatusRequest $request (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function isClassifiedAsync($instance_id, $connection_id, $request, $test_mode = 'false')
    {
        return $this->isClassifiedAsyncWithHttpInfo($instance_id, $connection_id, $request, $test_mode)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation isClassifiedAsyncWithHttpInfo
     *
     * Check products classification status
     *
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  \Swagger\Client\Model\HsCodesClassificationStatusRequest $request (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function isClassifiedAsyncWithHttpInfo($instance_id, $connection_id, $request, $test_mode = 'false')
    {
        $returnType = '\Swagger\Client\Model\HsCodesClassificationStatusResponse';
        $request = $this->isClassifiedRequest($instance_id, $connection_id, $request, $test_mode);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    $responseBody = $response->getBody();
                    if ($returnType === '\SplFileObject') {
                        $content = $responseBody; //stream goes to serializer
                    } else {
                        $content = $responseBody->getContents();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'isClassified'
     *
     * @param  string $instance_id (required)
     * @param  string $connection_id (required)
     * @param  \Swagger\Client\Model\HsCodesClassificationStatusRequest $request (required)
     * @param  bool $test_mode (optional, default to false)
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function isClassifiedRequest($instance_id, $connection_id, $request, $test_mode = 'false')
    {
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null || (is_array($instance_id) && count($instance_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $instance_id when calling isClassified'
            );
        }
        // verify the required parameter 'connection_id' is set
        if ($connection_id === null || (is_array($connection_id) && count($connection_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $connection_id when calling isClassified'
            );
        }
        // verify the required parameter 'request' is set
        if ($request === null || (is_array($request) && count($request) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $request when calling isClassified'
            );
        }

        $resourcePath = '/instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs/classificationstatus';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        if ($test_mode !== null) {
            $queryParams['testMode'] = ObjectSerializer::toQueryValue($test_mode, null);
        }
        // query params
        if ($request !== null) {
            $queryParams['request'] = ObjectSerializer::toQueryValue($request, null);
        }

        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                '{' . 'instanceId' . '}',
                ObjectSerializer::toPathValue($instance_id),
                $resourcePath
            );
        }
        // path params
        if ($connection_id !== null) {
            $resourcePath = str_replace(
                '{' . 'connectionId' . '}',
                ObjectSerializer::toPathValue($connection_id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['*/*']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['*/*'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            $httpBody = $_tempBody;
            // \stdClass has no __toString(), so we should encode it manually
            if ($httpBody instanceof \stdClass && $headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($httpBody);
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = \GuzzleHttp\Psr7\Query::build($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = \GuzzleHttp\Psr7\Query::build($queryParams);
        return new Request(
            'GET',
            $this->config->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
