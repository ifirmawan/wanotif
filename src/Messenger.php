<?php

namespace ifirmawan\Wanotif;

class Messenger {

    protected $toNumber;
    protected $message;
    protected $errors;
    private $response;
    private $config;

    public function __construct(array $config)
    {
        $this->setConfig($config);
    }

    private function setConfig(array $config)
    {
        $this->config = $config;
        $errors = array();
        if (isset($this->config['url'])) {
            if (!filter_var($this->config['url'], FILTER_VALIDATE_URL)) {
                $errors[] = 'url not valid';
            } 
        }else{
            $errors[] = 'please set url configuration';
        }

        if (!isset($this->config['api_key'])) {
            $errors[] = 'please set API KEY configuration';
        }
        
        if ($errors) {
            $this->errors = $errors;
        }
    }

    private function setResponse(string $response){
        $this->response = $response;
    }

    public function setMessage(string $toNumber,string $text)
    {
        $this->toNumber = $toNumber;
        $this->message  = $text;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function sendMessage()
    {
        $config = $this->getConfig();
    
        $data['api_key']        = $config['api_key']; 
        $data['mobile']         = $this->toNumber;
        $data['message']        = $this->message;
        $data['reference_id']   = 1;

        $url = $config['url'];
        $this->curl_formdata_request($url,$data);
        return $this;
    }
    
    private function curl_formdata_request($url,$data)
    {
        $inputs = array();
        if ($data) {
            
            foreach($data as $key => $value){
                $inputs[] = "$key=$value";
            }
        }

        $formdata = implode('&',$inputs);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$formdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        $this->setResponse($response);
    }
}