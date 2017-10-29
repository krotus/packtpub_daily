<?php

namespace PacktpubDaily\libraries;

/**
 * Class RequestManager
 * @package PacktpubDaily\libraries
 */
class RequestManager
{

    /**
     * Methods used
     */
    const GET = "GET";
    const POST = "POST";

    /**
     * HTTP headers and content
     */
    const HEADER_CONTENT_TYPE = "Content-Type";
    const X_WWW_FORM_URLENCODED = "application/x-www-form-urlencoded";

    /**
     * HTTP response codes
     */
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_ACCEPTED = 202;
    const HTTP_STATUS_BAD_REQUEST = 400;
    const HTTP_STATUS_FORBIDDEN = 403;
    const HTTP_STATUS_NOT_FOUND = 404;
    const HTTP_STATUS_IM_A_TEAPOD = 418;
    const HTTP_STATUS_UNPROCESSABLE_ENTITY = 422;

    private $url;
    private $agent;

    public function __construct($url)
    {
        $this->url = $url;
        $this->agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36';
    }

    public function __call($method, $args)
    {
        $request = strtoupper($method);

        if ($request != self::GET && $request != self::POST) {
            throw new \Exception("Invalid request method", 1);
        }

        $params = [];
        if (isset($args[1])) {
            $params = $args[1];
        }

        return $this->request($request, $args[0], $params);
    }

    public function request($method, $path = '', $params = [])
    {
        $headers = [

        ];

        $ch = curl_init();

        if ($method == self::POST) {
            array_push($headers, self::HEADER_CONTENT_TYPE . self::X_WWW_FORM_URLENCODED);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        }

        if (!empty($params) && $method == self::GET) {
            $path .= "?" . http_build_query($params);
        }

        curl_setopt($ch, CURLOPT_URL, $this->url . $path);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie-name');  //could be empty, but cause problems on some hosts
        curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp');  //could be empty, but cause problems on some hosts
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Getting the raw output
        $curlResponse = curl_exec($ch);
        // Getting information about the transfer
        $curlHeaders = curl_getinfo($ch);
        // Fetching results or failing if doesn't work
        if ($curlResponse === false) {
            throw new \Exception("Connection failed: " . curl_error($ch), -2);
        }

        // Closing the HTTP connection
        curl_close($ch);

        return $curlResponse;
    }

}