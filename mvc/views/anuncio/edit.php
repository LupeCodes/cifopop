<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar anuncio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Editar anuncio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>
		<script src="/js/Preview.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Editar ', $anuncio->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    $anuncio->titulo => '/anuncio/show/$anuncio->id',
		    'Editar anuncio' => NULL
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar anuncio</h2>
			
			<section class="flex-container gap2">
			
    			<form method="POST" action="/anuncio/update" class="flex2 no-border no-shadow"
    				enctype="multipart/form-data">
    			     <!-- input oculto que contiene el id del libro a actualizar -->
    				 <input type="hidden" name="id" value="<?= $anuncio->id ?>">
    			
    				<div class="flex2">
            			<label>Título</label>
            			<input type="text" name="titulo" value="<?= old('titulo', $anuncio->titulo) ?>">
            			<br>
            			<label>Descripcion</label>
            			<textarea name="descripcion"> <?= old('descripcion', $anuncio->descripcion) ?>
            			</textarea>
            			<br>
            			<label>Precio</label>
            			<input type="number" name="precio" value="<?= old('precio'), $anuncio->precio ?>">
            			<br>
            			<label>Imagen</label>
            			<input type="file" name="imagen" accept="image/*" id="file-with-preview">
            			<br>
            			
            		
            			
            			<div class="centered mt2">
            				<input type="submit" class="button" name="actualizar" value="Actualizar">
            				<input type="reset" class="button"  value="Reset">
            			</div>
            		</div>
				</form>
				
				<figure class="flex1 centrado no-shadow">
					<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
						class="cover enlarge-image" alt="Imagen de <?= $anuncio->titulo ?>"
						id="preview-image">
					<figcaption>Foto de <?="$anuncio->titulo" ?></figcaption>
					
					<!-- Boton para eliminar la portada (sin cambiar nada más) -->
					<?php if($anuncio->portada){?>
					<form method="POST" action="/anuncio/dropimagen" class="no-border no-shadow">
						<input type="hidden" name="id" value="<?=$anuncio->id?>">
						<input type="submit" class="button-danger"
							name="borrar" value="Eliminar foto">
					</form>
					<?php } ?>
				</figure>
			
			</section>
			
			
			<section>
				<script>
					function confirmar(id){
						if(confirm('¿Seguro que deseas eliminar?'))
							location.href = '/Ejemplar/destroy/'+id
					}
				</script>
			
				<h3>Ejemplares del libro <b><?=$libro->titulo?></b></h3>
				<a class="button" href="/Ejemplar/create/<?= $libro->id ?>">
        			Nuevo Ejemplar
        		</a>
        		
        		<?php 
        		  if(!$ejemplares){
        		    echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
        		  }else{
        		?>
        		
				<table class="table w100 centered-block">
        			<tr>
        				<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($ejemplares as $ejemplar){?>
        				<tr>
        					<td><?=$ejemplar->id?></td>
        					<td><?=$ejemplar->anyo?></td>
        					<td><?=$ejemplar->precio?></td>
        					<td><?=$ejemplar->estado?></td>
        					
        					<td class="centered">
        					<?php if(!$ejemplar->hasAny('Prestamo')) { ?>
        						<a onclick="confirmar(<?= $ejemplar->id ?>)">Borrar</a>
        					<?php }  ?>
        					</td>
        				</tr>
        			<?php } //mm ?>
        		</table>
        		<?php }  ?>
			</section>
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
				<a class="button" href="/libro/show/<?= $libro->id ?>">Detalles</a>
				<a class="button" href="/libro/delete/<?= $libro->id ?>">Borrado</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>