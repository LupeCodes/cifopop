<?php
class AnuncioController extends Controller{
    
    //metodo por defecto-----------------------------------------
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE ANUNCIOS-----------------------------------
    public function list(int $page = 1){
        //analiza si hay filtros, pone uno nuevo o quita el existente
        $filtro = Filter::apply('anuncios');
        
        $limit = RESULTS_PER_PAGE;  //numero de resultados x pagina, en el config
        
        //si hay filtro
        if($filtro){
            $total = Anuncio::filteredResults($filtro);    //el total de anuncios q hay
            
            //el objeto paginador
            $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);
            
            //recupera los anuncios que cumplen los criterios de busqueda
            $anuncios = Anuncio::filter($filtro, $limit, $paginator->getOffset());
            //si no hay filtro...
        }else{
            //recupera el total de anuncios
            $total= Anuncio::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Anuncio/list', $page, $limit, $total);
            
            //recupera todos los libros
            $anuncios = Anuncio::orderBy('id', 'DESC', $limit, $paginator->getOffset());
        }
        //dd($anuncios);
        //carga la vista que los muestra
        //el view es un helper
        return view('anuncio/list',[
            'anuncios'    => $anuncios,
            'paginator' => $paginator,
            'filtro'    =>  $filtro
        ]);
    }//FIN DEL METODO
    
    
    //DETALLES DEL ANUNCIO---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $anuncio = Anuncio::findOrFail($id);    //busca el anuncio con ese ID
        
        
        //carga la vista y le pasa el libro recuperado
        return view('anuncio/show',[
            'anuncio' => $anuncio
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        
        return view('anuncio/create');
    }
    
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
            
            $anuncio = new Anuncio();   //creamos el nuevo anuncio
            $usuario = Login::user();
            $iduser = $usuario->id;
            //toma los datos que llegan por POST
            //en la configuracion, las cadenas vacias las guarda como null
            //para poner un valor por defecto seria asi
            //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
    
            $anuncio->titulo              =request()->post('titulo');
            $anuncio->descripcion         =request()->post('descripcion');
            $anuncio->precio              =request()->post('precio');
            $anuncio->iduser              =$iduser;  
            
            //intenta guardar el libro. En caso de que la insercion falle
            //vamos a evitar ir a la página de error y volveremos
            //al formulario "nuevo libro"
            try{
              
                $anuncio->save();
                    
                    //recupera la imagen como objeto UploadedFile (o null si no llega)
                $file = request()->file(
                        'imagen',  //nombre del input
                        8000000,    //tamaño máximo del fichero
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp'] //tipos aceptados
                        );
                    
                    //si hay fichero, lo guardamos y actualizamos el campo "portada"
                    if($file){
                        $anuncio->imagen = $file->store('../public/'.ANUNCIO_IMAGE_FOLDER, 'anu_');
                        $anuncio->update();   //actualiza el anuncio para añadir la portada
                    }
                    
                    //flashea un mensaje de éxito en la sesión
                    Session::success("Guardado del anuncio $anuncio->titulo correcto");
                    
                    //redirecciona a los detalles del anuncio que hemos guardado
                    return redirect("/anuncio/show/$anuncio->id");
                    
                    //si falla el guardado del anuncio nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el anuncio $anuncio->titulo");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de anuncio
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Anuncio/create");
                    
                    //si falla el guardado de la portada...
            }catch(UploadException $e){
                //preparamos un mensaje de advertencia
                //no de error, puesto que el libro se guardó
                Session::warning("El anuncio se guardó correctamente,
                                pero no se pudo subir el fichero de imagen");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    //redirigimos a la edicion del libro
                    //por si se quiere volver a intentar subir la imagen
                    redirect("/Anuncio/edit/$anuncio->id");
                    
                    //y aqui el catch de la validacion
            }
    }//FIN DE FUNCION STORE
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        
        //recuperamos el usuario que ha hecho login
        $usuario = Login::user();
        $idlogin = $usuario->id;
        
        //busca el libro con ese ID
        $anuncio = Anuncio::findOrFail($id, "No se encontró el anuncio");
        $iduser = $anuncio->iduser;
        //primero comprobamos que el usuario que está intentando
        //editar el anuncio es el mismo que lo ha creado
        if($idlogin == $iduser){
        //retornamos una ViewResponse con la vista con el formulario de edicion
            return view('anuncio/edit', [
                'anuncio'      => $anuncio
            ]);
        }else{
            throw new AuthException('No puedes hacer esto, no seas tramposete');
        }
        
    }//FIN DE EDIT
    
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
             
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
            $id = intval(request()->post('id'));    //recuperar el id vía POST
            
            $anuncio = Anuncio::findOrFail($id, "No se ha encontrado el anuncio.");
            
            //recuperar el resto de campos
            $anuncio->titulo              = request()->post('titulo');
            $anuncio->descripcion         = request()->post('descripcion');
            $anuncio->precio              = request()->post('precio');
            
            
            //intentamos actualizar el libro
            try{
                //recuperamos el usuario que ha hecho login
                $usuario = Login::user();
                $idlogin = $usuario->id;
                
                //busca el libro con ese ID
                //$anuncio = Anuncio::findOrFail($id, "No se encontró el anuncio");
                $iduser = $anuncio->iduser;
                //primero comprobamos que el usuario que está intentando
                //editar el anuncio es el mismo que lo ha creado
                if($idlogin == $iduser)
                    
                    $anuncio->update();
                    
                    //ahora recupera la portada como objeto UploadedFile (o null si no llega)
                    $file = request()->file(
                        'imagen',  //nombre del input
                        8000000,    //tamaño maximo del fichero
                        ['image/png', 'image/jpeg', 'image/gif', 'image/webp']  //tipos aceptados
                        );
                    
                    //si llega un nuevo fichero...
                    if($file){
                        if($anuncio->imagen) //si el libro ya tenia portada, la elimina
                            File::remove('../public/'.ANUNCIO_IMAGE_FOLDER.'/'.$anuncio->imagen);
                            
                            //coloca el nuevo fichero (portada) y actualiza la propiedad
                            $anuncio->imagen = $file->store('../public/'.ANUNCIO_IMAGE_FOLDER,'anu_');
                            $anuncio->update();   //actualiza solamente el campo portada
                    }
                    
                    Session::success("Actualización del anuncio $anuncio->titulo correcta.");
                    return redirect("/Anuncio/edit/$id");
                    
                    //si se produce un error al guardar el anuncio
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización del anuncio $anuncio->titulo");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Anuncio/edit/$id");
                    //si falla la actualizacion de la portada...
            }catch(UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la imagen");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                return redirect("/Anuncio/edit/$id");
            }
            
    }//FIN DE UPDATE
    
    
    
    
}//FIN DE LA CLASE