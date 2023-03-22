<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterController extends Controller
{
    public function index(Request $request, Response $respone)
    {
        return $this->container->get('view')
            ->render($respone, 'register.twig');
    }
}