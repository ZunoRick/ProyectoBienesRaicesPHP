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
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES(' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);
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

    public function sanitizarAtributos(){
        $atributos =  $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
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

        // if (!$this->imagen['name'] || $this->imagen['error'])
        //     self::$errores[] = "La imagen es obligatoria";

        // //Validar por tamaño (100Kb máximo)
        // $medida = 1024 * 1000;
        // if ($this->imagen['size'] > $medida) 
        //     self::$errores[] = "La imagen es muy pesada";

        return self::$errores;
    }
}