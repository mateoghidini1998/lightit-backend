<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Services\DiagnosisClient;
use Carbon\Carbon;


class SymptomsController extends Controller
{
    protected $diagnosisClient;

    public function __construct()
    {
        $language = 'en-gb';
        $this->diagnosisClient = app()->make(DiagnosisClient::class, ['language' => $language]);
    }

    public function getAllSymptoms()
    {
        $symptoms = $this->diagnosisClient->loadSymptoms();

        return response()->json($symptoms);
    }

    public function getIssues()
    {
        $issues = $this->diagnosisClient->loadIssues();

        return response()->json($issues);
    }

    public function getDiagnoses(Request $request)
    {
        $this->validate($request, [
            'symptoms' => 'required|array',
            'symptoms.*' => 'numeric',
        ]);

        $symptoms = $request->input('symptoms');
        $user = Auth::user();
        $gender = $user->gender;
        $birth_date = Carbon::parse($user->birth_date)->format('Y');

        $diagnoses = $this->diagnosisClient->loadDiagnosis($symptoms, $gender, $birth_date);

        return response()->json($diagnoses);
    }

    
}


