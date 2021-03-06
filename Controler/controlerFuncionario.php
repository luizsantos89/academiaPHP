<?php
    //require_once('../includes/conexao.inc');
    //require_once('../classes/Funcionario.php');
    require_once('../Model/FuncionarioDAO.php');    
    session_start();

    if(!isset($_REQUEST['opcao'])) {
        Header("location:../index.php");
    }
    
    $opcao = (int)$_REQUEST['opcao'];

    //Lista todos os funcionarios
    if($opcao == 1){
        $funcionarioDAO = new FuncionarioDAO();

        $lista = $funcionarioDAO->getFuncionarios();

        $_SESSION['funcionarios'] = $lista;

        header("Location:../exibirFuncionarios.php");
    }    
    

    //Lista funcionario por ID
    if($opcao == 2){
        $id = $_REQUEST["id"];
                
        $funcionarioDAO = new FuncionarioDAO();

        $_SESSION['funcionario'] =  $funcionarioDAO->getFuncionarioByID($id);

        header("Location:../EditarFuncionario.php");
    }
    
    //Editar funcionario
    if($opcao == 3){
        $funcionario = new Funcionario();
        $funcionario->idFuncionario = (int) $_REQUEST["idFuncionario"];        
        $funcionario->nome = $_REQUEST["nome"];
        $funcionario->email = $_REQUEST["email"];
        $funcionario->usuario = $_REQUEST["usuario"];
        $funcionario->senha = $_REQUEST["senha"];
        $funcionario->cpf = $_REQUEST["cpf"];
        $funcionario->dataAdmissao = $_REQUEST["dataAdmissao"];
        if ($_REQUEST["operacao"] == "demissao") {
            date_default_timezone_set('America/Sao_Paulo');
            $funcionario->dataDemissao = date('Y-m-d H:i:s');
        }
        
        
        $funcionarioDAO = new FuncionarioDAO();

        $funcionarioDAO->editarFuncionario($funcionario);

        header("Location:controlerFuncionario.php?opcao=1");
    }
    
    //Cadastrar funcionario
    if ($opcao == 4){
        $funcionario = new Funcionario();       
        $funcionario->nome = $_REQUEST["nome"];
        $funcionario->email = $_REQUEST["email"];
        $funcionario->usuario = $_REQUEST["usuario"];
        $funcionario->senha = md5($_REQUEST["senha"]);
        $funcionario->cpf = $_REQUEST["cpf"];
        date_default_timezone_set('America/Sao_Paulo');
        $funcionario->dataAdmissao = date('Y-m-d H:i:s');
                
        $funcionarioDAO = new FuncionarioDAO();
        $funcionarioDAO->incluirFuncionario($funcionario);

        header("Location:controlerFuncionario.php?opcao=1");
    }