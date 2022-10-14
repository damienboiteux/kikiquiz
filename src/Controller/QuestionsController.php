<?php

namespace App\Controller;

use App\Entity\Questions;
use App\Form\ReponseType;
use App\Form\QuestionType;
use App\Repository\ReponsesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionsController extends AbstractController
{
    #[Route('/questions', name: 'app_questions', methods: ['GET'])]
    public function index(QuestionsRepository $questionsRepository): Response
    {
        return $this->render('questions/index.html.twig', [
            'questions' => $questionsRepository->findAll(),
            'form'      => $this->createForm(QuestionType::class)->createView(),
        ]);
    }

    #[Route('/questions/{id}', name: 'app_questions_update')]
    public function update(Questions $question, ReponsesRepository $reponsesRepository): Response
    {
        dd($question);
        return $this->render('questions/update.html.twig', [
            'reponses'      => $reponsesRepository->findAll(),
            'question_form' => $this->createForm(QuestionType::class, $question)->createView(),
            'reponse_form'  => $this->createForm(ReponseType::class)->createView(),
        ]);
    }
}
