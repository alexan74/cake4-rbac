<?php 
namespace Rbac\Controller\Component;
 
Interface LoginInterface
{
    public function autenticacion($usuario, $password);

    public function getUsuario($usuario);
}