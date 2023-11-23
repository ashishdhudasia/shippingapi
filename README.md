# SwaggerClient-php
Shipping Label application

This PHP package is automatically generated by the [Swagger Codegen](https://github.com/swagger-api/swagger-codegen) project:

- API version: v1
- Build package: io.swagger.codegen.v3.generators.php.PhpClientCodegen

## Requirements

PHP 5.5 and later

## Installation & Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/git_user_id/git_repo_id.git"
    }
  ],
  "require": {
    "git_user_id/git_repo_id": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/SwaggerClient-php/vendor/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$apiInstance = new Swagger\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\ShippingLabelAccessCredentials(); // \Swagger\Client\Model\ShippingLabelAccessCredentials | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->create($body, $instance_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->create: ', $e->getMessage(), PHP_EOL;
}

$apiInstance = new Swagger\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 

try {
    $result = $apiInstance->remove($instance_id, $connection_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->remove: ', $e->getMessage(), PHP_EOL;
}

$apiInstance = new Swagger\Client\Api\AuthenticationApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client()
);
$body = new \Swagger\Client\Model\ShippingLabelUpdateCredentials(); // \Swagger\Client\Model\ShippingLabelUpdateCredentials | 
$instance_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$connection_id = "38400000-8cf0-11bd-b23e-10b96e4ef00d"; // string | 
$test_mode = false; // bool | 

