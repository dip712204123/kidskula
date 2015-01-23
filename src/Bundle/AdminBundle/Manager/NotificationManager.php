<?php

namespace Bundle\AdminBundle\Manager;
use Doctrine\ORM\EntityRepository;

use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidskulaNotification;
use Bundle\AdminBundle\Entity\KidsKulaStudentHasCollection;
use Bundle\AdminBundle\Entity\KidsKulaStudentPoint;
use Bundle\AdminBundle\Entity\KidsKulaClubNotification;
use Bundle\AdminBundle\Entity\KidsKulaClubArticle;
use Bundle\AdminBundle\Entity\KidsKulaClub;

class NotificationManager extends EntityRepository {

    private $em, $router, $container;

    function __construct($em, $container, $router) {
        $this->em = $em;
        $this->router = $router;
        $this->container = $container;
    }

    /*
     * Save access logs
     */
    public function setClubNotification($text,$articleid) {
        //echo 'dhukeche';exit;
        // $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->em;
	    $user = $this->container->get('security.context')->getToken()->getUser();
	    $clubentity = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->findOneBy(array('id' => $articleid));
        $getFirstName=$user->getFirstName();
        $getLastName=$user->getLastName();
        $fullName=$getFirstName.' '.$getLastName;
       
            $text=$fullName.' '.$text.' '.''.' "'.$clubentity->getTitle().'" on '.' '.date("Y-m-d");
        
		$ClubNotif = new KidsKulaClubNotification();
		$ClubNotif->setToUser($user);
		$ClubNotif->setClubId($clubentity->getClubId());
        $ClubNotif->setArticleId($clubentity);
		$ClubNotif->setCreatedDate(new \DateTime());
		$ClubNotif->setTexttoshow($text);    

		$em->persist($ClubNotif);    
		$em->flush();
        
    }


    public function setNotification($text) {

        // $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->em;
	    $user = $this->container->get('security.context')->getToken()->getUser();
	   
		$CollectionNotif = new KidskulaNotification();
		$CollectionNotif->setToUser($user);
		
		$CollectionNotif->setCreatedDate(new \DateTime());
		$CollectionNotif->setTexttoshow($text);    

		$em->persist($CollectionNotif);    
		$em->flush();
        
    }
   
	public function setPointsToUser($id,$Invitekey=null) {

        
        $em = $this->em;
	    $user = $this->container->get('security.context')->getToken()->getUser();
		
	    $reward = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->findOneBy(array('id' => $id));
		$pointsactivity = $reward->getPointsactivity();
		$pointsactivity = unserialize($pointsactivity);
		$point = $pointsactivity['point'];
		$parameter = $pointsactivity['parameter'];

		//Insert into table 'kidskula_student_has_collection' //Done by sourav@16_12_2014

		$studentCollection = new KidsKulaStudentHasCollection();
		$studentCollection->setStudentId($user);
		$studentCollection->setStatus(1);
		$studentCollection->setGetcollection(0);
		$studentCollection->setPoint($point);
		$studentCollection->setInvitekey($Invitekey);

		$em->persist($studentCollection);
		$em->flush();
		
		//update table 'kidskula_student_point' //Done by sourav@18_12_2014
		$pointAdd = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $user ));
		

                    if (!$pointAdd) {
                        $pointAdds = new KidsKulaStudentPoint();
                        $pointAdds->setStudentId($user);
                        $pointAdds->setPoint($point);
                        $pointAdds->setTotalcollection(0);
                        $em->persist($pointAdds);
                        $em->flush();
                    }
					else{
						$prePoint = $pointAdd->getPoint();
						$totalPoint = $prePoint + $point;
						$pointAdd->setPoint($totalPoint);
						$pointAdd->setLastaddedDate(new \DateTime());

						//$em->persist($pointAdd);
						$em->flush();
					}
		
		
        return  array('points'=>$point,'id'=>$studentCollection->getId());
		
    }
    
	public function findOneRandom($subid,$catid) {
        
		$em = $this->em;
        $Alcol = $em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->findBy(array('subcatID' => $subid, 'categoryId' => $catid));
        $colarr = array();
        foreach ($Alcol as $collections) {
            array_push($colarr, $collections->getId());
        }
        $k = array_rand($colarr);
        return $v = $colarr[$k];
    }
	

    public function setCollectionToUser($id,$subid,$catid) {
		
		$em = $this->em;
		$user = $this->container->get('security.context')->getToken()->getUser();
		
		//Fetch random value from collection table where subcatID=2************
		$randomRet = $this->findOneRandom($subid,$catid);

		//**************Random collection fetching ends************************	

		$collectionobject = $em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->findOneBy(array('id' => $randomRet));
		
		//update table 'kidskula_student_has_collection'
       
		$studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->find($id);
		$studentCollection->setGetcollection(1);
		$studentCollection->setCollectionId($collectionobject);
		$studentCollection->setCollectionPoint($collectionobject->getPoint());
		//echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($studentCollection);exit;
		$em->flush();

		//update table 'kidskula_student_point' for collection no add //Done by sourav@18_12_2014
		$collectionAdd = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $user));
		$preTotalcollection = $collectionAdd->getTotalcollection();
		$Totalcollection = $preTotalcollection + 1;
		$collectionAdd->setTotalcollection($Totalcollection);
		$collectionAdd->setLastaddedDate(new \DateTime());

		$em->persist($collectionAdd);
		$em->flush();
		
    }
    public function setParentPermissionFrndInvitationNotification($text,$childId) {

        // $user_id = $this->container->get('security.context')->getToken()->getUser()->getId();
        $em = $this->em;
	    $user = $this->container->get('security.context')->getToken()->getUser();
	    $userentity = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('id' => $childId));
        
		$CollectionNotif = new KidskulaNotification();
		$CollectionNotif->setToUser($userentity);
        $CollectionNotif->setFromUser($user);
		
		$CollectionNotif->setCreatedDate(new \DateTime());
		$CollectionNotif->setTexttoshow($text);    

		$em->persist($CollectionNotif);    
		$em->flush();
        
    }
   
}
