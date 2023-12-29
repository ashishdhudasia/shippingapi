# Swagger\Client\ShoplineApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getRates**](ShoplineApi.md#getrates) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/extint/shopline/rates | Get Rates

# **getRates**
> \Swagger\Client\Model\ShoplineExtGetRatesResponse getRates($body, $instance_id, $connection_id)

Get Rates

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\ShoplineApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\ShoplineExtGetRatesRequest(); // \Swagger\Client\Model\ShoplineExtGetRatesRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 

try {
    $result = $apiInstance->getRates($body, $instance_id, $connection_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShoplineApi->getRates: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\ShoplineExtGetRatesRequest**](../Model/ShoplineExtGetRatesRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |

### Return type

[**\Swagger\Client\Model\ShoplineExtGetRatesResponse**](../Model/ShoplineExtGetRatesResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

