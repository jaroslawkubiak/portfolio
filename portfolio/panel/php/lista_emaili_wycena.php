<?php
// #########################################################  tworze liste rozwijana z emailami klienta
$ilosc_email = 0;
$klient_email = [];
$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
while($wynik3= mysqli_fetch_assoc($pytanie))
	{
	$klient_email_ostatni=$wynik3['ostatnio_uzyty_wycena'];

	$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$klient." AND dzial = 'Wyceny';");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		if($wynik33['email'] != '') 
			{
			$email_jest_na_liscie = 0;
			for ($k=1; $k<=$ilosc_email; $k++) if($klient_email[$k] == $wynik33['email']) $email_jest_na_liscie = 1;
			if($email_jest_na_liscie == 0)
				{
				$ilosc_email++;
				$klient_email[$ilosc_email]=$wynik33['email'];
				}
			}
		}

	$ilosc_email++;
	$klient_email[$ilosc_email]=$linia_rozdzielajaca;

	$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$klient." AND dzial <> 'Wyceny';");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		if($wynik33['email'] != '') 
			{
			$email_jest_na_liscie = 0;
			for ($k=1; $k<=$ilosc_email; $k++) if($klient_email[$k] == $wynik33['email']) $email_jest_na_liscie = 1;
			if($email_jest_na_liscie == 0)
				{
				$ilosc_email++;
				$klient_email[$ilosc_email]=$wynik33['email'];
				}
			}
		}

	}
?>