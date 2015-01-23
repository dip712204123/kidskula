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


class HomeController extends Controller {

    
    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getid();

        //Fetch all deatils related to the user
         
        $fetchStudent = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findBy(array('parentid' =>$userId));
        
        //*********************Fetch friend request***********************
        
        /*$category = $em->createQueryBuilder();
        $category->select('a')->from('BundleAdminBundle:KidsKulaUsers', 'a')
              
                ->where('a.parentid =:id')
                ->setParameter('id', $userId);
                $query = $category->getQuery();
                $fetchStudent = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);*/
                //echo '<pre>';
                //\Doctrine\Common\Util\Debug::dump($fetchStudent);
               

              // print_r($array);exit;
       
               $array=array();
                foreach($fetchStudent as $childarrayId)
                {
                $clubId=$childarrayId->getId();
                array_push($array, $clubId);
                }
                //Fetch all notifications of all child
                //$datecreated = new \DateTime('-1 months');
                
                $notification = $em->createQueryBuilder();
                $notification->select('a.texttoshow','a.createdDate','b.username','b.firstName','b.id as childid')
                     ->from('BundleAdminBundle:KidskulaNotification', 'a')   
                     ->leftJoin('a.toUser','b')   
                     ->where('a.toUser IN (:ids)')
                     //->where('a.createdDate > :datecreated')
                     ->setParameter('ids', $array)
                     //->setParameter('datecreated', $datecreated)
                     ->setMaxResults(100)
                     ->setFirstResult(0)
                     ->orderBy('a.id', 'DESC');
                  
                 $query = $notification->getQuery();
                
                 $Notification = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                 //echo '<pre>';
                 //\Doctrine\Common\Util\Debug::dump($Notification);
                 
                 //***************************************  
                return $this->render('BundleParentBundle:Home:home.html.twig',array('childentity' => $fetchStudent,'Notification'=>$Notification));
                   
        
        
        
    }

    public function frndrequestcheckAction(Request $request){
        
        $request = $this->getRequest();
        $childId = $request->get('childId');
        $em = $this->getDoctrine()->getManager();
        $userId = $childId;

        $category = $em->createQueryBuilder();
        $category->select('a.receiverId','a.id','a.recieverParentApproval','a.senderParentApproval','b.username','b.firstName','b.id as senderid')->from('BundleAdminBundle:KidskulaFriendRequest', 'a')
                                ->leftJoin('a.sender','b')
                                ->where('a.receiverId =:rcvid')
                                ->orwhere('a.sender =:senderid')
                                
                                ->andWhere('a.status=1')                
                                ->setParameter('rcvid', $userId)
                                ->setParameter('senderid', $userId)
                                ->orderBy('a.id', 'DESC');
                                
        $query = $category->getQuery();
                
        $fetchStudentrqst = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $totalrquest=count($fetchStudentrqst);
       // echo '<pre>';
      // \Doctrine\Common\Util\Debug::dump($fetchStudentrqst);exit;

        return $this->render('BundleParentBundle:Home:child_frnd_request.html.twig',array('fetchStudentrqst' => $fetchStudentrqst,
                                                                                'totalrquest'=>$totalrquest,'childID'=>$userId));
    }
    
   public function allowfriendAction(Request $request){
        $request = $this->getRequest();
        $Id = $request->get('id');
        $status= $request->get('status');
        $mychildis= $request->get('mychildis');
        $childId = $request->get('childId');
        $sender= $request->get('sender');
        $receiver= $request->get('receiver');
        //echo $mychildis;exit;
        $em = $this->getDoctrine()->getManager();
        $frndrequest = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('id' =>$Id));
        if($frndrequest){
          
        if($status=='agree')
        {
            if($mychildis==1){
            
            $frndrequest->setRecieverParentApproval(2); 
             //notification manager call in 'kidskula_notification' table :) @by sourav@19th dec,2015
    		$res1= $this->get('Bundle_notifyservice')->setParentPermissionFrndInvitationNotification("Your parent has given permission to make friendship with ".$sender,$childId); 
            
            }
            if($mychildis==0){
            
            $frndrequest->setSenderParentApproval(2); 
             //notification manager call in 'kidskula_notification' table :) @by sourav@19th dec,2015
    		$res1= $this->get('Bundle_notifyservice')->setParentPermissionFrndInvitationNotification("Your parent has given permission to make friendship with  ".$receiver,$childId);
            }
           
       
        }
        else
        {
           if($mychildis==1){
            
            $frndrequest->setRecieverParentApproval(0);  
            //notification manager call in 'kidskula_notification' table :) @by sourav@19th dec,2015
    		$res1= $this->get('Bundle_notifyservice')->setParentPermissionFrndInvitationNotification("Your parent has not given permission to make friendship with ".$sender,$childId); 
            }
            if($mychildis==0){
            
            $frndrequest->setSenderParentApproval(0);  
            //notification manager call in 'kidskula_notification' table :) @by sourav@19th dec,2015
    		$res1= $this->get('Bundle_notifyservice')->setParentPermissionFrndInvitationNotification("Your parent has not given permission to make friendship with  ".$receiver,$childId);
            }
        }
        //****************** MAKE FRIENDSHIP **************************
        $senderparentappr=$frndrequest->getSenderParentApproval();
        $receivererparentappr=$frndrequest->getRecieverParentApproval();
        if($senderparentappr == 2 && $receivererparentappr == 2 )
        {
            $frndrequest->setStatus(2);  
        }
        //*************************************************************
         $em->flush();
        return new JsonResponse(array('msg' => 'success', 'status' => 1));
        }
        else{
        return new JsonResponse(array('msg' => 'error', 'status' => 0));
        }
        
   }
}
