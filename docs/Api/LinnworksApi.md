# Swagger\Client\LinnworksApi

All URIs are relative to *https://api.itembase.com/connectivity*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addUser**](LinnworksApi.md#adduser) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/addUser | Add User
[**callEmpty**](LinnworksApi.md#callempty) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/empty**/** | Empty handler
[**cancelLabel**](LinnworksApi.md#cancellabel) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/label/cancel | Cancel label
[**createLabel**](LinnworksApi.md#createlabel) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/label/create | Create label
[**getAvailableServices**](LinnworksApi.md#getavailableservices) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/availableServices | Get available services
[**getExternalPropertiesMap**](LinnworksApi.md#getexternalpropertiesmap) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/ExtPropertyMap | Get Extended Property mapping
[**getUserConfig**](LinnworksApi.md#getuserconfig) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig | Get User Config
[**updateUserConfig**](LinnworksApi.md#updateuserconfig) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig/update | Update User Config
[**updateUserConfig1**](LinnworksApi.md#updateuserconfig1) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig/delete | Delete User

# **addUser**
> \Swagger\Client\Model\LinnworksAddUserResponse addUser($body, $instance_id, $test_mode)

Add User

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksAddUserRequest(); // \Swagger\Client\Model\LinnworksAddUserRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->addUser($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->addUser: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksAddUserRequest**](../Model/LinnworksAddUserRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\LinnworksAddUserResponse**](../Model/LinnworksAddUserResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **callEmpty**
> \Swagger\Client\Model\EmptyObjectResponse callEmpty()

Empty handler

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);

try {
    $result = $apiInstance->callEmpty();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->callEmpty: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**\Swagger\Client\Model\EmptyObjectResponse**](../Model/EmptyObjectResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **cancelLabel**
> \Swagger\Client\Model\EmptyObjectResponse cancelLabel($body, $instance_id, $test_mode)

Cancel label

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksShippingCancelRequest(); // \Swagger\Client\Model\LinnworksShippingCancelRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->cancelLabel($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->cancelLabel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksShippingCancelRequest**](../Model/LinnworksShippingCancelRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\EmptyObjectResponse**](../Model/EmptyObjectResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **createLabel**
> \Swagger\Client\Model\LinnworksShippingLabelResponse createLabel($body, $instance_id, $test_mode)

Create label

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksShippingLabelRequest(); // \Swagger\Client\Model\LinnworksShippingLabelRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->createLabel($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->createLabel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksShippingLabelRequest**](../Model/LinnworksShippingLabelRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\LinnworksShippingLabelResponse**](../Model/LinnworksShippingLabelResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getAvailableServices**
> \Swagger\Client\Model\LinnworksUserAvailableServicesResponse getAvailableServices($body, $instance_id, $test_mode)

Get available services

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksUserAvailableServicesRequest(); // \Swagger\Client\Model\LinnworksUserAvailableServicesRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getAvailableServices($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->getAvailableServices: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksUserAvailableServicesRequest**](../Model/LinnworksUserAvailableServicesRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\LinnworksUserAvailableServicesResponse**](../Model/LinnworksUserAvailableServicesResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getExternalPropertiesMap**
> \Swagger\Client\Model\LinnworksExportPropertyMapResponse getExternalPropertiesMap($body, $instance_id, $test_mode)

Get Extended Property mapping

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksExportPropertyMapRequest(); // \Swagger\Client\Model\LinnworksExportPropertyMapRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getExternalPropertiesMap($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->getExternalPropertiesMap: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksExportPropertyMapRequest**](../Model/LinnworksExportPropertyMapRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\LinnworksExportPropertyMapResponse**](../Model/LinnworksExportPropertyMapResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getUserConfig**
> \Swagger\Client\Model\LinnworksUserConfigResponse getUserConfig($body, $instance_id, $test_mode)

Get User Config

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksUserConfigRequest(); // \Swagger\Client\Model\LinnworksUserConfigRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->getUserConfig($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->getUserConfig: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksUserConfigRequest**](../Model/LinnworksUserConfigRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\LinnworksUserConfigResponse**](../Model/LinnworksUserConfigResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateUserConfig**
> \Swagger\Client\Model\EmptyObjectResponse updateUserConfig($body, $instance_id, $test_mode)

Update User Config

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksUpdateConfigRequest(); // \Swagger\Client\Model\LinnworksUpdateConfigRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->updateUserConfig($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->updateUserConfig: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksUpdateConfigRequest**](../Model/LinnworksUpdateConfigRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\EmptyObjectResponse**](../Model/EmptyObjectResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateUserConfig1**
> \Swagger\Client\Model\EmptyObjectResponse updateUserConfig1($body, $instance_id, $test_mode)

Delete User

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\LinnworksApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\LinnworksUserConfigRequest(); // \Swagger\Client\Model\LinnworksUserConfigRequest | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->updateUserConfig1($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LinnworksApi->updateUserConfig1: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Swagger\Client\Model\LinnworksUserConfigRequest**](../Model/LinnworksUserConfigRequest.md)|  |
 **instance_id** | [**string**](../Model/.md)|  |
 **test_mode** | **bool**|  | [optional] [default to false]

### Return type

[**\Swagger\Client\Model\EmptyObjectResponse**](../Model/EmptyObjectResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: */*

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

