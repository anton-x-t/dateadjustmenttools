<?php

/*
    This file is part of Moodle - http://moodle.org/
    
    Released under GNU General Public License version three (3), for further details,
    review the web page "https://www.gnu.org/licenses/gpl.html" or "license.txt".
	
	A tool for Date rollover and a tool for Individual date adjustment. Jesus lives!
	
	@package    local
	@subpackage dateadjustmenttools
	@copyright  2014 Tsedey Terefe   <snort.test123@gmail.com>
	@copyright  2015 Anton Thelander <anton.thelander@outlook.com>
	@license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die;

//Sometimes c stands for capitalized and s for space, p or par stands for parentheses.

$string['abbreviatedinstructions'] = 'Det här tillägget eller pluginen har utformats för att visa och individuellt ändra datum för kursstart, datum för inlämningsuppgifter och datum för quizzar med tillhörande kalenderhändelser. En annan del av det här tillägget har gjorts för att ändra alla tidigare nämnda datum för en kurs på en gång. I sektionen <b>"Inställningar"</b> kan alla andra sektioner <b>förutom</b> sektionen "Inställningar" ställas in för att visas eller döljas och expanderas eller minimeras. Sektionen "Inställningar" kan emellertid <b>expanderas</b> eller <b>minimeras</b>. Aktivera en sektion i en sektion genom att bocka i en kryssruta, mata in datum och genomför förändringar genom att klicka på "Spara förändringar.". <b>VARNING: Var försiktig vid användning av sektionen "Datummassförflyttning".</b>';
$string['allowsubmissionsfroml'] = 'inlämningar tillåtna från';
$string['allowsubmissionsfromu'] = 'Inlämningar tillåtna från';
$string['applychanges'] = 'Verkställ förändringar';
$string['assignmentdateadjustmentheader'] = 'Datumjustering för inlämningsuppgifter';
$string['assignmentdateadjustmentsectiondescription'] = 'Sektionen <b>"Datumjustering för inlämningsuppgifter"</b> visar nuvarande datum för inlämningsuppgifter, om åtminstone en inlämningsuppgift finns. I den här sektionen finns det <b>bara</b> möjlighet att ändra datum för Inlämningar tillåtna från, Stoppdatum och Avstängningsdatum med relaterade kalenderhändelser. Mata in datum på detta sätt: "ÅÅÅÅ-MM-DD HH:MM". Exempeldatum: "2021-08-03 17:37". Lämna ett aktiverat fält blankt eller ofullständigt för ta bort det datumet.';
$string['backtocoursehome'] = 'Gå tillbaka till den här kursens förstasida';
$string['closethequizl'] = 'stäng quizzen';
$string['closethequizu'] = 'Stäng quizzen';
$string['coursedatetableoverview'] = 'Tabellöversikt över datum för kursen';
$string['coursestart'] = 'kursstart';
$string['coursestartdate'] = 'Individuell datumjustering';
$string['coursestartdate_help'] = 'Datum för kursstart visas och kan ändras här. Datum för kursstart kan inte tas bort.';
$string['coursestartdatec'] = 'Datum för kursstart';
$string['coursestartdateadjustmentheader'] = 'Datumjustering för kursstart';
$string['coursestartdateadjustmentsectiondescription'] = 'Sektionen <b>"Datumjustering för kursstart"</b> visar nuvarande datum för kursstart. I den här sektionen finns det <b>bara</b> möjlighet att ändra datum för kursstart. Mata in datum på detta sätt: "ÅÅÅÅ-MM-DD". Exempeldatum: "2017-12-07". Lämna ett aktiverat fält blankt eller ofullständigt för ta bort det datumet.';
$string['cutoffdatel'] = 'avstängningsdatum';
$string['cutoffdateu'] = 'Avstängningsdatum';
$string['dateexample'] = 'Exempeldatum';
$string['dateindigits'] = '2017-12-07';
$string['dateindigitswithtime'] = '2021-08-03 17:37';
$string['dateoverviewheader'] = 'Datumöversikt';
$string['dateoverviewsectiondescription'] = 'Sektionen <b>"Datumöversikt"</b> visar nuvarande datum för kursstart, datum för inlämningsuppgifter och datum för quizzar, var och en i sin tabell. Ingenting kan ändras i denna sektion.';
$string['daterollover'] = 'Datummassförflyttning (Date rollover)';
$string['daterollover_help'] = 'Datum för kursstart visas här. Datum för kursstart, datum för inlämningsuppgifter och datum för quizzar med kalenderhändelser kan ändras här, alla på en gång. Verktyget Datummassförflyttning tar inte hänsyn till röda dagar och andra helgdagar. Vissa datum kan bli förflyttade en timme framåt eller bakåt om serverns tidszon tar hänsyn till sommartid och om en kurs går över omställningsdatum för sommartid och vintertid (en söndag, 25:e-31:a mars och en söndag, 25:e-31:a oktober i Europa). Var försiktig!';
$string['daterolloverheader'] = 'Datummassförflyttning';
$string['daterolloversectiondescription'] = 'Sektionen <b>"Datummassförflyttning"</b> visar nuvarande datum för kursstart. I den här sektionen finns det <b>bara</b> möjlighet att ändra datum för kursstart, datum för inlämningsuppgifter och datum för quizzar med tillhörande kalenderhändelser, alla på en gång. Alla tidigare nämnda datum blir förflyttade i förhållande till nuvarande datum för kursstart. Klicka i kryssrutan "Aktivera" och mata sedan in det nya datumet på det sätt webbläsaren visar det, klicka därefter på "Spara ändringar" för att verkställa förändringar.';
$string['daterollovertextwithvariable'] = '{$a} är det nuvarande startdatumet för kursen. Till vilket datum skulle du vilja ändra startdatumet för kursen?';
$string['daterollovertextwithvariableheader'] = 'Datummassförflyttning';
$string['daterollovertextwithvariableshort'] = 'Nytt startdatum ({$a}):';
$string['daterollovertextwithoutvariableshort'] = 'Nytt startdatum (YYYY-MM-DD):';
$string['daterollovertextwithoutvariableshort_help'] = 'Det nuvarande startdatumet för kursen är inom parenteserna. Alla datum som tillhör den här kursen kommer att justeras bakåt eller framåt i relation till det valda datumet. Var god och välj ett datum från och med i dag till och med 2030-12-31.';
$string['duedateu'] = 'Stoppdatum';
$string['duedatel'] = 'stoppdatum';
$string['emptydate'] = 'Datumfältet tomt. Var god försök igen. Tack!';
$string['enablechangesfor'] = 'Gör det möjligt att förändra';
$string['enablesettingchanges'] = 'Gör det möjligt att ändra inställningarna';
$string['enablethe'] = 'Visa';
$string['expand'] = 'Expandera';
$string['headerwhenaccessingthispage'] = '-sektionen vid sidåtkomst';
$string['individualdateadjustment'] = 'Individuell datumjustering';
$string['individualdateadjustment_help'] = 'Sätt ett datum till något datum i 1970 för att ta bort det. Om ett datum är satt i 1970, då existerar inte datumet och det är inte satt.';
$string['individualdateadjustmentheader'] = 'Individuell datumjustering';
$string['inputdateslikethis'] = 'Mata in datum på detta sätt';
$string['instructionsheader'] = 'Var god läs dessa instruktioner';
$string['instructionssectiondescription'] = 'Sektionen <b>"Var god läs dessa instruktioner"</b> är den här sektionen som innehåller direktiv om hur de andra sektionerna ska användas.';
$string['invaliddate'] = 'Ej giltigt datum. Var god försök igen. Tack!';
$string['leaveanactivatedfield'] = 'Lämna ett aktiverat fält blankt eller ofullständigt för datumborttagning.';
$string['name'] = 'Namn';
$string['newcoursestartdate'] = 'Nytt datum för kursstart';
$string['nopermission'] = 'Du har inte rätt behörigheter för att göra dessa förändringar.<br />Kontakta systemadministratören för det här Moodlesystemet ifall du tror att du kan erhålla dessa behörigheter.<br />Ha det bra!';
$string['nothingcanbechanged'] = 'Ingenting kan ändras under den här sektionen.';
$string['notaninteger'] = 'Ett datum blev inte inmatat som heltal. Var god försök igen. Tack!';
$string['notoolselectedp'] = '(Inget verktyg valt)';
$string['notset'] = 'Ej satt';
$string['openthequizl'] = 'öppna quizzen';
$string['openthequizu'] = 'Öppna quizzen';
$string['pastdate'] = 'Datumet har passerat. Var vänlig och välj ett datum från och med i dag till och med 2030-12-31. Tack!';
$string['pluginname'] = 'Datumjusteringsverktyg';
$string['pleaseselectadate'] = 'Var vänlig välj ett datum';
$string['quizclosespar'] = '(Quizzen stänger)';
$string['quizdateadjustmentheader'] = 'Datumjustering för quizzar';
$string['quizdateadjustmentsectiondescription'] = 'Sektionen <b>"Datumjustering för quizzar"</b> visar nuvarande datum för quizzar, om åtminstone en quiz finns. I den här sektionen finns det <b>bara</b> möjlighet att ändra datum för när en quiz blir tillgänlig och datum för när en quiz blir otillgänglig med associerade kalenderhändelser. Mata in datum på detta sätt: "ÅÅÅÅ-MM-DD HH:MM". Exempeldatum: "2019-02-01 07:06". Lämna ett aktiverat fält blankt eller ofullständigt för ta bort det datumet.';
$string['quizopenspar'] = '(Quizzen öppnar)';
$string['rollover'] = 'Massjustera alla datum i relation till det valda datumet.';
$string['sectionshows'] = '-sektionen visar';
$string['selecttool'] = 'Välj verktyg';
$string['selecttoolheader'] = 'Välj verktyg';
$string['settingsheader'] = 'Inställningar';
$string['settingssectiondescription'] = 'Sektionen <b>"Inställningar"</b> visar och erbjuder möjligheter att ändra om sektioner ska visas eller döljas och expanderas eller minimeras. Hursomhaver, sektionen "Inställningar" kan <b>inte</b> döljas men den kan minimeras. I sektionen "Inställningar", bocka i kryssrutan "Gör förändringar möjliga", bocka i eller bocka ur en annan kryssruta och klicka på "Spara förändingar." för att ändra vilka sektioner som ska visas eller döljas och expanderas eller minimeras.';
$string['tableadjustmentheader'] = 'Justera kursdatum med hjälp av tabell';
$string['thecurrentcoursestartdate'] = 'det nuvarande datumet för kursstart';
$string['tldrinstructions'] = 'tldr: Ett tillägg för att ändra datum. Klicka på "Spara ändringar." för att verkställa ändringar. Var god använd det här tillägget försiktigt.';
$string['underthissectionits'] = 'Under den här sektionen kan förändringar <b>bara</b> genomföras på';
$string['yyyymmddc'] = 'ÅÅÅÅ-MM-DD';
$string['yyyymmddhhmmc'] = 'ÅÅÅÅ-MM-DD HH:MM';