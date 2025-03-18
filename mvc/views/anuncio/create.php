<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo anuncio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo anuncio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		<!-- JS -->
		<script src="/js/Preview.js"></script>
		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo anuncio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Nuevo Anuncio' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo anuncio</h2>
			
			<form method="POST" enctype="multipart/form-data" 
				action="/anuncio/store" class="flex-container gap2">
			
				<div class="flex2">
        			<label>Título</label>
        			<input type="text" name="titulo" value="<?= old('titulo') ?>">
        			<br>
        			<label>Descripcion</label>
        			<textarea name="descripcion"><?= old('descripcion') ?></textarea>
        			<br>
        			<label>Precio</label>
        			<input type="number" name="precio" value="<?= old('precio') ?>">
        			<br>
        			<label>Imagen</label>
        			<input type="file" name="imagen" accept="image/*"  id="file-with-preview">
        			<br>
        			
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>	
    			
    			<figure class="flex2 centrado p2">
            		<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.DEFAULT_ANUNCIO_IMAGE?>"
            			class="cover" id="preview-image" alt="previsualizacion de la imagen"
            			alt="Imagen de <?=$anuncio->titulo?>">
            		<figcaption>Previsualización de la imagen</figcaption>	
            	</figure>
            			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/anuncio/list">Lista de anuncios</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>