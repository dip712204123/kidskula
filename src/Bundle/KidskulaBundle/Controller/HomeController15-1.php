<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskullaMessaging;
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
        $category = $em->createQueryBuilder();
        $category->select('a', 'b', 'c')->from('BundleAdminBundle:KidskulaUsersProfile', 'a')
                ->leftJoin('BundleAdminBundle:KidsKulaUsers', 'b', 'with', 'b.id=a.kidskulaUsersUser')
                ->leftJoin('BundleAdminBundle:KidsKulaStudentAvatar', 'c', 'with', 'c.id=b.avatarid')
                ->where('b.id =' . $userId);

        $query = $category->getQuery();
        //print_r($query->getSql()); die;
        // echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($query);exit;

        $entity = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        //echo '<pre>';
        // \Doctrine\Common\Util\Debug::dump($entity);exit;
        if (!$entity) {

            $this->get('session')->getFlashBag()->set('error_message', 'There Is No Profile Details');
            return $this->redirect($this->generateUrl('frnd_search_index')); // Route should be changed.Now it is temporary use
        }
		
        //****************************************************
        //Fetch all my points from KidsKulaStudentPoint
        $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $this->getUser()));
		
		if (!$studentPoint) {
		$totalpoint= 0;
		}else{
        $totalpoint = $studentPoint->getPoint();
		}
       
        //Fetch all my Collections
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $this->getUser(),'getcollection'=>1));
 
        $totalcollection=count($studentCollection);
       
        //**************************************************
        //Fetch all friend requests from manager(UserManager)
        $datefrom = new \DateTime('-6 months');

        $category->select('request,connection as fromuser')
                ->from('BundleAdminBundle:KidskulaFriendRequest', 'request')
                ->leftJoin('request.sender', 'connection')
                ->where('request.status=1 and request.receiverId=:connectionId')
                ->setParameter('connectionId', $userId)
                ->groupby('request.id')
                ->orderBy('request.sendDate', 'DESC');



        $query = $category->getQuery();
        $frnds = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        $countArray = count($frnds);

        //*********************My all friends ************************** 
        $myfrnds = $this->getUser()->getFriendsWithMe();
        $mytotalfriend = count($myfrnds);
        //\Doctrine\Common\Util\Debug::dump($myfrnds);exit;
        //*********************Invite friends form************************** 

        $form = $this->createForm(new InvitefrndType($em));
        //********************************************************** 
        //*********************LISTING ALL NOTIFICATION************************** 
        $studentNotification = $em->getRepository('BundleAdminBundle:KidskulaNotification')->findBy(array('toUser' => $this->getUser(),'seenByUser'=>0),array('id' => 'DESC'));
		$notification_count = count($studentNotification);
        //********************************************************** 
        //*********************LISTING ALL CLUBS********************
        $clubentity = $em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('studentId' =>$this->getUser()));
        
        $clubcount=count($clubentity);
        //**********************************************************
        
        return $this->render('BundleKidskulaBundle:Home:home.html.twig', array(
                    'profile' => $entity[0],
                    'personal' => $entity[1],
                    'avatar' => $entity[2],
                    'frndrequest' => $frnds,
                    'countArray' => $countArray,
                    'myfrnds' => $myfrnds,
                    'mytotalfriend' => $mytotalfriend,
                    'collectionarray'=>$studentCollection,                    
                    'totalcollection'=>$totalcollection,
                    'collectionpoint'=>$totalpoint,
                    'studentNotification'=>$studentNotification,
					'notification_count'=>$notification_count,
                    'clubcount'=>$clubcount,
                    'clubentity'=>$clubentity,
                    'form' => $form->createView()
        ));
    }

    public function friendhomeAction($username) {

        $accessor = PropertyAccess::createPropertyAccessor(); ///To acccess array values.

        $em = $this->getDoctrine()->getManager();

        //echo $userId;exit; 
        //Fetch all deatils related to the user
        $category = $em->createQueryBuilder();
        $category->select('a', 'b')->from('BundleAdminBundle:KidskulaUsersProfile', 'a')
                ->leftJoin('BundleAdminBundle:KidsKulaUsers', 'b', 'with', 'b.id=a.kidskulaUsersUser')
                ->where("b.username ='" . $username . "'");

        $query = $category->getQuery();


        $entity = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if (!$entity) {

            $this->get('session')->getFlashBag()->set('error_message', 'There Is No Profile Details');
            return $this->redirect($this->generateUrl('frnd_search_index')); // Route should be changed.Now it is temporary use
        }
        //****************** find this friend's friends list!!
        $friendId = $accessor->getValue($entity, '[1][id]');
        
        $friendIdentity = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($friendId);
        // \Doctrine\Common\Util\Debug::dump($friendIdentity);exit;
        $myfrnds = $friendIdentity->getFriendsWithMe();
        $mytotalfriend = count($myfrnds);
        //****************** find this friend's profile details
        //****************** find this friend is in my friend list or not!!


        $userId = $this->getUser()->getid();
        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $flag = 1;
        $friendExistNew = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $friendId, 'sender' => $insertdata));

        if (!$friendExistNew) {

            $flag = 0;
        } else {

            $status = $friendExistNew->getStatus();
            if ($status == 0)
                $flag = 0;
            elseif ($status == 1)
                $flag = 2;
            else
                $flag = 3;
        }

        if (!$friendExistNew && $flag == 0) {
            $friendExistNew = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));
            if (!$friendExistNew) {

                $flag = 0;
            } else {

                $status = $friendExistNew->getStatus();


                if ($status == 0)
                    $flag = 0;
                elseif ($status == 1)
                    $flag = 4; //For respond
                else
                    $flag = 3;
            }
        }

        $totalfriend = count($friendExistNew);
		
        //****************************************************
        //Fetch all my collections from manager(UserManager)
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $friendIdentity,'getcollection'=>1));
 
        $totalcollection=count($studentCollection);
      
        $totalpoint = 0;
        foreach ($studentCollection as $mycollection) {
          
            $totalpoint = $totalpoint + $mycollection->getPoint();   //My total point
            
        }
        
        //print_r($colArray);exit;
        //*****************collections END*********************************
        //**************Encryption Start*****************************
         // Create the initialization vector for added security.
         // $secret_key = "kidskula";
         // $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
         // $encrypted_string= mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$secret_key,$friendId,MCRYPT_MODE_CBC, $iv);
          
          //echo $decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret_key, $encrypted_string, MCRYPT_MODE_CBC, $iv);exit;
          $encrypted_string=  base64_encode($friendId);
         //**************Encryption*****************************
        return $this->render('BundleKidskulaBundle:Home:friendhome.html.twig', array(
                    'profile' => $entity[0],
                    'personal' => $entity[1],
                    'myuserId'=>$userId,
                    'friendId'=>$encrypted_string,
                    'totalfriend' => $totalfriend,
                    'flag' => $flag,
                    'friendExist' => $friendExistNew,
                    'myfrnds' => $myfrnds,
                    'mytotalfriend' => $mytotalfriend,
                    'collectionarray'=>$studentCollection,
                    'totalcollection'=>$totalcollection,
                    'collectionpoint'=>$totalpoint
                    
                   
        ));

