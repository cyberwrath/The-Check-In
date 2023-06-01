<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tasks;
use Illuminate\Support\Arr;
use App\Models\TaskDiscussion;
use App\Models\Projects;
use App\Models\paymentRecords;



class DeveloperController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ViewTaskDetail($id)
    {   
        $id = base64_decode(base64_decode($id));
        $data = array();
        $Task = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('companies', 'companies.id', '=', 'tasks.company_id')
            ->select('users.name as developer', 'projects.name as projectName', 'projects.login_detail as credentials' , 'companies.name as CompanyName' , 'tasks.*')
            ->where('tasks.id', $id)
            ->first();
       
        $data['task'] = $Task;
        $data['discussions'] =  TaskDiscussion::get()->where('task_id', '=', $id);
        $data['attchemnets'] = Attachments::get()->where('task_id', '=', $id);

        return view('pages.viewTask', $data);
    } 

    public function ViewCompletedTask()
    {  
        $projectsFilter = Projects::orderBy('id', 'DESC')->get();
        $data['projectsFilter'] = $projectsFilter;
        $project =  request()->query('project');
           if(isset($project) && !empty($project ))
           {
            $data['tasks'] = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('companies', 'companies.id', '=', 'tasks.company_id')
            ->select('users.name as developer', 'projects.name as projectName' , 'companies.name as CompanyName' , 'tasks.*')
            ->where('tasks.status', '=', 'Completed')
            ->where('users.id', '=', Auth::user()->id)
            ->where('tasks.project_id', '=', $project)
            ->orderBy('tasks.id', 'desc')
            ->paginate(10);
           }
           else
           {
            $data['tasks'] = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('companies', 'companies.id', '=', 'tasks.company_id')
            ->select('users.name as developer', 'projects.name as projectName' , 'companies.name as CompanyName' , 'tasks.*')
            ->where('tasks.status', '=', 'Completed')
            ->where('users.id', '=', Auth::user()->id)
            ->orderBy('tasks.id', 'desc')
            ->paginate(10);
           }
        
        return view('developer.completedTasks', $data);
    }

    public function DevLoginCredentials()
    {   
        $user_id = Auth::user()->id;
        $data['projects'] = DB::table('projects')
        ->join('project_developers as pd', 'pd.project_id', '=', 'projects.id')
        ->join('users', 'users.id', '=', 'pd.user_id')
        ->select('users.name as developer' , 'projects.*')
        ->where('pd.user_id', '=', $user_id)
        ->get(); 

       return view('developer.loginDetails', $data);
    }


    public function paymentRecordsDev()
        {   

            $where = 'WHERE 1=1 AND pr.user_id='.Auth::user()->id;
            $month =  request()->query('month');
            $year =  request()->query('year');
            if(empty($year))
            {
                $year = date("Y");
            }
            for($i=0; $i<=5; $i++)
            {
                $years[] =  date("Y",strtotime("-".$i." year"));
            }
            if(isset($month) && !empty($month))
            {
                $where .= " AND pr.month='".$month."'";
            }
            else
            {
                $month = date('F', strtotime(date('Y-m-d')));
                $where .= " AND pr.month='".$month."'";
            }

            $where .= " AND pr.date between '".$year."-01-01' and '".$year."-12-31'";
            
            $data = array();
            $records = DB::select("SELECT u.name as developer,p.name as project,pr.* FROM `payment_records` AS pr
            INNER JOIN users as u ON u.id = pr.user_id
            INNER JOIN projects as p ON p.id = pr.project_id $where ORDER BY pr.id DESC");
            $data['records'] = $records;
            $data['months'] =  array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $data['_month'] =  $month;
            $data['years'] =  $years;
            $data['_year'] =  $year;
            $data['totalearned'] =  paymentRecords::where('user_id', '=', Auth::user()->id)->sum('amount'); 
            return view('developer.paymentRecords', $data);
        }
}


