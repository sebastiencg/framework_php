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


    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     * @return void
     */
    public function  errorHandler($severity, $message, $file, $line)
    {
        $this->error = [$severity, $message, $file, $line];

        $date = new \DateTime();
        $newDate = date_format($date, "Y/m/d H:i:s");
        $error = "ERROR" . "\n" . $newDate . "\n" . $file . "\n" . "line : " . $line . "\n" . $message . "\n" . "\n";

        $currentContent = file_get_contents("../logs/dev/dev.log");

        $newContent = $error . $currentContent;

        file_put_contents("../logs/dev/dev.log", $newContent);


        $this->renderDebugger("error", $this->error);
    }

    /**
     * @param \Throwable $exception
     * @return void
     */
    public function exceptionHandler(\Throwable $exception)
    {
        $this->exception = $exception;


        // write dev.log
        $date = new \DateTime();
        $newDate = date_format($date, "Y/m/d H:i:s");
        $error = "EXCEPTION" . "\n" . $newDate . "\n" . $this->exception->getFile() . "\n" . "line : " . $this->exception->getLine() . "\n" . $this->exception->getMessage() . $this->exception->getCode() . "\n" . "\n";

        $currentContent = file_get_contents("../logs/dev/dev.log");

        $newContent = $error . $currentContent;

        file_put_contents("../logs/dev/dev.log", $newContent);


        $this->renderDebugger("exception", $this->exception);
    }

    /**
     * @param $template
     * @param $data
     * @return void
     */
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

    /**
     * @return void
     */
    public function getProfilerBar(){
        ob_start();
        require_once "templates/profilerbar.html.php";
        echo ob_get_clean();
    }

    // Error 500 mode prod -> templates/error/500.html.php //
    // ################################################### //


    /**
     * @param $c
     * @param $m
     * @param $f
     * @param $l
     * @return void
     */
    public function prodErrorHandler($c,$m,$f,$l)
    {
        $this->error = [$c,$m,$f,$l];

        $date = new \DateTime();
        $newDate= date_format($date,"Y/m/d H:i:s");
        $error="ERROR"."\n".$newDate."\n".$f."\n"."line : ".$l."\n".$m."\n"."\n";

        $currentContent = file_get_contents("../logs/prod/prod.log");

        $newContent = $error . $currentContent;
        file_put_contents("../logs/prod/prod.log", $newContent);
        $resp = new Response();
        $resp->renderError("500", []);
    }

    /**
     * @param \Throwable $e
     * @return void
     */
    public function prodExceptionHandler(\Throwable $e)
    {
        $this->exception = $e;

        $date = new \DateTime();
        $newDate = date_format($date, "Y/m/d H:i:s");
        $error = "EXCEPTION" . "\n" . $newDate . "\n" . $this->exception->getFile() . "\n" . "line : " . $this->exception->getLine() . "\n" . $this->exception->getMessage() . $this->exception->getCode() . "\n" . "\n";

        $currentContent = file_get_contents("../logs/prod/prod.log");

        $newContent = $error . $currentContent;

        file_put_contents("../logs/prod/prod.log", $newContent);

        $resp = new Response();
        $resp->renderError("500", []);
    }




    public function writeError($template)
    {
        // write Error
        $date = new \DateTime();
        $newDate= date_format($date,"Y/m/d H:i:s");
        $error="ERROR"."\n".$newDate."\n".$this->exception->getFile()."\n"."line : ".$this->exception->getLine()."\n".$this->exception->getMessage().$this->exception->getCode()."\n"."\n";
        error_log($error, 3, "../logs/$template.log");
    }
    public function writeException($template)
    {
        // write Exception
        $date = new \DateTime();
        $newDate= date_format($date,"Y/m/d H:i:s");
        $error="EXCEPTION"."\n".$newDate."\n".$this->exception->getFile()."\n"."line : ".$this->exception->getLine()."\n".$this->exception->getMessage().$this->exception->getCode()."\n"."\n";
        error_log($error, 3, "../logs/$template.log");
    }
}