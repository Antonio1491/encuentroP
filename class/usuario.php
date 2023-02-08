<?php

class Usuarios extends Conexion{
    
    public function __construct()
    {
        parent::__construct();
    }

    public function saveUsuario($data)
    {
        $nombre = $data["nombres"];
        $apellido1 = $data["apellidoPaterno"];
        $apellido2 = $data["apellidoMaterno"];
        $correo = $data["correo"];
        $correoSecundario = $data["correoSecundario"];
        $whatsapp = $data["whatsapp"];
        $cargo = $data["cargo"];
        $area = $data["area"];
        $nombreCargo = $data["nombreCargo"];
        $periodo = $data["periodo"];
        $miembro = $data["miembro"];
        $familiar = $data["familiar"];
        $razones = $data["razones"];
        $medio = $data["medio"];
        $acompanante = $data["acompanantes"];
        $condicion = $data["condicion"];
        $linkedin = $data["linkedin"];;
        $alimentacion = $data["alimentacion"];

        $organizacion = $data["organizacion"];
        $correoInstitucional = $data["correoInstitucional"];
        $sector = $data["sector"];
        $direccion = $data["direccion"];
        $pais = $data["pais"];
        $ciudad = $data["ciudad"];
        $estado = $data["estado"];
        $telefono = $data["telefono"];
        $web = $data["web"];
        $redes = $data["redes"];

        $cv = $_FILES["cv"]["tmp_name"];
        $imgName = $_FILES["cv"]["name"];
        $size = $_FILES["cv"]["size"];
        $type = $_FILES["cv"]["type"];

        $logo = $_FILES["logotipo"]["tmp_name"];
        $imgN = $_FILES["logotipo"]["name"];
        $sizelogo = $_FILES["logotipo"]["size"];
        $typelogo = $_FILES["logotipo"]["type"];
     
        $random = $this->random4();

        //remplazar espacios en blanco con '-' y convertir a minusculas
        $logotipo = "img-".$random.mb_strtolower(str_replace(" ", "-", "-".$imgN));
     
        $id = $this->random4();

         //remplazar espacios en blanco con '-' y convertir a minusculas
        $archivo = "cv-".$id.mb_strtolower(str_replace(" ", "-", "-".$imgName));

        //Ruta de los archivos
        $uploads = $_SERVER['DOCUMENT_ROOT'].'/encuentro/src/img/uploads';

        //guardar
        move_uploaded_file($cv, $uploads."/".$archivo);
        move_uploaded_file($logo, $uploads."/".$logotipo);

        $sql = "INSERT INTO usuarios VALUES (null,'$nombre','$apellido1', '$apellido2', '$correo', '$correoSecundario', '$whatsapp', '$cargo', '$area', '$nombreCargo',  '$periodo', '$miembro', '$familiar', '$razones', '$medio', '$acompanante', '$condicion', '$archivo', '$linkedin', '$alimentacion', '$id' )";


        // var_dump($nombre, $apellido1, $apellido2, $correo, $correoSecundario, $whatsapp, $cargo, $area, $nombreCargo,  $periodo, $miembro, $familiar, $razones, $medio, $acompanante, $condicion, $archivo, $linkedin, $alimentacion, $id);

        $consulta = $this->conexion_db->query($sql);
        // die();

        if($consulta){
            $sql = "INSERT INTO organizacion VALUES(null, '$organizacion', '$correoInstitucional', '$logotipo', '$sector', '$direccion', '$pais', '$ciudad', '$estado', '$telefono', '$web', '$redes', '$id' )";

            $consulta = $this->conexion_db->query($sql);

            $mensaje = true;

            $this->correoAsistente($data);
            $this->correoAviso($data);
        }
        else{
            $mensaje = false;
        }

        return ($mensaje);
        
    }

    //generar cadena random de 4 caracteres
    public function random4()
    { 
        $random = bin2hex(random_bytes(2));  
        return $random;
    }

