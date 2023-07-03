<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Http\Services\TokenGenerator;
use App\Services\DiagnosisClient;

class ApiMedicService
{
    protected $diagnosisClient;

    public function __construct()
    {
        $language = 'en-gb';
        $this->diagnosisClient = new DiagnosisClient($language);
    }

    public function loadSymptoms()
    {
        return $this->diagnosisClient->loadSymptoms();
    }

    public function loadIssues()
    {
        return $this->diagnosisClient->loadIssues();
    }

    public function loadIssueInfo($issueId)
    {
        return $this->diagnosisClient->loadIssueInfo($issueId);
    }

    public function loadDiagnosis($selectedSymptoms, $gender, $yearOfBirth)
    {
        return $this->diagnosisClient->loadDiagnosis($selectedSymptoms, $gender, $yearOfBirth);
    }

    public function loadSpecialisations($selectedSymptoms, $gender, $yearOfBirth)
    {
        return $this->diagnosisClient->loadSpecialisations($selectedSymptoms, $gender, $yearOfBirth);
    }

    public function loadBodyLocations()
    {
        return $this->diagnosisClient->loadBodyLocations();
    }

    public function loadBodySublocations($bodyLocationId)
    {
        return $this->diagnosisClient->loadBodySublocations($bodyLocationId);
    }

    public function loadSublocationSymptoms($sublocationId, $selectedSelectorStatus)
    {
        return $this->diagnosisClient->loadSublocationSymptoms($sublocationId, $selectedSelectorStatus);
    }

    public function loadProposedSymptoms($selectedSymptoms, $gender, $yearOfBirth)
    {
        return $this->diagnosisClient->loadProposedSymptoms($selectedSymptoms, $gender, $yearOfBirth);
    }

    public function loadRedFlag($symptomId)
    {
        return $this->diagnosisClient->loadRedFlag($symptomId);
    }
}
