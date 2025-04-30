<?php
class Route
{

    protected string $regex;

    protected array $parameters;

    public function __construct(public readonly string $uri, public readonly Closure|array |string $action)
    {
        $replace = str_replace("/", "\/", $this->uri);
        $this->regex = preg_replace("/\{([a-zA-Z_]+)\}/", "([a-zA-Z0-9_\\.=-]+)", $replace);
        preg_match_all("/\{([a-zA-Z_]+)\}/", $this->uri, $parameters);
        $this->parameters = $parameters[1];
    }


    public function matches(string $path): bool
    {
        return preg_match("/^$this->regex$/i", $path);
    }

    public function hasParameters(): bool
    {
        return count($this->parameters) > 0;
    }

    public function parseParameters(string $path): array
    {
        preg_match("/^$this->regex$/", $path, $arguments);
        $arguments = array_slice($arguments, 1);
        foreach ($arguments as $key => $value) {
            if (is_numeric($arguments[$key])) {
                $arguments[$key] = is_int($arguments[$key]) ? (int) $value : (float) $value;
            }
        }
        return array_combine($this->parameters, $arguments);
    }
}