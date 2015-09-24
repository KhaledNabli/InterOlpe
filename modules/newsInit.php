<?php

function parseBBCode2HTML( $bb )
{
    $bb = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $bb);
    $bb = preg_replace('/\[i\](.*?)\[\/i\]/', '<i>$1</i>', $bb);
    $bb = preg_replace('/\[color=([[:alnum:]]{6}?).*\](.*?)\[\/color\]/', '<font color="$1">$2</font>', $bb);
    $bb = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="$1">$2</a>', $bb);
	$bb = preg_replace('/\[img:([^ ]+).*\](.*)\[\/img:([^ ]+).*\]/', '<img src="$2" width="100%"></img>', $bb);
	
    $bb = preg_replace('/\n/', "<br/>\n", $bb);

    return $bb;

}

?>