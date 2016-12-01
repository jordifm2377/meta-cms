<?php if(GOOGLE_MAPS_API_KEY!="" && $googlemaps){?>

<body onunload="GUnload()">
<?php }else{ ?>
<body>
<?php } ?>

<!-- Debug Info:<?php echo $debug ?>: -->

<!-- HEADER -->
<div id="header">
	<!-- BOTTOM (primer va el bottom) -->
	<div class="head_bottom">
		<div class="wrapper">
			<h1><?php echo $title ?></h1>
			<div class="right">
				<?php
				if($_SESSION['rol_id']==1) $rol='<a href="controller.php?p_action=get_roles" title="'.getMessage('info_word_privileges').'">'.getMessage('info_word_privileges').'</a>';?>

				<p><em><?php echo getMessage('info_word_logged')." ".$_SESSION['user_nom'] ?></em></p>
				<ul>
					<!--li><?php echo $rol ?></li-->
					<li><a href="<?php echo APP_BASE?>/logout" title="<?php echo getMessage('info_word_logout'); ?>"><?php echo getMessage('info_word_logout'); ?></a></li>
				</ul>

			</div>
		</div>
	</div>
	<!-- /end BOTTOM -->

	<!-- TOP (despres del bottom va el top) -->
	<div class="head_top">
		<!-- NAVEGACIO -->
		<div class="wrapper" id="nav">
				 <!-- MENU -->
				 <ul>
					<?php echo $top_menu ?>
				 </ul>
				 <div class="clear"></div>
			</div>
		<!-- /end NAVEGACIO -->
   </div>
	<!-- /end TOP -->
</div>
<!-- /end HEADER -->

<!-- CONTENT -->
<div id="content">
	<div class="row one_col">
		<!-- COLUMNA MISSATGE ALERTA -->
		<div class="column col">
			<!-- MISSATGE ALERTA -->
		   <div class="col_item alert alert_wrong">
				<span></span>
				<div><p><?=getMessage('error_page')?></p></div>
				<!--p class="btn_close"><a title="Tancar" href="/">Tancar</a></p-->
			</div>
			<!-- /end MISSATGE ALERTA -->
		</div>
		<!-- /end COLUMNA MISSATGE ALERTA -->
	</div>
	<!-- FILA 1 -->
	<div class="row two_cols">
		<!-- COLUMNA ESQUERRA -->
		<div class="column col_a">
			<!-- CERCADOR GRAN -->
				<?php if(!$minibuscador_bool) echo '<div class="col_item visible searcher">'.$buscador.'<div class="clear"></div></div>';  ?>
			<!-- /end CERCADOR GRAN -->
			<!-- TAULA OBJECTES -->
				<?php echo $body ?>
			<!-- /end TAULA OBJECTES -->
		</div>
		<!-- /end COLUMNA ESQUERRA -->
		<!-- COLUMNA DRETA -->
		<div class="column col_b">
			<?php if(SHOWTWIT) { ?>
				<div id="caixa_twitter">
					<div id="titol_twitter"><?php echo getMessage('container_twitter');?> <a href="/"></a></div>
					 <?=$afegir_twitter ?>
				</div>
			<?php }
			if($minibuscador_bool) { ?>
				<div class="col_item mini_searcher" id="caixa_cercador">
					<?=$buscador?>
				</div>
			<?php } ?>
			<!-- CAIXA OBJECTES PREFERITS -->
			<div class="col_item box box_show" id="caixa_favorits">
				<div class="box_tit">
					<h2><?php echo getMessage('container_objetos_favoritos');?></h2>
					<p class="arrow"><a href="#" title="Ocultar">Ocultar</a></p>
				</div>
				<div class="box_content tbl_items"><?=$favorites?></div>
			</div>
			<!-- /end CAIXA OBJECTES PREFERITS -->
			<!-- CAIXA OBJECTES ACCEDITS -->
			<div class="col_item box box_show" id="caixa_darrers"><!-- box_show -->
				<div class="box_tit">
					<h2><?php echo getMessage('container_ultimos_objetos');?></h2>
					<p class="arrow"><a href="#">Mostrar</a></p>
				</div>
				<div class="box_content tbl_items">
					<?=$last_accessed?>
				</div>

			</div>
			<!-- /end CAIXA OBJECTES ACCEDITS -->
			<!-- CAIXA OBJECTES PARE -->
			<?php if (isset($parents) && $parents!='') { ?>
				<div class="col_item box box_show" id="caixa_pares"><!-- box_show -->
					<div class="box_tit">
						<h2><?php echo getMessage('container_objetos_padre');?></h2>
						<p class="arrow"><a href="#">Mostrar</a></p>
					</div>
					<div class="box_content tbl_items">
						<?=$parents?>
					</div>
				</div>
			<?php } ?>
			<!-- /end CAIXA OBJECTES PARE -->
			<!-- CAIXA MES FUNCIONS -->
			<div class="col_item box box_show" id="caixa_funcions">
				<div class="box_tit">
						<h2><?php echo getMessage('container_mes_funcions');?></h2>
						<p class="arrow"><a href="#">Mostrar</a></p>
					</div>
					<div class="box_content">
						<?=$special?>
					</div>
		   </div>
			<!-- /end CAIXA MES FUNCIONS -->
		</div>
		<!-- /end COLUMNA DRETA -->
	</div>
	<!-- /end FILA 1 -->
</div>
<!-- /end CONTENT -->