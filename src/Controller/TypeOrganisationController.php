<?php

namespace App\Controller;

use App\Entity\TypeOrganisation;
use App\Form\TypeOrganisationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Ldap\Entry;
use Symfony\Component\Ldap\Ldap;
use Symfony\Component\Routing\Annotation\Route;

class TypeOrganisationController extends AbstractController
{
    /**
     * @Route("/type/organisation", name="type_organisation")
     */
    public function index(Request $request)
    {
        /*$ldap=Ldap::create('ext_ldap', [
            'host' => 'esisar-test01.123cigale.fr',
            'port' => '389',
            //'encryption'=>'ssl',
        ]);
        //$mac=$device[0]->getAdresseMac();
        $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
        $query = $ldap->query('cn=1,dc=artica,dc=com', '(objectclass=inetOrgPerson)');

        $result = $query->execute();
        //var_dump($result);
        $entry = $result[0];
        $entry->setAttribute('sn', ['1']);
        $entryManager = $ldap->getEntryManager();
        $entryManager->update($entry);*/

        //add first cgu
       /* $ldap=Ldap::create('ext_ldap', [
            'host' => 'esisar-test01.123cigale.fr',
            'port' => '389',
            //'encryption'=>'ssl',
        ]);
        $ldap->bind('cn=admin,dc=artica,dc=com','azerty');
        $cn='cn=cgu,dc=artica,dc=com';
        $date=new \DateTime('now');
        $date=$date->getTimestamp();
        $entry = new Entry($cn, array(
            'sn' => 'cgu',
            'uid'=>  strtolower($date),
            'givenName'=>'1',
            'objectClass' => array('inetOrgPerson'),
        ));

        $entryManager = $ldap->getEntryManager();
        $entryManager->add($entry);*/
        $date=new \DateTime('now');
        $date=$date->format('yy-m-d');
        var_dump($date);
        $data=$this->getDoctrine()->getRepository('App:TypeOrganisation')
            ->findAll();

        return $this->render('type_organisation/index.html.twig', [
            'controller_name' => 'TypeOrganisationController',
            'data'=>$data,
        ]);
    }
    /**
     * @Route("/type/organisation/ajouter", name="type_organisation.ajouter")
     */
    public function ajouterType(Request $request):Response
    {
        $type= new TypeOrganisation();
        $form=$this->createForm(TypeOrganisationType::class,$type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

        }

        return $this->render('type_organisation/ajouter.html.twig', [
            'type' => $type,
            'form'=>$form->createView(),
        ]);
    }
}
