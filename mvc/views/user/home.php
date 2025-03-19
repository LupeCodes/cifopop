<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de libros en <?= APP_NAME ?>">
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
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    $user->displayname => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			
			<section class="flex-container" id="user-data">
				<div class="flex2">
					<h2><?= "Home de $user->displayname" ?></h2>
					
					<p><b>Nombre:</b>				<?= $user->displayname ?></p>
					<p><b>Email:</b>				<?= $user->email ?></p>
					<p><b>Teléfono:</b>				<?= $user->phone ?></p>
					<p><b>Fecha de alta:</b>		<?= $user->created_at ?></p>
					<p><b>Última modificación:</b>	<?= $user->updated_at ?? '--' ?></p>
				
				</div>
				<!-- Esta parte solo si creamos la carpeta para las fotos de perfil -->
				<figure class="flex1 centrado">
					<img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>"
						class="cover enlarge-image" alt="Imagen de perfil <?= $user->displayname ?>">
					<figcaption>Imagen de perfil de <?= $user->displayname ?></figcaption>	
				</figure>
			</section>
			
			<a href='/Anuncio/create' class='button'>Nuevo Anuncio</a>
			
			<section>
				<h2>Tus anuncios</h2>
				
				<table class="table w100 centered-block">
        			<tr>
        				<th>Imagen</th><th>Titulo</th><th>Precio</th>
        					<th>Operaciones</th>
        			</tr>
        			
        			<?php foreach($anuncios as $anuncio){?>
        				<script>
							function confirmar(id){
							if(confirm('¿Seguro que deseas eliminar?'))
								location.href = '/Anuncio/destroy/'+id
							}
						</script>
						
        				<tr>
        					<td class="centrado">
        						<img src="<?=ANUNCIO_IMAGE_FOLDER.'/'.($anuncio->imagen ?? DEFAULT_ANUNCIO_IMAGE)?>"
        								class="table-image">
        					</td>
        					<td><?=$anuncio->titulo?></td>
        					<td><?=$anuncio->precio?></td>
        					
        						<td><a href='/Anuncio/edit/<?=$anuncio->id?>'>Editar</a>
        						<a onclick="confirmar(<?= $anuncio->id ?>)">Borrar</a></td>
        						
        					
        				</tr>
        			<?php } ?>
				</table>
			
			</section>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>
