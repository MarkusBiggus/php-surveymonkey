<?php
/**
 * Class for SurveyMonkey Responses defined from https://developer.surveymonkey.com/mashery/data_types
 * @package default
 */
class SurveyMonkey_Response {

    /**
     * @var text respondent ID
     */
	protected $_respondent_id;
    /**
     * @var array of question objects (those the respondent answered)
     */
	protected $_questions;

	public function __construct($survey =array()) {
          $this->_questions=array();
          foreach ($survey as $field => $value) {
            switch ($field) {
              case "respondent_id":
                 $this->_respondent_id = $value;
                 break;
              case "questions":
                  foreach ($value as $index => $question) {
                     $obj = new SurveyMonkey_ResponseQuestion ($question);
//                     echo $obj->formatHTML();  // show us what we got
                     $this->_questions[] = $obj;
                  }
                 break;
/*              default:
                 if (!is_array($value)) {
                    echo "unexpected response property: $field:$value<br>";
                 } else {
                    echo "unexpected response array: $field<br>";
                    print_r($value);
                 }
*/
            }
          }
        }

	public function getQuestions(){
        return $this->_questions;
	}
	/**
	 * Build display format HTML
	 * @return string of HTML ready for output
	 */
	public function formatHTML () {
            $HTML  = "<div>Respondent ID: ". $this->_respondent_id ."<br>";
            $HTML .= "</div>";
            return $HTML ;
	}

}


class SurveyMonkey_ResponseQuestion {

    /**
     * @var sring question ID
     */
	protected $_question_id;
    /**
     * @var array of answer objects (usually only one)
     */
	protected $_answers;

	public function __construct($question =array()) {
          $this->_answers=array();

          foreach ($question as $field => $value) {
            switch ($field) {
              case "question_id":
                 $this->_question_id = $value;
                 break;
              case "answers":
                  foreach ($value as $index => $answer) {
                     $obj = new SurveyMonkey_ResponseAnswer ($answer);
//                     echo $obj->formatHTML();  // show us what we got
                     $this->_answers[] = $obj;
                  }
                 break;
/*              default:
                 if (!is_array($value)) {
                    echo "unexpected question property: $field:$value<br>";
//                 } else {
//                    echo "unexpected question array: $field<br>";
//                    print_r($value);
                 }
*/
            }
          }
        }
	public function getAnswers(){
        return $this->_answers;
	}
	/**
	 * Build display format HTML
	 * @return string of HTML ready for output
	 */
	public function formatHTML () {
            $HTML  = "<div>Question ID:". $this->_question_id ."<br>";
            $HTML .= "</div>";
            return $HTML ;
        }
}

class SurveyMonkey_ResponseAnswer {

    /**
     * @var sring row type answer id
     */
	protected $_row;
    /**
     * @var sring col type answer id
     */
	protected $_col;
    /**
     * @var sring col_choice type answer id
     */
	protected $_col_choice;
    /**
     * @var sring text  answer 
     */
	protected $_text;

	public function __construct($answer =array()) {
          foreach ($answer as $field => $value) {
            switch ($field) {
              case "row":
                 $this->_row = $value;
                 break;
              case "col":
                 $this->_col = $value;
                 break;
              case "col_choice":
                 $this->_col_choice = $value;
                 break;
              case "text":
                 $this->_text = $value;
                 break;
/*              default:
                if (!is_array($value)) {
                   echo "unexpected answer property: $field:$value<br>";
                 } else {
                    echo "unexpected answer array: $field<br>";
                    print_r($value);
                 }
*/
            }
          }
        }
	/**
	 * Build display format HTML
	 * @return string of HTML ready for output
	 */
	public function formatHTML () {
            $HTML  = "<div>col: ". $this->_col ." choice: ". $this->_col_choice ."<br>"."<br>row: ". $this->_row ."<br>";
            $HTML .= "text: ". $this->_text ."<br>";
            $HTML .= "</div>";
            return $HTML ;
        }
}
?>
