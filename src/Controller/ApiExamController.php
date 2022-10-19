<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\Examens;
use App\Entity\Questionnaires;
use App\Repository\ElevesRepository;
use App\Repository\ExamensRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use App\Repository\ReponsesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarExporter\Internal\Hydrator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiExamController extends AbstractController
{

    // Formulaire de connexion
    #[Route('/examen/connexion', name: 'api_exam_connexion')]
    public function exam_connexion(
        Request $request,
        QuestionnairesRepository $questionnairesRepository,
        ElevesRepository $elevesRepository,
        ExamensRepository $examensRepository
    ): Response {
        $data = $request->request->all();

        $questionnaire = $questionnairesRepository->findOneBy(['code' => $data['code']]);

        $eleve = new Eleves();
        $eleve->setFirstname($data['firstname']);
        $eleve->setLastname($data['lastname']);
        $eleve->setEmail('');
        $elevesRepository->save($eleve);

        $examen = new Examens();
        $examen->addEleve($eleve);
        $examen->setQuestionnaires($questionnaire);
        $examensRepository->save($examen, true);


        return $this->json(['eleve' => $eleve->getId(), 'questionnaire' => $questionnaire->getId()], 200);
    }

    // Affichage des consignes
    #[Route('/examen/consignes/{id}', name: 'api_exam_consignes')]
    public function exam_consignes(Request $request, Questionnaires $questionnaire): Response
    {
        return $this->json(['consignes' => $questionnaire->getConsigne()], 200);
    }

    // Affichage d'une question
    #[Route('/examen/question/{id}', name: 'api_exam_question', methods: ['GET'])]
    public function exam_question(
        Questionnaires $questionnaire,
        QuestionsRepository $questionsRepository,
        ReponsesRepository $reponsesRepository
    ): Response {
        $question = $questionsRepository->findByQuestionnaires($questionnaire->getId())[0];
        // dd($question);
        $reponses = $question->getReponses();
        // dd(count($reponses));
        // dd($reponses);
        return $this->json(['question' => $question->getLabel(), 'reponses' => $reponses], 200);
    }

    // Sauvegarde réponse à une question
    #[Route('/examen/question', name: 'api_exam_reponse', methods: ['POST'])]
    public function exam_reponse(
        Request $request,
        QuestionnairesRepository $questionnairesRepository,
        QuestionsRepository $questionsRepository
    ): Response {
        return $this->json([], 200);
    }


    // Affichage des résultats
    #[Route('/examen/resultats', name: 'api_exam_resultats')]
    public function exam_resultats(): Response
    {
        return $this->json([], 200);
    }
}
