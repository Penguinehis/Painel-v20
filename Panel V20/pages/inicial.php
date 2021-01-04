<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();

if($usuario['tipo']=='revenda'){
        // Clientes
  $SQLbuscaclientes= "select * from usuario where tipo='vpn' and id_mestre='".$usuario['id_usuario']."'";
  $SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
  $SQLbuscaclientes->execute();
  $totalclientes = $SQLbuscaclientes->rowCount();

         // Servidores
  $SQLbuscaservidores= "select * from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
  $SQLbuscaservidores = $conn->prepare($SQLbuscaservidores);
  $SQLbuscaservidores->execute();
  $servidoresclientes = $SQLbuscaservidores->rowCount();

        // Cotas
  $totaldecotas=0;
  $SQLbuscacontasssh= "select sum(qtd) as cotas from acesso_servidor where id_usuario='".$usuario['id_usuario']."'";
  $SQLbuscacontasssh = $conn->prepare($SQLbuscacontasssh);
  $SQLbuscacontasssh->execute();
  $minhascotas = $SQLbuscacontasssh->fetch();
  $totaldecotas+=$minhascotas['cotas'];


}else{
        // Contas
  $SQLbuscacontinhas= "select * from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
  $SQLbuscacontinhas = $conn->prepare($SQLbuscacontinhas);
  $SQLbuscacontinhas->execute();
  $totalcontas = $SQLbuscacontinhas->rowCount();

        // Cotas
  $totaldecotas2=0;
  $SQLbuscacontasssh2= "select sum(acesso) as cotas from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
  $SQLbuscacontasssh2 = $conn->prepare($SQLbuscacontasssh2);
  $SQLbuscacontasssh2->execute();
  $minhascotas2 = $SQLbuscacontasssh2->fetch();
  $totaldecotas2+=$minhascotas2['cotas'];

        // Faturas
  if($usuario['id_mestre']==0){
    $SQLbuscafaturinhas= "select * from fatura where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
    $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
    $SQLbuscafaturinhas->execute();
    $minhasfatu = $SQLbuscafaturinhas->rowCount();
  }else{
        // Faturas
    $SQLbuscafaturinhas= "select * from fatura_clientes where usuario_id='".$usuario['id_usuario']."' and status='pendente'";
    $SQLbuscafaturinhas = $conn->prepare($SQLbuscafaturinhas);
    $SQLbuscafaturinhas->execute();
    $minhasfatu = $SQLbuscafaturinhas->rowCount();

  }




}

?>

<!-- Noticias -->
<?php if($procnoticias->rowCount()>0){
 $noticia=$procnoticias->fetch();

 $datapega=$noticia['data'];
 $data = date('D',strtotime($datapega));
 $mes = date('M',strtotime($datapega));
 $dia = date('d',strtotime($datapega));
 $ano = date('Y',strtotime($datapega));

 $semana = array(
  'Sun' => 'Domingo',
  'Mon' => 'Segunda-Feira',
  'Tue' => 'Terça-Feira',
  'Wed' => 'Quarta-Feira',
  'Thu' => 'Quinta-Feira',
  'Fri' => 'Sexta-Feira',
  'Sat' => 'Sábado'
);

 $mes_extenso = array(
  'Jan' => 'Janeiro',
  'Feb' => 'Fevereiro',
  'Mar' => 'Marco',
  'Apr' => 'Abril',
  'May' => 'Maio',
  'Jun' => 'Junho',
  'Jul' => 'Julho',
  'Aug' => 'Agosto',
  'Nov' => 'Novembro',
  'Sep' => 'Setembro',
  'Oct' => 'Outubro',
  'Dec' => 'Dezembro'
);


?>

<div class="alert alert-info">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  <center>
    <h3 class="text-warning"><i class="fal fa-bullhorn"></i> <?php echo $noticia['titulo'];?> </h3> <i class="fal fa-info"></i>
    <?php echo $noticia['subtitulo'];?> <br/>
    <?php echo $noticia['msg'];?><br/>
    <?php echo $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";;?>
  </center>
</div>
<br>
<?php } ?>

<section id="dashboard-analytics">
  <div class="row">
    <div class="col-12">
      <div class="card bg-analytics text-white">
        <div class="card-content">
          <div class="card-body text-center">
            <div class="avatar avatar-xl bg-gradient-primary shadow mt-0">
              <div class="avatar-content">
                <img class="round" src="../app-assets/images/portrait/avatar/<?php echo $avatarusu;?>" alt="avatar" height="60" width="60"></img>
              </div>
            </div>
            <div class="text-center">
              <h3 class="mb-2 text-white">BEM VINDOª <?php echo strtoupper($usuario['nome']);?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Dashboard Analytics end -->
