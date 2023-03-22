<?php

namespace App\Controllers;

use App\Models\Payment;
use Stripe\Exception\CardException;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PaymentController extends Controller
{
    public function index(Request $request, Response $respone)
    {
        // if (!$token = $request->getQueryParams()['token'] ?? false) {
        //     throw new HttpNotFoundException($request);
        // }

        // if (!Payment::whereToken($token)->first()) {
        //     throw new HttpNotFoundException($request);
        // }

        $payments = Payment::orderBy('id', 'desc')->limit(5)->get();

        return $this->container->get('view')
            ->render($respone, 'payment.twig', [
                'payments' => $payments,
                'messages' => $this->container->get('flash')->getMessages()
            ]);
    }

    public function store(Request $request, Response $respone)
    {
        [
            'name' => $name,
            'email' => $email,
            'payment_method' => $paymentMethod
        ] = $request->getParsedBody();

        try {
            $charge = $this->container->get('stripe')->paymentIntents->create([
                'amount' => 99,
                'currency' => 'usd',
                'payment_method' => $paymentMethod,
                'description' => 'Who paid 99¢ payment',
                'confirm' => true,
                'receipt_email' => $email
            ]);

            Payment::create([
                'name'  => $name,
                'email' => $email,
                'token' => $token = bin2hex(random_bytes(32)),
                'stripe_id' => 'abc'
            ]);

            $this->container->get('flash')
                ->addMessage('status', 'Payment successful.');

            return $respone->withStatus(303)
                ->withHeader('Location', '/payment?token=' . $token);
        } catch (CardException $e) {
            $this->container->get('flash')
                ->addMessage('status', 'There was a problem processing your payment.');

            return $respone->withStatus(302)->withHeader('Location', '/');
        }
    }
}