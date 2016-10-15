<?php

class Yathzee extends Spel {

    private $running = false;
    private $count = 0;
    private $playerTurn;
    private $tel;
    private $db;
    private $speler1;
    private $nivo;
    private $dobbel1;
    private $dobbel2;
    private $dobbel3;
    private $dobbel4;
    private $dobbel5;

    private $dobbel1St;
    private $dobbel2St;
    private $dobbel3St;
    private $dobbel4St;
    private $dobbel5St;
    //private $speler2;

    private $turn = true;
    private $botnumber;

    public function __construct() {
        $this->start();
        $this->running = true;
    }

    public function start() {
        $this->dobbel1= rand(1,6);
        $this->dobbel2= rand(1,6);
        $this->dobbel3= rand(1,6);
        $this->dobbel4= rand(1,6);
        $this->dobbel5= rand(1,6);
        $this->playerTurn = false;
    }

    /**
     * @return mixed
     */
    public function getNivo()
    {
        return $this->nivo;
    }

    public function playGame($post) {

        if (!isset($post['count']) && !isset($post['speler1']) && !isset($post['speler2'])) {
            $this->register();
        } else {

            if (isset($post['speler1'])) {
                $this->speler1 = $post['speler1'];
            }

            if (isset($post['count'])) {
                $this->playerTurn($post);
            }

            if (isset($post['newgame'])) {
                $this->start();
            }
            if (isset($post['nivo'])) {
                if($post['nivo']=="moeilijk"){
                   $this->nivo= "moeilijk";
                }
            }
            $this->display();
        }
    }

public function getTel()
{

    return $this->tel;
}
    public function bot(){

$tel = $this->tel;
        if($this->nivo =="moeilijk") {
            if ($tel - 3 == 4) {
                $this->botnumber = 3;
            }
            if ($tel - 2 == 4) {
                $this->botnumber = 2;
            }
            if ($tel - 1 == 4) {
                return $this->botnumber = 1;
            }


            switch ($tel) {
                case "3":
                    return $this->botnumber = 3;
                    break;
                case "2":
                    return $this->botnumber = 2;
                    break;
                case "1":
                    return $this->botnumber = 1;
                    break;
                default:
                    return $this->botnumber = rand(1, 3);


            }
        }
        else{ switch ($tel) {
            case "3":
                return $this->botnumber = 3;
                break;
            case "2":
                return $this->botnumber = 2;
                break;
            case "1":
                return $this->botnumber = 1;
                break;
            default:
                return $this->botnumber = rand(1, 3);


        }}
    }




    public function register() {
        echo "<h1> Speel het spel nim tegen de pc</h1>";
        echo "<span>Naam: </span><input type='text' name='speler1'><br>";
        echo "<span>Moeilijkheid: </span><input type='radio' value='moeilijk' checked name='nivo'><br>";
        echo "<span>Makkelijk: </span><input type='radio' value='makkelijk' name='nivo'>";
        echo "<br><br>";
        echo "<button class='btn btn-success' type='submit' value='start game' name='newgame'>start game</button>";
    }

    public function gameEnded() {
        if ($this->turn){
            echo "<h1> PC WINT</h1>";
            echo "<h2>HAHAHAHA de bot is slimmer dan jij noob.</h2> <br> <input class='btn btn-success' type='submit' value='Start een nieuwe spel' name='newgame'>";
        }
         else {
            echo "<h1>".$this->speler1." WINT</h1>";
            echo "<h2> <input class='btn btn-success' type='submit' value='Start a new game' name='newgame'>";
         }
         $this->setData();
    }

    public function isOver() {
        if ($this->tel <= 0)
            return true;
        else
            return false;
    }

    public function playerTurn($post) {
        if ($this->isOver())
            return;
        $this->count = $post['count'];
        if($this->turn == true){
            $this->count=$this->bot();
        }
        $this->tel = $this->tel - $this->count;
        if ($this->isOver())
            return;
    }

    public function display() {
        if (!$this->isOver()) {
            if ($this->turn == true) {

            if ($this->turn)
                echo "<h1>" . $this->speler1 . "'s beurt</h1>";
            if ($this->tel >= 1)
                echo "<input class='btn btn-success' type='submit' value='1' name='count'>";
            if ($this->tel >= 2)
                echo "<input class='btn btn-success' type='submit' value='2' name='count'>";
            if ($this->tel >= 3)
                echo "<input class='btn btn-success' type='submit' value='3' name='count'>";
        }
            else{
                echo "<h1>laat de bot nu kiezen</h1><br>";
                echo "<input class='btn btn-success' type='submit' value='bots turn' name='count'>";
            }


            $this->turn = !$this->turn;
        } else {
            $this->gameEnded();
        }
    }

    public function connect() {
        $this->db = new PDO('mysql:host=' . SpelData::database . ';dbname=' . SpelData::dbname . ';charset=utf8mb4', SpelData::username, SpelData::password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }



    public function setData() {
        $this->connect();
        $query = $this->db->query('SELECT id, username, score FROM user WHERE username="'.$this->speler1.'"');
        if (!$this->turn){
            if ($query->rowCount() > 0){
                foreach($query as $row){
                    $newScore = $row['score'] += 1;
                    $this->db->exec('UPDATE user SET score="'.$newScore.'" WHERE id='.$row['id']);
                }
            } else {
                $this->db->exec('INSERT INTO user (username, score) VALUES ("'.$this->speler1.'", 1)');
            }

        }
            if (!$query->rowCount() > 0){
                $this->db->exec('INSERT INTO user (username) VALUES ("'.$this->speler1.'")');
            }

        $this->disconnect();
    }
    public function disconnect() {
        $this->db=null;
    }
}
