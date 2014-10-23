<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Text_renderer {

    public function to_rupiah($value)
	{
        return "Rp ".number_format($value, 0, "", ".");
	}
}