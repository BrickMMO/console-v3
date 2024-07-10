<?php

function message_set($title, $text, $colour = 'green', $icon = 'fa-triangle-exclamation')
{
    if(isset($_SESSION['message'])) return false;
    
    $_SESSION['message']['title'] = $title;
    $_SESSION['message']['text'] = $text;
    $_SESSION['message']['colour'] = $colour;
    $_SESSION['message']['icon'] = $icon;
}
