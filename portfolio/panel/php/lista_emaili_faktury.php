<?php
// #########################################################  tworze liste rozwijana z emailami klienta
$ilosc_email = 0;
$klient_email = [];
$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$nabywca_id.";");
while($wynik3= mysqli_fetch_assoc($pytanie))
	{
	$klient_email_ostatni=$wynik3['ostatnio_uzyty_faktury'];

		if($klient_email_ostatni != '') 
		{
			$ilosc_email++;
			$klient_email[$ilosc_email]=$klient_email_ostatni;
		}

	$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$nabywca_id." AND dzial = 'Faktury';");
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
				// echo 'dodaje adres='.$wynik33['email'].'<br>';
				}
			}
		}

	//dodaje do listy kreske rozdzielajaca
	$ilosc_email++;
	$klient_email[$ilosc_email]=$linia_rozdzielajaca;

	$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$nabywca_id." AND dzial <> 'Faktury';");
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
				// echo 'Dodaje adres='.$wynik33['email'].'<br>';
				}
			}
		}
	}
?>