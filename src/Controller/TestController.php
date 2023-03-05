<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request): Response
    {
        $greet = '';
        if ($name = $request->query->get('hello')) {
            $greet = '<h1>Hello '. htmlspecialchars($name).' !</h1>';
        }
        dd($request);
        $page='<!DOCTYPE html>
        <html>
        <head>
        <meta charset="UTF-8" />
        <title>Site en construction</title>
        </head> 
        <body>'.$greet.'
        <img src="/images/under-construction.gif" />
        </body>
        </html>';
        return new Response($page,RESPONSE::HTTP_OK,array('content-type'=>'text-html'));
    }
}


