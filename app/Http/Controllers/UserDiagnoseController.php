<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserDiagnosis;



class UserDiagnoseController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'issue_name' => 'required|string',
            'issue_ProfName' => 'required|string',
            'issue_accuracy' => 'required|string',
            'specialisations' => 'required|array',
        ]);

        $userDiagnosis = UserDiagnosis::create([
            'user_id' => Auth::user()->id,
            'issue_name' => $request->input('issue_name'),
            'issue_ProfName' => $request->input('issue_ProfName'),
            'issue_accuracy' => $request->input('issue_accuracy'),
            'specialisations' => json_encode($request->input('specialisations')),
        ]);
        

        return response()->json($userDiagnosis, 201);
    }   

    public function index(){
        $userDiagnosis = UserDiagnosis::where('user_id', Auth::user()->id)->get();

        return response()->json($userDiagnosis, 200);
    }

    public function delete($id){
        $userDiagnosis = UserDiagnosis::find($id);
        $userDiagnosis->delete();
        return response()->json(null, 204);
    }
}