//        return $this->render('BundleKidskulaBundle:Home:home.html.twig',array('username'=>$username));
    }

    public function profilestatusAction(Request $request) {

        $request = $this->getRequest();

        $newstatus = $request->get('newstatus');

        $userId = $this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser' => $userId));
        $entities->setProfileMsg($newstatus);
        $em->flush();
        return new JsonResponse(array('msg' => '<p>' . $newstatus . '  <span class="edittext"><a href="javascript:void(0)" onclick="statusChange();">Edit</a></span> </p>', 'status' => 1));
    }

    public function allfriendlistingAction(Request $request) {
        $myfrnds = $this->getUser()->getFriendsWithMe();
        $mytotalfriend = count($myfrnds);
        return $this->render('BundleKidskulaBundle:Home:allfriendsajax.html.twig', array(
                    'myfrnds' => $myfrnds,
                    'mytotalfriend' => $mytotalfriend,
        ));
    }

    public function setavatarnameAction(Request $request) {
        $request = $this->getRequest();
        $textval = $request->get('textval');


        $userId = $this->getUser()->getid();

        $em = $this->getDoctrine()->getManager();

        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $insertdata->setMyavatar($textval);

        $em->flush();
        return new JsonResponse(array('msg' => '<a style="font-size:11px; font-family: Open sans;" href="javascript:void(0)" onclick="editavatar();" title="Edit Your Avatar Name">' . $textval . ' <i class="glyphicon glyphicon-edit iconsize" ></i></a>', 'status' => 1));
    }
    
    public function sendmessageAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $message = $request->get('message'); 
        $receiver_id = $request->get('user_id'); 
        $receiver_id = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('id' => $receiver_id));
        $senderId = $this->getUser();
        
        $entities = new KidskullaMessaging();
        $entities->setTouser($receiver_id);
        $entities->setFromuser($this->getUser());
        $entities->setTexttoshow($message);
        $em->persist($entities);
        $em->flush(); 
        echo '1'; exit;
    }

}
