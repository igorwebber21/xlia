<?php


namespace app\controllers;


class NovaPoshtaController extends AppController
{
    private const API_KEY = '18995eae0107bc7dacf8afcf9047553d';

    public function searchSettlementsAction()
    {
        if(isset($_GET['userCitySearch']))
        {
            $userCitySearch = trim($_GET['userCitySearch']);

            $postFields = [
                "apiKey" => self::API_KEY,
                "modelName" => "Address",
                "calledMethod" => "searchSettlements",
                "methodProperties" => [
                    "CityName" => $userCitySearch,
                    "Limit" => 5
                ]
            ];

            $response = self::sendData($postFields);
            $res = json_decode($response, true);

            if($res['data'])
            {
                $addresses = $res['data'][0]['Addresses'];
                echo json_encode($addresses);
            }
            else{
                echo json_encode('no-results');
            }

            exit;
        }
    }

    public function getWarehousesAction()
    {

        if(isset($_GET['cityRef']))
        {

            $cityRef = trim($_GET['cityRef']);

            $postFields = [
                "apiKey" => self::API_KEY,
                "modelName" => "AddressGeneral",
                "calledMethod" => "getWarehouses",
                "methodProperties" => [
                    "Language" => "ru",
                    "CityRef" => $cityRef
                ]
            ];

            $response = self::sendData($postFields);
            $res = json_decode($response, true);

            if($res['data'])
            {
                echo json_encode($res['data']);
            }
            else{
                echo json_encode('no-results');
            }

            exit;

        }

    }


    public static function sendData($postFields)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.novaposhta.ua/v2.0/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("content-type: application/json",),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return !$err ? $response : "no-results";
    }
}