# Swagger\Client\LocationsApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getLocations**](LocationsApi.md#getlocations) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/locations | Get Locations

# **getLocations**
> \Swagger\Client\Model\GetLocationsResponse getLocations($instance_id, $connection_id, $country, $zip, $test_mode)

Get Locations

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
    // Configure HTTP bearer authorization: bearer-jwt
    $config = Swagger\Client\Configuration::getDefaultConfiguration()
    ->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Swagger\Client\Api\LocationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$country = "country_example"; // string | 
$zip = "zip_example"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getLocations($instance_id, $connection_id, $country, $zip, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocationsApi->getLocations: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | [**string**](../Model/.md)|  |
 **connection_id** | [**string**](../Model/.md)|  |
 **country** | **string**|  |
 **zip** | **string**|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\GetLocationsResponse**](../Model/GetLocationsResponse.md)

### Authorization

[bearer-jwt](../../README.md#bearer-jwt)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

