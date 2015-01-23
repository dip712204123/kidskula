<?php

namespace Bundle\AdminBundle\Manager;
use Doctrine\ORM\EntityRepository;

use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Bundle\AdminBundle\Entity\KidskulaModules;

class UserManager extends EntityRepository {

    private $em, $router, $container;

    function __construct($em, $container, $router) {
        $this->em = $em;
        $this->router = $router;
        $this->container = $container;
    }

    /*
     * Save access logs
     */



     public function getCurrentFriendRequests($count = 0) {

       // $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->em->getDoctrine()->getManager();
	    $user = $this->em->getUser();
	    $user_id=$user->getId();
        $datefrom = new \DateTime('-6 months');
        $user = $this->em->createQueryBuilder('a');
        $requests = $user->select('request,connection as fromuser')
                        ->from('BundleAdminBundle:KidskulaFriendRequest', 'request')
                        ->leftJoin('request.sender', 'connection')
                        ->where('request.status=1 and request.receiverId=:connectionId and request.sendDate>:datefrom')
                        ->setParameter('connectionId', $user_id)
                        ->setParameter('datefrom', $datefrom)
                        ->groupby('request.id')
                        ->orderBy('request.sendDate', 'DESC')
                        ->getQuery()->getResult();

        if (!empty($count)) {
            return count($requests);
        }

        return $requests;
    }
    
    
   public function getParentfrndApproval() {
   
        $em = $this->em;
	   
	    $modulesStatus = $em->getRepository('BundleAdminBundle:KidskulaModules')->findOneBy(array('id' => 4,'modulesStatus'=>1));
        if(!$modulesStatus)
        {
          return '0';  
        }
        else
        {
          return '1';
        }
        
    }
}
