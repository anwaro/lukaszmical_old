<?php

namespace vendor\base;

use vendor\Lii;

class Bootstrap
{
    /**
     * Starts the Bootstrap
     *
     */
    public function init()
    {
        list($controller, $action, $param) = $this->parseUrl();

        $errorControllerName = $this->controllerName('error');
        $errorActionName = $this->actionName('index');

        $controllerName = $this->controllerName($controller);
        $actionName = $this->actionName($action);

        $validRoute = $this->checkRoute($controllerName, $actionName);

        /** @var Controller $controllerObject */
        $controllerObject = $validRoute
            ? $this->loadController($controllerName)
            : $this->loadController($errorControllerName);
        $actionName = $validRoute ? $actionName : $errorActionName;

        $controllerObject->before($actionName);
        $render = $this->call($controllerObject, $actionName, $param);
        $controllerObject->after($actionName);


        return $render;
    }

    /**
     * @return array
     */
    private function parseUrl()
    {
        $path = Lii::$app->url->getPathArray();

        return [
            isset($path[0]) ? $path[0] : 'index',
            isset($path[1]) ? $path[1] : 'index',
            count($path) > 2 ? array_slice($path, 2) : []
        ];
    }

    /**
     * @param $controllerObject
     * @param $actionName
     * @param $param
     * @return array
     */
    private function call($controllerObject, $actionName, $param)
    {
        return call_user_func_array([$controllerObject, $actionName], $param);
    }

    /**
     * Load an existing controller if there IS a GET parameter passed
     * @param $controllerName
     * @return false|Controller
     */
    private function loadController($controllerName)
    {
        if (class_exists($controllerName)) {
            return new $controllerName;
        }

        return false;
    }

    /**
     * @param $controllerName
     * @param $actionName
     * @return bool|mixed
     */
    private function checkRoute($controllerName, $actionName)
    {
        $controllerModel = $this->loadController($controllerName);
        return $controllerModel && method_exists($controllerModel, $actionName);
    }

    /**
     * @param $action
     * @return string
     */
    private function actionName($action)
    {
        $part = explode("-", $action);
        array_walk($part, function (&$value) {
            $value = ucfirst($value);
        });

        return "action" . implode($part);
    }

    /**
     * @param string $string
     * @return string
     */
    private function controllerName($string)
    {
        return 'controllers\\' . ucfirst($string) . 'Controller';
    }
}