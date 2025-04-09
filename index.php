<?php

    require_once("config.php");
   
    //Carrega 1 usuario
    //$root = new Usuario();
    //$root->loadById(3);
    //echo $root;

    //carrega uma lista de usuarios
    //$lista = Usuario::getList();
    //echo json_encode($lista);

    //carrega uma lista de usuarios, buscando pelo login
    //$search = Usuario::search("jo");
    //echo json_encode($search);

    //carrega um usuario usando o login e a senha
    //$usuario = new Usuario();
    //$usuario->login("vitor","torugo");
    //echo $usuario;

    //Criando um novo usuario
    //$aluno = new Usuario("aluno4","teste#3asdaga");
    //$aluno->insert();
    //echo $aluno;

    $usuario = new Usuario();
    $usuario->loadById(8); // Carrega o usuário com ID 8
    $usuario->update("naruto", "novasenha"); // Agora o ID está definido

    echo $usuario;

?>