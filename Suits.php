<?php

function cardGetName($index)
{
 $number = ($index-1) % 13;
 $number = ["Ace","Two","Three","Four","Five","Six","Seven","Eight", "Nine","Ten","Jack","Queen","King"][$number];
 return ( . " of " 
}

private const CHAR_SPADE = 127136;
private const CHAR_HEART = 127152;
private const CHAR_DIAMOND = 127168;
private const CHAR_CLUB = 127184;