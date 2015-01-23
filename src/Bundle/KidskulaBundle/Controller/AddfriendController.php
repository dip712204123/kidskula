<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidsKulaStudentPoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Bundle\AdminBundle\Entity\KidsKulaStudentHasCollection;
use Bundle\AdminBundle\Entity\Kidskulafrndinvite;

class AddfriendController extends Controller {

    public function addfriendAction(Request $request) {

        $request = $this->getRequest();
        $friendId = $request->get('friendId');
        
        //check parent approval for friend request from user manager
        $parentApproval= $this->get('Bundle_userservice')->getParentfrndApproval();


        $userId = $this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $friendId, 'sender' => $insertdata));

        if ($friendExist) {
            $friendExist->setSender($insertdata);
            $friendExist->setReceiverId($friendId);
            $friendExist->setStatus(1);
            if($parentApproval==1)
            {
                $friendExist->setSenderParentApproval('1');
                $friendExist->setRecieverParentApproval('1');
            }
            else{
                $friendExist->setSenderParentApproval('2');
                $friendExist->setRecieverParentApproval('2');
            }
            $em->flush();
        } else {
            $friendExist1 = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));

            if ($friendExist1) {
                // $frienddata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
                //echo $frienddata;exit;
                $friendExist1->setSender($insertdata);
                $friendExist1->setReceiverId($friendId);
                $friendExist1->setStatus(1);
                if($parentApproval==1)
                {
                   $friendExist1->setSenderParentApproval('1');
                   $friendExist1->setRecieverParentApproval('1');
                }
                else{
                   $friendExist1->setSenderParentApproval('2');
                   $friendExist1->setRecieverParentApproval('2');
                 }
                $em->flush();
            } else {
                $entities = new KidskulaFriendRequest();
                $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
                $entities->setSender($insertdata);
                $entities->setReceiverId($friendId);
                $entities->setSendDate(new \DateTime());
                $entities->setStatus('1');
                if($parentApproval==1)
                {
                $entities->setSenderParentApproval('1');
                $entities->setRecieverParentApproval('1');
                }
                else{
                $entities->setSenderParentApproval('2');
                $entities->setRecieverParentApproval('2');
                }
                $em->persist($entities);
                $em->flush();
            }
        }



        return new JsonResponse(array('msg' => '<button id="cancelfriendbtn" class="btn col-md-12 addfrnd_btn" onclick="cancelfriend();" type="button">Cancel Friend Request</button>', 'status' => 1));
    }

    public function cancelfriendAction(Request $request) {

        $request = $this->getRequest();
        $friendId = $request->get('friendId');

        $userId = $this->getUser()->getid();

        $em = $this->getDoctrine()->getManager();

        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $friendId, 'sender' => $insertdata));
        if (!$friendExist) {
            $friendExist1 = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));
            $friendExist1->setStatus(0);

            $em->flush();
        } else {
            $friendExist->setStatus(0);

            $em->flush();
        }
        return new JsonResponse(array('msg' => '<button id="addfriendbtn" class="btn col-md-12 addfrnd_btn" onclick="addfriend();" type="button">Add Friend</button>', 'status' => 1));
    }

    public function acceptfriendAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $friendId = $request->get('friendId');

        $frienddata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($friendId);

        $userId = $this->getUser()->getid();


        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);

        $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));
        //\Doctrine\Common\Util\Debug::dump($friendExist);exit;
        $totalfriend = count($friendExist);
        if ($totalfriend > 0) {
            $friendExist->setReplyDate(new \DateTime());
            //$friendExist->setStatus('2');
            $friendExist->setStatus('2');
            $em->flush();

            //Add user to friend table
            $user = $this->getUser();
            $user->addVetcommConnections($frienddata);
            $em->flush();

            $frienddata->addVetcommConnections($user);
            $em->flush();

            if ($totalfriend == 1) {
                $lastrequest = 'yes';
            } else {
                $lastrequest = 'no';
            }
            return new JsonResponse(array('msg' => 'success', 'status' => 1, 'lastrequest' => $lastrequest));
        } else {
            return new JsonResponse(array('msg' => 'empty', 'status' => 0));
        }
    }

    public function unfriendAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $request = $this->getRequest();
        $friendId = $request->get('friendId');

        $frienddata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($friendId);

        $userId = $this->getUser()->getid();


        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);

        $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $friendId, 'sender' => $insertdata));
        if (!$friendExist) {
            $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));
        }
        $totalfriend = count($friendExist);
        if ($totalfriend > 0) {

            $friendExist->setStatus('0');
            $em->flush();

            //Add user to friend table
            $user = $this->getUser();
            $user->removeVetcommConnections($frienddata);
            $em->flush();

            $frienddata->removeVetcommConnections($user);
            $em->flush();

            return new JsonResponse(array('msg' => '<button id="addfriendbtn" class="btn col-md-12 addfrnd_btn" onclick="addfriend();" type="button">Add Friend</button>', 'status' => 1));
        } else {
            return new JsonResponse(array('msg' => 'empty', 'status' => 0));
        }
    }

    public function rejectfriendAction(Request $request) {

        $request = $this->getRequest();
        $friendId = $request->get('friendId');

        $userId = $this->getUser()->getid();
        $em = $this->getDoctrine()->getManager();

        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $insertdata, 'sender' => $friendId));
        $totalfriend = count($friendExist);

        if ($totalfriend > 0) {

            //$entities->setSendDate(new \DateTime());
            $friendExist->setStatus(0);

            $em->flush();
            if ($totalfriend == 1) {
                $lastrequest = 'yes';
            } else {
                $lastrequest = 'no';
            }
            return new JsonResponse(array('msg' => 'success', 'status' => 1, 'lastrequest' => $lastrequest));
        } else {
            return new JsonResponse(array('msg' => 'failure', 'status' => 0));
        }
    }

    public function intervalrequestcheckAction(Request $request) {
        //****************************************************
        //Fetch all friend requests from manager(UserManager)

        $em = $this->getDoctrine()->getManager();
        $category = $em->createQueryBuilder();
        $userId = $this->getUser()->getid();

        $datefrom = new \DateTime('-6 months'); //For fetch within 6 months friends

        $category->select('request,connection as fromuser')
                ->from('BundleAdminBundle:KidskulaFriendRequest', 'request')
                ->leftJoin('request.sender', 'connection')
                ->where('request.status=1 and request.receiverId=:connectionId')
                ->andWhere('request.senderParentApproval = 2') 
                ->andWhere('request.recieverParentApproval = 2')
                ->setParameter('connectionId', $userId)
                ->groupby('request.id')
                ->orderBy('request.sendDate', 'DESC');



        $query = $category->getQuery();
        //echo $query->getSql();exit;
        $frnds = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $countArray = count($frnds);
        return $this->render('BundleKidskulaBundle:Home:friendrequestajax.html.twig', array(
                    'frndrequest' => $frnds,
                    'countArray' => $countArray,
        ));


        //\Doctrine\Common\Util\Debug::dump($frnds);exit;
        //**********************************************************
    }
    //**************************Home page friend invtation div show********************************
    public function friendrequestcheckAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $category = $em->createQueryBuilder();
        $userId = $this->getUser()->getid();

        $datefrom = new \DateTime('-6 months'); //For fetch within 6 months friends

        $category->select('request,connection as fromuser')
                ->from('BundleAdminBundle:KidskulaFriendRequest', 'request')
                ->leftJoin('request.sender', 'connection')
                ->where('request.status=1 and request.receiverId=:connectionId')
                ->andWhere('request.senderParentApproval = 2') 
                ->andWhere('request.recieverParentApproval = 2')
                ->setParameter('connectionId', $userId)
                ->groupby('request.id')
                ->orderBy('request.sendDate', 'DESC');



        $query = $category->getQuery();
        $frnds = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        $countArray = count($frnds);
        if($countArray>0){
            return new JsonResponse(array('msg' => 'show', 'status' => 1));
        }
        else
        {
         return new JsonResponse(array('msg' => 'hide', 'status' => 0));   
        }

    }
    //**********************************************************
    public function invitefrndsAction(Request $request) {

        $request = $this->getRequest();
        $secretcode = $request->get('secretcode');
        $avatarname = $request->get('avatarname');
        $type = $request->get('type');

        $em = $this->getDoctrine()->getManager();
        //check parent approval for friend request from user manager
        $parentApproval= $this->get('Bundle_userservice')->getParentfrndApproval();
        
        if ($type == 'invitewithsecret') {
            $friendId = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('securityCode' => $secretcode, 'myavatar' => $avatarname));
            if ($friendId) {
                $userId = $this->getUser()->getid();

                $insertdata = $this->getUser();

                $friendExist = $em->getRepository('BundleAdminBundle:KidskulaFriendRequest')->findOneBy(array('receiverId' => $friendId->getId(), 'sender' => $insertdata));

                if ($friendExist != NULL) {
                    if ($friendExist->getStatus() == 0) {
                        $friendExist->setSender($insertdata);
                        $friendExist->setReceiverId($friendId);
                        $friendExist->setStatus(1);
                        if($parentApproval==1)
                        {
                        $friendExist->setSenderParentApproval('1');
                        $friendExist->setRecieverParentApproval('1');
                        }
                        else{
                        $friendExist->setSenderParentApproval('2');
                        $friendExist->setRecieverParentApproval('2');
                        }
                        $em->flush();
                        return new JsonResponse(array('msg' => 'request_sent', 'status' => 1, 'user' => $friendId));
                    } else if ($friendExist->getStatus() == 1) {
                        return new JsonResponse(array('msg' => 'already_sent', 'status' => 1, 'user' => $friendId));
                    } else {
                        return new JsonResponse(array('msg' => 'already_friend', 'status' => 1, 'user' => $friendId));
                    }
                } else {
                    $entities = new KidskulaFriendRequest();
                    $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
                    $entities->setSender($insertdata);
                    $entities->setReceiverId($friendId->getId());
                    $entities->setSendDate(new \DateTime());
                    $entities->setStatus('1');
                    if($parentApproval==1)
                        {
                        $entities->setSenderParentApproval('1');
                        $entities->setRecieverParentApproval('1');
                        }
                        else{
                        $entities->setSenderParentApproval('2');
                        $entities->setRecieverParentApproval('2');
                        }
                    

                    $em->persist($entities);
                    $em->flush();

                    return new JsonResponse(array('msg' => 'request_sent', 'status' => 1, 'user' => $friendId));
                }
            } else {
                return new JsonResponse(array('msg' => 'oppsy', 'status' => 0));
            }
        }
    }

    public function findfrndsAction(Request $request) {

        //fetching value from landing page form @sourav
        //initialise session variable 
        $session = $this->getRequest()->getSession();

        $request = $this->getRequest();
        $checkbox1 = $request->request->get('checkbox1');
        $checkbox2 = $request->request->get('checkbox2');
        $checkbox3 = $request->request->get('checkbox3');
        $em = $this->getDoctrine()->getManager();
        $userId = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('id' => $this->getUser()));

        $schoolgrade = $em->getRepository('BundleAdminBundle:KidsKullaschoolshaskidskulausers')->findOneBy(array('kidskulausersid' => $this->getUser()));

        $category = $em->createQueryBuilder();
        $category->select('a.id', 'a.firstName', 'a.lastName', 'a.username')->from('BundleAdminBundle:KidsKulaUsers', 'a')
                ->leftJoin('BundleAdminBundle:KidsKullaschoolshaskidskulausers', 'b', 'with', 'b.kidskulausersid=a.id')
                ->where('a.status =' . '1')
                ->andwhere('a.id NOT IN(' . $userId->getId() . ')')
                ->andwhere('a.roles LIKE :roles')
                ->setParameter('roles', '%ROLE_STUDENT%');

        if ($checkbox1 == 1) {

            $city = $userId->getCity();
            $category->andwhere('LOWER(a.city) like :city');
            $category->setParameter('city', strtolower('%' . $city . '%'));
            $session->set('city', $city);
        } else {
            $city = '';
        }
        //for school and grade


        if ($checkbox2 == 1) {
            $school = $schoolgrade->getKidsKullaschoolsid();
            $category->andwhere('b.KidsKullaschoolsid= :schoolid');
            $category->setParameter('schoolid', $school);
            $session->set('school', $school);
        } else {
            $school = '';
        }

        if ($checkbox3 == 1) {

            $selectgrade = $schoolgrade->getGradeId();
            $category->andwhere('b.gradeId= :gradeid ');
            $category->setParameter('gradeid', $selectgrade);
            $session->set('selectgrade', $selectgrade);
        } else {
            $selectgrade = '';
        }



