<?php

namespace Model;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'usuario', 'nombre', 'apellido', 'email', 'password', 'admin', 'confirmado', 'token'];

    public $id;
    public $usuario;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id         = $args['id']         ?? null;
        $this->usuario    = $args['usuario']    ?? '';
        $this->nombre     = $args['nombre']     ?? '';
        $this->apellido   = $args['apellido']   ?? '';
        $this->email      = $args['email']      ?? '';
        $this->password   = $args['password']   ?? '';
        $this->password2  = $args['password2']  ?? '';
        $this->admin      = $args['admin']      ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token      = $args['token']      ?? '';
    }

    // Validación del formulario de login (por usuario + password)
    public function validarLogin() {
        if(!$this->usuario) {
            self::$alertas['error'][] = 'El usuario es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
}
