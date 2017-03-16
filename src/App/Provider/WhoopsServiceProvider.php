<?php

declare(strict_types=1);

namespace App\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['whoops.error_page_handler'] = function () {
            if (PHP_SAPI === 'cli') {
                return new PlainTextHandler();
            } else {
                return new PrettyPageHandler();
            }
        };

        $app['whoops.silex_info_handler'] = $app->protect(function () use ($app) {
            try {
                /** @var RequestStack $request */
                $request = $app['request_stack']->getCurrentRequest();
            } catch (\Throwable $e) {
                return;
            }

            /** @var Handler $errorPageHandler */
            $errorPageHandler = $app["whoops.error_page_handler"];

            if ($errorPageHandler instanceof PrettyPageHandler) {
                /** @var PrettyPageHandler $errorPageHandler */

                $errorPageHandler->addDataTable('Silex Application', array(
                    'Version' => $app::VERSION,
                    'Charset' => $app['charset'],
                    'Route Class' => $app['route_class'],
                    'Dispatcher Class' => get_class($app['dispatcher']),
                    'Application Class' => get_class($app)
                ));

                // Request info:
                if ($request) {
                    $errorPageHandler->addDataTable(
                        'Silex Application (Request)',
                        [
                            'URI' => $request->getUri(),
                            'Request URI' => $request->getRequestUri(),
                            'Path Info' => $request->getPathInfo(),
                            'Query String' => $request->getQueryString() ?: '<none>',
                            'HTTP Method' => $request->getMethod(),
                            'Script Name' => $request->getScriptName(),
                            'Base Path' => $request->getBasePath(),
                            'Base URL' => $request->getBaseUrl(),
                            'Scheme' => $request->getScheme(),
                            'Port' => $request->getPort(),
                            'Host' => $request->getHost()
                        ]
                    );
                }
            }
        });

        $app['whoops'] = function () use ($app) {
            $run = new Run();
            $run->allowQuit(false);
            $run->pushHandler($app['whoops.error_page_handler']);
            $run->pushHandler($app['whoops.silex_info_handler']);
            return $run;
        };

        $app->error(function ($e) use ($app) {
            $method = Run::EXCEPTION_HANDLER;

            ob_start();
            $app['whoops']->$method($e);
            $response = ob_get_clean();
            $code = $e instanceof HttpException ? $e->getStatusCode() : 500;

            return new Response($response, $code);
        });

        $app['whoops']->register();
    }
}
