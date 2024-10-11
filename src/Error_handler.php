<?php
//This class is used to handle errors
    class Error_handler {
        public static function handleException(Throwable $exception): void{
            http_response_code(500);
            $error = [
                "message" => $exception->getMessage(),
                "code" => $exception->getCode(),
                "file" => $exception->getFile(),
                "line" => $exception->getLine()
            ];
            echo json_encode($error);
        }
        public static function handleError($errno, $errstr, $errfile, $errline): bool{
           throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            
        }
    }