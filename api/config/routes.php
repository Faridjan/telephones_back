<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\V1\Mark\MarkAction;
use App\Http\Action\V1\Mark\MarkAddAction;
use App\Http\Action\V1\Proxy\CheckAction;
use App\Http\Action\V1\Proxy\LoginAction;
use App\Http\Action\V1\Proxy\LogoutAction;
use App\Http\Action\V1\Proxy\RefreshAction;
use App\Http\Middleware\LocalStorage\LocalStorageRequestMiddleware;
use App\Http\Middleware\LocalStorage\LocalStorageResponseMiddleware;
use App\Http\Middleware\Oauth\JwtAccessMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {
    $app->group(
        '/v1',
        function (RouteCollectorProxy $group) {
            $group->get('/', HomeAction::class);

            $group->group(
                '/marks',
                function (RouteCollectorProxy $group) {
                    $group->get('', MarkAction::class);
                    $group->post('/add', MarkAddAction::class);
//                    $group->get('/all', MarkAllAction::class);
//                    $group->get('/find', MarkFindAction::class);
//                    $group->get('/update', MarkUpdateAction::class);
                }
            );

            $group->group(
                '/content',
                function (RouteCollectorProxy $group) {
//                    $group->get('', ContentAction::class);
//                    $group->get('/add', ContentAddAction::class);
//                    $group->get('/update', ContentUpdateAction::class);
                }
            );
        }
    );
//        ->add(JwtAccessMiddleware::class)
//        ->add(LocalStorageRequestMiddleware::class);

    $app->group(
        '/v1/users',
        function (RouteCollectorProxy $group) {
            $group->post('/login', LoginAction::class);
            $group->post('/logout', LogoutAction::class);
            $group->get('/check', CheckAction::class);
            $group->get('/refresh', RefreshAction::class);
        }
    )
        ->add(LocalStorageResponseMiddleware::class);
};
