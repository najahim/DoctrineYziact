<?php


namespace App\Controller;

use App\Entity\Peripherique;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class GoogleController extends AbstractController
{

    public $device ;
    public $id;

    public function setDevice(Peripherique $device)
    {
        $this->device=$device;

    }
    public function getDevice()
    {
        return $this->device;
    }
   /* public static function setId(string $id)
    {
        self::$id=$id;
    }*/
    public function __construct()
    {
        $this->device=new Peripherique();
    }

    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(SessionInterface $session,ClientRegistry $clientRegistry,Request $request)
    {


        $this->device->setAdresseMac($request->query->get('mac'));
        $this->device->setPOs($request->query->get('os'));
        $this->device->setPUseragent($request->query->get('useragent'));
        $this->device->setPType($request->query->get('type'));
        $this->device->setPLang($request->query->get('lang'));
        $this->device->setPBrowser($request->query->get('browser'));
        $this->device->setPBrand($request->query->get('brand'));
        $this->setDevice($this->device);
        $user=$this->getUser();
        $this->device->setUtilisateur($user);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($this->device);
        $entityManager->flush();
        $this->id=($request->query->get('mac'));
        $session->set('id',$request->query->get('mac'));
        $session->set('new',$request->query->get('new'));
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    /**
     * Google redirects to back here afterwards
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(SessionInterface $session,Request $request,\Swift_Mailer $mailer):Response
    {
        $user=$this->getUser();
        $cgu=$this->getDoctrine()->getRepository('App:VersionCGU')
            ->findLast();

        if (!$user) {
            return new JsonResponse(array('status' => false, 'message' => "User not found!"));
        } else {
            /*$message = (new \Swift_Message('Nouveau compte'))
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
            $mailer->send($message);*/
            $cgu=$this->getDoctrine()->getRepository('App:VersionCGU')
                ->findLast();

            $uti=$this->getDoctrine()->getRepository('App:Utilisateur')
                ->findBy(array('email'=>$user->getUsername()));

            $device=$this->getDoctrine()->getRepository('App:Peripherique')
                ->findBy(array('adresse_mac'=>$session->get('id')));
            $device[0]->setUtilisateur($uti[0]);
            $entityManager = $this->getDoctrine()->getManager();


            $entityManager->persist($device[0]);
            $entityManager->flush();
            $uti[0]->setVersionCgu($cgu[0]);

            $entityManager->persist($uti[0]);
            $entityManager->flush();
            // Ldap
            $ldap=Ldap::create('ext_ldap', [
                'host' => 'esisar-test01.123cigale.fr',
                'port' => '389',
                //'encryption'=>'ssl',
            ]);
            $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
            $cn='cn='.$session->get('id').',dc=artica,dc=com';
            $date=new \DateTime('now');
            $date=$date->getTimestamp();
            $entry = new Entry($cn, array(
                'sn' => '0',
                'uid'=>  strtolower($date),
                'givenName'=>strtolower($cgu[0]->getId()),
                'objectClass' => array('inetOrgPerson'),
            ));

            $entryManager = $ldap->getEntryManager();
           // $entryManager->add($entry);





            if ($session->get('new')==0)
            {
                $session->set('id',$uti[0]->getId());
                return $this->redirect('https://127.0.0.1:8000/userspaces/devices');
            }
            return $this->redirect('http://www.cigale-hotspot.fr/');


        }

    }
    /**
     * @Route ("/google/test",name="google.test")
     */
    public function historiqueBorne($id,Request $request):Response
    {
        $borne= $this->getDoctrine()->getRepository('App:Activation')->findByBorne($id);
        $user=$this->getUser();
        var_dump($user);
        return $this->render('google/test.html.twig', [
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
            return $this->redirectToRoute('bornes');
        }
        $this->addFlash('message', 'lien a expiré');
        // On retourne à l'accueil
        return $this->redirect('https://127.0.0.1:8000/logout');
    }



}