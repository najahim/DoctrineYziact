<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    /**
     * @Route("/cgu", name="cgu")
     */
    public function index()
    {
        return $this->render('cgu/index.html.twig', [
            'controller_name' => 'CguController',
        ]);
    }
}
