# Swagger\Client\ShippingRateApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getShippingRate**](ShippingRateApi.md#getshippingrate) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/rate | Get Shipping Rate

# **getShippingRate**
> \Swagger\Client\Model\GetShippingRateResponse getShippingRate($body, $instance_id, $connection_id, $test_mode)

Get Shipping Rate

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\ShippingRateApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\GetShippingRateRequest(); // \Swagger\Client\Model\GetShippingRateRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getShippingRate($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingRateApi->getShippingRate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\GetShippingRateRequest**](../Model/GetShippingRateRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\GetShippingRateResponse**](../Model/GetShippingRateResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

