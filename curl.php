<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/4/004
 * Time: 15:22
 */

namespace App\Services;


class Curl
{
    private $ch;

    /**
     * get
     * @param string $url
     * @param array $params
     * @param array $headers
     * @return mixed|string
     */
    public function get(string $url, array $params = [], array $headers = [])
    {
        $initHeader = ["Accept" => "application/json"];
        $headers = array_merge($initHeader, $headers);
        $this->init();
        $this->setHeaders($headers);
        if ($params) {
            $query = http_build_query($params);
            $url = $url . '?' . $query;
        }
        curl_setopt($this->ch, CURLOPT_URL, $url);
        $result = curl_exec($this->ch);
        if(curl_errno($this->ch)){
            return curl_error($this->ch);
        }
        curl_close($this->ch);
        return $this->toArray($result);
    }

    /**
     * post
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed|string
     */
    public function post(string $url, array $data = [], array $headers = [])
    {
        $initHeader = ["Content-type" => "application/json;charset='utf-8'", "Accept" => "application/json"];
        $headers = array_merge($initHeader,$headers);
        $this->init();
        $this->setHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($this->ch);
        if(curl_errno($this->ch)){
            return curl_error($this->ch);
        }
        curl_close($this->ch);
        return $this->toArray($result);
    }

    /**
     * put
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed|string
     */
    public function put(string $url, array $data = [], array $headers = [])
    {
        $this->init();
        $this->setHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($this->ch);
        if(curl_errno($this->ch)){
            return curl_error($this->ch);
        }
        curl_close($this->ch);
        return $this->toArray($result);
    }

    /**
     * patch
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed|string
     */
    public function patch(string $url, array $data = [], array $headers = [])
    {
        $this->init();
        $this->setHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($this->ch);
        if(curl_errno($this->ch)){
            return curl_error($this->ch);
        }
        curl_close($this->ch);
        return $this->toArray($result);
    }

    /** delete
     * @param string $url
     * @param array $data
     * @param array $headers
     * @return mixed|string
     */
    public function delete(string $url, array $data = [], array $headers = [])
    {
        $this->init();
        $this->setHeaders($headers);
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($this->ch);
        if(curl_errno($this->ch)){
            return curl_error($this->ch);
        }
        curl_close($this->ch);
        return $this->toArray($result);
    }

    protected function init()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    protected function setHeaders(array $headers = [])
    {
        $initHeader = [
            "Content-type" => "application/json",
        ];
        $headers = array_merge($initHeader, $headers);
        $httpHeader = [];
        foreach ($headers as $key => $value) {
            array_push($httpHeader, $key . ':' . $value);
        }
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $httpHeader);
    }
    protected function toArray(string $result)
    {
        $response = json_decode($result, true);
        if (is_null($response) || empty($result)) {
            return $result;
        }
        return $response;
    }
}