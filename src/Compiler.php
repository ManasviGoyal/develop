<?php

namespace Hyde\RealtimeCompiler;

class Compiler
{
    public string $path;
    public string $output;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->output = $this->compile();
    }

    private function compile(): string
    {
        // TODO: Implement compile() method which boots Hyde and compiles the page
        return file_get_contents($this->path);
    }

    public function getOutput(): string
    {
        return $this->output;
    }
}