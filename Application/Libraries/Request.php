<?php

namespace Application\Libraries;

class Request
{

    /**
     * General CURL request to any url
     */
    public static function call($do, $vars = array(), $methodRequest = 'GET', $headers = [])
    {
        // Initiate CURL
        $ch = curl_init();

        $link = $do;

        if ($methodRequest == 'GET' && count($vars) >= 1) {
            $link = $link . '?' . http_build_query($vars);
        }

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $link);

        // If it is POST or PUT, set it up
        if ($methodRequest == 'POST' || $methodRequest == 'PUT') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($vars));
        }

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Get the response
        $response = curl_exec($ch);

        // Close CURL
        curl_close($ch);

        // Decode the response
        $response = json_decode($response);

        if (!$response) {
            $response = (object) [];
        }

        $response->request_link = $link;
        $response->vars = http_build_query($vars);

        return $response;
    }
}