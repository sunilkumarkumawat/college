<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Validator;
use App\Models\User;
use App\Models\Admission;
use App\Models\ClassType;
use App\Models\hostel\Hostel;
use App\Models\hostel\HostelBuilding;
use App\Models\BillCounter;
use App\Models\hostel\HostelFloor;
use App\Models\hostel\HostelRoom;
use App\Models\hostel\HostelBed;
use App\Models\hostel\HostelAssign;
use App\Models\Master\MessageTemplate;
use App\Models\Master\Branch;
use App\Models\Setting;
use App\Models\Expense;
use App\Models\Remark;
use Session;
use Hash;
use Helper;
use File;
use Str;
use Redirect;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

            public function expenseAdd(Request $request){
                if ($request->isMethod('post')) {
                    $request->validate([
                        //  'name' => 'required',    
                        //  'date' => 'required',    
                        //  'amount' => 'required',    
                        //  'total_amt' => 'required',    
                    ]);
                    for ($count = 0; $count <= count($request->name); $count++) {
                        if (isset($request->name[$count])) {
                            $attachment = '';
                            if ($request->hasfile('attachment') && isset($request->attachment[$count])) {
                                $image = $request->file('attachment')[$count];
                                $path = $image->getRealPath();
                                $attachment = time() . uniqid() . $image->getClientOriginalName();
                                $destinationPath = env('IMAGE_UPLOAD_PATH') . 'expense';
                                $image->move($destinationPath, $attachment);
                            }
                            $hostel = new Expense; //model name
                            $hostel->user_id = $request->role[$count];
                            $hostel->session_id = Session::get('session_id');
                            $hostel->branch_id = Session::get('branch_id');
                            //$hostel->role_id = ;
                            $hostel->name = $request->name[$count];
                            $hostel->date = $request->date[$count];
                            $hostel->quantity = $request->quantity[$count];
                            $hostel->rate = $request->rate[$count];
                            $hostel->amount = $request->amount[$count];
                            $hostel->payment_mode_id = $request->payment_mode_id[$count];
                            $hostel->total_amt = $request->total_amt;
                            $hostel->attachment = $attachment;
                            $hostel->description = $request->description[$count];
                            $hostel->save();
                            $template = MessageTemplate::Select('message_templates.*', 'message_types.slug')
                                ->leftjoin('message_types', 'message_types.id', 'message_templates.message_type_id')
                                ->where('message_types.status', 1)->where('message_types.slug', 'expences')->first();
                            $branch = Branch::find(Session::get('branch_id'));
                            $setting = Setting::where('session_id', Session::get('session_id'))->where('branch_id', Session::get('branch_id'))->first();
                            $admin = User::where('id', Session::get('id'))->first();
                            $arrey1 = array(
                                '{#name#}',
                                '{#expenses_name#}',
                                '{#description#}',
                                '{#quantity#}',
                                '{#amount#}',
                                '{#total_amount#}',
                                '{#date#}',
                                '{#support_no#}',
                                '{#school_name#}'
                            );
                            $arrey2 = array(
                                $admin->first_name . " " . $admin->last_name,
                                $request->name[$count],
                                $request->description[$count],
                                $request->quantity[$count],
                                $request->rate[$count],
                                $request->amount[$count],
                                date('d-m-Y', strtotime($request->date[$count])),
                                $setting->mobile,
                                $setting->name
                            );
                            if (!empty($template) && $template->status != 1) {
                                if ($admin->email != "") {
                                    if ($branch->email_srvc != 0) {
                                        if ($template->email_status != 0) {
                                            $message = str_replace($arrey1, $arrey2, $template->email_content);
                                            $emailData = ['email' => $admin->email, 'data' => $message, 'subject' => $template->title];
                                            Helper::sendMail('email_print.template_print', $emailData);
                                        }
                                    }
                                }
                                if ($branch->whatsapp_srvc != 0) {
                                    if ($admin->mobile != "") {
                                        if ($template->whatsapp_status != 0) {
                                            $whatsapp = str_replace($arrey1, $arrey2, $template->whatsapp_content);
                                            Helper::sendWhatsappMessage($admin->mobile, $whatsapp);
                                        }
                                    }
                                }
                                if ($branch->sms_srvc != 0) {
                                    if ($admin->mobile != "") {
                                        if ($template->sms_status != 0) {
                                            $sms = str_replace($arrey1, $arrey2, $template->sms_content);
                                            Helper::SendMessage($admin->mobile, $sms);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $url = '/expensePrint/' . $hostel->id;
                    ?>
                    <script type="text/javascript">
                        window.open("<?= $url ?>", "_blank");
                    </script>
                    <?php
        
                    return redirect::to('expenseView')->with('message', 'Expense Added Successfully !');
                }
                return view('expense.add');
            }
        
            public function expenseView(Request $request){
                $search['session_id'] = $request->has('session_id') ? $request->session_id : Session::get('session_id');
                $search['name'] = $request->name;
                $search['from_date'] = $request->from_date;
                $search['to_date'] = $request->to_date;
                $data = Expense::query();
                if (!empty($search['session_id'])) {
                    $data = $data->where('session_id', $search['session_id']);
                }
                if (Session::get('role_id') > 1) {
                    $data = $data->where('branch_id', Session::get('branch_id'));
                }
                if (!empty(Session::get('admin_branch_id'))) {
                    $data = $data->where('branch_id', Session::get('admin_branch_id'));
                }
                if ($request->isMethod('post')) {
                    if (!empty($request->name)) {
                        $value = $request->name;
                        $data = $data->where('name', 'LIKE', '%' . $value . '%');
                    }
                    if (!empty($request->from_date) && !empty($request->to_date)) {
                        $data = $data->whereBetween('date', [$request->from_date, $request->to_date]);
                    } elseif (!empty($request->from_date)) {
                        $data = $data->whereDate('date', '>=', $request->from_date);
                    } elseif (!empty($request->to_date)) {
                        $data = $data->whereDate('date', '<=', $request->to_date);
                    }
                }
                $data = $data->orderBy('id', 'DESC')->whereNull('deleted_at')->get();
                return view('expense.view', ['data' => $data, 'search' => $search]);
            }
            public function expenseEdit(Request $request, $id)
            {
                $data = Expense::find($id);
                if ($request->isMethod('post')) {
                    $request->validate([
                        //  'name' => 'required',    
                        //  'date' => 'required',    
                        //  'amount' => 'required',    
                        //  'total_amt' => 'required',    
        
                    ]);
                    if ($request->file('attachment')) {
                        $image = $request->file('attachment');
                        $path = $image->getRealPath();
                        $attachment = time() . uniqid() . $image->getClientOriginalName();
                        $destinationPath = env('IMAGE_UPLOAD_PATH') . 'expense';
                        $image->move($destinationPath, $attachment);
                        if (File::exists(env('IMAGE_UPLOAD_PATH') . 'expense/' . $data->attachment)) {
                            File::delete(env('IMAGE_UPLOAD_PATH') . 'expense/' . $data->attachment);
                        }
                        $data->attachment = $attachment;
                    }
                    $data->user_id = $request->role ?? '';
                    $data->session_id = Session::get('session_id');
                    $data->branch_id = Session::get('branch_id');
                    // $data->role_id = $request->role;
                    $data->name = $request->name ?? '';
                    $data->date = $request->date;
                    $data->quantity = $request->quantity;
                    $data->rate = $request->rate;
                    $data->amount = $request->amount;
                    $data->payment_mode_id = $request->payment_mode_id;
                    $data->total_amt = $request->total_amt;
                    $data->description = $request->description;
                    $data->save();
                    return redirect::to('expenseView')->with('message', 'Expense Updated Successfully !');
                }
                return view('expense.edit', ['data' => $data]);
            }
            public function expenseDelete(Request $request){
                $id = $request->delete_id;
                $bed = Expense::find($id);
                if (File::exists(env('IMAGE_UPLOAD_PATH') . 'expense/' . $bed->attachment)) {
                    File::delete(env('IMAGE_UPLOAD_PATH') . 'expense/' . $bed->attachment);
                }
                $bed->delete();
                return redirect::to('expenseView')->with('message', 'Expense Deleted Successfully !');
            }
            public function expensePrint($id){
                $data = Expense::find($id);
                return view('print_file.expense.expense_print', ['data' => $data]);
            }
            
            public function remarkMail(Request $request){
                $data = Remark::select('registration_remarks.*', 'Student.*', 'ClassTypes.name as class')
                    ->leftjoin('students as Student', 'Student.id', 'registration_remarks.student_id')
                    ->leftjoin('class_types as ClassTypes', 'Student.class_type_id', 'ClassTypes.id')
                    ->where('registration_remarks.date', date('Y-m-d'))->get();
                $admin = User::find('1');
                if ($data->count() > 0) {
                    $emailData = ['email' => $admin->gmail, 'data' => $data, 'subject' => 'Remark Recole.'];
                    Helper::sendmail('print_file.remark_mail', $emailData);
                }
                return view('print_file.remark_mail', ['data' => $data]);
            }


}
