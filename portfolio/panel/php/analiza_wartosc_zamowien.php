<?php
$i=0;
$zamowienie_id = [];
$wartosc_brutto = [];
$fv_jest = [];

$SUMA_ZAMOWIEN_BRUTTO=0;
$pytanie3 = mysqli_query($conn, "SELECT id, wartosc_brutto FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$i++;
	$zamowienie_id[$i]=$wynik3['id'];
	$wartosc_brutto[$i]=$wynik3['wartosc_brutto'];
	$SUMA_ZAMOWIEN_BRUTTO += $wartosc_brutto[$i];
	
	$fv_jest[$i] = 0;
	$pytanie = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$i]." AND nr_faktury <> '' AND korekta_fv = 'NIE';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$fv_jest[$i] = 1;
		}
	if($fv_jest[$i] == 0) $SUMA_ZAMOWIEN_BEZ_FAKTUR += $wartosc_brutto[$i];
	}


$SUMA_ZAMOWIEN_Z_FAKTURAMI = $SUMA_ZAMOWIEN_BRUTTO - $SUMA_ZAMOWIEN_BEZ_FAKTUR;
$SUMA_ZAMOWIEN_BRUTTO = number_format($SUMA_ZAMOWIEN_BRUTTO, 2,'.',' ');
$SUMA_ZAMOWIEN_Z_FAKTURAMI = number_format($SUMA_ZAMOWIEN_Z_FAKTURAMI, 2,'.',' ');
$SUMA_ZAMOWIEN_BEZ_FAKTUR = number_format($SUMA_ZAMOWIEN_BEZ_FAKTUR, 2,'.',' ');

echo '<div align="left" class="text_duzy">Wartość zamówień brutto : '.$SUMA_ZAMOWIEN_BRUTTO.' '.$waluta.'<br>';

echo 'A w tym : <br>';
echo '&nbsp;- zafakturowane : '.$SUMA_ZAMOWIEN_Z_FAKTURAMI.' '.$waluta.'<br>';
echo '&nbsp;- niezafakturowane : '.$SUMA_ZAMOWIEN_BEZ_FAKTUR.' '.$waluta.'</div>';

?>