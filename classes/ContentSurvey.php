<?php

/**
 * @copyright  Helmut Schottmüller 2009-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    survey_ce
 * @license    LGPL
 * @filesource
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;

/**
 * Class ContentSurvey
 *
 * @copyright  Helmut Schottmüller 2009-2010
 * @author     Helmut Schottmüller <contao@aurealis.de>
 * @package    Controller
 */
class ContentSurvey extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_survey';
	protected $objSurvey = null;
	protected $questionblock_template = 'survey_questionblock';
	protected $pin;
	private $questionpositions;


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### SURVEY ###';

			return $objTemplate->parse();
		}

		$this->strTemplate = (strlen($this->surveyTpl)) ? $this->surveyTpl : $this->strTemplate;
		return parent::generate();
	}
	
	/**
	 * Create an array of widgets containing the questions on a given survey page
	 *
	 * @param array
	 * @param boolean
	 */
	protected function createSurveyPage($pagerow, $pagenumber, $validate = true, $goback = false)
	{
		$this->questionpositions = array();
		if (!strlen($this->pin)) $this->pin = \Input::post('pin');
		$surveypage = array();
		$pagequestioncounter = 1;
		$doNotSubmit = false;

		$questions = $this->Database->prepare("SELECT * FROM tl_survey_question WHERE pid=? ORDER BY sorting")
			->execute($pagerow['id'])
			->fetchAllAssoc();

		foreach ($questions as $question)
		{
			$strClass = $GLOBALS['TL_SVY'][$question['questiontype']];
			// Continue if the class is not defined
			if (!$this->classFileExists($strClass))
			{
				continue;
			}

			$objWidget = new $strClass();
			$objWidget->surveydata = $question;
			$objWidget->absoluteNumber = $this->getQuestionPosition($question['id'], $this->objSurvey->id);
			$objWidget->pageQuestionNumber = $pagequestioncounter;
			$objWidget->pageNumber = $pagenumber;
			$objWidget->cssClass = ($question['cssClass'] != '' ? ' ' . $question['cssClass'] : '') . ($objWidget->absoluteNumber%2 == 0 ? ' odd' : ' even');
			array_push($surveypage, $objWidget);
			$pagequestioncounter++;
			
			if ($validate)
			{
				$objWidget->validate();
				if ($objWidget->hasErrors())
				{
					$doNotSubmit = true;
				}
			} else {
				// load existing values
				switch ($this->objSurvey->access)
				{
					case 'anon':
					case 'anoncode':
						$objResult = $this->Database->prepare("SELECT * FROM tl_survey_result WHERE (pid=? AND qid=? AND pin=?)")
							->execute($this->objSurvey->id, $objWidget->id, $this->pin);
						break;
					case 'nonanoncode':
						$objResult = $this->Database->prepare("SELECT * FROM tl_survey_result WHERE (pid=? AND qid=? AND uid=?)")
							->execute($this->objSurvey->id, $objWidget->id, $this->User->id);
						break;
				}
				if ($objResult->numRows)
				{
					$objWidget->value = deserialize($objResult->result);
				}
			}
		}
		if ($validate)
		{
			// HOOK: pass validated questions to callback functions
			if (isset($GLOBALS['TL_HOOKS']['surveyQuestionsValidated']) && is_array($GLOBALS['TL_HOOKS']['surveyQuestionsValidated']))
			{
				foreach ($GLOBALS['TL_HOOKS']['surveyQuestionsValidated'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($surveypage, $pagerow);
				}
			}
		}
		else
		{
			// HOOK: pass loaded questions to callback functions
			if (isset($GLOBALS['TL_HOOKS']['surveyQuestionsLoaded']) && is_array($GLOBALS['TL_HOOKS']['surveyQuestionsLoaded']))
			{
				foreach ($GLOBALS['TL_HOOKS']['surveyQuestionsLoaded'] as $callback)
				{
					$this->import($callback[0]);
					$this->$callback[0]->$callback[1]($surveypage, $pagerow);
				}
			}
		}

		if ($validate && \Input::post('FORM_SUBMIT') == 'tl_survey' && !strlen($this->pin))
		{
			if ($this->objSurvey->usecookie && strlen($_COOKIE['TLsvy_' . $this->objSurvey->id]))
			{
				// restore lost PIN from cookie
				$this->pin = $_COOKIE['TLsvy_' . $this->objSurvey->id];
			}
			else
			{
				// PIN got lost, restart
				global $objPage;
				$this->redirect($this->generateFrontendUrl($objPage->row()));
			}
		}

		// save survey values
		if ($validate && \Input::post('FORM_SUBMIT') == 'tl_survey' && (!$doNotSubmit || $goback))
		{
			if (!strlen($this->pin) || !$this->isValid($this->pin))
			{
				global $objPage;
				$this->redirect($this->generateFrontendUrl($objPage->row()));
			}
			foreach ($surveypage as $question)
			{
				switch ($this->objSurvey->access)
				{
					case 'anon':
					case 'anoncode':
						$objResult = $this->Database->prepare("DELETE FROM tl_survey_result WHERE pid=? AND qid=? AND pin=?")
							->execute($this->objSurvey->id, $question->id, $this->pin);
						$value = $question->value;
						if (is_array($question->value))
						{
							$value = serialize($question->value);
						}
						if (strlen($value))
						{
							$objResult = $this->Database->prepare("INSERT INTO tl_survey_result (tstamp, pid, qid, pin, result) VALUES (?, ?, ?, ?, ?)")
								->execute(time(), $this->objSurvey->id, $question->id, $this->pin, $value);
						}
						break;
					case 'nonanoncode':
						$objResult = $this->Database->prepare("DELETE FROM tl_survey_result WHERE pid=? AND qid=? AND uid=?")
							->execute($this->objSurvey->id, $question->id, $this->User->id);
						$value = $question->value;
						if (is_array($question->value))
						{
							$value = serialize($question->value);
						}
						if (strlen($value))
						{
							$objResult = $this->Database->prepare("INSERT INTO tl_survey_result (tstamp, pid, qid, pin, uid, result) VALUES (?, ?, ?, ?, ?, ?)")
								->execute(time(), $this->objSurvey->id, $question->id, $this->pin, $this->User->id, $value);
						}
						break;
				}
			}
			if (\Input::post('finish'))
			{
				// finish the survey
				switch ($this->objSurvey->access)
				{
					case 'anon':
					case 'anoncode':
						$objResult = $this->Database->prepare("UPDATE tl_survey_participant SET finished = ? WHERE pid = ? AND pin = ?")
							->execute('1', $this->objSurvey->id, $this->pin);
						break;
					case 'nonanoncode':
						$objResult = $this->Database->prepare("UPDATE tl_survey_participant SET finished = ? WHERE pid = ? AND uid = ?")
							->execute('1', $this->objSurvey->id, $this->User->id);
						break;
				}
				// HOOK: pass survey data to callback functions when survey is finished
				if (isset($GLOBALS['TL_HOOKS']['surveyFinished']) && is_array($GLOBALS['TL_HOOKS']['surveyFinished']))
				{
					foreach ($GLOBALS['TL_HOOKS']['surveyFinished'] as $callback)
					{
						$this->import($callback[0]);
						$this->$callback[0]->$callback[1]($this->objSurvey->row());
					}
				}
				if ($this->objSurvey->sendConfirmationMail)
				{
					$objMailProperties = new \stdClass();
					$objMailProperties->subject = '';
					$objMailProperties->sender = '';
					$objMailProperties->senderName = '';
					$objMailProperties->replyTo = '';
					$objMailProperties->recipients = array();
					$objMailProperties->messageText = '';
					$objMailProperties->messageHtml = '';
					$objMailProperties->attachments = array();
					$objMailProperties->skipEmptyFields = false;
					$objMailProperties->skipEmptyFields = ($this->objSurvey->confirmationMailSkipEmpty) ? true : false;

					// Set the sender as given in form configuration
					list($senderName, $sender) = \String::splitFriendlyEmail($this->objSurvey->confirmationMailSender);
					$objMailProperties->sender = $sender;
					$objMailProperties->senderName = $senderName;

					// Set the 'reply to' address, if given in form configuration
					if (!empty($this->objSurvey->confirmationMailReplyto))
					{
						list($replyToName, $replyTo) = \String::splitFriendlyEmail($this->objSurvey->confirmationMailReplyto);
						$objMailProperties->replyTo = (strlen($replyToName) ? $replyToName . ' <' . $replyTo . '>' : $replyTo);
					}

					// Set recipient(s)
					if (strlen($this->objSurvey->confirmationMailRecipientField))
					{
						$res = $this->Database->prepare("SELECT * FROM tl_survey_result WHERE (qid=? AND pin=?)")
								->execute($this->objSurvey->confirmationMailRecipientField, $this->pin)
								->fetchAssoc();
						if (strlen($res['result']))
						{
							$arrRecipient = trimsplit(',', $res['result']);
						}
					}
					
					if (!empty($this->objSurvey->confirmationMailRecipient))
					{
						$varRecipient = $this->objSurvey->confirmationMailRecipient;
						$arrRecipient = array_merge($arrRecipient, trimsplit(',', $varRecipient));
					}
					$arrRecipient = array_filter(array_unique($arrRecipient));

					if (!empty($arrRecipient))
					{
						foreach ($arrRecipient as $kR => $recipient)
						{
							list($recipientName, $recipient) = \String::splitFriendlyEmail($this->replaceInsertTags($recipient, false));
							$arrRecipient[$kR] = (strlen($recipientName) ? $recipientName . ' <' . $recipient . '>' : $recipient);
						}
					}
					$objMailProperties->recipients = $arrRecipient;

					// Check if we want custom attachments... (Thanks to Torben Schwellnus)
					if ($this->objSurvey->addConfirmationMailAttachments)
					{
						if($this->objSurvey->confirmationMailAttachments)
						{
							$arrCustomAttachments = deserialize($this->objSurvey->confirmationMailAttachments, true);

							if (!empty($arrCustomAttachments))
							{
								foreach ($arrCustomAttachments as $varFile)
								{
									$objFileModel = \FilesModel::findById($varFile);

									if ($objFileModel !== null)
									{
										$objFile = new \File($objFileModel->path);
										if ($objFile->size)
										{
											$objMailProperties->attachments[TL_ROOT .'/' . $objFile->path] = array
											(
												'file' => TL_ROOT . '/' . $objFile->path,
												'name' => $objFile->basename,
												'mime' => $objFile->mime);
										}
									}
								}
							}
						}
					}

					$objMailProperties->subject = \String::decodeEntities($this->objSurvey->confirmationMailSubject);
					$objMailProperties->messageText = \String::decodeEntities($this->objSurvey->confirmationMailText);
					
					$messageHtmlTmpl = '';
					if (\Validator::isUuid($this->objSurvey->confirmationMailTemplate) || (is_numeric($this->objSurvey->confirmationMailTemplate) && $this->objSurvey->confirmationMailTemplate > 0))
					{
						$objFileModel = \FilesModel::findById($this->objSurvey->confirmationMailTemplate);
						if ($objFileModel !== null)
						{
							$messageHtmlTmpl = $objFileModel->path;
						}
					}
					if ($messageHtmlTmpl != '')
					{
						$fileTemplate = new \File($messageHtmlTmpl);
						if ($fileTemplate->mime == 'text/html')
						{
							$messageHtml = $fileTemplate->getContent();
							$objMailProperties->messageHtml = $messageHtml;
						}
					}
					// Replace Insert tags and conditional tags
					//$objMailProperties = $this->Formdata->prepareMailData($objMailProperties, $arrSubmitted, $arrFiles, $arrForm, $arrFormFields);

					// Send Mail
					$blnConfirmationSent = false;

					if (!empty($objMailProperties->recipients))
					{
						$objMail = new \Email();
						$objMail->from = $objMailProperties->sender;

						if (!empty($objMailProperties->senderName))
						{
							$objMail->fromName = $objMailProperties->senderName;
						}

						if (!empty($objMailProperties->replyTo))
						{
							$objMail->replyTo($objMailProperties->replyTo);
						}

						$helper = new \SurveyHelper();
						$replacements = array("#Bezahlt#" => $this->getTotalToPay());
						$objMail->subject = $objMailProperties->subject;

						if (!empty($objMailProperties->attachments))
						{
							foreach ($objMailProperties->attachments as $strFile => $varParams)
							{
								$strContent = file_get_contents($varParams['file'], false);
								$objMail->attachFileFromString($strContent, $varParams['name'], $varParams['mime']);
							}
						}

						if (!empty($objMailProperties->messageText))
						{
							$objMail->text = $helper->replaceTags($objMailProperties->messageText, $this->pin, $replacements);
						}

						if (!empty($objMailProperties->messageHtml))
						{
							$objMail->html = $helper->replaceTags($objMailProperties->messageHtml, $this->pin, $replacements, true);
						}

						foreach ($objMailProperties->recipients as $recipient)
						{
							$objMail->sendTo($recipient);
							$blnConfirmationSent = true;
						}
					}

					if ($blnConfirmationSent && isset($intNewId) && intval($intNewId) > 0)
					{
						//$arrUpd = array('confirmationSent' => '1', 'confirmationDate' => $timeNow);
						//$res = \Database::getInstance()->prepare("UPDATE tl_formdata %s WHERE id=?")
						//	->set($arrUpd)
						//	->execute($intNewId);
					}
				}
				if ($this->objSurvey->jumpto)
				{
					$pagedata = $this->Database->prepare("SELECT * FROM tl_page WHERE id = ?")->execute($this->objSurvey->jumpto)->fetchAssoc();
					$this->redirect($this->generateFrontendUrl($pagedata));
				}
			}
		}
		return (($doNotSubmit || !$validate) && !$goback) ? $surveypage : array();
	}

	protected function getResultForQuestion($question_id, $survey_id)
	{
		$objResult = $this->Database->prepare("SELECT * FROM tl_survey_result WHERE (pid=? AND qid=? AND pin=?)")
				->execute($survey_id, $question_id, $this->pin);
		if ($objResult->numRows)
		{
			return deserialize($objResult->result);
		}
		else
		{
			return null;
		}
	}

	protected function getQuestionPosition($question_id, $survey_id)
	{
		if ($question_id > 0 && $survey_id > 0)
		{
			if (!count($this->questionpositions))
			{
				$execute = (method_exists($this->Database, 'executeUncached')) ? 'executeUncached' : 'execute';
				$this->questionpositions = $this->Database->prepare("SELECT tl_survey_question.id FROM tl_survey_question, tl_survey_page WHERE tl_survey_question.pid = tl_survey_page.id AND tl_survey_page.pid = ? ORDER BY tl_survey_page.sorting, tl_survey_question.sorting")
					->$execute($survey_id)
					->fetchEach('id');
			}
			return array_search($question_id, $this->questionpositions) + 1;
		}
		else
		{
			return 0;
		}
	}

/**
 * Check if the active participant is still valid (maybe participant data was deleted by the survey administrator)
 *
 * @return boolean
 **/
	protected function isValid($pin)
	{
		if (strlen($pin) == 0) return false;
		$arrData = $this->Database->prepare("SELECT * FROM tl_survey_participant WHERE pin = ? AND pid = ?")
			->execute($pin, $this->objSurvey->id)
			->fetchEach('id');
		return (is_array($arrData) && count($arrData) == 1);
	}

	protected function outIntroductionPage()
	{
		switch ($this->objSurvey->access)
		{
			case 'anon':
				$status = "";
				if ($this->objSurvey->usecookie)
				{
					$status = $this->svy->getSurveyStatus($this->objSurvey->id, $_COOKIE['TLsvy_' . $this->objSurvey->id]);
				}
				if (strcmp($status, "finished") == 0)
				{
					$this->Template->errorMsg = $GLOBALS['TL_LANG']['ERR']['survey_already_finished'];
					$this->Template->hideStartButtons = true;
				}
				break;
			case 'anoncode':
				$this->loadLanguageFile("tl_content");
				$this->Template->needsTAN = true;
				$this->Template->txtTANInputDesc = $GLOBALS['TL_LANG']['tl_content']['enter_tan_to_start_desc'];
				$this->Template->txtTANInput = $GLOBALS['TL_LANG']['tl_content']['enter_tan_to_start'];
				if (strlen(\Input::get('code')))
				{
					$this->Template->tancode = \Input::get('code');
				}
				break;
			case 'nonanoncode':
				if (!$this->User->id)
				{
					$this->Template->errorMsg = $GLOBALS['TL_LANG']['ERR']['survey_no_member'];
					$this->Template->hideStartButtons = true;
				}
				else if ($this->objSurvey->limit_groups)
				{
					if (!$this->svy->isUserAllowedToTakeSurvey($this->objSurvey))
					{
						$this->Template->errorMsg = $GLOBALS['TL_LANG']['ERR']['survey_no_allowed_member'];
						$this->Template->hideStartButtons = true;
					}
				}
				else
				{
					$status = $this->svy->getSurveyStatusForMember($this->objSurvey->id, $this->User->id);
					if (strcmp($status, "finished") == 0)
					{
						$this->Template->errorMsg = $GLOBALS['TL_LANG']['ERR']['survey_already_finished'];
						$this->Template->hideStartButtons = true;
					}
				}
				break;
		}
	}
	
	/**
	 * Insert a new participant dataset
	 */
	protected function insertParticipant($pid, $pin, $uid = 0)
	{
		$objResult = $this->Database->prepare("INSERT INTO tl_survey_participant (tstamp, pid, pin, uid) VALUES (?, ?, ?, ?)")
			->execute(time(), $pid, $pin, $uid);
	}
	
	protected function getTotalToPay()
	{
		$res_1 = $this->getResultForQuestion(13, $this->objSurvey->id);
		$res_2 = $this->getResultForQuestion(14, $this->objSurvey->id);
		$day1 = 0;
		if ($res_1["value"] == 1)
		{
			$day1 = 200;
		}
		else if ($res_1["value"] == 2)
		{
			$day1 = 150;
		}
		else if ($res_1["value"] == 3)
		{
			$day1 = 0;
		}
		$day2 = 0;
		if ($res_2["value"] == 1)
		{
			$day2 = 150;
		}
		else if ($res_2["value"] == 2)
		{
			$day2 = 0;
		}
		$total = "";
		if ($day1 > 0 && $day2 > 0)
		{
			if ($day1 == 200)
			{
				$total = "250,- EUR (Kombiticket Ärzte, Herz-Intensiv-Kurs und Bildgebung mit Herz)";
			}
			else
			{
				$total = "200,- EUR (Kombiticket RT, RT-Fortbildung und Bildgebung mit Herz)";
			}
		}
		else
		{
			if ($day1 == 200)
			{
				$total = "200,- EUR (CBCT)";
			}
			else if ($day1 == 150)
			{
				$total = "150,- EUR (RT-Fortbildung)";
			}
			else if ($day2 == 150)
			{
				$total = "150,- EUR (Bildgebung mit Herz)";
			}
		}
		return $total;
	}
	
	/**
	 * Generate module
	 */
	protected function compile()
	{
		if (TL_MODE == 'FE' && !BE_USER_LOGGED_IN && ($this->invisible || ($this->start > 0 && $this->start > time()) || ($this->stop > 0 && $this->stop < time())))
		{
			return '';
		}

		// Get front end user object
		$this->import('FrontendUser', 'User');

		// add survey javascript
		if (is_array($GLOBALS['TL_JAVASCRIPT']))
		{
			array_insert($GLOBALS['TL_JAVASCRIPT'], 1, 'system/modules/survey_ce/assets/survey.js');
		}
		else
		{
			$GLOBALS['TL_JAVASCRIPT'] = array('system/modules/survey_ce/assets/survey.js');
		}

		$surveyID = (strlen(\Input::post('survey'))) ? \Input::post('survey') : $this->survey;
		$this->objSurvey = $this->Database->prepare("SELECT * FROM tl_survey WHERE id=?")
			->execute($surveyID);
		$this->objSurvey->next();
		$this->import('Survey', 'svy');

		// check date activation
		if ((strlen($this->objSurvey->online_start)) && ($this->objSurvey->online_start > time())) {
			$this->Template->protected = true;
			return;
		}
		if ((strlen($this->objSurvey->online_end)) && ($this->objSurvey->online_end < time())) {
			$this->Template->protected = true;
			return;
		}
		
		$pages = $this->Database->prepare("SELECT * FROM tl_survey_page WHERE pid=? ORDER BY sorting")
			->execute($surveyID)
			->fetchAllAssoc();
		$page = (\Input::post('page')) ? \Input::post('page') : 0;
		// introduction page / status
		if ($page == 0)
		{
			$this->outIntroductionPage();
		}
		
		// check survey start
		if (\Input::post('start') || ($this->objSurvey->immediate_start == 1 && !\Input::post('FORM_SUBMIT')))
		{
			$page = 0;
			switch ($this->objSurvey->access)
			{
				case 'anon':
					if (($this->objSurvey->usecookie) && strlen($_COOKIE['TLsvy_' . $this->objSurvey->id]) && $this->svy->checkPINTAN($this->objSurvey->id, $_COOKIE['TLsvy_' . $this->objSurvey->id]) !== false)
					{
						$page = $this->svy->getLastPageForPIN($this->objSurvey->id, $_COOKIE['TLsvy_' . $this->objSurvey->id]);
						$this->pin = $_COOKIE['TLsvy_' . $this->objSurvey->id];
					}
					else
					{
						$pintan = $this->svy->generatePIN_TAN();
						if ($this->objSurvey->usecookie) setcookie('TLsvy_' . $this->objSurvey->id, $pintan["PIN"], time()+3600*24*365, "/");
						$this->pin = $pintan["PIN"];
						// add pin/tan
						$objResult = $this->Database->prepare("INSERT INTO tl_survey_pin_tan (tstamp, pid, pin, tan, used) VALUES (?, ?, ?, ?, ?)")
							->execute(time(), $this->objSurvey->id, $pintan["PIN"], $pintan["TAN"], 1);
						$this->insertParticipant($this->objSurvey->id, $pintan["PIN"]);
						$page = 1;
					}
					break;
				case 'anoncode':
					$tan = \Input::post('tan');
					if ((strcmp(\Input::post('FORM_SUBMIT'), 'tl_survey_form') == 0) && (strlen($tan)))
					{
						$result = $this->svy->checkPINTAN($this->objSurvey->id, "", $tan);
						if ($result === false)
						{
							$this->Template->tanMsg = $GLOBALS['TL_LANG']['ERR']['survey_wrong_tan'];
						}
						else
						{
							$this->pin = $this->svy->getPINforTAN($this->objSurvey->id, $tan);
							if ($result == 0)
							{
								// activate the TAN
								$objResult = $this->Database->prepare("UPDATE tl_survey_pin_tan SET used = ? WHERE tan = ? AND pid = ?")
									->execute(1, $tan, $this->objSurvey->id);
								
								// set pin
								if ($this->objSurvey->usecookie) setcookie('TLsvy_' . $this->objSurvey->id, $this->pin, time()+3600*24*365, "/");
								$this->insertParticipant($this->objSurvey->id, $this->pin);
								$page = 1;
							}
							else
							{
								$status = $this->svy->getSurveyStatus($this->objSurvey->id, $this->pin);
								if (strcmp($status, "finished") == 0)
								{
									$this->Template->errorMsg = $GLOBALS['TL_LANG']['ERR']['survey_already_finished'];
									$this->Template->hideStartButtons = true;
								}
								else
								{
									$page = $this->svy->getLastPageForPIN($this->objSurvey->id, $this->pin);
								}
							}
						}
					}
					else
					{
						$this->Template->tanMsg = $GLOBALS['TL_LANG']['ERR']['survey_please_enter_tan'];
					}
					break;
				case 'nonanoncode':
					$participant = $this->Database->prepare("SELECT * FROM tl_survey_participant WHERE pid=? AND uid=?")
						->execute($this->objSurvey->id, $this->User->id)
						->fetchAssoc();
					if (!$participant["uid"])
					{
						$pintan = $this->svy->generatePIN_TAN();
						$this->pin = $pintan["PIN"];
						$this->insertParticipant($this->objSurvey->id, $pintan["PIN"], $this->User->id);
					}
					else
					{
						$this->pin = $participant["pin"];
					}
					$page = strlen($participant["lastpage"]) ? $participant["lastpage"] : 1;
					break;
			}
		}
		
		// check question input and save input or return a question list of the page
		$surveypage = array();
		if (($page > 0 && $page <= count($pages)))
		{
			if (\Input::post('FORM_SUBMIT') == 'tl_survey')
			{
				$goback = (strlen(\Input::post("prev"))) ? true : false;
				$surveypage = $this->createSurveyPage($pages[$page-1], $page, true, $goback);
			}
		}

		// submit successful, calculate next page and return a question list of the new page
		if (count($surveypage) == 0)
		{
			if (strlen(\Input::post("next"))) {
				$res = $this->getResultForQuestion(13, $this->objSurvey->id);
				if ($page == 2 && $res["value"] != 2)
				{
					$page++;
					$page++;
				}
				else
				{
					$page++;
				}
			}
			if (strlen(\Input::post("finish"))) $page++;
			if (strlen(\Input::post("prev"))) {
				$res = $this->getResultForQuestion(13, $this->objSurvey->id);
				if ($page == 4 && $res["value"] != 2)
				{
					$page--;
					$page--;
				}
				else
				{
					$page--;
				}
			}

			$surveypage = $this->createSurveyPage($pages[$page-1], $page, false);
		}

		// save position of last page (for resume)
		if ($page > 0)
		{
			$objResult = $this->Database->prepare("UPDATE tl_survey_participant SET lastpage = ? WHERE pid = ? AND pin = ?")
				->execute($page, $this->objSurvey->id, $this->pin);
			if (strlen($pages[$page-1]['page_template'])) $this->questionblock_template = $pages[$page-1]['page_template'];
		}
		
		$questionBlockTemplate = new FrontEndTemplate($this->questionblock_template);
		$questionBlockTemplate->surveypage = $surveypage;

		// template output
		$this->Template->pages = $pages;
		$this->Template->survey_id = $this->objSurvey->id;
		$this->Template->show_title = $this->objSurvey->show_title;
		$this->Template->show_cancel = ($page > 0 && count($surveypage)) ? $this->objSurvey->show_cancel : false;
		$this->Template->surveytitle = specialchars($this->objSurvey->title);
		$this->Template->cancel = specialchars($GLOBALS['TL_LANG']['MSC']['cancel_survey']);
		global $objPage;
		$this->Template->cancellink = $this->generateFrontendUrl($objPage->row());
		$this->Template->allowback = $this->objSurvey->allowback;
		$qb = $questionBlockTemplate->parse();
		$qb = str_replace("#Bezahlt#", $this->getTotalToPay(), $qb);
		$this->Template->questionblock = $qb;
		$this->Template->page = $page;
		$this->Template->introduction = $this->objSurvey->introduction;
		$this->Template->finalsubmission = ($this->objSurvey->finalsubmission) ? $this->objSurvey->finalsubmission : $GLOBALS['TL_LANG']['MSC']['survey_finalsubmission'];
		$formaction = \Environment::get('request');

		$this->Template->pageXofY = $GLOBALS['TL_LANG']['MSC']['page_x_of_y'];
		$this->Template->next = $GLOBALS['TL_LANG']['MSC']['survey_next'];
		$this->Template->prev = $GLOBALS['TL_LANG']['MSC']['survey_prev'];
		$this->Template->start = $GLOBALS['TL_LANG']['MSC']['survey_start'];
		$this->Template->finish = "Anmeldung durchführen";
		$this->Template->pin = $this->pin;
		$this->Template->action = ampersand($formaction);
	}
}

?>