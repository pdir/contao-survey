<?php

declare(strict_types=1);

/*
 * @copyright  Helmut Schottmüller 2005-2018 <http://github.com/hschottm>
 * @author     Helmut Schottmüller (hschottm)
 * @package    contao-survey
 * @license    LGPL-3.0+, CC-BY-NC-3.0
 * @see	       https://github.com/hschottm/survey_ce
 *
 * forked by pdir
 * @author     Mathias Arzberger <develop@pdir.de>
 * @link       https://github.com/pdir/contao-survey
 */

$GLOBALS['TL_LANG']['tl_survey_page']['title'] = ['Titel', 'Bitte geben Sie den Titel der Seite ein.'];
$GLOBALS['TL_LANG']['tl_survey_page']['description'] = ['Beschreibung', 'Bitte geben Sie eine Beschreibung der Seite ein.'];
$GLOBALS['TL_LANG']['tl_survey_page']['tstamp'] = ['Zuletzt geändert', 'Datum und Uhrzeit der letzten Änderung der Seite.'];
$GLOBALS['TL_LANG']['tl_survey_page']['introduction'] = ['Einleitender Text', 'Bitte geben Sie einen einleitenden Text für die Seite ein. Der Text erscheint am Anfang der Seite vor der ersten Frage.'];
$GLOBALS['TL_LANG']['tl_survey_page']['page_template'] = ['Seitentemplate', 'Hier können Sie ein Seitentemplate auswählen.'];
$GLOBALS['TL_LANG']['tl_survey_page']['conditions'] = ['Sprungbedingungen', 'Wenn Sie nicht mit der nächsten Seite fortfahren wollen, können Sie hier Sprungbedingungen definieren, um mit einer anderen Seite fortzufahren.'];

$GLOBALS['TL_LANG']['tl_survey_page']['new'] = ['Neue Seite', 'Eine neue Seite anlegen'];
$GLOBALS['TL_LANG']['tl_survey_page']['show'] = ['Seitendetails', 'Details der Seite ID %s anzeigen'];
$GLOBALS['TL_LANG']['tl_survey_page']['cut'] = ['Seite verschieben', 'Seite ID %s verschieben'];
$GLOBALS['TL_LANG']['tl_survey_page']['edit'] = ['Seite bearbeiten', 'Seite ID %s bearbeiten'];
$GLOBALS['TL_LANG']['tl_survey_page']['copy'] = ['Seite duplizieren', 'Seite ID %s duplizieren'];
$GLOBALS['TL_LANG']['tl_survey_page']['delete'] = ['Seite löschen', 'Seite ID %s löschen'];

$GLOBALS['TL_LANG']['tl_survey_page']['page'] = 'Seite';
$GLOBALS['TL_LANG']['tl_survey_page']['type'] = ['Seitentyp', 'Bitte wählen Sie den Typ der Seite.'];
$GLOBALS['TL_LANG']['tl_survey_page']['useCustomNextButtonTitle'] = ['"Weiter"-Text anpassen', 'Wählen Sie diese Option, um der "Weiter"-Schaltfläche der vorrigen Seite einen benutzerdefinierten Text zuzuweisen.'];
$GLOBALS['TL_LANG']['tl_survey_page']['customNextButtonTitle'] = ['"Weiter"-Text', 'Geben Sie einen Text für die "Weiter"-Schaltfläche der vorrigen Seite an.'];
$GLOBALS['TL_LANG']['tl_survey_page']['hideBackButton'] = ['"Zurück" ausblenden', 'Wählen Sie diese Option, um die "Zurück"-Schaltfläche auf dieser Seite auszublenden.'];
$GLOBALS['TL_LANG']['tl_survey_page']['markSurveyAsFinished'] = ['Umfrage als beendet markieren', 'Wählen Sie diese Option, um die Umfrage beim erreichen dieser Seite als beendet zu markieren.'];
/*
 * Legends
 */
$GLOBALS['TL_LANG']['tl_survey_page']['type_legend'] = 'Seitentyp';
$GLOBALS['TL_LANG']['tl_survey_page']['title_legend'] = 'Titel und Beschreibung';
$GLOBALS['TL_LANG']['tl_survey_page']['intro_legend'] = 'Einleitender Text';
$GLOBALS['TL_LANG']['tl_survey_page']['condition_legend'] = 'Sprungbedingungen';
$GLOBALS['TL_LANG']['tl_survey_page']['template_legend'] = 'Template-Einstellungen';
$GLOBALS['TL_LANG']['tl_survey_page']['config_legend'] = 'Konfiguration';
/*
 * Page types
 */
$GLOBALS['TL_LANG']['tl_survey_page']['type']['default'] = 'Fragenseite';
$GLOBALS['TL_LANG']['tl_survey_page']['type']['result'] = 'Ergebnisseite';
