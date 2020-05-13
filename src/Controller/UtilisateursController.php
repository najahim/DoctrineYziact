<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Manager;
use App\Entity\UtilisateurSearch;
use App\Form\AdminRegistrationType;
use App\Form\ManagerRegistrationType;
use App\Form\ModifierManagerType;
use App\Form\MotdepasseType;
use App\Form\UtilisateurSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateursController extends AbstractController
{
    /**
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function index(Request $request)
    {


        $data = $this->getDoctrine()->getRepository('App:Utilisateur')->findAll();


        return $this->render('utilisateurs/index.html.twig', [
            'controller_name' => 'UtilisateursController',
            'data'=>$data,
        ]);
    }


    /**
     * @Route ("/admin/ajouter",name="utilisateurs.ajouterAdmin")
     */
    public function ajouterAdmin(UserPasswordEncoderInterface $passwordEncoder,Request $request):Response
    {
        $admin= new Admin();
        $form=$this->createForm(AdminRegistrationType::class,$admin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword(
                $passwordEncoder->encodePassword(
                    $admin,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles[] = 'ROLE_ADMIN';
            //$admin=$form->getData();
            $admin->setRoles($roles);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

        }
        return $this->render('utilisateurs/ajouterAdmin.html.twig', [
            'admin' => $admin,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/managers/ajouter",name="utilisateurs.ajouterManager")
     */
    public function ajouterManager(UserPasswordEncoderInterface $passwordEncoder,Request $request):Response
    {
        $manager= new Manager();
        $form=$this->createForm(ManagerRegistrationType::class,$manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->setPassword(
                $passwordEncoder->encodePassword(
                    $manager,
                    $form->get('plainPassword')->getData()
                )
            );
            $roles[] = 'ROLE_USER';
            //$admin=$form->getData();
            $manager->setRoles($roles);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manager);
            $entityManager->flush();

        }
        return $this->render('utilisateurs/ajouterManager.html.twig', [
            'manager' => $manager,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/managers", name="utilisateurs.managers")
     */
    public function indexManager(Request $request)
    {


        $data = $this->getDoctrine()->getRepository('App:Manager')->findAll();


        return $this->render('utilisateurs/managers.html.twig', [
            'controller_name' => 'UtilisateursController',
            'data'=>$data,
        ]);
    }



    /**
     * @Route ("/managers/modifier/{id}",name="utilisateurs.modifierManager")
     */
    public function modifierManager($id,Request $request):Response
    {
        $manager= new Manager();
        $manager=$this->getDoctrine()->getRepository('App:Manager')
            ->find($id);
        $form=$this->createForm(ModifierManagerType::class,$manager);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //$admin=$form->getData();
            //$manager->setRoles($roles);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manager);
            $entityManager->flush();

        }
        return $this->render('utilisateurs/modifierManager.html.twig', [
            'manager' => $manager,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/mdp",name="utilisateurs.motdepasse")
     */
    public function modifierpasseword(Request $request,UserPasswordEncoderInterface $passwordEncoder):Response
    {
        $user= $this->getUser();
        $form=$this->createForm(MotdepasseType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $oldpassword=$passwordEncoder->encodePassword(
                $user,
                $form->get('motdepasse')->getData()
            );
            if($passwordEncoder->isPasswordValid($user,$form->get('motdepasse')->getData()))
            {

                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('newpassword')->getData()
                    )
                );
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

            }
            else
            {
                $form->addError(new FormError('Ancien mot de passe incorrect'));

            }

        }
        return $this->render('utilisateurs/motdepasse.html.twig', [
            'manager' => $user,
            'form'=>$form->createView(),
        ]);
    }
}
