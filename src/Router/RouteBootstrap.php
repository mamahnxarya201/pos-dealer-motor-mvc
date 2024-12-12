<?php

declare(strict_types=1);

namespace Router;

use ReflectionClass;
use Router\Attributes\DELETE;
use Router\Attributes\GET;
use Router\Attributes\NeedAuth;
use Router\Attributes\POST;
use Router\Attributes\Prefix;
use Router\Attributes\PUT;

class RouteBootstrap
{
    private array $routes = [];

    public function __construct(array $controllerclass)
    {
        foreach ($controllerclass as $class) {
            $this->registerController($class);
        }
    }

    public function registerController(string $controllerClass): RouteBootstrap
    {
        $controllerReflection = new ReflectionClass($controllerClass);
        $prefixAttributes = $controllerReflection->getAttributes(Prefix::class);

        $basePath = null;
        if (count($prefixAttributes) > 0) {
            $basePath = $prefixAttributes[0]->newInstance()->path;
        }

        foreach ($controllerReflection->getMethods() as $method) {
            $needAuth = false;
            foreach ($method->getAttributes() as $attribute) {
                $attributeName = $attribute->getName();
                $httpMethod = $this->getHttpMethodFromAttribute($attributeName);
                $attributeInstance = $attribute->newInstance();
                if (!$attributeInstance instanceof NeedAuth) {
                    $path = $basePath . $attributeInstance->path;
                } else {
                    $needAuth = true;
                }

                if ($httpMethod) {
                    $this->routes[$httpMethod][$path] = [$controllerClass, $method->getName(), $needAuth];
                }
            }
        }


        return $this;
    }

    private function getHttpMethodFromAttribute(string $attributeName): ?string
    {
        return match ($attributeName) {
            GET::class => 'GET',
            POST::class => 'POST',
            PUT::class => 'PUT',
            DELETE::class => 'DELETE',
            default => null,
        };
    }

    public function dispatch(string $requestMethod, string $requestUri)
    {
        $path = parse_url($requestUri, PHP_URL_PATH);
        if (isset($this->routes[$requestMethod][$path])) {
            [$controllerClass, $methodName] = $this->routes[$requestMethod][$path];
            if ($this->routes[$requestMethod][$path][2] === true) {
                MiddlewareProcessesor::checkSession();
            }
            (new $controllerClass())->$methodName();
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        }
    }


}