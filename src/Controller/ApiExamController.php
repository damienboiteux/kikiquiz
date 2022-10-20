<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Entity\Examens;
use App\Entity\Questionnaires;
use App\Entity\ReponsesEleves;
use App\Repository\ElevesRepository;
use App\Repository\ExamensRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use App\Repository\ReponsesElevesRepository;
use App\Repository\ReponsesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiExamController extends AbstractController
{

    // Formulaire de connexion
    #[Route('/examen/connexion', name: 'api_exam_connexion', methods: ['POST'])]
    public function exam_connexion(
        Request $request,
        QuestionnairesRepository $questionnairesRepository,
        ElevesRepository $elevesRepository,
        ExamensRepository $examensRepository
    ): Response {

        // dd($request->request->all());
        $data = $request->request->all();

        $questionnaire = $questionnairesRepository->findOneBy(['code' => $data['code']]);

        $eleve = new Eleves();
        $eleve->setFirstname($data['firstname']);
        $eleve->setLastname($data['lastname']);
        $eleve->setEmail('');
        $elevesRepository->save($eleve, true);

        $examen = new Examens();
        $examen->setEleves($eleve);
        $examen->setQuestionnaires($questionnaire);
        $examensRepository->save($examen, true);

        return $this->json([
            'eleve'         => $eleve->getId(),
            'questionnaire' => $questionnaire->getId(),
            'examen'        => $examen->getId()
        ], 200);
    }

    // Affichage des consignes
    #[Route('/examen/consignes/{id}', name: 'api_exam_consignes')]
    public function exam_consignes(Request $request, Questionnaires $questionnaire): Response
    {
        return $this->json(['consignes' => $questionnaire->getConsigne()], 200);
    }

    // Affichage d'une question
    #[Route('/examen/question/{id}/{offset}', name: 'api_exam_question', methods: ['GET'])]
    public function exam_question(
        Questionnaires $questionnaire,
        QuestionsRepository $questionsRepository,
        int $offset
    ): Response {
        $question = $questionsRepository->findNextQuestion($questionnaire->getId(), $offset)[0];
        $reponses = $question->getReponses();

        return $this->json([
            'question' => $question->getLabel(),
            'reponses' => $reponses,
            'idQuestion' => $question->getId
        ], 200);
    }

    // Sauvegarde réponse à une question
    #[Route('/examen/reponse', name: 'api_exam_reponse', methods: ['POST'])]
    public function exam_reponse(
        Request $request,
        QuestionsRepository $questionsRepository,
        ExamensRepository $examensRepository,
        ReponsesElevesRepository $reponsesElevesRepository
    ): Response {
        $data = $request->request->all();

        $examen = $examensRepository->find($data['id-examen']);
        $question = $questionsRepository->find($data['id-question']);

        $reponse = new ReponsesEleves();
        $reponse->setCommentaire('');
        $reponse->setSuccess(false);
        $reponse->setExamens($examen);
        $reponse->setQuestions($question);
        $reponsesElevesRepository->save($reponse, true);

        $question = $questionsRepository->findNextQuestion($data['id-questionnaire'], ++$data['offset'])[0];
        $reponses = $question->getReponses();

        return $this->json(['msg' => 'ok'], 200);
    }


    // Affichage des résultats
    #[Route('/examen/resultats', name: 'api_exam_resultats')]
    public function exam_resultats(): Response
    {
        return $this->json([], 200);
    }
}
