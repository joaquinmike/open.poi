<?php

namespace Util\Common;

use Zend\Mail\Message;
use Zend\Mime\Part;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Util\Common\EmailTemplate;

class Email
{
    const LOGIGAL = 1;
    const APPLICATION = 2;
        
    private $emails;
    private $config;
           
    private static $instance;
    
    /**
     *
     * @var \Zend\Mail\Transport\Smtp 
     */
    public $smtp;    
    public $emailTemplate;
    public $domain;
    
    public function __construct($config) 
    {                
        $this->config = $config['mail'];
        $this->emails = $config['emails'];
        $this->domain = $config['view_manager']['base_path'];        
        $this->emailTemplate = new EmailTemplate();
        
        $this->setSmtp();    
    }

    private static function _getInstance()
    {
        $config = \Util\Common\Config::get();
        
        if (is_null(static::$instance)) {
            static::$instance = new Email($config);
        }
        
        return static::$instance;
    }
    
    /**
     * Envia un mensaje para reportar un error lógico en el sistema al administrador.
     * y a los desarroladores.
     * 
     * @param Exception $e
     * @param String $subject
     * 
     * @return void
     * 
     */       
    public static function reportException(\Exception $e, $type = 2, $subject = '')
    {
        $emailService = self::_getInstance();

        $body = '';
        $key = '';

        switch ($type) {
            case self::LOGIGAL:
                $body = $emailService->emailTemplate->getLogicalExceptionTemplate($e);
                $key = 'Logical';
                break;
            case self::APPLICATION:
                $body = $emailService->emailTemplate->getApplicationExceptionTemplate($e);
                $key = 'Exception';
                break;
        }

        if ($subject == '') {                        
            $subject = $emailService->domain . " [$key]";
            $subject .= isset($emailService->config['subject']) ? $emailService->config['subject'] : " Error en la aplicación.";
        }
        
        $emailService->send($subject, $body, $emailService->emails['admin'], true, $emailService->emails['developers']);
    }
    /**
     * Envia un mensaje para reportar un debug en casos especificos de debug.
     * 
     * @param Array $data
     * @param Exception $e | null
     * @param String $subject
     * 
     * @return void
     * 
     */
    public static function reportDebug($data, \Exception $e = null, $subject = '')
    {
        $config = \Util\Common\Config::get();

        if (!$config['error']['internal_debug']) {
            return;
        }

        $emailService = self::_getInstance();

        if ($subject == '') {
            $subject = $emailService->domain . ' [Debug]';
            $subject .= isset($emailService->config['subject']) ? $emailService->config['subject'] : " Error en la aplicación.";
        } else {
            $newSubject = $emailService->domain . ' ' . $subject;
            $subject = $newSubject;
        }
 
        $body = $emailService->emailTemplate->getDebugTemplate($data, $e);

        $emailService->send($subject, $body, $emailService->emails['admin'], true, $emailService->emails['developers']);
    }
    /**
     *  Envia un correo de caracter particular a una direccion especifica.
     *  
     * @param String $subject Nombre del correo
     * @param String $body Cuerpo del correo
     * @param String|Array $to Para quien va el correo
     * @param bool $html (Opcional) Soporte de mensaje HTML (false)
     * @param String|null $bcc (Opcional) Copias ocultas (correo1, correo2, correo3)
     * @param String|null $fromName (Opcional) Nombre del remitente
     *  @param String|null $fromEmail (Opcional) Email del remitente
     * 
     * @return void
     */
    public static function send($subject, $body, $to, $html = false, $bcc = null, $fromName = null, $fromEmail = null)
    {        
        $emailService = self::_getInstance();
                
        $message = new Message();
        $message->addTo($to);
        $message->setSubject($subject);

        $emailService->setBcc($message, $bcc);

        $emailService->setFrom($message, $fromEmail, $fromName);

        $emailService->setBody($message, $body, $html);

        $emailService->smtp->send($message);                
    }

    public function setSmtp()
    {        
        $this->smtp = new Smtp();
        $this->smtp->setOptions(new SmtpOptions($this->config['transport']['options']));
    }

    public function setBcc(Message $message, $bcc)
    {
        if (!empty($bcc)) {
            $bccs = explode(',', $bcc);

            foreach ($bccs as $email) {
                $message->addBcc(trim($email));
            }
        }
    }

    public function setFrom(Message $message, $fromEmail = null, $fromName = null)
    {
        if ($fromEmail == null) {
            $message->setFrom($this->config['fromEmail'],
                $this->config['fromName']);
        } else {
            $message->setFrom($fromEmail,
                $fromName);
        }        
    }

    public function setBody(Message $message, $textBody, $html)
    {
        if ($html) {
            $body = new Part($textBody);
            $body->type = 'text/html';
        } else {
            $body = new Part($textBody);
            $body->type = 'text/plain';
        }

        $mimeMessage = new MimeMessage();
        $mimeMessage->setParts(array($body));

        $message->setBody($mimeMessage);
    }   
}