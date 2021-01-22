<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require_once ("$root/sild/app/Modelo/ChatModelo.php");
require_once ("$root/sild/app/Librerias/Helps.php");

/**
 * 
 */
class ChatController
{

  private $modelo;
  public function __construct()
  {
         //Iniciar una sesión
    session_start();

    $this->modelo = new ChatModelo();
  }


  public function MainChat()
  {

   require_once 'Vista/Chat/MainChat.php'; 
 
 }
}