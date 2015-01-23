<?php

namespace Orderly\PayPalIpnBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Orderly\PayPalIpnBundle\Ipn;
use Orderly\PayPalIpnBundle\Event as Events;
use Vet\AdminBundle\Entity\VetcommPaymenthistory;
use Symfony\Component\HttpFoundation\Request;

/*
 * Copyright 2012 Orderly Ltd 
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 *  Sample listener controller for IPN messages with twig email notification
 */
class TwigNotificationEmailController extends Controller
{
    
    public $paypal_ipn;
    /**
     * @Route("/ipn-twig-email-notification", name="paypal_ipn_orderly_bundle")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        //getting ipn service registered in container
        $this->paypal_ipn = $this->get('orderly_pay_pal_ipn');

        $em = $this->getDoctrine()->getManager();
        $payinfo=$_REQUEST;
        $payinfo=json_encode($payinfo);
        $payer_id=$request->get('payer_id');
        $custom=$request->get('custom');


        $txn_id=$request->get('txn_id');
        $custom=json_decode($custom,true);
        $plan=$custom['planid'];
        $userid=$custom['userid'];
        $userasarray = $this->get('vet_usermanager')->getcurrentuserasarray($userid);
        $userinfo=json_encode($userasarray);

               

        //validate ipn (generating response on PayPal IPN request)
        if ($this->paypal_ipn->validateIPN())
        {
            // Succeeded, now let's extract the order
            $this->paypal_ipn->extractOrder();

            // And we save the order now (persist and extract are separate because you might only want to persist the order in certain circumstances).
            $this->paypal_ipn->saveOrder();

            $status=$this->paypal_ipn->getOrderStatus();


            $useremail=$userasarray['email'];
            $payer_email=$request->get('payer_email');
            $payer_status=$request->get('payer_status');
            //get the plan entity
            $query = $em->createQueryBuilder()
                ->select('p')
                ->from('VetAdminBundle:VetcommEmplyeepackage', 'p')
                ->where('p.id = :id')
                ->setParameter('id', $plan)
                ->getQuery();

            $entityplan = $query->getSingleResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY);
            //preparre for inserting it in history table in json format
            $package_info=json_encode($entityplan);
            $price=$entityplan['price'];
            $description=$entityplan['title'];

            $VetcommPaymenthistory=new VetcommPaymenthistory();
            //Create payment information with user details and package
            $VetcommPaymenthistory->setStatus($status);
            $VetcommPaymenthistory->setVerifieddate(date('Y-m-d H:i:s'));
            $VetcommPaymenthistory->setPayerTxToken($txn_id);
            $VetcommPaymenthistory->setPayerEmail($payer_email);
            $VetcommPaymenthistory->setTransactionverified(1);
            $VetcommPaymenthistory->setPackageInfo($package_info);  // Store package info as json encoded
            $VetcommPaymenthistory->setPayerAmount($price);
            $VetcommPaymenthistory->setPayerItemname($description);
            $VetcommPaymenthistory->setUserInfo($userinfo);
            $VetcommPaymenthistory->setOrderId($txn_id);
            $VetcommPaymenthistory->setPayinfo($payinfo);
            $em->persist($VetcommPaymenthistory);
            $em->flush();


            // Now let's check what the payment status is and act accordingly
            if ($this->paypal_ipn->getOrderStatus() == Ipn::PAID)
            {


                //Add credit to user
                $user=$em->getRepository('VetAdminBundle:VetcommUsers')->find($userid);
                $this->get('vet_payment')->createPayment($VetcommPaymenthistory,$user,$entityplan);

                if($userasarray['email']==$payer_email){

                    //If paypal email is same as user
                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $userasarray['email']);
                }else{
                    //If paypal email is not same as user send invoice to both
                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $userasarray['email']);

                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $payer_email);

                }



            }else{

                if($userasarray['email']==$payer_email){

                    //If paypal email is same as user
                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $userasarray['email']);
                }else{
                    //If paypal email is not same as user send invoice to both
                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $userasarray['email']);

                    $this->get('vet_mailservice')
                        ->sendMessage('VetRecruiterBundle:User:invoice.txt.twig', array('user' => $userasarray, 'package' => $entityplan,
                                'order' => $VetcommPaymenthistory
                            , 'subject' => 'Invoice from Vetcommander','status'=>$status)
                            , null, $payer_email);

                }

            }
        }
        else // Just redirect to the root URL
        {

            return $this->redirect('/');
        }
        $this->triggerEvent(Events\PayPalEvents::RECEIVED);

        $response = new Response();
        $response->setStatusCode(200);
        
        return $response;
    }

    private function triggerEvent($event_name) {
        $dispatcher = $this->container->get('event_dispatcher');
        $dispatcher->dispatch($event_name, new Events\PayPalEvent($this->paypal_ipn));
    }
}
