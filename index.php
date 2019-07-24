<?php
    //definindo constante para o nome do arquivo
    define('ARQUIVO','contatos.json');


    //função para validar dados do post
    function errosNoPost(){
        $erros = [];
        if(!isset($_POST['nome']) || $_POST['nome']==''){
            $erros[] = 'errNome';
        }
        if(!isset($_POST['email']) || $_POST['email']==''){
            $erros[] = 'errEmail';
        }
        return $erros;
    }

    //carregando o conteúdo do arquivo (string json) para uma variável
    function getContatos(){
        $json = file_get_contents(ARQUIVO);
        $contatos = json_decode($json,true);
        return $contatos;
    }

    //fucnção que adiciona contato ao json
    function addContato($nome,$email){
        //carregando os contatos
        $contatos = getContatos();

        //adicionando um novo contato ao array de contatos
        $contatos[] = [
            'nome' => $nome,
            'email' => $email
        ];
        //transformando o array de contatos numa string json
        $json = json_encode($contatos);

        //salvar os contatos no arquivo
        file_put_contents(ARQUIVO,$json);
    }

    //verificando o post
    $erros = errosNoPost();
    if($_POST){

        if(count($erros)==0){
            //adicionar contato ao arquivo json
            addContato($_POST['nome'],$_POST['email']);
        }
        else{
            $erros = [];
        }
    }
    
    $contatos = getContatos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php foreach($contatos as $c): ?>
        <ul>
            <li>
                <span><?= $c['nome']?></span> :
                <span><?= $c['email']?></span>
            </li>
        </ul>
    <?php endforeach; ?>
    
    <form action="index.php" method="post">
        <input <?= (in_array('errNome',$erros)?'style="border:1px solid red"':''); ?> type="text" name="nome" id="nome" placeholder="Digite o nome">
        <input type="email" name="email" id="email" placeholder="Digite o e-mail">
        <button type="submit">Salvar</button>
    </form>

</body>
</html>