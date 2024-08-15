<?php

// TODO
// If not logged in
// Check for key

if(!security_is_logged_in())
{
    $data = array('message' => 'Must be logged in to use this ajax call.', 'error' => false);
}

$url = 'https://www.lego.com/api/graphql/StoreInfo';

$query = '
query StoreInfo($urlKey: String!) {
  storeInfo(urlKey: $urlKey) {
    storeId
    name
    phone
    openingTimes {
      day
      timeRange
      __typename
    }
    coordinates {
      lat
      lng
      __typename
    }
    storeUrl
    urlKey
    streetAddress
    city
    postalCode
    state
    region
    openingDate
    certified
    additionalInfo
    isNewStore
    isComingSoon
    storeFeatures
    events {
      urlKey
      heading
      subHeading
      thumbnailImage {
        small {
          url
          width
          height
          maxPixelDensity
          format
          __typename
        }
        large {
          url
          width
          height
          maxPixelDensity
          format
          __typename
        }
        __typename
      }
      __typename
    }
    description
    storeImage {
      small {
        url
        width
        height
        maxPixelDensity
        format
        __typename
      }
      large {
        url
        width
        height
        maxPixelDensity
        format
        __typename
      }
      __typename
    }
    __typename
  }
}';

$variables = array('urlKey' => $_GET['urlKey']);

$data = array(
    'operationName' => 'StoreInfo',
    'variables' => $variables,
    'query' => $query
);

$jsonData = json_encode($data);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $storeInfo = json_decode($response, true);   
}

curl_close($ch);

$query = 'INSERT INTO stores (
  name,
  store_id,
  phone,
  certified,
  additional_info,
  store_url,
  image,
  created_at,
  updated_at
) VALUES (
  "'.addslashes($storeInfo['data']['storeInfo']['name']).'",
  "'.addslashes($storeInfo['data']['storeInfo']['storeId']).'",
  "'.addslashes($storeInfo['data']['storeInfo']['phone']).'",
  "'.($storeInfo['data']['storeInfo']['certified'] ? 'Yes' : 'No').'",
  "'.addslashes($storeInfo['data']['storeInfo']['additionalInfo']).'",
  "'.addslashes($storeInfo['data']['storeInfo']['storeUrl']).'",  
  '.(($storeInfo['data']['storeInfo']['storeImage'] !== NULL) ? '"data:image/jpeg;base64, '.base64_encode(file_get_contents(addslashes($storeInfo['data']['storeInfo']['storeImage']['small']['url']))) .'"' : 'NULL' ).',
  NOW(),
  NOW()
)';
mysqli_query($connect, $query);

$data = array(
    'message' => 'LEGO Store information has been retrieved.',
    'error' => false, 
    'storeInfo' => $storeInfo
);
