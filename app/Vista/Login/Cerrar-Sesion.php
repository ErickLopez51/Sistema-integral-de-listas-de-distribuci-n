<?php
//Destruir la sesión y redireccionar al login
session_start();

session_destroy();
session_unset();

header("location:Vista/Login/Login.php");
