<?php
/**
 * Class for SurveyMonkey Survey Metadata defined from https://developer.surveymonkey.com/mashery/data_types
 * @package default
 */
class SurveyMonkey_Survey {

    /**
     * @var string date modified
     */
	protected $_date_modifed;
    /**
     * @var string date created
     */
	protected $_date_created;
    /**
     * @var int language ID
     */
	protected $_language_ID;
    /**
     * @var int question_count
     */
	protected $_question_count;
    /**
     * @var int response count
     */
	protected $_num_responses;
    /**
     * @var string title
     */
	protected $_title;
    /**
     * @var bool title enabled
     */
	protected $_title_enabled;
    /**
     * @var text nickname
     */
	protected $_nickname;
    /**
     * @var array of page objects
     */
	protected $_pages;

    /**
     * SurveyMonkey  Collector Types
     */
    public static $SM_COLLECTOR_TYPE = array(
                  "url",
                  "embedded",
                  "email",
                  "facebook",
                  "audience"
	);
    /**
     * SurveyMonkey Respondent Collection Modes
     */
    public static $SM_RESPONDENT_COLLECTION_MODE = array(
                  "normal",
                  "manual",
                  "survey_preview",
                  "edited"
	);

    /**
     * SurveyMonkey respondent status
     */
    public static $SM_RESPONDENT_STATUS = array(
                  "completed",
                  "partial"
	);

    /**
     * SurveyMonkey Language IDs code definitions
     */
    public static $SM_LANGUAGE_ID = array(
		0	=> "undefined",
		1	=> "English",
		2	=> "Chinese(Simplified)",
		3	=> "Chinese(Traditional)",
		4	=> "Danish",
		5	=> "Dutch",
		6	=> "Finnish",
		7	=> "French",
		8	=> "German",
		9	=> "Greek",
		10	=> "Italian",
		11	=> "Japanese",
		12	=> "Korean",
		13	=> "Malay",
		14	=> "Norwegian",
		15	=> "Polish",
		16	=> "Portuguese(Iberian)",
		17	=> "Portuguese(Brazilian)",
		18	=> "Russian",
		19	=> "Spanish",
		20	=> "Swedish",
		21	=> "Turkish",
		22	=> "Ukrainian",
		23	=> "Reverse",
		24	=> "Albanian",
		25	=> "Arabic",
		26	=> "Armenian",
		27	=> "Basque",
		28	=> "Bengali",
		29	=> "Bosnian",
		30	=> "Bulgarian",
		31	=> "Catalan",
		32	=> "Croatian",
		33	=> "Czech",
		34	=> "Estonian",
		35	=> "Filipino",
		36	=> "Georgian",
		37	=> "Hebrew",
		38	=> "Hindi",
		39	=> "Hungarian",
		40	=> "Icelandic",
		41	=> "Indonesian",
		42	=> "Irish",
		43	=> "Kurdish",
		44	=> "Latvian",
		45	=> "Lithuanian",
		46	=> "Macedonian",
		47	=> "Malayalam",
		48	=> "Persian",
		49	=> "Punjabi",
		50	=> "Romanian",
		51	=> "Serbian",
		52	=> "Slovak",
		53	=> "Slovenian",
		54	=> "Swahili",
		55	=> "Tamil",
		56	=> "Telugu",
		57	=> "Thai",
		58	=> "Vietnamese",
		59	=> "Welsh",
		60	=> "num60",
	);


	public function __construct($survey =array()) {
          $this->_pages=array();

          foreach ($survey as $field => $value) {
            switch ($field) {
              case "survey_id":
                 $this->_survey_id = $value;
                 break;
              case "title":
                 $this->_title = $value["text"];
                 $this->_title_enabled = ($value["enabled"]==1);
                 break;
              case "nickname":
                 $this->_nickname = $value;
                 break;
              case "date_modified":
                 $this->_date_modified = $value;
                 break;
              case "date_created":
                 $this->_date_created = $value;
                 break;
              case "language_id":
                 $this->_language_id = intval($value);
                 break;
              case "question_count":
                 $this->_question_count = intval($value);
                 break;
              case "num_responses":
                 $this->_num_responses = intval($value);
                 break;
              case "pages":
                  foreach ($value as $index => $page) {
                     $obj = new SurveyMonkey_SurveyPage ($page);
//                     echo $obj->formatHTML();  // show us what we got
                     $this->_pages[] = $obj;
                  }
                 break;
/*              default:
                 if (!is_array($value)) {
                    echo "unexpected survey property: $field:$value<br>";
                 } else {
                    echo "unexpected survey array: $field<br>";
                    print_r($value);
                 }
*/
            }
          }
        }

