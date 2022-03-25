<?php
require_once ('constants.php');
class apiClass
{
    public $apiClassName;
    public $apiMethodName;
    public $apiMethodParams;
    public $resultFunctionCall;

    public function __construct($apiClassName, $apiMethodName, $apiMethodParams, $cookie=false){
        if($cookie['token']==__API_TOKEN__){
            $this->apiClassName = $apiClassName;
            $this->apiMethodName = $apiMethodName;
            $this->apiMethodParams = $apiMethodParams;
        }
    }

    private function getAPIInstanceByName($apiClassName){
        require_once $apiClassName . '.php';
        return new $apiClassName();
    }

    function callApiFunction() {
        $apiName = strtolower($this->apiClassName);
        if (file_exists($apiName . '.php')) {
            $apiClass = $this->getAPIInstanceByName($apiName);
            try {
                $methodName = $this->apiMethodName;
                $jsonParams = json_decode($this->apiMethodParams);
                if ($jsonParams) {
                    if (!isset($jsonParams->responseBinary)){
                        $this->resultFunctionCall->result = $apiClass->$methodName($jsonParams);
                        $this->resultFunctionCall->statusCode = STATUS_NO_ERROR;
                    }
                    else
                    {
                        $this->resultFunctionCall->result = false;
                        $this->resultFunctionCall->statusCode = STATUS_ERROR_PARAM;
                        $this->resultFunctionCall->error = 'В параметры метода нельзя передать бинарный файл';
                    }
                }
                else
                {
                    $this->resultFunctionCall->result = false;
                    $this->resultFunctionCall->statusCode = STATUS_ERROR_PARAM;
                    $this->resultFunctionCall->error = 'Не удалось обработать параметры метода';
                }
            } catch (Exception $ex) {
                $this->resultFunctionCall->result = false;
                $this->resultFunctionCall->statusCode = STATUS_ERROR_PARAM;
                $this->resultFunctionCall->error = $ex->getMessage();
            }
        }
        else {
            $this->resultFunctionCall->result = false;
            $this->resultFunctionCall->statusCode = STATUS_ERROR_METHOD;
            $this->resultFunctionCall->error = 'Указанный метод API не найден, проверьте документацию';
        }
    }

}