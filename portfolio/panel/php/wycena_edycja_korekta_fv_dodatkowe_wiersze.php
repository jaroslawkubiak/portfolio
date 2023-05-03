<?php
	echo '<tr bgcolor="98f3f0" align="center" height="'.$wysykosc_wiersza.'"><td>'.$x.'/'.$ilosc_pozycji.'</td>';
	echo '<td align="right">'.$wygiecie_ramy_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_pvc_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_pvc_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_pvc_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_skrzydla_z_pvc ###################################################################
	echo '<td align="right">'.$wygiecie_skrzydla_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_pvc_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_pvc_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_pvc_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_listwy_z_pvc ###################################################################
	echo '<td align="right">'.$wygiecie_listwy_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_pvc_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_pvc_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_pvc_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_innego elementu_z_pvc ###################################################################
	echo '<td align="right">'.$wygiecie_innego_pvc_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_pvc_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_pvc_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_pvc_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_ramy_alu_ilosc_szt ###################################################################
	echo '<td align="right">'.$wygiecie_ramy_alu_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_alu_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_alu_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_ramy_alu_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_skrzydla_z_alu ###################################################################
	echo '<td align="right">'.$wygiecie_skrzydla_alu_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_alu_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_alu_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_skrzydla_alu_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_listwy_z_alu ###################################################################
	echo '<td align="right">'.$wygiecie_listwy_alu_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_alu_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_alu_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_listwy_alu_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_innego elementu_z_alu ###################################################################
	echo '<td align="right">'.$wygiecie_innego_alu_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_alu_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_alu_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_alu_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  wygiecie_wzmocnienia okiennego ###################################################################
	echo '<td align="right">'.$wygiecie_wzmocnienia_okiennego_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_wzmocnienia_okiennego_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_wzmocnienia_okiennego_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_wzmocnienia_okiennego_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wygiecie_innego_elementu_ze_stali   ###################################################################
	echo '<td align="right">'.$wygiecie_innego_ilosc_szt[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_ilosc_m[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_cena[$x].'</td>';
	echo '<td align="right">'.$wygiecie_innego_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  Zgrzanie	     ###################################################################
	echo '<td align="right">'.$zgrzanie_ilosc[$x].'</td>';
	echo '<td align="right">'.$zgrzanie_cena[$x].'</td>';
	echo '<td align="right">'.$zgrzanie_wartosc[$x].' '.$waluta.'</td>';
	//   #######################################################################  Wyfrezowanie odwodnienia   ###################################################################
	echo '<td align="right">'.$wyfrezowanie_odwodnienia_ilosc[$x].'</td>';
	echo '<td align="right">'.$wyfrezowanie_odwodnienia_cena[$x].'</td>';
	echo '<td align="right">'.$wyfrezowanie_odwodnienia_wartosc[$x].' '.$waluta.'</td>';

	// #######################################################################  Wstawienie słupka	stałego     ###################################################################
	echo '<td align="right">'.$wstawienie_slupka_ilosc[$x].'</td>';
	echo '<td align="right">'.$wstawienie_slupka_cena[$x].'</td>';
	echo '<td align="right">'.$wstawienie_slupka_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  Wstawienie słupka	ruchomego     ###################################################################
	echo '<td align="right">'.$wstawienie_slupka_ruchomego_ilosc[$x].'</td>';
	echo '<td align="right">'.$wstawienie_slupka_ruchomego_cena[$x].'</td>';
	echo '<td align="right">'.$wstawienie_slupka_ruchomego_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  Docięcie listwy przyszybowej	   ###################################################################
	echo '<td align="right">'.$listwa_przyszybowa_ilosc[$x].'</td>';
	echo '<td align="right">'.$listwa_przyszybowa_cena[$x].'</td>';
	echo '<td align="right">'.$listwa_przyszybowa_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  Docięcie kompletu listwy przyszybowej	   ###################################################################
	echo '<td align="right">'.$dociecie_kompletu_listew_przyszybowych_ilosc[$x].'</td>';
	echo '<td align="right">'.$dociecie_kompletu_listew_przyszybowych_cena[$x].'</td>';
	echo '<td align="right">'.$dociecie_kompletu_listew_przyszybowych_wartosc[$x].' '.$waluta.'</td>';

	// #######################################################################  okucie	     ###################################################################
	echo '<td align="right">'.$okucie_ilosc[$x].'</td>';
	echo '<td align="right">'.$okucie_cena[$x].'</td>';
	echo '<td align="right">'.$okucie_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  zaszklenie	     ###################################################################
	echo '<td align="right">'.$zaszklenie_ilosc[$x].'</td>';
	echo '<td align="right">'.$zaszklenie_cena[$x].'</td>';
	echo '<td align="right">'.$zaszklenie_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wykonanie_innej_uslugi	     ###################################################################
	echo '<td align="right">'.$innej_uslugi_ilosc[$x].'</td>';
	echo '<td align="right">'.$innej_uslugi_cena[$x].'</td>';
	echo '<td align="right">'.$innej_uslugi_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  oscieznica	     ###################################################################
	echo '<td align="right">'.$oscieznica_ilosc[$x].'</td>';
	echo '<td align="right">'.$oscieznica_cena[$x].'</td>';
	echo '<td align="right">'.$oscieznica_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  skrzydlo	     ###################################################################
	echo '<td align="right">'.$skrzydlo_ilosc[$x].'</td>';
	echo '<td align="right">'.$skrzydlo_cena[$x].'</td>';
	echo '<td align="right">'.$skrzydlo_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  listwa	     ###################################################################
	echo '<td align="right">'.$listwa_ilosc[$x].'</td>';
	echo '<td align="right">'.$listwa_cena[$x].'</td>';
	echo '<td align="right">'.$listwa_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  slupek	     ###################################################################
	echo '<td align="right">'.$slupek_ilosc[$x].'</td>';
	echo '<td align="right">'.$slupek_cena[$x].'</td>';
	echo '<td align="right">'.$slupek_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wzmocnienie_do_ramy	     ###################################################################
	echo '<td align="right">'.$wzmocnienie_ramy_ilosc[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_ramy_cena[$x].'</td>';
	echo '<td align="right"> '.$wzmocnienie_ramy_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wzmocnienie_do_skrzydla	     ###################################################################
	echo '<td align="right">'.$wzmocnienie_skrzydla_ilosc[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_skrzydla_cena[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_skrzydla_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wzmocnienie_do_slupka	     ###################################################################
	echo '<td align="right">'.$wzmocnienie_slupka_ilosc[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_slupka_cena[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_slupka_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  wzmocnienie_do_luku	     ###################################################################
	echo '<td align="right">'.$wzmocnienie_luku_ilosc[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_luku_cena[$x].'</td>';
	echo '<td align="right">'.$wzmocnienie_luku_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  okucia	     ###################################################################
	echo '<td align="right">'.$okucia_ilosc[$x].'</td>';
	echo '<td align="right">'.$okucia_cena[$x].'</td>';
	echo '<td align="right"> '.$okucia_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  szyby	     ###################################################################
	echo '<td align="right">'.$szyby_ilosc[$x].'</td>';
	echo '<td align="right">'.$szyby_cena[$x].'</td>';
	echo '<td align="right">'.$szyby_wartosc[$x].' '.$waluta.'</td>';
	// #######################################################################  inny_element	     ###################################################################
	echo '<td align="right">'.$inny_element_ilosc[$x].'</td>';
	echo '<td align="right">'.$inny_element_cena[$x].'</td>';
	echo '<td align="right">'.$inny_element_wartosc[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$okna[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$drzwi_wewnetrzne[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$drzwi_zewnetrzne[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$bramy[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$parapety[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$rolety_zewnetrzne[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$rolety_wewnetrzne[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$moskitiery[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$montaz[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$odpady_pvc[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$odpady_alu_stal[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$transport[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$inne[$x].' '.$waluta.'</td>';
	echo '<td align="left">'.$nazwa_produktu[$x].'</td>';
	echo '<td align="right">'.$cena_netto_za_sztuke[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$ilosc_sztuk[$x].'</td>';
	echo '<td align="center">'.$wartosc_netto[$x].' '.$waluta.'</td>';
	echo '<td align="center">'.$vat_baza[$x].'</td>';
	echo '<td align="center">'.$wartosc_brutto[$x].' '.$waluta.'</td>';
	echo '<td align="right">'.$nr_faktury[$x].'</td>';
	echo '<td align="right">'.$data_faktury[$x].'</td>';
	echo '<td align="center"></td></tr>';

?>