    public function correoAsistente($data){

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8';
        //Luego tenemos que iniciar la validación por SMTP:
        $mail->SMTPDebug = 0 ;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.hostinger.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
        $mail->Username = "soporte@anpr.org.mx"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
        $mail->Password = "Anpr2018*!"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
        $mail->Port = 587; // Puerto de conexión al servidor de envio.
        $mail->SMTPSecure =  "tls"  ; // Habilitar el cifrado TLS
        //cambiar por contenido@congreso@congresoparques.com
        $mail->setFrom("soporte@anpr.org.mx"); // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
        $mail->FromName = "ANPR México"; //A RELLENAR Nombre a mostrar del remitente.
        $mail->addAddress($data["correo"]); // Esta es la dirección a donde enviamos
    
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = "Encuentro Nacional de Lideres de Parques Urbanos y Espacios Públicos"; // Este es el titulo del email.
        $body = "<html><body>
                      <p>¡Gracias por tu interés en participar en el Encuentro Parques!<br>
                      Hemos recibido tu registro, pronto estarás recibiendo un correo con los resultados de selección y con más información. 
                      </p>
                      <p>Si tienes dudas o comentarios puedes comunicarte con Vitoria Martín a contenido@anpr.org.mx</p>
                  </body></html>";
        // $body .= "Aquí continuamos el mensaje";
        $mail->Body = $body;
        // Mensaje a enviar.
        $exito = $mail->Send(); // Envía el correo.
          // if($exito){ echo 'El correo fue enviado correctamente.'; }else{ echo 'Hubo un problema. Contacta a un administrador.'; }
        }


        public function correoAviso($data){

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->CharSet = 'UTF-8';
            //Luego tenemos que iniciar la validación por SMTP:
            $mail->SMTPDebug = 0 ;
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Host = "smtp.hostinger.com"; // A RELLENAR. Aquí pondremos el SMTP a utilizar. Por ej. mail.midominio.com
            $mail->Username = "soporte@anpr.org.mx"; // A RELLENAR. Email de la cuenta de correo. ej.info@midominio.com La cuenta de correo debe ser creada previamente.
            $mail->Password = "Anpr2018*!"; // A RELLENAR. Aqui pondremos la contraseña de la cuenta de correo
            $mail->Port = 587; // Puerto de conexión al servidor de envio.
            $mail->SMTPSecure =  "tls"  ; // Habilitar el cifrado TLS
            //cambiar por contenido@congreso@congresoparques.com
            $mail->setFrom("soporte@anpr.org.mx"); // A RELLENARDesde donde enviamos (Para mostrar). Puede ser el mismo que el email creado previamente.
            $mail->FromName = "Nuevo registro al Encuentro 2023"; //A RELLENAR Nombre a mostrar del remitente.
            $mail->addAddress("conexion@anpr.org.mx"); // Esta es la dirección a donde enviamos
        
            $mail->IsHTML(true); // El correo se envía como HTML
            $mail->Subject = "Plataforma de registro"; // Este es el titulo del email.
            $body = "<html><body>
                          <p>Nuevo usuario registrado:</p>
                          <strong>Nombre: </strong>".$data['nombres']."<br/>
                          <strong>Apellidos: </strong>".$data['apellidoPaterno']." " .$data['apellidoMaterno']."<br/>
                          <strong>Correo: </strong>".$data['correo']."<br/>
                          <strong>Correo secundario: </strong>".$data['correoSecundario']."<br/>
                          <strong>WhatsApp: </strong>".$data['whatsapp']."<br/>
                          <strong>Cargo:</strong>".$data['cargo']."<br/>
                          <p>Organización:</p>
                          <strong>Organizacion:</strong>".$data['organizacion']."<br/>
                          <strong>Sector:</strong>".$data['sector']."<br/>
                          <strong>Ciudad:</strong>".$data['ciudad']."<br/>
                          <strong>Estado:</strong>".$data['estado']."<br/>
                          <strong>Sitio Web:</strong>".$data['web']."<br/>
                      </body></html>";
            // $body .= "Aquí continuamos el mensaje";
            $mail->Body = $body;
            // Mensaje a enviar.
            $exito = $mail->Send(); // Envía el correo.
              // if($exito){ echo 'El correo fue enviado correctamente.'; }else{ echo 'Hubo un problema. Contacta a un administrador.'; }
            }

}

// <strong>Área:</strong>
//                           <strong>Nombre del cargo:</strong>
//                           <strong>Período:</strong>
//                           <strong>Acompañante:</strong>
//                           <strong>Objetivos:</strong>
//                           <strong>Medio por el que se entero:</strong>
//                           <strong>Número de acompañantes:</strong>
//                           <strong>Condición alimentaria:</strong>
//                           <strong>CV:</strong>
//                           <strong>Linkedin: </strong>

?>