<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/acceuil", name="default")
     */
    public function index()
    {
        $data=$this->getDoctrine()->getRepository('App:Nouveaute')
            ->findbyType(2);
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'nouveautes'=> $data,
        ]);
    }
}
