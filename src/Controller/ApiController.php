<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/api/url", name="api",methods={"POST"})
     */
    public function indexurl(Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("api/monitor", name="api_monitor",methods={"POST"})
     */
    public function monitor(Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        if (isset($data['Nouveaux'])) {
            foreach ($data['Nouveaux'] as $nouveau) {
                $mac = $nouveau['mac'];
                $rx = 0;
                $tx = 0;

                if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                    // nouvelle session avec $mac $rx $tx et l'heure actuelle en heure de début
                }
            }
        }

        if (isset($data['Deconnectes'])) {
            foreach ($data['Deconnectes'] as $deconnectes) {
                $mac = $deconnectes['mac'];
                $rx = $deconnectes['rx'];
                $tx = $deconnectes['tx'];

                if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                    // fin de session pour la derniere session de $mac avec pour valeur $rx $tx et l'heure actuelle en heure de fin
                }
            }
        }

        if (isset($data['Update'])) {
            foreach ($data['Update'] as $update) {
                $mac = $update['mac'];
                $rx = $update['rx'];
                $tx = $update['tx'];

                if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                    // actualiser pour la derniere session de $mac avec pour valeur $rx $tx
                }
            }
        }

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
}
