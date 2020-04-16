<?php

namespace App\Controller;

use App\Entity\Organisation;
use App\Entity\TypeOrganisation;
use App\Form\OrganisationType;
use App\Form\TypeOrganisationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganisationController extends AbstractController
{
    /**
     * @Route("/organisation", name="organisation")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Organisation')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('organisation/index.html.twig', [
            'controller_name' => 'OrganisationController',
            'data'=>$data,
        ]);
    }

    /**
     * @Route("/organisation/ajouter", name="organisation.ajouter")
     */
    public function ajouterOrganisation(Request $request):Response
    {
        $organisation= new Organisation();
        $form=$this->createForm(OrganisationType::class,$organisation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisation);
            $entityManager->flush();

        }

        return $this->render('organisation/ajouter.html.twig', [
            'organisation' => $organisation,
            'form'=>$form->createView(),
        ]);
    }
}
