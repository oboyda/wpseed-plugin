<?php

namespace HSP;

class Api_Req
{
    const API_BASE = 'http://websiteapi.egorealestate.com';
    const API_VER  = 'v1';

    static function get($branch, $resource, $headers=[])
    {
        $args = [
            'headers' => self::getDefaultHeaders($branch, $headers)
        ];
        $resp = wp_remote_get(
            self::getEndpointUrl($resource), 
            $args
        );

        $resp_status_code = (int)wp_remote_retrieve_response_code($resp);
        $resp_body = wp_remote_retrieve_body($resp);

        // file_put_contents(ABSPATH . '/__debug.txt', print_r([time(), $branch, $args, $resp], true));

        return [
            'status_code' => $resp_status_code,
            'data' => $resp_body ? json_decode($resp_body, true) : []
        ];
    }

    static function post($branch, $resource, $payload, $headers=[])
    {
        $args = [
            'headers' => self::getDefaultHeaders($branch, $headers),
            // 'body' => json_encode($payload)
            'body' => $payload
        ];
        $resp = wp_remote_post(
            self::getEndpointUrl($resource), 
            $args
        );

        $resp_status_code = (int)wp_remote_retrieve_response_code($resp);
        $resp_body = wp_remote_retrieve_body($resp);

        // file_put_contents(ABSPATH . '/__debug.txt', print_r([time(), $args, $resp], true));

        return [
            'status_code' => $resp_status_code,
            'data' => $resp_body ? json_decode($resp_body, true) : []
        ];
    }

    static function getEndpointUrl($resource)
    {
        return self::API_BASE . '/' . self::API_VER . $resource;
    }

    static function getDefaultHeaders($branch, $headers=[])
    {
        return wp_parse_args($headers, [
            'AuthorizationToken' => self::getToken($branch),
            'Accept' => 'application/json'
            // 'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }

    static function getToken($branch)
    {
        // $tokens = [
        //     'madrid' => 'R68xYd4mLk3j7vCHN2mwA2MlKf3KJD+Q/pDzbhB6w04pQ/OBbu4Y9tFOH8M17sg2',
        //     'ibiza' => '7fVjF9tOQpxH3F4QZAJFqY31uBFAzeV9FMj3fqGZvWQs5HwSO7C0dckINJ1pbOkv'
        // ];
        // return isset($tokens[$branch]) ? $tokens[$branch] : false;

        $branch_term = is_int($branch) ? get_term($branch, 'branch') : get_term_by('slug', $branch, 'branch');

        return is_a($branch_term, 'WP_Term') ? get_term_meta($branch_term->term_id, 'api_key', true) : false;
    }
}
