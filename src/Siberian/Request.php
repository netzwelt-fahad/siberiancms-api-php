<?php

namespace Siberian;

/**
 * Class Request
 * @package Siberian
 */
class Request
{
    /**
     * @param $endpoint
     * @param $data
     * @return Response
     * @throws \Exception
     */
    public static function post($endpoint, $data)
    {
        $url = \Siberian\Api::$host . $endpoint;

        # Appending current Api version
        $data["api_version"] = \Siberian\Api::$version;

        $request = curl_init();

        # Setting options
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_TIMEOUT, 3);
        curl_setopt($request, CURLOPT_POST, true);
        switch (\Siberian\Api::$authType) {
            case 'basic':
                $credentials = \Siberian\Api::$username . ":" . \Siberian\Api::$password;
                curl_setopt($request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($request, CURLOPT_USERPWD, $credentials);
                break;
            case 'bearer':
                $bearerToken = \Siberian\Api::$bearerToken;
                curl_setopt($request, CURLOPT_HTTPHEADER, [
                    'Api-Auth-Bearer: Bearer ' . $bearerToken
                ]);
                break;
        }

        # Query string
        $query_string = http_build_query($data);
        curl_setopt($request, CURLOPT_POSTFIELDS, $query_string);

        # Call
        $result = curl_exec($request);
        $status_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

        # Closing connection
        curl_close($request);

        return new \Siberian\Response($status_code, $result);
    }
}