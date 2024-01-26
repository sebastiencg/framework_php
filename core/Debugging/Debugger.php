<?php

namespace Core\Debugging;

use Core\Environment\DotEnv;
use Core\Http\Response;

class Debugger
{

    private $error;
    private $exception;


    public function run()
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        if($environment === "dev"){
            $this->runDev();
        }elseif ($environment === "prod"){
            $this->runProd();
        }
    }

    public function runDev()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        set_error_handler([$this, "errorHandler"]);
        set_exception_handler([$this, "exceptionHandler"]);

        $this->getProfilerBar();
    }
    private function runProd()
    {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        set_error_handler([$this, "prodErrorHandler"]);
        set_exception_handler([$this, "prodExceptionHandler"]);
    }



    ////////////////////////////////////////////////////////////////
    // ########################################################## //




    public function  errorHandler($severity, $message, $file, $line)
    {
        $this->error = [$severity, $message, $file, $line];

        $this->renderDebugger("error", $this->error);

    }

    public function exceptionHandler(\Throwable $exception)
    {
        $this->exception = $exception;

        $this->renderDebugger("exception", $this->exception)
        ;
    }

    public function renderDebugger($template, $data)
    {
        switch($template):
            case "error": $error = $data;
                break;
            case "exception": $exception = $data;
                break;
        endswitch;

        ob_start();

        require_once "templates/$template.html.php";

        $content  =ob_get_clean();

        ob_start();

        require_once "templates/debugger.html.php";

        echo ob_get_clean();
        exit();
    }

    public function getProfilerBar(){
        ob_start();
        require_once "templates/profilerbar.html.php";
        echo ob_get_clean();
    }



    // Error 500 mode prod -> templates/error/500.html.php //
    // ################################################### //

    public function prodErrorHandler($c,$m,$f,$l)
    {

        $this->error = [$c,$m,$f,$l];

        //ajouter au log prod
        error_log($m, 3, "../logs/prod/prod.log");

        $resp = new Response();
        $resp->renderError("500", []);
    }
    public function prodExceptionHandler(\Throwable $e)
    {
        $this->exception =$e;

        //ajouter au log prod
        error_log($e, 3, "../logs/prod/prod.log");

        $resp = new Response();
        $resp->renderError("500", []);
    }
}