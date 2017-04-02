<?php
//$dbh->query("SELECT login, password,xo_online FROM clients WHERE login='" . $login . "'");
//$dbh->prepare("UPDATE clients SET xo_online = 'true' WHERE login='" . $login . "'");

//die();


class Application
{
    private function DB_connect(){
        $dsn = 'mysql:dbname=Team_4;host=127.0.0.1';
        $user = 'root';
        $password = '';

        try {
            $dbh = new PDO($dsn, $user, $password);
            return $dbh;
        } catch (PDOException $e) {
            return 'Connection failed: ' . $e->getMessage();
        }
    }
    public function Auth_Select($login){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT login, password,xo_online FROM clients WHERE login= :login ");
        $sth->execute(array( ':login' => $login ));
        return $sth->fetchAll();
    }
    public function Update_auth_xo($login, $value){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("UPDATE clients SET xo_online=:xo_online WHERE login=:login");
        $sth->execute(array( ':xo_online'=> $value,':login' => $login ));
    }
    public function Update_auth_chat($login, $value){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("UPDATE clients SET chat_online=:xo_online WHERE login=:login");
        $sth->execute(array( ':xo_online'=> $value,':login' => $login ));
    }
    public function Game_start_select($who,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT who, who_fract, who_turn, opponent, block, value FROM game WHERE who =:who AND opponent =:opponent");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent));
        return $sth->rowCount();
    }
    public function Game_start_insert($who,$who_fract,$who_turn,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("INSERT INTO game(who, who_fract, who_turn, opponent ,block ,value) VALUES(:who, :who_fract, :who_tutn, :opponent, :block, :value)");
        $sth->execute(array( ':who' => $who,':who_fract' => $who_fract,':who_tutn' => $who_turn, ':opponent' => $opponent, ':block' => '',':value' => ''));
    }
    public function Game_check($who,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT who, opponent, block, value FROM game WHERE who =:who AND opponent =:opponent
                OR who =:opponent AND opponent =:who ");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent));
        return $sth->fetchAll();
    }
    public function Game_make_num($who,$opponent,$block){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT who,opponent, block FROM game WHERE who =:who
              AND opponent =:opponent AND block =:block OR who =:opponent
              AND opponent =:who AND block =:block");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent, ':block' => $block));
        return $sth->rowCount();
    }
    public function Game_make_insert($who,$who_fract,$who_turn,$opponent,$block,$value){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("INSERT INTO game(who, who_fract, who_turn, opponent ,block ,value) VALUES(:who, :who_fract, :who_turn, :opponent, :block, :value)");
        $sth->execute(array( ':who' => $who, ':who_fract'=> $who_fract, ':who_turn'=> $who_turn, ':opponent' => $opponent, ':block' => $block , ':value'=>$value));
        return $sth->rowCount();
    }
    public function Game_make_select($who,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT MAX(id), who, who_fract, who_turn, opponent, block, value FROM game 
                  WHERE who =:who AND opponent =:opponent AND id ='".$max[0]."'
                  OR who =:opponent AND opponent =:who AND id ='".$max[0]."'");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent));
        return $sth->fetchAll();
    }
    public function Game_end($who,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("DELETE FROM game WHERE who =:who AND opponent =:opponent OR who =:opponent AND opponent =:who ");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent));

    }
    public function Mail_send($email){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT login, password, email FROM clients WHERE email=:email");
        $sth->execute(array( ':email' => $email ));
        return $sth->fetchAll();

    }
    public function Receive($receiver){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT sender,header,body FROM messages_xo WHERE receiver = :receiver");
        $sth->execute(array( ':receiver' => $receiver ));
        return $sth->fetchAll();
    }
    public function Receiver_delete($receiver){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("DELETE FROM messages_xo WHERE receiver = :receiver");
        $sth->execute(array( ':receiver' => $receiver ));
        return $sth->fetchAll();
    }
    public function Send($sender,$receiver,$header,$body){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("INSERT INTO messages_xo(sender,receiver,header,body) VALUES(:sender,:receiver,:header,:body)");
        $sth->execute(array( ':sender' => $sender ,':receiver' => $receiver, ':header'=> $header, ':body'=> $body ));
    }
    public function Registration($login,$email){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT login,email FROM clients WHERE login=:login OR email =:email ");
        $sth->execute(array( ':login' => $login ,':email' => $email));
        return $sth->fetchAll();
    }
    public function Registration_created($login,$password,$email){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("INSERT INTO clients(login,password,email,banned) VALUES(:login, :password, :email,'false')");
        $sth->execute(array( ':login' => $login ,':password'=>$password,':email' => $email));
    }
    public function Local($lang){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT * FROM local WHERE lang=:lang");
        $sth->execute(array( ':lang' => $lang));
        return $sth->fetchAll();
    }
}