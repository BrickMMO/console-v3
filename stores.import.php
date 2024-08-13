<?php

security_check();
admin_check();

$stores_last_import = setting_fetch('STORES_LAST_IMPORT');

$url = 'https://www.lego.com/api/graphql/StoresDirectory';

$query = '
query {
  storesDirectory {
    id
    country
    region
    stores {
      storeId
      name
      phone
      state
      phone
      openingDate
      certified
      additionalInfo
      storeUrl
      urlKey
      isNewStore
      isComingSoon
      __typename
    }
    __typename
  }
}';

$data = array('query' => $query);
$jsonData = json_encode($data);

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData)
));
curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {
    $responseData = json_decode($response, true);

    $query = 'TRUNCATE TABLE stores';
    mysqli_query($connect, $query);

    $query = 'UPDATE settings SET 
    value = NOW() 
    WHERE name = "STORES_LAST_IMPORT" 
    LIMIT 1';
    mysqli_query($connect, $query);

    $stores = [];
    foreach ($responseData['data']['storesDirectory'] as $storesDirectory) {
        foreach ($storesDirectory['stores'] as $store) {
            $query = 'INSERT INTO stores (
                name,
                store_id,
                phone,
                certified,
                additional_info,
                store_url,
                created_at,
                updated_at
            ) VALUES (
                "'.htmlspecialchars($store['name']).'",
                "'.htmlspecialchars($store['storeId']).'",
                "'.htmlspecialchars($store['phone']).'",
                "'.($store['certified'] ? 'Yes' : 'No').'",
                "'.htmlspecialchars($store['additionalInfo']).'",
                "'.htmlspecialchars($store['storeUrl']).'",
                NOW(),
                NOW()
            )';
            mysqli_query($connect, $query);

            $stores[] = [
                'name' => htmlspecialchars($store['name']),
                'storeId' => htmlspecialchars($store['storeId']),
                'phone' => htmlspecialchars($store['phone']),
                'certified' => $store['certified'] ? 'Yes' : 'No',
                'additionalInfo' => htmlspecialchars($store['additionalInfo']),
                'storeUrl' => htmlspecialchars($store['storeUrl'])
            ];
        }
    }
    echo '<script>';
    echo 'let stores = ' . json_encode($stores) . ';';
    echo '</script>';
}
curl_close($curl);

    

define('APP_NAME', 'Stores');

define('PAGE_TITLE', 'Import Stores');
define('PAGE_SELECTED_SECTION', 'admin-content');
define('PAGE_SELECTED_SUB_PAGE', '/stores/import');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'SELECT * 
    FROM stores';
$result = mysqli_query($connect, $query);

?>

<!-- CONTENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/stores.png"
        height="50"
        style="vertical-align: top"
    />
    Stores
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/stores/dashboard">Stores</a> / 
    Import Stores
</p>
<hr />
<h2>Importing Stores</h2>

<p>
    Importing:
    <span class="w3-tag w3-blue" id="repo-count">0/0</span>
    Stores imported from 
    <a href="https://www.lego.com/en-ca/stores">LEGO® Store</a>.
</p>

<hr />

<div class="w3-light-grey w3-margin-bottom">
    <div class="w3-container w3-green w3-padding w3-center" style="width:0%; min-width: 50px;" id="progress">0%</div>
</div>

<div class="w3-container w3-border w3-padding-16 w3-margin-bottom" id="loading" style="max-height: 500px; overflow: scroll;">
    <div class="container" id="storeContainer"></div>
    <h3>
        <i class="fa-solid fa-spinner fa-spin"></i>
        Loading...
    </h3>
</div>

<script>
    let container = document.getElementById('storeContainer');
    let loading = document.getElementById('loading');
    let progress = document.getElementById('progress');
    let repoCount = document.getElementById('repo-count');
    
    repoCount.innerHTML = '0/'+<?=mysqli_num_rows($result)?>;
        let index = 0;

        function showNextCard() {
            if (index < stores.length) {
                let percent = Math.round(((index+1) / <?=mysqli_num_rows($result)?>) * 100)+'%';

                progress.innerHTML = percent;
                progress.style.width = percent;

                repoCount.innerHTML = (index+1)+'/'+<?=mysqli_num_rows($result)?>;

                const store = stores[index];
                const card = document.createElement('div');
                card.className = 'w3-border w3-padding';
                card.innerHTML = `
                    <h2>${store.name}</h2>
                    <p><strong>Store ID:</strong> ${store.storeId}</p>
                    <p><strong>Phone:</strong> ${store.phone}</p>
                    <p><strong>Certified:</strong> ${store.certified}</p>
                    <p><strong>Additional Info:</strong> ${store.additionalInfo}</p>
                    <a href="${store.storeUrl}" target="_blank">Visit Store Page</a>
                `;
                container.appendChild(card);
                setTimeout(() => {
                    card.style.opacity = 1;
                }, 10); // Necesario para forzar la transición

                index++;
                setTimeout(showNextCard, 1000); // Pausa de 2 segundos entre cada carta
            }
        }

        showNextCard();
</script>

    
<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');
