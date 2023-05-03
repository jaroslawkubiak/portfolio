<?php
//dodatkowe zabezpieczenie przezd brakujące wartością przy wygięciu listwy z pvc. to chyba drugie zgłoszenie od Pawła z dnia 22.05.2020 źle liczyło cenę netto za sztukę, ale dobrze wartosc netto.
//echo 'dodatkowe zabezpieczenia';

$nazwa_wygiecie_ramy_z_pvc_wartosc[$i] = (float)$nazwa_wygiecie_ramy_z_pvc_ilosc_m[$i] * $nazwa_wygiecie_ramy_z_pvc_cena[$i];
$nazwa_wygiecie_skrzydla_z_pvc_wartosc[$i] = (float)$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m[$i] * $nazwa_wygiecie_skrzydla_z_pvc_cena[$i];
$nazwa_wygiecie_listwy_z_pvc_wartosc[$i] = (float)$nazwa_wygiecie_listwy_z_pvc_ilosc_m[$i] * $nazwa_wygiecie_listwy_z_pvc_cena[$i];
$nazwa_wygiecie_innego_elementu_z_pvc_wartosc[$i] = (float)$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m[$i] * $nazwa_wygiecie_innego_elementu_z_pvc_cena[$i];

$nazwa_wygiecie_ramy_z_alu_wartosc[$i] = (float)$nazwa_wygiecie_ramy_z_alu_ilosc_m[$i] * $nazwa_wygiecie_ramy_z_alu_cena[$i];
$nazwa_wygiecie_skrzydla_z_alu_wartosc[$i] = (float)$nazwa_wygiecie_skrzydla_z_alu_ilosc_m[$i] * $nazwa_wygiecie_skrzydla_z_alu_cena[$i];
$nazwa_wygiecie_listwy_z_alu_wartosc[$i] = (float)$nazwa_wygiecie_listwy_z_alu_ilosc_m[$i] * $nazwa_wygiecie_listwy_z_alu_cena[$i];
$nazwa_wygiecie_innego_elementu_z_alu_wartosc[$i] = (float)$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m[$i] * $nazwa_wygiecie_innego_elementu_z_alu_cena[$i];

$nazwa_wygiecie_wzmocnienia_okiennego_wartosc[$i] = (float)$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m[$i] * $nazwa_wygiecie_wzmocnienia_okiennego_cena[$i];
$nazwa_wygiecie_innego_elementu_ze_stali_wartosc[$i] = (float)$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m[$i] * $nazwa_wygiecie_innego_elementu_ze_stali_cena[$i];

$nazwa_zgrzanie_wartosc[$i] = (float)$nazwa_zgrzanie_ilosc_m[$i] * $nazwa_zgrzanie_cena[$i];
$nazwa_wyfrezowanie_odwodnienia_wartosc[$i] = (float)$nazwa_wyfrezowanie_odwodnienia_ilosc_m[$i] * $nazwa_wyfrezowanie_odwodnienia_cena[$i];
$nazwa_wstawienie_slupka_wartosc[$i] = (float)$nazwa_wstawienie_slupka_ilosc_m[$i] * $nazwa_wstawienie_slupka_cena[$i];
$nazwa_wstawienie_slupka_ruchomego_wartosc[$i] = (float)$nazwa_wstawienie_slupka_ruchomego_ilosc_m[$i] * $nazwa_wstawienie_slupka_ruchomego_cena[$i];
$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i] = (float)$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m[$i] * $nazwa_dociecie_kompletu_listew_przyszybowych_cena[$i];
$nazwa_okucie_wartosc[$i] = (float)$nazwa_okucie_ilosc_m[$i] * $nazwa_okucie_cena[$i];
$nazwa_zaszklenie_wartosc[$i] = (float)$nazwa_zaszklenie_ilosc_m[$i] * $nazwa_zaszklenie_cena[$i];
$nazwa_wykonanie_innej_uslugi_wartosc[$i] = (float)$nazwa_wykonanie_innej_uslugi_ilosc_m[$i] * $nazwa_wykonanie_innej_uslugi_cena[$i];
$nazwa_oscieznica_wartosc[$i] = (float)$nazwa_oscieznica_ilosc_m[$i] * $nazwa_oscieznica_cena[$i];
$nazwa_skrzydlo_wartosc[$i] = (float)$nazwa_skrzydlo_ilosc_m[$i] * $nazwa_skrzydlo_cena[$i];
$nazwa_listwa_wartosc[$i] = (float)$nazwa_listwa_ilosc_m[$i] * $nazwa_listwa_cena[$i];
$nazwa_slupek_wartosc[$i] = (float)$nazwa_slupek_ilosc_m[$i] * $nazwa_slupek_cena[$i];
$nazwa_wzmocnienie_do_ramy_wartosc[$i] = (float)$nazwa_wzmocnienie_do_ramy_ilosc_m[$i] * $nazwa_wzmocnienie_do_ramy_cena[$i];
$nazwa_wzmocnienie_do_skrzydla_wartosc[$i] = (float)$nazwa_wzmocnienie_do_skrzydla_ilosc_m[$i] * $nazwa_wzmocnienie_do_skrzydla_cena[$i];
$nazwa_wzmocnienie_do_slupka_wartosc[$i] = (float)$nazwa_wzmocnienie_do_slupka_ilosc_m[$i] * $nazwa_wzmocnienie_do_slupka_cena[$i];
$nazwa_wzmocnienie_do_luku_wartosc[$i] = (float)$nazwa_wzmocnienie_do_luku_ilosc_m[$i] * $nazwa_wzmocnienie_do_luku_cena[$i];
$nazwa_okucia_wartosc[$i] = (float)$nazwa_okucia_ilosc_m[$i] * $nazwa_okucia_cena[$i];
$nazwa_szyby_wartosc[$i] = (float)$nazwa_szyby_ilosc_m[$i] * $nazwa_szyby_cena[$i];
$nazwa_inny_element_wartosc[$i] = (float)$nazwa_inny_element_ilosc_m[$i] * $nazwa_inny_element_cena[$i];

