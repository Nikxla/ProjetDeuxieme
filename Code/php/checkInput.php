<?php

function MinMaxPwd($var)
{
    if (strlen($var) > 8 || strlen($var) < 16) {
        return true;
    } else {
        return false;
    }
}

function OnlyLetters($var)
{
    if (ctype_alpha($var)) {
        return true;
    } else {
        return false;
    }
}