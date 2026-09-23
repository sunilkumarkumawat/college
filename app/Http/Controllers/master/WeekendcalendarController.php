<?php
namespace App\Http\Controllers\master;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Master\Weekendcalendar;
use Session;
use Hash;
use Str;
use Redirect;
use File;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;

class WeekendcalendarController extends Controller 

{
            public function add(Request $request){
                if($request->isMethod('post')){
                    $request->validate([
                        //'img_category' => 'required',
                        //'photo' => 'required', 
                    ]);
                    $date = new DateTime($request->date); // replace with your date
                    $monthNumber = $date->format('n');
                    $weekName = $date->format('l');
                    $add_weeked = new Weekendcalendar;//model name
                    $add_weeked->user_id = Session::get('id');
                    $add_weeked->session_id = Session::get('session_id');
                    $add_weeked->branch_id = Session::get('branch_id');
                    $add_weeked->month_id =$monthNumber;
                    $add_weeked->attendance_status =$request->attendance_status;
                    $add_weeked->event_schedule =$request->event_schedule;
                    $add_weeked->date =$request->date;
                    $add_weeked->day =$weekName;
            	    $add_weeked->save();
                    return redirect::to('view_weekend')->with('message', 'Weekend Calendar Added Successfully.');
                }
                return view('master.Weekendcalendar.add');
            } 

            public function view(Request $request){
                $search['month_id'] = $request->month_id ?? '';
                $data = Weekendcalendar::select('weekendcalendar.*','months.name as month_name','attendance_status.name as attendance_status')
                ->leftJoin('months','months.id','weekendcalendar.month_id')
                ->leftJoin('attendance_status','attendance_status.id','weekendcalendar.attendance_status');
                if($search['month_id'] !='' ){
                    $data = $data->where('weekendcalendar.month_id', $search['month_id']);
                }
                $data = $data->orderBy('weekendcalendar.id','DESC')->get();
                return view('master.Weekendcalendar.view',['data'=>$data, 'search' => $search]);
            } 

            public function delete(Request $request){
                $data = Weekendcalendar::find($request->delete_id)->delete();
                return redirect::to('view_weekend')->with('message', 'Weekend Calendar  Deleted Successfully.');
            }

            public function weekendPrint(Request $request, $id){
                $weekendcalendar =  Weekendcalendar::where('month_id', $id)->orderBy('id','ASC')->get();
                //dd($weekendcalendar);
                return view('master.Weekendcalendar.calendarprint', ['data' => $weekendcalendar,'id' => $id]);
            }

            public function academicCalendar(Request $request){
                $data = Weekendcalendar::where('session_id',Session::get('session_id'))
                ->where('branch_id',Session::get('branch_id'))
                ->orderBy('date','ASC')->get();
                return response()->json(['data' => $data]);
            }
            
            public function weekendSearch(Request $request){
                $search['month_type'] = $request->month_type;
                if ($request->isMethod('post')) {
                    $request->validate([]);
                    $data = Weekendcalendar::where('session_id', Session::get('session_id'));
                    if (Session::get('role_id') > 1) {
                        $data = $data->where('branch_id', Session::get('branch_id'));
                    }
                    if (!empty(Session::get('admin_branch_id'))) {
                        $data = $data->where('branch_id', Session::get('admin_branch_id'));
                    }
                    if (!empty($request->month_type)) {
                        $data = $data->where("month_type", $request->month_type);
                    }
                    $allstudents = $data->orderBy('id', 'DESC')->get();
                }
                // return view('students.admission.studentSearchView', ['data' => $allstudents]);
                return view('master.Weekendcalendar.calendarSearch', ['data' => $allstudents]);
            }

            public function weekendEdit(Request $request,$id){
                $data = Weekendcalendar::find($id);
                if ($request->isMethod('post')) {
                    $date = new DateTime($request->date); // replace with your date
                    $monthNumber = $date->format('n');
                    $weekName = $date->format('l');
                    $data->month_id =$monthNumber;
                    $data->attendance_status =$request->attendance_status;
                    $data->event_schedule =$request->event_schedule;
                    $data->date =$request->date;
                    $data->day =$weekName;
                    $data->save();
                    
                    return redirect::to('view_weekend')->with('message', 'Weekend Calendar Updated Successfully.');
                    // return redirect::to('edit_weekend/'.$id)->with('message', 'Event Updated Successfully');
                }
                return view('master.Weekendcalendar.edit', ['data' => $data]);
            }
    
}