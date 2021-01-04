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
                <h1 class="card-title font-medium-2"><i class="fad fa-user-tie text-success font-large-1"></i> Usuarios VPN</h1>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>Clintes SSH com acesso ao painel</p>
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
                            <th>STATUS</th>
                            <th>NOME</th>
                            <th>LOGIN</th>
                            <th>TIPO</th>
                            <th>CONTAS SSH</th>
                            <th>ACESSOS SSH</th>
                            <th>DONO</th>
                            <th>INFORMACOES</th>
                        </thead>
                        <tbody id="myTable">
                        <?php

                        $SQLUsuario = "SELECT * FROM usuario  where tipo='vpn' ORDER BY ativo ";
                        $SQLUsuario = $conn->prepare($SQLUsuario);
                        $SQLUsuario->execute();

                        // output data of each row
                        if (($SQLUsuario->rowCount()) > 0) {

                            while($row = $SQLUsuario->fetch())


                            {
                                $class = "class='btn-sm btn-danger'";
                                $status="";
                                $tipo="";
                                $owner = "";
                                $contas = 0;
                                $color = "";
                                if($row['ativo']== 1){
                                    $status="Ativo";
                                    $class = "class='btn-sm btn-primary'";
                                }else{
                                    $status="Desativado";
                                    $color = "bgcolor='#FF6347'";
                                }

                                $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'";
                                $SQLContasSSH = $conn->prepare($SQLContasSSH);
                                $SQLContasSSH->execute();
                                $contas += $SQLContasSSH->rowCount();

                                $total_acesso_ssh = 0;
                                $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
                                $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                                $SQLAcessoSSH->execute();
                                $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                                $total_acesso_ssh += $SQLAcessoSSH['quantidade'];



                                if($row['tipo']=="vpn"){
                                    $tipo="Usuário SSH";

                                }else{
                                    $tipo="Revendedor";


                                }

                                if($row['id_mestre'] == 0){
                                    $owner = "Sistema";
                                }else{


                                    $SQLContasSSH = "select * from usuario WHERE id_usuario = '".$row['id_mestre']."'";
                                    $SQLContasSSH = $conn->prepare($SQLContasSSH);
                                    $SQLContasSSH->execute();
                                    $revendedor = $SQLContasSSH->fetch();
                                    $owner = $revendedor['login'];

                                }



                                ?>
                                <?php if($row['id_mestre']==0){?>
                                <div class="modal fade" id="squarespaceModal<?php echo $row['id_usuario'];?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="lineModalLabel"><i class="fa fa-money"></i> Cria uma Fatura</h3>
                                            </div>
                                            <div class="modal-body">

                                                <!-- content goes here -->
                                                <form name="editaserver" action="pages/usuario/criarfatura_usuariovpn.php" method="post">
                                                    <input name="idcontausuario" type="hidden" value="<?php echo $row['id_usuario'];?>">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Cliente</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row['nome'];?>" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Tipo</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" value="Outros" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Valor</label>
                                                        <input type="number" class="form-control" name="valor" value="1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Desconto</label>
                                                        <input type="number" class="form-control" name="desconto" value="0">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Prazo</label>
                                                        <input type="number" class="form-control" name="prazo" value="1">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Descrição</label>
                                                        <textarea class="form-control" name="msg" rows=3 cols=20 wrap="off" placeholder="Digite..."></textarea>
                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="btn-group btn-group-justified" role="group" aria-label="group button">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Cancelar</button>
                                                    </div>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-default btn-success">Confirmar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                                <tr <?php echo $color; ?> >
                                    <td><?php echo $status;?></td>
                                    <td><?php echo $row['nome'];?></td>

                                    <td><?php echo $row['login'];?></td>


                                    <td><?php echo $tipo;?></td>
                                    <td><?php echo $contas;?></td>
                                    <td><?php echo $total_acesso_ssh;?></td>
                                    <td><?php echo $owner;?></td>

                                    <td>


                                        <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" <?php echo $class;?>><i class="fa fa-eye"></i></a>
                                        <?php if($row['id_mestre']==0){?>
                                            <a data-toggle="modal" href="#squarespaceModal<?php echo $row['id_usuario'];?>" class="btn-sm btn-success label-orange"><i class="fa fa-shopping-cart"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>




                            <?php }
                        }


                        ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
