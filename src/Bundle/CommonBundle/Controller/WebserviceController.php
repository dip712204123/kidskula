<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaStudentGrade;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Entity\KidsKullaschoolshaskidskulausers;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaEmailNotification;
use Bundle\KidskulaBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Bundle\AdminBundle\Entity\KidskulaModules;
use Bundle\AdminBundle\Entity\Kidskulafrndinvite;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;



class WebserviceController extends Controller {

    
    public function indexAction(Request $request) {
        //**********************************************************
       
        //print_r($registration_data);
        $request = $this->getRequest();
         if($request->getMethod()=='POST'){ 
            $studentregistration = $request->get('studentregistration');
            print_r($studentregistration);
         }
         
         
        
        echo 'aaa'; exit;
    }

   

}