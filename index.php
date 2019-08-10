<?php
try{
    $pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost", "root", "");

} catch(PDOException $e){
    echo "ERRO: ".$e->getMessage();
    exit;
}

if(isset($_POST['nome']) && !empty($_POST['nome'])){
    $nome = $_POST['nome'];
    $mensagem = $_POST['mensagem'];

    $sql = $pdo->prepare("INSERT INTO mensagens SET nome= :nome, msg= :msg, data_msg= NOW()");
    $sql->bindValue(":nome", $nome);
    $sql->bindValue(":msg", $mensagem);
    $sql->execute();
}
?>

<fieldset>
    <form method="post">
        Nome: <br>
        <input type="text" name="nome"><br><br>

        Mensagem: <br>
        <textarea name="mensagem" cols="30" rows="10"></textarea> <br><br>

        <input type="submit" value="Enviar Mensagem">
    </form>
</fieldset>
<br><br>

<?php 
$sql = "SELECT * FROM mensagens ORDER BY data_msg DESC";
$sql = $pdo->query($sql);

if($sql->rowCount() > 0){
    foreach ($sql->fetchAll() as $mensagem):
        ?>
        <strong><?php echo $mensagem['nome'];?></strong><br>
        <?php echo $mensagem['msg'];?>
        <hr>
        <?php
    endforeach;
}else{
    echo "Nao ha mensagens.";
}

?>

