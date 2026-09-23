<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\Admission;
use App\Models\RollNumber;
use App\Models\StudentId;
use App\Models\StudentAction;
use App\Models\exam\FillMarks;
use App\Models\Classs;
use App\Models\ClassType;
use App\Models\Subject;
use App\Models\Sessions;
use App\Models\Master\Branch;
use App\Models\TcCertificate;
use App\Models\BillCounter;
use App\Models\SmsSetting;
use App\Models\BloodGroup;
use App\Models\DatatableFields;
use App\Models\FeesMaster;
use App\Models\FeesCollect;
use App\Models\WhatsappSetting;
use App\Models\FeesStructure;
use App\Models\FeesDetail;
use App\Models\Setting;
use App\Models\State;
use App\Models\Gender;
use App\Models\Master\MessageTemplate;
use App\Models\Master\MessageType;
use App\Models\City;
use App\Models\fees\FeesAssign;
use App\Models\fees\FeesAssignDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Session;
use Hash;
use PDF;
use Helper;
use Str;
use Mail;
use File;
use DB;
use Redirect;
use Auth;
use App\Imports\YourImportClassName;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class StudentsAdmissionController extends Controller
{
           /*public function unique_system_id(){
                $data = Admission::whereNull('unique_system_id')->get();
                
                if(!empty($data)){ 
                    foreach($data as $item){
                        $find = Admission::find($item->id);
                        $uniqueId = strtoupper(Str::random(10));
                        $find->unique_system_id = $uniqueId;
                        $find->save();
                    }
                }
            }*/
    
            protected function unique_system_id($id){
                $uniqueId = strtoupper(Str::random(10));
                Admission::where('id',$id)->whereNull('unique_system_id')->update(['unique_system_id' => $uniqueId]);
            }
    
            protected function convertExcelDate($date){
                if(is_numeric($date)) {
                        return Carbon::createFromFormat('Y-m-d', '1899-12-30')->addDays($date);
                    }elseif (is_string($date)) {
                        try{
                            return Carbon::createFromFormat('Y-m-d', $date);
                        } catch (\Exception $e) {
                            try{
                                return Carbon::createFromFormat('d-m-Y', $date);
                            }catch (\Exception $e) {
                                try {
                                    return Carbon::createFromFormat('m-d-Y', $date);
                                }catch (\Exception $e) {
                                        return null;
                                }
                            }
                        }
                    }
                     return null;
            }
            public function saveAdmissionDatatableFields(Request $request){
                $data = DatatableFields::find(1);
                    if(!empty($data)){
                    $data->fields= implode(',', $request->fields);
                    $data->save();
                    }
                            else
                        {
                            $data = new DatatableFields;
                            $data->fields = implode(',', $request->fields);
                            $data->save();
                        }
                return redirect::to('admissionView')->with('message','Datatable Fields Selected Successfully');
            }
    
            public function updateByExcel(Request $request){
                //dd($request);
                $array = Helper::getAdmissionDatatableFields();
                // $array['SR.NO'] = 'id';
                // $array['Student.Ad. No'] = 'admissionNo';
                // $array['Image'] = 'image';
                // $array['Ledger No'] = 'ledger_no';
                // $array['Srn'] = 'srn';
                // $array['Name'] = 'first_name';
                // $array['F Name'] = 'father_name';
                // $array['M Name'] = 'mother_name';
                // $array['Class'] = 'class_type_id';
                // $array['Mobile'] = 'mobile';
                // $array['D.O.B.'] = 'dob';
                // $array['State'] = 'state_id';
                // $array['City'] = 'city_id';
                // $array['Village'] = 'village_city';
                // $array['Address'] = 'address';
                // $array['Pincode'] = 'pincode';
                // $array['Caste Category'] = 'caste_category';
                // /*$array['Id Proof'] = 'id_proof';
                // $array['Id Number'] = 'id_number';*/
                // $array['Blood Group'] = 'blood_group';
                // $array['House'] = 'house';
                // $array['Height'] = 'height';
                // $array['Weight'] = 'weight';
                // $array['Family Income'] = 'family_annual_income';
                // $array['Email'] = 'email';
                // $array['Family Id'] = 'family_id';
                // $array['Religion'] = 'religion';
                // $array['Category'] = 'category';
                // $array['Aadhar'] = 'aadhaar';
                // $array['Gender'] = 'gender_id';
                // $array['Father Mobile'] = 'father_mobile';
                // $array['Father Aadhaar'] = 'father_aadhaar';
                // $array['Mother Mobile'] = 'mother_mob';
                // $array['Mother Aadhaar'] = 'mother_aadhaar';
                // $array['Guardian Name'] = 'guardian_name';
                // $array['Guardian Mobile'] = 'guardian_mobile';
                // $array['Admission Type'] = 'admission_type_id';
                // $array['Bus No.'] = 'bus_number';
                // $array['Bus Route'] = 'bus_route';
                // $array['Stoppage'] = 'stoppage';
                // $array['Transport Charge'] = 'transpor_charges';
                // $array['Bank Name'] = 'bank_name';
                // $array['Bank Account'] = 'bank_account';
                // $array['Branch Name'] = 'branch_name';
                // $array['IFSC'] = 'ifsc';
                // $array['MICR Code'] = 'micr_code';
                // $array['Remark'] = 'remark_1';
                // $array['Ad. Date'] = 'admission_date';
                // $array['Transport'] = 'transport';
                $branch = Branch::find(Session::get('session_id'));
                $the_file = $request->file('excel');
                try {
                    $spreadsheet = IOFactory::load($the_file->getRealPath());
                    $sheet        = $spreadsheet->getActiveSheet();
                    $row_limit    = $sheet->getHighestDataRow();
                    $column_limit = $sheet->getHighestDataColumn();
                    $row_range    = range(4, $row_limit);
                    $column_range = range('F', $column_limit);
                    $highestColumnNumber = $this->columnLetterToNumber($column_limit);
                    $data = array();
                    $val2 = [];
                    foreach ($row_range as $row) {
                        $val = [];
                            for ($i = 0; $i < $highestColumnNumber; $i++) {
                                $cell = $sheet->getCell($this->indexToColumnName($i) . $row);
                                $value = $cell->getValue();
                                if ($value instanceof RichText) {
                                    $value = $value->getPlainText();
                                }
                                $index = $sheet->getCell($this->indexToColumnName($i) . 3)->getValue() . '';
                                if ($index == 'Class'){
                                    $classType = ClassType::where('name', $value)->first();
                                    $value = $classType->id ?? '';
                                }
                                if ($index == 'Admission Type'){
                                    $admissionTypeMapping = ["Non RTE" => 1, "RTE" => 2];
                                    $value = $admissionTypeMapping[$value] ?? '1';
                                }
                                if ($index == 'Gender'){
                                    $genderTypeMapping = Gender::where('name', $value)->first();
                                    $value = $genderTypeMapping->id ?? '';
                                }
                                if ($index == 'Blood Group'){
                                    $bloodgroupTypeMapping = BloodGroup::where('name', $value)->first();
                                    $value = $bloodgroupTypeMapping->id ?? '';
                                }
                                if ($index == 'State'){
                                    $state = State::where('name', $value)->first();
                                    $value = $state->id ?? '';
                                }
                                if ($index == 'City') {
                                    $city = City::where('name', $value)->first();
                                    $value = $city->id ?? '';
                                }
                                if ($index == 'D.O.B.'){
                                    $value =  $this->convertExcelDate($value);
                                }
                                if ($index == 'Ad. Date'){
                                    $value =  $this->convertExcelDate($value);
                                }
                                if (!empty($array[$index])) {
                                    $val[$array[$index]] = $value;
                                }
                            }
                        $val2[] = $val;
                    }
                    foreach ($val2 as $student) {
                        $fullName = $student['first_name'] ?? '';
                        $nameParts = explode(' ', $fullName);
                        $firstName = '';
                        $lastName ='';
                            if (count($nameParts) > 1) {
                                $lastName = array_pop($nameParts);
                                $firstName = implode(' ', $nameParts);
                            } else{
                                $firstName = $fullName;
                                $lastName = ''; 
                            }
                                $addadmission = Admission::find($student['id']);
                                $addadmission->admissionNo = array_key_exists('admissionNo', $student) ?  $student['admissionNo'] ?? '' : $addadmission->admissionNo ?? null;
                                $addadmission->ledger_no = array_key_exists('ledger_no', $student) ?  $student['ledger_no'] ?? '' : $addadmission->ledger_no ?? null;
                                $addadmission->srn = array_key_exists('srn', $student) ?  $student['srn'] ?? '' : $addadmission->srn ?? null;
                                $addadmission->first_name = array_key_exists('first_name', $student) ?  $firstName : $addadmission->first_name ?? null;
                                $addadmission->last_name = array_key_exists('first_name', $student) ?  $lastName : $addadmission->last_name ?? null;
                                $addadmission->father_name =  array_key_exists('father_name', $student) ?  $student['father_name'] ?? '' : $addadmission->father_name ?? null;
                                $addadmission->mother_name =  array_key_exists('mother_name', $student) ?  $student['mother_name'] ?? '' : $addadmission->mother_name ?? null;
                                $addadmission->class_type_id =  array_key_exists('class_type_id', $student) ?  $student['class_type_id'] ?? '' : $addadmission->class_type_id ?? null;
                                $addadmission->mobile =  array_key_exists('mobile', $student) ?  $student['mobile'] ?? '' : $addadmission->mobile ?? null;
                                $addadmission->dob = array_key_exists('dob', $student) ?  $student['dob'] ?? '' : $addadmission->dob ?? null;
                                $addadmission->state_id = array_key_exists('state_id', $student) ?  $student['state_id'] ?? '' : $addadmission->state_id ?? null;
                                $addadmission->city_id = array_key_exists('city_id', $student) ?  $student['city_id'] ?? '' : $addadmission->city_id ?? null;
                                $addadmission->village_city = array_key_exists('village_city', $student) ?  $student['village_city'] ?? '' : $addadmission->village_city ?? null;
                                $addadmission->address = array_key_exists('address', $student) ?  $student['address'] ?? '' : $addadmission->address ?? null;
                                $addadmission->pincode = array_key_exists('pincode', $student) ?  $student['pincode'] ?? '' : $addadmission->pincode ?? null;
                                $addadmission->caste_category = array_key_exists('caste_category', $student) ?  $student['caste_category'] ?? '' : $addadmission->caste_category ?? null;
                                // $addadmission->id_proof = array_key_exists('id_proof', $student) ?  $student['id_proof'] ?? '' : $addadmission->id_proof ?? null;
                                // $addadmission->id_number = array_key_exists('id_number', $student) ?  $student['id_number'] ?? '' : $addadmission->id_number ?? null;
                                $addadmission->blood_group = array_key_exists('blood_group', $student) ?  $student['blood_group'] ?? '' : $addadmission->blood_group ?? null;
                                $addadmission->house = array_key_exists('house', $student) ?  $student['house'] ?? '' : $addadmission->house ?? null;
                                $addadmission->height = array_key_exists('height', $student) ?  $student['height'] ?? '' : $addadmission->height ?? null;
                                $addadmission->weight = array_key_exists('weight', $student) ?  $student['weight'] ?? '' : $addadmission->weight ?? null;
                                $addadmission->family_annual_income = array_key_exists('family_annual_income', $student) ?  $student['family_annual_income'] ?? '' : $addadmission->family_annual_income ?? null;
                                $addadmission->email = array_key_exists('email', $student) ?  $student['email'] ?? '' : $addadmission->email ?? null;
                                $addadmission->family_id = array_key_exists('family_id', $student) ?  $student['family_id'] ?? '' : $addadmission->family_id ?? null;
                                $addadmission->religion = array_key_exists('religion', $student) ?  $student['religion'] ?? '' : $addadmission->religion ?? null;
                                $addadmission->category = array_key_exists('category', $student) ?  $student['category'] ?? '' : $addadmission->category ?? null;
                                $addadmission->aadhaar = array_key_exists('aadhaar', $student) ?  $student['aadhaar'] ?? '' : $addadmission->aadhaar ?? null;
                                $addadmission->jan_aadhaar = array_key_exists('jan_aadhaar', $student) ?  $student['jan_aadhaar'] ?? '' : $addadmission->jan_aadhaar ?? null;
                                $addadmission->previous_school = array_key_exists('previous_school', $student) ?  $student['previous_school'] ?? '' : $addadmission->previous_school ?? null;
                                $addadmission->gender_id = array_key_exists('gender_id', $student) ?  $student['gender_id'] ?? '' : $addadmission->gender_id ?? null;
                                $addadmission->father_mobile = array_key_exists('father_mobile', $student) ?  $student['father_mobile'] ?? '' : $addadmission->father_mobile ?? null;
                                $addadmission->father_aadhaar = array_key_exists('father_aadhaar', $student) ?  $student['father_aadhaar'] ?? '' : $addadmission->father_aadhaar ?? null;
                                $addadmission->mother_mob = array_key_exists('mother_mob', $student) ?  $student['mother_mob'] ?? '' : $addadmission->mother_mob ?? null;
                                $addadmission->mother_aadhaar = array_key_exists('mother_aadhaar', $student) ?  $student['mother_aadhaar'] ?? '' : $addadmission->mother_aadhaar ?? null;
                                $addadmission->guardian_name = array_key_exists('guardian_name', $student) ?  $student['guardian_name'] ?? '' : $addadmission->guardian_name ?? null;
                                $addadmission->guardian_mobile = array_key_exists('guardian_mobile', $student) ?  $student['guardian_mobile'] ?? '' : $addadmission->guardian_mobile ?? null;
                                $addadmission->admission_type_id = array_key_exists('admission_type_id', $student) ?  $student['admission_type_id'] ?? '' : $addadmission->admission_type_id ?? null;
                                $addadmission->bus_number = array_key_exists('bus_number', $student) ?  $student['bus_number'] ?? '' : $addadmission->bus_number ?? null;
                                $addadmission->bus_route = array_key_exists('bus_route', $student) ?  $student['bus_route'] ?? '' : $addadmission->bus_route ?? null;
                                $addadmission->stoppage = array_key_exists('stoppage', $student) ?  $student['stoppage'] ?? '' : $addadmission->stoppage ?? null;
                                $addadmission->transpor_charges = array_key_exists('transpor_charges', $student) ?  $student['transpor_charges'] ?? '' : $addadmission->transpor_charges ?? null;
                                $addadmission->bank_name = array_key_exists('bank_name', $student) ?  $student['bank_name'] ?? '' : $addadmission->bank_name ?? null;
                                $addadmission->bank_account = array_key_exists('bank_account', $student) ?  $student['bank_account'] ?? '' : $addadmission->bank_account ?? null;
                                $addadmission->branch_name = array_key_exists('branch_name', $student) ?  $student['branch_name'] ?? '' : $addadmission->branch_name ?? null;
                                $addadmission->ifsc = array_key_exists('ifsc', $student) ?  $student['ifsc'] ?? '' : $addadmission->ifsc ?? null;
                                $addadmission->micr_code = array_key_exists('micr_code', $student) ?  $student['micr_code'] ?? '' : $addadmission->micr_code ?? null;
                                $addadmission->remark_1 = array_key_exists('remark_1', $student) ?  $student['remark_1'] ?? '' : $addadmission->remark_1 ?? null;
                                $addadmission->admission_date =   array_key_exists('admission_date', $student) ?  $student['admission_date'] ?? '' : $addadmission->admission_date ?? null;
                                $addadmission->transport = array_key_exists('transport', $student) ?  $student['transport'] ?? '' : $addadmission->transport ?? null;
                                $addadmission->bank_account_holder = array_key_exists('bank_account_holder', $student) ?  $student['bank_account_holder'] ?? '' : $addadmission->bank_account_holder ?? null;
                                $addadmission->optional_subject = array_key_exists('optional_subject', $student) ?  $student['optional_subject'] ?? '' : $addadmission->optional_subject ?? null;
                                $addadmission->urban = array_key_exists('urban', $student) ?  $student['urban'] ?? '' : $addadmission->urban ?? null;
                                $addadmission->district = array_key_exists('district', $student) ?  $student['district'] ?? '' : $addadmission->district ?? null;
                                $addadmission->tehsil = array_key_exists('tehsil', $student) ?  $student['tehsil'] ?? '' : $addadmission->tehsil ?? null;
                                $addadmission->father_pancard = array_key_exists('father_pancard', $student) ?  $student['father_pancard'] ?? '' : $addadmission->father_pancard ?? null;
                                $addadmission->mother_pancard = array_key_exists('mother_pancard', $student) ?  $student['mother_pancard'] ?? '' : $addadmission->mother_pancard ?? null;
                                $addadmission->income_tax_payee_father = array_key_exists('income_tax_payee_father', $student) ?  $student['income_tax_payee_father'] ?? '' : $addadmission->income_tax_payee_father ?? null;
                                $addadmission->income_tax_payee_mother = array_key_exists('income_tax_payee_mother', $student) ?  $student['income_tax_payee_mother'] ?? '' : $addadmission->income_tax_payee_mother ?? null;
                                $addadmission->bpl = array_key_exists('bpl', $student) ?  $student['bpl'] ?? '' : $addadmission->bpl ?? null;
                                $addadmission->bpl_certificate_no = array_key_exists('bpl_certificate_no', $student) ?  $student['bpl_certificate_no'] ?? '' : $addadmission->bpl_certificate_no ?? null;
                                $addadmission->father_occupation = array_key_exists('father_occupation', $student) ?  $student['father_occupation'] ?? '' : $addadmission->father_occupation ?? null;
                                $addadmission->mother_occupation = array_key_exists('mother_occupation', $student) ?  $student['mother_occupation'] ?? '' : $addadmission->mother_occupation ?? null;
                                $addadmission->save();
                            }
                                // DB::table('admissions')->insert($data);
                        }   
                    catch (Exception $e) {
                        $error_code = $e->errorInfo[1];
                        return redirect('admissionAdd')->with('error', 'Error Student Not Added !');
                    }
                return redirect('admissionView')->with('message', 'Student Add Successful !');
            }

            function indexToColumnName($index) {
                $columnName = '';
                    while ($index >= 0) {
                        $columnName = chr(($index % 26) + 65) . $columnName;
                        $index = intdiv($index, 26) - 1;
                    }
                return $columnName;
            }

            function columnLetterToNumber($columnLetter) {
                $columnNumber = 0;
                $length = strlen($columnLetter);
                    for ($i = 0; $i < $length; $i++) {
                        $columnNumber = $columnNumber * 26 + (ord($columnLetter[$i]) - ord('A') + 1);
                    }
                return $columnNumber;
            }
            
            public function studentExcelAdd(Request $request){   
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
                return redirect('admissionAdd')->with('error', 'Error Student Not Added !');
                }
                return redirect('admissionView')->with('message', 'Student Add Successful !');
            }

            public function studentProfile(Request $request, $id){
                $data = Admission::find($id);
                $feesDetail = FeesMaster::where('class_type_id')->get();
                   return view('sprofile.studentprofile', ['data' => $data, 'feesDetail' => $feesDetail]);
            }
    
            public function getStreamSubjects(Request $request){
                $data = Subject::where('class_type_id',$request->class_type_id)->get();
                return $data;
            }

            public function admissionAdd(Request $request){
                $BillCounter = BillCounter::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('type', 'StudentAdmission')->get()->first();
                    if (!empty($BillCounter)) {
                        $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0;
                        $BillCounterNo = $counter + 1;
                    }
                    if ($request->isMethod('post')) {
                        $sessionId =   Session::get('session_id');
                            $request->validate([
                                //'admissionNo' => 'nullable|unique:admissions',
                                //'aadhaar' => 'unique:admissions,aadhaar',
                                //'mobile' => 'unique:admissions,mobile',
                            ]);
                            $Student = Enquiry:: where('registration_no',$request->registration_id)->update(['status'=>1]);
                        $student_image = '';
                    if ($request->file('student_img')) {
                        $image = $request->file('student_img');
                        $student_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    if (isset($data->image) && File::exists($destinationPath . $data->image)) {
                        File::delete($destinationPath . $data->image);
                    }
                    $compressedImage = Image::make($image)
                        ->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('jpg', 80); // Adjust quality as needed
                        $compressedImage->save($destinationPath . $student_image);
                        $image->move($destinationPath, $student_image);
                    }
                    /*$student_image = '';
                    if ($request->file('student_img')) {
                        $image = $request->file('student_img');
                        $path = $image->getRealPath();
                        $student_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile';
                        $image->move($destinationPath, $student_image);
                    }*/
                    $father_image = '';
                    if ($request->file('father_img')) {
                        $image = $request->file('father_img');
                        $father_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'father_image/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    if (isset($data->father_image) && File::exists($destinationPath . $data->father_image)) {
                        File::delete($destinationPath . $data->father_image);
                    }
                    $compressedImage = Image::make($image)
                        ->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('jpg', 80); // Adjust quality as needed
                        $compressedImage->save($destinationPath . $father_image);
                        $image->move($destinationPath, $father_image);
                    }
                    /*$father_image = '';
                    if ($request->file('father_img')) {
                        $image = $request->file('father_img');
                        $path = $image->getRealPath();
                        $father_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'father_image';
                        $image->move($destinationPath, $father_image);
                    }*/
                    $mother_image = '';
                    if ($request->file('mother_img')) {
                        $image = $request->file('mother_img');
                        $mother_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'mother_image/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
                    if (isset($data->mother_img) && File::exists($destinationPath . $data->mother_img)) {
                        File::delete($destinationPath . $data->mother_img);
                    }
                    $compressedImage = Image::make($image)
                        ->resize(600, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->encode('jpg', 80); // Adjust quality as needed
                        $compressedImage->save($destinationPath . $mother_image);
                        $image->move($destinationPath, $mother_image);
                    }
                    /*$mother_image = '';
                    if ($request->file('mother_img')) {
                        $image = $request->file('mother_img');
                        $path = $image->getRealPath();
                        $mother_image = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'mother_image';
                        $image->move($destinationPath, $mother_image);
                    }*/
                        $counter = !empty($BillCounter->counter) ? $BillCounter->counter : 0;
                        $BillCounter->counter = $counter + 1;
                        $BillCounter->save();
                        $addadmission = new Admission(); //model name
                        $addadmission->user_id = Session::get('id');
                        $addadmission->session_id = Session::get('session_id');
                        $addadmission->branch_id = Session::get('branch_id');
                        $addadmission->admissionNo = $request->admissionNo;
                        $addadmission->ledger_no = $request->ledger_no;
                        $addadmission->school = '1';
                        $addadmission->library = '0';
                        $addadmission->hostel = '0';
                        $addadmission->roll_no = $request->roll_no;
                        $addadmission->admission_date = $request->admission_date;
                        $addadmission->admission_type_id = $request->admission_type_id;
                        $addadmission->rte_student = $request->rte_student;
                        $addadmission->class_type_id = $request->class_type_id;
                            if(!empty($request->stream_subject)){
                                $addadmission->stream_subject = implode(',', $request->stream_subject);
                            }
                            $course_name = $request->course;
                            if (empty($course_name) && !empty($request->class_type_id)) {
                                $cType = ClassType::find($request->class_type_id);
                                if ($cType && !empty($cType->course_id)) {
                                    $crs = \App\Models\Master\Course::find($cType->course_id);
                                    if ($crs) {
                                        $course_name = $crs->name;
                                    }
                                }
                            }
                            $addadmission->course = $course_name;
                            $addadmission->student_type = $request->student_type;
                            $addadmission->batch = $request->batch;
                            $addadmission->first_name = $request->first_name;
                            $addadmission->last_name = $request->last_name;
                            $addadmission->aadhaar = $request->aadhaar;
                            $addadmission->jan_aadhaar = $request->jan_aadhaar;
                            $addadmission->previous_school = $request->previous_school;
                            $addadmission->email = $request->email;
                            $addadmission->mobile = $request->mobile;
                            $addadmission->father_name = $request->father_name;
                            $addadmission->mother_name = $request->mother_name;
                            $addadmission->father_mobile = $request->father_mobile;
                            $addadmission->dob = $request->dob;
                            $addadmission->relation_student = $request->relation_student;
                            $addadmission->school_namestudied_last_year = $request->school_namestudied_last_year;
                            $addadmission->house = $request->house;
                            $addadmission->height = $request->height;
                            $addadmission->weight = $request->weight;
                            $addadmission->gender_id = $request->gender_id;
                            $addadmission->admission_type_id = $request->admission_type_id;
                            $addadmission->blood_group = $request->blood_group;
                            $addadmission->medium = $request->medium;
                            $addadmission->address = $request->address;
                            $addadmission->country_id = $request->country;
                            $addadmission->village_city = $request->village_city;
                            $addadmission->city_id = $request->city;
                            $addadmission->state_id = $request->state;
                            $addadmission->pincode = $request->pincode;
                            $addadmission->family_id = $request->family_id;
                            $addadmission->srn = $request->srn;
                            $addadmission->religion = $request->religion;
                            // $addadmission->nationalty = $request->nationalty;
                            $addadmission->category = $request->category;
                            $addadmission->caste_category = $request->caste_category;
                            $addadmission->transport = null;
                            $addadmission->bus_number = null;
                            $addadmission->bus_route = null;
                            $addadmission->stoppage = null;
                            $addadmission->transpor_charges = null;
                            $addadmission->guardian_name = $request->guardian_name;
                            $addadmission->guardian_mobile = $request->guardian_mobile;
                            $addadmission->mother_mob = $request->mother_mob;
                            $addadmission->father_aadhaar = $request->father_aadhaar;
                            $addadmission->mother_aadhaar = $request->mother_aadhaar;
                            $addadmission->family_annual_income = $request->family_annual_income;
                            $addadmission->bank_account = $request->bank_account;
                            $addadmission->bank_name = $request->bank_name;
                            $addadmission->branch_name = $request->branch_name;
                            $addadmission->ifsc = $request->ifsc;
                            $addadmission->micr_code = $request->micr_code;
                            $addadmission->image = $student_image;
                            $addadmission->father_img = $father_image;
                            $addadmission->mother_img = $mother_image;
                            $addadmission->remark_1 = $request->remark_1;
                            $addadmission->bank_account_holder = $request->bank_account_holder;
                            $addadmission->optional_subject = $request->optional_subject;
                            $addadmission->urban = $request->urban;
                            $addadmission->district = $request->district;
                            $addadmission->tehsil = $request->tehsil;
                            $addadmission->father_pancard = $request->father_pancard;
                            $addadmission->mother_pancard = $request->mother_pancard;
                            $addadmission->income_tax_payee_father = $request->income_tax_payee_father;
                            $addadmission->income_tax_payee_mother = $request->income_tax_payee_mother;
                            $addadmission->bpl = $request->bpl;
                            $addadmission->bpl_certificate_no = $request->bpl_certificate_no;
                            $addadmission->father_occupation = $request->father_occupation;
                            $addadmission->mother_occupation = $request->mother_occupation;
                            $addadmission->password = Hash::make($request->admissionNo);
                            $addadmission->confirm_password = $request->admissionNo;
                            $status = 1;
                            if(($request->newStudentRegistration ?? '') == 'newStudentRegistration'){
                                $status = 'newStudentRegistration';
                            }
                            $addadmission->status = $status;
                            
                            $class_name = ClassType::find($request->class_type_id);
                            $initials = substr($request->first_name, 0, 3);
                            $birthYear = date('Y', strtotime($request->dob));
                            $random_number = Str::random(10);
                            $cleanedMobile = preg_replace('/[^0-9]/', '', $request->mobile ?? $random_number);
                            $username = strtoupper($initials).strtoupper($class_name->name).substr($cleanedMobile, -3);
                            $addadmission->userName = strtoupper(str_replace(' ', '', $request->first_name)) . $request->admissionNo;
                            $addadmission->save();
                            
                            $addadmission_id = $addadmission->id;
                            $this->unique_system_id($addadmission_id);
                            
                            $feesGroupId = null;
                            if (!empty($request->fees_master_id) && is_array($request->fees_assign)) {
                                $feesGroup = new FeesAssign();
                                $feesGroup->user_id = Session::get('id');
                                $feesGroup->session_id = Session::get('session_id');
                                $feesGroup->branch_id = Session::get('branch_id');
                                $feesGroup->admission_id = $addadmission_id;
                                $feesGroup->save();
                                $feesGroupId = $feesGroup->id;
                    
                                $assign_count = 0;
                                $fees_group_amount = 0;
                                $fees_group_discount = 0;
                                
                                for ($count = 0; $count < count($request->fees_master_id); $count++) {
                                    if (in_array($request->fees_master_id[$count], $request->fees_assign)) {
                                        $feesGroupDetail = new FeesAssignDetail(); // model name
                                        $feesGroupDetail->user_id = Session::get('id');
                                        $feesGroupDetail->session_id = Session::get('session_id');
                                        $feesGroupDetail->branch_id = Session::get('branch_id');
                                        $feesGroupDetail->fees_group_id = $request->fees_group_id[$count];
                                        $feesGroupDetail->fees_master_id = $request->fees_assign[$assign_count];
                                        $feesGroupDetail->fees_group_amount = $request->fees_group_amount[$count];
                                        $feesGroupDetail->class_type_id = $request->class_type_id ?? null;
                                        $fees_group_amount += $request->fees_group_amount[$count];
                                        $feesGroupDetail->discount = $request->discount[$count];
                                        $fees_group_discount += $request->discount[$count];
                                        $feesGroupDetail->fees_breakdown = $request->fees_breakdown[$count];
                                        $feesGroupDetail->fees_assign_id = $feesGroupId;
                                        $feesGroupDetail->admission_id = $addadmission_id;
                                        $feesGroupDetail->save();
                                        $assign_count++;
                                    }
                                }
                             
                                $feesGroup->total_amount = $fees_group_amount;
                                $feesGroup->total_discount = $fees_group_discount;
                                $feesGroup->net_amount = $fees_group_amount - $fees_group_discount;
                                $feesGroup->save();
                            }
                           
                        //     $template =  MessageTemplate::Select('message_templates.*','message_types.slug')
                        //     ->leftjoin('message_types','message_types.id','message_templates.message_type_id')
                        //     ->where('message_types.status',1)->where('message_types.slug','student-admission')->first();
                        //     $branch = Branch::find(Session::get('branch_id'));
                        //     $setting = Setting::where('branch_id',Session::get('branch_id'))->first();
                        //     $arrey1 =   array(
                        //                 '{#name#}',
                        //                 '{#school_name#}',
                        //                 '{#user_name#}',
                        //                 '{#password#}',
                        //                 '{#email#}',
                        //                 '{#mobile#}',);
                        //     $arrey2 = array(
                        //                     $addadmission->first_name." ".$addadmission->last_name,
                        //                     $setting->name,
                        //                     $addadmission->userName,
                        //                     $addadmission->confirm_password,
                        //                     $addadmission->email,
                        //                     $addadmission->mobile);
                        // if($template->status != 1){
                        //         if($request->email != ""){
                        //             if($branch->email_srvc != 0){
                        //                 if($template->email_status != 0){
                        //                     $message = str_replace($arrey1,$arrey2,$template->email_content);
                        //                     $emailData = ['email' => $request->email, 'data' => $message, 'subject' => $template->title];
                        //                     Helper::sendMail('email_print.template_print', $emailData);
                        //                 } 
                        //             } 
                        //         }
                                
                        //     if($branch->whatsapp_srvc != 0){
                        //         if ($request->mobile != ""){
                        //             if($template->whatsapp_status != 0){
                        //                 $whatsapp = str_replace($arrey1,$arrey2,$template->whatsapp_content);
                        //                 Helper::sendWhatsappMessage($request->mobile,$whatsapp);
                        //             }
                        //         }
                        //     }
                        //     if($branch->sms_srvc != 0){
                        //         if($request->mobile != ""){
                        //             if($template->sms_status != 0){
                        //                 $sms = str_replace($arrey1,$arrey2,$template->sms_content);
                        //                 Helper::SendMessage($request->mobile, $sms);
                        //             }
                        //         }
                        //     }    
                        // }
                        $url = '/admissionStudentIdPrint/'.$addadmission->id;
                    ?>
                        <script type="text/javascript">
                            window.open("<?=$url?>", "_blank");
                        </script>
                    <?php        
                    return redirect::to('admissionView')->with('message', 'Admission Successful.');
                }
                return view('students.admission.add', ['BillCounter' => $BillCounterNo]);
            }

            public function admissionView(Request $request){
                $generate_user_name = $request->generate_user_name ?? '';
                    // if($generate_user_name != ''){
                    //     //$this->studentUserNameCreate();  
                    // }
                    $search['session_id'] = $request->has('session_id') ? $request->session_id : Session::get('session_id');
                    $search['admissionNo'] = $request->admissionNo;
                    $search['course'] = $request->course;
                    $search['class_type_id'] = $request->class_type_id;
                    $search['state_id'] = $request->state_id;
                    $search['city_id'] = $request->city_id;
                    $search['category'] = $request->category;
                    $search['gender_id'] = $request->gender_id;
                    $search['admission_type_id'] = $request->admission_type_id;
                    $search['blood_group'] = $request->blood_group;
                    $search['transport'] = $request->transport;
                    $search['status'] = $request->status;
                    $search['name'] = $request->name;
                    $search['batch'] = $request->batch;

                    $data = Admission::select('admissions.*','class.name as class_name')
                        ->leftJoin('class_types as class','class.id','admissions.class_type_id')
                        ->orderBy('class.orderBy', 'ASC')->with('City')->with('State');
                    $data = $data->where('admissions.branch_id', Session::get('branch_id'));
                    if (!empty($search['session_id'])) {
                        $data = $data->where('admissions.session_id', $search['session_id']);
                    }
                    if (Session::get('role_id') == 2) {
                        $data = $data->where('admissions.class_type_id', $request->class_type_id);
                    }
                    
                    if ($request->isMethod('post')) {
                        if ($request->name != '') {
                            $value = $request->name;
                            $data = $data->where(function ($query) use ($value) {
                                $query->where('first_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('last_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('father_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('mother_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('mobile', 'LIKE', '%' . $value . '%');
                                $query->orWhere('email', 'LIKE', '%' . $value . '%');
                                $query->orWhere('aadhaar', 'LIKE', '%' . $value . '%');
                                $query->orWhere('jan_aadhaar', 'LIKE', '%' . $value . '%');
                                $query->orWhere('previous_school', 'LIKE', '%' . $value . '%');
                                $query->orWhere('address', 'LIKE', '%' . $value . '%');
                                $query->orWhere('ledger_no', 'LIKE', '%' . $value . '%');
                                $query->orWhere('srn', 'LIKE', '%' . $value . '%');
                                $query->orWhere('dob', 'LIKE', '%' . $value . '%');
                                $query->orWhere('village_city', 'LIKE', '%' . $value . '%');
                                $query->orWhere('address', 'LIKE', '%' . $value . '%');
                                $query->orWhere('pincode', 'LIKE', '%' . $value . '%');
                                $query->orWhere('caste_category', 'LIKE', '%' . $value . '%');
                                $query->orWhere('house', 'LIKE', '%' . $value . '%');
                                $query->orWhere('height', 'LIKE', '%' . $value . '%');
                                $query->orWhere('weight', 'LIKE', '%' . $value . '%');
                                $query->orWhere('family_annual_income', 'LIKE', '%' . $value . '%');
                                $query->orWhere('family_id', 'LIKE', '%' . $value . '%');
                                $query->orWhere('religion', 'LIKE', '%' . $value . '%');
                                $query->orWhere('category', 'LIKE', '%' . $value . '%');
                                $query->orWhere('father_mobile', 'LIKE', '%' . $value . '%');
                                $query->orWhere('father_aadhaar', 'LIKE', '%' . $value . '%');
                                $query->orWhere('mother_mob', 'LIKE', '%' . $value . '%');
                                $query->orWhere('mother_aadhaar', 'LIKE', '%' . $value . '%');
                                $query->orWhere('guardian_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('guardian_mobile', 'LIKE', '%' . $value . '%');
                                $query->orWhere('bus_number', 'LIKE', '%' . $value . '%');
                                $query->orWhere('bus_route', 'LIKE', '%' . $value . '%');
                                $query->orWhere('stoppage', 'LIKE', '%' . $value . '%');
                                $query->orWhere('transpor_charges', 'LIKE', '%' . $value . '%');
                                $query->orWhere('bank_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('bank_account', 'LIKE', '%' . $value . '%');
                                $query->orWhere('branch_name', 'LIKE', '%' . $value . '%');
                                $query->orWhere('ifsc', 'LIKE', '%' . $value . '%');
                                $query->orWhere('micr_code', 'LIKE', '%' . $value . '%');
                                $query->orWhere('remark_1', 'LIKE', '%' . $value . '%');
                                $query->orWhere('admission_date', 'LIKE', '%' . $value . '%');
                            });
                        }
                        if ($request->admissionNo != '') {
                            $data = $data->where("admissionNo", $request->admissionNo);
                        }
                       
                        if ($request->batch != '') {
                            $data = $data->where("batch", $request->batch);
                        }
                        if ($request->course != '') {
                            $data = $data->where("admissions.course", $request->course);
                        }
                        if ($request->class_type_id != '') {
                            $data = $data->where("class_type_id", $request->class_type_id);
                        }
                        if ($request->state_id != '') {
                            $data = $data->where("state_id", $request->state_id);
                        }
                        if ($request->city_id != '') {
                            $data = $data->where("city_id", $request->city_id);
                        }
                        if ($request->category != '') {
                            $data = $data->where("category", $request->category);
                        }
                        if ($request->gender_id != '') {
                            $data = $data->where("gender_id", $request->gender_id);
                        }
                        if ($request->admission_type_id != '') {
                            $data = $data->where("admission_type_id", $request->admission_type_id);
                        }
                        if ($request->blood_group != '') {
                            $data = $data->where("blood_group", $request->blood_group);
                        }
                        if ($request->transport != '') {
                            $data = $data->where("transport", $request->transport);
                        }
                        if ($request->status != '') {
                            $data = $data->where("status", $request->status);
                        }else
                        {
                            $data = $data->where("status", 1);
                        }
                        $alladmission = $data->where('school',1)->orderBy('first_name')->get();
                        return view('students.admission.view', ['data' => $alladmission, 'search' => $search]);
                    }
                $alladmission = $data->where('school',1)->orderBy('first_name')->where('status',1)->get();
              
                return view('students.admission.view', ['data' => $alladmission, 'search' => $search]);
            }
            
            public function admissionView2(Request $request){
                // dd($request);
                $search['admissionNo'] = $request->admissionNo;
                $search['class_type_id'] = $request->class_type_id;
                $search['state_id'] = $request->state_id;
                $search['city_id'] = $request->city_id;
                $search['name'] = $request->name;
                // $alladmission = Admission::orderBy('first_name', 'ASC')->where('session_id', Session::get('session_id'));
                $alladmission = Admission::select('admissions.*','class.name as class_name')
                    ->leftJoin('class_types as class','class.id','admissions.class_type_id')->orderBy('admissions.first_name', 'ASC')->where('admissions.session_id', Session::get('session_id'));
                    if (Session::get('role_id') > 1) {
                        $alladmission = $alladmission->where('admissions.branch_id', Session::get('branch_id'));
                    }
                $alladmission =  $alladmission->get();
                //dd($search);
                return view('students.admission.view_2', ['data' => $alladmission, 'search' => $search]);
            }

            public function admissionEdit(Request $request, $id){
                $data = Admission::find($id);
                    if ($request->isMethod('post')) {
                        $update_n_next = $request->update ?? '';
                        $sessionId = Session::get('session_id');
                        $request->validate([
                            // 'admissionNo' => ['nullable',Rule::unique('admissions')->where(function ($query) use ($sessionId) {
                            // $query->where('session_id', $sessionId);})->ignore($id)],
                            // 'aadhaar' => 'unique:admissions,aadhaar',
                            // 'mobile' => 'unique:admissions,mobile',
                        ]);
                        if ($request->file('student_img')) {
                            $image = $request->file('student_img');
                            $student_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                            $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile/';
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            if (isset($data->image) && File::exists($destinationPath . $data->image)) {
                                File::delete($destinationPath . $data->image);
                            }
                                $compressedImage = Image::make($image)
                                    ->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->encode('jpg', 80); // Adjust quality as needed
                            $compressedImage->save($destinationPath . $student_image);
                            $data->image = $student_image;
                        }
                
                        if ($request->file('father_img')) {
                            $image = $request->file('father_img');
                            $father_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                            $destinationPath = env('IMAGE_UPLOAD_PATH') . 'father_image/';
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            if (isset($data->father_image) && File::exists($destinationPath . $data->father_image)) {
                                File::delete($destinationPath . $data->father_image);
                            }
                            $compressedImage = Image::make($image)
                                ->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->encode('jpg', 80); // Adjust quality as needed
                            $compressedImage->save($destinationPath . $father_image);
                            $data->father_img = $father_image;
                        }
                        if ($request->file('mother_img')) {
                            $image = $request->file('mother_img');
                            $mother_image = time() . uniqid() . '.' . $image->getClientOriginalExtension();
                            $destinationPath = env('IMAGE_UPLOAD_PATH') . 'mother_image/';
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            if (isset($data->mother_img) && File::exists($destinationPath . $data->mother_img)) {
                                File::delete($destinationPath . $data->mother_img);
                            }
                            $compressedImage = Image::make($image)
                            ->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->encode('jpg', 80); // Adjust quality as needed
                            $compressedImage->save($destinationPath . $mother_image);
                            $data->mother_img = $mother_image;
                        }
                        /*if ($request->file('father_img')) {
                            $image = $request->file('father_img');
                            $path = $image->getRealPath();
                            $father_image = time() . uniqid() . $image->getClientOriginalName();
                            $destinationPath = env('IMAGE_UPLOAD_PATH') . 'father_image';
                            $image->move($destinationPath, $father_image);
                            $data->father_img = $father_image;
                        }
            
                        if ($request->file('mother_img')) {
                            $image = $request->file('mother_img');
                            $path = $image->getRealPath();
                            $mother_image = time() . uniqid() . $image->getClientOriginalName();
                            $destinationPath = env('IMAGE_UPLOAD_PATH') . 'mother_image';
                            $image->move($destinationPath, $mother_image);
                            $data->mother_img = $mother_image;
                        }*/
                        $data->user_id = Session::get('id');
                        $data->session_id = Session::get('session_id');
                        $data->branch_id = Session::get('branch_id');
                      //  $data->admissionNo = $request->admissionNo;
                        $data->ledger_no = $request->ledger_no;
                        //$data->school_name = $request->school_name;
                        $data->roll_no = $request->roll_no;
                        $data->admission_date = $request->admission_date;
                        $data->admission_type_id = $request->admission_type_id;
                        $data->rte_student = $request->rte_student;
                        $data->class_type_id = $request->class_type_id;
                        if(!empty($request->stream_subject)){
                            $data->stream_subject = implode(',', $request->stream_subject);
                        }
                        $course_name = $request->course;
                        if (empty($course_name) && !empty($request->class_type_id)) {
                            $cType = ClassType::find($request->class_type_id);
                            if ($cType && !empty($cType->course_id)) {
                                $crs = \App\Models\Master\Course::find($cType->course_id);
                                if ($crs) {
                                    $course_name = $crs->name;
                                }
                            }
                        }
                        $data->course = $course_name;
                        $data->student_type = $request->student_type;
                        $data->batch = $request->batch;
                        $data->first_name = $request->first_name;
                        $data->last_name = $request->last_name;
                        $data->aadhaar = $request->aadhaar;
                        $data->jan_aadhaar = $request->jan_aadhaar;
                        $data->previous_school = $request->previous_school;
                        $data->email = $request->email;
                        $data->mobile = $request->mobile;
                        $data->father_name = $request->father_name;
                        $data->mother_name = $request->mother_name;
                        $data->father_mobile = $request->father_mobile;
                        $data->dob = $request->dob;
                        $data->gender_id = $request->gender_id;
                        $data->admission_type_id = $request->admission_type_id;
                        $data->blood_group = $request->blood_group;
                        $data->medium = $request->medium;
                        $data->address = $request->address;
                        $data->country_id = $request->country;
                        $data->village_city = $request->village_city;
                        $data->family_id = $request->family_id;
                        $data->srn = $request->srn;
                        $data->religion = $request->religion;
                        // $data->nationalty = $request->nationalty;
                        $data->category = $request->category;
                        $data->caste_category = $request->caste_category;
                        $data->transport = $request->transport;
                        $data->bus_number = $request->bus_number;
                        $data->bus_route = $request->bus_route;
                        $data->stoppage = $request->stoppage;
                        $data->transpor_charges = $request->transpor_charges;
                        $data->guardian_name = $request->guardian_name;
                        $data->guardian_mobile = $request->guardian_mobile;
                        $data->mother_mob = $request->mother_mob;
                        $data->father_aadhaar = $request->father_aadhaar;
                        $data->mother_aadhaar = $request->mother_aadhaar;
                        $data->family_annual_income = $request->family_annual_income;
                        $data->bank_account = $request->bank_account;
                        $data->bank_name = $request->bank_name;
                        $data->branch_name = $request->branch_name;
                        $data->ifsc = $request->ifsc;
                        $data->micr_code = $request->micr_code;
                        $data->city_id = $request->city;
                        $data->state_id = $request->state;
                        $data->relation_student = $request->relation_student;
                        $data->school_namestudied_last_year = $request->school_namestudied_last_year;
                        $data->house = $request->house;
                        $data->height = $request->height;
                        $data->weight = $request->weight;
                        $data->pincode = $request->pincode;
                        $data->remark_1 = $request->remark_1;
                        $data->bank_account_holder = $request->bank_account_holder;
                        $data->optional_subject = $request->optional_subject;
                        $data->urban = $request->urban;
                        $data->district = $request->district;
                        $data->tehsil = $request->tehsil;
                        $data->father_pancard = $request->father_pancard;
                        $data->mother_pancard = $request->mother_pancard;
                        $data->income_tax_payee_father = $request->income_tax_payee_father;
                        $data->income_tax_payee_mother = $request->income_tax_payee_mother;
                        $data->bpl = $request->bpl;
                        $data->bpl_certificate_no = $request->bpl_certificate_no;
                        $data->father_occupation = $request->father_occupation;
                        $data->mother_occupation = $request->mother_occupation;
                        /*$session = Sessions::where('id',Session::get('session_id'))->first();
                        $initials = substr($request->first_name, 0, 4);
                        $birthYear = date('Y', strtotime($request->dob));
                        $cleanedMobile = preg_replace('/[^0-9]/', '', $request->mobile);*/
                        /*$username = 'Green_'.strtoupper($initials)  .'_'. substr($cleanedMobile, -4).'_'.$session->from_year;
                        $data->userName = $username;
                        $data->password = Hash::make('12345678');
                        $data->confirm_password = '12345678';*/
                        $data->save();
                        $addadmission_id = $id;
                        $this->unique_system_id($id);
                        //     if($request->admission_type_id == 1){
                        //     // $feesGroup = FeesAssign::where('admission_id', $id)->first();
                        //     // if(!empty($feesGroup)){
                        //     //     $feesGroup = $feesGroup;
                        //     // }else{
                        //     //     $feesGroup  = new FeesAssign();
                        //     // }
                        //     // $feesGroup->user_id = Session::get('id');
                        //     // $feesGroup->session_id = Session::get('session_id');
                        //     // $feesGroup->branch_id = Session::get('branch_id');
                        //     // $feesGroup->admission_id = $addadmission_id;
                        //     // // $feesGroup->total_amount = $request->total_amount;
                        //     // //$feesGroup->dis_on_total_amt = $request->great_discount;
                        //     // // $feesGroup->total_discount = $request->net_discount;
                        //     // // $feesGroup->net_amount = $request->pay_amt;
                        //     // $feesGroup->save();
                        // //     $feesGroupId = $feesGroup->id;
                        // //     $feesDetail_ids;
                        // //   $fees_group_amount = 0;
                        // //   $fees_group_discount = 0;
                        // //  //  dd($request->unchecked);
                        // //     if ($request->checked != "")
                        // //     {
                        // //         $checked_values = explode(',', $request->checked);
                        // //         for ($count = 0; $count < count($request->fees_master_id); $count++) {
                        // //             if (in_array($request->fees_master_id[$count], $checked_values))
                        // //             {
                        // //             // if (isset($request->fees_master_id[$count])) {
                        // //                 $feesGroupDetail = FeesAssignDetail::where('fees_master_id',$request->fees_master_id[$count])->where('admission_id',$addadmission_id)->first();
                        // //                 if(!empty($feesGroupDetail))
                        // //                 {
                        // //                      $feesDetail_ids[] = $request->fees_master_id[$count];
                        // //                 $feesGroupDetail->user_id = Session::get('id');
                        // //                 $feesGroupDetail->session_id = Session::get('session_id');
                        // //                 $feesGroupDetail->branch_id = Session::get('branch_id');
                        // //                 $feesGroupDetail->fees_group_id = $request->fees_group_id[$count];
                        // //                 $feesGroupDetail->fees_group_amount = $request->fees_group_amount[$count];
                        // //                 $fees_group_amount +=$request->fees_group_amount[$count];
                        // //                 $feesGroupDetail->fees_master_id = $request->fees_master_id[$count];
                        // //                 $feesGroupDetail->discount = $request->discount[$count];
                        // //                 $fees_group_discount += $request->discount[$count];
                        // //                 $feesGroupDetail->fees_breakdown = $request->fees_breakdown[$count];
                        // //                 $feesGroupDetail->fees_assign_id = $feesGroupId;
                        // //                 $feesGroupDetail->admission_id = $addadmission_id;
                        // //                 $feesGroupDetail->save();
                        // //                 }
                        // //                 else
                        // //                 {
                        // //                 $feesDetails = new FeesAssignDetail;
                        // //                 $feesDetails->user_id = Session::get('id');
                        // //                 $feesDetails->session_id = Session::get('session_id');
                        // //                 $feesDetails->branch_id = Session::get('branch_id');
                        // //                 $feesDetails->fees_group_id = $request->fees_group_id[$count];
                        // //                 $feesDetails->fees_group_amount = $request->fees_group_amount[$count];
                        // //                 $feesDetails->class_type_id = $request->class_type_id ?? null;
                        // //                 $fees_group_amount +=$request->fees_group_amount[$count];
                        // //                 $feesDetails->fees_master_id = $request->fees_master_id[$count];
                        // //                 $feesDetails->discount = $request->discount[$count];
                        // //                 $fees_group_discount += $request->discount[$count];
                        // //                 $feesDetails->fees_breakdown = $request->fees_breakdown[$count];
                        // //                 $feesDetails->fees_assign_id = $feesGroupId;
                        // //                 $feesDetails->admission_id = $addadmission_id;
                        // //                 $feesDetails->save();
                        // //                  $feesDetail_ids[] = $feesDetails->fees_master_id;
                        // //                 }
                        // //                 // }
                        // //          }
                        // //     }
                        // //         }
                        //         // if ($request->unchecked != "")
                        //         // {
                        //         //       $unchecked_values = explode(',', $request->unchecked);
                        //         // foreach($unchecked_values as $id) 
                        //         //  {
                        //         //   $feesDetailsDataForDelete = FeesAssignDetail::where('admission_id',$addadmission_id)->where('fees_master_id',$id)->delete();    
                        //         //  }  
                        //         // }
                        //         // $feesGroup->total_amount =$fees_group_amount;
                        //         // $feesGroup->total_discount = $fees_group_discount;
                        //         // $feesGroup->net_amount = $fees_group_amount-$fees_group_discount;
                        //         //   $feesGroup->save();
                        //     }
                        //     else if($request->admission_type_id == 2)
                        //     {
                        //          FeesAssignDetail::where('admission_id',$id)->delete();  
                        //          FeesAssign::where('admission_id',$id)->delete();  
                        //          FeesCollect::where('admission_id',$id)->delete();  
                        //          FeesDetail::where('admission_id',$id)->delete();  
                        //     }
                        $value = Session::get('update_n_next_value');
                        if($request->update == ""){
                            
                            return redirect::to('admissionView')->with('message', 'Admission Updated Successfully !');
                        }else{
                            session()->put('update_n_next_value', $value.','.$addadmission_id);
                            session()->save();
                            $updated_id = explode(',',Session::get('update_n_next_value'));
                            $next_id = Admission::whereNotIn('id',$updated_id)->where('class_type_id',$request->class_type_id)
                            ->where('session_id',Session::get('session_id'))
                            ->where('branch_id',Session::get('branch_id'))
                            ->get();
                        if(count($next_id) > 0){
                            return redirect::to('admissionEdit/'.$next_id[0]->id ?? '')->with('message', 'Admission Edit For : '.$next_id[0]->first_name ?? '');
                        }
                        else{
                            return redirect::to('admissionView')->with('error', 'No more students for update in this class!');
                        }
                    }
                }
                $getstate = State::where('country_id', $data['country_id'])->get();
                $getcitie = City::where('state_id', $data['state_id'])->get();
                   return view('students.admission.edit', ['data' => $data, 'getState' => $getstate, 'getCity' => $getcitie]);
            }

            public function admissionDelete(Request $request){
                $id = $request->delete_id;
                $admission = Admission::find($id);
                $fess = FeesDetail::where('admission_id',$admission->id)->get();
                $marks = FillMarks::where('admission_id',$admission->id)->get();
                if(count($marks) > 0 || count($fess) > 0){
                    return redirect::to('admissionView')->with('error', 'This student has not been removed because his fees or field mark Etc. data has been entered.');
                };
                if (File::exists(env('IMAGE_UPLOAD_PATH') . 'father_image/' . $admission->father_img)) {
                    File::delete(env('IMAGE_UPLOAD_PATH') . 'father_image/' . $admission->father_img);
                }
                    $admission->delete();
                return redirect::to('admissionView')->with('message', 'Admission Deleted Successfully !');
            }
            public function admissionStudentSearch(Request $request){
                $search['name'] = $request->name;
                    if ($request->isMethod('post')) {
                        $request->validate([]);
                        $data = Enquiry::with('ClassTypes')->where('session_id', Session::get('session_id'));
                    if (Session::get('role_id') > 1) {
                        $data = $data->where('branch_id', Session::get('branch_id'));
                    }
                    if (!empty(Session::get('admin_branch_id'))) {
                        $data = $data->where('branch_id', Session::get('admin_branch_id'));
                    }
                    if (!empty($request->name)) {
                        $data = $data
                        ->where('first_name', 'like', '%' . $request->name . '%')
                        ->orWhere('last_name', 'like', '%' . $request->name . '%')
                        ->orWhere('mobile', 'like', '%' . $request->name . '%')
                        ->orWhere('email', 'like', '%' . $request->name . '%')
                        ->orWhere('father_name', 'like', '%' . $request->name . '%')
                        ->orWhere('mother_name', 'like', '%' . $request->name . '%')
                        ->orWhere('address', 'like', '%' . $request->name . '%');
                    }
                    if (!empty($request->registration_no)) {
                        $data = $data->where("registration_no", $request->registration_no);
                    }
                    if (!empty($request->class_search_id)) {
                        $data = $data->where("class_type_id", $request->class_search_id);
                    }
                    $allstudents = $data->orderBy('id', 'DESC')->get();
                }
                return view('students.admission.studentSearchView', ['data' => $allstudents]);
            }

            public function admissionStudentOnClick(Request $request){
                $data['stu_data'] = Enquiry::where('id',$request->student_id)->first();
                return $data;
            }

            public function showFeesDetail(Request $request){
                $class_type_id = $request->get('class_id');
                $data = FeesStructure::where("class_type_id", $class_type_id)
                ->orderBy('id', 'DESC')
                ->get();
               return view('students.admission.fees_detail', ['data' => $data]);
            }

            public function birthdatEmail(Request $request){
                $data = Admission::where('dob', date('Y-m-d'))->get();
                if ($data->count() > 0) {
                    foreach ($data as $data) {
                        $emailData = ['email' => $data->email, 'data' => $data, 'subject' => 'Birthday Email.'];
                        Helper::sendmail('print_file.birthday_mail', $emailData);
                    }
                }
                return view('print_file.birthday_mail', ['data' => $data]);
            }
  
            public function admissionStudentPrint(Request $request, $id){
                $student_admission = Admission::select('admissions.*', 'sessions.from_year', 'class_types.name as class_name','sessions.to_year', 'gender.name as genderName','countries.name as country_name','states.name as state_name','citys.name as city_name')
                ->leftJoin('gender','gender.id','admissions.gender_id')
                ->leftjoin('countries','countries.id','admissions.country_id')
                ->leftjoin('states','states.id','admissions.state_id')
                ->leftjoin('citys','citys.id','admissions.city_id')
                ->leftjoin('sessions','sessions.id','admissions.session_id')
                ->leftjoin('class_types','class_types.id','admissions.class_type_id')
                ->where('admissions.id',$id)->first();
                // dd($student_admission);
                // $pdf = PDF::loadView('master.printFilePanel.StudentManagement.template11', ['data'=>$student_admission]);
                //      $pdf->setPaper('A4', 'portrait');
                //     return $pdf->download('StudentManagement.pdf');
                $printPreview = Helper::printPreview('Admission Print');
                // dd($printPreview);
                return view($printPreview, ['data' => $student_admission]);
               // return view('print_file.student_print.admissionStudentPrint', ['data' => $student_admission]);
            }
            public function admissionStudentIdPrint(Request $request, $id){
                // $student_id = Admission::find($id);
                $student_id =  Admission::Select('admissions.*','sessions.from_year','class_types.name as class_name','sessions.to_year')
                ->leftjoin('sessions','sessions.id','admissions.session_id')
                ->leftjoin('class_types','class_types.id','admissions.class_type_id')
                ->where('admissions.id', $id)->first();
                $printPreviewId = Helper::printPreview('Student Id Print');
                //dd($printPreviewId);
                return view($printPreviewId, ['data' => $student_id]);
                // return view('print_file.student_print.admissionStudentIdPrint', ['data' => $student_id]);
            }
            
            public function studentIdGenerator(Request $request, $id){
                $student_idGenerator =  Admission::Select('admissions.*','sessions.from_year','sessions.to_year')
                ->leftjoin('sessions','sessions.id','admissions.session_id')
                ->where('admissions.id', $id)->first();
                $printPreviewId = Helper::printPreview('Student Id Print');
                $randomString = Str::random(10);
                $pdf = PDF::loadView($printPreviewId, ['data' => $student_idGenerator]);
                file_put_contents(env('IMAGE_UPLOAD_PATH'). 'studentIdPdf' . '/' .$randomString.$student_idGenerator->admissionNo . '.pdf', $pdf->output());
                $file_url = env('IMAGE_SHOW_PATH') . 'studentIdPdf' . '/' .$randomString.$student_idGenerator->admissionNo . '.pdf';  
                Admission::where('id',$id)->update(['student_id_pdf_name' => $file_url]);
                return redirect::to('admissionView')->with('message', 'PDF Generated Successfully !');
                // return view('print_file.student_print.admissionStudentIdPrint', ['data' => $student_id]);
            }

            public function studentDetail($id){
                $studentDetail = Admission::select('admissions.*','hostel.name as hostel_name','countries.name as country_name','states.name as state_name','citys.name as city_name','hostel_room.name as room_name','hostel_bed.name as bed_name')
                ->leftjoin('hostel_assign','hostel_assign.admission_id','admissions.id')
                ->leftjoin('hostel','hostel.id','hostel_assign.hostel_id')
                ->leftjoin('hostel_room','hostel_room.id','hostel_assign.room_id')
                ->leftjoin('hostel_bed','hostel_bed.id','hostel_assign.bed_id')
                ->leftjoin('countries','countries.id','admissions.country_id')
                ->leftjoin('states','states.id','admissions.state_id')
                ->leftjoin('citys','citys.id','admissions.city_id')
                ->with('ClassTypes')->find($id);
                $feesassiggn=FeesAssign::where('admission_id',$id)->get()->first();
                $feesDetail = FeesDetail::with('PaymentMode')
                ->with('FeesCollect')
                ->where('admission_id', $id)
                ->where('branch_id', Session::get('branch_id'))
                ->get();
                return view('students.admission.studentDetail', ['data' => $studentDetail, 'feesDetail' => $feesDetail,'assignfees'=>$feesassiggn]);
            }
    
            public function multiAdmissionEdit(Request $request){
                if ($request->isMethod('post')) {
                    for($i=0; $i<count($request->admission_id); $i++)
                {
                $data = Admission::find($request->admission_id[$i]);
                if (!empty($request->file('student_img')[$i])) {
                    $image = $request->file('student_img')[$i];
                    $path = $image->getRealPath();
                    $student_image = time() . uniqid() . $image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile';
                    $image->move($destinationPath, $student_image);
                    if (File::exists(env('IMAGE_UPLOAD_PATH') . 'profile/' . $data->image)) {
                        File::delete(env('IMAGE_UPLOAD_PATH') . 'profile/' . $data->image);
                    }
                    $data->image = $student_image;
                }
                if (!empty($request->file('father_img')[$i])) {
                    $image = $request->file('father_img')[$i];
                    $path = $image->getRealPath();
                    $father_image = time() . uniqid() . $image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH') . 'father_image';
                    $image->move($destinationPath, $father_image);
                    if (File::exists(env('IMAGE_UPLOAD_PATH') . 'father_image/' . $data->father_img)) {
                    File::delete(env('IMAGE_UPLOAD_PATH') . 'father_image/' . $data->father_img);
                    }
                    $data->father_img = $father_image;
                }
                if (!empty($request->file('mother_img')[$i])) {
                    $image = $request->file('mother_img')[$i];
                    $path = $image->getRealPath();
                    $mother_image = time() . uniqid() . $image->getClientOriginalName();
                    $destinationPath = env('IMAGE_UPLOAD_PATH') . 'mother_image';
                    $image->move($destinationPath, $mother_image);
                    if (File::exists(env('IMAGE_UPLOAD_PATH') . 'mother_image/' . $data->mother_img)) {
                        File::delete(env('IMAGE_UPLOAD_PATH') . 'mother_image/' . $data->mother_img);
                    }
                    $data->mother_img = $mother_image;
                }
                    $data->admission_date = $request->admission_date[$i];
                    $data->class_type_id = $request->class_type_id[$i];
                    $data->first_name = $request->first_name[$i];
                    $data->last_name = $request->last_name[$i];
                    $data->aadhaar = $request->aadhaar[$i];
                    $data->jan_aadhaar = $request->jan_aadhaar[$i];
                    $data->previous_school = $request->previous_school[$i];
                    $data->email = $request->email[$i];
                    $data->mobile = $request->mobile[$i];
                    $data->father_name = $request->father_name[$i];
                    $data->mother_name = $request->mother_name[$i];
                    $data->father_mobile = $request->father_mobile[$i];
                    $data->dob = $request->dob[$i];
                    $data->gender_id = $request->gender_id[$i];
                    $data->admission_type_id = $request->admission_type_id[$i];
                    $data->address = $request->address[$i];
                    $data->country_id = $request->country[$i];
                    $data->village_city = $request->village_city[$i];
                    $data->city_id = $request->city[$i];
                    $data->state_id = $request->state[$i];
                    $data->pincode = $request->pincode[$i];
                    $data->remark_1 = $request->remark_1[$i];
                    $data->save();
                }
                 return redirect::to('admissionView')->with('message', 'Admission Updated Successfully !');
            }
                $getstate = State::where('country_id', $data['country_id'])->get();
                $getcitie = City::where('state_id', $data['state_id'])->get();
                return view('students.admission.edit', ['data' => $data, 'getState' => $getstate, 'getCity' => $getcitie]);
            }

            /* public function studentUserNameCreate(Request $request)
                {
                    $allStudents = Admission::whereNotNull('dob')->whereNotNull('first_name')->get();
                    foreach($allStudents as $item)
                    {
                        $session = Sessions::where('id',$item->session_id)->first();
                        $initials = substr($item->first_name, 0, 3)
                        $birthYear = date('Y', strtotime($item->dob));
                        $random_number = Str::random(10);
                        $cleanedMobile = preg_replace('/[^0-9]/', '', $item->mobile ?? $random_number);
                        // $username = 'EPA_'.strtoupper($initials) .'_'. $birthYear .'_'. substr($cleanedMobile, -4);
                        $username = 'GG_'.strtoupper($initials)  .'_'. substr($cleanedMobile, -4).'_'.$session->from_year;
                        $update = Admission::find($item->id);
                        $update->username = $username;
                        $update->password = Hash::make('12345678');
                        $update->confirm_password = '12345678';
                        $update->save();
                    }
                   
                }
            */
            
           
            
            public function bulkIdPrint(Request $request){
                $classtype = $request->class_type_id;
                $admission_ids = Admission::where('session_id',Session::get('session_id'))->where('branch_id',Session::get('branch_id'))->where('class_type_id',$classtype)->pluck('id')->implode(',');
                if(!empty($admission_ids)){
                    $data= explode(',',$admission_ids);
                }
                return view('students.student_id.bulkIdPrint',['admission_ids'=>$data]);
            }
    
            public function studentBulkImageUpload(Request $request){
                if($request->isMethod('post')){
                    if ($request->file('image')) {
                        foreach($request->file('image') as $img){
                            $originalName = $img->getClientOriginalName();
                            $filenameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                            $admission = Admission::where('branch_id', Session::get('branch_id'))->where('session_id', $request->session_id)->where('admissionNo', $filenameWithoutExtension)->first();
                            if($admission){
                                if (File::exists(env('IMAGE_UPLOAD_PATH') . 'profile/' . $admission->image)) {
                                    File::delete(env('IMAGE_UPLOAD_PATH') . 'profile/' . $admission->image);
                                }
                                $student_image = time() . uniqid() . $originalName;
                                $destinationPath = env('IMAGE_UPLOAD_PATH') . 'profile';
                                $img->move($destinationPath, $student_image);
                                $admission->image = $student_image;
                                $admission->save();
                            }
                        }
                         return redirect::to('admissionView')->with('message','Images Updated Succcessfully');
                    }
                }
            }
    
            public function verify_admission(Request $request){
                Admission::where('id',$request->id)->update(['session_id' => $request->session_id, 'status' => 1, 'admission_date' => date('Y-m-d')]);
                $data = Admission::where('id',$request->id)->first();
                $template = "
                Hello {#name#},
                This is Administrator from {#school_name#}. I hope this message finds you well.
                We are pleased to provide you with your credentials to access our school’s online platform:
                Username: {#user_name#}
                Password: {#password#}
                Please ensure you keep these credentials secure and do not share them with others. If you have any questions or need further assistance, feel free to contact us at {#school_mobile#}.
                Thank you and have a great day!
                Best regards,
                Adminitrator
                {#school_name#}
                {#school_mobile#}
                ";    
                $branch = Branch::find(Session::get('branch_id'));
                $setting = Setting::where('branch_id',$branch->id)->first();
                $arrey1 =   array(
                    '{#name#}',
                    '{#school_name#}',
                    '{#user_name#}',
                    '{#password#}',
                    '{#school_mobile#}',
                    '{#mobile#}',);
                $arrey2 = array(
                    $data->first_name ?? '',
                    $setting->name,
                    $data->userName,
                    $data->confirm_password,
                    $setting->mobile,
                    $data->mobile);
                if($branch->whatsapp_srvc != 0){
                    if ($data->mobile != ""){
                        $whatsapp = str_replace($arrey1,$arrey2,$template);
                         Helper::sendWhatsappMessage($data->mobile,$whatsapp);
                    }
                }
                if(Session::get('session_id') != $request->session_id){
                    return redirect::to('admissionView')->with('message','Student Admission Complete Successfully');
                }else{
                    return redirect::to('admissionEdit/'.$request->id)->with('message','Student Admission Complete Successfully');
                }
            }
    
            public function category_wise_report(Request $request){
                $student_id =  Admission::Select('admissions.*','sessions.from_year','class_types.name as class_name','sessions.to_year')
                ->leftjoin('sessions','sessions.id','admissions.session_id')
                ->leftjoin('class_types','class_types.id','admissions.class_type_id')
                ->get();
                return view('students.report/category_wise_report', ['data' => $student_id]);
            }
    
            public function streamUpdate(Request $request){
                $search["exam_id"] = $request->exam_id  ?? "";
                $data = [];
                $list_subject = '';
                $search["class_type_id"] = $request->class_type_id;
                if ($request->isMethod('post')) {
                    $data = Admission::where('class_type_id',$request->class_type_id)->where("branch_id", Session::get("branch_id"))->orderBy('first_name','ASC')->get();
                    $list_subject = Subject::where("class_type_id", $request->class_type_id)->where("branch_id", Session::get("branch_id"))->orderBy("sort_by", "ASC")->get();
                }
                return view('students.admission.stream_update',['search'=>$search,'data'=>$data,'list_subject'=>$list_subject]);
            }
    
            public function streamUpdateSave(Request $request){
                if ($request->isMethod('post')) {
                    if($request->admission_id != [] && $request->subject_id != []){
                        for ($i = 0; $i < count($request->admission_id); $i++) {
                            $data = Admission::find($request->admission_id[$i]);
                            $a1 = !empty($data->stream_subject) ? explode(',', $data->stream_subject) : [];
                            $a2 = $request->subject_id;
                            $r = array_merge($a1, $a2);
                            $r_unique = array_unique($r);
                            //dd($r_unique);
                            if (!empty($request->subject_id)) {
                                $data->stream_subject = implode(',', $r_unique);
                                $data->save();  
                            }
                        }
                        return redirect::to('stream_update')->with('message', 'Admission Updated Successfully!');
                    }else{
                        return redirect::to('stream_update')->with('error', 'please select Students checkbox !');
                    }
                }
            }
            
            public function streamRemove(Request $request,$admission_id,$subject_id){
                $data = Admission::find($admission_id);
                if (!$data) {
                    return response()->json(['error' => 'Admission not found.'], 404);
                }
                $a1 = !empty($data->stream_subject) ? explode(',', $data->stream_subject) : [];
                // Using array_filter to remove the subject
                $a1 = array_filter($a1, function($subject) use ($subject_id) {
                    return $subject != $subject_id;
                });
                // Reindex the array if needed
                $a1 = array_values($a1);
                $data->stream_subject = implode(',', $a1);
                $data->save();
                return response()->json(['success' => 'Subject Updated Successfully '], 200);
            }
            
            public function folderCompressor(Request $request)
            {
                // Prevent timeout & memory issues
                ini_set('memory_limit', '1024M');
                set_time_limit(0);
            
                // Main folder path
                $path = base_path('schoolimage');
            
                // Get all files from folder recursively
                $images = \File::allFiles($path);
            
                foreach ($images as $file) {
            
                    try {
            
                        $filePath = $file->getRealPath();
            
                        // Skip invalid images
                        if (!@getimagesize($filePath)) {
                            \Log::warning("Invalid image skipped: " . $filePath);
                            continue;
                        }
            
                        // Skip already small images (optional)
                        if ($file->getSize() < 100 * 1024) {
                            continue;
                        }
            
                        // Compress & resize image
                        $compressedImage = Image::make($filePath)
                            ->resize(600, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            })
                            ->encode('jpg', 80);
            
                        // Save back to SAME location
                        $compressedImage->save($filePath);
            
                        \Log::info("Compressed: " . $filePath);
            
                    } catch (\Exception $e) {
            
                        \Log::error(
                            "Compression failed for: "
                            . $filePath
                            . ' | Error: '
                            . $e->getMessage()
                        );
                    }
                }
            
                return redirect('/')
                    ->with('message', 'Folder compressed successfully!');
            }
                 
            public function imageDelete(Request $request)
          {
    
                $id = $request->delete_image;
                
                $admission = Admission::find($id);
                // dd($admission);
                 if (!$admission) {
        
                        return redirect()->to('admissionView')->with('error', 'Admission not found!');
                    }
                if (File::exists(env('IMAGE_UPLOAD_PATH') . 'profile/' . $admission->image)) {
                    File::delete(env('IMAGE_UPLOAD_PATH') . 'profile/' . $admission->image);
                }
            
                $admission->image = null;
                $admission->save();
            
            
                return redirect()->to('admissionView')->with('message','image deleted successfully!');
            }
        public function login_credential_reports(Request $request)
        {
            $search = [
                'course' => $request->course,
                'class_type_id' => $request->class_type_id,
                'admissionNo' => $request->admissionNo,
                'name' => $request->name,
                'status' => $request->status,
            ];
            $query = Admission::select('admissions.*', 'class.name as class_name')
                ->leftJoin('class_types as class', 'class.id', '=', 'admissions.class_type_id')
                ->where('admissions.branch_id', Session::get('branch_id'))
                ->where('admissions.session_id', Session::get('session_id'))
                ->where('admissions.status', '1');
                
            if (!empty($search['course'])) {
                $query->where('admissions.course', $search['course']);
            }
            if (!empty($search['class_type_id'])) {
                $query->where('admissions.class_type_id', $search['class_type_id']);
            }
            if (!empty($search['admissionNo'])) {
                $query->where('admissions.admissionNo', $search['admissionNo']);
            }
            if (!empty($search['name'])) {
                $value = $search['name'];
                $query->where(function($q) use ($value) {
                    $q->where('admissions.first_name', 'like', '%' . $value . '%')
                      ->orWhere('admissions.last_name', 'like', '%' . $value . '%')
                      ->orWhere('admissions.father_name', 'like', '%' . $value . '%')
                      ->orWhere('admissions.mobile', 'like', '%' . $value . '%')
                      ->orWhere('admissions.userName', 'like', '%' . $value . '%')
                      ->orWhere('admissions.email', 'like', '%' . $value . '%');
                });
            }
            if (!empty($search['status'])) {
                if ($search['status'] == 'generated') {
                    $query->whereNotNull('admissions.userName')->where('admissions.userName', '!=', '');
                } elseif ($search['status'] == 'pending') {
                    $query->where(function($q) {
                        $q->whereNull('admissions.userName')->orWhere('admissions.userName', '');
                    });
                }
            }
            
            $data = $query->orderBy('admissions.first_name', 'ASC')->get();
            return view('students.login_credential.view', ['search' => $search, 'data' => $data]);
        }

        public function studentUserNameCreate(Request $request)
        {
            if (empty($request->student_ids)) {
                return back()->with('error', 'No students selected.');
            }
        
            $ids = array_filter(explode(',', $request->student_ids));
        
            if (empty($ids)) {
                return back()->with('error', 'Invalid student selection.');
            }
        
            $usernameOrder = !empty($request->username_order) ? explode(',', $request->username_order) : [];
            $passwordOrder = !empty($request->password_order) ? explode(',', $request->password_order) : [];
        
            $nameLetters = $request->name_letters ?? 4;
            $mobileDigits = $request->mobile_digits ?? 4;
        
            $students = Admission::select('admissions.*', 'class.name as class_name')
                ->leftJoin('class_types as class', 'class.id', '=', 'admissions.class_type_id')
                ->whereIn('admissions.id', $ids)
                ->where('admissions.branch_id', Session::get('branch_id'))
                ->where('admissions.session_id', Session::get('session_id'))
                ->get();
        
            foreach ($students as $student) {
                $username = '';
                $password = '';
            
                // 1. Username
                if (!empty($usernameOrder)) {
                    foreach ($usernameOrder as $key) {
                        if (!empty($key)) {
                            $username .= $this->getFieldValue($student, $key, $nameLetters, $mobileDigits);
                        }
                    }
                }
                if (empty($username)) {
                    $username = 'stu_' . ($student->admissionNo ?? $student->id);
                }
            
                // 2. Password Logic
                if (!empty($request->custom_password)) {
                    $password = trim($request->custom_password);
                } elseif (!empty($passwordOrder)) {
                    foreach ($passwordOrder as $key) {
                        if (!empty($key)) {
                            $password .= $this->getFieldValue($student, $key, $nameLetters, $mobileDigits);
                        }
                    }
                    if (empty($password)) {
                        $password = '12345678';
                    }
                } else {
                    $password = '12345678';
                }
            
                $student->userName = $username;
                $student->password = Hash::make($password);
                $student->confirm_password = $password;
                $student->save();
            }
            
            return back()->with('message', count($students) . ' student credentials generated successfully!');
        }

        public function updateSingleStudentCredential(Request $request)
        {
            $request->validate([
                'student_id' => 'required',
                'username' => 'required',
                'password' => 'required|min:4',
            ]);

            $student = Admission::where('branch_id', Session::get('branch_id'))
                ->where('session_id', Session::get('session_id'))
                ->find($request->student_id);

            if (!$student) {
                if ($request->ajax()) {
                    return response()->json(['status' => false, 'message' => 'Student not found.']);
                }
                return back()->with('error', 'Student not found.');
            }

            // Check if username is already taken by another student in this branch
            $existing = Admission::where('branch_id', Session::get('branch_id'))
                ->where('userName', $request->username)
                ->where('id', '!=', $student->id)
                ->first();

            if ($existing) {
                if ($request->ajax()) {
                    return response()->json(['status' => false, 'message' => 'Username is already in use by another student.']);
                }
                return back()->with('error', 'Username is already in use by another student.');
            }

            $password = trim($request->password);
            $student->userName = trim($request->username);
            $student->password = Hash::make($password);
            $student->confirm_password = $password;
            $student->save();

            if ($request->ajax()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Credentials updated successfully for ' . $student->first_name . ' ' . ($student->last_name ?? '') . '!',
                    'data' => [
                        'id' => $student->id,
                        'userName' => $student->userName,
                        'confirm_password' => $student->confirm_password
                    ]
                ]);
            }

            return back()->with('message', 'Credentials updated successfully for ' . $student->first_name . ' ' . ($student->last_name ?? '') . '!');
        }
            
            
        private function getFieldValue($student, $key, $nameLetters = 4, $mobileDigits = 4)
        {
            switch ($key) {
                case 'name':
                    return substr(strtolower(preg_replace('/\s+/', '', $student->first_name)), 0, $nameLetters);
                case 'mobile':
                    return substr(preg_replace('/\D/', '', $student->mobile), -$mobileDigits);
                case 'dob':
                    if (!$student->dob) return '';
                    $dob = date('dmy', strtotime($student->dob)); //e.g. 150805
                    return $dob;
                case 'admission_no':
                    return $student->admissionNo;
                case 'class':
                    return strtolower(preg_replace('/\s+/', '', $student->class_name));
                default:
                    return '';
            }
        }

        public function getClassesByCourse(Request $request)
        {
            $course_name = $request->course;
            $course_id = $request->course_id;
            $branch_id = Session::get('branch_id') ?? Session::get('admin_branch_id');
            $session_id = Session::get('session_id');

            $query = ClassType::query();
            if (!empty($branch_id)) {
                $query->where('branch_id', $branch_id);
            }
            if (!empty($session_id)) {
                $query->where(function($q) use ($session_id) {
                    $q->where('session_id', $session_id)
                      ->orWhereNull('session_id')
                      ->orWhere('session_id', 0);
                });
            }

            if (!empty($course_id)) {
                if (is_numeric($course_id)) {
                    $query->where(function($q) use ($course_id) {
                        $q->where('course_id', $course_id);
                        $courseObj = \App\Models\Master\Course::find($course_id);
                        if ($courseObj) {
                            $q->orWhere('name', 'LIKE', $courseObj->name . ' %')
                              ->orWhere('name', $courseObj->name);
                        }
                    });
                } else {
                    $query->where(function($q) use ($course_id) {
                        $q->where('name', 'LIKE', $course_id . ' %')
                          ->orWhere('name', $course_id);
                        $courseObj = \App\Models\Master\Course::where('name', $course_id)->first();
                        if ($courseObj) {
                            $q->orWhere('course_id', $courseObj->id);
                        }
                    });
                }
            } elseif (!empty($course_name)) {
                $courseQuery = \App\Models\Master\Course::where('name', $course_name);
                if (!empty($branch_id)) {
                    $courseQuery->where('branch_id', $branch_id);
                }
                $course = $courseQuery->first();
                if ($course) {
                    $query->where(function($q) use ($course, $course_name) {
                        $q->where('course_id', $course->id)
                          ->orWhere('name', 'LIKE', $course_name . ' %')
                          ->orWhere('name', $course_name);
                    });
                } else {
                    $query->where(function($q) use ($course_name) {
                        $q->where('name', 'LIKE', $course_name . ' %')
                          ->orWhere('name', $course_name);
                    });
                }
            }

            $classes = $query->orderBy('orderBy', 'ASC')->orderBy('id', 'ASC')->get();
            return response()->json($classes);
        }

    }
