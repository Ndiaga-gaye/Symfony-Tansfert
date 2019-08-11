<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CaissierType;
use App\Entity\Prestataire;
use App\Entity\Caissier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/api", name="api")
 */
class CaissierController extends AbstractController
{
    /**
     * @Route("/caissier", name="caissier")
     */
    public function ajoutCaissier(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $caissier = new Caissier();
        $form1 = $this->createForm(CaissierType::class, $caissier);
        $form1->handleRequest($request);
        $data=$request->request->all();
        $file=$request->files->all()['imageFile'];
        $form1->submit($data);
        $caissier->setPassword($passwordEncoder->encodePassword($caissier, $form1->get('plainPassword')->getData()));
        $caissier->setImageFile($file);
        $repository = $this->getDoctrine()->getRepository(Prestataire::class);
        $caissier->setStatut("actif");
        $caissier->setRoles(['ROLE_CAISSIER_SYSTEME']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($caissier);
        $entityManager->flush();
  
            $data = [
                'status' => 201,
                'message' => 'Le Caissier est  bien ajoute'
            ];
            return new JsonResponse($data, 201); 
        //}
  
        $data = [
            'status' => 500,
            'message' => 'Vous devez renseigner les champs'
        ];
        return new JsonResponse($data, 500);
    }
}
