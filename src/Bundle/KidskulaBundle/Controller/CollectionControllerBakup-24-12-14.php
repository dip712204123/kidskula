<?php

//Created By Sourav Bhowmik @3/12/2014

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidsKulaStudentCollection;
use Bundle\AdminBundle\Entity\KidsKulaStudentHasCollection;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\Kidskulafrndinvite;
use Bundle\AdminBundle\Entity\KidskulaNotification;
use Bundle\AdminBundle\Entity\KidsKulaStudentPoint;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Bundle\KidskulaBundle\Form\InvitefrndType;
use Bundle\AdminBundle\Manager\NotificationManager;
use Bundle\AdminBundle\Entity\KidsKulaCollectionTradeHistory;

class CollectionController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        //Fetch all my Collections
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $this->getUser(), 'getcollection' => 1));

        $totalcollection = count($studentCollection);

        $myCollectionReq = $em->getRepository('BundleAdminBundle:KidsKulaCollectionTradeHistory')->findBy(array('receiverId' => $this->getUser(), 'status' => 0));
        $totalCollectionReq = count($myCollectionReq);
        //FOR TOTAL POINT COUNT
        $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $this->getUser()));

        if (!$studentPoint) {
            $totalpoint = 0;
        } else {
            $totalpoint = $studentPoint->getPoint();
        }

        return $this->render('BundleKidskulaBundle:Collection:collection.html.twig', array('collectionarray' => $studentCollection, 'myCollectionReq' => $myCollectionReq, 'totalCollectionReq' => $totalCollectionReq, 'totalpoint' => $totalpoint));
    }

    public function findOneRandom() {
        $em = $this->getDoctrine()->getManager();
        $Alcol = $em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->findBy(array('subcatID' => 5, 'categoryId' => 4));
        $colarr = array();
        foreach ($Alcol as $collections) {
            array_push($colarr, $collections->getId());
        }
        $k = array_rand($colarr);
        return $v = $colarr[$k];
    }

    public function mycollectionsAction() {

        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getid();
        $userobject = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId); // Object of a particular user

        $invitiations = $em->getRepository('BundleAdminBundle:Kidskulafrndinvite')->findAll(array('sender' => $userobject));
        // echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($invitiations);exit;
        //print_r($check_invitiations->getInvitekey());exit;

        foreach ($invitiations as $value) {
            $Invitekey = $value->getInvitekey();
            $Status = $value->getStatus();
            //echo $Invitekey;
            $check_invitiations = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findOneBy(array('invitekey' => $Invitekey));
            $findSenderId = $em->getRepository('BundleAdminBundle:Kidskulafrndinvite')->findOneBy(array('invitekey' => $Invitekey));
            //\Doctrine\Common\Util\Debug::dump($check_invitiations);exit;
            if ($Status == 0) {              //Only send mail
                if (!$check_invitiations) {
                    $reward = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->findOneBy(array('id' => 6));
                    $pointsactivity = $reward->getPointsactivity();
                    $pointsactivity = unserialize($pointsactivity);
                    $point = $pointsactivity['point'];
                    $parameter = $pointsactivity['parameter'];

                    //Insert into table 'kidskula_student_has_collection' //Done by sourav@16_12_2014

                    $studentCollection = new KidsKulaStudentHasCollection();
                    $studentCollection->setStudentId($findSenderId->getSender());
                    $studentCollection->setStatus(1);
                    $studentCollection->setGetcollection(0);
                    $studentCollection->setPoint($point);
                    $studentCollection->setInvitekey($Invitekey);

                    $em->persist($studentCollection);
                    $em->flush();

                    //update table 'kidskula_student_point' //Done by sourav@18_12_2014
                    $pointAdd = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $findSenderId->getSender()));
                    $prePoint = $pointAdd->getPoint();
                    $totalPoint = $prePoint + $point;
                    $pointAdd->setPoint($totalPoint);
                    $pointAdd->setLastaddedDate(new \DateTime());

                    $em->persist($pointAdd);
                    $em->flush();
                    //Insert into table 'kidskula_notification'
                    //*********************** MANAGER TO ADD FOR NOTIFICATION **********************
                    //*****************************************************************************
                    $CollectionNotif = new KidskulaNotification();
                    $CollectionNotif->setToUser($this->getUser());

                    $CollectionNotif->setTexttoshow('You have earned ' . $point . ' points');

                    $em->persist($CollectionNotif);
                    $em->flush();
                }
            } else {                  //Get received
                if ($check_invitiations) {
                    if (!$check_invitiations->getCollectionId()) {
                        $updateId = $check_invitiations->getId();

                        /* $reward = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->findOneBy(array('id' => 5));


                          $pointsactivity=$reward->getPointsactivity() ;
                          $pointsactivity=  unserialize($pointsactivity);
                          $point= $pointsactivity['point'];
                          $parameter= $pointsactivity['parameter'];
                         */

                        //Fetch random value from collection table where subcatID=2************
                        $randomRet = $this->findOneRandom();

                        //**************Random collection fetching ends************************	

                        $collectionobject = $em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->findOneBy(array('id' => $randomRet));
                        //update table 'kidskula_student_has_collection'
                        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findOneBy(array('id' => $updateId));
                        $studentCollection->setGetcollection(1);
                        $studentCollection->setCollectionId($collectionobject);
                        $studentCollection->setCollectionPoint($collectionobject->getPoint());

                        $em->flush();

                        //update table 'kidskula_student_point' for collection no add //Done by sourav@18_12_2014
                        $collectionAdd = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $findSenderId->getSender()));
                        $preTotalcollection = $collectionAdd->getTotalcollection();
                        $Totalcollection = $preTotalcollection + 1;
                        $collectionAdd->setTotalcollection($Totalcollection);
                        $collectionAdd->setLastaddedDate(new \DateTime());

                        $em->persist($collectionAdd);
                        $em->flush();
                        //******************NOTIFICATION START***************************
                        $CollectionNotif = new KidskulaNotification();
                        $CollectionNotif->setToUser($this->getUser());

                        $CollectionNotif->setTexttoshow('You have earned 1 Collection');

                        $em->persist($CollectionNotif);
                        $em->flush();
                        //******************NOTIFICATION END***************************
                    }
                }
            }
        }


        //FETCH My total point

        $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $this->getUser()));
        $totalpoint = $studentPoint->getPoint();
        return new JsonResponse(array('msg' => $totalpoint, 'status' => 1));
    }

    public function mycollectionsHomeListingAction(Request $request) {
        //FETCH ALL COLLECTIONS
        $em = $this->getDoctrine()->getManager();
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $this->getUser(), 'getcollection' => 1));
        $totalcollection = count($studentCollection);

        return $this->render('BundleKidskulaBundle:Home:homecollection.html.twig', array('totalcollection' => $totalcollection, 'collectionarray' => $studentCollection));
    }

    public function mycollection_hometrade_buttonAction(Request $request) {

        $request = $this->getRequest();
        $Id = $request->get('newstatus');
        $em = $this->getDoctrine()->getManager();
        $studentCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findOneBy(array('studentId' => $this->getUser(), 'id' => $Id));
        $status = $studentCollection->getStatus();
        $imagepath = $this
                ->get('templating.helper.assets')
                ->getUrl('bundles/KidskulaBundle/assets', $packageName = null)
        ;
        if ($status == 1) {
            $studentCollection->setStatus(2);
            //$imagepath="{{asset('bundles/KidskulaBundle/assets')}}";

            $em->flush();
            return new JsonResponse(array('msg' => '<a href="javascript:void(0);" class="classtrade" onclick="tradeIcon(' . $Id . ');"><img src="' . $imagepath . '/images/trade.png" title="Allowed to trade" height="16px" width="16px" /></a>', 'status' => 2));
        }
        if ($status == 2) {
            $studentCollection->setStatus(1);

            $em->flush();
            return new JsonResponse(array('msg' => '<a href="javascript:void(0);" class="classtrade" onclick="tradeIcon(' . $Id . ');"><img src="' . $imagepath . '/images/cart.png" title="Not allowed to trade" height="16px" width="16px" /></a>', 'status' => 1));
        }
    }

    public function mycollection_tradeAction($id) {
        $friendId = base64_decode($id);
        $em = $this->getDoctrine()->getManager();
        //Fetch all my Collections that are to be exchanged means status=2
        //$myCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $this->getUser(),'getcollection'=>1,'status'=>'2'));
        //Fetch all my Collections
        $myCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $this->getUser(), 'getcollection' => 1));

        //Fetch all friend's Collections that are to be exchanged means status=2
        $friendTradeCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $friendId, 'getcollection' => 1, 'status' => '2'));
        //Fetch all friend's Collections
        $friendCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('studentId' => $friendId, 'getcollection' => 1));
        //POST USER COLLECTION REQUEST 
        $myCollectionReq = $em->getRepository('BundleAdminBundle:KidsKulaCollectionTradeHistory')->findBy(array('senderId' => $this->getUser(), 'status' => 0));
        $totalCollectionReq = count($myCollectionReq);
        //My total point
        $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $this->getUser()));

        if (!$studentPoint) {
            $totalpoint = 0;
        } else {
            $totalpoint = $studentPoint->getPoint();
        }
        return $this->render('BundleKidskulaBundle:Collection:collection_trade.html.twig', array('myCollection' => $myCollection, 'friendCollection' => $friendCollection, 'friendId' => $friendId, 'myCollectionReq' => $myCollectionReq, 'totalCollectionReq' => $totalCollectionReq, 'friendTradeCollection' => $friendTradeCollection, 'totalpoint' => $totalpoint));
    }

    public function mycollection_trade_exchangeAction(Request $request) {
        $request = $this->getRequest();
        $friendId = $request->get('friendId');
        $mycolid = $request->get('mycolid');
        $friendcolid = $request->get('friendcolid');

        $em = $this->getDoctrine()->getManager();
        //Fetch all my Collections
        $myCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('id' => $mycolid));
        $friendCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findBy(array('id' => $friendcolid));

        //FOR USER OBJECT
        $userId = $this->getUser()->getid();
        $friendobject = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($friendId); // Object of a particular user


        $CollectionTradeHistory = new KidsKulaCollectionTradeHistory();
        $CollectionTradeHistory->setSenderId($this->getUser());
        $CollectionTradeHistory->setReceiverId($friendobject);
        $CollectionTradeHistory->setSendercollectionid($myCollection[0]->getCollectionId()); //CollectionID object
        $CollectionTradeHistory->setReceivercollectionid($friendCollection[0]->getCollectionId()); //CollectionID object
        $CollectionTradeHistory->setSendercolpoint($myCollection[0]->getCollectionPoint());
        $CollectionTradeHistory->setReceivercolpoint($friendCollection[0]->getCollectionPoint());
        $CollectionTradeHistory->setStatus(0);
        $em->persist($CollectionTradeHistory);
        $em->flush();

        //******************NOTIFICATION FOR SENDER START***************************
        $CollectionNotif = new KidskulaNotification();
        $CollectionNotif->setToUser($this->getUser());

        $CollectionNotif->setCreatedDate(new \DateTime());
        $CollectionNotif->setTexttoshow('Your request has been sent to ' . $friendobject->getFirstName() . ' and waiting for approval');

        $em->persist($CollectionNotif);
        $em->flush();
        //******************NOTIFICATION END***************************
        //******************NOTIFICATION FOR RECEIVER START***************************
        $CollectionNotif = new KidskulaNotification();
        $CollectionNotif->setToUser($friendobject);

        $CollectionNotif->setCreatedDate(new \DateTime());
        $CollectionNotif->setTexttoshow('You have new collection exchange request from ' . $this->getUser()->getFirstName());

        $em->persist($CollectionNotif);
        $em->flush();
        //******************NOTIFICATION END***************************

        return new JsonResponse(array('msg' => 'Your request has been sent and waiting for approval', 'status' => 1));
    }

    function mycollection_trade_rejectAction(Request $request) {

        $mycolid = $request->get('mycolid');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BundleAdminBundle:KidsKulaCollectionTradeHistory')->find($mycolid);

        $em->remove($entity);
        $em->flush();

        return new JsonResponse(array('msg' => 'Request rejected.', 'status' => 1));
    }

    function mycollection_trade_accpetAction(Request $request) {

        $mycolid = $request->get('mycolid');
		//echo $mycolid;exit;
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BundleAdminBundle:KidsKulaCollectionTradeHistory')->findOneBy(array('id'=>$mycolid));
        //\Doctrine\Common\Util\Debug::dump($entity);exit;
        $myColNewId = $entity->getSendercollectionid(); 
        $frndColNewId = $entity->getReceivercollectionid();
        //*********************** UPDATE MY / FRIEND'S POINT STARTS HERE *******************************************************************************************
        $mypoint = $entity->getReceivercolpoint();
        $friendpoint = $entity->getSendercolpoint();


        if ($mypoint > $friendpoint) {
            //*******ADD POINT TO MY ACCOUNT******************   
            $studentPoint = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $entity->getReceiverId()));
            $pluspoint = $mypoint - $friendpoint;
            $setReceivercolpoint = $studentPoint->getPoint();
            $totalpoint = $setReceivercolpoint + $pluspoint;
            $studentPoint->setPoint($totalpoint);
            $studentPoint->setLastaddedDate(new \DateTime());
            $em->flush();
            //*******DEDUCT POINT FROM FRIEND'S ACCOUNT******************   
            $studentPoint2 = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $entity->getSenderId()));
            $setSendercolpoint = $studentPoint2->getPoint();
            $totalpoint2 = $setSendercolpoint - $pluspoint;
            $studentPoint2->setPoint($totalpoint2);
            $studentPoint2->setLastaddedDate(new \DateTime());
            $em->flush();
        } elseif ($mypoint < $friendpoint) {
            //*******DEDUCT POINT TO MY ACCOUNT******************   
            $mypointdeduct = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $entity->getReceiverId()));
            $pluspoint = $friendpoint - $mypoint;
            $fetchmypoint = $mypointdeduct->getPoint();
            $deductsetmypoint = $fetchmypoint - $pluspoint;
            $mypointdeduct->setPoint($deductsetmypoint);
            $mypointdeduct->setLastaddedDate(new \DateTime());
            $em->flush();

            //*******ADD POINT TO MY FRIEND'S ACCOUNT****************** 
            $studentPoint2 = $em->getRepository('BundleAdminBundle:KidsKulaStudentPoint')->findOneBy(array('studentId' => $entity->getSenderId()));
            if (!$studentPoint2) {
                $pointAdd = new KidsKulaStudentPoint();
                
                $pointAdd->setStudentId($entity->getSenderId());
                $pointAdd->setPoint($pluspoint);
                $pointAdd->setTotalcollection(0);
                
                $em->persist($pointAdd);
                $em->flush();
            } else {
                //echo '<pre>';
                //\Doctrine\Common\Util\Debug::dump($studentPoint2);exit;
                $setSendercolpoint = $studentPoint2->getPoint();
                $totalpoint2 = $setSendercolpoint + $pluspoint;
                $studentPoint2->setPoint($totalpoint2);
                $studentPoint2->setLastaddedDate(new \DateTime());
                $em->flush();
            }
        }
        //*********************** UPDATE MY / FRIEND'S POINT CLOSE HERE *******************************************************************************************
       
	   //*********************** UPDATE MY COLLECTION **********************
        $myCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findOneBy(array('studentId' => $entity->getReceiverId(), 'collectionId' => $frndColNewId, 'getcollection' => 1));
        //$myCollection = $myCollection[0];
       // echo '<pre>';
        // \Doctrine\Common\Util\Debug::dump($myCollection);exit;
		//echo '*********************************************************************';
		
		//$collectionentity = $em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->findOneBy(array('id'=>$myColNewId));
		//\Doctrine\Common\Util\Debug::dump($collectionentity);
		//exit;
        $myCollection->setCollectionId($myColNewId);
        $myCollection->setTradewith($entity->getSenderId());
        $myCollection->setSharedate(new \DateTime());
        $em->flush();

        //*********************** UPDATE FRIENDS COLLECTION **********************
        $myFrndCollection = $em->getRepository('BundleAdminBundle:KidsKulaStudentHasCollection')->findOneBy(array('studentId' => $entity->getSenderId(), 'collectionId' => $myColNewId, 'getcollection' => 1));
        //$myFrndCollection = $myFrndCollection[0];
        $myFrndCollection->setCollectionId($frndColNewId);
        $myFrndCollection->setTradewith($entity->getReceiverId());
        $myFrndCollection->setSharedate(new \DateTime());
        $em->flush();

        //************ UPDATE TRADE REQUEST TABLE***********************
        $entity->setStatus(1);
        $em->flush();

        //******************NOTIFICATION FOR SENDER START***************************
        $CollectionNotif = new KidskulaNotification();
        $CollectionNotif->setToUser($entity->getSenderId());

        $CollectionNotif->setCreatedDate(new \DateTime());
        $CollectionNotif->setTexttoshow($entity->getSenderId()->getFirstName() . ' has accepted your request and you have successfully exchanged the collection.');

        $em->persist($CollectionNotif);
        $em->flush();
        //******************NOTIFICATION END***************************
        //******************NOTIFICATION FOR RECEIVER START***************************
        $CollectionNotif = new KidskulaNotification();
        $CollectionNotif->setToUser($entity->getReceiverId());

        $CollectionNotif->setCreatedDate(new \DateTime());
        $CollectionNotif->setTexttoshow('You have successfully exchanged your collection with ' . $entity->getSenderId()->getFirstname());

        $em->persist($CollectionNotif);
        $em->flush();
        //******************NOTIFICATION END***************************

        $this->get('session')->getFlashBag()->set('success', 'You have successfully exchanged your collection with ' . $entity->getSenderId()->getFirstname());


        return new JsonResponse(array('msg' => 'Request accepted.', 'status' => 1));
    }

}
