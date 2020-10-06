<?php


namespace Suraj\Test\Example;


class Dependency
{
    /**
     * @var String
     */
    private $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
