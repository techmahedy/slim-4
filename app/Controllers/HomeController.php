<?php

namespace App\Controllers;

use App\Models\Payment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController extends Controller
{
    public function __invoke(Request $request, Response $respone)
    {
        return $this->container->get('view')->render($respone, 'home.twig', [
            'messages' => $this->container->get('flash')->getMessages()
        ]);
    }
}