$nazwa_wartosc_netto[$i] = 
(float)$nazwa_wygiecie_ramy_z_pvc_wartosc[$i] + 
(float)$nazwa_wygiecie_skrzydla_z_pvc_wartosc[$i] + 
(float)$nazwa_wygiecie_listwy_z_pvc_wartosc[$i] + 
(float)$nazwa_wygiecie_innego_elementu_z_pvc_wartosc[$i] + 
(float)$nazwa_wygiecie_ramy_z_alu_wartosc[$i] + 
(float)$nazwa_wygiecie_skrzydla_z_alu_wartosc[$i] + 
(float)$nazwa_wygiecie_listwy_z_alu_wartosc[$i] + 
(float)$nazwa_wygiecie_innego_elementu_z_alu_wartosc[$i] + 
(float)$nazwa_wygiecie_wzmocnienia_okiennego_wartosc[$i] + 
(float)$nazwa_wygiecie_innego_elementu_ze_stali_wartosc[$i] + 
(float)$nazwa_zgrzanie_wartosc[$i] + 
(float)$nazwa_wyfrezowanie_odwodnienia_wartosc[$i] + 
(float)$nazwa_wstawienie_slupka_wartosc[$i] + 
(float)$nazwa_wstawienie_slupka_ruchomego_wartosc[$i] + 
(float)$nazwa_dociecie_listwy_przyszybowej_wartosc[$i] + 
(float)$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc[$i] + 
(float)$nazwa_okucie_wartosc[$i] + 
(float)$nazwa_zaszklenie_wartosc[$i] + 
(float)$nazwa_wykonanie_innej_uslugi_wartosc[$i] + 
(float)$nazwa_oscieznica_wartosc[$i] + 
(float)$nazwa_skrzydlo_wartosc[$i] + 
(float)$nazwa_listwa_wartosc[$i] + 
(float)$nazwa_slupek_wartosc[$i] + 
(float)$nazwa_wzmocnienie_do_ramy_wartosc[$i] + 
(float)$nazwa_wzmocnienie_do_skrzydla_wartosc[$i] + 
(float)$nazwa_wzmocnienie_do_slupka_wartosc[$i] + 
(float)$nazwa_wzmocnienie_do_luku_wartosc[$i] + 
(float)$nazwa_okucia_wartosc[$i] + 
(float)$nazwa_szyby_wartosc[$i] + 
(float)$nazwa_inny_element_wartosc[$i] + 
(float)$nazwa_okna_wartosc[$i] + 
(float)$nazwa_drzwi_wewnetrzne_wartosc[$i] + 
(float)$nazwa_drzwi_zewnetrzne_wartosc[$i] + 
(float)$nazwa_bramy_wartosc[$i] + 
(float)$nazwa_parapety_wartosc[$i] + 
(float)$nazwa_rolety_zewnetrzne_wartosc[$i] + 
(float)$nazwa_rolety_wewnetrzne_wartosc[$i] + 
(float)$nazwa_moskitiery_wartosc[$i] + 
(float)$nazwa_montaz_wartosc[$i] + 
(float)$nazwa_odpady_z_pvc_wartosc[$i] + 
(float)$nazwa_odpady_ze_stali_wartosc[$i] + 
(float)$nazwa_transport_wartosc[$i] + 
(float)$nazwa_inne_wartosc[$i];

$nazwa_wartosc_brutto[$i] = $nazwa_wartosc_netto[$i] + ($nazwa_wartosc_netto[$i] * ($nazwa_vat[$i]/100));

if($nazwa_ilosc_sztuk[$i] != 0) $nazwa_cena_netto_za_sztuke[$i] = $nazwa_wartosc_netto[$i]/ $nazwa_ilosc_sztuk[$i];



?>