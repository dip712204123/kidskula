<?php

//Created By Sourav Bhowmik @22/12/2014

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaClub;
use Bundle\AdminBundle\Entity\KidsKulaClubMember;
use Bundle\AdminBundle\Entity\KidskulaNotification;
use Bundle\AdminBundle\Entity\KidsKulaClubNotification;
use Bundle\AdminBundle\Entity\KidsKulaStudentPoint;
use Bundle\AdminBundle\Entity\KidsKulaClubArticle;
use Bundle\AdminBundle\Entity\KidsKulaClubComment;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Bundle\KidskulaBundle\Form\ClubArticleType;
use Bundle\KidskulaBundle\Form\InvitefrndType;
use Bundle\AdminBundle\Manager\NotificationManager;
use Bundle\AdminBundle\Entity\KidsKulaCollectionTradeHistory;

class ClubController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        //Fetch all Clubs
        $allclubs = $em->getRepository('BundleAdminBundle:KidsKulaClub')->findBy(array('status' => 1));
        $firstdate=date('Y-m-d',strtotime('last monday')).' 00:00:00';
        $today=date('Y-m-d h:i:s');
        //echo 'firstdate='.$firstdate.'<br>';
        //echo 'today='.$today;exit;
        $newclubs = $em->createQueryBuilder();
        $newclubs->select('a')->from('BundleAdminBundle:KidsKulaClub', 'a')
               ->where('a.status =1')        
               ->andwhere('a.createDate BETWEEN :fistdate AND :today')
                 ->setParameter('fistdate', $firstdate)
                 ->setParameter('today', $today);
             $myquery = $newclubs->getQuery();
             
             $newclubsarray = $myquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
       
        
        $membership = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('studentId' => $this->getUser()));
        
        $array=array();
        foreach($membership as $memberarray)
        {
            $clubId=$memberarray->getClubId()->getId();
            array_push($array, $clubId);
        }
        
        //*************** Fetch all related notification(Only my joined club notification)*************************
        //$notifiEntity = $em->getRepository('BundleAdminBundle:KidsKulaClubNotification')->findBy(array('clubId' => $membership->getClubId()));
        $category = $em->createQueryBuilder();
             $category->select('a')->from('BundleAdminBundle:KidsKulaClubNotification', 'a')
              
                 ->where('a.clubId IN (:ids)')
                 ->andwhere('a.toUser != :usrid')
                 ->setParameter('ids', $array)
                 ->setParameter('usrid', $this->getUser()->getId())
                 ->orderBy('a.id', 'DESC');
                  
                 $query = $category->getQuery();
                
                 $clubNotification = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                
       //***************notification fetching end*************************
        
        return $this->render('BundleKidskulaBundle:Club:clubs.html.twig', array('entity' => $allclubs,
                                                                                'membership'=>$array,
                                                                                'myclubentity'=>$membership,
                                                                                'clubNotification'=>$clubNotification,
                                                                                'newclubsarray'=>$newclubsarray));
        
    }
    
    public function clublistAction() {

        $em = $this->getDoctrine()->getManager();
        //Fetch all Clubs
        $allclubs = $em->getRepository('BundleAdminBundle:KidsKulaClub')->findBy(array('status' => 1));
        
        $membership = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('studentId' => $this->getUser(),'status'=>'1'));
        $array=array();
        foreach($membership as $memberarray)
        {
            $clubId=$memberarray->getClubId()->getId();
            array_push($array, $clubId);
        }
       
        //print_r($array);exit;
       // \Doctrine\Common\Util\Debug::dump($membership);exit;
        return $this->render('BundleKidskulaBundle:Club:club.html.twig', array('entity' => $allclubs,'membership'=>$array,'myclubentity'=>$membership));
        
    }

    public function clubdetailsAction($id) {
       
        $em = $this->getDoctrine()->getManager();
        //Fetch Club
        $articleowner=$this->getUser()->getId();
        $form = $this->createForm(new ClubArticleType($em));
        $allclubDetails = $em->getRepository('BundleAdminBundle:KidsKulaClub')->findOneBy(array('status' => 1,'id'=>$id));
		//$clubArticles = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->findBy(array('status' => 1,'clubId'=>$id));
        //fetch recent article within this week***********************************
        
        $recentArticle = $em->createQueryBuilder();
        $recentArticle->select('a')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
              
                ->where('a.status =1')
                ->andwhere('a.clubId= :clubid')
                
                 ->setParameter('clubid', $id)
                 ->setMaxResults(10)
                 ->setFirstResult(0)
                 ->orderBy("a.id", 'DESC');
                  
                 $myquery = $recentArticle->getQuery();
                
        
                
         $clubArticles = $myquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        // echo '<pre>';
        // \Doctrine\Common\Util\Debug::dump($clubArticles); die;
        //********************************fetch end*********************
        $membership = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId'=>$id,'status'=>'1'));
	    $countfollower=count($membership);
        
         //*****************************************************Fetch in which club I joined***************
        $findmymembership = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId'=>$id,'status'=>'1','studentId'=>$this->getUser())); 
        
        return $this->render('BundleKidskulaBundle:Club:club_details.html.twig',array('allclubDetails'=>$allclubDetails,
                                                                                     'form'=>$form->createView(),
                                                                                     'clubArticles'=>$clubArticles,
                                                                                     'articleowner'=>$articleowner,
                                                                                     'clubid'=>$id,
                                                                                     'findmymembership'=>$findmymembership,
                                                                                     'countfollower'=>$countfollower));
    }

    public function myclub_membershipAction(Request $request) {
        
        $request = $this->getRequest();
        $clubid = $request->get('clubid');
        $variable = $request->get('variable');
        
        $em = $this->getDoctrine()->getManager();
        $clubentity = $em->getRepository('BundleAdminBundle:KidsKulaClub')->find($clubid);
        
        if($variable == 'join'){
             $clubentityduplicate = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId' =>                                            $clubid, 'studentId' => $this->getUser()->getId()));
        if(!$clubentityduplicate)
        {
            $entities = new KidsKulaClubMember();
            $entities->setStudentId($this->getUser());
            $entities->setClubId($clubentity);
            $em->persist($entities);
            $em->flush();
            
            //Point add to 'kidskula_student_has_collection' table by manager @by sourav@29th dec,2014
    		$res= $this->get('Bundle_notifyservice')->setPointsToUser(8);
    		
    		//notification manager call for insert point update in 'kidskula_notification' table :) @by sourav@29th dec,2014
    		$res1= $this->get('Bundle_notifyservice')->setNotification("You got ".$res['points']." points for joining ".$clubentity->getTitle());
    		
    		//Collection update to 'kidskula_student_has_collection' table by manager @by sourav@29th dec,2014
            $res= $this->get('Bundle_notifyservice')->setCollectionToUser($res['id'],8,7);
            
            //notification manager call for insert point update in 'kidskula_notification' table :) @by sourav@29th dec,2014
    		$res1= $this->get('Bundle_notifyservice')->setNotification("You got one collection for joining ".$clubentity->getTitle());
        } 
        else{
           
         $clubentityduplicate = $clubentityduplicate[0];
         $clubentityduplicate->setStatus('1');
         $em->flush();
        }
    		//notification manager call for insert in 'kidskula_notification' table :)@by sourav@29th dec,2014
    		$res= $this->get('Bundle_notifyservice')->setNotification("Thank you for joining ".$clubentity->getTitle());
   		
    		return new JsonResponse(array('msg' => 'Thank you for joining', 'status' => 1));
      }else{
         
         $clubmember = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId' => $clubid, 'studentId' => $this->getUser()->getId()));
         $clubmember = $clubmember[0];
         $clubmember->setStatus('0');
         $em->flush();
         
         return new JsonResponse(array('msg' => 'We will miss you..', 'status' => 1));
      }
    }
    
    private function createCreateForm(KidsKulaClubArticle $entity) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new ClubArticleType($em), $entity, array(
            'action' => $this->generateUrl('myarticle-add'),
            'method' => 'POST',
        ));

        return $form;
    }
    
    public function createarticleAction(Request $request) {
        $entity = new KidsKulaClubArticle();
        $form = $this->createCreateForm($entity);
        
        $clubid = $request->get('clubid');
       
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $clubentity = $em->getRepository('BundleAdminBundle:KidsKulaClub')->find($clubid);
            $entity->setClubId($clubentity);
			$entity->setOwnerId($this->getUser()); 
            $entity->setModifiedDate(new \DateTime());
            $entity->setCreateDate(new \DateTime());
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'New job category added to the list');
            return $this->redirect($this->generateUrl('myclub'));
        }

        $form = $this->createForm(new ClubArticleType($em));
        $allclubDetails = $em->getRepository('BundleAdminBundle:KidsKulaClub')->findOneBy(array('status' => 1,'id'=>$id));
        return $this->render('BundleKidskulaBundle:Club:club_details.html.twig',array('allclubDetails'=>$allclubDetails,'form'=>$form->createView()));
    }
    
    public function articlelistingAction($id,$status,$articleid=0) {
        // echo $status;exit;
        $em = $this->getDoctrine()->getManager();
        //Fetch Club
        $articleowner=$this->getUser()->getId();
        $form = $this->createForm(new ClubArticleType($em));
        $allclubDetails = $em->getRepository('BundleAdminBundle:KidsKulaClub')->findOneBy(array('status' => 1,'id'=>$id));
        //*********************FOR 'myfriend-articles' ********************
        if($status=='myfriend-articles')
        {
         $myfrnds = $this->getUser()->getFriendsWithMe();
         $array=array();
         foreach($myfrnds as $myfrndsId)
         {
            array_push($array,$myfrndsId->getId());
         }
        
       	
             $category = $em->createQueryBuilder();
             $category->select('a.title','a.path','a.createDate','a.description','a.liked','a.id','b.firstName','b.lastName')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
                ->leftJoin('a.ownerId','b')
                ->where('a.status =' . '1')
                ->andwhere('a.clubId= :clubid')
                ->andwhere('a.ownerId IN (:ids)')
                 ->setParameter('clubid', $id)
                 ->setParameter('ids', $array);
                  
                 $query = $category->getQuery();
                
                 $clubArticles = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                 //echo '<pre>';
                 //\Doctrine\Common\Util\Debug::dump($clubArticles); exit;
                 $title="My friend's Articles";
        }
        
        //*********************FOR 'my-articles' ********************
	    if($status=='my-articles')
        {
         $myid = $this->getUser()->getId();
         //echo $myid;
         
             $mycategory = $em->createQueryBuilder();
             //$mycategory->select('a')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
              $mycategory->select('a.title','a.path','a.createDate','a.description','a.liked','a.id','b.firstName','b.lastName')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
                ->leftJoin('a.ownerId','b')
                ->where('a.status =1')
                ->andwhere('a.clubId= :clubid')
                ->andwhere('a.ownerId = :myid')
                 ->setParameter('clubid', $id)
                 ->setParameter('myid', $myid);
                  
                 $myquery = $mycategory->getQuery();
                
                 $clubArticles = $myquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                 $title='My Articles';
                
        }
       //*********************FOR 'my-articles' ********************
	    if($status=='recent-articles')
        {
         $myid = $this->getUser()->getId();
         
         
             $mycategory = $em->createQueryBuilder();
             //$mycategory->select('a')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
              $mycategory->select('a.title','a.path','a.createDate','a.description','a.liked','a.id','b.firstName','b.lastName')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
                ->leftJoin('a.ownerId','b')
                ->where('a.status =1')
                ->andwhere('a.clubId= :clubid')
                ->andwhere('a.id= :articleid')
                 ->setParameter('clubid', $id)
                 ->setParameter('articleid', $articleid);
                 
                  
                 $myquery = $mycategory->getQuery();
                
                 $clubArticles = $myquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                 $title='Recent Article';
                
        }
        //*********************FOR 'most-commented-articles' ********************
	    if($status=='most-commented-articles')
        {
                $myid = $this->getUser()->getId();
         
                 $category = $em->createQueryBuilder();
                
                 $category->select('IDENTITY(a.eventid) as eventid,COUNT(a.id) as contNum')  
                            ->from('BundleAdminBundle:KidsKulaClubComment', 'a')
                            ->where('a.status =1')
                            ->andwhere('a.clubId= :clubid')
                            ->setParameter('clubid', $id)
                            ->groupBy('a.eventid')
                            ->orderBy('contNum', 'DESC')
                            ->setMaxResults(10);
                            
                 $myquery1 = $category->getQuery();
                 $Articles = $myquery1->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

                 $array = array();
                 foreach($Articles as $articl)
                 {
                    array_push($array,$articl['eventid']);
                 }
                 
                 $mycategory = $em->createQueryBuilder();
                // $mycategory->select('a')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
                 $mycategory->select('a.title','a.path','a.createDate','a.description','a.liked','a.id','b.firstName','b.lastName')->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
                            ->leftJoin('a.ownerId','b')
                            ->where('a.status =1')
                            ->where('a.clubId = :ids')
                            ->andwhere('a.id IN (:articleid)')
                            ->setParameter('ids', $id)
                            ->setParameter('articleid', $array);
                  
                 $myquery = $mycategory->getQuery();        
                 $clubArticles = $myquery->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                
                 $title='Most Commented Articles';
                
        }
	    return $this->render('BundleKidskulaBundle:Club:article.html.twig',array('allclubDetails'=>$allclubDetails,'form'=>$form->createView(),'clubArticles'=>$clubArticles,'articleowner'=>$articleowner,'title'=>$title,'clubid'=>$id));
      
    }
    
    
    //***************Article comment controller starts here*******************************************************
    
    
    public function getdiscussionAction(Request $request, $eventId=0, $parentId=0) {
        
        
        $em = $this->getDoctrine()->getManager();
        $qdb = $em->createQueryBuilder();
        $evententity = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->find($eventId);
        $comment = $request->get('comment');
        $comment_id = $request->get('comment_id');
        $clubid = $request->get('clubid');
        //echo $clubid;
        $edit = $request->get('edit');
        $remove = $request->get('remove');
        $parentId = $parentId;
	    $parent_entity = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->find($parentId);
        
        
        if ($request->getMethod() == 'POST' && !empty($comment)) {
		
			
            $KidsKulaClubComment = new KidsKulaClubComment();

            $parentId = $request->get('parent_reply');
            //If it is a reply set parent
            if (!empty($parentId)) {

                $parent_reply_entity = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->find($parentId);
                
                $evententity = $parent_reply_entity->getEventid();
            } elseif (!empty($edit)) {
                //if edit comment
                $KidsKulaClubComment = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->find($edit);
                $evententity = $KidsKulaClubComment->getEventid();
            }
	     	
				
            $KidsKulaClubComment->setComment($comment);
            

            if (empty($edit) && empty($remove)) {
				$eventId = $request->get('articleId');
				$evententity = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->find($eventId);
				$clubEntity = $em->getRepository('BundleAdminBundle:KidsKulaClub')->find($clubid);
                $user = $this->getUser();
                $KidsKulaClubComment->setUserid($user);
                $KidsKulaClubComment->setClubId($clubEntity);
                $KidsKulaClubComment->setEventid($evententity);
                if(isset($parent_reply_entity)){
				    $KidsKulaClubComment->setParentid($parent_reply_entity);
                }
                $em->persist($KidsKulaClubComment);
                
            }
            //\Doctrine\Common\Util\Debug::dump($KidsKulaClubComment); die;
            $em->flush();
            //notification manager call for insert in 'kidskula_club_notification' table :)@by sourav@5th jan,2015
            $res= $this->get('Bundle_notifyservice')->setClubNotification("posted a comment in",$eventId);
            
        } elseif ($request->getMethod() == 'POST' && !empty($comment_id)) {
            //Mark this answer as correct
            $comment_id = $request->get('comment_id');
            $status = $request->get('status');
            $commentntity = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->find($comment_id);
            $commentntity->setIscorrect($status);
            $em->flush();

            //Set this question as commentd
            $checkcorrct = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->findBy(array('id' => $comment_id, 'iscorrect' => 1));
            $evententity = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->find($eventId);
            if (count($checkcorrct) > 0) {

                $evententity->setAnwered(1);
            } else {
                $evententity->setAnwered(0);
            }
            $em->flush();
            //notification manager call for insert in 'kidskula_club_notification' table :)@by sourav@5th jan,2015
            $res= $this->get('Bundle_notifyservice')->setClubNotification("posted a comment in",$commentntity->getEventid());
        }elseif (!empty($remove)) {
            $KidsKulaClubComment = $em->getRepository('BundleAdminBundle:KidsKulaClubComment')->find($remove);
            $em->remove($KidsKulaClubComment);
            $em->flush();
        }
        
        $data['reply'] = 0;
        
        $qdb->select('a','u')
                ->from('BundleAdminBundle:KidsKulaClubComment', 'a')
                ->leftJoin('a.userid', 'u')
                ->groupby('a.id')
                ->orderby('a.id', 'DESC');
                
        if (!empty($eventId)) {
            $qdb->where('a.eventid=:eventId and a.parentId is NULL')
                    ->setParameter('eventId', $eventId);
        } elseif (!empty($parentId)) {
            $qdb->where('a.parentId=:parentId')
                    ->setParameter('parentId', $parent_entity);
            $data['reply'] = 1;
        }
        
        $query = $qdb->getQuery();
        
        $details = $query->getResult();
		//echo "<pre>";
		//\Doctrine\Common\Util\Debug::dump($details); die;
        $data['eventId'] = $eventId;
		$data['comments'] = $details;
        $data['evententity'] = $evententity;
        //return $this->render('VetPublicBundle:events:discussion.html.twig', $data);
        return $this->render('BundleKidskulaBundle:Club:comment.html.twig', $data);
    }
	    
  //***************Article comment controller ends here*******************************************************
  
  public function viewnotificationAction(Request $request) {

        $request = $this->getRequest();
        $notifId = $request->get('notifId');

        $userId = $this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $viewnotifExist = $em->getRepository('BundleAdminBundle:KidsKulaClubNotification')->findOneBy(array('id' => $notifId));
        $RecieverStatus=$viewnotifExist->getRecieverStatus();
        
        if(!$RecieverStatus)
        {
          $newarray=array($userId);  
        }
        else{
           $array=unserialize($RecieverStatus);
           $array[] = $userId; //insert the value to the last element of an array
           $newarray = $array;
        }
        //print_r($newarray);exit;
        $serialize=serialize($newarray);
        $viewnotifExist->setRecieverStatus($serialize);
                       
        $em->flush();
        return new JsonResponse(array('msg' => 'success', 'status' => 1));
        
    }
    
    //***************Article like controller starts here*******************************************************
  
  public function articlelikeAction(Request $request) {

        $request = $this->getRequest();
        $artId = $request->get('articleid');
        $status= $request->get('status');
        
        $userId = $this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        //$insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $viewnotifExist = $em->getRepository('BundleAdminBundle:KidsKulaClubArticle')->findOneBy(array('id' => $artId));
        
        $RecieverStatus=$viewnotifExist->getLiked();
        if($status=='like')
        {
            if(!$RecieverStatus)
        {
          $newarray=array($userId);  
        }
        else{
           $array=unserialize($RecieverStatus);
           $array[] = $userId; //insert the value to the last element of an array
           $newarray = $array;
        }
        //print_r($newarray);exit;
        $serialize=serialize($newarray);
        $viewnotifExist->setLiked($serialize);
        $em->flush();
        $var='<a role="button" class="btn btn-success" href="javascript:void(0)" onclick="articlelikefunc('.$artId.',\'dislike\')">
                <span id="artlike'.$artId.'"><i title="Dislike" style="font-size:16px;" class="glyphicon glyphicon-thumbs-down"></i></span>
                </a>';
        //notification manager call for insert in 'kidskula_club_notification' table :)@by sourav@5th jan,2015
        $res= $this->get('Bundle_notifyservice')->setClubNotification("likes",$artId);
        return new JsonResponse(array('msg' => $var, 'status' => 1));
        }
        if($status=='dislike')
        {
           $array=unserialize($RecieverStatus);
           
           if(($key = array_search($userId, $array)) !== false) {
           unset($array[$key]);
           } //unset the value from an array
           $newarray = $array;
           $serialize=serialize($newarray);
           $viewnotifExist->setLiked($serialize);
           $em->flush();
           $var='<a role="button"  class="btn btn-success" href="javascript:void(0)" onclick="articlelikefunc('.$artId.',\'like\')">
              <span id="artlike'.$artId.'"><i title="Like" style="font-size:16px;" class="glyphicon glyphicon-thumbs-up"></i></span>
              </a>';
           //notification manager call for insert in 'kidskula_club_notification' table :)@by sourav@5th jan,2015
           $res= $this->get('Bundle_notifyservice')->setClubNotification("dislikes",$artId);   
           return new JsonResponse(array('msg' => $var, 'status' => 0));
        }
        
        
    }
    public function studentclublogAction(Request $request) {
        $userId = $this->getUser()->getid();
        if ($request->getMethod() == 'POST') {
            
            $section = $request->get('section');
            
            
            $em = $this->getDoctrine()->getManager();
            $check_for_log_exist = $em->getRepository('BundleAdminBundle:Kidskulaactivitylog')->findOneBy(array('userid' => $this->getUser(),'pagesectionname'=>$section));
            
            
            if(!$check_for_log_exist)
            {   
                $entities = new Kidskulaactivitylog();
                $todaydate = date('Y-m-d h:i:s');
                $entities->setStartdate(new \DateTime());
                $entities->setEnddate(new \DateTime());
                $entities->setTotalvisittime('1');
                $entities->setPagesectionname($section);
                $entities->setUserid($this->getUser());
                $em->persist($entities);
                $em->flush();
            }
            else{
                $total_spend_time =  $check_for_log_exist->getTotalvisittime();
                $total_spend_time = $total_spend_time+1;
                
                $check_for_log_exist->setEnddate(new \DateTime());
                $check_for_log_exist->setTotalvisittime($total_spend_time);
                $em->flush();
                //$check_exist = \Doctrine\Common\Util\Debug::dump($check_for_log_exist);
            }
            
            //echo $section; 
            exit;
        }
        
        return $this->render('BundleKidskulaBundle:Logtracker:tracker.html.twig');
      }
}