<section id="statistics-card">
  <div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <a href="home.php?page=ssh/online">
          <div class="card-header d-flex flex-column align-items-center pb-0">
            <div class="avatar bg-rgba-success p-2 m-0">
              <div class="avatar-content">
                <i class="fad fa-rocket text-success font-large-2"></i>
              </div>
            </div>
            <h4 class="text-bold-700 mt-1"><?php echo $total_acesso_ssh_online; ?> Online</h4>
            <p class="mb-2"></p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <a href="home.php?page=ssh/contas">
          <div class="card-header d-flex flex-column align-items-center pb-0">
            <div class="avatar bg-rgba-info p-2 m-0">
              <div class="avatar-content">
                <i class="fad fa-user-circle text-info font-large-2"></i>
              </div>
            </div>
            <h4 class="text-bold-700 mt-1"><?php echo $quantidade_ssh; ?> Contas</h4>
            <p class="mb-2"></p>
          </div>
        </a>
      </div>
    </div>
    <?php if($usuario['tipo']=="revenda"){?>
      <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
          <a href="home.php?page=usuario/listar">
            <div class="card-header d-flex flex-column align-items-center pb-0">
              <div class="avatar bg-rgba-primary p-2 m-0">
                <div class="avatar-content">
                  <i class="fal fa-user text-primary font-large-2"></i>
                </div>
              </div>
              <h4 class="text-bold-700 mt-1"><?php echo $quantidade_sub; ?> Clientes</h4>
              <p class="mb-2"></p>
            </div>
          </a>
        </div>
      </div>
    <?php }?>
    <?php if(($usuario['tipo']=="revenda") and ($usuario['subrevenda']=='nao') ){?>
      <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
          <a href="home.php?page=usuario/revenda">
            <div class="card-header d-flex flex-column align-items-center pb-0">
              <div class="avatar bg-rgba-warning p-2 m-0">
                <div class="avatar-content">
                  <i class="fad fa-user-tie text-warning font-large-2"></i>
                </div>
              </div>
              <h4 class="text-bold-700 mt-1"><?php echo $quantidade_sub_revenda; ?> Revendedores</h4>
              <p class="mb-2"></p>
            </div>
          </a>
        </div>
      </div>
    <?php }?>
    <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card">
          <a href="?page=servidor/listar">
            <div class="card-header d-flex flex-column align-items-center pb-0">
              <div class="avatar bg-rgba-warning p-2 m-0">
                <div class="avatar-content">
                  <i class="fad fa-server text-warning font-large-2"></i>
                </div>
              </div>
              <h4 class="text-bold-700 mt-1"><?php echo $acesso_servidor; ?> Servidores</h4>
              <p class="mb-2"></p>
            </div>
          </a>
        </div>
      </div>
    <?php }?>

    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <a href="home.php?page=faturas/abertas">
          <div class="card-header d-flex flex-column align-items-center pb-0">
            <div class="avatar bg-rgba-success p-2 m-0">
              <div class="avatar-content">
                <i class="fad fa-file-invoice-dollar text-success font-large-2"></i>
              </div>
            </div>
            <h4 class="text-bold-700 mt-1 mb-25"><?php echo $faturas; ?> Faturas</h4>
            <p class="mb-2"></p>
          </div>
        </a>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-12">
      <div class="card">
        <a href="home.php?page=chamados/abertas">
          <div class="card-header d-flex flex-column align-items-center pb-0">
            <div class="avatar bg-rgba-danger p-2 m-0">
              <div class="avatar-content">
                <i class="fad fa-bells text-danger font-large-2"></i>
              </div>
            </div>
            <h4 class="text-bold-700 mt-1"><?php echo $all_chamados;?> Chamados</h4>
            <p class="mb-2"></p>
          </div>
        </a>
      </div>
    </div>

    <?php if($usuario['tipo']=='revenda'){ ?>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card">
          <a href="home.php?page=faturas/abertas">
            <div class="card-header d-flex flex-column align-items-center pb-0">
              <div class="avatar bg-rgba-success p-2 m-0">
                <div class="avatar-content">
                  <i class="fad fa-file-invoice-dollar text-success font-large-2"></i>
                </div>
              </div>
              <h4 class="text-bold-700 mt-1"><?php echo $faturas_clientes; ?> Faturas Cli.</h4>
              <p class="mb-2"></p>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
    <?php if($usuario['tipo']=='revenda'){ ?>
      <div class="col-lg-3 col-md-6 col-12">
        <div class="card">
          <a href="home.php?page=chamados/abertas">
            <div class="card-header d-flex flex-column align-items-center pb-0">
              <div class="avatar bg-rgba-danger p-2 m-0">
                <div class="avatar-content">
                  <i class="fad fa-clipboard-list-check text-danger font-large-2"></i>
                </div>
              </div>
              <h4 class="text-bold-700 mt-1"><?php echo $all_chamados_clientes;?> Chamados Cli.</h4>
              <p class="mb-2"></p>
            </div>
          </a>
        </div>
      </div>
    <?php } ?>
    
    <div class="col-lg-3 col-sm-6 col-12">
      <div class="card">
        <a href="home.php?page=downloads/downloads">
          <div class="card-header d-flex flex-column align-items-center pb-0">
            <div class="avatar bg-rgba-primary p-2 m-0">
              <div class="avatar-content">
                <i class="fad fa-cloud-download-alt text-primary font-large-2"></i>
              </div>
            </div>
            <h4 class="text-bold-700 mt-1 mb-25"><?php echo $todosarquivos; ?> Arquivos</h4>
            <p class="mb-2"></p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>
