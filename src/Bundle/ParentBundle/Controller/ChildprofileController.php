<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\ParentBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaStudentPoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Bundle\KidskulaBundle\Form\InvitefrndType;

//use Bundle\AdminBundle\Manager\UserManager;


class ChildprofileController extends Controller {

    
    public function indexAction($username) {
        $accessor = PropertyAccess::createPropertyAccessor(); ///To acccess array values.
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getid();
        
        //Check this is the child of particular parent
        $checkChild = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findBy(array('username' =>$username));
        
        
        $parentid=$checkChild[0]->getParentid();
        if($parentid != $userId)
        {
         return $this->redirect($this->generateUrl('parent-home'));   
        }
        //checking ends here
       
        //Fetch all deatils related to the user
        $category = $em->createQueryBuilder();
        $category->select('a', 'b')->from('BundleAdminBundle:KidskulaUsersProfile', 'a')
                ->leftJoin('BundleAdminBundle:KidsKulaUsers', 'b', 'with', 'b.id=a.kidskulaUsersUser')
                ->where("b.username ='" . $username . "'");

        $query = $category->getQuery();
        $entity = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        //****************** find this friend's friends list!!******
        $friendId = $accessor->getValue($entity, '[1][id]');       
        $friendIdentity = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($friendId);       
        $myfrnds = $friendIdentity->getFriendsWithMe();
        $mytotalfriend = count($myfrnds);
        //***************************friend's section end*********
        
        //Fetch all my collections from manager(UserManager)******
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $friendIdentity,'getcollection'=>1));
        $totalcollection=count($studentCollection);     
        $totalpoint = 0;
        foreach ($studentCollection as $mycollection) {         
            $totalpoint = $totalpoint + $mycollection->getPoint();   //My total point          
        }
        //*******Collection section ends*************************
        
        //*********************LISTING ALL CLUBS********************
        $clubentity = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('studentId' =>$friendIdentity,'status'=>1));        
        $clubcount=count($clubentity);
        //************************CLUB SECTION ENDS**********************************
        
        //**************************DIPANJAN CODED HERE***************************************************
        
        //*********************get track time********************
        //$track = $em->getRepository('BundleAdminBundle:Kidskulaactivitylog')->findBy(array('userid' =>$friendId));  
        
        $em = $this->getDoctrine()->getManager();
          
        /* for club*/
        $track = $em->createQueryBuilder('a');
        $track->select('a')
        ->from('BundleAdminBundle:Kidskulaactivitylog', 'a')
        ->where('LOWER(a.pagesectionname) like :keyword')
        ->andwhere('a.userid =:userid')
        
        ->setParameter('keyword', strtolower('%club%'))
        ->setParameter('userid', $friendId);

        $query = $track->getQuery();
        $result = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($result); exit;
        $total_time = '';
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $total_time = $row['totalvisittime']+$total_time;
            }
            $club_tracker = $total_time;
        }
        else{
            $club_tracker = 0;
        }
        
        //echo $total_time;
        //exit;
        // for club end 
        
        
        /* for message*/
        $track = $em->createQueryBuilder('a');
        $track->select('a')
        ->from('BundleAdminBundle:Kidskulaactivitylog', 'a')
        ->where('LOWER(a.pagesectionname) like :keyword')
        ->andwhere('a.userid =:userid')
        
        ->setParameter('keyword', strtolower('%message%'))
        ->setParameter('userid', $friendId);

        $query = $track->getQuery();
        $result = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($result);
        $total_time = '';
        /*foreach($result as $row)
        {
            $total_time = $row['totalvisittime']+$total_time;
        }
        $message_tracker = $total_time;*/
        
        
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $total_time = $row['totalvisittime']+$total_time;
            }
            $message_tracker = $total_time;
        }
        else{
            $message_tracker = 0;
        }
        //echo $total_time;
        //exit;
        // for message end 
      
        
        /* for collection*/
        $collection = $em->createQueryBuilder('a');
        $collection->select('a')
        ->from('BundleAdminBundle:Kidskulaactivitylog', 'a')
        ->where('LOWER(a.pagesectionname) like :keyword')
        ->andwhere('a.userid =:userid')
        
        ->setParameter('keyword', strtolower('%collection%'))
        ->setParameter('userid', $friendId);

        $collectionquery = $collection->getQuery();
        $collectionresult = $collectionquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($result);
        $total_time = '';
        
        /*foreach($collectionresult as $row)
        {
            $total_time = $row['totalvisittime']+$total_time;
        }
        $collectionresult_tracker = $total_time;*/
        
        
        if(!empty($result))
        {
            foreach($collectionresult as $row)
            {
                $total_time = $row['totalvisittime']+$total_time;
            }
            $collectionresult_tracker = $total_time;
        }
        else{
            $collectionresult_tracker = 0;
        }
        
        
        //echo $total_time;
        //exit;
        // for collection end 
        
        
        //echo $track[0]->getTotalvisittime();
        
        //exit;
        //************************get track time**********************************
        //*************************DIPANAJN CODE ENDED*******************************
        
      
        
        
        
        return $this->render('BundleParentBundle:ChildActivity:index.html.twig', array(
                    'profile' => $entity[0],
                    'personal' => $entity[1],
                    'parentuserId'=>$userId,
                    'myfrnds' => $myfrnds,
                    'childId'=>$friendId,
                    'mytotalfriend' => $mytotalfriend,
                    'collectionarray'=>$studentCollection,
                    'totalcollection'=>$totalcollection,
                    'collectionpoint'=>$totalpoint,
                    'clubcount'=>$clubcount,
                    'clubentity'=>$clubentity,
                    'message_tracker'=>$message_tracker,
                    'collectiontracker'=>$collectionresult_tracker,
                    'tracker'=>$club_tracker)
                    );
        
    }

    public function showchildmessageAction(Request $request){
        
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $frnd_id = $request->get('frnd_id'); 
        $child_id = $request->get('child_id');

        $replymsg = $em->createQueryBuilder();
        $replymsg->select('a.texttoshow','a.createddate','b.username','b.profileimage')
                    ->from('BundleAdminBundle:KidskullaMessaging', 'a')
                    ->leftJoin('a.fromuser', 'b')
                    ->where(" (a.touser ='" . $frnd_id . "' AND a.fromuser ='" . $child_id . "'  ) ")
                    ->orwhere(" (a.touser ='" . $child_id . "' AND a.fromuser ='" . $frnd_id . "'  ) ")
                    ->orderBy('a.id', 'ASC');
         
        $replymessageQry = $replymsg->getQuery();
        //echo $replymessageQry->getSql(); die;

        $replymessage = $replymessageQry->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
              
        return $this->render('BundleParentBundle:ChildActivity:childmessage.html.twig', array(
                    'replymessage'=>$replymessage
                    )
                    );
        
    }
   
}
