<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalle del anuncio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="detalle del anuncio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del anuncio ', $anuncio->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Anuncios' => '/Anuncio/list',
		    $anuncio->titulo => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section id="detalles" class="flex-container gap2">
				<div class="flex2">
    				<h2><?= $anuncio->titulo ?></h2>
    				
            		<p><b>Título:</b>		<?=$anuncio->titulo?></p>
            		<p><b>Descripción:</b>	<?=$anuncio->descripcion?></p>
            		<p><b>Precio:</b>		<?=$anuncio->precio?></p>
            		
            	</div>
            	<figure class="flex1 centrado p2">
            		<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
            			class="cover enlarge-image"
            			alt="Imagen del artículo <?=$anuncio->titulo?>">
            		<figcaption>Imagen de <?= "$anuncio->titulo" ?></figcaption>	
            	</figure>	
			</section>
			
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Anuncio/list">Lista de anuncios</a>
				
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>