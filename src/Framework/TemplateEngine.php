<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine //create template engine
{
    private array $globalTemplateData = [];
    public function __construct(private string $basePath/*setting a base path*/)
    {
    }
    public function render(string $template, array $data = []) //render a template
    {
        extract($data, EXTR_SKIP); //extract the individual value
        extract($this->globalTemplateData, EXTR_SKIP); //extract globaltemplatedata variable -> data array variable must always have priority , otherwise controller wont be able to override title 

        ob_start(); //start the output buffering

        // include "{$this->basePath}/{$template}";
        include $this->resolve($template); // use resolve method for reduce redandancy
        $output = ob_get_contents(); // return the content of output buffer
        ob_end_clean(); //clear and stop output buffer , content store in output buffering is lost
        return $output;
    }
    public function resolve(string $path)
    {
        return "{$this->basePath}/{$path}";
    }
    public function addGlobal(string $key, mixed $value) //global template variable
    {
        $this->globalTemplateData[$key] = $value;
    }
}
