<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Cadastro de contatos</title>
    <style>
        .verde{
            color: green;
        }
        .vermelho{
            color: red;
        }
    </style>
</head>
<body class="bg-light">
    <header>
        <div class="container">
            <div class="row bg-black rounded">
                <h1 class="text-light">Contatos</h1>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-4">
            <form class="row g-3"action="<?= $url; ?>" method="POST">
                <input type="hidden" id="url" value="<?php URL_BASE ?>">
                <h5>Criar contato novo</h5>
                <div class="col-md-4">
                    <label for="nome">Nome<span>*</span></label>
                    <input type="text" class="form-control form-control-sm" id="nome" name="nome" aria-describedby="emailHelp" placeholder="" >  
                </div>
                <div class="col-md-4">
                    <label for="sobreNome">Sobrenome<span>*</span></label>
                    <input type="text" class="form-control form-control-sm" id="sobreNome" name="sobreNome" aria-describedby="emailHelp" placeholder="" required>  
                </div>
                <div class="col-md-4">
                    <label for="telefone">Telefone<span>*</span></label>
                    <input type="tel" class="form-control form-control-sm telefone" id="telefone" name="telefone" aria-describedby="emailHelp" placeholder="">  
                </div>
                <div class="col-md-4">
                    <label for="segundoTelefone">Segundo telefone</label>
                    <input type="tel" class="form-control form-control-sm telefone" id="segundoTelefone" name="segundoTelefone" aria-describedby="emailHelp" placeholder="">  
                </div>
                <div class="col-md-4">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control form-control-sm" id="email" name="email" aria-describedby="emailHelp" placeholder="">
                </div>
                <div class="col-md-4">
                    <label for="segundoEmail">Segundo e-mail</label>
                    <input type="email" class="form-control form-control-sm" id="segundoEmail" name="segundoEmail" aria-describedby="emailHelp" placeholder="">
                </div>
                <div class="col-md-4">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control form-control-sm cpf" id="cpf" name="cpf" aria-describedby="emailHelp" placeholder="">  
                </div>
                <div class="col-md-4 mt-4">
                    <button type="submit" class="btn btn-success mt-2">Salvar</button>
                </div>
            </form>
            <div class="retorno mt-4">
                <?php $retorno = (isset($_GET["retorno"]) ? $_GET["retorno"] : ""); echo $retorno; ?>
            </div>
        </div>
        
        <div class="table-responsive p-5">
        <h5>Gerenciar Contatos</h5>
            Buscar contato
            <input type="text" id="buscando" name="buscando" class="form-control">
            <?php $retornoEditar = (isset($_GET["retornoEditar"]) ? $_GET["retornoEditar"] : ""); echo $retornoEditar; ?>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Nome<span>*</span></th>
                    <th scope="col">Sobrenome<span>*</span></th>
                    <th scope="col">Telefone<span>*</span></th>
                    <th scope="col">Segundo telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Segundo e-mail</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Opções</th>
                    </tr>
                </thead>
                <tbody id="tabela">

                    <?php if ($list) {
                         foreach ($list as $userItem) {        
                    ?>
                    <tr>
                    <form action="<?= $url . $userItem->id; ?>" method="POST">
                    <td><input class="form-control" type="text" value="<?= $userItem->nome ?>" name="nome" required></td>
                    <td><input class="form-control" type="text" value="<?= $userItem->sobrenome ?>" name="sobreNome" required></td>
                    <td><input class="form-control telefone" type="tel"  value="<?= $userItem->telefone ?>" name="telefone" required></td>
                    <td><input class="form-control telefone" type="tel"  value="<?= $userItem->segundo_telefone ?>" name="segundoTelefone"></td>
                    <td><input class="form-control" type="email" value="<?= $userItem->email ?>" name="email"></td>
                    <td><input class="form-control" type="email" value="<?= $userItem->segundo_email ?>" name="segundoEmail"></td>
                    <td><input class="form-control cpf" type="text" value="<?= $userItem->cpf ?>" name="cpf"></td>
                    <td><input type="hidden" name="_method" value="PUT"><button type="submit" class="btn btn-primary">Editar</button></form></td>
                    <td><form action="<?= $url . $userItem->id; ?>" id="delete" method="POST">
                    <input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger">Excluir</button></form></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>  
    </main>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<script>
const URL_BASE = $("#url").val()

$(document).ready(function(){
    mascara()
})

$("#buscando").keyup(function(){
    var search = $("#buscando").val()
    $.ajax({
        url: URL_BASE + 'search/' + search,
        type: 'GET',
        dataType: 'json',
        contentType: 'application/json; charset=utf-8',
        success: function(data) {
            console.log(data)
            $("#tabela").empty()
            if (data) {
                for (i = 0; i < data.length; i++ ){
                    $("#tabela").append(
                        '<tr>'+
                        '<td><form action="'+URL_BASE+data[i].id+'" method="POST" id="editar'+data[i].id+'"><input type="hidden" name="_method" value="PUT"></form>'+
                        '<input class="form-control" form="editar'+data[i].id+'" type="text" value="'+data[i].nome+'" name="nome" required></td>'+
                        '<td><input class="form-control" form="editar'+data[i].id+'" type="text" value="'+data[i].sobrenome+'" name="sobreNome" required></td>'+
                        '<td><input class="form-control telefone" form="editar'+data[i].id+'" type="tel" value="'+data[i].telefone+'" name="telefone" required></td>'+
                        '<td><input class="form-control telefone" form="editar'+data[i].id+'" type="tel" value="'+data[i].segundo_telefone+'" name="segundoTelefone"></td>'+
                        '<td><input class="form-control" form="editar'+data[i].id+'" type="email" value="'+data[i].email+'" name="email"></td>'+
                        '<td><input class="form-control" form="editar'+data[i].id+'" type="email" value="'+data[i].segundo_email+'" name="segundoEmail"></td>'+
                        '<td><input class="form-control cpf" form="editar'+data[i].id+'" type="text" value="'+data[i].cpf+'" name="cpf"></td>'+
                        '<td><input form="editar'+data[i].id+'" type="submit" value="Editar"class="btn btn-primary"></td>'+
                        '<td><form action="'+URL_BASE+data[i].id+'" id="delete" method="POST">'+
                        '<input type="hidden" name="_method" value="DELETE"><button type="submit" class="btn btn-danger">Excluir</button></form></td>'+
                        '</tr>')
                }mascara()
            } else {
                $("#tabela").html(
                    '<tr><td>Não encontrado</td></tr>'
                )
            }
           
            
        }
    })
})

function mascara(){
var cpf = $(".cpf")
    cpf.mask('000.000.000-00', {reverse: true})
var telefone = $(".telefone")
    telefone.mask("(99) 99999-9999")
}
</script>