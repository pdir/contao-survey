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

$GLOBALS['TL_LANG']['tl_survey_question']['title']= ['Titel', 'Bitte geben Sie den Titel der Frage ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['alias']= ['Alias', 'Der Fragenalias ist eine eindeutige Referenz, die anstelle der numerischen Fragen-ID aufgerufen werden kann.'];
$GLOBALS['TL_LANG']['tl_survey_question']['author']= ['Autor', 'Bitte geben Sie den Namen des Autors ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['questiontype']= ['Fragentyp', 'Bitte wählen Sie den Fragentyp aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['description']= ['Beschreibung', 'Bitte geben Sie eine Beschreibung für die Frage ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['question']= ['Fragentext', 'Bitte geben Sie einen Fragentext ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['language']= ['Sprache', 'Bitte wählen Sie die Sprache der Frage.'];
$GLOBALS['TL_LANG']['tl_survey_question']['obligatory']= ['Verpflichtend', 'Wenn Sie diese Option wählen, muss die Frage in einer Umfrage beantwortet werden.'];
$GLOBALS['TL_LANG']['tl_survey_question']['help']= ['Hilfetext', 'Bitte geben Sie einen Hilfetext ein, der zusätzlich zum Fragentitel angezeigt werden soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['introduction']= ['Einleitung', 'Bitte geben Sie einen einleitenden Text ein, der zu Beginn der Seite angezeigt wird.'];
$GLOBALS['TL_LANG']['tl_survey_question']['lower_bound']= ['Wertebereich von', 'Bitte geben Sie die untere Schranke des Wertebereiches ein, wenn dieser überprüft werden soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['upper_bound']= ['Wertebereich bis', 'Bitte geben Sie die obere Schranke des Wertebereiches ein, wenn dieser überprüft werden soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['choices']= ['Antworten', 'Benutzen Sie die Schaltflächen, um Antworten zu kopieren, zu verschieben oder zu löschen. Wenn Sie ohne JavaScript-Unterstützung arbeiten, sollten Sie Ihre Eingaben speichern bevor Sie die Struktur der Antworten verändern!'];
$GLOBALS['TL_LANG']['tl_survey_question']['choices_'] = ['choice' => ['Antwort'],'category' => ['Kategorie']];
$GLOBALS['TL_LANG']['tl_survey_question']['hidetitle']= ['Fragentitel nicht anzeigen', 'Zeigt den Titel der Frage während der Umfrage nicht an.'];
$GLOBALS['TL_LANG']['tl_survey_question']['addother']= ['Andere Antwort erlauben', 'Wenn Sie diese Option wählen, wird als letzte Antwortoption ein Textfeld für eine freie Antwort angeboten.'];
$GLOBALS['TL_LANG']['tl_survey_question']['addscale']= ['Vordefinierte Skala hinzufügen', 'Wählen Sie eine Skala aus einer Liste von vordefinierten Skalen aus und fügen Sie diese Ihrer Frage hinzu.'];
$GLOBALS['TL_LANG']['tl_survey_question']['mc_style']= ['Darstellung der Antworten', 'Bitte wählen Sie eine Darstellungsform für die Antworten der Frage aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['mc_style']['vertical'] = 'Vertikal (Antworten untereinander)';
$GLOBALS['TL_LANG']['tl_survey_question']['mc_style']['horizontal'] = 'Horizontal (Antworten nebeneinander)';
$GLOBALS['TL_LANG']['tl_survey_question']['mc_style']['select'] = 'Dropdown-Feld';
$GLOBALS['TL_LANG']['tl_survey_question']['othertitle']= ['Titel der anderen Antwort', 'Geben Sie einen Titel für die zusätzliche andere Antwort ein. Der Text wird vor dem Antwortfeld angezeigt.'];
$GLOBALS['TL_LANG']['tl_survey_question']['scale']= ['Skala', 'Wählen Sie eine Skala aus einer Liste der vordefinierten Skalen aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['save_add_scale'] = 'Skala hinzufügen';
$GLOBALS['TL_LANG']['tl_survey_question']['openended_subtype']= ['Untertyp', 'Bitte wählen Sie den Untertyp für die offene Frage aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_textbefore']= ['Beschriftung vor Textfeld', 'Bitte geben Sie eine Beschriftung ein, die vor dem Textfeld erscheinen soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_textafter']= ['Beschriftung nach Textfeld', 'Bitte geben Sie eine Beschriftung ein, die nach dem Textfeld erscheinen soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_textinside']= ['Vorbelegung', 'Bitte geben Sie einen Text ein, mit dem das Textfeld vorbelegt werden soll.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_rows']= ['Zeilen', 'Bitte geben Sie die Anzahl der Zeilen für das mehrzeilige Textfeld an.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_cols']= ['Spalten', 'Bitte geben Sie die Anzahl der Spalten für das mehrzeilige Textfeld an.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_width']= ['Breite', 'Bitte geben Sie die Breite des Textfeldes in Zeichen an.'];
$GLOBALS['TL_LANG']['tl_survey_question']['openended_maxlen']= ['Maximale Länge', 'Bitte geben Sie die maximale Anzahl von Zeichen für dieses Textfeld an, wenn Sie auf eine Eingabebeschränkung bestehen.'];
$GLOBALS['TL_LANG']['tl_survey_question']['multiplechoice_subtype']= ['Untertyp', 'Bitte wählen Sie den Untertyp für die Multiple Choice Frage aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['matrix_subtype']= ['Untertyp', 'Bitte wählen Sie den Untertyp für die Matrixfrage aus.'];
$GLOBALS['TL_LANG']['tl_survey_question']['matrixrows']= ['Zeilen', 'Benutzen Sie die Schaltflächen, um Zeilen zu kopieren, zu verschieben oder zu löschen. Wenn Sie ohne JavaScript-Unterstützung arbeiten, sollten Sie Ihre Eingaben speichern bevor Sie die Struktur der Zeilen verändern!'];
$GLOBALS['TL_LANG']['tl_survey_question']['matrixcolumns']= ['Spalten', 'Benutzen Sie die Schaltflächen, um Spalten zu kopieren, zu verschieben oder zu löschen. Wenn Sie ohne JavaScript-Unterstützung arbeiten, sollten Sie Ihre Eingaben speichern bevor Sie die Struktur der Spalten verändern!'];
$GLOBALS['TL_LANG']['tl_survey_question']['addneutralcolumn']= ['Neutrale Spalte erlauben', 'Wenn Sie diese Option wählen, wird als letzte Spalte eine neutrale Spalte (z.B. keine Angabe, weiß nicht etc.) angeboten.'];
$GLOBALS['TL_LANG']['tl_survey_question']['neutralcolumn']= ['Neutrale Spalte', 'Bitte geben Sie einen Text für die neutrale Spalte ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['addbipolar']= ['Entgegengesetzte Pole anzeigen', 'Wenn Sie diese Option wählen, können Sie entgegengesetzte Pole definieren, die in der Matrixfrage angezeigt werden.'];
$GLOBALS['TL_LANG']['tl_survey_question']['adjective1']= ['Linker Pol', 'Bitte geben Sie einen Text für den linken Pol ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['adjective2']= ['Rechter Pol', 'Bitte geben Sie einen Text für den rechten Pol ein.'];
$GLOBALS['TL_LANG']['tl_survey_question']['bipolarposition']= ['Position der Pole', 'Bitte wählen Sie aus, wo die entgegengesetzten Pole in der Matrixfrage angezeigt werden sollen.'];
$GLOBALS['TL_LANG']['tl_survey_question']['bipolarposition']['top'] = 'Über den Spaltenbezeichnern';
$GLOBALS['TL_LANG']['tl_survey_question']['bipolarposition']['aside'] = 'Links und rechts der Spalten';

$GLOBALS['TL_LANG']['tl_survey_question']['new']= ['Neue Frage', 'Eine neue Frage anlegen'];
$GLOBALS['TL_LANG']['tl_survey_question']['show']= ['Details', 'Details der Frage ID %s anzeigen'];
$GLOBALS['TL_LANG']['tl_survey_question']['edit']= ['Frage bearbeiten', 'Frage ID %s bearbeiten'];
$GLOBALS['TL_LANG']['tl_survey_question']['copy']= ['Frage duplizieren', 'Frage ID %s duplizieren'];
$GLOBALS['TL_LANG']['tl_survey_question']['cut']= ['Frage verschieben', 'Frage ID %s verschieben'];
$GLOBALS['TL_LANG']['tl_survey_question']['up']= ['Nach oben verschieben', 'Frage ID %s nach oben verschieben'];
$GLOBALS['TL_LANG']['tl_survey_question']['down']= ['Nach unten verschieben', 'Frage ID %s nach unten verschieben'];
$GLOBALS['TL_LANG']['tl_survey_question']['delete']= ['Frage löschen', 'Frage ID %s löschen'];
$GLOBALS['TL_LANG']['tl_survey_question']['details']= ['Detaillierte Statistik', 'Detaillierte Statistik der Frage ID %s anzeigen'];

$GLOBALS['TL_LANG']['tl_survey_question']['openended'] = 'Offene Frage';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_singleline'] = 'Einzeilig';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_multiline'] = 'Mehrzeilig';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_integer'] = 'Ganzzahl';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_float'] = 'Kommazahl';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_date'] = 'Datum';
$GLOBALS['TL_LANG']['tl_survey_question']['oe_time'] = 'Uhrzeit';
$GLOBALS['TL_LANG']['tl_survey_question']['multiplechoice'] = 'Multiple Choice Frage';
$GLOBALS['TL_LANG']['tl_survey_question']['mc_singleresponse'] = 'Einfachauswahl';
$GLOBALS['TL_LANG']['tl_survey_question']['mc_multipleresponse'] = 'Mehrfachauswahl';
$GLOBALS['TL_LANG']['tl_survey_question']['mc_dichotomous'] = 'Dichotom (Ja/Nein)';
$GLOBALS['TL_LANG']['tl_survey_question']['matrix'] = 'Matrixfrage';
$GLOBALS['TL_LANG']['tl_survey_question']['matrix_singleresponse'] = 'Eine Antwort pro Zeile (Einfachauswahl)';
$GLOBALS['TL_LANG']['tl_survey_question']['matrix_multipleresponse'] = 'Mehrere Antworten pro Zeile (Mehrfachauswahl)';
$GLOBALS['TL_LANG']['tl_survey_question']['constantsum'] = 'Feste Summe';
$GLOBALS['TL_LANG']['tl_survey_question']['sum']= ['Summe', 'Geben Sie einen Wert für die Summe an.'];
$GLOBALS['TL_LANG']['tl_survey_question']['sum']['exact'] = 'Die zu den Antworten eingetragenen Werte müssen in der Summe exakt dem unten angegebenen Wert entsprechen.';
$GLOBALS['TL_LANG']['tl_survey_question']['sum']['max'] = 'Die zu den Antworten eingetragenen Werte dürfen in der Summe den unten angegebenen Wert nicht überschreiten.';
$GLOBALS['TL_LANG']['tl_survey_question']['sumoption']= ['Berechnungsoption', 'Die zu den Antworten eingetragenen Werte müssen in der unten angegebenen Summe der ausgewählten Option entsprechen.'];
$GLOBALS['TL_LANG']['tl_survey_question']['inputfirst']= ['Eingabefelder vor den Antworten anzeigen', 'Wenn Sie diese Option wählen, werden die Eingabefelder vor dem Antworttext ausgegeben, anderenfall werden die Eingabefelder hinter dem Antworttext ausgegeben.'];

$GLOBALS['TL_LANG']['tl_survey_question']['answered'] = 'Beantwortet';
$GLOBALS['TL_LANG']['tl_survey_question']['skipped'] = 'Übersprungen';
$GLOBALS['TL_LANG']['tl_survey_question']['most_selected_value'] = 'Häufigste Auswahl';
$GLOBALS['TL_LANG']['tl_survey_question']['nr_of_selections'] = 'Anzahl der Auswahlen';
$GLOBALS['TL_LANG']['tl_survey_question']['median'] = 'Median';
$GLOBALS['TL_LANG']['tl_survey_question']['arithmeticmean'] = 'Arithmetisches Mittel';
$GLOBALS['TL_LANG']['tl_survey_question']['yes'] = 'Ja';
$GLOBALS['TL_LANG']['tl_survey_question']['no'] = 'Nein';

$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_new'] = 'Neue Antwort';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_copy'] = 'Antwort duplizieren';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_delete'] = 'Antwort löschen';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixrow_new'] = 'Neue Zeile';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixrow_copy'] = 'Zeile duplizieren';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixrow_delete'] = 'Zeile löschen';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixcolumn_new'] = 'Neue Spalte';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixcolumn_copy'] = 'Spalte duplizieren';
$GLOBALS['TL_LANG']['tl_survey_question']['buttontitle_matrixcolumn_delete'] = 'Spalte löschen';
$GLOBALS['TL_LANG']['tl_survey_question']['cssClass'] = ['CSS-Klasse', 'Hier können Sie eine oder mehrere CSS-Klassen eingeben.'];
$GLOBALS['TL_LANG']['tl_survey_question']['answers'] = 'Antworten';
/*
* Legends
*/
$GLOBALS['TL_LANG']['tl_survey_question']['title_legend'] = 'Titel und Fragentyp';
$GLOBALS['TL_LANG']['tl_survey_question']['question_legend'] = 'Fragentext';
$GLOBALS['TL_LANG']['tl_survey_question']['obligatory_legend'] = 'Pflichteingabe';
$GLOBALS['TL_LANG']['tl_survey_question']['specific_legend'] = 'Fragenspezifische Einstellungen';
$GLOBALS['TL_LANG']['tl_survey_question']['rows_legend'] = 'Matrixzeilen';
$GLOBALS['TL_LANG']['tl_survey_question']['columns_legend'] = 'Matrixspalten';
$GLOBALS['TL_LANG']['tl_survey_question']['bipolar_legend'] = 'Bipolare Attribute';
$GLOBALS['TL_LANG']['tl_survey_question']['sum_legend'] = 'Summenberechnung';
$GLOBALS['TL_LANG']['tl_survey_question']['expert_legend'] = 'Experten-Einstellungen';
