<?php
require_once 'config.php';
require_once 'index.php';
function create_meeting() {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
 
    try {
        // if you have userid of user than change it with me in url
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => $_GET['mname'],
                "type" => 2,
                "agenda" => $_GET['mdes'],                              
                "start_time" => $_GET['mdate']." ".$_GET['mhour'].":00",    // meeting start time
                "duration" => $_GET['mtime'],                       // 30 minutes
                "password" => "123456"                   // meeting password
            ],
        ]);
 
        $data = json_decode($response->getBody());
    ?>
<div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
  <div class="flex">
    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
    <div>
      <p class="font-bold">Les informations de session</p>
      <p class="text-base"><?php        
        echo "<span class='font-medium'>Join URL: </span>". $data->join_url;
        echo "<br>";
        echo "<span class='font-medium'>Status: </span>". $data->status;
        echo "<br>";
        echo "<span class='font-medium'>Duration: </span>". $data->duration;
        echo "<br>";
        echo $_GET['mdate']." H ".$_GET['mhour'];
        echo "<br>";
        echo "<span class='font-medium'>Meeting Password: </span>". $data->password; ?>
      </p>
    </div>
  </div>
</div>
    <?php
 
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody());
 
            create_meeting();
        } else {
            echo $e->getMessage();
        }
    }
}
 
create_meeting();