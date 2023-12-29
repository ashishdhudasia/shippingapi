# Swagger\Client\HarmonizedSystemCodesApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getHsCodes**](HarmonizedSystemCodesApi.md#gethscodes) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs | Get Hs codes for list of products
[**isClassified**](HarmonizedSystemCodesApi.md#isclassified) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs/classificationstatus | Check products classification status

# **getHsCodes**
> \Swagger\Client\Model\HsCodesResponse getHsCodes($body, $instance_id, $connection_id, $test_mode)

Get Hs codes for list of products

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\HarmonizedSystemCodesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\HsCodesRequest(); // \Swagger\Client\Model\HsCodesRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getHsCodes($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HarmonizedSystemCodesApi->getHsCodes: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\HsCodesRequest**](../Model/HsCodesRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\HsCodesResponse**](../Model/HsCodesResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **isClassified**
> \Swagger\Client\Model\HsCodesClassificationStatusResponse isClassified($body, $instance_id, $connection_id, $test_mode)

Check products classification status

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\HarmonizedSystemCodesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\HsCodesClassificationStatusRequest(); // \Swagger\Client\Model\HsCodesClassificationStatusRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->isClassified($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HarmonizedSystemCodesApi->isClassified: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\HsCodesClassificationStatusRequest**](../Model/HsCodesClassificationStatusRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\HsCodesClassificationStatusResponse**](../Model/HsCodesClassificationStatusResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

