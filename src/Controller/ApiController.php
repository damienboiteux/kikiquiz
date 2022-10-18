<?php

namespace App\Controller;

use App\Entity\Classes;
use App\Entity\Questions;
use App\Entity\Categories;
use App\Entity\Questionnaires;
use App\Entity\Reponses;
use App\Form\CategorieType;
use App\Repository\ClassesRepository;
use App\Repository\QuestionsRepository;
use App\Repository\CategoriesRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\ReponsesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function categorie_add(
        Request $request,
        CategoriesRepository $categoriesRepository,
        ValidatorInterface $validator
    ): Response {

        $data = $request->request->all('categorie');
        // $data = $request->request->all()['categorie'];

        // Validation depuis les contraintes de l'entité sans utilisation du formulaire

        $categorie = new Categories();
        $categorie->setLabel($data['label']);
        $errors = $validator->validate($categorie);
        if (count($errors) > 0) {
            $msg = '';
            foreach ($errors as $error) {
                $msg .= $error->getMessage() . '<br>';
            }
            return $this->json([
                'msg'       => $msg,
                'code'      => 'danger',
                'categorie' => null,
            ], 201);
        } else {
            // $data       =   $request->request->all();
            $categorie  =   new Categories();
            $categorie->setLabel($data['label']);
            $categoriesRepository->save($categorie, true);
            return $this->json([
                'msg'       => 'La catégorie a été ajoutée',
                'code'      => 'success',
                'categorie' => $categorie,
            ], 201);
        }


        // Validation en utilisant les contraintes du formulaire

        // $form = $this->createForm(CategorieType::class);
        // $form->submit($data, true);

        // if (!$form->isValid()) {
        //     $allErrors = $this->getErrorsFromForm($form);
        //     // dd($allErrors);
        //     $msg = '';
        //     foreach ($allErrors as $fieldErrors) {
        //         foreach ($fieldErrors as $error) {
        //             $msg .= $error . "<br>";
        //         }
        //     }
        //     return $this->json([
        //         'msg'       => $msg,
        //         'code'      => 'danger',
        //         'categorie' => null,
        //     ], 201);
        // } else {
        //     $data       =   $request->request->all();
        //     $categorie  =   new Categories();
        //     $categorie->setLabel($data['categorie']['label']);
        //     $categoriesRepository->save($categorie, true);
        //     return $this->json([
        //         'msg'       => 'La catégorie a été ajoutée',
        //         'code'      => 'success',
        //         'categorie' => $categorie,
        //     ], 201);
        // }
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

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

    /**
     * Questions
     */

    #[Route('/questions', name: 'api_question_add', methods: ['POST'])]
    public function question_add(Request $request, QuestionsRepository $questionsRepository): Response
    {

        $data       =   $request->request->all();
        $question   =   new Questions();
        $question->setLabel($data['question']['label']);
        $question->setType($data['question']['type']);
        $question->setActive(isset($data['question']['active']));
        $questionsRepository->save($question, true);
        return $this->json([
            'msg'       => 'La question a été ajoutée',
            'code'      => 'success',
            'question' => $question,
        ], 201);
    }

    #[Route('/questions/{id}', name: 'api_question_delete', methods: ['DELETE'])]
    public function question_delete(int $id, QuestionsRepository $questionsRepository): Response
    {
        $question = $questionsRepository->find($id);
        $questionsRepository->remove($question, true);
        return $this->json([
            'msg'  => 'La question a été supprimée',
            'code' => 'success',
        ], 200);
    }

    /** 
     * Réponses
     */
    #[Route('/reponses', name: 'api_reponse_add', methods: ['POST'])]
    public function reponse_add(
        Request $request,
        QuestionsRepository $questionsRepository,
        ReponsesRepository $reponsesRepository,
    ): Response {

        $data       =   $request->request->all('reponse');
        $reponse = new Reponses();
        $reponse->setLabel($data['label']);
        $reponse->setSuccess(isset($data['success']));
        $question = $questionsRepository->find($request->request->get('question_id'));
        $question->addReponse($reponse);
        $reponsesRepository->save($reponse, true);
        return $this->json([
            'msg'       => 'La question a été ajoutée',
            'code'      => 'success',
            'reponse'   => $reponse,
        ], 201);
    }

    #[Route('/reponses/{id}', name: 'api_reponse_delete', methods: ['DELETE'])]
    public function reponse_delete(Reponses $reponse, ReponsesRepository $reponsesRepository): Response
    {
        $reponsesRepository->remove($reponse, true);
        return $this->json([
            'msg'  => 'La reponse a été supprimée',
            'code' => 'success',
        ], 200);
    }

    /** 
     * Questionnaires
     */
    #[Route('/questionnaires', name: 'api_questionnaire_add', methods: ['POST'])]
    public function questionnaire_add(
        Request $request,
        QuestionnairesRepository $questionnairesRepository
    ): Response {

        $data       =   $request->request->all('questionnaire');
        $questionnaire = new Questionnaires();
        $questionnaire->setCode($data['code']);
        $questionnaire->setConsigne($data['consigne']);
        $questionnairesRepository->save($questionnaire, true);
        return $this->json([
            'msg'           => 'Le questionnairen a été ajouté',
            'code'          => 'success',
            'questionnaire' => $questionnaire,
        ], 201);
    }

    #[Route('/questionnaires/{id}', name: 'api_questionnaire_delete', methods: ['DELETE'])]
    public function questionnaire_delete(
        Questionnaires $questionnaire,
        QuestionnairesRepository $questionnairesRepository
    ): Response {
        $questionnairesRepository->remove($questionnaire, true);
        return $this->json([
            'msg'  => 'Le questionnaire a été supprimé',
            'code' => 'success',
        ], 200);
    }

    #[Route('/questionnaires/{id}', name: 'api_questionnaire_add_question', methods: ['PATCH', 'PUT'])]
    public function questionnaire_add_question(
        Request $request,
        Questionnaires $questionnaire,
        QuestionnairesRepository $questionnairesRepository,
        QuestionsRepository $questionsRepository,
        ClassesRepository $classesRepository
    ): Response {
        $data = json_decode($request->getContent(), true);
        switch ($data['entite']) {
            case "question":
                $question = $questionsRepository->find($data['id']);
                if ($data['action'] === 'add') {
                    $questionnaire->addQuestion($question);
                    $msg = "Question ajoutée";
                } else {
                    $questionnaire->removeQuestion($question);
                    $msg = "Question supprimée";
                }
                break;
            case "classe":
                break;
        }

        $questionnairesRepository->save($questionnaire, true);

        return $this->json([
            'code'  => 'success',
            'msg'   => $msg,
        ], 200);
    }
}
