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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $users = $em->getRepository('AuthBundle:User')->findAll();


        foreach ($users as $user){
            $activateAt = $user->getActiveAt();
            $activeUntil = $user->getActiveUntil();
            $now = new \DateTime();
            if (!$activateAt == null && !$user->isEnabled() && $activateAt < $now ){
                $controller = new UserController();
                $controller->sendrequestAction($user);
            }
        }
    }


}