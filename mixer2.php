<?php
require $_SERVER["DOCUMENT_ROOT"] . "/config.php";
session_start(); 
include('kop.php');
require_once('class.pagina.php');
include('index.overzicht.php');
//ONTVANGEN
$label = $_GET['blok'];
if(in_array($label, array_keys($blokken))){ 
	$terug_link = '';
	$opgave = $blokken[$label]["Opgave"];
	$titel 	= $blokken[$label]["Titel"];
	$reeksen = $blokken[$label]["Reeksen"];
	$reeks = $reeksen[rand(0,count($reeksen)-1)];
}elseif(in_array($label, array_keys(array_merge($paginas, $meetkunde))))
{
	$alles = array_merge($paginas, $meetkunde);
	$opgave = $alles[$label]["Opgave"];
	$titel = $alles[$label]["Titel"];
	$embed = "";
	if(isset($_GET['embed'])){	$embed = '&embed';}
	$terug_link = "<a href='index.php?pagina=$label$embed' class='button'>12 per keer</a> &nbsp;";
	$reeks = $label;
}else{
	die('Onbekende aanvraag');
}
?>
<div class="container">
	<?php echo "<h1>".$titel."</h1>";
	if(!isset($_GET['embed']))
	{
		echo "<a href=\"index.php\" class='button'>Hoofdmenu</a>&nbsp;";
	}
	if(!in_array($label, array_keys($meetkunde)))
	{
		echo $terug_link; 
		
	}
	?>
	<!--<span style='float:right'><button onclick="myFunction()" id='knop'>Toon oplossing</button></span>-->
</div>
<div class="container">
	
		<?php 
			try
			{
				$P = new Pagina($opgave, $reeks.'.php');
				$P->mix2();
				
			}catch(Exception $e) {
				echo '<p>Oeps, ergens een rekenfoutje gemaakt: ' .$e->getMessage();
				echo '<br/>Zoals je ziet, het overkomt iedereen wel eens</p>';
				echo "<a href='?blok=$label' class='button'>Probeer opnieuw</a>";
			}
		?>
	<div class ='row' style='text-align:center'>
		<hr/>
	</div>
	
</div>

<script>
function myFunction() {
  var x = document.getElementById("oplossing");
  var y = document.getElementById("knop");
  if (x.style.margin-left === "-9999") {
    x.style.margin-left = "0";
    y.innerHTML = "Nieuwe oefening";
  } else {
	y.innerHTML = "Toon oplossing";
    x.style.display = location.reload();
  }
}
</script>
<?php include(COMPONENTS . 'voet.html');?>
