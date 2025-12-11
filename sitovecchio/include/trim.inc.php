<?php
function trim_body($text, $max_length = 139, $tail = '...')
	{
		$tail_len = strlen($tail);
		if (strlen($text) > $max_length)
			{
				$tmp_text = substr($text, 0 , $max_length - $tail_len);
				if (substr($text, $max_length - $tail_len, 1) == ' ') 
					{
						$text = $tmp_text;
					}
			else {
			$pos = strrpos($tmp_text, ' ');
			$text = substr($text, 0, $pos);
				}
		$text = $text . $tail;
			}
		return $text;
	}
?>