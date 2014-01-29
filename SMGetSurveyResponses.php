<?php
include 'SurveyMonkeyAPI.class.php';
include 'SurveyMonkeyResponse.class.php';
echo '<html><head><title>SurveyMonkey Responses</title></head><body style="font-family:Arial; font-size:12pt;">';

$Survey = new SurveyMonkey('<apikey>', '<accesstoken>');   // your values provided by the API console

if (isset($_REQUEST['ID'])) {
   $surveyID = $_REQUEST['ID'];

   if (isset($_REQUEST['RID'])) {
      $responseIDs[] = $_REQUEST['RID'];
      $respondent_array = $Survey -> getResponses ($surveyID, $responseIDs);
      $objSurvey = new SurveyMonkey_Response ($respondent_array["data"][0]); // only one respondent in this array
      echo $objSurvey->formatHTML() ."<br>";

      // use detailHTML function for all properties display
      foreach ($objSurvey->getQuestions() as $question){
         echo $question->formatHTML();
         foreach ($question->getAnswers() as $answer){
            echo $answer->formatHTML() ."<br>";
         }
      }

   } else {  // no respondent ID
      $respondent_array = $Survey -> getRespondentList($surveyID);
      if (count($respondent_array["data"]["respondents"]) < 1) {
        echo "Survey ID $surveyID has no respondents yet.";
      } else {
         //print_r($respondent_array);
         dspRespondentList ($respondent_array["data"]["respondents"], $surveyID);
      }
   }
} else { // no survey ID
   $list = $Survey -> getSurveyList();
   dspSurveyList ($list["data"]["surveys"]);
}
echo '</body></html>';
/////////////////////////////////////////

function dspSurveyList($SurveyList) {
  if (is_array($SurveyList)) {
    foreach ($SurveyList as $Survey){
      echo "ID: <strong>". $Survey['survey_id'] ."</strong> <a href='SMGetSurveyMetadata.php?ID=" . $Survey['survey_id'] ."'> MetaData</a>&nbsp;&nbsp;<a href='SMGetSurveyResponses.php?ID=" . $Survey['survey_id'] ."'> Responses</a><br>";
    }
  } else {
      echo "Expected array of Survey IDs";
      Die(1);
  }
}

function dspRespondentList($RespondentList, $surveyID) {
  if (is_array($RespondentList)) {
    foreach ($RespondentList as $Respondent){
      echo "ID: <strong>". $Respondent['respondent_id'] ."</strong><a href='SMGetSurveyResponses.php?ID=$surveyID&RID=". $Respondent['respondent_id'] ."'> Responses</a><br>";
    }
  } else {
      echo "Expected array of Respondent IDs";
      Die(1);
  }
}

?>
