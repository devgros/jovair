<?php 
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\entity\Alerte;

class OutillageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:outillage:check');
        $this->setDescription("Vérifie la validité des certificat pour les outillages");
        $this->setHelp("Créer une alerte si les certificats d'un outillages sont périmé ou s'il le seront dans le prochain mois. Supprime les alertes pour les certificats à jour");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$em = $this->getContainer()->get('doctrine')->getManager();
        $outillages = $em->getRepository('App:Outillage')->findAll();
        $current_date = new \DateTime();

        foreach($outillages as $outillage){
        	$alerte_bdd = $em->getRepository('App:Alerte')->findBy(array('type' => '1', 'id_entity' => $outillage->getId()));
        	$last_date_certificat = $outillage->getLastDateCertificat()->getDateValidite();
        	$last_date_certificat_at_one_month = clone $last_date_certificat;
        	$last_date_certificat_at_one_month->modify('-1 month');
	        if($last_date_certificat_at_one_month <= $current_date && $alerte_bdd == null){
	            $alerte = new Alerte();
	            $alerte->setType(1);
	            $alerte->setIdEntity($outillage->getId());
	            $alerte->setNameEntity("Outillage");
	            $alerte->setDesignation($outillage->getNom()." - Certificat périmé le ".$outillage->getLastDateCertificat()->getDateValidite()->format('d/m/Y'));
	            $em->persist($alerte);
	            $em->flush($alerte);
	        }
        }

    }
}