<?php
    # Directorio Proyecto
    define('DIRSTORAGE', __DIR__);
    require DIRSTORAGE . '/config/autoload.php';
    require DIRSTORAGE . '/vendor/autoload.php';
    # Implementar Variables de Entorno
    define('ENVS', DIRSTORAGE . '/envs');
    $dotenv = Dotenv\Dotenv::createImmutable(ENVS);
    $dotenv->load();
    # Implementar JWT
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    # Implementar Psr
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface;
    # Implementar Slim
    use Slim\Exception\HttpInternalServerErrorException;
    use Slim\Factory\AppFactory;
    use Slim\Factory\ServerRequestCreatorFactory;
    use Slim\Routing\RouteCollectorProxy;
    use Slim\Routing\RouteContext;
    use Slim\Views\Twig;
    use Slim\Views\TwigMiddleware;
    # Implementar Tuupola
    use Tuupola\Middleware\CorsMiddleware;
    # Implementar Controlladores
    use MyApp\Controllers\RootController as controllerRoot;
    use MyApp\Controllers\ApiController as controllerApi;
    use MyApp\Controllers\LogController as controllerLog;
    # Implementar Handlers
    use MyApp\Handlers\HttpErrorHandler;
    use MyApp\Handlers\ShutdownHandler;
    # Implementar Rutas
    use MyApp\Routes\AnyRoute as routeAny;
    use MyApp\Routes\DeleteRoute as routeDelete;
    use MyApp\Routes\GetRoute as routeGet;
    use MyApp\Routes\MySqlRoute as routeMySql;
    use MyApp\Routes\OptionsRoute as routeOptions;
    use MyApp\Routes\PatchRoute as routePatch;
    use MyApp\Routes\PostRoute as routePost;
    use MyApp\Routes\PutRoute as routePut;
    # Obtener la ruta completa del archivo actual
    $fileRoute = __FILE__;
    # Obtener solo el nombre del archivo sin la ruta
    $fileIndex = basename($fileRoute);
    # Obtener index.php y reemplazarlo
    $folderRoot = str_replace('/' . $fileIndex, '', SERVER_SCRIPT_NAME);
    define('SERVER_FOLDER_ROOT', $folderRoot);
    //------------------------------------------------------------------------
    // Set that to your needs
    $displayErrorDetails = true;
    # Instantiate App
    $app = AppFactory::create();
    # Configurar la base URL
    $app->setBasePath(SERVER_FOLDER_ROOT);
    //------------------------------------------------------------------------
    $origin = '*';
    $allowedMethods = [
        'ANY',
        'DELETE',
        'GET',
        'OPTIONS',
        'PATCH',
        'POST',
        'PUT',
    ];
    $allowedHeaders = [
        'Content-Type',
        'Authorization',
        'Accept',
        'X-Requested-With',
        'Cache-Control',
        'Origin',
        'If-Modified-Since',
        'If-None-Match',
        'Content-Encoding',
        'Accept-Encoding',
        'Content-Disposition',
        'ETag',
    ];
    # Aquí es donde debes agregar la configuración del middleware de CORS
    $app->add(new CorsMiddleware([
        'origin' => [$origin],
        'methods' => $allowedMethods,
        'headers.allow' => $allowedHeaders,
        'headers.expose' => [],
        'credentials' => true,
        'cache' => 0,
    ]));
    # Ruta genérica para manejar las solicitudes OPTIONS en todas las rutas
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    //------------------------------------------------------------------------
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    $request = $serverRequestCreator->createServerRequestFromGlobals();
    $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
    $shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);
    // Add Routing Middleware
    $app->addRoutingMiddleware();
    // Add Error Handling Middleware
    $errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
    //------------------------------------------------------------------------
    $app->addBodyParsingMiddleware();
    // This middleware will append the response header Access-Control-Allow-Methods with all allowed methods
    $app->add(function (Request $request, RequestHandlerInterface $handler): Response {
        $routeContext = RouteContext::fromRequest($request);
        $routingResults = $routeContext->getRoutingResults();
        $methods = $routingResults->getAllowedMethods();
        $requestHeaders = $request->getHeaderLine('Access-Control-Request-Headers');
        $response = $handler->handle($request);
        $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        $response = $response->withHeader('Access-Control-Allow-Methods', implode(',', $methods));
        $response = $response->withHeader('Access-Control-Allow-Headers', $requestHeaders);
        // Optional: Allow Ajax CORS requests with Authorization header
        $response = $response->withHeader('Access-Control-Allow-Credentials', 'true');
        return $response;
    });
    // The RoutingMiddleware should be added after our CORS middleware so routing is performed first
    $app->addRoutingMiddleware();
    //------------------------------------------------------------------------
    # Routing Middleware
    //$app->addRoutingMiddleware();
    # Configuración de la depuración: habilitar mensajes de error detallados
    //$errorMiddleware = $app->addErrorMiddleware(true, true, true);
    //------------------------------------------------------------------------
    $twig = Twig::create('src/templates', ['cache' => false,]);
    $app->add(TwigMiddleware::create($app, $twig));
    //------------------------------------------------------------------------
    # Define app routes
    $routesGet = new routeGet();
    $routesGet($app);
    # Define app routes
    $routesMysql = new routeMySql();
    $routesMysql($app);
    //------------------------------------------------------------------------
    # Run app
    $app->run();
