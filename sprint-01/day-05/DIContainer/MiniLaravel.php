<?php

interface IContainer {
    public function make(string $interface);
    public function bind(string $interface, string $concrete);
}
interface IMiddleware {
    public function handle($request, Closure $next);
}

class Container implements IContainer {
    protected array $container = [];

    public function bind(string $interface, string $concrete){
        if (isset($this->container[$interface])) return;
        $this->container[$interface] = $concrete;
    }

    public function make(string $interface) {
        if (!isset($this->container[$interface])) {
            // If not bound, use the class itself (auto-resolve)
            $concrete = $interface;
        } else {
            $concrete = $this->container[$interface];
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->getConstructor()) {
            return new $concrete;
        }

        $params = $reflector->getConstructor()->getParameters();
        $dependencies = [];

        foreach ($params as $param) {
            $dependency = $param->getType() && !$param->getType()->isBuiltin()
                ? $this->make($param->getType()->getName())
                : null;
            $dependencies[] = $dependency;
        }

        return $reflector->newInstanceArgs($dependencies);
    }
}

interface PaymentGeteway {
    public function pay(float $amount);
}

class Paypal implements PaymentGeteway {
    public function pay(float $amount) {
        echo "Processed payment of $amount via Paypal \n";
    }
}

class PaymentController {
    public function __construct(protected PaymentGeteway $paypal) {}
    public function PaymentProcess() {
        $this->paypal->pay(33.4);
    }
}

class Middleware implements IMiddleware{
    public function handle($request, Closure $next){
        echo "logger\n";
        return $next($request);
    }
}
$routes = [
    "/pay" => [
        "action" => [PaymentController::class, "PaymentProcess"],
        "middlewares" => [Middleware::class]
    ]
];

$c = new Container();

$uri = '/pay';
$request = ['uri' => $uri];

if (isset($routes[$uri])) {
    $route = $routes[$uri];
    $middlewares = $route['middlewares'] ?? [];
    [$controllerClass, $method] = $route["action"];
    $c->bind(PaymentGeteway::class, Paypal::class);

    $controllerCallable = function($request) use($c,$controllerClass,$method){
        $controller = $c->make($controllerClass);
         return $controller->$method();
    };

    $pipeline = array_reverse($middlewares);
    $handler = $controllerCallable;

    foreach ($pipeline as $middlewareClass) {
        $middlewareInstance = $c->make($middlewareClass);
        $next = $handler;
        $handler = function($request) use ($middlewareInstance, $next) {
            return $middlewareInstance->handle($request, $next);
        };
    }
    $response = $handler($request);
    return $response;
} else {
    http_response_code(404);
    echo '404 Not Found';
}
