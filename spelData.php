<?php

interface SpelData{
    
    const database = "localhost";
    const username = "root";
    const password = "";
    const dbname = "nim";


    public function connect();
    public function setData();
    public function disconnect();
}

