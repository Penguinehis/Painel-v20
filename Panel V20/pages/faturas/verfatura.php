<script type="text/javascript" src="//resources.mlstatic.com/mptools/render.js"></script>
<?php
require_once("pages/system/seguranca.php");
require_once ('lib/mercadopago.php');

$SQLmp = "select * from mercadopago";
$SQLmp = $conn->prepare($SQLmp);
$SQLmp->execute();
$mp=$SQLmp->fetch();

$mp = new MP ("".$mp['CLIENT_ID']."", "".$mp['CLIENT_SECRET']."");

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

if(isset($_GET['id'])){

    $fatura_id=$_GET['id'];


    $SQLUPUser= "SELECT * FROM fatura where id='".$fatura_id."'";
    $SQLUPUser = $conn->prepare($SQLUPUser);
    $SQLUPUser->execute();

    $conta=$SQLUPUser->rowCount();
    if($conta==0){
        echo '<script type="text/javascript">';
        echo 	'alert("Fatura não encontrada!");';
        echo	'window.location="home.php?page=faturas/abertas";';
        echo '</script>';

    }
    $fatu=$SQLUPUser->fetch();

    if($fatu['usuario_id']<>$_SESSION['usuarioID']){
        echo '<script type="text/javascript">';
        echo 	'alert("Esta fatura não é sua!");';
        echo	'window.location="home.php?page=faturas/abertas";';
        echo '</script>';

    }
    if($fatu['status']=='cancelado'){
        echo '<script type="text/javascript">';
        echo 	'alert("Esta fatura está vencida ou expirada!");';
        echo	'window.location="home.php?page=faturas/abertas";';
        echo '</script>';

    }
                       //Datas

    $datacriado=$fatu['data'];
    $dataconvcriado = substr($datacriado, 0, 10);
    $partes = explode("-", $dataconvcriado);
    $ano = $partes[0];
    $mes = $partes[1];
    $dia = $partes[2];

    $datavenc=$fatu['datavencimento'];
    $datanv = substr($datavenc, 0, 10);
    $partes2 = explode("-", $datanv);
    $anov = $partes2[0];
    $mesv = $partes2[1];
    $diav = $partes2[2];

// Busca usuario
    $user= "SELECT * FROM usuario where id_usuario='".$fatu['usuario_id']."'";
    $user = $conn->prepare($user);
    $user->execute();
    $usufatu=$user->fetch();

// busca servidor

    $server= "SELECT * FROM servidor where id_servidor='".$fatu['servidor_id']."'";
    $server = $conn->prepare($server);
    $server->execute();
    $servidor=$server->fetch();

// busca conta
    if($fatu['tipo']=='vpn'){
        $acc= "SELECT * FROM usuario_ssh where id_usuario_ssh='".$fatu['conta_id']."'";
        $acc = $conn->prepare($acc);
        $acc->execute();
        $conta=$acc->fetch();

    }

//valores
    $desconto1=$fatu['desconto'];
    $desconto=number_format($fatu['desconto'], 2, ',', '.');
    $valor=number_format($fatu['valor'], 2, ',', '.');
    $total=ceil(($fatu['valor']*$fatu['qtd'])-$desconto1);
    $valorfinal=$fatu['valor'];
    $total=number_format($total, 2, ',', '.');


    $total2=$fatu['valor']*$fatu['qtd'];
    $total2=number_format($total2, 2, ',', '.');
// MercadoPago
    $id=$fatu['id'];
    $decricao=$fatu['descricao'];
    $preference_data = array(
        "items" => array(
            array(
                "id" => $id,
                "title" => "Mercado Pago Inc - Pagamentos",
                "currency_id" => "BRL",
                "picture_url" =>"https://www.mercadopago.com/org-img/MP3/home/logomp3.gif",
                "description" => $decricao,
                "unit_price" => intval($valorfinal),
                "category_id" => "Category",
                "quantity" => intval($fatu['qtd']),
            )
        )
    );

    $preference = $mp->create_preference($preference_data);




    switch($fatu['tipo']){
     case 'vpn':$tipo='Acesso VPN';break;
     case 'revenda':$tipo='Revenda';break;
     default:$tipo='Outros';break;
 }


}else{
   echo '<script type="text/javascript">';
   echo 	'alert("Fatura Inexistente!");';
   echo	'window.location="home.php?page=faturas/abertas";';
   echo '</script>';

}


?>

