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
    public function Game_check($who,$opponent){
        $dbh = Application::DB_connect();
        $sth = $dbh->prepare("SELECT who, opponent, block, value FROM game WHERE who =:who AND opponent =:opponent
                OR who =:opponent AND opponent =:who ");
        $sth->execute(array( ':who' => $who, ':opponent' => $opponent));
        return $sth->fetchAll();
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
        $sth->execute(array( ':who' => $who,':who_fract' => $who_fract,':who_turn' => $who_turn, ':opponent' => $opponent, ':block' => "",':value' => ""));
    }

}