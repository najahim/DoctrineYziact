<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Erreur404Controller extends AbstractController
{
    /**
     * @Route("/erreur404", name="erreur404")
     */
    public function index()
    {
        return $this->render('erreur404/index.html.twig', [
            'controller_name' => 'Erreur404Controller',
        ]);
    }
}
