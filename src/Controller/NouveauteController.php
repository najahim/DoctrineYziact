<?php

namespace App\Controller;

use App\Entity\Flotte;
use App\Entity\Nouveaute;
use App\Form\FlotteType;
use App\Form\NouveauteType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NouveauteController extends AbstractController
{
    /**
     * @Route("/nouveaute", name="nouveaute")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Nouveaute')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('nouveaute/index.html.twig', [
            'controller_name' => 'NouveauteController',
            'data'=> $data,
        ]);
    }

    /**
     * @Route ("/nouveaute/ajouter",name="nouveaute.ajouter")
     */
    public function ajouterNouveaute(Request $request):Response
    {
        $nouveaute= new Nouveaute();
        $form=$this->createForm(NouveauteType::class,$nouveaute);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $nouveaute->setDateNouveaute(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nouveaute);
            $entityManager->flush();

        }

        return $this->render('nouveaute/ajouter.html.twig', [
            'nouveaute' => $nouveaute,
            'form'=>$form->createView(),
        ]);
    }
}
