<?php

namespace Bundle\AdminBundle\Manager;

class MailerService {

	//put your code here

	private $em,$container ,$router,$templating,$twig,
	 $confirmation,$resetting;
	 
	 private $sendingtemplate='sdf:asd';


	function __construct( $em, $container, $router,$templating,$twig,$templatArray) {
	
		$this->em = $em;
		$this->router = $router;
		$this->container = $container;		
		$this->templating=$templating;
		$this->twig=$twig;
		$this->confirmation=$templatArray['template']['confirmation'];
		$this->resetting=$templatArray['template']['resetting'];		
	}

	/**
	 * @param string $templateName
	 * @param array  $context
	 * @param string $fromEmail
	 * @param string $toEmail
	 */
	public function sendMail($context, $fromEmail, $toEmail,$templateName=null) {
		
		if(!empty($templateName)){		
		   	$this->sendingtemplate=$this->$templateName;			
		}
        
		$template = $this->twig->loadTemplate($this->sendingtemplate); 			
		$mail_subject = $context['subject'];
		
		$header = $template->renderBlock('header', $context);
		$subject = $template->renderBlock('subjectmail', $context);
		$content = $template->renderBlock('content', $context);
		$footer = $template->renderBlock('footer', $context);
		$message = $header . $subject. $content . $footer;

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		if (empty($fromEmail)) {
			$fromEmail = $this->container->getParameter('from_email');
		}

		// More headers
		$headers .= 'From: <' . $fromEmail . '>' . "\r\n";
		/*$headers .= 'Cc: sibnath.wgt@gmail.com' . "\r\n";*/

		@mail($toEmail, $mail_subject, $message, $headers);

		return 1;
	}
	
}
