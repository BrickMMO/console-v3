<?php

security_check();
admin_check();

if (!isset($_GET['key']) || !in_array($_GET['key'], explode(',', setting_fetch('GITHUB_ACCOUNTS'))))
{
    message_set('Import Error', 'There was an error importing repos.', 'red');
    header_redirect('/github/dashboard');
}


define('APP_NAME', 'GitHub Scanner');

define('PAGE_TITLE', 'Dashboard');
define('PAGE_SELECTED_SECTION', 'admin-tools');
define('PAGE_SELECTED_SUB_PAGE', '/github/dashboard');

include('templates/html_header.php');
include('templates/nav_header.php');
include('templates/nav_slideout.php');
include('templates/nav_sidebar.php');
include('templates/main_header.php');

include('templates/message.php');

$query = 'DELETE FROM repos 
    WHERE owner = "'.addslashes($_GET['key']).'"';
mysqli_query($connect, $query);

?>

<!-- CONENT -->

<h1 class="w3-margin-top w3-margin-bottom">
    <img
        src="https://cdn.brickmmo.com/icons@1.0.0/colours.png"
        height="50"
        style="vertical-align: top"
    />
    GitHub Tools
</h1>
<p>
    <a href="/city/dashboard">Dashboard</a> / 
    <a href="/github/dashboard">GitHub Tools</a> / 
    Import <?=$_GET['key']?>
</p>
<hr>
<h2>Importing Repos</h2>

<p>
    Importing:
    <span class="w3-tag w3-blue" id="repo-count">0/0</span>
    Importing from: 
    <span class="w3-tag w3-blue"><?=$_GET['key']?></span>
</p>

<div class="w3-light-grey w3-margin-bottom">
    <div class="w3-container w3-green w3-padding w3-center" style="width:0%; min-width: 50px;" id="progress">0%</div>
</div>

<div class="w3-container w3-border w3-padding-16 w3-margin-bottom" id="loading" style="max-height: 500px; overflow: scroll;">
    <h3>
        <i class="fa-solid fa-spinner fa-spin"></i>
        Loading...
    </h3>
</div>

<script>

    async function fetchAccount(account) {
        return fetch('/ajax/github/account/'+account,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                }
            })  
            .then((response)=>response.json())
            .then((responseJson)=>{return responseJson});
    }
    
    async function scanRepo(account,repo) {
        
        return fetch('/ajax/github/scan/account/'+account+'/repo/'+repo,{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                }
            })  
            .then((response)=>response.json())
            .then((responseJson)=>{return responseJson});
    }

    async function scanRepos() {

        let loading = document.getElementById('loading');
        let progress = document.getElementById('progress');
        let repoCount = document.getElementById('repo-count');
        
        const account = '<?=$_GET['key']?>';
        const resultAccount = await fetchAccount(account);
        
        repoCount.innerHTML = '0/'+resultAccount.repos.length;

        for(let i = 0; i < resultAccount.repos.length; i++)
        {

            let percent = Math.round(((i+1) / resultAccount.repos.length) * 100)+'%';

            progress.innerHTML = percent;
            progress.style.width = percent;

            repoCount.innerHTML = (i+1)+'/'+resultAccount.repos.length;

            const resultRepo = await scanRepo(account,resultAccount.repos[i].name);

            if(i == 0) loading.innerHTML = '';

            let div = document.createElement('div');

            let h3 = document.createElement('h3');
            div.append(h3);

            let h3Text = document.createTextNode(resultRepo.repo.name);
            h3.append(h3Text);

            let p = document.createElement('p');
            p.innerHTML = 'Repo has <span class="w3-tag w3-blue" id="repo-count">'+resultRepo.errors.length+
                '</span> errors and <span class="w3-tag w3-blue" id="repo-count">'+resultRepo.pull_requests+
                '</span> pull requests.';
            div.append(p);

            // let pText = document.createTextNode('Repo has <span class="w3-tag w3-blue" id="repo-count">0/0</span> errors and <span class="w3-tag w3-blue" id="repo-count">0/0</span> pull requests.');
            // p.append(pText);

            let ul = document.createElement('ul');
            div.append(ul);

            for(let i = 0; i < resultRepo.errors.length; i++)
            {
                ul.innerHTML += '<li>'+resultRepo.errors[i]+'</li>';
            }

            let a = document.createElement('a');
            a.href = '/github/repo/'+resultRepo.repo.name;
            a.innerHTML = '<i class="fa-brands fa-github" aria-hidden="true"></i> /'+resultRepo.repo.full_name;
            div.append(a);

            // let aText = document.createTextNode(resultRepo.repo.html_url);
            // a.append(aText);

            let hr = document.createElement('hr');
            div.append(hr);

            loading.prepend(div);
             

            await new Promise(resolve => setTimeout(resolve, 0));

        }
            
    }

    scanRepos();

</script>


<?php

include('templates/modal_city.php');

include('templates/main_footer.php');
include('templates/debug.php');
include('templates/html_footer.php');
