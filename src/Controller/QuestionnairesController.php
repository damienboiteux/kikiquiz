<?php

namespace App\Controller;

use App\Form\QuestionnaireType;
use App\Repository\QuestionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
