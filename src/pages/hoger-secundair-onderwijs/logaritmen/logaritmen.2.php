<?php
require $_SERVER["DOCUMENT_ROOT"] . '/config.php';

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

require_once(LIB . "class.oefening.php");
require_once(LIB . "class.math.php");
require_once(LIB . "class.helper.php");
//require_once(LIB . "class.rational.php");
//require_once(LIB . "class.hoek.php");

class Fabriek extends OefeningFactory
{
	public function run()
	{
		$i = random_int(11,13);
		return call_user_func(array($this,"oef".$i));
	}
	private function oef11()
	{	
		$e			= rand(-3,9);
		$opgave 	= "\\log x = ".$e;
		$oplossing 	= $opgave;
		$oplossing .= "\\\\ \\Leftrightarrow x = 10^{".$e."} \\\\ \\Leftrightarrow x =".puntkomma(pow(10,$e));
		$stamp		= "$e";
		return new Oefening($this->titel,$opgave, $oplossing, $stamp);
	}
	private function oef12()
	{	
		$e			= rand(-9,-1);
		$opgave 	= "\\log x = ".$e;//"\\log \\frac{1}{10^{".abs($e)."}}";
		$oplossing 	= $opgave;
		$oplossing .= "\\\\ \\Leftrightarrow x = \\log 10^{".$e."} \\\\ \\Leftrightarrow x = \\frac{1}{10^{".abs($e)."}}";
		$stamp		= "$e";
		return new Oefening($this->titel,$opgave, $oplossing, $stamp);
	}
	private function oef13()
	{
		$e			= array(-1,1)[rand(0,1)] * rand(2,12);
		$f			= rand(2,12);
		$ggd		= ggd(abs($e),abs($f));
		$e			/= $ggd;
		$f			/= $ggd;
		if(abs($e) == 1 and $f == 1){$f = rand(2,12);} //Geen eentjes
		$opgave		= "\\log x = \\frac{".$e."}{".$f."}";
		
		$oplossing 	= $opgave;
		$oplossing .= "\\\\ \\Leftrightarrow x =\\log 10^{\\frac{".$e."}{".$f."}}";
		if($e < 0)
		{
			$oplossing	.= "\\\\ \\Leftrightarrow x =".proot("\\frac{1}{10^{".(abs($e))."}}", 1, $f); 
		}else{
			$oplossing .= "\\\\ \\Leftrightarrow x =".proot("10", $e, $f);
		}
		$stamp		= "$e.$f";
		return new Oefening($this->titel,$opgave, $oplossing, $stamp);
	}
}
?>
