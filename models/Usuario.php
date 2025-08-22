<?php 

namespace Model;

class Usuario extends ActiveRecord{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','email','password','toke','confirmado'];

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;

    public function __construct($args=[]){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? '';
    }

    // VAlidacion para cuentas nuevas
    public function validarNuevaCuenta(){
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es necesario';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El email es necesario';
        }

        if (!$this->password) {
            self::$alertas['error'][] = 'El password no puede estar vacio';
        }

        if (strlen($this->email) < 6) {
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }

        if ($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los passwords son diferentes';
        }

        return self::$alertas;
    }
}