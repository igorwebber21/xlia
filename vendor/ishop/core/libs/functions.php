<?php

function debug($arr, $exit = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if($exit) exit();
}

function redirect($http = false){

    if($http){
        $redirect = $http;
    }
    else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }

    header("Location: $redirect");
    exit;
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


function date_point_format($date_str)
{
    return $date_str ? date('d.m.Y H:i', strtotime($date_str)) : '';
}


function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}


function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


function getUserLocation($ipAddress)
{
    $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$ipAddress"));
    return $geo['geoplugin_countryName'] ? $geo['geoplugin_countryName'] .', '. $geo['geoplugin_region'] .', '. $geo['geoplugin_city'] : '';
}

