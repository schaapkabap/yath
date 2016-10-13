<?php


class Yahtzee
{
//    private $database;
    //    private $computer;
    //    private $count = 0;
//    private $spelersBeurt;
//    private $beurt = true;
    private $speler1;
    private $running = false;
    /*private $dice1;
    private $dice2;
    private $dice3;
    private $dice4;
    private $dice5;
    private $dice1B;
    private $dice2B;
    private $dice3B;
    private $dice4B;
    private $dice5B;*/
    private $dicesB= array(TRUE,TRUE,TRUE,TRUE,TRUE);
    private $dices= array(0,0,0,0,0);
    private $deel1= array(0,0,0,0,0,0);
    private $deel2= array(0,0,0,0,0,0);
    private $turn;
    private $zelfde= array(0,0,0,0,0);
    //private $scoreblad= array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
    private $scoreblad;


    public function __construct()
    {
        $this->setTurn(4);
        $this->scoreblad= array(
            "Eenen"=>'',
            "Tweeen"=>'',
            "Drieen"=>'',
            "Vieren"=>'',
            "Vijven"=>'',
            "Zessen"=>'',
            "Threeofkind"=>'',
            "Fourofkind"=>'',
            "Fullhouse"=>'',
            "Kleinestraat"=>'',
            "Grotestraat"=>'',
            "Yathzee"=>'',
            "Change"=>'',
            "Bonus"=>'',
            "Totaaldeel1"=>'',
            "Totaaldeel2"=> ''
            );
        $this->start();

        $this->running = true;

    }

    public function start()
    {
        $this->spelersBeurt = false;
    }

    public function play($postdata)
    {
        //werkt nog niet goed
        if(isset($postdata['Reset'])){
            $this->reset();
            session_destroy();


        }

        foreach($this->scoreblad as $key =>$value ){


            if(isset($postdata[$key])){
                $this->setScoreblad($key,$postdata[$key]);

            }}

        if(isset($postdata['score'])){
            $this->setscore();
        }
        if (!isset($this->speler1)) {

            for($i = 0; $i < count($this->dicesB); $i++){
                if (isset($postdata[$i])){
                    $this->dicesB[$i] = FALSE;
                }else $this->dicesB[$i] = TRUE;}
            $this->weergave();
        } else {

            if (isset($postdata['speler1'])) {
                $this->speler1 = $postdata['speler1'];

            }

            if (isset($postdata['generate'])){/*
                echo $this->dicesB[1];
                for($i = 0; $i < count($this->dicesB); $i++){
                    if ($postdata["'".$i."'"] == "false"){
                        $this->dicesB[$i] = FALSE;
                }}
               echo var_dump($this->dicesB);
                $this->generateDiceValue();*/
            }


            if (isset($postdata['newgame'])) {
                $this->start();
            }

            $this->weergave();
        }
    }

    /**
     * @return int
     */
    public function getTurn()
    {
        return $this->turn;
    }
    /**
     * @return int
     */
public function setTurn($turn){
    return $this->turn= $turn;
}

public function reset(){
    
}
    public function getScoreblad()
    {
        $score=


            $this->scoreblad['Eenen']." eenen<br>".
            $this->scoreblad['Tweeen']." tweeen<br>".
            $this->scoreblad['Drieen']." drieen<br>".
            $this->scoreblad['Vieren']." vieren<br>".
            $this->scoreblad['Vijven']." vijven<br>".
            $this->scoreblad['Zessen']." zessen <br><br>".
            $this->scoreblad['Bonus']." bonus<br>".
            $this->scoreblad['Totaaldeel1']. " totaal deel1<br>".
            $this->scoreblad['Threeofkind']. " three of kind<br>".
            $this->scoreblad['Fourofkind']." four of kind<br>".
            $this->scoreblad['Fullhouse']." full house<br>".
            $this->scoreblad['Kleinestraat']." Kleine straat<br>".
            $this->scoreblad['Grotestraat']." Grote straat<br>".
            $this->scoreblad['Yathzee']." Yathzee<br>".
            $this->scoreblad['Change']." change<br>".
            $this->scoreblad['Totaaldeel2']." totaal deel2<br>".
            $this->scoreblad['Totaaldeel1']. " totaal deel1<br>".
            "totaal score";

        return $score;
    }
//    public function register()
//    {
//        echo "<span>Wat is je naam?: </span><input class='inputregister' type='text' name='speler1'>";
//        echo "<br>";
//        echo "<input type='submit' value='Speel Yahtzee!' name='newgame'>";
//    }
    public function setScoreblad($naam,$getal)
    {
        if ($this->scoreblad[$naam] == "") {
        $this->scoreblad[$naam] = $getal;
        $this->turn = 3;
    }
    }

    public function eenen(){
        return $getal= $this->showNumbers(1);
    }
    public function tweeen(){
        return $this->showNumbers(2);

    }
    public function drieen(){
        return $this->showNumbers(3);
    }
    public function vieren(){
        return $this->showNumbers(4);
    }
    public function vijven(){
        return  $this->showNumbers(5);
    }
    public function zessen(){
        return $this->showNumbers(6);
    }

