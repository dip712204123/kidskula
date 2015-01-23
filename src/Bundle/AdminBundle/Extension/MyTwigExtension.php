<?php

namespace Bundle\AdminBundle\Extension;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
//use Bundle\AdminBundle\Entity\KidsKulaUsers;
//use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
//use Vet\AdminBundle\Manager\IndeedAPI;

class MyTwigExtension extends \Twig_Extension {

    /**
     *
     * @var EntityManager 
     */
    protected $em, $router, $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    function __construct(EntityManager $entityManager, \Symfony\Bundle\FrameworkBundle\Routing\Router $router, $container) {
        $this->em = $entityManager;
        $this->router = $router;
        $this->container = $container;

        if ($this->container->isScopeActive('request')) {
            $this->request = $this->container->get('request');
        }
        // $this->request=$request;
    }

    public function getFilters() {
        return array(
            'uppercase_first_letter' => new \Twig_Filter_Method($this, 'uppercase_first_letter'),
           
            'var_dump' => new \Twig_Filter_Function('var_dump'),
        );
    }

    function uppercase_first_letter($var) {
        return ucwords($var);
    }

    /**
     * Return the function registered as twig extension
     *
     * @return array
     */
    public function getFunctions() {
        return array(
            'my_twig_get_username' => new \Twig_Function_Method($this, 'getusername', array('is_safe' => array('html'))),
            'getTimediff' => new \Twig_Function_Method($this, 'getTimediff', array('is_safe' => array('html'))),
            'getimageurl' => new \Twig_Function_Method($this, 'getimageurl', array('is_safe' => array('html'))),
            'getNotification' => new \Twig_Function_Method($this, 'getNotification', array('is_safe' => array('html'))),
            'jsonDecode' => new \Twig_Function_Method($this, 'jsonDecode'),
            'getTitle' => new \Twig_Function_Method($this, 'getTitle'),
            'getRollById' => new \Twig_Function_Method($this, 'getRollById'),
            'checkInarray' => new \Twig_Function_Method($this, 'checkInarray'),
            'generateauthtoken' => new \Twig_Function_Method($this, 'generateauthtoken'),
            'getindeedJobdetails' => new \Twig_Function_Method($this, 'getindeedJobdetails'),
            'getprofileimage' => new \Twig_Filter_Method($this, 'getprofileimage'),
            'getcollectionparent' => new \Twig_Filter_Method($this, 'getcollectionparent'),
            'getFriendActiveTab' => new \Twig_Function_Method($this, 'getFriendActiveTab'),
            'getcollectionimage' => new \Twig_Filter_Method($this, 'getcollectionimage'),
            'totalJoinedClubMember' => new \Twig_Filter_Method($this, 'totalJoinedClubMember'),
            'totalMyFrndClubMember' => new \Twig_Filter_Method($this, 'totalMyFrndClubMember'),
            'getNotifications' => new \Twig_Filter_Method($this, 'getNotifications'),
            'getClubNotifications' => new \Twig_Filter_Method($this, 'getClubNotifications'),
            'getUserProfileDetails' => new \Twig_Filter_Method($this, 'getUserProfileDetails'),
            'getMessages' => new \Twig_Filter_Method($this, 'getMessages'),
            'getUsers' => new \Twig_Filter_Method($this, 'getUsers'),
        );
    }
    
    function getFriendActiveTab()
    {
        $active_tab = '';
        $session = $this->container->get('session');
        if($session->has('active_invite_friend'))  
        {
            $active_tab = $session->get('active_invite_friend') ;  
            $session->remove('active_invite_friend');
        }  
        
        return $active_tab;        
    }

    function jsonDecode($str) {
		//echo $str."<br/>";
        //$str = json_decode($str);		
        //$str = array_filter($str);		
		$str = json_decode($str, true);
		//print_r($str);		
        return $str;	
    }

    public function getTimediff($time) {

        $start_date = new \DateTime();
        $since_start = $start_date->diff($time);
        $minute = $since_start->i;
        $hour = $since_start->h;
        $day = $since_start->days;
        $diffstr = '';
        if ($day == 0 && $hour == 0) {
            $diffstr = $minute . ' Minutes.';
        } elseif ($day == 0) {
            $diffstr = $hour . ' Hr : ' . $minute . ' Min.';
        } else {
            $diffstr = $day > 1 ? $day . ' Days' : $day . ' Day';
        }
        $diffstr = $diffstr . ' ago';
        return $diffstr;
    }

    public function getusername() {
        $user = $this->container->get('security.context')->getToken()->getUser();

        return $user->getUsername();
    }

    public function getimageurl($id = 0) {
        if (empty($id))
            $user = $this->container->get('security.context')->getToken()->getUser();
        else
            $user = $this->em->getRepository('VetAdminBundle:VetcommUsers')->find($id);

        $userprofile = $this->em->getRepository('VetAdminBundle:VetcommUsersProfile')->findOneBy(array('vetcommUsers' => $user));
        $str = null;
        $url = 0;
        $str = null;
        $flag = 1;
        $path = $userprofile->getPath();
        $width = 0;
        $height = 0;


        if (!empty($path)) {
            $str = $userprofile->getImageurl();
            $src = __DIR__ . '/../../../../web/' . $str;
        }
        if (filter_var($path, FILTER_VALIDATE_URL) == true) {
            $str = $userprofile->getPath();

            $flag = 0;
        }
        if (!empty($str)) {
            list($width, $height, $type, $attr) = @getimagesize($str);
        }

        $data = array('image' => $str, 'flag' => $flag, 'width' => $width, 'height' => $height);


        return $data;
    }
    
