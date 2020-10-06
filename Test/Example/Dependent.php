<?php
namespace Suraj\Test\Example;
use Suraj\Test\Example\Dependency;

class Dependent
{
    /**
     * @var Dependency
     */
private $dependency;
public function __construct(Dependency $dependency)
{
    $this->dependency = $dependency;
}

public function getDependency(): Dependency
{
return $this->dependency;
}
}
