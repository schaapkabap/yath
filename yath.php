<?php


class Yahtzee
{
    private $running = false;
    private $dicesB = array(TRUE, TRUE, TRUE, TRUE, TRUE);
    private $dices = array(0, 0, 0, 0, 0);
    private $turn;
    private $zelfde = array(0, 0, 0, 0, 0);
    private $scoreblad;

    public function __construct()
    {
        $this->setTurn(4);
        $this->scoreblad = array(
            "Eenen" => '',
            "Tweeen" => '',
            "Drieen" => '',
            "Vieren" => '',
            "Vijven" => '',
            "Zessen" => '',
            "Threeofkind" => '',
            "Fourofkind" => '',
            "Fullhouse" => '',
            "Kleinestraat" => '',
            "Grotestraat" => '',
            "Yathzee" => '',
            "Change" => '',
            "Bonus" => '',
            "Totaaldeel1" => '',
            "Totaaldeel2" => '',
            "Totaal" => ''
        );

        $this->running = true;

    }

    //  Seeplt de game als ...
    public function play($postdata)
    {

        foreach ($this->scoreblad as $key => $value) {
            if ($this->scoreblad[$key] == '') {
                $i++;
            }
        }
       if($i>0){



            foreach ($this->scoreblad as $key => $value) {
                if (isset($postdata[$key])) {
                    $this->setScoreblad($key, $postdata[$key]);
                }
            }

            for ($i = 0; $i < count($this->dicesB); $i++) {
                if (isset($postdata[$i])) {
                    $this->dicesB[$i] = FALSE;
                } else $this->dicesB[$i] = TRUE;
            }


            $this->display();
        }
        elseif($i==0||($i!=0&&$this->scoreblad['Bonus']=='')){
            $this->EndGame();
        }
    }





    public function EndGame(){
        return $end= "Het spel is tot zijn einde";
    }

    // Maakt een beurt aan
    public function getTurn()
    {
        return $this->turn;
    }

    // Set de turn
    public function setTurn($turn)
    {
        return $this->turn = $turn;
    }

    // Maakt het scoreboard aan
    public function getScoreblad()
    {
        $score =
            $this->scoreblad['Eenen'] . " eenen<br>" .
            $this->scoreblad['Tweeen'] . " tweeen<br>" .
            $this->scoreblad['Drieen'] . " drieen<br>" .
            $this->scoreblad['Vieren'] . " vieren<br>" .
            $this->scoreblad['Vijven'] . " vijven<br>" .
            $this->scoreblad['Zessen'] . " zessen <br><br>" .
            $this->scoreblad['Bonus'] . " bonus<br>" .
            $this->scoreblad['Totaaldeel1'] . " totaal deel1<br>" .
            $this->scoreblad['Threeofkind'] . " three of kind<br>" .
            $this->scoreblad['Fourofkind'] . " four of kind<br>" .
            $this->scoreblad['Fullhouse'] . " full house<br>" .
            $this->scoreblad['Kleinestraat'] . " Kleine straat<br>" .
            $this->scoreblad['Grotestraat'] . " Grote straat<br>" .
            $this->scoreblad['Yathzee'] . " Yathzee<br>" .
            $this->scoreblad['Change'] . " change<br>" .
            $this->scoreblad['Totaaldeel1'] . " totaal deel1<br>" .
            $this->scoreblad['Totaaldeel2'] . " totaal deel2<br>" .
            $this->scoreblad['Totaal'] . " Totaal score<br>" .
            "totaal score";

        return $score;
    }

    public function calcaluteScoreDeel1()
    {
        $this->scoreblad['Totaaldeel1'] = $this->scoreblad['Eenen'] + $this->scoreblad['Tweeen'] + $this->scoreblad['Drieen'] + $this->scoreblad['Vieren'] + $this->scoreblad['Vijven'] + $this->scoreblad['Zessen'];
    }

    public function calculateScoreDeel2()
    {
        $this->scoreblad['Totaaldeel2'] = $this->scoreblad['Threeofkind'] + $this->scoreblad['Fourofkind'] + $this->scoreblad['Fullhouse'] + $this->scoreblad['Kleinestraat'] + $this->scoreblad['Grotestraat'] + $this->scoreblad['Yathzee'] + $this->scoreblad['Change'];
    }

    public function calcaluteBonus()
    {
        if ($this->scoreblad['Totaaldeel1'] >= 63) {
            $this->scoreblad["Bonus"] = 35;
        }
        $this->scoreblad["Bonus"] = 0;
    }

    public function setStandardScoreValue()
    {
        if (isset($this->scoreblad['Bonus'])) {

        }
    }

    public function calcaluteScoreDeel1WithBonus()
    {
        if (isset($this->scoreblad['Bonus'])) {
            $this->scoreblad['Totaaldeel1metBonus'] = $this->scoreblad['Totaaldeel1'] + $this->scoreblad['Bonus'];
        } else {
            $this->scoreblad['Totaaldeel1metBonus'] = $this->scoreblad['Totaaldeel1'];
        }
    }

