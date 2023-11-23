<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Company;
use App\Models\ContactCandidate;
use App\Models\HiredCandidate;
use App\Models\Wallet;
use GuzzleHttp\Psr7\Request;

class CandidateController extends Controller
{
    public function index(){

    $candidates = Candidate::with(['contact','hired'])->get();
    $coins = Company::find(1)->wallet->coins;
    
    return view('candidates.index', compact('candidates', 'coins'));
}

    public function contact($id) {

        $status = 200;

        try {
            
            ContactCandidate::updateOrCreate([
                'company_id' => 1,
                'candidate_id' => $id,
            ]);
            
            $data = Company::find(1);
            $email = Candidate::find($id);

            $details = [
                'title' => 'Congratulation you are shorted listed',
                'body' => "By ".$data->name
            ];

            dispatch(new \App\Jobs\SendEmailQueueJob($email->email,$details));

            Wallet::where('company_id', 1)->decrement('coins',5);

            $message = 'Contact email send successfully';
        } catch (\Illuminate\Database\QueryException $qe) {
            $status = 500;
            $message = $qe->getMessage();
        } catch (\Exception $ex) {
            $status = 500;
            $message = $ex->getMessage();
        } catch (\Throwable $t) {
            $status = 500;
            $message = $t->getMessage();
        }

        return response(['status_code' => $status, 'message' => $message]);
    }

    public function hire($id){
        $status = 200;

        try {

            $candidate = Candidate::find($id);

            if($candidate->contact){
                
                HiredCandidate::updateOrCreate([
                    'company_id' => 1,
                    'candidate_id' => $id,
                ]);
                
                $data = Company::find(1);
    
                $details = [
                    'title' => 'Congratulation you are hired',
                    'body' => "By ".$data->name
                ];
    
                dispatch(new \App\Jobs\SendEmailQueueJob($candidate->email,$details));
    
                Wallet::where('company_id', 1)->increment('coins',5);
    
                $message = 'Hiring email send successfully';
            }else{
                $status = 500;
                $message = 'Contact Candidate first.';
            }
        } catch (\Illuminate\Database\QueryException $qe) {
            $status = 500;
            $message = $qe->getMessage();
        } catch (\Exception $ex) {
            $status = 500;
            $message = $ex->getMessage();
        } catch (\Throwable $t) {
            $status = 500;
            $message = $t->getMessage();
        }

        return response(['status_code' => $status, 'message' => $message]);
    }
}
