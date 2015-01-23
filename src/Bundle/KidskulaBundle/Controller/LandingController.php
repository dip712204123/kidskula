<?php
//Created By Sourav Bhowmik @4/11/2014
namespace Bundle\KidskulaBundle\Controller;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaStudentGrade;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Entity\KidsKullaschoolshaskidskulausers;
use Bundle\AdminBundle\Entity\KidsKulaUsers;

class LandingController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        		
        $search = $em->createQueryBuilder('a');
        $search->select('a')
        ->from('BundleAdminBundle:KidsKulaStudentGrade', 'a')
        ->where('a.status <> 3')
        ->orderBy('a.id', 'ASC');
        

        $query = $search->getQuery();
        $result = $query->getResult();
        //\Doctrine\Common\Util\Debug::dump($result);exit;
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT * FROM kidskula_countries ORDER BY country_name ASC");      
        $statement->execute();
        $countries = $statement->fetchAll();
        
        return $this->render('BundleKidskulaBundle:Landing:index.html.twig', array(
            'entities' => $result,
            'countries' => $countries
        ));
        
    }
     
    public function autosuggestAction()
    {   
         $request = $this->getRequest();
         $schoolname = $request->get('schoolname');
        
        //  echo $schoolname;
        //   exit;
        $em = $this->getDoctrine()->getManager();
        		
        $search = $em->createQueryBuilder('a');
        $search->select('a')
        ->from('BundleAdminBundle:KidsKullaSchools', 'a')
        ->where('LOWER(a.schoolName) like :keyword')
        ->andwhere('a.status <> 3')
        ->orderBy('a.id', 'DESC')
        ->setParameter('keyword', strtolower('%' . $schoolname . '%'));

        $query = $search->getQuery();
        $result = $query->getResult();
        $count=count($result);
        
       
       
       // \Doctrine\Common\Util\Debug::dump($count);exit;

	//$sql = "select name from ".$db_table." where ".$db_column." like '".$keyword."%' limit 0,20"; 
	//$result = mysql_query($sql) or die(mysql_error());
	if($count)
	{
		echo '<ul class="searchschoollist">';
		foreach($result as $row)
		{
			$str = $row->getSchoolName();
			$start = strpos($str,$schoolname); 
			$end   = similar_text($str,$schoolname); 
			$last = substr($str,$end,strlen($str));
			$first = substr($str,$start,$end);
			
			$final = '<span class="bold">'.$first.'</span>'.$last;
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
        exit;
    }
    
    public function frndsearchAction()
    {       
     //fetching value from landing page form @sourav
       //initialise session variable 
     $session = $this->getRequest()->getSession();

        
     $request     = $this->getRequest();
     
     if($request->request->get('firstname') !=''){
        $firstname = $request->request->get('firstname'); 
        $session->set('firstname', $firstname);
     }
     else{
        $firstname = $session->get('firstname');
      }
      
      if($request->request->get('lastname') !=''){
        $lastname = $request->request->get('lastname'); 
        $session->set('lastname', $lastname);
     }
     else{
        $lastname = $session->get('lastname');
      }
      
     if($request->request->get('schoolname') !=''){
        $schoolname = $request->request->get('schoolname'); 
        $session->set('schoolname', $schoolname);
     }
     else{
        $schoolname = $session->get('schoolname');
      }
     
      if($request->request->get('selectgrade') !=''){
        $selectgrade = $request->request->get('selectgrade'); 
        $session->set('selectgrade', $selectgrade);
     }
     else{
        $selectgrade = $session->get('selectgrade');
      }
      
      if($request->request->get('country') !=''){
        $country = $request->request->get('country'); 
        $session->set('country', $country);
     }
     else{
        $country = $session->get('country');
      }
      
     if($request->request->get('state') !=''){
        $state = $request->request->get('state'); 
        $session->set('state', $state);
     }
     else{
        $state = $session->get('state');
      }
     
      if($request->request->get('city') !=''){
        $city = $request->request->get('city'); 
        $session->set('city', $city);
     }
     else{
        $city = $session->get('city');
      }
    
      
        $em = $this->getDoctrine()->getManager();
        $category = $em->createQueryBuilder();
        $category->select('a.id','a.firstName','a.lastName','a.username') ->from('BundleAdminBundle:KidsKulaUsers', 'a')
                                   ->leftJoin('BundleAdminBundle:KidsKullaschoolshaskidskulausers', 'b','with', 'b.kidskulausersid=a.id')
                                   ->leftJoin('BundleAdminBundle:KidsKullaSchools', 'c',  'with', 'c.id=b.KidsKullaschoolsid') 
                                   
                                   ->where('LOWER(a.firstName) like :keyword') 
                                   ->andwhere('LOWER(a.lastName) like :keyword1')  
                                   ->andwhere('a.status ='. '1')
                                  // ->andwhere('LOWER(c.schoolName) like :school')
//                                   ->andwhere('c.schoolName ="' . $schoolname.'"')
//                                  ->andwhere('b.gradeId =' . $selectgrade)
//                                   ->andwhere('a.country =' . $country)
//                                   ->andwhere('a.state ="' . $state.'"')
//                                   ->andwhere('a.city ="' . $city.'"');
                                     ->setParameter('keyword', strtolower('%' . $firstname . '%'))
                                     ->setParameter('keyword1', strtolower('%' . $lastname . '%'));
                                     //->setParameter('school', strtolower('%' . $schoolname . '%'));
              
	$query = $category->getQuery();
        //print_r($query->getSql());
        //$query->getParameters(); 
        $entity =$query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
       
       // return $this->redirect($this->generateUrl('dashboard', array('entities' =>$entity)));
      // echo '<pre>';
      // \Doctrine\Common\Util\Debug::dump($entity);exit;
      
            return $this->render('BundleKidskulaBundle:Dashboard:dashboard.html.twig', array(
            'entities' => $entity
        ));
       
    }
    
}


    