//      $category->setParameter('city', strtolower('%' . $city . '%'))
//                         ->setParameter('schoolid', $school)
//                         ->setParameter('gradeid', $selectgrade);



        $query = $category->getQuery();
        //echo'<pre>';
        $entity = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //\Doctrine\Common\Util\Debug::dump($entity);
        //exit;

        return $this->render('BundleKidskulaBundle:Dashboard:dashboard.html.twig', array(
                    'entities' => $entity
        ));
    }

    //Fetch Reandom string for making invitation key********
    function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        // Length of character list
        $chars_length = (strlen($chars) - 1);

        // Start our string
        $string = $chars{rand(0, $chars_length)};

        // Generate random string
        for ($i = 1; $i < $length; $i = strlen($string)) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};

            // Make sure the same two characters don't appear next to each other
            if ($r != $string{$i - 1})
                $string .= $r;
        }

        // Return the string
        return $string;
    }

    public function invitenewfriendsAction(Request $request) {

        //initialise session variable 
        $session = $this->getRequest()->getSession();

        /*         * ********* active tab part start ********* */
        $active_friend_tab_session = $request->getSession();
        $active_friend_tab_session->set('active_invite_friend', '1');
        /*         * ********* active tab part end ********* */

        $request = $this->getRequest();
        $friend_name = $request->request->get('friend_name');

        if (isset($friend_name) && $friend_name != '') {
            $friend_name_arr = explode(',', $friend_name);
        }

        if (isset($friend_name_arr) && !empty($friend_name_arr)) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $userID = $user->getId();

            foreach ($friend_name_arr as $row) {
                $send_friend_request = $em->getRepository('BundleAdminBundle:Kidskulafrndinvite')->findOneBy(array('sender' => $userID, 'receiveremail' => $row));
                /*                 * ***** check sender email id and send user id ******* */
                if (!$send_friend_request) {


                    // $inviteIdkey= mktime(date("H"),date("s"),date("m"),date("i"),date("d")+1).mt_rand(10,80).mt_rand(1,10).mt_rand(1,90).mt_rand(19,90).mt_rand(51,90);
                    $inviteIdkey = $this->rand_str(); //Done by sourav@16_12_2014 for generating random str key
                    //Insert into table 'kidskula_frnd_invite'
                    $friendInvite = new Kidskulafrndinvite();
                    $friendInvite->setSender($this->getUser());
                    $friendInvite->setReceiveremail($row);
                    $friendInvite->setSenddate(new \DateTime());
                    $friendInvite->setStatus(0);
                    $friendInvite->setInvitekey($inviteIdkey);
                    $em->persist($friendInvite);
                    $em->flush();

                    //Insert into table 'kidskula_student_point' //Done by sourav@18_12_2014
                    $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $this->getUser()));

                    if (!$studentPoint) {
                        $pointAdd = new KidsKulaStudentPoint();
                        $pointAdd->setStudentId($this->getUser());
                        $pointAdd->setPoint(0);
                        $pointAdd->setTotalcollection(0);
                        $em->persist($pointAdd);
                        $em->flush();
                    }


                    /*                     * ******** mail part start ******** */
                    $emailcode = 'friend_invitation_email_by_mail';
                    $em = $this->getDoctrine()->getManager();
                    $emailEntity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findOneBy(array('emailCode' => $emailcode));

                    if ($emailEntity) {
                        $fullname = $user->getFirstName() . ' ' . $user->getLastName();

                        $to_mail = $row;
                        $from_mail = '';

                        $baseurl = $request->getScheme() . '://' . $request->getHttpHost();

                        /* $info = '<a href="http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('fornt_auth_registration',array('auth' => base64_encode($inviteIdkey))).'">here</a>.';
                         */
                        $info = '<a href="' . $baseurl . $this->generateUrl('fornt_auth_registration', array('auth' => base64_encode($inviteIdkey))) . '">here</a>.';

                        $subject = $emailEntity->getSubject();
                        $email_content = $emailEntity->getContent();
                        $email_content = str_replace("###username###", $row, $email_content);
                        $email_content = str_replace("###friendname###", $fullname, $email_content);
                        $email_content = str_replace("###Info###", $info, $email_content);
                        //echo $email_content."<br/>";exit;
                        $cc = '';
                        $template = '';
                        $this->container->get('Bundle_mailservice')->sendMail(array('text' => $email_content, 'subject' => $subject), $from_mail, $to_mail, 'confirmation');
                    }
                    /*                     * ******** mail part end ******** */
                }
            }

            $this->get('session')->getFlashBag()->set('success_message', 'Your friend request successfully send');
            return $this->redirect($this->generateUrl('home'));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please enter friend\'s email id');
            return $this->redirect($this->generateUrl('home'));
        }
    }

}
