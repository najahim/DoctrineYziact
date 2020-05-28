<?php

namespace App\Controller;

use App\Entity\Borne;
use App\Entity\Peripherique;
use App\Entity\Personne;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Form\UserspaceType;
use App\Repository\UtilisateurRepository;
use App\Security\CustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
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
            $roles[] = 'ROLE_UD';
            $user->setValidation(false);
            $user->setRoles($roles);
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
            )?: new RedirectResponse('app_logout');
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
        $borne1 =new Borne();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        $mac=str_replace('-',':',$idBorne);
        //var_dump($mac);
        /*$entry = new Entry('cn=yo,dc=artica,dc=com', array(
            'sn' => array('yo'),
           'objectClass' => array('inetOrgPerson'),
        ));

        $entryManager = $ldap->getEntryManager();

// Creating a new entry
        $entryManager->add($entry);*/

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
            //$d=new Peripherique();


           // var_dump($request->headers->get('User-Agent'));
            $devic=$this->getDoctrine()->getRepository('App:Peripherique')
                ->findBy(array('adresse_mac'=>$mac));
            $devic=$devic[0];
            $device=$form->get('device')->getData();

            $devic->setAdresseMac($mac);

            $devic->setUtilisateur($user);
            if ($device->getPType())
            $devic->setPType($device->getPType());
            if ($device->getPOs())
            $devic->setPOs($device->getPOs());
            if ($device->getPBrand())
            $devic->setPBrand($device->getPBrand());
            if ($device->getPUseragent())
            $devic->setPUseragent($device->getPUseragent());
            if ($device->getPLang())
            $devic->setPLang($device->getPLang());
            if ($device->getPBrowser())
            $devic->setPBrowser($device->getPBrowser());

            $entityManager->persist($devic);
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

            // Ldap
            $ldap=Ldap::create('ext_ldap', [
                'host' => 'esisar-test01.123cigale.fr',
                'port' => '389',
                //'encryption'=>'ssl',
            ]);
            $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
            $cn='cn='.$mac.',dc=artica,dc=com';
            $date=new \DateTime('now');
            $date=$date->getTimestamp();
            $entry = new Entry($cn, array(
                'sn' => '0',
                'uid'=>  strtolower($date),
                'givenName'=>strtolower($cgu[0]->getId()),
                'objectClass' => array('inetOrgPerson'),
            ));

            $entryManager = $ldap->getEntryManager();
            //$entryManager->add($entry);



            $s = $this->getDoctrine()->getRepository('App:SessionWifi')
                ->findLast($devic->getId());
            $session=$s[0];
            $borne1=$this->getDoctrine()->getRepository('App:Borne')->find($session->getBorne());
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
        //$borne=new Borne();
        $dev=$this->getDoctrine()->getRepository('App:Peripherique')
            ->findBy(array('adresse_mac'=>$mac));
        //$borne=$this->getDoctrine()->getRepository('App:Borne')->find($idBorne);
        $s = $this->getDoctrine()->getRepository('App:SessionWifi')
            ->findLast($dev[0]->getId());
        $session=$s[0];
        $borne1=$this->getDoctrine()->getRepository('App:Borne')->find($session->getBorne());

        $locBorne=$borne1->getEmplacement();
        $nouveautes=$borne1->getNouveautes();
        //var_dump($nouveautes[0]->getId());
        return $this->render('registration/registerId.html.twig', [
            'registrationForm' => $form->createView(),
            'test'=> $test,
            'emplacement'=>$locBorne,
            'nouveautes'=>$nouveautes,
            'borne' => $borne1,
            'mac' => $idBorne,
        ]);
    }


    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UtilisateurRepository $users)
    {
        $user = $users->findOneBy(['activation_token' => $token]);
        $device=$this->getDoctrine()->getRepository('App:Peripherique')
            ->findBy(array('utilisateur'=>$user->getId()));
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
            //update Ldap
            $ldap=Ldap::create('ext_ldap', [
                'host' => 'esisar-test01.123cigale.fr',
                'port' => '389',
                //'encryption'=>'ssl',
            ]);
            $mac=$device[0]->getAdresseMac();
            $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
            $query = $ldap->query('cn='.$mac.',dc=artica,dc=com', '(objectclass=inetOrgPerson)');

            $result = $query->execute();
            //var_dump($result);
            $entry = $result[0];
            $entry->setAttribute('sn', ['1']);
            $entryManager = $ldap->getEntryManager();
            $entryManager->update($entry);
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
            $text=$borne->getNom();
            $text=str_replace(' ','_',$text);
            $jsonData=$jsonData .$text.': { lat: ' . $borne->getEmplacement()->getLatitude() . ', lon: ' . $borne->getEmplacement()->getLongitude(). ' }';
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



    /**
     * @Route("/userspace/{idBorne}", name="app_userspace")
     */
    public function Userspace(SessionInterface $session,$idBorne,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, CustomAuthenticator $authenticator,\Swift_Mailer $mailer): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(UserspaceType::class, $user);
        $form->handleRequest($request);

        $mac=str_replace('-',':',$idBorne);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $pass=(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $mail= $form->get('email')->getData();
            $currentUser=$this->getDoctrine()->getRepository('App:Utilisateur')
                ->findBy(array('email'=>$mail));
            //var_dump($currentUser[0]);
            if ($currentUser and $passwordEncoder->isPasswordValid($currentUser[0],$form->get('plainPassword')->getData()))
            {
                $entityManager = $this->getDoctrine()->getManager();
               /* $device=$form->get('device')->getData();
                $device->setAdresseMac($idBorne);
                $device->setUtilisateur($currentUser[0]);
                $entityManager->persist($device);
                $entityManager->flush();
                // Ldap
                $ldap=Ldap::create('ext_ldap', [
                    'host' => 'esisar-test01.123cigale.fr',
                    'port' => '389',
                    //'encryption'=>'ssl',
                ]);
                $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
                $cn='cn='.$idBorne.',dc=artica,dc=com';
                $date=new \DateTime('now');
                $date=$date->getTimestamp();
                $entry = new Entry($cn, array(
                    'sn' => '0',
                    'uid'=>  strtolower($date),
                    'givenName'=>strtolower($currentUser[0]->getVersionCgu()->getId()),
                    'objectClass' => array('inetOrgPerson'),
                ));

                $entryManager = $ldap->getEntryManager();
                //$entryManager->add($entry);*/


                //
                $devic=$this->getDoctrine()->getRepository('App:Peripherique')
                    ->findBy(array('adresse_mac'=>$mac));
                $devic=$devic[0];
                $device=$form->get('device')->getData();

                $devic->setAdresseMac($mac);

                $devic->setUtilisateur($currentUser[0]);
                if ($device->getPType())
                    $devic->setPType($device->getPType());
                if ($device->getPOs())
                    $devic->setPOs($device->getPOs());
                if ($device->getPBrand())
                    $devic->setPBrand($device->getPBrand());
                if ($device->getPUseragent())
                    $devic->setPUseragent($device->getPUseragent());
                if ($device->getPLang())
                    $devic->setPLang($device->getPLang());
                if ($device->getPBrowser())
                    $devic->setPBrowser($device->getPBrowser());

                //
                $entityManager->persist($devic);
                $entityManager->flush();

                // Ldap
                $ldap=Ldap::create('ext_ldap', [
                    'host' => 'esisar-test01.123cigale.fr',
                    'port' => '389',
                    //'encryption'=>'ssl',
                ]);
                $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
                $cn='cn='.$mac.',dc=artica,dc=com';
                $date=new \DateTime('now');
                $date=$date->getTimestamp();
                $entry = new Entry($cn, array(
                    'sn' => '0',
                    'uid'=>  strtolower($date),
                    'givenName'=>strtolower($currentUser[0]->getVersionCgu()->getId()),
                    'objectClass' => array('inetOrgPerson'),
                ));

                $entryManager = $ldap->getEntryManager();
                //$entryManager->add($entry);
                $session->set('id',$currentUser[0]->getId());
                return $this->redirect('https://127.0.0.1:8000/userspaces/devices');

            }


            else
                throw new CustomUserMessageAuthenticationException('Email could not be found.');


        }

        $test = $this->jsonLocalisation();
        //$borne=new Borne();
        $dev=$this->getDoctrine()->getRepository('App:Peripherique')
            ->findBy(array('adresse_mac'=>$mac));
        //$borne=$this->getDoctrine()->getRepository('App:Borne')->find($idBorne);
        $s = $this->getDoctrine()->getRepository('App:SessionWifi')
            ->findLast($dev[0]->getId());
        $session=$s[0];
        $borne1=$this->getDoctrine()->getRepository('App:Borne')->find($session->getBorne());

        $locBorne=$borne1->getEmplacement();
        $nouveautes=$borne1->getNouveautes();
        //var_dump($nouveautes[0]->getId());
        return $this->render('registration/userspace.html.twig', [
            'registrationForm' => $form->createView(),
            'test'=> $test,
            'emplacement'=>$locBorne,
            'nouveautes'=>$nouveautes,
            'borne' => $borne1,
            'mac' => $idBorne,
        ]);
    }




    /**
     * @Route ("/userspaces/devices/supprimer/{id}",name="device.supprimer")
     */
    public function supprimerdevice(SessionInterface $session,$id,Request $request):Response
    {
        $device= $this->getDoctrine()->getRepository('App:Peripherique')->find($id);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($device);
        $entityManager->flush();
        var_dump($session->get('id'));
        $session->set('id',$session->get('id'));
        return $this->redirect('https://127.0.0.1:8000/userspaces/devices');
    }
    /**
     * @Route("/userspaces/devices", name="app_devices")
     */
    public function UserspaceDevices(SessionInterface $session): Response
    {
        $data=$this->getDoctrine()->getRepository('App:Utilisateur')
            ->find($session->get('id'));
        return $this->render('registration/devices.html.twig', [
            'data'=>$data
        ]);
    }
}