<section class="card invoice-page">
    <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-md-6 col-sm-12 text-left">
                <h1>Fatura #<?php echo $fatu['id']; ?> </h1>
                <div class="invoice-details mt-2">
                    <h6>Dia do pagamento</h6>
                    <p><?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?></p>
                </div>
            </div>
        </div>
        <!--/ Invoice Company Details -->

        <!-- Invoice Recipient Details -->
        <div id="invoice-customer-details" class="row pt-2">
            <div class="col-md-6 col-sm-12 text-left">
                <h5>SSHPLUS, Inc.</h5><br>
                <p><i class="fad fa-calendar"></i> <?php echo $dia;?>/<?php echo $mes;?>/<?php echo $ano;?></p>
                <div class="recipient-contact pb-2">
                    <p>
                        <i class="feather icon-mail"></i>
                        admin@admin
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        +55 11 99999-9999
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <h5><?php echo $usufatu['nome'];?></h5>
                <div class="company-info my-2">
                    <p><i class="fad fa-calendar"></i> <?php echo $diav;?>/<?php echo $mesv;?>/<?php echo $anov;?></p>
                    <p><?php if($fatu['servidor_id']<>0){?><b>Servidor:</b> <i class="fa fa-calendar"></i> <?php echo $servidor['ip_servidor'];?> (<?php echo $servidor['nome'];?>)<?php } ?></p>
                    <p><?php if($fatu['conta_id']<>0){?></p>
                    <p><?php if($fatu['tipo']=='vpn'){ ?></p>
                    <p><b>Conta:</b> <i class="fa fa-calendar"></i><?php echo $conta['login'];?></p>
                    <?php } } ?>
                </div>
                <div class="company-contact">
                    <p>
                        <i class="feather icon-mail"></i>
                        <?php echo $usufatu['email'];?>
                    </p>
                    <p>
                        <i class="feather icon-phone"></i>
                        <?php echo $usufatu['celular'];?>
                    </p>
                </div>
            </div>
        </div>
        <!--/ Invoice Recipient Details -->

        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-1 invoice-items-table">
            <div class="row">
                <div class="table-responsive col-sm-12">
                    <table class="table table-borderless">
                        <thead>
                        <tr>
                            <th class="text-center">Qtd</th>
                            <th>Produto</th>
                            <th class="text-right">Tipo</th>
                            <th class="text-right">Descrição</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center"><?php echo $fatu['qtd'];?></td>
                            <td>Contas SSH</td>
                            <td class="text-right"> <?php echo $tipo;?> </td>
                            <td class="text-right"> <?php echo $fatu['descrição'];?></td>
                            <td class="text-right"> R$<?php echo $total;?> </td>
                        </tr>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div id="invoice-total-details" class="invoice-total-table">
            <div class="row">
                
                    <div class="table-responsive col-sm-12">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <th>SUBTOTAL</th>
                                <td>R$<?php echo $total2;?></td>
                            </tr>
                            <tr>
                                <th>DESCONTO</th>
                                <td>R$<?php echo $desconto;?></td>
                            </tr>
                            <tr>
                                <th>TOTAL</th>
                                <td>R$<?php echo $total;?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                
            </div>
        </div>

        <!-- Invoice Footer -->
        <div id="invoice-footer" class="text-center pt-3">
            <p>Pague com mercado pago ou transfira o valor para a conta comercial abaixo.
            <p class="bank-details mb-0">
                <span class="mr-4"><strong>SOLICITAR AO FORNECEDOR</strong></span>
            </p>
        </div>

        <!--/ Invoice Footer -->
        <div class="divider"></div>

        <div class="col-sm-12 text-center">
            <?php if($fatu['status']=='pendente'){ ?>
            <a href="<?php echo $preference["response"]["init_point"]; ?>" name="MP-Checkout" class="btn btn-success"> <i class="fad fa-credit-card"></i> Pagar</a>
            <button type="button" onclick="window.location.href='home.php?page=faturas/confirmar&id=<?php echo $fatu['id'];?>'" class="btn btn-primary"> <i class="fad fa-download"></i> Confirmar</button>
        </div>

        <div class="divider"></div>

        <div class="col-sm-12 text-center">
            <?php }elseif($fatu['status']=='pago'){ ?>
                <h3 class="text-success">Fatura Paga</h3>
            <?php }elseif($fatu['status']=='cancelado'){ ?>
                <h3 class="text-danger">Fatura Cancelada/Vencida</h3>
            <?php } ?>
        </div>
    </div>
</section>