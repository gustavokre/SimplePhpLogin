<?php
    namespace gustavokre\classes;
    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\SMTP;
    use \PHPMailer\PHPMailer\Exception;


    class Recover{
        const INIFILE = "email.ini";
        //recover life token in minutes
        const RECOVER_LIFE = 120;
        private $cfg;
        private $pdo;
        private $token;
        private $expires;
        private $login;
        private $email;
        private $errors;

        public function __construct($email)
        {
            if(!$this->cfg = $this->load_ini_config()){
                throw new Exception("Configuração de email inválida");
            }
            $this->email = $email;
            $this->pdo = Database_connection::get_connection();

        }

        public function generate_recover_link(){
            $url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";  
            $url.= $_SERVER['HTTP_HOST'];   
            $url.= $this->cfg['recover_link'] . "?token=" . $this->token . "&email=" . $this->email;
            return $url;
        }

        public function change_password($new_password){
            $table = Database_connection::TABLENAME;
            $hash = User::generate_password_hash($new_password);
            $stmt = $this->pdo->prepare("UPDATE $table SET password_hash=:pass_hash WHERE email=:uemail");
            $stmt->bindValue(':uemail', $this->email, \PDO::PARAM_STR);
            $stmt->bindValue(':pass_hash', $hash, \PDO::PARAM_STR);
            
            if(!$stmt->execute()) {
                throw new Exception($this->pdo->errorInfo()[2]);
            }
        }

        public function generate_html_body_email(){
            return $this->login . "<br>Clique neste link para trocar sua senha: <a href=" . $this->generate_recover_link() . ">Recuperar Senha</a><br>Este token expira em: " . self::RECOVER_LIFE . " minutos.<br>fim da mensagem";
        }

        public function generate(){
            if($this->is_valid_email()){
                $this->generate_token();
                $this->generate_expires();
                if($this->save_recover()){
                    return;
                }
                throw new Exception("Recover não foi salvo no banco de dados");
                return;
            }
            throw new Exception("Email não foi encontrado");
            return;
        }

        public function save_recover(){
            $table = Database_connection::TABLENAME_RECOVER;
            $stmt = $this->pdo->prepare("INSERT INTO $table (userLogin, email, token, expires) VALUES(:userLogin,:email,:token,:expires) ON DUPLICATE KEY UPDATE token=:token, expires=:expires");
			$stmt->bindValue(':userLogin', $this->login, \PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, \PDO::PARAM_STR);
            $stmt->bindValue(':token', $this->token, \PDO::PARAM_STR);
            $stmt->bindValue(':expires', $this->expires, \PDO::PARAM_STR);
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }
            return true;
        }

        public function generate_expires(){
            $this->expires = date("Y-m-d H:i:s", strtotime("+" . self::RECOVER_LIFE . "minutes"));
        }

        public function generate_token(){
            $token = base64_encode(random_bytes(64));
            $this->token = strtr($token, '+/', '-_');
        }

        public function is_valid_email(){
            $table = Database_connection::TABLENAME;
            $stmt = $this->pdo->prepare("SELECT userLogin FROM $table WHERE email=:uemail");
            $stmt->bindValue(':uemail', $this->email, \PDO::PARAM_STR);
            
            if(!$stmt->execute()) {
                array_push($this->errors, $this->pdo->errorInfo());
                return false;
            }

            while($user = $stmt->fetch(\PDO::FETCH_ASSOC)){
                $this->login = $user['userLogin'];
                return true;
            }
            array_push($this->errors, "Nenhuma conta com este e-mail foi encontrado.");
            return false;

        }

        public function send_email(){

            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Timeout    = $this->cfg['timeout'];                  // Timeout in seconds
                $mail->getSMTPInstance()->Timelimit = $this->cfg['timeout']; // Timeout in seconds
                $mail->Host       = $this->cfg['host'];                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $this->cfg['email'];                     // SMTP username
                $mail->Password   = $this->cfg['password'];                               // SMTP password
                $mail->SMTPSecure = $this->cfg['encrypt'] == 0 ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $this->cfg['port'];                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($this->cfg['email'], 'Recover Password');
                $mail->addAddress($this->email);               // Name is optional

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Recover Password';
                $mail->Body    = $this->generate_html_body_email();

                $mail->send();
                return true;
            } catch (\Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                return false;
            }
        }

        public function is_valid_token($token){
            $table = Database_connection::TABLENAME_RECOVER;
            $stmt = $this->pdo->prepare("SELECT token, expires FROM $table WHERE email=:email");
            $stmt->bindValue(':email', $this->email, \PDO::PARAM_STR);
            
            if(!$stmt->execute()) {
                array_push($this->errors, $stmt->errorInfo());
                return false;
            }

            if($db = $stmt->fetch(\PDO::FETCH_ASSOC)){
                $this->expires = $db['expires'];
                if($token === $db['token'] && !$this->is_expired()){
                    return true;
                }
            }
            return false;
        }

        public function get_full_directory(){
            $fullDir = [ 
                realpath("../" . "/cfg/" . self::INIFILE),
                $_SERVER['DOCUMENT_ROOT'] . "/cfg/" . self::INIFILE,
                $_SERVER['DOCUMENT_ROOT'] . "/src/cfg/" . self::INIFILE
            ];
            foreach($fullDir as $val){
                if(file_exists($val)){
                    return $val;
                }
            }
            return false;
        }

        public function load_ini_config(){
            $fullDir = $this->get_full_directory();
            if(!$fullDir){
                throw new \Exception(sprintf(MultiLang::get_text("DB_FILE_NOT_FOUND"), $fullDir));
                return false;
            }
            if($cfg = parse_ini_file(realpath($fullDir))) return $cfg;
            return false;
        }

        function is_expired(){
            $time = strtotime($this->expires);
            $cur_time = time();
            if($cur_time > $time){
                return true;
            }
            return false;
        }

        public function get_errors(){
            return $this->errors;
        }

    }

?>