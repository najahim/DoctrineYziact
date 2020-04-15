<?php

namespace App\Controller;

use App\Entity\Langue;
use App\Entity\VersionCGU;
use App\Form\LangueType;
use App\Form\VersionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LangueController extends AbstractController
{
    /**
     * @Route("/langue", name="langue")
     */
    public function index()
    {
        $langues=$this->getDoctrine()->getRepository('App:Langue')
            ->findAll();
        return $this->render('langue/index.html.twig', [
            'controller_name' => 'LangueController',
            'langues' => $langues
        ]);
    }

    /**
     * @Route("/langue/ajouterLangue", name="langue.ajouterLangue")
     *
     */
    public function ajouterLangue(Request $request):Response
    {
        $langue= new Langue();
        $form=$this->createForm(LangueType::class,$langue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($langue);
            $entityManager->flush();

        }
        return $this->render('/langue/ajouterLangue.html.twig', [
            'langue' => $langue,
            'form'=>$form->createView(),
        ]);
    }
}
