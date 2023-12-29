# Swagger\Client\TaxAndDutiesApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getQuotes**](TaxAndDutiesApi.md#getquotes) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/tad/quotes | Get Taxes and Duties quotes
[**submitParcel**](TaxAndDutiesApi.md#submitparcel) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/tad/submitOrder | Submit parcel

# **getQuotes**
> \Swagger\Client\Model\QuoteResponse getQuotes($body, $instance_id, $connection_id, $test_mode)

Get Taxes and Duties quotes

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\TaxAndDutiesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\QuoteRequest(); // \Swagger\Client\Model\QuoteRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getQuotes($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TaxAndDutiesApi->getQuotes: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\QuoteRequest**](../Model/QuoteRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\QuoteResponse**](../Model/QuoteResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **submitParcel**
> \Swagger\Client\Model\SubmitParcelResponse submitParcel($body, $instance_id, $connection_id, $test_mode)

Submit parcel

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\TaxAndDutiesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\SubmitParcelRequest(); // \Swagger\Client\Model\SubmitParcelRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->submitParcel($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TaxAndDutiesApi->submitParcel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\SubmitParcelRequest**](../Model/SubmitParcelRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\SubmitParcelResponse**](../Model/SubmitParcelResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

