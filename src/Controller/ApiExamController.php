<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiExamController extends AbstractController
{

    // Formulaire de connexion
    #[Route('/examen/connexion', name: 'api_exam_connexion')]
    public function exam_connexion(Request $request): Response
    {
        $data = $request->request->all();
        return $this->json(['data' => $data], 200);
    }

    // Affichage des consignes
    #[Route('/examen/consignes', name: 'api_exam_consignes')]
    public function exam_consignes(): Response
    {
        return $this->json(['consignes' => 'Bla Bla'], 200);
    }

    // Affichage d'une question
    #[Route('/examen/question', name: 'api_exam_question')]
    public function exam_question(): Response
    {
        return $this->json([], 200);
    }

    // Affichage des résultats
    #[Route('/examen/resultats', name: 'api_exam_resultats')]
    public function exam_resultats(): Response
    {
        return $this->json([], 200);
    }
}