	public function getPages(){
        return $this->_pages;
	}
	/**
	 * Build display format HTML
	 * @return string of HTML ready for output
	 */
	public function formatHTML () {
            $HTML  = "<div>Survey ID: ". $this->_survey_id ."<br>";
            $HTML .= $this->_title ."<br>";
            $HTML .= $this->_nickname;
            $HTML .= "<table border=0; cellspacing=10 style='text-align:center;'><tr><thead><td>Created</td><td>Modified</td><td>#questions</td><td>#responses</td></tr><tr><td>";
            $HTML .= $this->_date_created ."</td><td>";
            $HTML .= $this->_date_modified ."</td><td>";
            $HTML .= $this->_question_count ."</td><td>";
            $HTML .= $this->_num_responses ."</td></tr>";
            $HTML .= "</table></div>";
            return $HTML ;
	}

}

class SurveyMonkey_SurveyPage {

    /**
     * @var sring page ID
     */
	protected $_page_id;
    /**
     * @var sring heading
     */
	protected $_heading;
    /**
     * @var sring subheading
     */
	protected $_sub_heading;
    /**
     * @var array of question objects
     */
	protected $_questions;

	public function __construct($page =array()) {
          $this->_questions=array();

          foreach ($page as $field => $value) {
            switch ($field) {
              case "page_id":
                 $this->_page_id = $value;
                 break;
              case "heading":
                 $this->_heading = $value;
                 break;
              case "sub_heading":
                 $this->_sub_heading = $value;
                 break;
              case "questions":
                  foreach ($value as $index => $question) {
                     $obj = new SurveyMonkey_SurveyQuestion ($question);
//                     echo $obj->formatHTML();  // show us what we got
                     $this->_questions[] = $obj;
                  }
                 break;
/*              default:
                 if (!is_array($value)) {
                    echo "unexpected page property: $field:$value<br>";
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
            $HTML  = "<div>Page ID:". $this->_page_id ."<br>";
            $HTML .= $this->_heading ."<br>";
            $HTML .= $this->_sub_heading;
            $HTML .= "</div>";
            return $HTML ;
	}
}

class SurveyMonkey_SurveyQuestion {

    /**
     * @var sring question ID
     */
	protected $_question_id;
    /**
     * @var int question subtype
     */
        const SM_SUBTYPE_VERTICAL = 1;
        const SM_SUBTYPE_VERTICAL_TWO_COL = 2;
        const SM_SUBTYPE_VERTICAL_THREE_COL = 3;
        const SM_SUBTYPE_HORIZ = 4;
        const SM_SUBTYPE_SINGLE = 5;
        const SM_SUBTYPE_MULTI = 6;
        const SM_SUBTYPE_RATING = 7;
        const SM_SUBTYPE_RANKING = 8;
        const SM_SUBTYPE_NUMERICAL = 9;
        const SM_SUBTYPE_ESSAY = 10;
        const SM_SUBTYPE_US = 12;
        const SM_SUBTYPE_INTERNATIONAL = 13;
        const SM_SUBTYPE_DATE_ONLY = 14;
        const SM_SUBTYPE_TIME_ONLY = 15;
        const SM_SUBTYPE_BOTH = 16;
        const SM_SUBTYPE_IMAGE = 17;
        const SM_SUBTYPE_VIDEO = 18;
        const SM_SUBTYPE_DESCRIPTIVE_TEXT = 19;

	protected $_subtype;
    /**
     * @var int question family
     */
        const SM_FAMILY_SINGLE_CHOICE = 1;
        const SM_FAMILY_MULTIPLE_CHOICE = 2;
        const SM_FAMILY_MATRIX = 3;
        const SM_FAMILY_OPEN_ENDED = 4;
        const SM_FAMILY_DEMOGRAPGIC = 5;
        const SM_FAMILY_DATETIME = 6;
        const SM_FAMILY_PRESENTATION = 7;

	protected $_family;
    /**
     * @var sring heading
     */
	protected $_heading;
    /**
     * @var int position
     */
	protected $_position;
    /**
     * @var array of answer objects
     */
	protected $_answers;

	public function __construct($question =array()) {
          $this->_answers=array();

          foreach ($question as $field => $value) {
            switch ($field) {
              case "question_id":
                 $this->_question_id = $value;
                 break;
              case "heading":
                 $this->_heading = $value;
                 break;
              case "subtype":
                 switch ($value) {
                     case "vertical":
                       $this->_type = SM_SUBTYPE_VERTICAL;
                       break;
                     case "vertical_two_col":
                       $this->_type = SM_SUBTYPE_VERTICAL_TWO_COL;
                       break;
                     case "vertical_three_col":
                       $this->_type = SM_SUBTYPE_VERTICAL_THREE_COL;
                       break;
                     case "horiz":
                       $this->_type = SM_SUBTYPE_HORIZ;
                       break;
                     case "menu":
                       $this->_type = SM_SUBTYPE_MENU;
                       break;
                     case "single":
                       $this->_type = SM_SUBTYPE_SINGLE;
                       break;
                     case "multi":
                       $this->_type = SM_SUBTYPE_MULTI;
                       break;
                     case "rating":
                       $this->_type = SM_SUBTYPE_RATING;
                       break;
                     case "ranking":
                       $this->_type = SM_SUBTYPE_RANKING;
                       break;
                     case "numerical":
                       $this->_type = SM_SUBTYPE_NUMERICAL;
                       break;
                     case "essay":
                       $this->_type = SM_SUBTYPE_ESSAY;
                       break;
                     case "us":
                       $this->_type = SM_SUBTYPE_US;
                       break;
                     case "international":
                       $this->_type = SM_SUBTYPE_INTERNATIONAL;
                       break;
                     case "date_only":
                       $this->_type = SM_SUBTYPE_DATE_ONLY;
                       break;
                     case "time_only":
                       $this->_type = SM_SUBTYPE_TIME_ONLY;
                       break;
                     case "both":
                       $this->_type = SM_SUBTYPE_BOTH;
                       break;
                     case "image":
                       $this->_type = SM_SUBTYPE_IMAGE;
                       break;
                     case "video":
                       $this->_type = SM_SUBTYPE_VIDEO;
                       break;
                     case "descriptive_text":
                       $this->_type = SM_SUBTYPE_DESCRIPTIVE_TEXT;
                       break;
                     default:
                       echo "unexpected question subtype: $value<br>";
                   }
                 break;
              case "family":
                 switch ($value) {
                     case "single_choice":
                       $this->_family = SM_FAMILY_SINGLE_CHOICE;
                       break;
                     case "matrix":
                       $this->_family = SM_FAMILY_MATRIX;
                       break;
                     case "open_ended":
                       $this->_family = SM_FAMILY_OPEN_ENDED;
                       break;
                     case "demographic":
                       $this->_family = SM_FAMILY_DEMOGRAPGIC;
                       break;
                     case "datetime":
                       $this->_family = SM_FAMILY_DATETIME;
                       break;
                     case "presenation":
                       $this->_family = SM_FAMILY_PRESENTATION;
                       break;
                     default:
                       echo "unexpected question family: $value<br>";
                   }
                 break;
              case "position":
                 $this->_position = intval($value);
                 break;
              case "answers":
                  foreach ($value as $index => $answer) {
                     $obj = new SurveyMonkey_SurveyAnswer ($answer);
//                     echo $obj->detailHTML();  // show us what we got
                     $this->_answers[] = $obj;
                  }
                 break;
/*              default:
                 if (!is_array($value)) {
                    echo "unexpected question property: $field:$value<br>";
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
            $HTML .= $this->_heading ."<br>";
            $HTML .= "</div>";
            return $HTML ;
        }
	public function detailHTML () {
            $HTML  = $this->formatHTML ();
            $HTML .= "<div><table border=0; cellspacing=10 style='text-align:center;'><tr><thead><td>Family</td><td>SubType</td><td>posn</td></tr><tr><td>";
            $HTML .= $this->_family ."</td><td>";
            $HTML .= $this->_subtype ."</td><td>";
            $HTML .= $this->_position ."</td></tr>";
            $HTML .= "</table></div>";
            return $HTML ;
	}
}

class SurveyMonkey_SurveyAnswer {

    /**
     * @var sring answer ID
     */
	protected $_answer_id;
    /**
     * @var sring answer type (col; row)
     */
	protected $_type;
    /**
     * @var sring answer text
     */
	protected $_text;
    /**
     * @var sring answer text
     */
	protected $_apply_all_rows;
    /**
     * @var int position
     */
	protected $_position;
    /**
     * @var int weight
     */
	protected $_weight;
    /**
     * @var bool visible
     */
	protected $_visible;


	public function __construct($answer =array()) {
          foreach ($answer as $field => $value) {
            switch ($field) {
              case "answer_id":
                 $this->_answer_id = $value;
                 break;
              case "text":
                 $this->_text = $value;
                 break;
              case "type":
                 $this->_type = $value;
                 break;
              case "apply_all_rows":
                 $this->_apply_all_rows = $value;
                 break;
              case "position":
                 $this->_position = intval($value);
                 break;
              case "weight":
                 $this->_weight = intval($value);
                 break;
              case "visible":
                 $this->_visible = ($value == 1);
                 break;
/*              default:
                if (!is_array($value)) {
                   echo "unexpected answer property: $field:$value<br>";
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
            $HTML  = "<div>Answer ID:". $this->_answer_id ."<br>";
            $HTML .= $this->_text ."<br>";
            $HTML .= "</div>";
            return $HTML ;
        }
	public function detailHTML () {
            $HTML  = $this->formatHTML ();
            $HTML .= "<div><table border=0; cellspacing=10 style='text-align:center;'><tr><thead><td>Visible</td><td>apply<br>all rows</td><td>Type</td><td>posn</td><td>weight</td></tr><tr><td>";
            $HTML .= $this->_visible ."</td><td>";
            $HTML .= $this->_apply_all_rows ."</td><td>";
            $HTML .= $this->_type ."</td><td>";
            $HTML .= $this->_position ."</td><td>";
            $HTML .= $this->_weight ."</td></tr>";
            $HTML .= "</table></div>";
            return $HTML ;
	}
}
?>
