<?php

namespace App\Controller;

use App\Entity\Borne;
use App\Entity\Personne;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use App\Security\CustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, CustomAuthenticator $authenticator,\Swift_Mailer $mailer): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setValidation(false);
            $user->setActivationToken(md5(uniqid()));
            $user->setDateCreation(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('testyziact@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(

                    $this->renderView(
                        'email/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);


            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            )?: new RedirectResponse('/bornes');
        }
        $nouveautes=$this->getDoctrine()->getRepository('App:Nouveaute')
            ->findAll();

        $test = $this->jsonLocalisation();
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'test'=> $test,
            'nouveautes'=>$nouveautes,

        ]);
    }


    /**
     * @Route("/register/{idBorne}", name="app_registerId")
     */
    public function registerBorne($idBorne,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, CustomAuthenticator $authenticator,\Swift_Mailer $mailer): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setValidation(false);
            $user->setActivationToken(md5(uniqid()));
            $user->setDateCreation(new \DateTime('now'));
            $cgu=$this->getDoctrine()->getRepository('App:VersionCGU')
                ->findLast();
            $user->setVersionCgu($cgu[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('testyziact@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(

                    $this->renderView(
                        'email/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            $borne1=new Borne();
            $borne1=$this->getDoctrine()->getRepository('App:Borne')->find($idBorne);
            $url=$borne1->getPortailUrl();
            if($url)
            {
                /*return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $authenticator,
                    'main' // firewall name in security.yaml
                )?: new RedirectResponse($url);*/
                return $this->redirect($url);

            }
            /*return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            )?: new RedirectResponse('http://www.cigale-hotspot.fr/qui-sommes-nous/');*/
            return $this->redirect('http://www.cigale-hotspot.fr/qui-sommes-nous/');

        }

        $test = $this->jsonLocalisation();
        $borne=new Borne();
        $borne=$this->getDoctrine()->getRepository('App:Borne')->find($idBorne);
        $locBorne=$borne->getEmplacement();
        $nouveautes=$borne->getNouveautes();
        //var_dump($nouveautes[0]->getId());
        return $this->render('registration/registerId.html.twig', [
            'registrationForm' => $form->createView(),
            'test'=> $test,
            'emplacement'=>$locBorne,
            'nouveautes'=>$nouveautes,
            'borne' => $borne,
        ]);
    }


    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UtilisateurRepository $users)
    {
        $user = $users->findOneBy(['activation_token' => $token]);

        if(!$user){
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }
        $dateAcceptation= new \DateTime('now');
        $dateAcceptation=$dateAcceptation->getTimestamp();
        $dateCreation=$user->getDateCreation()->getTimestamp();
        $interval= $dateAcceptation-$dateCreation;
        var_dump($dateCreation);
        var_dump($dateAcceptation);
        var_dump($interval);
        if($interval<=900)
        {
            $user->setActivationToken(null);
            $user->setValidation(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

        // On génère un message
            $this->addFlash('message', 'Utilisateur activé avec succès');
        // On retourne à l'accueil
            return $this->redirectToRoute('/bornes');
        }
        $this->addFlash('message', 'lien a expiré');
        // On retourne à l'accueil
        return $this->redirect('https://127.0.0.1:8000/logout');
    }
    public function jsonLocalisation(){
        $Locs = [];
        $taille= 0;
        // $matrice=[];
        $jsonData = '{';
        $borne = new Borne();
        $bornes = $this->getDoctrine()->getManager()
            ->getRepository('App:Borne')
            ->findAll();
        //var_dump($bornes);
        $t=count($bornes);
        //var_dump($t);
        foreach ($bornes as $borne){
            $taille=$taille+1;
            //$matrices=[];
            $jsonData=$jsonData .$borne->getEmplacement()->getAdresse()->getVille().': { lat: ' . $borne->getEmplacement()->getLatitude() . ', lon: ' . $borne->getEmplacement()->getLongitude(). ' }';
            if ($taille<$t)
            {
                $jsonData =$jsonData .',';
            }
            //array_push($matrices,$taille);
            // array_push($matrices,$borne->getEmplacement()->getLatitude());
            // array_push($matrices,$borne->getEmplacement()->getLongitude());
            // array_push($matrice,$matrices);
        }
        $jsonData =$jsonData .'}';
        if ($Locs === 0)
            return null;
        else
        {
            //var_dump($jsonData);
            $Locs = JsonResponse::fromJsonString($jsonData)->getContent();
            //return $matrice;
            //$Locs=$jsonData;
            return $Locs;
        }


    }
}
