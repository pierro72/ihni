<?php
/**
 * Created by PhpStorm.
 * User: dmetthey.stage
 * Date: 19/06/2017
 * Time: 14:12
 */

namespace AuthBundle\Command;


use AuthBundle\Controller\UserController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckUserDateValidityCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            //Name of the command
            ->setName('app:account:check-validity')
            //description
            ->setDescription('Vérifie les dates de validités des comptes utilisateurs')
            ;



    }

    /**
     *A lancer par le serveur en tâche Cron à 1h00 chaque jour
     * Vérifie la validité des comptes et les active ou désactive le cas échéant
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $users = $em->getRepository('AuthBundle:User')->findAll();


        $output->writeln([
            '======================================',

        ]);
        foreach ($users as $user){
            $activateAt = $user->getActiveAt();
            $activeUntil = $user->getActiveUntil();
            $now = new \DateTime();
            //active les comptes qui ont dépassé leur date d'activation
            if (!$activateAt == null && !$user->isEnabled() && $activateAt < $now && $user->getConfirmationStatus() == "waiting" ){

                $this->getContainer()->get('app.sendinvitation')->sendInvitation($user);
                $output->writeln('activation de '.$user);
            }
            //désactive les comptes qui ont dépassé leur date de désactivation
            if (!$activeUntil == null && $user->isEnabled() && $activeUntil < $now){
                $user->setEnabled(false);
                $em->flush();
                $output->writeln('désativation de '.$user);
            }

        }
        $output->writeln([

            '======================================',
        ]);
    }


}