<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurlObject extends Model
{
    use HasFactory;
    public string $url;
    public string $requestType;
    public array $postFields;
    private array $headers;
    public function __construct($url = '', string $requestType, $headers = [], $postFields =[])
    {
        $this->url=$url;
        $this->requestType=$requestType;
        $this->headers=$headers;
        $this->postFields=$postFields;
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
    public function request()
    {
        $stringifyPostFields=$this::buildPostFields($this->postFields);
        $request=curl_init();
        curl_setopt_array($request, array(
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $this->requestType,
                CURLOPT_POSTFIELDS => $stringifyPostFields,
                CURLOPT_HTTPHEADER => $this->headers
            )
        );
        $response=json_decode(curl_exec($request));
        curl_close($request);
        return $response;
    }


}
