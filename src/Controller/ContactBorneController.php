<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\TypeNouveaute;
use App\Form\ContactBorneType;
use App\Form\ContactType;
use App\Form\TypeNouveauteType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactBorneController extends AbstractController
{
    /**
     * @Route("/contact/borne", name="contact_borne")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Contact')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('contact_borne/index.html.twig', [
            'controller_name' => 'ContactBorneController',
            'data'=>$data,
        ]);
    }

    /**
     * @Route("/contact/borne/ajouter", name="contact_borne.ajouter")
     */
    public function ajouterContact(Request $request):Response
    {
        $contact= new Contact();
        $form=$this->createForm(ContactBorneType::class,$contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

        }

        return $this->render('contact_borne/ajouter.html.twig', [
            'contact' => $contact,
            'form'=>$form->createView(),
        ]);
    }
}
