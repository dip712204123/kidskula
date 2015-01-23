<?php

//Created By Sourav Bhowmik @6/11/2014

namespace Bundle\ParentBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;



class IndexController extends Controller {

    
    public function indexAction() {
        //**********************************************************
        
        return $this->render('BundleParentBundle:Index:index.html.twig');
    }

   

}
