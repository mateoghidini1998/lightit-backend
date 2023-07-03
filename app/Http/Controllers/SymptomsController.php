<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Services\ApiMedicService;
use Carbon\Carbon;


class SymptomsController extends Controller
{
    protected $apimedicservice;

    public function __construct(ApiMedicService $apimedicservice)
    {
        $this->apimedicservice = $apimedicservice;
    }

    public function getAllSymptoms()
    {
        $symptoms = $this->apimedicservice->loadSymptoms();

        return response()->json($symptoms);
    }

    public function getIssues()
    {
        $issues = $this->apimedicservice->loadIssues();

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

        $diagnoses = $this->apimedicservice->loadDiagnosis($symptoms, $gender, $birth_date);

        return response()->json($diagnoses);
    }

    
}


