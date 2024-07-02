<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use App\Exception\SessionException;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) //return the current session status like session is start or not
        {
            throw new SessionException("Session Already Active");
        }
        // ob_end_clean();//if output buffering is clean then show the header sent sesssion error
        // echo "Hello"; //this message is print always because output buffering is on 
        if (headers_sent($filename, $line)) {
            throw new SessionException("Header Already Sent. Consider enabling ouput buffering. Data outputted from {$filename} - Line : {$line}");
        }
        session_start();
        $next();
        // dd($_SESSION['oldFormData']);
        session_write_close(); //it Write session data and end session
    }
}
