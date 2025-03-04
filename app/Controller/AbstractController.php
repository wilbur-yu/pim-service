<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;


    public function apiReturn($codeData = [])
    {
        if (is_array($codeData) && array_key_exists('code', $codeData)) {
            return $this->response->json($codeData)->withHeader('Content-Type','application/json');
        } else {
            $data['code'] = 200;
            $data['data'] = $codeData;
        }
        return $this->response->json($data)->withHeader('Content-Type','application/json');
    }
}
