<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// #[Route('/examen')]
class ApiExamenController extends AbstractController
{

    /*
        /               : identification POST
        /start          : consignes de l'examen (bouton commencer) GET
        /question/{id}  : question n°id (boutons : valider, question précédente, question suivante (si déjà répondu)) : POST (ou PATCH ?)
        /end            : synthèse du QCM 
    */

    // #[Route('/connexion', name: 'api_examen_connexion', methods: ['POST'])]
    // public function connexion(Request $request): Response
    // {
    //     // $data = json_decode($request->getContent(), true);
    //     $data = $request->request->all();
    //     return $this->json(['result' => 'Connexion OK', $data, 'codeForm' => 'a'], 200);
    // }

    // #[Route('/consignes', name: 'api_examen_consignes', methods: ['GET'])]
    // public function consignes(Request $request): Response
    // {
    //     $data = $request->request->all();
    //     return $this->json(['result' => 'Consignes OK', $data, 'question' => 58], 200);
    // }

    // #[Route('/question', name: 'api_examen_question', methods: ['POST'])]
    // public function question(Request $request): Response
    // {
    //     $data = $request->request->all();
    //     return $this->json(['result' => 'Question OK', $data, 'question' => 58], 200);
    // }

    #[Route('/resultat', name: 'api_examen_resultat', methods: ['GET'])]
    public function resultat(Request $request): Response
    {
        $data = $request->request->all();
        return $this->json(['result' => 'Resultat OK', $data], 200);
    }
}
