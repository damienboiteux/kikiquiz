<?php

namespace App\Controller;

use App\Form\ClassesType;
use App\Repository\ClassesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassesController extends AbstractController
{
    #[Route('/classes', name: 'app_classes', methods: ['GET'])]
    public function index(ClassesRepository $classesRepository): Response
    {
        return $this->render('classes/index.html.twig', [
            'classes' => $classesRepository->findAll(),
            'form' => $this->createForm(ClassesType::class)->createView(),
            'action' => 'classes',
        ]);
    }
}
