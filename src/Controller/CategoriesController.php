<?php

namespace App\Controller;

use App\Form\CategorieType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('categories/index.html.twig', [
            'categories'    => $categoriesRepository->findAll(),
            'form'          => $this->createForm(CategorieType::class)->createView(),
        ]);
    }
}
