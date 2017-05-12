<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "DB_MAGAZZINO";

// Create connection
$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db($database, $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

$prodotti = mysql_query("SELECT * FROM prodotto") or die("Query non valida: " . mysql_error());

$tecnici = mysql_query("SELECT * FROM tecnico") or die("Query non valida: " . mysql_error());

$numberp = mysql_query("SELECT count(*) FROM `prodotto`", $link) or die ("Query non valida: " . mysql_error());
$numbert = mysql_query("SELECT count(*) FROM `tracciamento`", $link) or die ("Query non valida: " . mysql_error());
$insert = mysql_query("SELECT count(*) FROM `tracciamento` where quantita > 0", $link) or die ("Query non valida: " . mysql_error());
$delete = mysql_query("SELECT count(*) FROM `tracciamento` where quantita < 0", $link) or die ("Query non valida: " . mysql_error());

$p = mysql_fetch_array($numberp);
$t = mysql_fetch_array($numbert);
$i = mysql_fetch_array($insert);
$d = mysql_fetch_array($delete);


//mysql_close($link);
?> 

<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Data Manager - Magazzino</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="theme/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="theme/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="theme/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="theme/assets/global/plugins/select2/select2.css"/>
<link rel="stylesheet" type="text/css" href="theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
<!-- END PAGE LEVEL STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="theme/assets/global/css/components-md.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="theme/assets/global/css/plugins-md.css" rel="stylesheet" type="text/css"/>
<link href="theme/assets/admin/layout4/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="theme/assets/admin/layout4/css/themes/light.css" rel="stylesheet" type="text/css"/>
<link href="theme/assets/admin/layout4/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="favicon.ico"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-md page-sidebar-closed-hide-logo ">
<!-- BEGIN CONTAINER -->
<div class="page-container">

	<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light blue-soft" href="index.php">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $p[0]; ?>
							</div>
							<div class="desc">
								 Magazzino
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light red-soft" href="inserimento.php">
						<div class="visual">
							<i class="fa fa-trophy"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $i[0]; ?>
							</div>
							<div class="desc">
								 Deposito
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light green-soft" href="uscita.php">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $d[0]; ?>
							</div>
							<div class="desc">
								 Ritiro
							</div>
						</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<a class="dashboard-stat dashboard-stat-light purple-soft" href="tracciamento.php">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?php echo $t[0]; ?>
							</div>
							<div class="desc">
								 Tracciamento
							</div>
						</div>
						</a>
					</div>
	</div>

		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><small></small></h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					
					<div class="portlet light">
							<div class="portlet-title">
								<div class="caption font-green">
									<i class="icon-pin font-green"></i>
									<span class="caption-subject bold uppercase">Ritiro</span>
								</div>
							</div>
							<div class="portlet-body form">
								<form role="form">
									<div class="form-body">
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<select class="form-control" id="form_control_1">
												<option value=""></option>
												<?php
												while ($row = mysql_fetch_row($tecnici)) {
													echo "<option value=\"$row[0]\">$row[1]</option>";
												}
												?>
											</select>
											<label for="form_control_1">Seleziona tecnico</label>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<select class="form-control" id="form_control_1">
												<option value=""></option>
												<?php
												while ($row = mysql_fetch_row($prodotti)) {
													echo "<option value=\"$row[0]\">$row[1]</option>";
												}
												?>
											</select>
											<label for="form_control_1">Seleziona prodotto</label>
										</div>
										<div class="form-group form-md-line-input form-md-floating-label has-info">
											<input type="number" min="-100" max="-1" class="form-control" id="form_control_1">
											<label for="form_control_1">Quantità</label>
											<span class="help-block">Numero di prodotti...</span>
										</div>
									</div>
									<div class="form-actions noborder">
										<button type="submit" class="btn blue">Prosegui</button>
										<button type="reset" class="btn default">Cancella</button>
									</div>
								</form>
							</div>
						</div>

				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
	<div class="page-footer-inner">
		 2017 &copy; Pega by federosa and apotereanu. <a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase PEGAMERDA!</a>
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="theme/assets/global/plugins/respond.min.js"></script>
<script src="theme/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="theme/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="theme/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="theme/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="theme/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="theme/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="theme/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="theme/assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="theme/assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="theme/assets/admin/pages/scripts/table-managed.js"></script>
<script>
jQuery(document).ready(function() {       
Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
TableManaged.init();
});
</script>
</body>
<!-- END BODY -->
</html>