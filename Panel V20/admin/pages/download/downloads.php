<?php

    if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
    exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script type="text/javascript" src="../../plugins/datatables/sort-table.js"></script>
<style type="text/css">

  table { 
    width: 100%; 
    border-collapse: collapse; 
  }
  /* Zebra striping */
  tr:nth-of-type(odd) { 
    background: #f3f4f8; 
  }
  th { 
    background: white; 
    color: black; 
    font-weight: bold; 
  }
  td, th { 
    padding: 6px; 
    border: 1px solid #d7dfe2; 
    text-align: left; 
  }

</style>

<script>
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
<script type="text/javascript">
function deletatudo(){
decisao = confirm("Realmente deseja deletar todos downloads?");
if (decisao){
  window.location.href='pages/download/excluir_todos.php?id=1';
} else {

}


}
</script>
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
<!-- Input with Icons start -->
<section id="input-with-icons">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title font-medium-2"><i class="fad fa-cloud-upload text-success font-large-1"></i> Hospedar Arquivos</h1>
                </div>
                <div class="card-content">
                    <form action="pages/download/enviandoarquivo.php" enctype="multipart/form-data" method="POST" role="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <p>Arquivos para download</p>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Nome do Arquivo
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <input type="text" name="nome" id="nome" class="form-control" minlength="4"  placeholder="Digite o Nome do Arquivo..." required>
                                        <div class="form-control-position">
                                            <i class="feather icon-file"></i>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Operadora
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <select class="form-control" name="operadora">
                                            <option value='1' selected=selected>Todas</option>
                                            <option value='2'>Claro</option>
                                            <option value='3'>Vivo</option>
                                            <option value='4'>Tim</option>
                                            <option value='5'>Oi</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Status
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <select class="form-control" name="status">
                                            <option value='1' selected=selected>Funcionando</option>
                                            <option value='2'>Em Testes</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Tipo do arquivo
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <select class="form-control" name="tipo">
                                            <option value='1' selected=selected>Ehi</option>
                                            <option value='2'>Apk</option>
                                            <option value='3'>Outros</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Tipo de cliente
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <select class="form-control" name="tipocliente">
                                            <option value='1' selected=selected>Todos</option>
                                            <option value='2'>Revenda</option>
                                            <option value='3'>Vpn</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div class="text-bold-600 font-medium-2 mb-1">
                                        Descrição
                                    </div>
                                    <fieldset class="form-group position-relative">
                                        <input type="text" name="msg" id="msg" class="form-control" placeholder="Digite uma descrição..." required></div>
                                </fieldset>
                            </div>
                            <div class="col-12 text-center">
                                <div class="text-bold-600 font-medium-2 mb-1">
                                    Arquivo
                                </div>
                                <fieldset class="form-group position-relative input-divider-right">
                                    <input type="file" class="form-control" name="arquivo">
                                    <div class="form-control-position">
                                        <i class="feather icon-file"></i>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-12 col-12	text-center">
                                <button type="submit" name="enviandoarquivos" class="btn btn-success">Enviar</button>
                                <button type="reset" class="btn btn-danger">Limpar</button>
                                <button type="submit" class="btn btn-warning" onclick="deletatudo();">Apagar Todos</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</section>
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
<!-- Input with Icons end -->
<div class="row" id="table-hover-row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title font-medium-2"><i class="fad fa-cloud text-success font-large-1"></i> Arquivos Hospedados</h1>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <p>Todos arquivos enviado ao servidor listado abaixo.</p>
                    <div class="col-12"><br>
                        <div class="form-responsive">
                            <input type="text" id="myInput" placeholder="Pesquisar..." class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0 js-sort-table" id="MeuServidor" data-search="minhaPesquisa-lista">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>TIPO</th>
                            <th>CLIENTE</th>
                            <th>OPERADORA</th>
                            <th>DATA POSTADO</th>
                            <th>NOME</th>
                            <th>DETALHES</th>
                            <th>APAGAR</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $SQLSubSSH = "SELECT * FROM arquivo_download ORDER BY id desc";
                        $SQLSubSSH = $conn->prepare($SQLSubSSH);
                        $SQLSubSSH->execute();
                        if(($SQLSubSSH->rowCount()) > 0){
                            while($row = $SQLSubSSH->fetch()){
                                $dataatual=$row['data'];
                                $dataconv = substr($dataatual, 0, 10);
                                $partes = explode("-", $dataconv);
                                $ano = $partes[0];
                                $mes = $partes[1];
                                $dia = $partes[2];
                                ?>
                                <tr>
                                    <td><?php echo $row['id'];?></td>
                                    <td><?php echo ucfirst($row['tipo']);?></td>
                                    <td><?php echo ucfirst($row['cliente_tipo']);?></td>
                                    <td><?php echo ucfirst($row['operadora']);?></td>
                                    <td><?php echo $dia;?>/<?php echo $mes;?> - <?php echo $ano;?></td>
                                    <td><?php echo $row['nome_arquivo'];?></td>
                                    <td><?php echo $row['detalhes'];?></td>
                                    <td><a href="pages/download/excluir.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-md">Excluir</a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
