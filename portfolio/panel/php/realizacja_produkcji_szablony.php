<?php

function przerob_sql($sql) {
    $szukaj = "'";
    $zamien_na = " ";
    $przerobione_query = zamien_dowolne_znaki($sql, $szukaj, $zamien_na);
    $szukaj = '"';
    $przerobione_query = zamien_dowolne_znaki($przerobione_query, $szukaj, $zamien_na);
    return $przerobione_query;
}

//zerowanie zmiennych ilosciowych
if($szablony_przy_wyrobach_ilosc == '') $szablony_przy_wyrobach_ilosc = 0;
if($szablony_luzem_ilosc == '') $szablony_luzem_ilosc = 0;
if($profile_ilosc == '') $profile_ilosc = 0;
if($uszczelki_ilosc == '') $uszczelki_ilosc = 0;

// echo 'szablony<br>';
//sprawdzamy czy wpis do tego zamowienia juz istnieje. jak istnieje to update. jak nie to insert
if ($zamowienie_id_akord) {
    $sql1 = "SELECT * FROM realizacja_produkcji_szablony WHERE zamowienie_id = " . $zamowienie_id_akord . ";";
    mysqli_query($conn, $sql1);

    if(mysqli_num_rows($result) > 0) {
        //jak zamowienie juz jest to spr czy ilosc jest inna niz 0, jak jest to zapisujemy ilosc z bazy do ilosci z selecta i zaznaczamy checkboxa na on.
        while ($wynik = mysqli_fetch_assoc($result)) {
            $BAZA_szablony_przy_wyrobach_on = $wynik['szablony_przy_wyrobach_on'];
            $BAZA_szablony_przy_wyrobach_ilosc = $wynik['szablony_przy_wyrobach_ilosc'];

            $BAZA_szablony_luzem_on = $wynik['szablony_luzem_on'];
            $BAZA_szablony_luzem_ilosc = $wynik['szablony_luzem_ilosc'];

            $BAZA_profile_on = $wynik['profile_on'];
            $BAZA_profile_ilosc = $wynik['profile_ilosc'];

            $BAZA_uszczelki_on = $wynik['uszczelki_on'];
            $BAZA_uszczelki_ilosc = $wynik['uszczelki_ilosc'];

            //pierwsze zaladowanie strony - checkbox jest pusty i ilosc tez, więc trzeba je pobrac z bazy
            if(($szablony_przy_wyrobach_on == '') && ($szablony_przy_wyrobach_ilosc == '')) {
                //w bazie coś już jest
                if(($BAZA_szablony_przy_wyrobach_on == 'on') && ($BAZA_szablony_przy_wyrobach_ilosc != 0)) {
                    $szablony_przy_wyrobach_on = $BAZA_szablony_przy_wyrobach_on;
                    $szablony_przy_wyrobach_ilosc = $BAZA_szablony_przy_wyrobach_ilosc;
                }
            }

            if(($szablony_luzem_on == '') && ($szablony_luzem_ilosc == '')) {
                //w bazie coś już jest
                if(($BAZA_szablony_luzem_on == 'on') && ($BAZA_szablony_luzem_ilosc != 0)) {
                    $szablony_luzem_on = $BAZA_szablony_luzem_on;
                    $szablony_luzem_ilosc = $BAZA_szablony_luzem_ilosc;
                }
            }


            if(($profile_on == '') && ($profile_ilosc == ''))
            {
                //w bazie coś już jest
                if(($BAZA_profile_on == 'on') && ($BAZA_profile_ilosc != 0)) {
                    $profile_on = $BAZA_profile_on;
                    $profile_ilosc = $BAZA_profile_ilosc;
                }
            }

            
            if(($uszczelki_on == '') && ($uszczelki_ilosc == ''))
            {
                //w bazie coś już jest
                if(($BAZA_uszczelki_on == 'on') && ($BAZA_uszczelki_ilosc != 0)) {
                    $uszczelki_on = $BAZA_uszczelki_on;
                    $uszczelki_ilosc = $BAZA_uszczelki_ilosc;
                }
            }

            //odznaczamy checkboxa
            if(($BAZA_szablony_przy_wyrobach_on == 'on') && ($szablony_przy_wyrobach_on == '') && ($szablony_przy_wyrobach_ilosc == $BAZA_szablony_przy_wyrobach_ilosc)) {
                // echo 'odznaczamy checkboxa<br>';
                $szablony_przy_wyrobach_ilosc = 0;
            }

            //odznaczamy checkboxa
            if(($BAZA_szablony_luzem_on == 'on') && ($szablony_luzem_on == '') && ($szablony_luzem_ilosc == $BAZA_szablony_luzem_ilosc)) {
                // echo 'odznaczamy checkboxa<br>';
                $szablony_luzem_ilosc = 0;
            }

            //odznaczamy checkboxa
            if(($BAZA_profile_on == 'on') && ($profile_on == '') && ($profile_ilosc == $BAZA_profile_ilosc)) {
                // echo 'odznaczamy checkboxa<br>';
                $profile_ilosc = 0;
            }

            //odznaczamy checkboxa
            if(($BAZA_uszczelki_on == 'on') && ($uszczelki_on == '') && ($uszczelki_ilosc == $BAZA_uszczelki_ilosc)) {
                // echo 'odznaczamy checkboxa<br>';
                $uszczelki_ilosc = 0;
            }

        }

        $data_temp = date('d-m-Y, H:i:s', $time);

        $SQL = [];
        $SQL[1] = "UPDATE realizacja_produkcji_szablony SET szablony_przy_wyrobach_on = '".$szablony_przy_wyrobach_on."' WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[2] = "UPDATE realizacja_produkcji_szablony SET szablony_przy_wyrobach_ilosc = ".$szablony_przy_wyrobach_ilosc." WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[3] = "UPDATE realizacja_produkcji_szablony SET szablony_luzem_on = '".$szablony_luzem_on."' WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[4] = "UPDATE realizacja_produkcji_szablony SET szablony_luzem_ilosc = ".$szablony_luzem_ilosc." WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[5] = "UPDATE realizacja_produkcji_szablony SET profile_on = '".$profile_on."' WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[6] = "UPDATE realizacja_produkcji_szablony SET profile_ilosc = ".$profile_ilosc." WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[7] = "UPDATE realizacja_produkcji_szablony SET uszczelki_on = '".$uszczelki_on."' WHERE zamowienie_id = ".$zamowienie_id_akord.";";
        $SQL[8] = "UPDATE realizacja_produkcji_szablony SET uszczelki_ilosc = ".$uszczelki_ilosc." WHERE zamowienie_id = ".$zamowienie_id_akord.";";

        $przerobione_query = 'szablony przy wyrobach ('.$szablony_przy_wyrobach_on.') = '.$szablony_przy_wyrobach_ilosc.', szablony luzem ('.$szablony_luzem_on.') = '.$szablony_luzem_ilosc.', profile ('.$profile_on.') = '.$profile_ilosc.', uszczelki('.$uszczelki_on.') = '.$uszczelki_ilosc;

        //wykonanie zapytan
        for($s=1; $s<=8; $s++) mysqli_query($conn, $SQL[$s]);

        //dodaję zapytanie do tymczasowej bazy danych
        $query2 = "INSERT INTO `a_szablony_zapytania` (`user_id`, `tresc`, `data`, `time`, `zamowienie_id`) 
        VALUES ($zalogowany_user, '$przerobione_query', '$data_temp', '$time', '$zamowienie_id_akord');";
        mysqli_query($conn, $query2);	

    }
    elseif($zamowienie_id_akord != 0) {
        $query = "INSERT INTO `realizacja_produkcji_szablony` (`zamowienie_id`, `szablony_przy_wyrobach_on`, `szablony_przy_wyrobach_ilosc`, `szablony_luzem_on`, `szablony_luzem_ilosc`, `profile_on`, `profile_ilosc`, `uszczelki_on`, `uszczelki_ilosc`) VALUES ('$zamowienie_id_akord', '$szablony_przy_wyrobach_on', '$szablony_przy_wyrobach_ilosc', '$szablony_luzem_on', '$szablony_luzem_ilosc', '$profile_on', '$profile_ilosc', '$uszczelki_on', '$uszczelki_ilosc');";
        mysqli_query($conn, $query);	
        } 
    }



?>