<?php
$procnoticias= "select * FROM noticias where status='ativo'";
$procnoticias = $conn->prepare($procnoticias);
$procnoticias->execute();


// Clientes
$SQLbuscaclientes= "select * from usuario where tipo='vpn'";
$SQLbuscaclientes = $conn->prepare($SQLbuscaclientes);
$SQLbuscaclientes->execute();
$totalclientes = $SQLbuscaclientes->rowCount();
// Revendedores
$SQLbuscarevendedores= "select * from  usuario where tipo='revenda'";
$SQLbuscarevendedores = $conn->prepare($SQLbuscarevendedores);
$SQLbuscarevendedores->execute();
$totalrevendedores = $SQLbuscarevendedores->rowCount();
// Servidores
$SQLbuscaservidores= "select * from  servidor";
$SQLbuscaservidores= $conn->prepare($SQLbuscaservidores);
$SQLbuscaservidores->execute();
$totalservidores = $SQLbuscaservidores->rowCount();

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
    <div class="card alert alert-info">

        <center>
            <a class="close danger" data-dismiss="alert" aria-label="Close">x</a>
            <h3 class="text-warning"><i class="fal fa-bullhorn"></i> <?php echo $noticia['titulo'];?> </h3> <i class="fal fa-info"></i>
            <?php echo $noticia['subtitulo'];?> <br/>
            <?php echo $noticia['msg'];?><br/>
            <?php echo $semana["$data"] . ", {$dia} de " . $mes_extenso["$mes"] . " de {$ano}";;?>
        </center>
    </div>
    <br>
<?php } ?>

<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
    <div class="row">
        <div class="col-sm-12">
            <div class="card bg-analytics text-white">
                <div class="card-content">
                    <div class="card-body text-center">
                        <div class="avatar avatar-xl bg-gradient-primary shadow mt-0">
                            <div class="avatar-content">
                                <img class="round" src="../../app-assets/images/portrait/avatar/user2-160x160.png" alt="avatar" height="60" width="60"></img>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="mb-2 text-white"> BEM VINDOª <?php echo strtoupper($administrador['nome']);?></h3>
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
                        <div class="avatar bg-rgba-success m-0 p-2">
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
                        <div class="avatar bg-rgba-warning p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-terminal text-warning font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $total_acesso_ssh;?> Acessos</h4>
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
                        <h4 class="text-bold-700 mt-1 mb-25"><?php echo $contas_ssh;?> Contas</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <a href="home.php?page=usuario/usuario_ssh">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-primary p-2 m-0">
                            <div class="avatar-content">
                                <i class="fal fa-user text-primary font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1 mb-25"><?php echo $all_usuarios_vpn_qtd;?> Clientes</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
    

        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <a href="home.php?page=usuario/revenda">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-danger p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-user-tie text-danger font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $all_usuarios_revenda_qtd;?> Revendedores</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <a href="home.php?page=servidor/listar">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-success p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-server text-success font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $servidor_qtd; ?> Servidores</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <a href="home.php?page=usuario/revenda">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-danger p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-user-clock text-danger font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $revenda_qtd_susp;?> Revende. Susp.</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            <div class="card">
                <a href="home.php?page=usuario/listar">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-warning p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-user-lock text-warning font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $all_usuarios_vpn_qtd_susp;?> Clientes Susp.</h4>
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
                                <i class="fad fa-user-times text-info font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $ssh_susp_qtd;?> SSH Suspensas</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <a href="home.php?page=download/downloads">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-primary p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-cloud-download-alt text-primary font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $todosarquivos; ?> Arquivos</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <a href="home.php?page=faturas/abertas">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-success p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-file-invoice-dollar text-success font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $faturas; ?> Faturas</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-12">
            <div class="card">
                <a href="home.php?page=chamados/abertas">
                    <div class="card-header d-flex flex-column align-items-center pb-0">
                        <div class="avatar bg-rgba-danger p-2 m-0">
                            <div class="avatar-content">
                                <i class="fad fa-clipboard-list-check text-danger font-large-2"></i>
                            </div>
                        </div>
                        <h4 class="text-bold-700 mt-1"><?php echo $all_chamados;?> Chamados</h4>
                        <p class="mb-2"></p>
                    </div>
                </a>
            </div>
        </div>
  
</section>