    public function calculateTotaal()
    {
        $this->scoreblad['Totaal'] = $this->scoreblad['Totaaldeel1metBonus'] + $this->scoreblad['Totaaldeel2'];
    }


    // Vult de waardes in van het scoreblad
    public function setScoreblad($naam, $getal)
    {
        if ($this->scoreblad[$naam] == "") {
            $this->scoreblad[$naam] = $getal;
            $this->turn = 3;
        }
    }

    // Genereert de waarde: eenen
    public function eenen()
    {
        return $getal = $this->showNumbers(1);
    }

    // Genereert de waarde: tweeen
    public function tweeen()
    {
        return $this->showNumbers(2);

    }

    // Genereert de waarde: drieen
    public function drieen()
    {
        return $this->showNumbers(3);
    }

    // Genereert de waarde: vieren
    public function vieren()
    {
        return $this->showNumbers(4);
    }

    // Genereert de waarde: wijven
    public function vijven()
    {
        return $this->showNumbers(5);
    }

    // Genereert de waarde: zessen
    public function zessen()
    {
        return $this->showNumbers(6);
    }

    // Genereert de waarde: three of a kind
    public function threeofkind()
    {
        $this->zelfde = array_count_values($this->dices);
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] >= 3) {
                return $getal = array_sum($this->dices);
            } else {
                return 0;
            }
        }

    }

    // Genereert de waarde: four of a kind
    public function fourofkind()
    {
        $this->zelfde = array_count_values($this->dices);
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] >= 4)
                return $getal = array_sum($this->dices);
        }
        return 0;
    }

    // Genereert de waarde: grotestraat
    public function fullhouse()
    {
        $this->zelfde = array_count_values($this->dices);
        $j = 0;
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] == 3)
                $j = 1;

        }
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] == 2 && $j == 1)
                return 25;
            else {
                return 0;
            }
        }
        return 0;
    }

    // Genereert de waarde: kleine straat
    public function kleinestraat()
    {
        $this->zelfde = array_count_values($this->dices);
        $j = 0;
        foreach ($this->dices as $value) {
            if ($this->zelfde[$value] == 1) {
                $j++;
            }
        }
        if ($j == 4 && isset($this->zelfde[1]) && isset($this->zelfde[2]) && isset($this->zelfde[3]) && isset($this->zelfde[4]))
            return 30;

        if ($j == 4 && isset($this->zelfde[2]) && isset($this->zelfde[3]) && isset($this->zelfde[4]) && isset($this->zelfde[5]))
            return 30;

        if ($j == 4 && isset($this->zelfde[3]) && isset($this->zelfde[4]) && isset($this->zelfde[5]) && isset($this->zelfde[6]))
            return 30;
        else {
            return 0;
        }
    }

    // Genereert de waarde: grotestraat + 0 werkt niet.
    public function grotestraat()
    {
        $zelfde = array_count_values($this->dices);
        $j = 0;
        foreach ($this->dices as $value) {
            if ($zelfde[$value] == 1) {
                $j++;
            }
        }
        if ($j == 5 && isset($this->zelfde[2]) && isset($this->zelfde[3]) && isset($this->zelfde[4]) && isset($this->zelfde[5]))
            return 40;

        else {
            return 0;
        }
    }

    // Genereert de waarde: yahtzee
    public function yathzee()
    {

        if (count(array_unique($this->dices)) == 1) {
            return 50;
        } else {
            return 0;
        }

    }

    // Genereert de waarde: change
    public function change()
    {
        return array_sum($this->dices);
    }

    //  Genereert willekeurige Dobbelsteenwaardes.
    public function generateDices()
    {
        if ($this->getTurn() == 0)
            return;
        $this->turn--;
        for ($i = 0; $i <= 4; $i++) {
            if ($this->dicesB[$i] == TRUE) {
                $this->dices[$i] = rand(1, 6);
            }
            echo $this->dices[$i];
            echo "<input type='radio' value='true' name='" . $i . "'> <input type='radio' value='false' name='" . $i . "'><br>";
        }
        if ($this->getTurn() == 0)
            return;
    }

    //  Laat de het 'totaal' aantal zien van 1 t/m 6
    public function showNumbers($amount)
    {
        $value = array();
        for ($i = 0; $i < count($this->dices); $i++) {
            if ($this->dices[$i] == $amount) {
                array_push($value, $amount);
            }
        }
        return $getal = array_sum($value);
    }

    // Hier kan je waardes vast zetten van het bovenste scoreboard
    public function claimUpperScore()
    {

        echo $this->eenen() . " eenen <input type='checkbox' value='" . $this->eenen() . "' name='Eenen'><br>";
        echo $this->tweeen() . " tweeen<input type='checkbox' value='" . $this->tweeen() . "' name='Tweeen'><br>";
        echo $this->drieen() . " drieen<input type='checkbox' value='" . $this->drieen() . "' name='Drieen'><br>";
        echo $this->vieren() . " vieren<input type='checkbox' value='" . $this->vieren() . "' name='Vieren'><br>";
        echo $this->vijven() . " vijven<input type='checkbox' value='" . $this->vijven() . "' name='Vijven'><br>";
        echo $this->zessen() . " zessen<input type='checkbox' value='" . $this->zessen() . "' name='Zessen'> <br><br>";
    }

    // Hier kan je waardes vast zetten van het onderste scoreboard
    public function claimLowerScore()
    {
        echo $this->threeofkind() . "three of kind<input type='checkbox' value='" . $this->threeofkind() . "' name='Threeofkind'><br>";
        echo $this->fourofkind() . " four of kind<input type='checkbox' value='" . $this->fourofkind() . "' name='Fourofkind'><br>";
        echo $this->fullhouse() . " full house<input type='checkbox' value='" . $this->fullhouse() . "' name='Fullhouse'><br>";
        echo $this->kleinestraat() . " Kleine straat<input type='checkbox' value='" . $this->kleinestraat() . "' name='Kleinestraat'><br>";
        echo $this->grotestraat() . " Grote straat<input type='checkbox' value='" . $this->grotestraat() . "' name='Grotestraat'><br>";
        echo $this->yathzee() . " Yathzee<input type='checkbox' value='" . $this->yathzee() . "' name='Yathzee'><br>";
        echo $this->change() . " change<input type='checkbox' value='" . $this->change() . "' name='Change'><br>";
    }

    // Geeft het spel weer.
    public function display()
    {
        echo $this->generateDices();
        if ($this->getTurn() == 0) {
            echo "u moet nu een waarde invullen<br>";
        } else {
            echo "Je hebt nog" . $this->getTurn() . "beurten voor gooien<br>";
        }
        $this->claimUpperScore();
        $this->claimLowerScore();

        echo "<br>";
        echo '
                <table>
                  <tr>
                    <th>Bovenste Helft:</th>
                  </tr>
                  <tr>
                    <td>Eenen:</td>
                    <td>  ' . $this->scoreblad['Eenen'] . ' </td>
                  </tr>
                  <tr>
                    <td>Twos:</td>
                    <td>' . $this->scoreblad['Tweeen'] . '</td>
                  </tr>
                    <tr>
                    <td>Threes:</td>
                    <td>' . $this->scoreblad['Drieen'] . '</td>
                  </tr>
                    <tr>
                    <td>Fours:</td>
                    <td>' . $this->scoreblad['Vieren'] . '</td>
                  </tr>
                    <tr>
                    <td>Fives:</td>
                    <td>' . $this->scoreblad['Vijven'] . '</td>
                  </tr>
                   <tr>
                    <td>Sixes:</td>
                    <td>' . $this->scoreblad['Zessen'] . '</td>
                  </tr>
                  <tr>
                    <td>Total:</td>
                    <td>' . $this->scoreblad['Totaaldeel1'] . '</td>
                  </tr>
                   <td>Extra bonus:</td>
                    <td>' . $this->scoreblad['Bonus'] . '</td>
                  </tr>
                   <td>Totaal (Bovenste helft):</td>
                    <td>' . $this->scoreblad['Totaaldeel1metBonus'] . '</td>
                  </tr>
                                    <tr>
                    <th>Onderste Helft:</th>
                  </tr>
                  <tr>
                    <td>Three of a kind:</td>
                    <td>' . $this->scoreblad['Threeofkind'] . '</td>
                  </tr>
                  <tr>
                    <td>Four of a kind:</td>
                    <td>' . $this->scoreblad['Fourofkind'] . '</td>
                  </tr>
                    <tr>
                    <td>Full house:</td>
                    <td>' . $this->scoreblad['Fullhouse'] . '</td>
                  </tr>
                    <tr>
                    <td>Kleine straat:</td>
                    <td>' . $this->scoreblad['Kleinestraat'] . '</td>
                  </tr>
                    <tr>
                    <td>Grote straat:</td>
                    <td>' . $this->scoreblad['Grotestraat'] . '</td>
                  </tr>
                   <tr>
                    <td>Yahtzee:</td>
                    <td>' . $this->scoreblad['Yathzee'] . '</td>
                  </tr>
                  <tr>
                    <td>Change:</td>
                    <td>' . $this->scoreblad['Change'] . '</td>
                  </tr>
                   <td>Onderste (Onderste helft):</td>
                    <td>' . $this->scoreblad['Totaaldeel2'] . '</td>
                  </tr>
                  <th>Totaal:</th>
                    <td>' . $this->scoreblad['Totaal'] . '</td>
                  </tr>
               </table>';

        echo "<br>";
        echo "<input type='submit' value='Volgende zet' name='generate' />";
        echo "reset?<input type='checkbox' value='Reset' name='Reset' />";
    }
}