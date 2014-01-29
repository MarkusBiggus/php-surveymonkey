<?php
include 'SurveyMonkeyAPI.class.php';
include 'SurveyMonkeySurvey.class.php';
echo '<html><head><title>SurveyMonkey Metadata</title></head><body style="font-family:Arial; font-size:12pt;">';

$Survey = new SurveyMonkey('<apikey>', '<accesstoken>');   // your values provided by the API console

if (isset($_REQUEST['ID'])) {
   $surveyID = $_REQUEST['ID'];
   $survey_array = $Survey -> getSurveyDetails($surveyID);
   
   $objSurvey = new SurveyMonkey_Survey ($survey_array["data"]);
   echo $objSurvey->formatHTML();

   // use detailHTML function for all properties display
   foreach ($objSurvey->getPages() as $page){
      echo $page->formatHTML() ."<br>";
      foreach ($page->getQuestions() as $question){
         echo $question->formatHTML() ."<br>";
         foreach ($question->getAnswers() as $answer){
            echo $answer->formatHTML() ."<br>";
         }
      }
   }

   echo "pages:" .count($objSurvey->getPages());
} else {

   $list = $Survey -> getSurveyList();
   dspSurveyList ($list["data"]["surveys"]);
}
echo '</body></html>';
function dspSurveyList($SurveyList) {
  if (is_array($SurveyList)) {
    foreach ($SurveyList as $Survey){
      echo "ID:<strong>". $Survey['survey_id'] ."</strong> <a href='SMGetSurveyMetadata.php?ID=" . $Survey['survey_id'] ."'>MetaData</a>&nbsp;&nbsp;<a href='SMGetSurveyResponses.php?ID=" . $Survey['survey_id'] ."'>Responses</a><br>";
    }
  } else {
      echo "Expected array of Survey IDs";
      Die(1);
  }
}

?>
