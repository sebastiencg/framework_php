<?php

namespace Core\Debugging;

use Core\Environment\DotEnv;
use Core\Http\Response;

class Debugger
{

    private $error;
    private $exception;
    public static bool $profileBarStatus = true;

    /**
     * @return void
     */
    public function run()
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        set_error_handler([$this, "ErrorHandler"]);
        set_exception_handler([$this, "ExceptionHandler"]);

        if($environment === "dev"){
            $this->getProfilerBar();
        }
    }

    ////////////////////////////////////////////////////////////////
    // ########################################################## //

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
        if (Debugger::$profileBarStatus) {
            ob_start();
            require_once "templates/profilerbar.html.php";
            echo ob_get_clean();
        }
    }

    ////////////////////////////////////////////////////////////////
    // ########################################################## //

    // Display/Write ERRORS (Dev/Prod)
    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     * @return void
     */
    public function ErrorHandler($severity,$message,$file,$line)
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        $this->error = [$severity,$message,$file,$line];

        $date = new \DateTime();
        $newDate= date_format($date,"Y/m/d H:i:s");
        $error="ERROR"."\n".$newDate."\n".$file."\n"."line : ".$line."\n".$message."\n"."\n";

        if($environment === "dev"){
            $currentContent = file_get_contents("../logs/dev/dev.log");
            $newContent = $error . $currentContent;

            file_put_contents("../logs/dev/dev.log", $newContent);
            $this->renderDebugger("error", $this->error);
        }
        elseif ($environment === "prod") {
            $currentContent = file_get_contents("../logs/prod/prod.log");
            $newContent = $error . $currentContent;

            file_put_contents("../logs/prod/prod.log", $newContent);
            $resp = new Response();
            $resp->renderError("500", []);
        }

    }

    // Display/Write EXCEPTION (Dev/Prod)

    /**
     * @param $exception
     * @return void
     */
    public function ExceptionHandler($exception)
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        $this->exception = $exception;

        $date = new \DateTime();
        $newDate= date_format($date,"Y/m/d H:i:s");
        $error="EXCEPTION"."\n".$newDate."\n".$this->exception->getFile()."\n"."line : ".$this->exception->getLine()."\n".$this->exception->getMessage().$this->exception->getCode()."\n"."\n";




        if($environment === "dev"){
            $currentContent = file_get_contents("../logs/dev/dev.log");
            $newContent = $error . $currentContent;
            file_put_contents("../logs/dev/dev.log", $newContent);

            $this->renderDebugger("exception", $this->exception);
        }
        elseif ($environment === "prod") {
            $currentContent = file_get_contents("../logs/prod/prod.log");
            $newContent = $error . $currentContent;
            file_put_contents("../logs/prod/prod.log", $newContent);

            $resp = new Response();
            $resp->renderError("500", []);
        }
    }
}