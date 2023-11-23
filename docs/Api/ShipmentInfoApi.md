# Swagger\Client\ShipmentInfoApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**orderShipmentInfo**](ShipmentInfoApi.md#ordershipmentinfo) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/shipment/order/info | Get Order Shipment Info
[**trackShipment**](ShipmentInfoApi.md#trackshipment) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/shipment/track | Track Shipment

# **orderShipmentInfo**
> \Swagger\Client\Model\OrderShipmentInfoResponse orderShipmentInfo($body, $instance_id, $connection_id, $test_mode)

Get Order Shipment Info

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\ShipmentInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\OrderShipmentInfoRequest(); // \Swagger\Client\Model\OrderShipmentInfoRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->orderShipmentInfo($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShipmentInfoApi->orderShipmentInfo: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\OrderShipmentInfoRequest**](../Model/OrderShipmentInfoRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\OrderShipmentInfoResponse**](../Model/OrderShipmentInfoResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **trackShipment**
> \Swagger\Client\Model\TrackShipmentResponse trackShipment($instance_id, $connection_id, $shipper_reference, $tracking_number, $test_mode)

Track Shipment

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\ShipmentInfoApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$shipper_reference = "shipper_reference_example"; // string | 
$tracking_number = "tracking_number_example"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->trackShipment($instance_id, $connection_id, $shipper_reference, $tracking_number, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ShipmentInfoApi->trackShipment: ', $e->getMessage(), PHP_EOL;
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
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\TrackShipmentResponse**](../Model/TrackShipmentResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

