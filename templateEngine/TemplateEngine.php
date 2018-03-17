<?php

class TemplateEngine
{
    private $parameters = [];
    private $content;

    public function setParameter($parameters)
    {
        foreach ($parameters as $key => $val) {
            $this->parameters[$key] = $val;
        }
    }

    public  function showContent($tpl)
    {
        $this->content = file_get_contents($tpl);

        foreach ($this->parameters as $key => $val) {
            $this->content = str_replace("{".$key."}", $val, $this->content);
        }

        echo $this->content;
    }
}
