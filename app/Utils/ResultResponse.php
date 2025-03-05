<?php

namespace App\Utils;

class ResultResponse
{
    const SUCCESS_CODE = 200;
    const CREATED_CODE = 201;
    const ERROR_CODE = 400;
    const UNAUTHORIZED_CODE = 401;
    const NOT_FOUND_CODE = 404;

    const SUCCESS_NAME = 'OK';
    const CREATED_NAME = 'Created';
    const ERROR_NAME = 'Bad Request';
    const UNAUTHORIZED_NAME = 'Unauthorized';
    const NOT_FOUND_NAME = 'Not Found';

    public $statusCode;
    public $statusName;
    public $errorMessage;
    public $result;

    function __construct(){
        $this->statusCode = self::ERROR_CODE;
        $this->statusName = self::ERROR_NAME;
        $this->errorMessage = '';
        $this->result = '';
    }

    public function getStatusCode(){
        return $this->statusCode;
    }

    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
    }

    public function getStatusName(){
        return $this->statusName;
    }

    public function setStatusName($statusName){
        $this->statusName = $statusName;
    }

    public function getErrorMessage(){
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage){
        $this->errorMessage = $errorMessage;
    }

    public function getResult(){
        return $this->result;
    }

    public function setResult($result){
        $this->result = $result;
    }
}