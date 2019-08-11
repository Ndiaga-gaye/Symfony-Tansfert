<?php
namespace App\DataFixtures;
use App\Entity\Utilisateur;

//use Symfony\Component\HttpFoundation\Request;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $utilisateur = new Utilisateur();
        $password = $this->encoder->encodePassword($utilisateur,'admin');
        $utilisateur->setpassword($password);
            $utilisateur->setUsername('Cheikh');
            $utilisateur->setRoles(["ROLE_ADMIN_SYSTEME"]);
            $utilisateur->setAdresse('Dakar');
            $utilisateur->setNomComplet('cheikh Bamba Fall');
            $utilisateur->setNumeroIdentite(1254783692);
            $utilisateur->setTelephone(771817731);
            $utilisateur->setProfil('Admin');
            $utilisateur->setStatut('Actif');
            $manager->persist($utilisateur);   
         
    
        $manager->flush();
    }
}
