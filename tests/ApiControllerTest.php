<?php

namespace App\Tests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @Route("/api", name="api")
 */
class ApiControllerTest extends WebTestCase
{
    /**
    * @Route("/prestataire", name="prestataire", methods={"GET","POST"})
    */

    public function testAjout()
    {

        $client = static::createClient();
        $crawler = $client->request('POST','/prestataire',[],[],
        ['CONTENT_TYPE'=>"application/json"],
    '{ "Nom": "Service Wari",
        "Ninea": "NDV142536",
        "Adresse": "Dakar Mermuz",
        "RaisonSocial": "Entreprise Multi  Service",
        "isActive": "1",}');
        $rep1=$client->getResponse();
       $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
    
    /**
  * @Route("/user", name="app_user", methods={"POST"})
  */

  /*  public function testajoutuser()
    {
        $client = static::createClient();
        $crawler = $client->request('POST','/user',[],[],
        ['CONTENT_TYPE'=>"application/json"],
    '{ "username": "Mouha",
        "plainPassword": "M2019",
        "NomComplet": "Mouhamed Dieng",
        "Adresse": "Dakar Rufisque",
        "Telephone": "778170414",
        "statut": "778170414",
        "NumeroIdentite": "1236547899",
        "profil": "admin",
         "Prestataire" 2
    }');
        $rep=$client->getResponse();
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
   
    
    /**
     * @Route("/caissier", name="caissier")
     */
    /*public function testajoutCaissier()
    {
        $client = static::createClient();
        $crawler = $client->request('POST','/creationCompte',[],[],
        ['CONTENT_TYPE'=>"application/json"],
    '{ "username": "Mounas",
        "plainPassword": "M2019",
        "NomComplet": "Maimouna Fall",
        "Adresse": "Thies",
        "Telephone": "213645897",
        "statut": "Actif",
        "NumeroIdentite": "1236547899",
        "Email": "gayemounana@gmail.com",
    }');
        $rep2=$client->getResponse();
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 
  */  
}
