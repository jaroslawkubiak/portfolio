<style type="text/css">
	a:link {
	color : #000000; 
	font-weight: Bold;
	font-family: arial; 
	text-decoration: none; 
	font-size: 12px;
	}

	a:visited {
	color : #000000; 
	font-weight: Bold;
	font-family: arial; 
	text-decoration: none;
	font-size: 12px;
	} 

	a:active {
	color: #000000;
	font-weight: Bold; 
	font-family: arial; 
	text-decoration: none; 
	font-size: 12px;
	} 

	a:hover {
	color: #000000;
	font-weight: Bold; 
	font-family: arial; 
	text-decoration: underline; 
	font-size: 12px;
	}

	input.produkcja_checkbox
	{
		/* Double-sized Checkboxes */
		-ms-transform: scale(3); /* IE */
		-moz-transform: scale(3); /* FF */
		-webkit-transform: scale(3); /* Safari and Chrome */
		-o-transform: scale(3); /* Opera */
		padding: 100px;

	}
	input.button_produkcja 
	{
		width: 300px;  
		height: 300px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_maly
	{
		width: 200px;  
		height: 200px;
		font:Arial, Helvetica, sans-serif;
		font-size:24px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_mniejszy
	{
		width: 120;  
		height: 35;
		font:Arial, Helvetica, sans-serif;
		font-size:30px;
		white-space: normal;
	}


	input.button_zapisz_produkcja 
	{
		width: 150px;  
		height: 100px;
		font:Arial, Helvetica, sans-serif;
		font-size:36px;
		font-weight: Bold;
		white-space: normal;
	}

	.pole_input_produkcja
	{
		width: 100%; 
		height: 40px;
		border: #000000 1px solid;
		background-color:#e24139;
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 22px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}

	.pole_input_produkcja_kalendarz
	{
		height: 35px;
		border: #000000 1px solid;
		color: #000000;
        background-color:#cccccc;
		text-align:center;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 18px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}
    .text_18
	{
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 18px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}

    .pole_input_duze_szare
    {
        height: 30px;
		border: #000000 1px solid;
        background-color:#ffffff;
        color: #dddddd;
        font-size: 16px;
    }

</style>

<?php
//szukamy stanowiska zalogowanego usera
$pytanie = mysqli_query($conn, "SELECT stanowisko FROM uzytkownicy WHERE id = ".$zalogowany_user.";");
while($wynik= mysqli_fetch_assoc($pytanie))
{
    $stanowisko_zalogowanego_usera = $wynik['stanowisko'];
}

//dodaje do bazy nowy wpis admina        
if(($zapisz == 'Zapisz') && ($stanowisko_zalogowanego_usera == 'administrator') && ($pracownik_produkcji_id != ''))
{
    $wartosc1 = change($wartosc1);
    $sql = "INSERT INTO premia_akordowa_wpisy (`data_time`, `user_id`, `opis`, `wartosc`, `data_wykonania_dzien`, `data_wykonania_miesiac`, `data_wykonania_rok`) VALUES ('$time', '$pracownik_produkcji_id', '$opis', '$wartosc1', '$aktualny_dzien', '$aktualny_miesiac', '$AKTUALNY_ROK');";
    $result = mysqli_query($conn, $sql);
	echo '<div class="text_duzy_niebieski" align="center">Wpis został dodany.</div><br>';
}


//sprawdzamy czy admin otwiera zakładkę dla danego pracownika
if(($stanowisko_zalogowanego_usera == 'administrator') && ($podane_haslo != '') && ($pracownik_produkcji_id != '')) $submit = True;

if($submit)
{
    // echo '$data_poczatkowa='.$data_poczatkowa.'<br>';
    // echo '$data_koncowa='.$data_koncowa.'<br>';
    //wyciagam dane uzytkownika
    $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$pracownik_produkcji_id.";");
    while($wynik= mysqli_fetch_assoc($pytanie))
    {
        $haslo_z_bazy = $wynik['haslo'];
        $imie = $wynik['imie'];
        $nazwisko = $wynik['nazwisko'];

        $wydane_profile=number_format($wynik['wydane_profile'], 2,'.','');
        $wygiete_profile_pvc=number_format($wynik['wygiete_profile_pvc'], 2,'.','');
        $wyfrezowane_odwodnienia=number_format($wynik['wyfrezowane_odwodnienia'], 2,'.','');
        $zgrzane_profile=number_format($wynik['zgrzane_profile'], 2,'.','');
        $wstawione_slupki=number_format($wynik['wstawione_slupki'], 2,'.','');
        $dociete_listwy = number_format($wynik['dociete_listwy'], 2,'.','');
        $dociecie_kompletu_listew_przyszybowych = number_format($wynik['dociecie_kompletu_listew_przyszybowych'], 2,'.','');
        $okute_elementy=number_format($wynik['okute_elementy'], 2,'.','');
        $zaszklone_elementy=number_format($wynik['zaszklone_elementy'], 2,'.','');
        $spakowane_wyroby=number_format($wynik['spakowane_wyroby'], 2,'.','');
    }
    

    //hasla się zgadzają, można pokazać premię
    if($haslo_z_bazy == $podane_haslo)
    {
        // echo '<div class="text_duzy" align="center">Witaj <font color="green">'.$imie.' '.$nazwisko.'</font>. Oto Twoja premia</div><br>';

        echo '<FORM action="index.php?page=produkcja_premia_akordowa" method="post">';

        echo '<INPUT type="hidden" name="page" value="produkcja_premia_akordowa">';
        echo '<INPUT type="hidden" name="podane_haslo" value="'.$podane_haslo.'">';
        echo '<INPUT type="hidden" name="pracownik_produkcji_id" value="'.$pracownik_produkcji_id.'">';
        
        //jezeli data nie została jeszcze wybrana - ustawiamy bierzący miesiąc
        if(($data_poczatkowa == '') && ($data_koncowa == ''))
        {
            $data_poczatkowa = date('d-m-Y', $time);
            $data_koncowa = date('d-m-Y', $time);

            $data_poczatkowa = '01-'.$AKTUALNY_MIESIAC.'-'.$AKTUALNY_ROK;
            $szukany_miesiac2 = mktime(0,0,0, $AKTUALNY_MIESIAC, 1, $AKTUALNY_ROK);
            $ilosc_dni = date('t', $AKTUALNY_MIESIAC2);
            $data_koncowa = $ilosc_dni.'-'.$AKTUALNY_MIESIAC.'-'.$AKTUALNY_ROK;
            $pieces = explode("-", $data_poczatkowa);		
            $data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
            $pieces2 = explode("-", $data_koncowa);		
            $data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
        }

        //jeżeli data została wybrana
        if($data_poczatkowa != '') 
            {
            $pieces = explode("-", $data_poczatkowa);		
            $data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
            }
        if($data_koncowa != '') 
            {
            $pieces2 = explode("-", $data_koncowa);		
            $data_koncowa_time = mktime(23,59,59,$pieces2[1], $pieces2[0], $pieces2[2]);
            }

        $data_poczatkowa_pieces = explode("-", $data_poczatkowa);		
        $data_poczatkowa_time = mktime(0,0,0,$data_poczatkowa_pieces[1], $data_poczatkowa_pieces[0], $data_poczatkowa_pieces[2]);
        $data_koncowa_pieces = explode("-", $data_koncowa);		
        $data_koncowa_time = mktime(23,59,59,$data_koncowa_pieces[1], $data_koncowa_pieces[0], $data_koncowa_pieces[2]);
        
        //zpisujemy poszczególne składowe z daty
        $data_poczatkowa_dzien = $data_poczatkowa_pieces[0];
        $data_poczatkowa_dzien = $data_poczatkowa_dzien * 1;
        $data_poczatkowa_miesiac = $data_poczatkowa_pieces[1];
        $data_poczatkowa_miesiac = $data_poczatkowa_miesiac * 1; // mnożąc przez 1 pozbywamy się zera przy np wrześniu 09 - nie wyszukuje w bazie
        
        $data_poczatkowa_rok = $data_poczatkowa_pieces[2] * 1;
        $data_koncowa_dzien = $data_koncowa_pieces[0] * 1;
        $data_koncowa_dzien = $data_koncowa_dzien * 1;
        $data_koncowa_miesiac = $data_koncowa_pieces[1] * 1;
        $data_koncowa_miesiac = $data_koncowa_miesiac * 1;
        $data_koncowa_rok = $data_koncowa_pieces[2] * 1;
    


        $WARUNEK = ' WHERE (pracownik_a = "'.$pracownik_produkcji_id.'" OR pracownik_b = "'.$pracownik_produkcji_id.'"  OR pracownik_c = "'.$pracownik_produkcji_id.'"  OR pracownik_d = "'.$pracownik_produkcji_id.'") AND  data_wykonania_rok >= "'.$data_poczatkowa_rok.'" AND data_wykonania_miesiac >= "'.$data_poczatkowa_miesiac.'" AND data_wykonania_dzien >= "'.$data_poczatkowa_dzien.'" AND data_wykonania_rok <= "'.$data_koncowa_rok.'" AND data_wykonania_miesiac <= "'.$data_koncowa_miesiac.'" AND data_wykonania_dzien <= "'.$data_koncowa_dzien.'"';

        $WARUNEK_ADMIN = ' WHERE user_id = "'.$pracownik_produkcji_id.'" AND  data_wykonania_rok >= "'.$data_poczatkowa_rok.'" AND data_wykonania_miesiac >= "'.$data_poczatkowa_miesiac.'" AND data_wykonania_dzien >= "'.$data_poczatkowa_dzien.'" AND data_wykonania_rok <= "'.$data_koncowa_rok.'" AND data_wykonania_miesiac <= "'.$data_koncowa_miesiac.'" AND data_wykonania_dzien <= "'.$data_koncowa_dzien.'"';
            
        // if($user_id == 1) echo 'warunek='.$WARUNEK.'<br>';
        //deklaracja zmiennych tablic
        $i=0;
        $zamowienie_id = []; //aby znaleźć stopien trudnosci
        $data_wykonania = []; // to jest time
        $pozycja = [];
        $nr_zamowienia = [];

        $SUMA_0_WYKONANE = 0;
        $SUMA_1_WYKONANE = 0;
        // $SUMA_2_WYKONANE = 0;
        // $SUMA_3_WYKONANE = 0;
        $SUMA_4_WYKONANE = 0;
        $SUMA_5_WYKONANE = 0;
        $SUMA_6_WYKONANE = 0;
        $SUMA_7_WYKONANE = 0;
        $SUMA_8_WYKONANE = 0;
        $SUMA_9_WYKONANE = 0;
        $SUMA_10_WYKONANE = 0;
        $SUMA_11_WYKONANE = 0;


        //szukamy dodatkowych wpisów admina
        $HISTORIA_ADMIN = [];
        $data_time_admin = [];
        $wartosc_admin = [];
        $SUMA_ADMIN = 0;

        $k = 0;
        $pytanie66 = mysqli_query($conn, "SELECT * FROM premia_akordowa_wpisy ".$WARUNEK_ADMIN." ORDER BY ID DESC;");
        while($wynik66= mysqli_fetch_assoc($pytanie66))
            {
            $k++;
            $data_time_admin[$k]=$wynik66['data_time'];
            $data_admin = date('d-m-Y', $wynik66['data_time']);
            $godzina_admin = date('H:i:s', $wynik66['data_time']);

            $wartosc_admin[$k]=$wynik66['wartosc'];
            $SUMA_ADMIN += $wartosc_admin[$k];
            $HISTORIA_ADMIN[$k] = $data_admin.', godz. '.$godzina_admin.', Opis : '.$wynik66['opis'].', Wartość : '.$wartosc_admin[$k].' zł';
            }

        // echo 'war='.$WARUNEK_ADMIN.'<br>';
        $HISTORIA = [];
        $pytanie = mysqli_query($conn, "SELECT id, zamowienie_id, data_wykonania, pozycja, rodzaj_produktu, ilosc, pracownik_a, pracownik_b, pracownik_c, pracownik_d, nr_zamowienia, zamowic_profile, stopien_trudnosci FROM realizacja_produkcji ".$WARUNEK." ORDER BY ID DESC;");
        while($wynik= mysqli_fetch_assoc($pytanie))
            {
            $i++;

            $zamowienie_id[$i]=$wynik['zamowienie_id'];
            $akord_id[$i]=$wynik['id'];
            $data_wykonania[$i]=$wynik['data_wykonania'];
            $pozycja[$i]=$wynik['pozycja'];	
            $rodzaj_produktu=$wynik['rodzaj_produktu'];
            $ilosc=$wynik['ilosc'];
            $nr_zamowienia[$i]=$wynik['nr_zamowienia'];
            $data = date('d-m-Y', $data_wykonania[$i]);
            $godzina = date('H:i:s', $data_wykonania[$i]);

            $historia_stopien_trudnosci = 'BRAK';
            //szukam dodatkowych informacji o zamowieniu
            $pytanie44 = mysqli_query($conn, "SELECT nr_zamowienia, klient_nazwa FROM zamowienia WHERE id=".$zamowienie_id[$i].";");
            while($wynik44= mysqli_fetch_assoc($pytanie44))
            {
                $nr_zamowienia = $wynik44['nr_zamowienia'];
                $klient_nazwa = $wynik44['klient_nazwa'];
            }
            $pytanie414 = mysqli_query($conn, "SELECT ilosc_pozycji FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$i]." LIMIT 1;");
            while($wynik414= mysqli_fetch_assoc($pytanie414))
            {
                $ilosc_pozycji = $wynik414['ilosc_pozycji'];
            }

            //jak wszystkie pozycje
            if($pozycja[$i] == 'on') 
            {
                $opis_pozycji = 'wszystkie'; 
                $historia_stopien_trudnosci_temp = 0;
                // $historia_stopien_trudnosci = 1;

                $pytanie414 = mysqli_query($conn, "SELECT stopien_trudnosci FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$i].";");
                while($wynik414= mysqli_fetch_assoc($pytanie414))
                {
                    $historia_stopien_trudnosci_temp += $wynik414['stopien_trudnosci'];
                }
            $historia_stopien_trudnosci = $historia_stopien_trudnosci_temp/$ilosc_pozycji;
            }
            else 
            {
                $opis_pozycji = $pozycja[$i].'/'.$ilosc_pozycji;
                $pytanie414 = mysqli_query($conn, "SELECT stopien_trudnosci FROM wyceny WHERE zamowienie_id=".$zamowienie_id[$i]." AND pozycja = ".$pozycja[$i].";");
                while($wynik414= mysqli_fetch_assoc($pytanie414))
                {
                    $historia_stopien_trudnosci = $wynik414['stopien_trudnosci'];
                }
    
               

            }


            if($rodzaj_produktu == 0) 
            {
                $SUMA_0_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $wydane_profile;
            }
			// if($rodzaj_produktu == 2) 
            // {
            //     $SUMA_2_WYKONANE += $ilosc;
            //     $stawka_podstawowa_historia = 0;
            // }
            // if($rodzaj_produktu == 3) 
            // {
            //     $SUMA_3_WYKONANE += $ilosc;
            //     $stawka_podstawowa_historia = 0;
            // }
            if($rodzaj_produktu == 5) 
            {
                $SUMA_5_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $wstawione_slupki;
            }
            if($rodzaj_produktu == 6) 
            {
                $SUMA_6_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $wyfrezowane_odwodnienia;
            }
            if($rodzaj_produktu == 7) 
            {
                $SUMA_7_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $dociete_listwy;
            }

            if($rodzaj_produktu == 11) 
            {
                $SUMA_11_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $dociecie_kompletu_listew_przyszybowych;
            }
            
            if($rodzaj_produktu == 8) 
            {
                $SUMA_8_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $okute_elementy;
            }
            if($rodzaj_produktu == 9) 
            {
                $SUMA_9_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $zaszklone_elementy;
            }
            if($rodzaj_produktu == 10) 
            {
                $SUMA_10_WYKONANE += $ilosc;
                $stawka_podstawowa_historia = $spakowane_wyroby;
            }
            $jednostka = ' szt';

            //jezeli luki_pvc to szukamy stopnia trudnosci
            if($rodzaj_produktu == 1) 
                {
                $SUMA_1_WYKONANE +=$wynik['stopien_trudnosci'];
                $jednostka = ' m';
                $ilosc = $wynik['stopien_trudnosci'];
                $stawka_podstawowa_historia = $wygiete_profile_pvc;
                }
            //jezeli zgrzewy to szukamy stopnia trudnosci
            if($rodzaj_produktu == 4) 
                {
                $SUMA_4_WYKONANE +=$wynik['stopien_trudnosci'];
                $jednostka = ' m';
                $ilosc = $wynik['stopien_trudnosci'];
                $stawka_podstawowa_historia = $zgrzane_profile;
                }

            $historia_wartosc = number_format($ilosc * $stawka_podstawowa_historia, 2,'.','');
            $historia_stopien_trudnosci = number_format($historia_stopien_trudnosci, 2,'.','');
            $HISTORIA[$i] = $data.', godz. '.$godzina.', zamówienie '.$nr_zamowienia.', poz. '.$opis_pozycji.', '.$klient_nazwa.', stopień trudności '.$historia_stopien_trudnosci.', '.$ilosc.$jednostka.' x '.$stawka_podstawowa_historia.' zł = '.$historia_wartosc.' zł';
            // 05.05.2021, godz. 12.00, zamówienie 2455/04/21, poz. 1/2, KONSPO, stopień trudności 2, 12.50 m x 0.80 zł = 10.00 zł 

            }

        $wartosc_0 = number_format($SUMA_0_WYKONANE * $wydane_profile, 2,'.','');
        $wartosc_1 = number_format($SUMA_1_WYKONANE * $wygiete_profile_pvc, 2,'.','');
        $wartosc_4 = number_format($SUMA_4_WYKONANE * $zgrzane_profile, 2,'.','');
        $wartosc_5 = number_format($SUMA_5_WYKONANE * $wstawione_slupki, 2,'.','');
        $wartosc_6 = number_format($SUMA_6_WYKONANE * $wyfrezowane_odwodnienia, 2,'.','');
        $wartosc_7 = number_format($SUMA_7_WYKONANE * $dociete_listwy, 2,'.','');
        $wartosc_8 = number_format($SUMA_8_WYKONANE * $okute_elementy, 2,'.','');
        $wartosc_9 = number_format($SUMA_9_WYKONANE * $zaszklone_elementy, 2,'.','');
        $wartosc_10= number_format($SUMA_10_WYKONANE * $spakowane_wyroby, 2,'.','');
        $wartosc_11= number_format($SUMA_11_WYKONANE * $dociecie_kompletu_listew_przyszybowych, 2,'.','');

        $wartosc_premii = $wartosc_0 + $wartosc_1 + $wartosc_4 + $wartosc_5 + $wartosc_6 + $wartosc_7 + $wartosc_8 + $wartosc_9 + $wartosc_10 + $wartosc_11 + $SUMA_ADMIN;

        $wartosc_premii= number_format($wartosc_premii, 2,'.',' ');

        //tabela główna
        echo '<table width="1700px" align="left" cellspacing="6" cellpadding="6" border="0"><tr align="left"><td>';

            //tabela nagłówek
            echo '<table width="800px" align="left" cellspacing="6" cellpadding="6" border="0">';
                echo '<tr align="center" class="text_18"><td width="20%" align="right">Pracownik : </td>';
                echo '<td width="80%" align="left">'.$imie.' '.$nazwisko.'</td></tr>';

                echo '<tr align="center" class="text_18"><td width="30%" align="right">Okres : </td>';
                echo '<td width="70%" align="left">';
                    echo '<div class="text_18" align="left">Od - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_poczatkowa" id="f_data_poczatkowa" value="'.$data_poczatkowa.'">';
                    echo '&nbsp;&nbsp;Do - <input type="text" size="10" class="pole_input_produkcja_kalendarz" autocomplete="off" name="data_koncowa" id="f_data_koncowa" value="'.$data_koncowa.'">';
                    echo '&nbsp;&nbsp;<input type="submit" name="submit" value="Pokaż" class="pole_input_produkcja_kalendarz"></div>';
                echo '</td></tr>';

                echo '<tr align="center" class="text_18"><td width="30%" align="right">Wartość premii : </td>';
                echo '<td width="70%" align="left">'.$wartosc_premii.' zł</td></tr>';
            echo '</table>';

        echo '</td><td width="900px">';
        //sprawdzamy czy zalogowany jest admin aby importować możliwość dodawania wpisów
        if(($stanowisko_zalogowanego_usera == 'administrator') && ($pracownik_produkcji_id != '')) 
        {
            //wyciagam dane uzytkownika
            $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$pracownik_produkcji_id.";");
            while($wynik= mysqli_fetch_assoc($pytanie))
                echo '<div class="text_duzy" align="center">Dodaj wpis do premii akordowej dla pracownika : <font color="green">'.$wynik['imie'].' '.$wynik['nazwisko'].'</font></div><br>';

            echo '<FORM action="index.php?page=produkcja_premia_akordowa" method="post">';
            echo '<input type="hidden" name="pracownik_produkcji_id" value="'.$pracownik_produkcji_id.'">';
            echo '<input type="hidden" name="podane_haslo" value="'.$podane_haslo.'">';
            echo '<table border="0" class="text" width="100%" align="center">';
            
            echo '<tr align="center"><td align="right" class="text">Wartość : </td>';
            echo '<td align="left"><input type="text" name="wartosc1" size="6" maxlenght="8" class="text" autocomplete="off">'.$waluta.'</td></tr>';
            
            echo '<tr align="center" height="100px"><td align="right" class="text">Opis : </td>';
            echo '<td align="left"><textarea name="opis" cols="49" rows="4" class="text"></textarea></td></tr>';
        
            echo '</table>';
            echo '<br><div align="center"><INPUT type="submit" class="text" name="zapisz" value="Zapisz"></div>';
            echo '</form>';
        }


        echo '</td></tr><tr align="left"><td colspan="2">';
       
            //tabela z wartościami
            echo '<table width="1800px" align="left" cellspacing="5" cellpadding="5" border="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
                echo '<tr><td colspan="11" align="left" style="border-top-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">Zestawienie zbiorcze wykonanych zleceń:</td></tr>';

                //poziom 1
                echo '<tr align="center" bgcolor="'.$kolor_szary.'" height="40px">';
                echo '<td width=8%">Dotyczy</td>';
                echo '<td width=8%">'.$kol_wydane_profile.'</td>';
                echo '<td width=8%">'.$kol_wygiete_profile_pvc.'</td>';
                echo '<td width=8%">'.$kol_wyfrezowane_odwodnienia.'</td>';
                echo '<td width=8%">'.$kol_zgrzane_profile.'</td>';
                echo '<td width=8%">'.$kol_wstawione_slupki.'</td>';
                echo '<td width=8%">'.$kol_dociete_listwy.'</td>';
                echo '<td width=8%">'.$kol_dociecie_kompletu_listew_przyszybowych.'</td>';
                echo '<td width=8%">'.$kol_okute_elementy.'</td>';
                echo '<td width=8%">'.$kol_zaszklone_elementy.'</td>';
                echo '<td width=8%">'.$kol_spakowane_wyroby.'</td>';
                echo '</tr>';

                //poziom 2 ilość nie liczymy rodzaju produktu 2 i 3
                echo '<tr align="center" bgcolor="'.$kolor_bialy.'" height="40px">';
                echo '<td bgcolor="'.$kolor_szary.'">Ilość</td>';
                echo '<td>'.$SUMA_0_WYKONANE.' szt</td>'; //Wydane profile
                echo '<td>'.$SUMA_1_WYKONANE.' m</td>'; //Wygięte profile z pvc MNOZYMY RAZY STOPIEN TRUDNOSCI
                echo '<td>'.$SUMA_6_WYKONANE.' szt</td>'; //Wyfrezowane odwodnienia
                echo '<td>'.$SUMA_4_WYKONANE.' szt</td>'; //Zgrzane profile MNOZYMY RAZY STOPIEN TRUDNOSCI
                echo '<td>'.$SUMA_5_WYKONANE.' szt</td>'; //Wstawione słupki
                echo '<td>'.$SUMA_7_WYKONANE.' szt</td>'; //Docięte listwy
                echo '<td>'.$SUMA_11_WYKONANE.' szt</td>'; //Docięte kompletu_listew_przyszybowych
                echo '<td>'.$SUMA_8_WYKONANE.' szt</td>'; //Okute elementy
                echo '<td>'.$SUMA_9_WYKONANE.' szt</td>'; //Zaszklone elementy
                echo '<td>'.$SUMA_10_WYKONANE.' szt</td>'; //Spakowane wyroby
                echo '</tr>';

                //poziom 2 Stawka podstawowa
                echo '<tr align="center" bgcolor="'.$kolor_bialy.'" height="40px">';
                echo '<td bgcolor="'.$kolor_szary.'">Stawka podstawowa</td>';
                echo '<td>'.$wydane_profile.' '.$waluta.'</td>'; //Wydane profile
                echo '<td>'.$wygiete_profile_pvc.' '.$waluta.'</td>'; //Wygięte profile z pvc
                echo '<td>'.$wyfrezowane_odwodnienia.' '.$waluta.'</td>'; //Wyfrezowane odwodnienia
                echo '<td>'.$zgrzane_profile.' '.$waluta.'</td>'; //Zgrzane profile
                echo '<td>'.$wstawione_slupki.' '.$waluta.'</td>'; //Wstawione słupki
                echo '<td>'.$dociete_listwy.' '.$waluta.'</td>'; //Docięte listwy
                echo '<td>'.$dociecie_kompletu_listew_przyszybowych.' '.$waluta.'</td>'; //Docięte kompletu_listew_przyszybowych
                echo '<td>'.$okute_elementy.' '.$waluta.'</td>'; //Okute elementy
                echo '<td>'.$zaszklone_elementy.' '.$waluta.'</td>'; //Zaszklone elementy
                echo '<td>'.$spakowane_wyroby.' '.$waluta.'</td>'; //Spakowane wyroby
                echo '</tr>';
        
                //poziom 2 Wartość
                echo '<tr align="center" bgcolor="'.$kolor_bialy.'" height="40px">';
                echo '<td bgcolor="'.$kolor_szary.'">Wartość</td>';
                echo '<td>'.$wartosc_0.' '.$waluta.'</td>'; //Wydane profile
                echo '<td>'.$wartosc_1.' '.$waluta.'</td>'; //Wygięte profile z pvc
                echo '<td>'.$wartosc_6.' '.$waluta.'</td>'; //Wyfrezowane odwodnienia
                echo '<td>'.$wartosc_4.' '.$waluta.'</td>'; //Zgrzane profile
                echo '<td>'.$wartosc_5.' '.$waluta.'</td>'; //Wstawione słupki
                echo '<td>'.$wartosc_7.' '.$waluta.'</td>'; //Docięte listwy
                echo '<td>'.$wartosc_11.' '.$waluta.'</td>'; //Docięte kompletu_listew_przyszybowych
                echo '<td>'.$wartosc_8.' '.$waluta.'</td>'; //Okute elementy
                echo '<td>'.$wartosc_9.' '.$waluta.'</td>'; //Zaszklone elementy
                echo '<td>'.$wartosc_10.' '.$waluta.'</td>'; //Spakowane wyroby
                echo '</tr>';
            echo '</table>';
       
        echo '</td></tr><tr align="left"><td colspan="2">';
            //tabela z historią zamówień
            echo '<table width="1500px" align="left" cellspacing="5" cellpadding="5" border="0" class="text">';
                echo '<tr><td colspan="11" align="left">Historia wykonanych zleceń:</td></tr>';
                //wyswietla wszystkie najnowsze wpisy admina
                for($y = 1; $y<=$k; $y++)
                    if(($data_time_admin[$y] >= $data_wykonania[1]) && ($data_time_admin[$y] != ''))
                    {
                        echo '<tr><td colspan="11" align="left"><font color="blue">'.$HISTORIA_ADMIN[$y].'</font></td></tr>';
                        $data_time_admin[$y] = '';
                    }
            
                for($x = 1; $x<=$i; $x++)
                {
                    //wyswietlam historie wykonanych zamowien
                    echo '<tr><td colspan="11" align="left">'.$HISTORIA[$x].'</td></tr>';
                    for($y = 1; $y<=$k; $y++)
                        if(($data_time_admin[$y] <= $data_wykonania[$x]) && ($data_time_admin[$y] >= $data_wykonania[$x+1]) && ($data_time_admin[$y] != ''))
                        {
                            echo '<tr><td colspan="11" align="left"><font color="blue">'.$HISTORIA_ADMIN[$y].'</font></td></tr>';
                            $data_time_admin[$y] = '';
                            break;
                        }
                }

                //wyswietla wszystkie pozostale wpisy admina
                for($y = 1; $y<=$k; $y++) 
                    if($data_time_admin[$y] != '') 
                    {
                        echo '<tr><td colspan="11" align="left"><font color="blue">'.$HISTORIA_ADMIN[$y].'</font></td></tr>';
                        $data_time_admin[$y] = '';
                    }
                echo '</table>';
        
        echo '</td></tr></table>';
        echo '</form>';
?>
        <script type="text/javascript">
            Calendar.setup({
                inputField     :    "f_data_poczatkowa",     // id of the input field
                ifFormat       :    "%d-%m-%Y",      // format of the input field
                button         :    "f_data_poczatkowa",  // trigger for the calendar (button ID)
                singleClick    :    true
            });
        </script>
        <script type="text/javascript">
            Calendar.setup({
                inputField     :    "f_data_koncowa",     // id of the input field
                ifFormat       :    "%d-%m-%Y",      // format of the input field
                button         :    "f_data_koncowa",  // trigger for the calendar (button ID)
                singleClick    :    true
            });
        </script>
<?php
    }
    else
    {
        //podane hasło jest niezgodne z tym w bazie danych
        echo '<div class="text_duzy_czerwony" align="center">Wpisane hasło jest błędne.</div><br>';
    }
}



if(($pracownik_produkcji_id) && (!$submit))
{
    //wyciagam dane uzytkownika
    $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$pracownik_produkcji_id.";");
    while($wynik= mysqli_fetch_assoc($pytanie))
    {
        echo '<div class="text_duzy" align="center">Witaj <font color="green">'.$wynik['imie'].' '.$wynik['nazwisko'].'</font></div><br>';
        
        echo '<FORM action="index.php?page=produkcja_premia_akordowa" method="post">';
        echo '<input type="hidden" name="pracownik_produkcji_id" value="'.$pracownik_produkcji_id.'">';
        echo '<div align="center"><span class="text_duzy">Proszę podać swoje hasło : </span><input type="text" name="podane_haslo" class="pole_input_duze_szare" autocomplete="off" required=""></div>';
       
        echo '<br><div align="center"><INPUT type="submit" class="text" name="submit" value="Dalej"></div>';
        echo '</form>';
    
    }

}
elseif(!$submit)
{
    //deklaracja pustych tablic
    $uzytkownik_id = [];
    $imie = [];
    $nazwisko = [];
    $ADMIN_HASLO = [];

    //wyciagam aktywnych uzytkownikow z bazy
    $pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on' ORDER BY ID ASC;");
    while($wynik= mysqli_fetch_assoc($pytanie))
        {
        $i++;
        $uzytkownik_id[$i]=$wynik['id'];
        $imie[$i]=$wynik['imie'];
        $nazwisko[$i]=$wynik['nazwisko'];
        $ADMIN_HASLO[$i]=$wynik['haslo'];
        }
    

     echo '<div class="text_duzy" align="center">Premia akordowa</div><br>';

    //wyswietlam liste aktywnych uzytkowników
    $szerokosc_pola_input_ilosc = '40px';
    $szerokosc_kolumny = 100;
    echo '<table align="center" class="tabela"><tr align="center" height="50" bgcolor="'.$kolor_tabeli.'" class="text_duzy">';
    echo '<td width="50px">'.$kol_lp.'</td>';
    echo '<td width="550px">'.$kol_imie_nazwisko.'</td>';

    echo '</tr>';

    for ($x=1; $x<=$i; $x++)
        {
        echo '<tr class="text_duzy" height="50" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text_duzy">'.$x.'</td>';
            if($stanowisko_zalogowanego_usera == 'administrator') echo '<td><a href="index.php?page=produkcja_premia_akordowa&pracownik_produkcji_id='.$uzytkownik_id[$x].'&podane_haslo='.$ADMIN_HASLO[$x].'"><div class="text_duzy">'.$imie[$x].' '.$nazwisko[$x].'</div></a></td>';
            else echo '<td><a href="index.php?page=produkcja_premia_akordowa&pracownik_produkcji_id='.$uzytkownik_id[$x].'"><div class="text_duzy">'.$imie[$x].' '.$nazwisko[$x].'</div></a></td>';
        echo '</tr>';
        }
    echo '</table>';
}

?>