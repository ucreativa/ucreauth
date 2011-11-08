<?php
/**
 * mail.php
 *
 * A (very) simple mailer class written in PHP.
 *
 * @author Zachary Fox
 * @version 1.0
 */

class cls_Mail{
    var $to = null;
    var $from = null;
    var $subject = null;
    var $body = null;
    var $headers = null;

     function ZFmail($to,$from,$subject,$body){
        $this->to      = $to;
        $this->from    = $from;
        $this->subject = $subject;
        $this->body    = $body;
    }

    function send(){
      $this->addHeader('From: '.$this->from."\r\n");
        $this->addHeader('Reply-To: '.$this->from."\r\n");
        $this->addHeader('Return-Path: '.$this->from."\r\n");
        $this->addHeader('X-mailer: mail 1.0'."\r\n");
        mail($this->to,$this->subject,$this->body,$this->headers);
    }

    function addHeader($header){
        $this->headers .= $header;
    }

}
?>