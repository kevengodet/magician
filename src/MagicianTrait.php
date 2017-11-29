<?php

namespace Keven\Magician;

trait MagicianTrait
{
    public function __get($name)
    {
        foreach ((new \ReflectionObject($this))->getMethods() as $method) {
            /* @var $method \ReflectionMethod */
            if (strpos($method->getName(), '__magicGet') === 0) {
                $v = $method->invoke($this, $name);
                if (!is_null($v)) {
                    return $v;
                }
            }
        }
    }

    public function __set($name, $value)
    {
        foreach ((new \ReflectionObject($this))->getMethods() as $method) {
            /* @var $method \ReflectionMethod */
            if (strpos($method->getName(), '__magicSet') === 0) {
                $v = $method->invoke($this, $name, $value);
            }
        }
    }

    public function __call($methodName, $arguments)
    {
        $return = null;

        foreach ((new \ReflectionObject($this))->getMethods() as $method) {
            /* @var $method \ReflectionMethod */
            if (strpos($method->getName(), '__magicCall') === 0) {
                $v = $method->invoke($this, $methodName, $arguments);
                if (!is_null($v)) {
                    $return = $v;
                }
            }
        }

        return $return;
    }
}
