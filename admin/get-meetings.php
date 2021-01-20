<?php
require_once 'config.php';

 
get_meetings(); 

function get_meetings() {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
    include('header.php');
    try {
        $response = $client->request('GET', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ]
        ]);
        echo "
        <div class='flex flex-wrap overflow-hidden'>
        ";
        $data = json_decode($response->getBody());
        $id = $data->meetings[0]->id;
        $topic = $data->meetings[0]->topic;
        $join = $data->meetings[0]->join_url;

        $status = $data->action;
        foreach($data->meetings as $meeting) {

        echo "
          

              <div class='w-1/2 overflow-hidden lg:w-1/4 xl:my-2 xl:px-2 xl:w-1/4'>
                <div class='card m-2 cursor-pointer border border-gray-400 rounded-lg hover:shadow-md hover:border-opacity-0 transform hover:-translate-y-1 transition-all duration-200'>
                  <div class='m-3'>
                    <h2 class='text-lg'>$meeting->topic 
                      <span class='text-sm text-teal-800 font-mono bg-teal-100 inline rounded-full px-2 align-top float-right animate-pulse'>$meeting->id</span>
                    </h2>
                    <p class='font-light font-mono text-sm text-gray-700 hover:text-gray-900 transition-all duration-200'>
                      Class: $meeting->agenda
                    </p>
                    <p class='font-light font-mono text-sm text-gray-700 hover:text-gray-900 transition-all duration-200'>
                    Duration: $meeting->duration
                    </p>
                    <p class='font-light font-mono text-sm text-gray-700 hover:text-gray-900 transition-all duration-200'>
                    Mot de pass: 123456
                    </p>
                    <p class='font-light font-mono text-sm text-gray-700 hover:text-gray-900 transition-all duration-200'>
                    Duration: $meeting->start_time
                    </p>
                    <div class='text-center mt-5'>
                      <a href='$meeting->join_url' class='text-green-600 text-center bg-green-200 rounded-full hover:text-green-900 px-2 mr-6'>Lancer</a>
                      <a href='' class='text-indigo-600 bg-indigo-200 rounded-full hover:text-indigo-900 px-2 mr-6'>Éditer</a>
                      <a href='delete-meeting.php?meetingid=$meeting->id' class='text-red-600 bg-red-200 rounded-full hover:text-red-900 px-2 mr-6'>Annuler</a>
                    </div>
                  </div>
              </div>
            </div>
         
       ";

            
          }
       echo"</div>";   

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
 
        } else {
            echo $e->getMessage();
        }
    }
}

?>

