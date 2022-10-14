<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Categories;
use App\Form\CategorieType;
use App\Repository\ClassesRepository;
use App\Repository\CategoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api')]
class ApiController extends AbstractController
{

    /**
     * Classes
     */

    #[Route('/classes', name: 'api_classe_add', methods: ['POST'])]
    public function classe_add(Request $request, ClassesRepository $classesRepository): Response
    {
        $data  = $request->request->all()['classes'];
        $classe = new Classes();
        $classe->setLabel($data['name']);
        $classe->setActive(false);
        $classesRepository->add($classe, true);
        return $this->json([
            'code' => 'success',
            'msg' => 'La classe a été ajoutée',
            'classe' => $classe
        ], 201);
    }

    #[Route('/classes/{id}', name: 'api_classe_delete', methods: ['DELETE'])]
    public function classe_delete(int $id, ClassesRepository $classesRepository): Response
    {
        $classe = $classesRepository->find($id);
        $classesRepository->remove($classe, true);
        return $this->json([
            'msg'  => 'La classe a été supprimée',
            'code' => 'success',
        ], 200);
    }

    /**
     * Catégories
     */

    #[Route('/categories', name: 'api_categorie_add', methods: ['POST'])]
    public function categorie_add(Request $request, CategoriesRepository $categoriesRepository): Response
    {

        // $categorie = new Categories();
        // $form = $this->createForm(CategorieType::class, $categorie)->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $categoriesRepository->save($categorie, true);
        //     return $this->json([
        //         'msg'       => 'La catégorie a été ajoutée',
        //         'code'      => 'success',
        //         'categorie' => $categorie,
        //     ], 201);
        // } else {
        //     return $this->json([
        //         'msg'       => 'La catégorie n\a pas a été ajoutée',
        //         'code'      => 'danger',
        //         'categorie' => $categorie,
        //     ], 400);
        // }


        $data       =   $request->request->all();
        $categorie  =   new Categories();
        $categorie->setLabel($data['categorie']['label']);
        $categoriesRepository->save($categorie, true);
        return $this->json([
            'msg'       => 'La catégorie a été ajoutée',
            'code'      => 'success',
            'categorie' => $categorie,
            // 'test' => $test,
        ], 201);
    }

    // #[Route('/categories/{id}', name: 'api_categories_edit', methods: ['PUT', 'PATCH'])]
    // public function categorie_edit(): Response
    // {
    //     return $this->json('ok', 200);
    // }

    #[Route('/categories/{id}', name: 'api_categories_delete', methods: ['DELETE'])]
    public function categorie_delete(int $id, CategoriesRepository $categoriesRepository): Response
    {
        $categorie = $categoriesRepository->find($id);
        $categoriesRepository->remove($categorie, true);
        return $this->json([
            'msg'  => 'La categorie a été supprimée',
            'code' => 'success',
        ], 200);
    }
}
