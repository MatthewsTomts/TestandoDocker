<?php 
session_start();
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');


// Solicitando o arquivo do banco
require_once '../database/conn.php';

// Função para verificar a sessão
function verificaSessao($token){

    // Verificando se as variáveis de sessão existem
    if(isset($_SESSION['token']) AND isset($_SESSION['cargo'])) {

        /*
            Verificando se o Hash do token é igual ao hash salvo na variável de sessão do PHP
            Verificando se o cargo salvo na sessão bate com a validação certa
            
        */
        if ($token === $_SESSION['token'] AND $_SESSION['cargo'] == 'funcionario') {

            echo json_encode(['autenticado' => true]);
    
        } else {
    
            echo json_encode(['autenticado' => false]);
    
        }
    

    } else {
        echo json_encode(['autenticado' => false]);
    }

    
}

// Verificando o tipo de requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Pegando o corpo da requisição
    $json = file_get_contents('php://input');

    // Convertendo o corpo json em objeto
    $dados = json_decode($json, true);

    // Verificar se o JSON é válido
    if ($dados === null) {
        $resposta = [
            'msgErro' => 'Usuário não autenticado'
        ];

        echo json_encode($resposta);

    } else {
        // Verificando se a sessão de login é válido
        verificaSessao($dados['token']);
    }

} else {

    echo json_encode(['msgErro' => 'Algo deu errado...']);

}
?>