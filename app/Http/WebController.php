<?php

namespace App\Http;

use App\Models\User;

class WebController
{
    /**
     * Método responsável por gerar a página principal
     *
     * @return view|array
     */
    public function home()
    {
        $url = URL_BASE;
        $users = new User();
        $list = $users->find()->fetch(true);
        require __DIR__."/../../views/home.php";
    }

    /**
     * Armazenando registros no banco de dados.
     *
     * @return json
     */
    public function store()
    {   

        //Validando campos obrigatorios
        if (isset($_POST['nome']) && trim($_POST['nome']) !== "" && isset($_POST['sobreNome']) && trim($_POST['sobreNome']) !== ""
            && isset($_POST['telefone']) && trim($_POST['telefone']) !== "") {
            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobreNome'];
            $telefone = $_POST['telefone'];
            
        } else {
            $retorno = "Campos inválidos!";
            header('location: '.URL_BASE."?retorno=$retorno");
            exit();
        }
        
        //Campos opcionais
        $cpf = $_POST['cpf']; 
        $email = null;
        $segundoEmail = null;
        $segundoTelefone = null;

        //Validação de CPF
        if (strlen($cpf) > 0 ) {

            // Extrai somente os números
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
            
            // Verifica se foi informado todos os digitos corretamente
            if (strlen($cpf) != 11) {
                $retorno = "<p class='vermelho'>CPF inválido!</p>";
                header('location: '.URL_BASE."?retorno=$retorno");
                exit();
            }
            // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                $retorno = "<p class='vermelho'>CPF inválido!</p>";
                header('location: '.URL_BASE."?retorno=$retorno");
                exit();
            }
            // Faz o calculo para validar o CPF
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $retorno = "<p class='vermelho'>CPF inválido!</p>";
                    header('location: '.URL_BASE."?retorno=$retorno");
                    exit();
                }
            }
        }

        if (strlen($_POST['segundoTelefone']) > 0) {
            $segundoTelefone = $_POST['segundoTelefone'];
        }

        //Validando e-mail
        if (strlen($_POST['email']) > 0) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $retorno = "<p class='vermelho'>E-mail inválido!</p>";
                header('location: '.URL_BASE."?retorno=$retorno");
                exit();
            }
        } 

        //Validando segundo e-mail
        if (strlen($_POST['segundoEmail']) > 0 ) {
            $segundoEmail = $_POST['segundoEmail'];
            if (!filter_var($segundoEmail, FILTER_VALIDATE_EMAIL)) {
                $retorno = "<p class='vermelho'>E-mail inválido!</p>";
                header('location: '.URL_BASE."?retorno=$retorno");
                exit();
            }
        }
        $user = new User();
        $user->nome = $nome;
        $user->sobrenome = $sobreNome;
        $user->cpf = $cpf;
        $user->telefone = $telefone;
        $user->segundo_telefone = $segundoTelefone;
        $user->email = $email;
        $user->segundo_email = $segundoEmail;
        $user->save();

        $retorno = "<p class='verde'>Contato criado com sucesso!</p>";
        header('location: '.URL_BASE."?retorno=$retorno");
        exit();
    }

    /**
     * Método responsável pela atualização de registros
     *
     * @param [array] $id
     * @return view
     */
    public function update($id)
    {
         //Validando campos obrigatorios
        if (isset($_POST['nome']) && trim($_POST['nome']) !== "" && isset($_POST['sobreNome']) && trim($_POST['sobreNome']) !== ""
            && isset($_POST['telefone']) && trim($_POST['telefone']) !== "") {
            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobreNome'];
            $telefone = $_POST['telefone'];
            
        } else {
            $retornoEditar = "<p class='vermelho'>Campos inválidos!</p>";
            header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
            exit();
        }
        
        //Campos opcionais
        $cpf = $_POST['cpf']; 
        $email = $_POST['email'];
        $segundoEmail = $_POST['segundoEmail'];
        $segundoTelefone = $_POST['segundoTelefone'];
        
        //Validação de CPF
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            $retornoEditar ="<p class='vermelho'>CPF inválido!</p>";
            header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
            exit();
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $retornoEditar ="<p class='vermelho'>CPF inválido!</p>";
            header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
            exit();
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                $retornoEditar = "<p class='vermelho'>CPF inválido!</p>";
                header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
                exit();
            }
        }


        if (strlen($_POST['segundoTelefone']) > 0) {
            $segundoTelefone = $_POST['segundoTelefone'];
        }

        //Validando e-mail
        if (strlen($_POST['email']) > 0) {
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $retornoEditar = "<p class='vermelho'>E-mail inválido!</p>";
                header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
                exit();
            }
        } 

        //Validando segundo e-mail
        if (strlen($_POST['segundoEmail']) > 0 ) {
            $segundoEmail = $_POST['segundoEmail'];
            if (!filter_var($segundoEmail, FILTER_VALIDATE_EMAIL)) {
                $retornoEditar = "<p class='vermelho'>E-mail inválido!</p>";
                header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
                exit();
            }
        }
        $user = (new User())->findById($id["id"]);
        $user->nome = $nome;
        $user->sobrenome = $sobreNome;
        $user->cpf = $cpf;
        $user->telefone = $telefone;
        $user->segundo_telefone = $segundoTelefone;
        $user->email = $email;
        $user->segundo_email = $segundoEmail;
        $user->save();

        $retornoEditar = "<p class='verde'>Contato editado com sucesso!</p>";
        header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
        exit();
    }

    /**
     * Método responsável por retornar algum registro de pesquisa 
     *
     * @return string
     */
    public function find($search)
    {
        if ($search['search'] == '') {
            $user = (new User())->find()->fetch(true);
            echo json_encode($user);
        }

        $user = (new User())->find("nome LIKE '%".$search['search']."%' OR NOT EXISTS(SELECT * FROM users)")->fetch(true);
        echo json_encode($user);
           
    }

    /**
     * Método responsável pela deleção de registros
     *
     * @param [array] $id
     * @return view
     */
    public function delete($id)
    {
        $user = (new User())->findById($id["id"]);

        if ($user) {
            $user->destroy();
        } 
        
        $retornoEditar = "<p class='verde'>Contato excluido com sucesso!</p>";
        header('location: '.URL_BASE."?retornoEditar=$retornoEditar");
        exit();
    }

    /**
     * Tratamento de erro de rotas.
     *
     * @param [string] $data
     * @return string
     */
    public function error($data)
    {
        echo "<h1>Erro {$data['errcode']}</h1>";
    }
}