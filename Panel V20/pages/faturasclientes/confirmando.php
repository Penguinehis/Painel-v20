<?php
require_once('../../pages/system/seguranca.php');
require_once('../../pages/system/config.php');
require_once('../../pages/system/funcoes.php');
require_once('../../pages/system/classe.ssh.php');

protegePagina("user");

if(isset($_POST['fatura'])){//posts
$idfatura=anti_sql_injection($_POST['fatura']);
$nota=anti_sql_injection($_POST['msg']);
$forma=anti_sql_injection($_POST['formap']);
$arquivo=$_FILES['arquivo'];

$SQLUPUser= "SELECT * FROM fatura where id='".$idfatura."'";
$SQLUPUser = $conn->prepare($SQLUPUser);
$SQLUPUser->execute();
$conta=$SQLUPUser->rowCount();
if($conta==0){
        echo '<script type="text/javascript">';
		echo 	'alert("Fatura n�o encontrada!");';
		echo	'window.location="home.php?page=faturas/confirmar&id='.$idfatura.'";';
		echo '</script>';
		exit;
}
$fatu=$SQLUPUser->fetch();
if($fatu['usuario_id']<>$_SESSION['usuarioID']){
        echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura n�o � sua!");';
		echo	'window.location="home.php?page=faturas/abertas";';
		echo '</script>';
		exit;

}
if($fatu['status']=='cancelado'){
        echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura est� vencida ou expirada!");';
		echo	'window.location="home.php?page=faturas/canceladas";';
		echo '</script>';
		exit;

}
if($fatu['status']=='pago'){
        echo '<script type="text/javascript">';
		echo 	'alert("Esta fatura est� paga!");';
		echo	'window.location="home.php?page=faturas/pagas";';
		echo '</script>';
		exit;

}

//busca comprovantes abertos

$faturacp= "SELECT * FROM fatura_comprovantes where fatura_id='".$idfatura."' and usuario_id='".$_SESSION['usuarioID']."' and status='aberto'";
$faturacp = $conn->prepare($faturacp);
$faturacp->execute();
$contafaturacp=$faturacp->rowCount();

if($contafaturacp>0){
        echo '<script type="text/javascript">';
		echo 	'alert("J� possui uma confirma��o para esta Fatura em andamento aguarde!");';
		echo	'window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";';
		echo '</script>';
		exit;

}

//Upload

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '../../admin/pages/faturas/comprovantes/';
// Tamanho m�ximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extens�es permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif');
// Renomeia o arquivo? (Se true, o arquivo ser� salvo como .jpg e um nome �nico)
$_UP['renomeia'] = true;
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = '<script type="text/javascript">alert("N�o houve erro");window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";</script>';
$_UP['erros'][1] = '<script type="text/javascript">alert("O arquivo no upload � maior do que o limite do PHP");window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";</script>';
$_UP['erros'][2] = '<script type="text/javascript">alert("O arquivo ultrapassa o limite de tamanho especifiado no HTML");window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";</script>';
$_UP['erros'][3] = '<script type="text/javascript">alert("O upload do arquivo foi feito parcialmente");window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";</script>';
$_UP['erros'][4] = '<script type="text/javascript">alert("N�o foi feito o upload do arquivo");window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";</script>';
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
  die("" . $_UP['erros'][$_FILES['arquivo']['error']]);
  exit; // Para a execu��o do script
}
// Caso script chegue a esse ponto, n�o houve erro com o upload e o PHP pode continuar
// Faz a verifica��o da extens�o do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
  echo '<script type="text/javascript">';
  echo 	'alert("Por favor, envie arquivos com as seguintes extens�es: jpg, png ou gif");';
  echo	'window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";';
  echo '</script>';
  exit;
}
// Faz a verifica��o do tamanho do arquivo
if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
   echo '<script type="text/javascript">';
   echo 'alert("O arquivo enviado � muito grande, envie arquivos de at� 2Mb.");';
   echo	'window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";';
   echo '</script>';
   exit;
}
// O arquivo passou em todas as verifica��es, hora de tentar mov�-lo para a pasta
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
  // Cria um nome baseado no UNIX TIMESTAMP atual e com extens�o .jpg
  $nome_final = md5(time()).'.jpg';
} else {
  // Mant�m o nome original do arquivo
  $nome_final = $_FILES['arquivo']['name'];
}

// Depois verifica se � poss�vel mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {

switch($forma){case 1:$formapagto='boleto';break;
case 2:$formapagto='deptra';break;
default:$formapagto='boleto';break;
}
if($nota==''){$nota="N/d";}else{$nota=$nota;}
$data=date('Y-m-d H:i:s');

$inserecp= "INSERT INTO fatura_comprovantes (fatura_id,usuario_id,data,formapagamento,nota,imagem) values ('".$idfatura."','".$_SESSION['usuarioID']."','".$data."','".$formapagto."','".$nota."','".$nome_final."')";
$inserecp = $conn->prepare($inserecp);
$inserecp->execute();



  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
        echo '<script type="text/javascript">';
		echo 	'alert("Enviado com sucesso! Aguarde um prazo de at� 4 horas");';
		echo	'window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";';
		echo '</script>';
} else {
  // N�o foi poss�vel fazer o upload, provavelmente a pasta est� incorreta
    echo '<script type="text/javascript">';
		echo 	'alert("N�o foi possivel enviar o arquivo tente novamente!");';
		echo	'window.location="../../home.php?page=faturas/confirmar&id='.$idfatura.'";';
		echo '</script>';
}

//fim








}else{echo "teste";}