<?php

class TemplateEngine
{
    public $parameters = [];
    private $content;

    public function setParameters(array $parameters): void
    {
        foreach ($parameters as $key => $val) {
            if (!is_array($val)) {
                $this->parameters[$key] = $val;
            } else {
                $this->setParameters($val);
            }
        }
    }

    public function showContent(string $tpl): void
    {
        $tempContent = file_get_contents($tpl);

        foreach ($this->parameters as $key => $val) {
            $tempContent = str_replace("{" . $key . "}", $val, $tempContent);
        }
        $this->content = $tempContent;

        echo $this->content;
    }
}
