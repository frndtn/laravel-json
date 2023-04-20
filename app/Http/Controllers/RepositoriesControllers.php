<?php

namespace App\Http\Controllers;

class RepositoriesControllers extends Controller
{

    public function repositories()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pokeapi.co/api/v2/pokemon/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HEADER => array()
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        //save response curl to database
        $this->saveData(json_encode($response));
        echo $response;
    }

    public function dataJson()
    {
        $data = '{"custom":[{"type":"parent","id":1},{"type":"children","id":2,"data":"Hallo Im Apple","parent_id":1},{"type":"parent","id":3},{"type":"children","id":4,"data":"Hallo Im Orange","parent_id":3},{"type":"children","id":5,"data":"Hallo Im Banana","parent_id":3},{"type":"children","id":6,"data":"Hallo Im Human","parent_id":null}]}';

        $result = [];

        $data = json_decode($data, true);

        foreach ($data['custom'] as $key => $value) {
            if (!isset($value['parent_id'])) {
                $result[$value['id']] = $value;
            } else {
                $result[$value['parent_id']]['data'][] = $value;
            }
        }

        $data['custom'] = $result;
        $result = json_encode($data);

        echo $result;
    }
}
