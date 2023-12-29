# Swagger\Client\ShippingLabelApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**cancelShippingLabel**](ShippingLabelApi.md#cancelshippinglabel) | **DELETE** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Cancel Shipping Label
[**createShippingLabel**](ShippingLabelApi.md#createshippinglabel) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Create Shipping Label
[**getShippingLabel**](ShippingLabelApi.md#getshippinglabel) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Get Shipping Label

# **cancelShippingLabel**
> \Swagger\Client\Model\CancelShippingLabelResponse cancelShippingLabel($instance_id, $connection_id, $shipper_reference, $tracking_number, $shipment_id, $test_mode)

Cancel Shipping Label

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\ShippingLabelApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$shipper_reference = "shipper_reference_example"; // string | 
$tracking_number = "tracking_number_example"; // string | 
$shipment_id = "shipment_id_example"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->cancelShippingLabel($instance_id, $connection_id, $shipper_reference, $tracking_number, $shipment_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingLabelApi->cancelShippingLabel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **shipper_reference** | **string**|  | [optional]
 **tracking_number** | **string**|  | [optional]
 **shipment_id** | **string**|  | [optional]
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\CancelShippingLabelResponse**](../Model/CancelShippingLabelResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createShippingLabel**
> \Swagger\Client\Model\CreateShippingLabelResponse createShippingLabel($body, $instance_id, $connection_id, $test_mode)

Create Shipping Label

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\ShippingLabelApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Swagger\Client\Model\CreateShippingLabelRequest(); // \Swagger\Client\Model\CreateShippingLabelRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->createShippingLabel($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingLabelApi->createShippingLabel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\CreateShippingLabelRequest**](../Model/CreateShippingLabelRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\CreateShippingLabelResponse**](../Model/CreateShippingLabelResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getShippingLabel**
> \Swagger\Client\Model\GetShippingLabelResponse getShippingLabel($instance_id, $connection_id, $label_format, $shipper_reference, $shipment_id, $tracking_number, $test_mode)

Get Shipping Label

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\ShippingLabelApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$label_format = "label_format_example"; // string | 
$shipper_reference = "shipper_reference_example"; // string | 
$shipment_id = "shipment_id_example"; // string | 
$tracking_number = "tracking_number_example"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getShippingLabel($instance_id, $connection_id, $label_format, $shipper_reference, $shipment_id, $tracking_number, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShippingLabelApi->getShippingLabel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **label_format** | **string**|  | [optional]
 **shipper_reference** | **string**|  | [optional]
 **shipment_id** | **string**|  | [optional]
 **tracking_number** | **string**|  | [optional]
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\GetShippingLabelResponse**](../Model/GetShippingLabelResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

