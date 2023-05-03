<?php
//jezeli lolkalnie
if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
{
    // serwer
    $mysql_server = "localhost";
    // admin
    $mysql_admin = "root";
    // hasło
    $mysql_pass = "";
    // nazwa baza
    $mysql_db = "arcus-luki_105";

    $adres_serwera_do_faktur = '127.0.0.1';

    //jak plik jpk_fa to ma nie drukować tego napisu
    if(($miesiac_od == '') || ($miesiac_do == '')) echo '<font color="#0876ff" size="5"><b><center>PANEL LOKALNY!!!</center></b></font>';

}
else //jezeli na serwerze
{
    // nowa wersja bazy danych
    $mysql_server = "mariadb106.server629307.nazwa.pl";
    $mysql_pass = "arcusPODWIESK65";
    $mysql_admin = "server629307_panel";
    $mysql_db = "server629307_panel";

    $adres_serwera_do_faktur = 'jaroslawkubiak.pl';
}

$conn = mysqli_connect($mysql_server, $mysql_admin, $mysql_pass, $mysql_db)
or die('<br><br><br><br><br><font color=red size=7><center><b>Brak połączenia z serwerem MySQL.<br><br>Prosimy spróbować póniej.</b></center></font>');

//zmieniamy kodowanie znakow połączenia z baza na utf-8
if($_SERVER['REMOTE_ADDR'] != '127.0.0.1') mysqli_set_charset($conn, "utf8");
?>