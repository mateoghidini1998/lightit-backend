<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Services\TokenGenerator;
use Exception;

class DiagnosisClient { 

    private $healthServiceUrl; 
    private $language;
    private $token;
    private $validThrough;

    # constructor
    function __construct($language) {

        $tokenGenerator = new TokenGenerator();
        $token = $tokenGenerator->loadToken();

        $this->token = $token->Token;
        $this->validThrough = $token->ValidThrough;
        $this->healthServiceUrl = Config::get('services.health_service_url');
        $this->language = $language;
    }

    # <summary>
    # Generic api get call to load data from webservice
    # </summary>
    # <param name="$action">common url parameters for each call</param>
    # <returns>Returns deserialized result from webservice</returns>
    private function _loadFromWebserice($action)
    {
        $extraArgs = 'token='.$this->token.'&format=json&language='.$this->language;
        $extraChar = strpos($action, '?') ? '&' : '?';
        $url = $this->healthServiceUrl.'/'.$action.$extraChar.$extraArgs;

        var_dump($url);
        $response = Http::get($url);
        $result = $response->body();
        $obj = json_decode($result, true);

        if ($response->status() != 200) {
            // Handle error from the server
            // You can throw an exception or return an appropriate response
            return null;
        }

        return $obj;
    }		
    
    private function getTokenValidThrough()
    {
        $tokenParts = explode('.', $this->token);
        if (count($tokenParts) !== 3) {
            return null;
        }

        $payload = base64_decode($tokenParts[1]);
        $data = json_decode($payload, true);
        return $data['ValidThrough'] ?? null;
    }

    # <summary>
    # Load all symptoms
    # </summary>
    # <returns>Returns array of all symptoms</returns>
    public function loadSymptoms() { 
        return $this->_loadFromWebserice('symptoms'); 
    } 
    
    # <summary>
    # Load all issues
    # </summary>
    # <returns>Returns array of all issues</returns>
    public function loadIssues() { 
        return $this->_loadFromWebserice('issues'); 
    } 
    
    # <summary>
    # Load detail informations about selected issue
    # </summary>
    # <param name="$issueId"></param>
    # <returns>Returns detail informations about selected issue</returns>
    public function loadIssueInfo($issueId) { 
        return $this->_loadFromWebserice('issues/'.$issueId.'/info'); 
    } 
    
    # <summary>
    # Load calculated array of potential issues for selected parameters
    # </summary>
    # <param name="$selectedSymptoms">List of selected symptom ids</param>
    # <param name="$gender">Selected person gender (possible values for gender: 'Male', 'Female')</param>
    # <param name="$yearOfBirth">Selected person year of born</param>
    # <returns>Returns calculated array of potential issues for selected parameters</returns>
    public function loadDiagnosis($selectedSymptoms, $gender, $yearOfBirth) { 
        return $this->_loadFromWebserice('diagnosis?symptoms='.json_encode($selectedSymptoms).'&gender='.$gender.'&year_of_birth='.$yearOfBirth); 
    } 
    
    # <summary>
    # Load calculated array of potential issues for selected parameters
    # </summary>
    # <param name="$selectedSymptoms">List of selected symptom ids</param>
    # <param name="$gender">Selected person gender (possible values for gender: 'Male', 'Female')</param>
    # <param name="$yearOfBirth">Selected person year of born</param>
    # <returns>Returns calculated array of potential specialisations for selected parameters</returns>
    public function loadSpecialisations($selectedSymptoms, $gender, $yearOfBirth) { 
        return $this->_loadFromWebserice('diagnosis/specialisations?symptoms='.json_encode($selectedSymptoms).'&gender='.$gender.'&year_of_birth='.$yearOfBirth); 
    } 
    
    # <summary>
    # Load human body locations
    # </summary>
    # <returns>Returns array of human body locations</returns>
    public function loadBodyLocations() { 
        return $this->_loadFromWebserice('body/locations'); 
    }
    
    # <summary>
    # Load human body sublocations for selected human body location
    # </summary>
    # <param name="bodyLocationId">Human body location id</param>
    # <returns>Returns array of human body sublocations for selected human body location</returns>
    public function loadBodySublocations($bodyLocationId) { 
        return $this->_loadFromWebserice('body/locations/'.$bodyLocationId); 
    }
    
    # <summary>
    # Load all symptoms for selected human body location
    # </summary>
    # <param name="$locationId">Human body sublocation id</param>
    # <param name="$selectedSelectorStatus">Selector status (possible values: 'Man', 'Woman', 'Boy', 'Girl')</param>
    # <returns>Returns array of all symptoms for selected human body location and selected selector status. If $sublocationId = 0, returns all symptoms</returns>
    public function loadSublocationSymptoms($sublocationId, $selectedSelectorStatus) { 
        return $this->_loadFromWebserice('symptoms/'.$sublocationId.'/'.$selectedSelectorStatus); 
    }
    
    # <summary>
    # Load array of proposed symptoms for selected symptoms combination
    # </summary>
    # <param name="$selectedSymptoms">List of selected symptom ids</param>
    # <param name="$gender">Selected person gender (Male, Female)</param>
    # <param name="$yearOfBirth">Selected person year of born</param>
    # <returns>Returns array of proposed symptoms for selected symptoms combination, gender and age</returns>
    public function loadProposedSymptoms($selectedSymptoms, $gender, $yearOfBirth) { 
        return $this->_loadFromWebserice('symptoms/proposed?symptoms='.json_encode($selectedSymptoms).'&gender='.$gender.'&year_of_birth='.$yearOfBirth); 
    } 
    
    # <summary>
    # Load red flag text for selected symptom
    # </summary>
    # <param name="$symptomId">Selected symptom id</param>
    # <returns>Returns red flag text for selected symptom</returns>
    public function loadRedFlag($symptomId) { 
        return $this->_loadFromWebserice('redflag?symptomId='.$symptomId); 
    } 
}