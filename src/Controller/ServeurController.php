<?php

namespace App\Controller;

use App\Entity\Nouveaute;
use App\Entity\Serveur;
use App\Form\DeployerServeurType;
use App\Form\NouveauteType;
use App\Form\ServeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServeurController extends AbstractController
{
    /**
     * @Route("/serveurs", name="serveur")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:Serveur')
            ->findAll();

        return $this->render('serveur/index.html.twig', [
            'controller_name' => 'ServeurController',
            'data'=>$data
        ]);
    }

    /**
     * @Route ("/serveurs/ajouter",name="serveur.ajouter")
     */
    public function ajouterServeur(Request $request):Response
    {
        $serveur= new Serveur();
        $form=$this->createForm(ServeurType::class,$serveur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $serveur->setDerniereMAJ(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serveur);
            $entityManager->flush();

        }

        return $this->render('serveur/ajouter.html.twig', [
            'serveur' => $serveur,
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route ("/serveurs/modifier/{id}",name="serveur.modifier")
     */
    public function modifierServeur($id,Request $request):Response
    {
        $serveur= new Serveur();
        $serveur=$this->getDoctrine()->getRepository('App:Serveur')
            ->find($id);
        $form=$this->createForm(ServeurType::class,$serveur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $serveur->setDerniereMAJ(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serveur);
            $entityManager->flush();

        }

        return $this->render('serveur/modifier.html.twig', [
            'serveur' => $serveur,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/serveurs/deployer",name="serveur.deployer")
     */
    public function deployerServeur(Request $request):Response
    {
        $serveur=new Serveur();

        $form=$this->createForm(DeployerServeurType::class,$serveur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$s=new Serveur();
            $s=$form->get('serveur')->getData();
            //$serveur1=$this->getDoctrine()->getRepository('App:Serveur')
             //   ->find($s->getId());
            $s->setDerniereMAJ(new \DateTime('now'));
            $bornes=$form->get('bornes')->getData();
            foreach ($bornes as $b)
            {
                $s->addBorne($b);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($s);
            $entityManager->flush();

        }

        return $this->render('serveur/deployer.html.twig', [
            'serveur' => $serveur,
            'form'=>$form->createView(),
        ]);
    }
}
