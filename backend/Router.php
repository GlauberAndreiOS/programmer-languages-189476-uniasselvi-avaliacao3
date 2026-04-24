<?php

class Router {
    private $routes = [];
    private $resources = [];

    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    public function put($uri, $action) {
        $this->addRoute('PUT', $uri, $action);
    }

    public function delete($uri, $action) {
        $this->addRoute('DELETE', $uri, $action);
    }

    public function resource($uri, $controller) {
        $this->resources[$uri] = $controller;
    }

    private function addRoute($method, $uri, $action) {
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch($method, $uri) {
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }

        if (isset($this->routes[$method][$uri])) {
            $this->executeRoute($this->routes[$method][$uri]);
            return;
        }

        $uriParts = explode('/', ltrim($uri, '/'));
        $resourceBase = '/' . ($uriParts[0] ?? '');
        $id = $uriParts[1] ?? null;

        if (isset($this->resources[$resourceBase])) {
            $this->executeResource($this->resources[$resourceBase], $method, $id);
            return;
        }

        $this->sendResponse(["error" => "Route not found"], 404);
    }

    private function executeRoute($action) {
        list($controllerName, $methodName) = $action;
        $controller = new $controllerName();

        try {
            $data = $this->getRequestData();
            $response = !empty($data) ? $controller->$methodName($data) : $controller->$methodName();
            $this->sendResponse($response, 200);
        } catch (Exception $e) {
            $this->sendResponse(["error" => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    private function executeResource($controllerName, $method, $id) {
        $controller = new $controllerName();
        $response = null;

        try {
            switch ($method) {
                case 'GET':
                    $response = $id ? $controller->show($id) : $controller->index();
                    $this->sendResponse($response, 200);
                    break;
                case 'POST':
                    if ($id) throw new Exception("POST cannot have ID", 400);
                    $response = $controller->store($this->getRequestData());
                    $this->sendResponse($response, 201);
                    break;
                case 'PUT':
                    if (!$id) throw new Exception("ID required for PUT", 400);
                    if (!method_exists($controller, 'update')) throw new Exception("Not implemented", 501);
                    $response = $controller->update($id, $this->getRequestData());
                    $this->sendResponse($response, 200);
                    break;
                case 'DELETE':
                    if (!$id) throw new Exception("ID required for DELETE", 400);
                    if (!method_exists($controller, 'destroy')) throw new Exception("Not implemented", 501);
                    $response = $controller->destroy($id);
                    $this->sendResponse($response, 204);
                    break;
                default:
                    throw new Exception("Method not allowed", 405);
            }
        } catch (Exception $e) {
            $this->sendResponse(["error" => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    private function getRequestData() {
        return json_decode(file_get_contents('php://input'), true) ?: $_POST;
    }

    private function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        if ($data !== null) {
            echo json_encode($data);
        }
        exit;
    }
}