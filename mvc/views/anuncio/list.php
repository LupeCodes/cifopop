<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de anuncios</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de anuncios en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de anuncios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Anuncios' => 'Anuncio/list'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de anuncios</h2>
			
			<?php if ($anuncios){ ?>
				<!-- FILTRO DE BUSQUEDA -->
				<?php 
				//si hay filtro guardado en sesion...
				if($filtro){
				    //pone el formulario de "quitar filtro"
				    //el metodo removeFilterForm necesita conocer el filtro
				    //y la ruta a la q se envia el formulario
				    echo $template->removeFilterForm($filtro, '/Anuncio/list');
				//y si no hay filtro guardado en sesion...    
				}else{
				    //pone el formulario de nuevo filtro
				    echo $template->filterForm(
				    
				        //lista de campos para el desplegable buscar en
				         [
				            'Titulo' => 'titulo',
				            'Descripcion' => 'descripcion'
				        ],
				        //lista de campos para el plesplegable ordenado por 
    				    [
        				    'Titulo' => 'titulo',
        				    'Descripcion' => 'descripcion'
    				    ],
    				    //valor por defecto para buscar en
    				    'Título',
    				    //valor por defecto para ordenado por
    				    'Título'
				    );
				}
				?>
			
				<!-- Enlaces creados por el paginator -->
				<div class="right">
					<?= $paginator->stats() ?>
				</div>
        		<table class="table w100">
        			<tr>
        				<th>Foto</th><th>Titulo</th><th>Precio</th>
        				
        			</tr>
        			<?php foreach($anuncios as $anuncio){?>
        				<tr>
        					<td class="centrado">
        						<a href='/Anuncio/show/<?=$anuncio->id?>'>
        							<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
        								class="table-image">
        						</a>
        					</td>
        					<td><a href='/Anuncio/show/<?=$anuncio->id?>'><?=$anuncio->titulo?></a></td>
        					<td><?=$anuncio->precio?>€</td>
        		
        				</tr>
        			<?php } ?>
        		</table>
        		<?= $paginator->ellipsisLinks() ?>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay anuncios que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>