<?php 
namespace App;

class Propiedad{
    //base de datos
    protected static $db;
    protected static $columnaBD = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
    
    //Errores
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    //Definir la conexión a la BD
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar(){
        if (isset($this->id)) {
            //Actualizar
            $this->actualizar();
        } else{
            //Creando un nuevo registro
            return $this->crear();
        }
    }

    public function crear(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));  //La función array keys está retornando un string con las llaves del arreglo separados por una coma y un espacio
        $query .= " ) VALUES('"; 
        $query .= join("', '", array_values($atributos));  //La función array values está retornando un string con los valores del arreglo separados por una comillas, coma y un espacio
        $query .= " ') ";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function actualizar(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores [] = "{$key}='{$value}'";
        }
        
        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '". self::$db->escape_string($this->id). "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);
        if ($resultado) {
            header('Location: /admin?resultado=2&id='.$this->id);
        }
    }

    //Eliminar un registro
    public function eliminar(){
        $query = " DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";

        if (self::$db->query($query)) {
            $this->eliminarImagen();
            header('Location: /admin?resultado=3&id='.$this->id);
        }
    }
    
    public function sanitizarAtributos(){
        $atributos =  $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }
    //Identificar y unir los atributos de la BD
    public function atributos(){
        $atributos = [];
        foreach (self::$columnaBD as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    //Subida de archivos
    public function setImagen($imagen){
        //Elimina la imagen previa
        if (isset($this->id))
            $this->eliminarImagen();

        //Asignar al atributo el nombre de la imagen
        if ($imagen)
            $this->imagen = $imagen;
    }

    //Elimina el archivo
    public function eliminarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
    
    //Validación
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if(!$this->titulo)
            self::$errores[] = "Debes añadir un titulo";

        if (!$this->precio) 
            self::$errores[] = "El precio es obligatorio";
            
        if ( strlen ( $this->descripcion ) < 50)
            self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";

        if (!$this->habitaciones) 
            self::$errores[] = "El número de habitaciones es obligatorio";

        if (!$this->wc) 
            self::$errores[] = "El número de baños es obligatorio";

        if (!$this->estacionamiento)
            self::$errores[] = "El número de lugares de estacionamiento es obligatorio";

        if (!$this->vendedorId) 
            self::$errores[] = "Elige un vendedor";

         if (!$this->imagen)
             self::$errores[] = "La imagen es obligatoria";

        return self::$errores;
    }

    //Lista todas las propiedades
    public static function all(){
        $query = "SELECT * FROM propiedades";
        return self::consultarSQL($query);
    }

    //Busca una propiedad por su ID
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        
        //Retorna el primer elemento de un arreglo
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar la BD
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new self;
        foreach ($registro as $key => $value) {
            if(property_exists($objeto, $key))
                $objeto->$key = $value;
        }
        return $objeto;
    }

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []){
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}