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
'msg' => $msg,
'code' => 'danger',
'categorie' => null,
], 201);
} else {
// $data = $request->request->all();
$categorie = new Categories();
$categorie->setLabel($data['label']);
$categoriesRepository->save($categorie, true);
return $this->json([
'msg' => 'La catégorie a été ajoutée',
'code' => 'success',
'categorie' => $categorie,
], 201);
}


// Validation en utilisant les contraintes du formulaire

// $form = $this->createForm(CategorieType::class);
// $form->submit($data, true);

// if (!$form->isValid()) {
// $allErrors = $this->getErrorsFromForm($form);
// // dd($allErrors);
// $msg = '';
// foreach ($allErrors as $fieldErrors) {
// foreach ($fieldErrors as $error) {
// $msg .= $error . "<br>";
// }
// }
// return $this->json([
// 'msg' => $msg,
// 'code' => 'danger',
// 'categorie' => null,
// ], 201);
// } else {
// $data = $request->request->all();
// $categorie = new Categories();
// $categorie->setLabel($data['categorie']['label']);
// $categoriesRepository->save($categorie, true);
// return $this->json([
// 'msg' => 'La catégorie a été ajoutée',
// 'code' => 'success',
// 'categorie' => $categorie,
// ], 201);
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