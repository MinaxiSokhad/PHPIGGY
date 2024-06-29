<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class HomeController //create a controller
{
    //private TemplateEngine $view;
    public function __construct(private TemplateEngine $view)
    {
        //var_dump($this->view); // for singleton pattern
        // echo '<br>';
        // $this->view = new TemplateEngine(Paths::VIEW); //instance of template engine

    }
    public function home()
    {
        //dd($this->view); //using sugar function pass the instance of template engine
        // echo "Home page ";
        // $secret = "sdsdagasag";

        // return
        echo $this->view->render("/index.php", [
            // 'title' => 'Home pagee'
        ]);
    }
}
