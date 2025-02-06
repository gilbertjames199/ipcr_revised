<?php

namespace App\Http\Controllers;

use App\Models\ChangeLog;
use App\Models\Division;
use App\Models\EmailChangeLog;
use App\Models\Office;
use App\Models\StatusUpdateLog;
use App\Models\UserEmployeeCredential;
use App\Models\UserEmployees;
use GuzzleHttp\Client;

use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class UserEmployeesController extends Controller
{
    protected $us_emp;
    public function _construct(UserEmployees $us_emp)
    {
        $this->us_emp = $us_emp;
    }
    public function index(Request $request)
    {
        $logged_emp = UserEmployees::where('empl_id', auth()->user()->username)
            ->first();
        // dd($logged_emp);
        $dept_code = $logged_emp->department_code;

        $sg = $logged_emp->salary_grade;
        if (intval($sg) >= 0) {
            $data = UserEmployees::with('Division')->with('Office')->where('department_code', $dept_code)
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10)
                ->withQueryString();
            // ->through(function($item){
            //     return [
            //         'empl_id'=>$item,
            //         'employee_name'=>$item,
            //         'employment_type_descr'=>$item,
            //         'position_long_title'=>$item,
            //         'division'=>$item,
            //         'office'=>$item,
            //     ];
            // })
            return inertia(
                'Employees/Index',
                [
                    "users" => $data
                ]
            );
        } else {
            return redirect('/forbidden')
                ->with('error', 'Access forbidden!');
        }
    }
    public function all_employees(Request $request)
    {
        // dd(auth()->user()->department_code);
        $dept = auth()->user()->department_code;
        $usn = auth()->user()->username;
        // dd($request->search);
        // dd($usn);

        if (($dept == '26' || $dept == '03')  && ($usn == '8510' || $usn == '8354' || $usn == '2003' || $usn == '8447' || $usn == '8753' || $usn == '2089' || $usn = '2960' || $usn = '2730')) {
            // $cats = auth()->user()->username;
            $data = UserEmployees::with('Division', 'Office', 'credential')
                ->select(
                    'user_employees.*',
                    DB::raw("
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    TO_BASE64(SHA2(user_employees.empl_id, 256)),
                                    '+', '-'
                                ),
                                '/', '_'
                            ),
                            '=', ''
                        ),
                        CHAR(10), ''
                    ) AS empl_id_hashed
                ")
                )
                ->when($request->EmploymentStatus, function ($query, $searchItem) {
                    $query->where('employment_type_descr', 'LIKE', '%' . $searchItem . '%');
                })
                ->when($request->office, function ($query) use ($request) {
                    $query->where('department_code',  $request->office);
                })
                ->when($request->division, function ($query) use ($request) {
                    // dd($request->division);
                    $query->where('division_code',  $request->division);
                })
                ->when($request->search, function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where('employee_name', 'LIKE', '%' . $request->search . '%')
                            // ->where('user_employees.active_status', 'ACTIVE')
                            ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $request->search . '%')
                            ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $request->search . '%');
                    })
                        ->Orwhere(function ($query) use ($request) {
                            $query->where('empl_id', 'LIKE', '%' . $request->search . '%')
                                ->where('user_employees.active_status', 'ACTIVE')
                                ->OrWhere(Division::select('division_name1')->whereColumn('divisions.division_code', 'user_employees.division_code'), 'LIKE', '%' . $request->search . '%')
                                ->OrWhere(Office::select('office')->whereColumn('offices.department_code', 'user_employees.department_code'), 'LIKE', '%' . $request->search . '%');
                        });
                })
                ->when($request->active_status, function ($query) use ($request) {
                    $query->where('user_employees.active_status', $request->active_status);
                })
                ->orderBy('user_employees.employee_name', 'ASC')
                ->paginate(10)
                ->withQueryString()
                ->through(function ($item) {
                    return [
                        "empl_id" => $item->empl_id,
                        "employee_name" => $item->employee_name,
                        "employment_type_descr" => $item->employment_type_descr,
                        "position_long_title" => $item->position_long_title,
                        "division" => $item->division,
                        "office" => $item->office,
                        "active_status" => $item->active_status,
                        "credential" => $item->credential,
                        "empl_id_bcrypt" => $item->empl_id_hashed
                        // $this->generateUrlSafeHash($item->empl_id)
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name"=>$item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                        // "employee_name" => $item->employee_name,
                    ];
                });

            // $divisions = Division::all();
            $offices = Office::where(function ($query) {
                $query->where('office', 'LIKE', '%Office%')
                    ->orWhere('office', 'Like', '%Hospital%');
            })
                ->where('office', '<>', 'NO OFFICE')
                ->orderBy('office', 'ASC')
                ->get();
            // dd($divisions);
            // dd(auth()->user());
            // dd(session()->get('impersonated_by'));

            // dd($impersonator_id);
            return inertia(
                'Employees/All/Index',
                [
                    "users" => $data,
                    "filters" => $request->only(['search']),
                    // "divisions" => $divisions,
                    "offices" => $offices
                ]
            );
        } else {
            // dd("sdsds");
            // return redirect('forbidden')->with('error', 'You are forbidden to access this page!');
        }
    }
    public function all_employees_redirector(Request $request)
    {
        // dd("fdfdfdf");R
        // return Inertia::location(route('employees.all'));
        return inertia('Redirect/Index', [
            'from_all' => "1"
        ]);
    }
    function generateUrlSafeHash($input)
    {
        // Generate a SHA-256 hash
        $hash = hash('sha256', $input, true); // Raw binary output
        // Base64 encode and make it URL-safe
        $urlSafeHash = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($hash));
        return $urlSafeHash;
    }
    public function resetpass(Request $request, $id)
    {
        // dd($id);
        // dd($request);
        $user_val = 'password1.';
        $pass_encrypt = md5($user_val);
        $user = UserEmployeeCredential::find($id);
        if ($user) {
            $rb = "";
            if ($request->requestor_id) {
                $rb = UserEmployees::where('empl_id', $request->requestor_id)->first()->employee_name;
            } else {
                $rb = UserEmployees::where('empl_id', $user->username)->first()->employee_name;
            }
            $host = "";
            $add = "";
            try {
                $host = $request->header('User-Agent');
                $add = $request->ip();
            } catch (Exception $ex) {
            }
            // dd(UserEmployeeCredential::find(session()->get('impersonated_by')));

            $impersonator = session()->get('impersonated_by');
            $impersonator_id = $impersonator ? (UserEmployeeCredential::find($impersonator)->username) : null;

            $previous = $user->password;
            $user->update(['password' => $pass_encrypt]);
            $pass_log = new ChangeLog();
            $pass_log->employee_cats = $user->username;
            $pass_log->acted_by = Auth::user()->username;
            $pass_log->previous = $previous;
            $pass_log->current = $pass_encrypt;
            $pass_log->requested_by = $rb;
            $pass_log->impersonated_by = $impersonator_id;
            $pass_log->address = $add;
            $pass_log->host = $host;
            $pass_log->save();
            return back()->with('message', 'password reset successful');
        } else {
            return back()->with('error', 'user not found, unable to reset password');
        }
        // UserEmployeeCredential::where()
    }
    public function updatestat(Request $request, $id, $status)
    {
        // dd("update staut");
        // dd(auth()->user()->username);
        // dd($request);
        $us_emp = UserEmployees::where('id', $id)->first();
        $auth_cats = auth()->user()->username;
        if ($us_emp) {
            $old_stat = $us_emp->active_status;
            $us_emp->active_status = $status;
            $us_emp->save();

            // dd(auth()->user());
            $host = "";
            $add = "";
            try {
                $host = $request->header('User-Agent');
                $add = $request->ip();
            } catch (Exception $ex) {
            }
            $msg = "Successfully updated the status of " . $us_emp->employee_name . " !";
            // dd($msg);
            $stat_up = new StatusUpdateLog();
            $stat_up->emp_cats = $us_emp->empl_id;
            $stat_up->requested_by_cats = $us_emp->empl_id;
            $stat_up->reset_by_cats = $auth_cats;
            $stat_up->ipaddress = $add;
            $stat_up->remarks = $request->password_change_remarks . ' (FROM ' . $old_stat . ' to ' . $status . ')';
            $stat_up->save();
            // $stat_up->reset_by_cats =

            return back()->with('message', $msg);
        }
    }
    private function invalidateOtherSessions($userId)
    {
        // Get the user's current session ID
        $currentSessionId = session()->getId();

        // Get all active sessions for the user
        $sessions = session()->where('user_id', $userId)->get();

        // Invalidate all other sessions
        foreach ($sessions as $session) {
            if ($session->id !== $currentSessionId) {
                $session->invalidate();
            }
        }
    }
    public function resetEmail(Request $request)
    {
        // dd('update email');
        $curr = auth()->user();

        $em = UserEmployeeCredential::where('email', $request->email)->first();
        // dd($request->id);
        if ($em) {
            // dd('unsuccessful kay existing na po!!!!');
            return redirect('/employees/all')->with('error', 'Please use a different email');
        }
        $host = "";
        $add = "";
        try {
            $host = $request->header('User-Agent');
            $add = $request->ip();
        } catch (Exception $ex) {
        }
        $user_cred = UserEmployeeCredential::where('username', $request->id)->first();
        if ($user_cred) {
            $prev_mail = $user_cred->email;
            $uname = $user_cred->username;
            $user_cred->email = $request->email;
            $user_cred->save();
            // dd($uname);
            $emp = UserEmployees::where('empl_id', $uname)->first();
            $useremp = UserEmployees::where('empl_id', $curr->username)->first();
            // dd($request->email);
            $emlog = new EmailChangeLog();
            $emlog->prev_email = $prev_mail;
            $emlog->new_email = $request->email;
            $emlog->username = $uname;
            $emlog->edited_by_cats = $curr->username;
            $emlog->username_long = $useremp->employee_name;
            $emlog->edited_by_name = $emp->employee_name;
            $emlog->host = $host;
            $emlog->address = $add;
            $emlog->save();
            $msg = 'Email of ' . $emp->employee_name . ' successfully updated!';
            return back()->with('message', $msg);
        } else {
            // return redirect()->back()->with('error', 'User not found!');
            return redirect('/employees/all')->with('error', 'User not found!');
        }
        // dd($request->id);
    }
    public function set_my_email(Request $request)
    {
        // dd('email');
        return inertia(
            'Users/ChangeEmail',
            [
                "email" => auth()->user()->email
            ]
        );
    }
    public function update_email(Request $request)
    {
        // dd('email update');
        // dd($request);
        $empl_id = auth()->user()->username;

        $e_find = UserEmployeeCredential::where('email', $request->email)->first();
        if ($e_find && ($request->email != '' || $request->email != NULL)) {
            // dd('efind');
            dd($e_find);
            return back()->with('error', 'Please type a unique email');
        } else {
            $us = UserEmployeeCredential::where('username', $empl_id)->first();
            $us->email = $request->email;
            $us->save();
            return back()->with('message', 'Email successfully updated');
        }
    }
    public function get_division(Request $request, $dept_code)
    {
        // dd($dept_code);
        return Division::where('department_code', $dept_code)
            ->get();
    }
    public function email_log(Request $request)
    {
        // dd('log');
        $emlog = EmailChangeLog::simplePaginate(10);
        // dd($emlog);
        return inertia('Employees/EmailChangeLog/Index', [
            'emlog' => $emlog
        ]);
    }
    // public function syncemployees()
    public function syncemployees_1(Request $request)
    {
        // dd($request->employee_code);
        try {
            // $employeeCode = $request->input('employee_code');
            $employeeCode = $request->employee_code;
            // $employeeCode ? [$employeeCode] : []
            // $response = Http::post('http://192.168.80.49:91/api/ListOfEmployees4IPCR', [$employeeCode]);

            $url = 'http://192.168.80.49:91/api/ListOfEmployees4IPCR';
            // $response = Http::post($url, $employeeCode ? json_encode($employeeCode) : '');

            $body = $employeeCode ? json_encode($employeeCode) : '';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withBody($body, 'application/json')->post($url);


            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch employees'], 500);
            }

            $data = $response->json();
            // dd($data);
            if ($employeeCode) {
                // dd($employeeCode);
                // dd($data[0]['empl_id']);
                // dd($data[0]);
                $index = array_search($employeeCode, array_column($data, 'empl_id'));
                if ($index == false) {
                    return redirect()->back()->with('error', "ID not found!!! Please try again");
                }
                $myData = $this->saveUserEmployees($data[$index]);
                // dd($myData);
                $userEmployee = UserEmployees::where('empl_id', $employeeCode)->first();
                if ($userEmployee) {
                    $userEmployee->update($myData);
                } else {
                    UserEmployees::create($myData);
                }
                $this->saveUserCredentials($myData);
                $msg = "Successfully synced employee data with employee code of " . $employeeCode;
            } else {
                $chunk_data = array_chunk(
                    $data,
                    1000
                );
                foreach ($chunk_data as $key => $value) {
                    foreach ($value as $data) {
                        try {
                            $userEmployee = UserEmployees::where('empl_id', $data['empl_id'])->first();
                            if ($userEmployee) {
                                $userEmployee->update($data);
                            } else {
                                UserEmployees::create($data);
                            }
                            $this->saveUserCredentials($data);
                        } catch (\Exception $e) {
                            Log::error('Error updating employee: ' . $e->getMessage());
                        }
                    }
                }
                $msg = "Successfully synced employee data";
            }
            return redirect()->back()->with('message', $msg);
        } catch (\Exception $e) {
            // return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
    public function saveUserEmployees($datum)
    {
        // dd($datum);
        return [
            'empl_id' => $datum['empl_id'],
            'employee_name' => $datum['employee_name'],
            'last_name' => $datum['last_name'],
            'first_name' => $datum['first_name'],
            'middle_name' => $datum['middle_name'],
            'suffix_name' => $datum['suffix_name'],
            'postfix_name' => $datum['postfix_name'],
            'gender' => $datum['gender'],
            'birth_date' => $datum['birth_date'],
            'age' => $datum['age'],
            'department_code' => $datum['department_code'],
            'subdepartment_code' => $datum['subdepartment_code'],
            'division_code' => $datum['division_code'],
            'section_code' => $datum['section_code'],
            'position_code' => $datum['position_code'],
            'position_long_title' => $datum['position_long_title'],
            'position_short_title' => $datum['position_short_title'],
            'position_title1' => $datum['position_title1'],
            'position_title2' => $datum['position_title2'],
            'is_pghead' => $datum['is_pghead'],
            'salary_grade' => $datum['salary_grade'],
            'employment_type' => $datum['employment_type'],
            'employment_type_descr' => $datum['employment_type_descr'],
            'designate_department_code' => $datum['designate_department_code'],
            'active_status' => $datum['active_status'],
            // 'ao_status' => $datum['ao_tag']
        ];
    }
    public function saveUserCredentials($datum)
    {
        $emplo = UserEmployeeCredential::where('username', $datum['empl_id'])
            ->get();

        if (count($emplo) < 1) {
            $emc = new UserEmployeeCredential;
            $emc->username = $datum['empl_id'];
            $emc->password = md5('password1.');
            $emc->department_code = $datum['department_code'];
            $emc->division_code = $datum['division_code'];
            $emc->save();
        }
    }
    public function syncemployees_2(Request $request)
    {
        // $apiUrl = 'http://hris.dvodeoro.ph:91/api/ListOfEmployees4IPCR';

        // $apiUrl = 'http://hrisd:191/api/ListOfEmployees4IPCR';
        // $apiUrl = 'http://192.168.7.49:91/api/ListOfEmployees4IPCR';
        // $apiUrl = 'http://122.53.120.26:89/api/ListOfEmployees4IPCR';
        $apiUrl = 'http://hris.dvodeoro.local:91/api/ListOfEmployees4IPCR';
        // Initialize Guzzle HTTP client
        //$client = new Client();
        $data = [];
        try {
            // Initialize GuzzleHTTP client
            $client = new Client();

            // Make an HTTP POST request to the API URL
            $response = $client->post($apiUrl, [
                // If the API requires any specific data in the request body, you can add it here
                'form_params' => [
                    'key' => 'value',
                    // Add more parameters as needed
                ],
                // If the API requires headers or authentication, you can add them here
                'headers' => [
                    'Authorization' => 'Bearer YOUR_API_TOKEN', // Replace with your API token or credentials
                    // Add more headers if needed
                ],
            ]);

            // Get the JSON response from the API and decode it into an associative array

            $data = json_decode($response->getBody(), true);
            // dd($data);
            //dd($data);
            // Now $data contains the API response as an array, and you can process it as needed
            $length = count($data);
            $mapped_data = [];
            for ($i = 0; $i < $length; $i++) {
                // dd($i);
                $val = $this->saveUserEmployees($data[$i]);
                array_push($mapped_data, $val);
            }
            dd($mapped_data);
            $chunk_data = array_chunk($mapped_data, 1000);
            foreach ($chunk_data as $key => $value) {
                foreach ($value as $data) {
                    try {
                        $userEmployee = UserEmployees::where('empl_id', $data['empl_id'])->first();
                        if ($userEmployee) {
                            $userEmployee->update($data);
                        } else {
                            UserEmployees::create($data);
                        }
                        $this->saveUserCredentials($data);
                    } catch (\Exception $e) {
                        Log::error('Error updating employee: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle any errors that might occur during the API request
            return Inertia::render('ErrorView', [
                'message' => 'Failed to retrieve data from the API.',
            ]);
        }
        return redirect('/user/employees')
            ->with('message', 'Employee list synced successfully!');
        //dd("done");
    }
}