try {
    $result = $apiInstance->update($body, $instance_id, $connection_id, $test_mode);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AuthenticationApi->update: ', $e->getMessage(), PHP_EOL;
}
?>
```

## Documentation for API Endpoints

All URIs are relative to *https://api.itembase.com/connectivity*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuthenticationApi* | [**create**](docs/Api/AuthenticationApi.md#create) | **POST** /instances/{instanceId}/connections/shipping/auth/v2 | Create a connection
*AuthenticationApi* | [**remove**](docs/Api/AuthenticationApi.md#remove) | **DELETE** /instances/{instanceId}/connections/{connectionId}/shipping/auth/v2 | Removes a connection
*AuthenticationApi* | [**update**](docs/Api/AuthenticationApi.md#update) | **PUT** /instances/{instanceId}/connections/{connectionId}/shipping/auth/v2 | Update the connection
*HarmonizedSystemCodesApi* | [**getHsCodes**](docs/Api/HarmonizedSystemCodesApi.md#gethscodes) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs | Get Hs codes for list of products
*HarmonizedSystemCodesApi* | [**isClassified**](docs/Api/HarmonizedSystemCodesApi.md#isclassified) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/hs/classificationstatus | Check products classification status
*LinnworksApi* | [**addUser**](docs/Api/LinnworksApi.md#adduser) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/addUser | Add User
*LinnworksApi* | [**callEmpty**](docs/Api/LinnworksApi.md#callempty) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/empty**/** | Empty handler
*LinnworksApi* | [**cancelLabel**](docs/Api/LinnworksApi.md#cancellabel) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/label/cancel | Cancel label
*LinnworksApi* | [**createLabel**](docs/Api/LinnworksApi.md#createlabel) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/label/create | Create label
*LinnworksApi* | [**getAvailableServices**](docs/Api/LinnworksApi.md#getavailableservices) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/availableServices | Get available services
*LinnworksApi* | [**getExternalPropertiesMap**](docs/Api/LinnworksApi.md#getexternalpropertiesmap) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/ExtPropertyMap | Get Extended Property mapping
*LinnworksApi* | [**getUserConfig**](docs/Api/LinnworksApi.md#getuserconfig) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig | Get User Config
*LinnworksApi* | [**updateUserConfig**](docs/Api/LinnworksApi.md#updateuserconfig) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig/update | Update User Config
*LinnworksApi* | [**updateUserConfig1**](docs/Api/LinnworksApi.md#updateuserconfig1) | **POST** /instances/{instanceId}/connections/shipping/api/v2/extint/linnworks/userConfig/delete | Delete User
*LocationsApi* | [**getLocations**](docs/Api/LocationsApi.md#getlocations) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/locations | Get Locations
*ShipmentInfoApi* | [**orderShipmentInfo**](docs/Api/ShipmentInfoApi.md#ordershipmentinfo) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/shipment/order/info | Get Order Shipment Info
*ShipmentInfoApi* | [**trackShipment**](docs/Api/ShipmentInfoApi.md#trackshipment) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/shipment/track | Track Shipment
*ShippingLabelApi* | [**cancelShippingLabel**](docs/Api/ShippingLabelApi.md#cancelshippinglabel) | **DELETE** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Cancel Shipping Label
*ShippingLabelApi* | [**createShippingLabel**](docs/Api/ShippingLabelApi.md#createshippinglabel) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Create Shipping Label
*ShippingLabelApi* | [**getShippingLabel**](docs/Api/ShippingLabelApi.md#getshippinglabel) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/label | Get Shipping Label
*ShippingRateApi* | [**getShippingRate**](docs/Api/ShippingRateApi.md#getshippingrate) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/rate | Get Shipping Rate
*ShippingServicesApi* | [**getServices**](docs/Api/ShippingServicesApi.md#getservices) | **GET** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/services | Get Shipping Services
*TaxAndDutiesApi* | [**getQuotes**](docs/Api/TaxAndDutiesApi.md#getquotes) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/tad/quotes | Get Taxes and Duties quotes
*TaxAndDutiesApi* | [**submitParcel**](docs/Api/TaxAndDutiesApi.md#submitparcel) | **POST** /instances/{instanceId}/connections/{connectionId}/shipping/api/v2/tad/submitOrder | Submit parcel

## Documentation For Models

 - [Address](docs/Model/Address.md)
 - [AddressInfo](docs/Model/AddressInfo.md)
 - [AuthResponse](docs/Model/AuthResponse.md)
 - [AvailableService](docs/Model/AvailableService.md)
 - [CancelShippingLabelResponse](docs/Model/CancelShippingLabelResponse.md)
 - [ClassificationItem](docs/Model/ClassificationItem.md)
 - [ClassificationResponseData](docs/Model/ClassificationResponseData.md)
 - [ConfigStage](docs/Model/ConfigStage.md)
 - [ConsigneeAddress](docs/Model/ConsigneeAddress.md)
 - [ConsignorAddress](docs/Model/ConsignorAddress.md)
 - [CreateShippingLabelRequest](docs/Model/CreateShippingLabelRequest.md)
 - [CreateShippingLabelResponse](docs/Model/CreateShippingLabelResponse.md)
 - [DdpInfo](docs/Model/DdpInfo.md)
 - [EmptyObjectResponse](docs/Model/EmptyObjectResponse.md)
 - [ErrorField](docs/Model/ErrorField.md)
 - [ErrorResponse](docs/Model/ErrorResponse.md)
 - [Event](docs/Model/Event.md)
 - [ExtIntLinnworks](docs/Model/ExtIntLinnworks.md)
 - [ExtendedProperty](docs/Model/ExtendedProperty.md)
 - [ExtendedPropertyItem](docs/Model/ExtendedPropertyItem.md)
 - [GetLocationsResponse](docs/Model/GetLocationsResponse.md)
 - [GetLocationsResponseLocation](docs/Model/GetLocationsResponseLocation.md)
 - [GetShippingLabelResponse](docs/Model/GetShippingLabelResponse.md)
 - [GetShippingRateRequest](docs/Model/GetShippingRateRequest.md)
 - [GetShippingRateResponse](docs/Model/GetShippingRateResponse.md)
 - [GetShippingRateResponseRate](docs/Model/GetShippingRateResponseRate.md)
 - [GetShippingServicesResponse](docs/Model/GetShippingServicesResponse.md)
 - [HsCodesClassificationStatusRequest](docs/Model/HsCodesClassificationStatusRequest.md)
 - [HsCodesClassificationStatusResponse](docs/Model/HsCodesClassificationStatusResponse.md)
 - [HsCodesRequest](docs/Model/HsCodesRequest.md)
 - [HsCodesResponse](docs/Model/HsCodesResponse.md)
 - [InvalidItem](docs/Model/InvalidItem.md)
 - [Item](docs/Model/Item.md)
 - [LandedCost](docs/Model/LandedCost.md)
 - [LineItem](docs/Model/LineItem.md)
 - [LinnworksAddUserRequest](docs/Model/LinnworksAddUserRequest.md)
 - [LinnworksAddUserResponse](docs/Model/LinnworksAddUserResponse.md)
 - [LinnworksExportPropertyMapRequest](docs/Model/LinnworksExportPropertyMapRequest.md)
 - [LinnworksExportPropertyMapResponse](docs/Model/LinnworksExportPropertyMapResponse.md)
 - [LinnworksShippingCancelRequest](docs/Model/LinnworksShippingCancelRequest.md)
 - [LinnworksShippingLabelRequest](docs/Model/LinnworksShippingLabelRequest.md)
 - [LinnworksShippingLabelResponse](docs/Model/LinnworksShippingLabelResponse.md)
 - [LinnworksUpdateConfigRequest](docs/Model/LinnworksUpdateConfigRequest.md)
 - [LinnworksUserAvailableServicesRequest](docs/Model/LinnworksUserAvailableServicesRequest.md)
 - [LinnworksUserAvailableServicesResponse](docs/Model/LinnworksUserAvailableServicesResponse.md)
 - [LinnworksUserConfigItem](docs/Model/LinnworksUserConfigItem.md)
 - [LinnworksUserConfigRequest](docs/Model/LinnworksUserConfigRequest.md)
 - [LinnworksUserConfigResponse](docs/Model/LinnworksUserConfigResponse.md)
 - [ListValue](docs/Model/ListValue.md)
 - [OrderExtendedProperty](docs/Model/OrderExtendedProperty.md)
 - [OrderShipmentInfoRequest](docs/Model/OrderShipmentInfoRequest.md)
 - [OrderShipmentInfoResponse](docs/Model/OrderShipmentInfoResponse.md)
 - [OrderShipmentInfoResponseProduct](docs/Model/OrderShipmentInfoResponseProduct.md)
 - [OrderShipmentInfoResponseShipment](docs/Model/OrderShipmentInfoResponseShipment.md)
 - [Package](docs/Model/Package.md)
 - [Product](docs/Model/Product.md)
 - [ProductsRequest](docs/Model/ProductsRequest.md)
 - [ProductsResponse](docs/Model/ProductsResponse.md)
 - [QuoteRequest](docs/Model/QuoteRequest.md)
 - [QuoteResponse](docs/Model/QuoteResponse.md)
 - [Reason](docs/Model/Reason.md)
 - [SendFrom](docs/Model/SendFrom.md)
 - [SendTo](docs/Model/SendTo.md)
 - [ServiceConfigItem](docs/Model/ServiceConfigItem.md)
 - [ServiceCountry](docs/Model/ServiceCountry.md)
 - [ServiceLevel](docs/Model/ServiceLevel.md)
 - [ServiceProperty](docs/Model/ServiceProperty.md)
 - [Shipment](docs/Model/Shipment.md)
 - [Shipper](docs/Model/Shipper.md)
 - [ShippingLabelAccessCredentials](docs/Model/ShippingLabelAccessCredentials.md)
 - [ShippingLabelUpdateCredentials](docs/Model/ShippingLabelUpdateCredentials.md)
 - [ShippingPackage](docs/Model/ShippingPackage.md)
 - [SubmitParcelRequest](docs/Model/SubmitParcelRequest.md)
 - [SubmitParcelResponse](docs/Model/SubmitParcelResponse.md)
 - [TrackShipmentResponse](docs/Model/TrackShipmentResponse.md)
 - [Value](docs/Model/Value.md)

## Documentation For Authorization

 All endpoints do not require authorization.


## Author



