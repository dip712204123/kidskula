<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\CommonBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;



class IndexController extends Controller {

    
    public function indexAction() {
        //**********************************************************
        
        return $this->render('BundleCommonBundle:Index:index.html.twig');
    }

   

}
