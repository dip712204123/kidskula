<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaNotification;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Bundle\KidskulaBundle\Form\InvitefrndType;

//use Bundle\AdminBundle\Manager\UserManager;


class NotificationController extends Controller {

   
    public function notificationSeenAction(Request $request) {
        $request = $this->getRequest();
        $visible = $request->get('visible');
        //print_r($visible);exit;

        $userId = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        //echo '<pre>';
        $insertdata = $em->getRepository('BundleAdminBundle:KidskulaNotification')->findBy(array('id'=>$visible));
		//\Doctrine\Common\Util\Debug::dump($insertdata);exit;
		foreach($insertdata as $data)
		{
        $data->setSeenByUser('1');
		$data->setModifiedDate(new \DateTime());
		$em->flush();
		}
		$notification=$em->getRepository('BundleAdminBundle:KidskulaNotification')->findBy(array('toUser'=>$userId,'seenByUser'=>0));
        $count= count($notification);
        
        return new JsonResponse(array('msg' => 'seen', 'status' => 1,'count'=>$count));
    }

}