    public function getprofileimage($id) {
         $user = $this->em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($id);

         $userprofile = $this->em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser' => $user));
         
         $path = $userprofile->getPath();
       
        
        return $path;
    }
    public function getcollectionimage($id) {
         $colimage = $this->em->getRepository('BundleAdminBundle:KidsKulaStudentCollection')->find($id);

        // $userprofile = $this->em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser' => $user));
         
         $path = $colimage->getPath();
       
        
        return $path;
    }
    public function getNotification() {
        return $this->container->get('vet_notification')->getCurrentnotifications(1);
    }

    function routeExists($name) {
        // I assume that you have a link to the container in your twig extension class

        return (null === $this->router->getRouteCollection()->get($name)) ? false : true;
    }

    function getTitle() {
        $route = $this->container->get('request')->getPathInfo();
        $route = explode('/', $route);
        // print_r($route);
        $str = '';
        foreach ($route as $r) {

            if (empty($r))
                continue;

            $temptitle = str_replace('_', ' ', $r);
            $temptitle = str_replace('-', ' ', $temptitle);
            $temptitle = ucwords($temptitle);

            $str .=' | ' . $temptitle;
        }


        return $str;
    }

    public function getName() {
        return 'recensus_twig_extension';
    }

    public function getRollById($role, $userid) {
        $userrolls = $this->container->get('vet_usermanager')->getrollsById($userid);
        if (in_array($role, $userrolls))
            return TRUE;

        return FALSE;
    }

    public function checkInarray($needel, $array) {

        if (!is_array($array))
            return FALSE;


        if (in_array($needel, $array)) {
            return TRUE;
        }

        return FALSE;
    }

    // Method for passwords encrypting in public ajaxlogin

    public function generateauthtoken() {

        $session = $this->container->get('session');
        if (!$session->has('login-ajax')) {
            $rand = rand(0, 10000000);
            $md5 = md5($rand);
            $sha = sha1($md5);
            $sha = $this->string_to_ascii($sha);

            $session->set('login-ajax', $sha);
        } else {
            $sha = $session->get('login-ajax');
        }

        return $sha;
    }

    function string_to_ascii($string) {
        $ascii = NULL;

        for ($i = 0; $i < strlen($string); $i++) {
            $ascii += ord($string[$i]);
        }

        return($ascii);
    }

    // get indeed job details By key
    public function getindeedJobdetails($jobkye) {

        $indeedAPI = new IndeedAPI();
        $searchcriteria = array(
            "jobkeys" => array($jobkye),
        );
        $output = $indeedAPI->query($searchcriteria);
        return (array) $output;
    }
    // get indeed job details By key
    public function getcollectionparent($parentid) {
        
        $pname = $this->em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($parentid);
       // \Doctrine\Common\Util\Debug::dump($pname);exit;

        $parentname=$pname->getCategoryName();
        return ($parentname);
    }
    // Total subscribe club member
    public function totalJoinedClubMember($clubid) {
        
        $clubentity = $this->em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId' =>$clubid));
       // \Doctrine\Common\Util\Debug::dump($pname);exit;

        $count=count($clubentity);
        return ($count);
    }
    // Total My friend subscribe club member
    public function totalMyFrndClubMember($clubid) {
        
        $clubentity = $this->em->getRepository('BundleAdminBundle:KidsKulaClubMember')->findBy(array('clubId' =>$clubid));
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($clubentity);exit;
        $array=array();
        
        $myfrnds = $this->container->get('security.context')->getToken()->getUser()->getFriendsWithMe();
      
        foreach($myfrnds as $frnds)
        {
            array_push($array,$frnds->getId());
        }
        $countArray=array();
        foreach($clubentity as $entity)
        {   
            $studentId=$entity->getStudentId()->getId();
           
            if (in_array($studentId, $array, TRUE))
            {
                array_push($countArray,$studentId);
            }
            
          
        }
       // print_r($countArray);exit;
        $count=count($countArray);
        return ($count);
    }
    function getNotifications()
    {
       
        //*********************LISTING ALL NOTIFICATION************************** 
        $studentNotification = $this->em->getRepository('BundleAdminBundle:KidskulaNotification')->findBy(array('toUser' => $this->container->get('security.context')->getToken()->getUser(),'seenByUser'=>0),array('id' => 'DESC'));
	 
        $notification_count = count($studentNotification);
        return ($studentNotification);
        //********************************************************** 
    }
    
    function getMessages()
    {
       
        //*********************LISTING ALL NOTIFICATION************************** 
        $messageNotification = $this->em->getRepository('BundleAdminBundle:KidskullaMessaging')->findBy(array('touser' => $this->container->get('security.context')->getToken()->getUser(),'seenbyuser'=>2),array('id' => 'DESC'));
	 
        $messageNotification_count = count($messageNotification);
        return ($messageNotification);
        //********************************************************** 
    }
    
    
    
    function getClubNotifications($viewed) 
    {
        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        //*********************LISTING ALL NOTIFICATION************************** 
        if($viewed!=''){
        $array = unserialize($viewed);
	    if (in_array($user, $array)) {
        $viewed=1;
        }
        else{
        $viewed=0;   
        }
        }else{$viewed=0;}
        return ($viewed);
        //********************************************************** 
    }
    function getUserProfileDetails($userid)
    {
       
        
        $studentprofiledetails = $this->em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser' => $userid));
       // echo '<pre>';
       //\Doctrine\Common\Util\Debug::dump($studentprofiledetails);exit;
        return ($studentprofiledetails);
       
    }
    function getUsers($userid)
    {
       
        
        $studentdetails = $this->em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('id' => $userid));
       // echo '<pre>';
      // \Doctrine\Common\Util\Debug::dump($studentdetails);exit;
        return ($studentdetails);
       
    }
//put your code here
}
