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

        $data = json_decode($response->getBody());
        $id = $data->meetings[0]->id;
        $topic = $data->meetings[0]->topic;
        $join = $data->meetings[0]->join_url;
        foreach($data->meetings as $meeting) {

        echo "
        <div class='flex flex-col'>
        <div class='-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8'>
          <div class='py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8'>
            <div class='shadow overflow-hidden border-b border-gray-200 sm:rounded-lg'>
              <table class='min-w-full divide-y divide-gray-200'>
                <thead>
                  <tr>
                    <th class='px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider'>
                      Nom de session
                    </th>
                    <th class='px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider'>
                      Date de session
                    </th>
                    <th class='px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider'>
                      Status
                    </th>
                    <th class='px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider'>
                      Class
                    </th>
                    <th class='px-6 py-3 bg-gray-50'></th>
                  </tr>
                </thead>
        <tbody class='bg-white divide-y divide-gray-200'>
            <tr>
              <td class='px-6 py-4 whitespace-no-wrap'>
                <div class='flex items-center'>
                  <div class='ml-4'>
                    <div class='text-sm leading-5 font-medium text-gray-900'>
                     "; echo $meeting->topic.'<br/>';
                    echo "
                    </div>
                    <div class='text-sm leading-5 text-gray-500'>
                    "; echo $meeting->id.'<br/>';
                    echo "
                    </div>
                  </div>
                </div>
              </td>
              <td class='px-6 py-4 whitespace-no-wrap'>
                <div class='text-sm leading-5 text-gray-900'>
                    ";echo $meeting->start_time;
                    echo"
                </div>
                <div class='text-sm leading-5 text-gray-500'>
                    ";echo $meeting->duration.' Minute <br/>';
                    echo "
                </div>
              </td>
              <td class='px-6 py-4 whitespace-no-wrap'>
                <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800'>
                "; echo $meeting->invitation;
                echo "
                </span>
              </td>
              <td class='px-4 py-2 whitespace-no-wrap text-sm leading-5 text-gray-500'>
              "; echo $meeting->agenda;
              echo "
              </td>
              <td class='px-6 py-4 whitespace-no-wrap text-left text-sm leading-5 font-medium'>
                <a href=' "; echo $meeting->join_url;echo" ' class='text-green-600 hover:text-green-900 pr-6'>Lancer</a>
                <a href='' class='text-indigo-600 hover:text-indigo-900 pr-6'>Éditer</a>
                <a href='delete-meeting.php?meetingid="; echo $meeting->id;echo "' class='text-red-600 hover:text-red-900'>Annuler</a>
              </td>
            </tr>

                </tbody>
                </table>
                </div>
                </div>
                    </div>
            </div> ";

            
          }

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

