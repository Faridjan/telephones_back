<?php

declare(strict_types=1);

use App\Http\Action\HomeAction;
use App\Http\Action\V1\Content\ContentAction;
use App\Http\Action\V1\Mark\MarkAction;
use App\Http\Action\V1\Mark\MarkAddAction;
use App\Http\Action\V1\Mark\MarkAllAction;
use App\Http\Action\V1\Mark\MarkFindAction;
use App\Http\Action\V1\Mark\MarkRemoveAction;
use App\Http\Action\V1\Mark\MarkUpdateAction;
use App\Http\Action\V1\Proxy\CheckAction;
use App\Http\Action\V1\Proxy\LoginAction;
use App\Http\Action\V1\Proxy\LogoutAction;
use App\Http\Action\V1\Proxy\RefreshAction;
use App\Http\Middleware\LocalStorage\LocalStorageResponseMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {
    $app->group(
        '/v1',
        function (RouteCollectorProxy $group) {
            $group->get('', HomeAction::class);

            $group->group(
                '/marks',
                function (RouteCollectorProxy $group) {
                    $group->get('', MarkAction::class);
                    $group->post('/add', MarkAddAction::class);
                    $group->get('/all', MarkAllAction::class);
                    $group->get('/find', MarkFindAction::class);
                    $group->put('/update', MarkUpdateAction::class);
                    $group->delete('/remove', MarkRemoveAction::class);
                }
            );

            $group->group(
                '/contents',
                function (RouteCollectorProxy $group) {
                    $group->get('', ContentAction::class);
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
