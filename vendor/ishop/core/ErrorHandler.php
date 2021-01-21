<?php


    namespace ishop;


    class ErrorHandler
    {

        public function __construct()
        {
            DEBUG ? error_reporting(-1) : error_reporting(0);
            set_exception_handler([$this, "exceptionHandler"]);
        }

        // my error handler method
        public function exceptionHandler($e){
            $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
            $this->displayError("Исключение", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode());
        }

        // write errors to file
        protected function logErrors($message = '', $file = '', $line = ''){

            error_log("[". date("d.m.Y H:i:s") . "]
                                Текст ошибки: {$message} | 
                                Файл: {$file} | 
                                Строка: {$line} \n ___________________________________ \n",
                                3, ROOT.'/tmp/errors.log');
        }

        // display errors on site
        protected function displayError($errno, $errstr, $errfile, $errline, $responce = 404){

            http_response_code($responce);

            if(DEBUG){
                $file = "dev.php";
            }
            else{
               $file = ($responce == 404) ? "404.php" : "prod.php";
            }

            ob_start();
            require WWW."/errors/".$file;
            $content = ob_get_clean();

            require APP . "/views/layouts/clothes.php";


        }
    }