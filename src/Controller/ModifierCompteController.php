<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Manager;
use App\Form\ManagerRegistrationType;
use App\Form\ModifierAdminType;
use App\Form\ModifierManagerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ModifierCompteController extends AbstractController
{
    /**
     * @Route("/modifiercompte", name="modifiercompte")
     */
    public function index(UserPasswordEncoderInterface $passwordEncoder,Request $request):Response
    {
        $user=$this->getUser();
        $form;
        if ($user instanceof Admin) {
            $form = $this->createForm(ModifierAdminType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }
        if ($user instanceof Manager) {
            $form = $this->createForm(ModifierManagerType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }
        return $this->render('modifiercompte/index.html.twig', [
            'controller_name' => 'ModifierCompteController',
            '$user' => $user,
            'form'=>$form->createView(),
        ]);
    }
}
