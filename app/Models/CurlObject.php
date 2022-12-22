<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Curl Object which has URL, Request Type, Headers and Post Fields as parameters
 * @param string $requestType controls whether the request is GET, POST, PUT
 * @param array $headers a list of headers which are attached to the request
 * @param array $postFields a list of keys and values that are the post fields when sending post information via API
 * @param string $url the URL which the request is being sent to.
 *
 */
class CurlObject
{
    private string $url;
    private string $requestType;
    private array $postFields;
    private array $headers;
    public function __construct(string $url, string $requestType, array $headers = [], array $postFields =[])
    {
        $this->url=$url;
        $this->requestType=$requestType;
        $this->headers=$headers;
        $this->postFields=$postFields;
    }

    /**
     * Gets URL from an instantiated object.
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * Gets Request Type from instantiated object.
     * @return string
     *
     */
    public function getRequestType(): string {
        return $this->requestType;
    }
    public function getHeaders(): array {
        return $this->headers;
    }
    public function getPostFields(): array {
        return $this->postFields;
    }
    /**
     * @param array $params
     * @return string
     */
    public static function buildPostFields(array $params): string
    {
        $str_param='';
        foreach($params as $key=>$value) {
            $str_param .= $key . '=' . urlencode($value) . '&';
        }
        return $str_param;
    }

    public function request($asArray = False)
    {
        $stringifyPostFields=$this::buildPostFields($this->getPostFields());
        $request=curl_init();
        curl_setopt_array($request, array(
                CURLOPT_URL => $this->getURL(),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $this->getRequestType(),
                CURLOPT_POSTFIELDS => $stringifyPostFields,
                CURLOPT_HTTPHEADER => $this->getHeaders()
            )
        );
        $response=json_decode(curl_exec($request), $asArray);
        curl_close($request);
        return $response;
    }


}
