<?php
    require_once 'models/usuario.php';
    class UsuarioController{
        public function index(){
            echo "Controlador usuario, Accion index";
        }
        public function registro(){
            require_once 'views/usuario/registro.php';
        }
        public function save(){
            if(isset($_POST)){

               $nombre=isset($_POST['nombre'])?$_POST['nombre']:false;
               $apellidos=isset($_POST['apellidos'])?$_POST['apellidos']:false;
               $email=isset($_POST['email'])?$_POST['email']:false;
               $password=isset($_POST['password'])?$_POST['password']:false;  
               
                //Array de errores
                $errores=array();
                
                // Validar los datos
                if(!empty($nombre)&& !is_numeric($nombre)&&!preg_match("/[0-9]/",$nombre)){
                    $nombre_validate=true;
                }
                else{
                    $nombre_validate=false;
                    $errores['nombre']="El nombre no es valido";
                }
            
                //Validar apellido
                if(!empty($apellidos)&& !is_numeric($apellidos)&&!preg_match("/[0-9]/",$apellidos)){
                    $apellido_validate=true;
                }
                else{
                    $apellido_validate=false;
                    $errores['apellidos']="El apellido no es valido";
                }
                //Validar email
                if(!empty($email)&&filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $email_validate=true;
                }
                else{
                    $email_validate=false;
                    $errores['email']="El email no es valido";
                }
                //Validar contraseña
                if(!empty($password)){
                    $password_validate=true;
                }
                else{
                    $password_validate=false;
                    $errores['password']="La contraseña esta vacia";
                }

                var_dump($errores);

               if($nombre && $apellidos && $email && $password && count($errores)==0){

                   $usuario=new Usuario();
                   $usuario->setNombre($nombre);
                   $usuario->setApellidos($apellidos);
                   $usuario->setEmail($email);
                   $usuario->setPassword($password);
                   $save=$usuario->save();

                   if($save){
                       $_SESSION['register']="complete";
                   }
                   else{
                       $_SESSION['register']="failed";
                   }
               }
               else{
                    $_SESSION['errores']=$errores;
                    $_SESSION['register']="failed";
               }          
            }
            else{
                
                $_SESSION['register']="failed";
            }
            header("Location:".base_url.'usuario/registro');
        }
    }
?>