<?php

if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
    exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}
?>
<script type="text/javascript" src="../../app-assets/plugins/sort-table.js"></script>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title font-medium-2"><i class="fad fa-file-excel text-success font-large-1"></i> Faturas Canceladas</h1>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>Todas suas faturas canceladas estão abaixo.</p>
                    <div class="col-12"><br>
                        <div class="form-responsive">
                            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 js-sort-table" id="MeuServidor" data-search="minhaPesquisa-lista">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>TIPO</th>
                            <th>STATUS</th>
                            <th>CLIETES</th>
                            <th>DATA</th>
                            <th>VENCIMENTO</th>
                            <th>VALOR</th>
                            <th>INFORMACOES</th>
                        </tr>
                        </thead>
                        <tbody
                        >
                        <?php




                        $SQLUPUser= "SELECT * FROM fatura_clientes where status='cancelado' and id_mestre='".$_SESSION['usuarioID']."' ORDER BY id desc ";
                        $SQLUPUser = $conn->prepare($SQLUPUser);
                        $SQLUPUser->execute();

                        // output data of each row
                        if (($SQLUPUser->rowCount()) > 0) {

                            while($row = $SQLUPUser->fetch())


                            {

                                switch($row['tipo']){
                                    case 'vpn':$tipo='Acesso VPN';break;
                                    case 'revenda':$tipo='Revenda';break;
                                    default:$tipo='Outros';break;
                                }


                                $datacriado=$row['data'];
                                $dataconvcriado = substr($datacriado, 0, 10);
                                $partes = explode("-", $dataconvcriado);
                                $ano = $partes[0];
                                $mes = $partes[1];
                                $dia = $partes[2];

                                $vencimento=$row['datavencimento'];
                                $datavn = substr($vencimento, 0, 10);
                                $partesven = explode("-", $datavn);
                                $anov = $partesven[0];
                                $mesv = $partesven[1];
                                $diav = $partesven[2];

                                $valor=number_format(($row['valor'])*($row['qtd']),2);


                                switch($row['status']){
                                    case 'pendente':$botao='<span class="label label-warning">Pendente</span>';break;
                                    case 'cancelado':$botao='<span class="label label-danger">Cancelado</span>';break;
                                    case 'pago':$botao='<span class="label label-success">Pago</span>';break;
                                    default:$botao='Outros';break;
                                }

                                $Susuario= "SELECT * FROM usuario where id_usuario='".$row['usuario_id']."'";
                                $Susuario = $conn->prepare($Susuario);
                                $Susuario->execute();
                                $usuario=$Susuario->fetch();

                                ?>

                                <tr >
                                    <td >#<?php echo $row['id'];?></td>
                                    <td><?php echo $tipo;?></td>
                                    <td><?php echo $botao;?></td>
                                    <td><?php echo $usuario['nome'];?></td>
                                    <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                                    <td><?php echo $diav;?>/<?php echo $mesv;?> - <?php echo $anov;?></td>
                                    <td>R$<?php echo number_format($valor, 2, ',', '.');?></td>
                                    <td>
                                        <a href="home.php?page=faturasclientes/verfatura&id=<?php echo $row['id'];?>" class="btn btn-block btn-success">Visualizar</a>
                                    </td>
                                </tr>
                            <?php } } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