    //done
    public function threeofkind(){
        $this->zelfde= array_count_values($this->dices);
        foreach ($this->dices as $value) {
            if($this->zelfde[$value] >=3) {
                return $getal= array_sum($this->dices);
            }
            else{
                return 0;
            }
        }

    }
    //done
    public function fourofkind(){
        $this->zelfde= array_count_values($this->dices);
        foreach ($this->dices as $value) {
            if($this->zelfde[$value] >=4)
                return $getal= array_sum($this->dices);
        }
        return 0;
    }
    //done
    public function fullhouse()
    {
        $this->zelfde = array_count_values($this->dices);
        $j = 0;
        foreach ($this->dices as $value) {
            if($this->zelfde[$value]==3)
                $j=1;

        }
        foreach($this->dices as $value){
            if($this->zelfde[$value]==2 && $j==1 )
                return 25;
            else{
                return 0;
            }
        }
        return 0;
    }
//done
    public function kleinestraat()
    {
        $this->zelfde = array_count_values($this->dices);
        $j = 0;
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] == 1) {
                $j++;
            }}
            if ($j == 4 && isset($this->zelfde[1]) && isset($this->zelfde[2]) && isset($this->zelfde[3]) && isset($this->zelfde[4]))
                return 30;

            if ($j == 4 && isset($this->zelfde[2]) && isset($this->zelfde[3]) && isset($this->zelfde[4]) && isset($this->zelfde[5]))
                return 30;

            if ($j == 4 && isset($this->zelfde[3]) && isset($this->zelfde[4]) && isset($this->zelfde[5]) && isset($this->zelfde[6]))
                return 30;







    }
    //0 werkt niet
    public function grotestraat(){
        $zelfde= array_count_values($this->dices);
        $j=0;
        foreach($this->dices as $value) {
            if ($zelfde[$value] == 1) {
                $j++;
            }
        }
            if ($j == 5&&isset($this->zelfde[2])&&isset($this->zelfde[3])&&isset($this->zelfde[4])&&isset($this->zelfde[5]))
                return 40;


else{
    return 0;
}
    }
    //done
    public function yathzee(){

        if(count(array_unique($this->dices)) == 1) {
            return 50;
        }
        else{
            return 0;
        }

    }
    //done
    public function change(){
        return array_sum($this->dices);
    }


    public function generateDices()
    {
    if($this->getTurn()==0)
        return;

        $this->turn--;


        for ($i = 0; $i <= 4; $i++) {


            if($this->dicesB[$i]==TRUE){
                $this->dices[$i] = rand(1,6);
            }

            /*$this->generateDiceValue($i);*/
            echo  $this->dices[$i];
            echo "<input type='radio' value='true' name='".$i."'> <input type='radio' value='false' name='".$i."'><br>";
        }
    if($this->getTurn()==0)
        return;

    }

    public function showNumbers($amount)
    {
        $value = array();





        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i] == $amount) {
                array_push($value, $amount);
            }
        }



        return $getal= array_sum($value);
    }
    public function getdeel1(){
        echo $this->eenen()." eenen <input type='checkbox' value='".$this->eenen()."' name='Eenen'><br>";
        echo $this->tweeen()." tweeen<input type='checkbox' value='".$this->tweeen()."' name='Tweeen'><br>";
        echo $this->drieen()." drieen<input type='checkbox' value='".$this->drieen()."' name='Drieen'><br>";
        echo $this->vieren()." vieren<input type='checkbox' value='".$this->vieren()."' name='Vieren'><br>";
        echo $this->vijven()." vijven<input type='checkbox' value='".$this->vijven()."' name='Vijven'><br>";
        echo $this->zessen()." zessen<input type='checkbox' value='".$this->zessen()."' name='Zessen'> <br><br>";
    }


    public function getDeel2()
    {
        echo $this->threeofkind()."three of kind<input type='checkbox' value='".$this->threeofkind()."' name='Threeofkind'><br>";
        echo $this->fourofkind()." four of kind<input type='checkbox' value='".$this->fourofkind()."' name='Fourofkind'><br>";
        echo $this->fullhouse()." full house<input type='checkbox' value='".$this->fullhouse()."' name='Fullhouse'><br>";
        echo $this->kleinestraat()." Kleine straat<input type='checkbox' value='".$this->kleinestraat()."' name='Kleinestraat'><br>";
        echo $this->grotestraat()." Grote straat<input type='checkbox' value='".$this->grotestraat()."' name='Grotestraat'><br>";
        echo $this->yathzee()." Yathzee<input type='checkbox' value='".$this->yathzee()."' name='Yathzee'><br>";
        echo $this->change()." change<input type='checkbox' value='".$this->change()."' name='Change'><br>";
    }
    public function weergave()
    {

        echo $this->generateDices();
        if($this->getTurn() ==0){
            echo "u moet nu een waarde invullen<br>";
        }
        echo "Je hebt nog". $this->getTurn() ."beurten voor gooien<br>";

        /*$this->generateDiceValue();*/
        /*
                for ($i = 1; $i <= 6; $i++) {
                    $this->showNumbers($i);
                }*/
        $this->getdeel1();
        $this->getdeel2();
        echo "<br>scorekaart<br>";
        echo $this->getScoreblad();
        echo print_r($this->scoreblad);



        echo "<br>";
        echo "<input type='submit' value='Volgende zet' name='generate' />";
        echo "reset?<input type='checkbox' value='Reset' name='Reset' />";

    }
}