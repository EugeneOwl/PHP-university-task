<?php

class TemplateEngine
{
    private $parameters = [];
    private $content;

    public function setParameter($parameters)
    {
        foreach ($parameters as $key => $val) {
            if (is_array($val)) {
                $this->parameters[$key] = $this->createListString($val);
            } else {
                $this->parameters[$key] = $val;
            }
        }
    }

    private function createListString($array): string
    {
        $listString = "<ol>";
        foreach ($array as $key => $val) {
            if (is_file($val)) {
                $listString .="<li><img src='" . "sandbox/" . basename($val) . "' alt='(image not found)' width='150' height='150'></li>";
            } else {
                $listString .= "<li>$val</li>";
            }
        }
        $listString .= "</ol>";
        return $listString;
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
