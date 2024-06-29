<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AboutController
{
    //private TemplateEngine $view;
    public function __construct(private TemplateEngine $view/* instantiating class with dependency*/)
    {
        // $this->view = new TemplateEngine(Paths::VIEW); //instance of template engine
    }
    public function about()
    {
        echo $this->view->render("about.php", [
            'title' => 'about pagee',
            'dangerousData' => '<script>alert(123)</script>'
        ]);
    }
}
