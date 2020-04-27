<?php

namespace Siberian;

/**
 * Class Push
 * @package Siberian
 */
class Push
{

    /**
     * @param null $adminId
     * @return Response
     */
    public static function listApps($adminId = null)
    {
        $endpoint = 'push/api_global/list';

        # Building data
        if ($adminId === null) {
            $data = [
                'all' => 1,
            ];
        } else {
            $data = [
                'admin_id' => $adminId,
            ];
        }

        return Request::post($endpoint, $data);
    }

    /**
     * @param $title
     * @param $message
     * @param array $checked // [42 => true, 43 => true]
     * @param bool $send_to_all
     * @param string $devices
     * @param bool $open_url
     * @param null $url
     * @param null $cover must be a base64 image png or jpg
     * @param bool $dry_run
     * @return Response
     * @throws \Exception
     */
    public static function send($title, $message, $checked = [], $send_to_all = false, $devices = 'all',
                                $open_url = false, $url = null, $cover = null, $dry_run = false)
    {
        $endpoint = 'push/api_global/send';

        if (empty($title) || empty($message)) {
            throw new \Exception('#400 Title & Message are required.');
        }

        if (empty($checked) && !$send_to_all) {
            throw new \Exception('#401 Please select at least one application.');
        }

        if ($open_url && empty($url)) {
            throw new \Exception('#402 An URL is required when \$open_url is set to true.');
        }

        # Building data
        $data = [
            'title' => $title,
            'message' => $message,
            'checked' => $checked,
            'send_to_all' => $send_to_all,
            'devices' => $devices,
            'open_url' => $open_url,
            'url' => $url,
            'cover' => $cover,
            'dry_run' => $dry_run,
        ];

        return Request::post($endpoint, $data);
    }

}