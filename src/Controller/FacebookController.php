<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/facebook", name="connect_facebook")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('facebook_main')
            ->redirect();
    }

    /**
     * Facebook redirects to back here afterwards
     *
     * @Route("/connect/facebook/check", name="connect_facebook_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request,\Swift_Mailer $mailer):Response
    {
        $user=$this->getUser();
        if (!$user) {
            return new JsonResponse(array('status' => false, 'message' => "User not found!"));
        } else {
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
            return $this->redirect('http://www.cigale-hotspot.fr/qui-sommes-nous/');

        }

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
            return $this->redirectToRoute('bornes');
        }
        $this->addFlash('message', 'lien a expiré');
        // On retourne à l'accueil
        return $this->redirect('https://127.0.0.1:8000/logout');
    }


}