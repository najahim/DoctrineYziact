<?php

namespace App\Controller;

use App\Entity\Flotte;
use App\Entity\Manager;
use App\Form\FlotteType;
use App\Form\ManagerRegistrationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FlotteController extends AbstractController
{
    /**
     * @Route("/flotte", name="flotte")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Flotte')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('flotte/index.html.twig', [
            'controller_name' => 'FlotteController',
            'data'=>$data,
        ]);
    }

    /**
     * @Route ("/flotte/ajouter",name="flotte.ajouter")
     */
    public function ajouterFlotte(Request $request):Response
    {
        $flotte= new Flotte();
        $form=$this->createForm(FlotteType::class,$flotte);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flotte);
            $entityManager->flush();

        }
        $manager=$this->getDoctrine()->getRepository('App:Manager')
            ->findAll();

        return $this->render('flotte/ajouter.html.twig', [
            'flotte' => $flotte,
            'manager'=>$manager,
            'form'=>$form->createView(),
        ]);
    }
}
