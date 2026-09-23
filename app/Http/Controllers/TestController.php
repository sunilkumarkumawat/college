<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Validator; 
use App\Models\User;
use App\Models\Profile;
use App\Models\Admission;
use App\Models\MessageQueue;
use DateTime;
use Helper;
use Session;
use Hash;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller

{
    
    public function test(Request $request){

        $admission = Admission::take(5)->get();
        foreach($admission as $item){
            $user_id = 1;
            $branch_id = $item->branch_id;
            $session_id = $item->session_id;
            $mobile = '8209949186';
            $message = $item->first_name;
            $this->MessageQueueSetup($user_id, $branch_id, $session_id, $mobile, $message);
        }
        // $data = Admission::where('branch_id', 4)->whereNull('batch')->get();
        // dd($data);
        // foreach($data as $item){

           
        //     // $admission = Admission::find($item->id);         
        //     // $admission->userName = strtoupper(str_replace(' ', '', $item->first_name)) . $item->admissionNo;
        //     // $admission->confirm_password = $item->admissionNo;
        //     // $admission->password = Hash::make($item->admissionNo);
        //     // $admission->save();
            
        // }
    
        dd('Done');
    }

    public function MessageQueueSetup($user_id, $branch_id, $session_id, $mobile, $message){
        $dateTime = new DateTime();
        $submitedDate = $dateTime->format('Y-m-d H:i:s'); 
        $queue = new MessageQueue;
        $queue->user_id = $user_id;
        $queue->session_id = $branch_id;
        $queue->branch_id = $session_id;
        $queue->message_id = $data['message-id'] ?? substr(md5(mt_rand()), 0, 7);
        $queue->receiver_number = $mobile;
        $queue->message_type = 'text';
        $queue->content = $message;
        $queue->submitted_at = $submitedDate;
        $queue->message_status = 0;
        $queue->save();
    }

    public function testExcel(Request $request){

        if($request->isMethod('post')){

            dd($request);
        
            $array = Helper::getAdmissionDatatableFields();
            $branch = Branch::find(Session::get('session_id'));
            $the_file = $request->file('excel');
                try {
                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet = $spreadsheet->getActiveSheet();
                    $row_limit = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range = range(3, $row_limit);
                    //$column_range = range('F', $column_limit);
                    $highestColumnNumber = $this->columnLetterToNumber($column_limit);
                    $data = array();
                    $val2 = [];
                        foreach ($row_range as $row) {
                            $val =[];
                            for($i =0; $i<$highestColumnNumber;$i++){
                            $cell =$sheet->getCell($this->indexToColumnName($i) . $row);
                            $value = $cell->getValue();
                            // Check if the cell contains rich text
                                if ($value instanceof RichText) {
                                     $value = $value->getPlainText();
                                }
                                    $index = $sheet->getCell($this->indexToColumnName($i) . 2)->getValue().'';
                                if($index == 'Class'){
                                    $classType = ClassType::where('name', $value)->where('branch_id',Session::get('branch_id'))->first();
                                    $value = $classType->id ?? '';
                                }
                                if($index == 'Admission Type'){
                                    $admissionTypeMapping = ["Non RTE" => 1, "RTE" => 2 ];
                                    $value = $admissionTypeMapping[$value] ?? '1';
                                }
                                if($index == 'Gender'){
                                    $genderTypeMapping = Gender::where('name', $value)->first();
                                    $value = $genderTypeMapping->id ?? '';
                                }
                                if($index == 'Blood Group'){
                                    $bloodgroupTypeMapping = BloodGroup::where('name', $value)->first();
                                    $value = $bloodgroupTypeMapping->id ?? '';
                                }
                                if($index == 'State'){
                                    $stateTypeMapping = State::where('name', $value)->first();
                                    $value = $stateTypeMapping->id ?? '';
                                }
                                if($index == 'City'){
                                    $cityTypeMapping = City::where('name', $value)->first();
                                    $value = $cityTypeMapping->id ?? '';
                                }
                                if ($index == 'D.O.B.') {
                                    $value =  $this->convertExcelDate($value);
                                }
                                if ($index == 'Ad. Date') {
                                    $value =  $this->convertExcelDate($value);
                                }
                                if($index != 'SR.NO'){
                                    $val[$array[$index]] = $value;
                                }
                                if ($this->indexToColumnName($i) == 'B') {
                                    $columnBValue = $value ?? ''; // Handle null values safely
                                }
                            }
                            $val['session_id']= Session::get('session_id');
                            $val['user_id']= Session::get('id');
                            $val['branch_id']=Session::get('branch_id');
                            $val['status']=1;
                            $val['school']=1;
                            $uniqueId = strtoupper(Str::random(10));
                            $val['unique_system_id'] = $uniqueId;
                            $val['userName'] = !empty($columnBValue) ? $columnBValue : '';
                            $val['password'] = !empty($columnBValue) ? Hash::make($columnBValue) : '';
                            $val['confirm_password'] = !empty($columnBValue) ? $columnBValue : '';
                            $val2[]=$val;
                        }
                //dd($val2);
                 DB::table('admissions')->insert($val2);
            } 
            catch (Exception $e) {
            $error_code = $e->errorInfo[1];
            return redirect('testExcel')->with('error', 'Error Student Not Added !');
            }
            return redirect('testExcel')->with('message', 'Student Add Successful !');
        }

        return view('test.test');
    }

}















