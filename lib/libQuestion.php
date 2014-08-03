<?php


Class libQuestion 
{
	const POINT_PER_ONE_QUESTION = 20;

	private $aOriginalAnswers = null;

	public function __construct() 
	{
		$this->setOriginalnswers();
	}

	private function setOriginalnswers()
	{
		$this->aOriginalAnswers = array(
			 'quiz1_answer' => 'option3'
			,'quiz2_answer' => 'option1'
			,'quiz3_answer' => 'option1'
			,'quiz4_answer' => 'option2'
			,'quiz5_answer' => 'option3'
		);
	}

	private function getOriginalAnswers()
	{
		return $this->aOriginalAnswers;
	}

	public function checkAnswer($aInputAnswer) 
	{
		$aOriginalAnswers = $this->getOriginalAnswers();
		$aCorrect = array();

		foreach ($aOriginalAnswers as $sQuestion => $aAnswer) {

			if ($aInputAnswer[$sQuestion] == $aAnswer) {
				$aCorrect[] = $sQuestion;
			}
		}


		return $aCorrect;
	}

	public function getPointFromCheckedAnswer($aCheckedAnswer)
	{
		$iCorrectAnswerCount = count($aCheckedAnswer);

		return $iCorrectAnswerCount * self::POINT_PER_ONE_QUESTION;
	}
	
}



?>