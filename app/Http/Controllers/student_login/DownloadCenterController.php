<?php

namespace App\Http\Controllers\student_login;
use Illuminate\Validation\Validator;
use App\Models\DownloadCenter;
use Session;
use Hash;
use Str;
use Redirect;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DownloadCenterController extends Controller
{
            public function studentDownloadCenter(){
                $assignments = DownloadCenter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('dashboard.student.download_center.download_center', ['data' => $assignments]);
            }
            
            public function studentAssignments(){
                $assignments = DownloadCenter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('dashboard.student.download_center.studentAssignments', ['data' => $assignments]);
            }
        
            public function studentStudyMaterials(){
                $studyMaterials = DownloadCenter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('dashboard.student.download_center.student_study_material', ['data' => $studyMaterials]);
            }
            
            public function studentSyllabus(){
                $syllabus = DownloadCenter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('dashboard.student.download_center.student_syllabus', ['data' => $syllabus]);
            }
            
            public function studentOtherDownloads(){
                $otherDownloads = DownloadCenter::where('session_id', Session::get('session_id'))
                    ->where('branch_id', Session::get('branch_id'))->orderBy('id', 'DESC')->get();
                return view('dashboard.student.download_center.student_other_downloads', ['data' => $otherDownloads]);
            }

}