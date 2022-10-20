<?php

namespace App\Controller;

use App\Entity\Questionnaires;
use App\Form\QuestionnaireType;
use App\Repository\QuestionsRepository;
use App\Repository\QuestionnairesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionnairesController extends AbstractController
{
    #[Route('/questionnaires', name: 'app_questionnaires')]
    public function index(QuestionnairesRepository $questionnairesRepository): Response
    {
        return $this->render('questionnaires/index.html.twig', [
            'questionnaires' => $questionnairesRepository->findAll(),
            'form'           => $this->createForm(QuestionnaireType::class)->createView(),
        ]);
    }

    #[Route('/questionnaires/{id}', name: 'app_questionnaires_update')]
    public function update(
        Questionnaires $questionnaire,
        QuestionnairesRepository $questionnairesRepository,
        QuestionsRepository $questionsRepository,
        Request $request
    ): Response {

        $form = $this->createForm(QuestionnaireType::class, $questionnaire)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnairesRepository->save($questionnaire, true);
            $this->addFlash('success', 'Le questionnaire a été modifié');
            $this->redirectToRoute('app_questionnaires');
        }

        return $this->render('questionnaires/update.html.twig', [
            'questions_liees'       =>  $questionnaire->getQuestions(),
            'questions_disponibles' =>  $questionsRepository->findQuestionsDisponibles($questionnaire->getId()),
            'form'                  =>  $form->createView(),
            'questionnaire_id'      =>  $questionnaire->getId(),
        ]);
    }
}
