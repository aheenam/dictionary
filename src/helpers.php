<?php

if (!function_exists('dictionary'))
{
	function dictionary()
	{
		return new \Aheenam\Dictionary\Models\Word();
	}
}