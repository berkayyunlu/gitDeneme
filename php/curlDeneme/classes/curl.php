<?php

class Curl
{
    private $url;
    private $jsonFlag;
    private $result;

    public function __construct(string $url, $jsonFlag = false)
    {
        $this->url = $url;
        $this->jsonFlag = $jsonFlag;
    }

    public function getResult()
    {
        $ch = curl_init();

        // Return Page contents.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //grab URL and pass it to the variable.
        curl_setopt($ch, CURLOPT_URL, $this->url);

        $this->result = curl_exec($ch);

        if ($this->jsonFlag)
            $this->result = json_decode($this->result);

        return $this->result;
    }
}
