<?php
$aktywny = 0;
$nieaktywny = 0;
$pytanie = mysqli_query($conn, "SELECT data_ostatniego_zamowienia FROM klienci;");
while ($wynik = mysqli_fetch_assoc($pytanie)) {
    $data_ostatniego_zamowienia = $wynik['data_ostatniego_zamowienia'];

    if ($data_ostatniego_zamowienia != '') {
        $rozbite = explode("-", $data_ostatniego_zamowienia);
        $data_ostatniego_zamowienia_time = mktime(0, 0, 0, $rozbite[1], $rozbite[0], $rozbite[2]);
        $odstep = $time - $czas_miedzy_zamowieniami_2 - $data_ostatniego_zamowienia_time;
        if ($odstep > 0) {
            $nieaktywny++;
        } else {
            $aktywny++;
        }

    } else {
        $nieaktywny++;
    }

}

echo '<div align="center" class="text_duzy">' . $wyraz_Ilosc . ' aktywnych ' . $wyraz_klientow . ' : ' . $aktywny . '</div>';
echo '<div align="center" class="text_duzy">' . $wyraz_Ilosc . ' nieaktywnych ' . $wyraz_klientow . ' : ' . $nieaktywny . '</div>';
