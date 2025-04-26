<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        foreach($_POST as $key => $value){
            echo "<p>", $key, ": ", $value, "</p>";
        }
    }
    
?>