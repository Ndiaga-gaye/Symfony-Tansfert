<?php
namespace App\Controller;
use App\Entity\User;

use App\Entity\Caissier;
use App\Entity\Depot;
use App\Form\UserType;
use App\Form\DepotType;
use  App\Form\CaissierType;
use App\Entity\Prestataire;
//use App\Controller\Caissier;
use App\Form\PrestatireType;
use App\Entity\CreationCompte;
use App\Form\CreationCompteType;
use App\Controller\SecurityController;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CreationCompteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api", name="api")
 */
class ApiController extends AbstractController

{
        /**
        * @Route("/prestataire", name="prestataire", methods={"GET","POST"})
        */

    public function Ajout(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager )
    {
        $prestataire = new Prestataire();
        $form1 = $this->createForm(PrestatireType::class, $prestataire);
        $form1->handleRequest($request);
        $date=$request->request->all(); 
        $form1->submit($date);
        $entityManager->persist($prestataire);
        $entityManager->flush();

       $data = [
        'status' => 201,
        'message' => 'Le Prestataire est bien ajoute'
    ];
    return new JsonResponse($data, 201); 


$data = [
    'status' => 500,
    'message' => 'Vous devez renseigner les champs'
];
return new JsonResponse($data, 500);
}
  /**
  * @Route("/useradmin", name="app_register")
  */
    public function ajoutuser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
       
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $data=$request->request->all();
        $file=$request->files->all()['imageFile'];
        $form->submit($data);
        
       
            $user->setPassword(
            $passwordEncoder->encodePassword($user,$form->get('plainPassword')->getData()));
            $user->setImageFile($file);
           $repository = $this->getDoctrine()->getRepository(Prestataire::class);
        
            $user->setStatut("actif");
            $profil= $data["profil"];
            $user->setProfil($profil);
            $roles=[];
            if($profil=="admin"){
                $user->setRoles(['ROLE_ADMINWari']);
            }
            elseif ($profil=="user") {
                $user->setRoles(['ROLE_USER']);
            }
            elseif ($profil=="caissier") {
                $user->setRoles(['ROLE_CAISSIER_DU_PRESTATAIRE']);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 201,
                'message' => 'Le user est  bien ajouté'
            ];
            return new JsonResponse($data, 201); 
        //}

        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les champs'
        ];
        return new JsonResponse($data, 500);
    }


  /**
  * @Route("/creationCompte", name="app_register")
  */

  public function CrerCompte(Request $request, UserPasswordEncoderInterface $passwordEncoder)
  {
     $random = random_int(10000000, 99999999);
     $creationCompte = new CreationCompte();
     $form = $this->createForm(CreationCompteType::class, $creationCompte);
     $form->handleRequest($request); 
     $daw=$request->request->all();
     $repository = $this->getDoctrine()->getRepository(Prestataire::class);
     $parte= $repository->findAll();
     $creationCompte->setNumeroCompte($random);
     $entityManager = $this->getDoctrine()->getManager();
     $form->submit($daw);
     $entityManager->persist($creationCompte);
     $entityManager->flush();
      $data = [
        'status' => 201,
        'message' => 'Le compte est bien créer'
    ];
    return new JsonResponse($data, 201); 


$data = [
    'status' => 500,
    'message' => 'Vous devez renseigner les champs'
];
return new JsonResponse($data, 500);


 }
 /**
  * @Route("/Depot", name="app_register")
  */

  public function dodepot(Request $request, UserPasswordEncoderInterface $passwordEncoder)
  {  
     $depot= new Depot();
     $form = $this->createForm(DepotType::class, $depot);
     $form->handleRequest($request); 
     $data=$request->request->all(); 
     $repository = $this->getDoctrine()->getRepository(CreationCompte::class);
    $parte= $repository->findAll(); 
     $repository = $this->getDoctrine()->getRepository(Caissier::class);
     $parte= $repository->findAll();
     $entityManager = $this->getDoctrine()->getManager();
     $form->submit($data);
     $entityManager->persist($depot);
     $entityManager->flush();
      $data = [
        'status' => 201,
        'message' => 'Le Depot est bien realiser'
    ];
    return new JsonResponse($data, 201); 


$data = [
    'status' => 500,
    'message' => 'Vous devez renseigner les champs'
];
return new JsonResponse($data, 500);

}

}
