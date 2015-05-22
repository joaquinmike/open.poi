<?php

namespace Util\Util;

class Util {

   /**
    * 
    * @param type $uri
    * @param type $params
    * @param type $method
    * @param type $usuario
    * @param type $password
    * @param type $image
    * @return string
    */
    public static function callServices(
            $uri,
            $params,
            $method = 'POST',
            $usuario = null,
            $password = null,
            $image = array('status' => false)) {
        
        $response = array('status' => 1, 'message' => 'Por procesar');
        try {
            $clientConfig = array(
                'adapter' => 'Zend\Http\Client\Adapter\Curl',
                'curloptions' => array(
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_SSL_VERIFYPEER => FALSE
                ),
            );

            $client = new \Zend\Http\Client($uri, $clientConfig);
            if (!empty($usuario)) {
                $client->setAuth($usuario, $password);
            }
            $client->setMethod($method);
            $client->setParameterPost($params);
            if($image['status']){
                $client->setFileUpload($image['filename'], 'img');
            }
            $responseHttp = $client->send();
            //var_dump($uri,$method,$responseHttp->getBody());
            
            if ($responseHttp->isSuccess()) {
                $response = json_decode($responseHttp->getBody(), true);
                $response["status"] = 1;
            } else {
                $response["status"] = -2;
                $response['message'] = $responseHttp->getStatusCode() . '=> ' . $responseHttp->getReasonPhrase();
                //throw new \Exception($responseHttp->getStatusCode() . '=> ' . $responseHttp->getReasonPhrase());
            }
        } catch (\Exception $e) {
            $response["status"] = -1;
            $response['message'] = $e->getMessage() . $e->getTraceAsString();
        }
        return $response;
    }

    /**
     * 
     * @param string $fileName
     * @param type $config
     * @return type
     */
    public static function readFile($fileName, $config) {
        $response = array();
        
        $file = 'data/xml/' . $fileName;
        /*$basePatch = 'Generado/';
        $fileName = $basePatch . $fileName;
        $ftp = new \FtpClient\FtpClient();
        $ftp->connect($config['ftp']['host']);
        $ftp->login($config['ftp']['user'], $config['ftp']['password']);
        $ftp->pasv(true);
        $ftp->get($file, $fileName, 1);*/
        if(file_exists($file)){
            $fileOpen = simplexml_load_file($file);
            $data = json_decode(json_encode($fileOpen), true);
            if (!empty($data)) {
                foreach ($data as $indice => $value) {
                    foreach ($value as $valOrder) {
                        $response[] = $valOrder;
                    }
                }
            }
            $response = array('status' => 1,'message' => 'PROCESADO', 'data' => $response);
        }
        else{
            $response = array('status' => -1,'message' => 'NO EXITE ARCHIVO EN EL SERVIDOR '. date('Y/m/d'), 'data' => $response);
        }
        return $response;
    }

    public static function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb"); 
        fwrite($ifp, base64_decode($base64_string)); 
        fclose($ifp); 
        return $output_file; 
    }
    public static function stripTags($params)
    {
        $filter = new \Zend\Filter\StripTags();
        if (!empty($params)) {
            foreach ($params as $indice => $value) {
                if (is_array($value)) {
                    foreach ($value as $indOne => $valueOne) {
                        if (is_array($valueOne)) {
                            foreach ($valueOne as $indTwo => $valueTwo) {
                                $params[$filter->filter($indice)][$filter->filter($indOne)][$filter->filter($indTwo)] = $filter->filter($valueTwo);
                            }
                        } else {
                            $params[$filter->filter($indice)][$filter->filter($indOne)] = $filter->filter($valueOne);
                        }
                    }
                } else {
                    $params[$filter->filter($indice)] = $filter->filter($value);
                }
            }
        }
        return $params;
    }

    public static function mergeParams($paramsData)
    {
        $params = array();
        foreach ($paramsData as $valueOne) {
            if (!empty($valueOne)) {
                foreach ($valueOne as $indice => $value) {
                    $params[$indice] = $value;
                }
            }
        }

        return$params;
    }
    
    /**
     * @return string
     */
    public static function getRealIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
    
    /**
     * @param $checkoutAlias
     * @return boolean
     */
    public static function isCustomFront($checkoutAlias)
    {
        
        $response = false;
        $path = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/public/s/partners/' . $checkoutAlias;
        if (file_exists($path)) {
            $response = true;
        }
        if(empty($checkoutAlias)){
            $response = false;
        }

        return $response;
    }
    
    public static function isCustomFrontHtml($checkoutAlias)
    {
        $response = false;
        $path = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/public/s/partners/' . $checkoutAlias . '/order.phtml';
        if (file_exists($path)) {
            $response = true;
        }

        return $response;
    }
}
