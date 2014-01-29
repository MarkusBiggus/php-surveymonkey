Developed on Windows Server PHP V5.3.6
the API class is a slightly modified version of SurveyMonkey.class.php found on GIThub.
line 150 :
        $ca = 'C:\Program Files (x86)\PHP\ca-bundle.crt';     // download from http://curl.haxx.se/docs/caextract.html

the ca-bundle.crt file goes in the PHP server folder specified in the API class. (current as of Jan-2014)

Get an API key and access code from the SurveyMonkey API console for your account.
Put those values into the two main modules  SMGetSurveyMetadata.php & SMGetSurveyResponses.php
Copy all remaining files to webroot folder of PHP server
Browse surveys using either module.
http://SMGetSurveyMetadata.php
http://SMGetSurveyResponses.php
