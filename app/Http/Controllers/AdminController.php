<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;
use App\Models\GroupFriends;
use App\Models\GroupUser;
use Illuminate\Support\Arr;
use App\Models\User;

class AdminController extends Controller
{   

    public function __construct()
    {
        $this->middleware('auth');
    }

    

    // company functions

    public function addGroups()
    {
       $data['friends'] = User::where('role', '=', 'friend')->get();
       return view('admin.forms.addGroupForm', $data);
    }
    public function GroupDetail($id)
        {   
            $group_id = base64_decode($id);

            $group = Group::where('id',$group_id)->first();
            $group_date = $group->created_at;
            $start = strtotime($group_date);
            $end = strtotime(date('Y-m-d H:i:s'));
            $days = ceil(abs($end - $start) / 86400);
            
            $data['groupName'] = $group;
            $data['days'] = $days;
            $data['group_friends'] = DB::table('group_user')
            ->join('users', 'users.id', '=', 'group_user.user_id')
            ->select('users.*', 'group_user.group_id')
            ->where('group_user.group_id', $group_id)
            ->orderBy('users.id', 'ASC')
            ->get();
             
            $pairs = $this->GetRandomPairsOfUsers($group_id, $data['group_friends']);
            array_unshift($pairs,"");
            unset($pairs[0]);
            $data['pairs'] = $pairs;
            $data['currentweek'] = $this->getCurrentGroupWeeks($days, $pairs);
            $data['friends'] = User::where('role', '=', 'friend')->get();
            return view('admin.GroupFriends', $data); 

        }

    public function getCurrentGroupWeeks($days, $pairs)
    {
        return (int)(ceil($days / 7)); 
    }

    
    public function GetRandomPairsOfUsers($id, $users, $week=1)
    {   

        $group_id = base64_decode($id);
        $friends = array(); 
        foreach($users as $user)
        {
            $friends[] = $user->name.'—'.$user->phone;
        }

        $res = $this->pairFriends($friends);

        return $res;
    }
    
    
    function buildPairIndexes($n) {
        if ($n % 2 !== 0) {
            //throw new Exception($n . ' is an odd number');
        }
        $pairings = array();
        $max = $n - 1;
        for ($i = 0; $i < $max; $i++) {
            $pairing = array(array($max, $i));
            for ($k = 1; $k < ($n / 2); $k++) {
                $pairing[] = array(($i + $k) % $max, ($max + $i - $k) % $max);
            }
            $pairings[] = $pairing;
        }
        return $pairings;
    }
    
    function pairFriends($friends) {
        $pairings = $this->buildPairIndexes(count($friends));
        $pairIxToPlayer = function ($i) use ($friends) {
            return $friends[($i + 1) % count($friends)];
        };
        return array_map(function ($pairing) use ($pairIxToPlayer) {
            return array_map(function ($pair) use ($pairIxToPlayer) {
                return array_map($pairIxToPlayer, $pair);
            }, $pairing);
        }, $pairings);
    }
      
      


   public function pairssampling($chars, $size, $combinations = array()) {

        # if it's the first iteration, the first set 
        # of combinations is the same as the set of characters
        if (empty($combinations)) {
            $combinations = $chars;
        }
    
        # we're done if we're at size 1
        if ($size == 1) {
            return $combinations;
        }
    
        # initialise array to put new values in
        $new_combinations = array();
    
        # loop through existing combinations and character set to create strings
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                if($char != $combination)
                {
                    $new_combinations[] = array($combination, $char);
                }
                
            }
        }
    
        # call same function again for the next iteration
        return $this->pairssampling($chars, $size - 1, $new_combinations);
    
    }

    public function createGroup(Request $request)
        {   
            $friends = Array();
            $validatedData = $request->validate([
                'group_name' => ['required'],
                'friends' => ['required'],
            ]);

            $group = isset($request->group_id) && !empty($request->group_id) ? Group::find($request->group_id) : new Group;

            $group->group_name = $request->group_name;
            $friends = $request->friends;
             
            isset($request->group_id) && !empty($request->group_id) ? $group->update() : $group->save();
            
            
            if(count($friends) > 0)
            {   
                $data = [];
                foreach($friends as $friend)
                    {
                        $data[] = array(
                            'group_id'    => $group->id,
                            'user_id'    => $friend
                        );
                    }
                DB::table('group_user')->insert($data);

            }
            return redirect()->route('home')->with('success','Group Form Executed successfully.');

        }


        public function assignFriends(Request $request)
        {   
            $friends = Array();
            $validatedData = $request->validate([
                'friends' => ['required'],
            ]);
            $friends = $request->friends;
            $group = $request->group;
            if(count($friends) > 0)
            {   
                $data = [];
                foreach($friends as $friend)
                    {
                        $data[] = array(
                            'group_id'    => $group,
                            'user_id'    => $friend
                        );
                    }
                DB::table('group_user')->insert($data);
                return redirect()->back()->with('success','Users Assigned');

            }
        }

        public function deleteCompany($id)
        {   
            Company::find($id)->delete();
            return redirect()->route('company')->with('success','Company Deleted successfully');
        }




        // projects functions

        
        public function ViewProject()
            {
                $data = array();
                $projectsFilter = Projects::orderBy('id', 'DESC')->get();

                $project =  request()->query('project');
                if(isset($project) && !empty($project ))
                {
                    $projects = DB::table('projects')
                    ->join('companies', 'companies.id', '=', 'projects.company_id')
                    ->select('companies.name as CompanyName' , 'projects.*')
                    ->where('projects.id', $project)
                    ->orderBy('projects.id', 'desc')
                    ->get(); 
                }
                else
                {
                    $projects = DB::table('projects')
                    ->join('companies', 'companies.id', '=', 'projects.company_id')
                    ->select('companies.name as CompanyName' , 'projects.*')
                    ->orderBy('projects.id', 'desc')
                    ->get(); 
                }
                $data['projects'] = $projects;
                $data['projectsFilter'] = $projectsFilter;

                return view('admin.projects', $data);
            }

        public function LoginCredentials()
            {
                $data = array();
                $projects = Projects::get();

                $projects = DB::table('projects')
                ->Leftjoin('companies', 'companies.id', '=', 'projects.id')
                ->select('companies.name as CompanyName' , 'projects.*')
                ->get();
                //dd($projects);
                return view('admin.loginDetails', ['projects' => $projects]);
            }

        ////////////////////////////////////////

        public function paymentRecords()
        {   

            $where = 'WHERE 1=1';
            $month =  request()->query('month');
            $developer =  request()->query('developer');
            $year =  request()->query('year');
            if(empty($year))
            {
                $year = date("Y");
            }
            if(isset($month) && !empty($month))
            {
                $where .= " AND pr.month='".$month."'";
            }
            if(isset($developer) && !empty($developer))
            {
                $developer = $developer;
            }
            else
            {
                $query =  User::where('role', '=', 'developer')->first();
                
                $developer = $query->id;
            }

            $where .= " AND pr.user_id=".$developer;

            $where .= " AND pr.date between '".$year."-01-01' and '".$year."-12-31'";
            
            
            $data = array();
            $records = DB::select("SELECT u.name as developer,p.name as project,pr.* FROM `payment_records` AS pr
            INNER JOIN users as u ON u.id = pr.user_id
            INNER JOIN projects as p ON p.id = pr.project_id $where ORDER BY pr.id DESC");
            for($i=0; $i<=5; $i++)
            {
                $years[] =  date("Y",strtotime("-".$i." year"));
            }
            
            //"SELECT status FROM `payment_records` WHERE month = 'October' GROUP BY status;";
            $data['records'] = $records;
            $data['months'] =  array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $data['developers'] =  User::get()->where('role', '=', 'developer');
            
            $data['_month'] =  $month;
            $data['_developer'] =  $developer;
            $data['years'] =  $years;
            $data['_year'] =  $year;
            return view('admin.paymentRecords', $data);
        }

        public function addPyment()
        {
            $data = Array();
            
            $data['companies'] =  Company::get();
            $data['projects'] =  Projects::get();
            $data['developers'] =  User::get()->where('role', '=', 'developer');
            $data['months'] =  array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $data['currentMonth'] = date('F', strtotime(date('Y-m-d')));
            
            return view('admin.forms.addPaymentRecordForm', $data);
        }

        public function createPaymentRecord(Request $request)
        {
            
            $validatedData = $request->validate([
                'company' => ['required'],
                'project' => ['required']
            ]);

            $precords = new paymentRecords();
            $precords->user_id = $request->assigned_to;
            $precords->company_id = $request->company;
            $precords->project_id = $request->project;
            $precords->month = date('F', strtotime($request->date));
            $precords->date = date('Y-m-d H:i:s', strtotime($request->date));
            $precords->hours = $request->hours;
            $precords->amount = $request->amount;
            $precords->remarks = $request->remarks;
            $precords->status = 'Unpaid';
            $precords->paiddate = date('Y-m-d H:i:s');
            $precords->save();
            return redirect()->back()->with('success', 'Payment record added successfully');
        }

        public function deletePaymentRecord($id)
        {   
            paymentRecords::find($id)->delete();
            return redirect()->back()->with('success', 'Record deleted successfully');
        }

        ////////////////////////////////////////
        public function DeveloperNotices()
        {
            $data = array();
            $notices = DB::table('developer_notices')
                ->join('users', 'users.id', '=', 'developer_notices.user_id')
                ->select('users.name as DevName' , 'developer_notices.*')
                ->orderBy('id', 'desc')
                ->get();
            $data['notices'] = $notices;
           
            return view('admin.Notices', $data);
        }

        public function AddNoticeForm()
        {   
            $data = array();
            $data['developers'] =  User::where('role', '=', 'developer')->get();
            return view('admin.forms.addNoticeForm', $data);
        }

        public function createNotice(Request $request)
        {   
     
           $validatedData = $request->validate([
                'notice' => ['required']
            ]);

          
            //$proj = new Projects;
            
            $notice =  new DeveloperNotices;
            
            $notice->user_id = $request->developer;
            $notice->notice = $request->notice;
            
            $notice->save();

            return redirect()->back()->with('success', 'Notice has been adeded');
            
        }

        public function deleteNotice($id)
        {
            DeveloperNotices::find($id)->delete();
            return redirect()->route('notices')->with('success','Notice removed successfully');
        }

        
        ////////////////////////////////////////
        public function addProject(Request $request,  $id)
        {   

            $data = array();
            $final_ids = array();
            $data['company_id'] =  base64_decode($id);
            $projectid = $request->input('projectid');
            $project = Projects::find($projectid);
            $data['project'] =  $project;
            $data['companies'] = Company::get();
            $data['developers'] =  User::get()->where('role', '=', 'developer');
            $selectec_devs = ProjectDeveloper::get()->where('project_id', $projectid)->pluck('user_id');

            
            if($selectec_devs)
            {
                foreach($selectec_devs as $selectec_dev)
                {
                    $final_ids[] = $selectec_dev;
                }
            }

            $data['selectec_devs'] = $final_ids;

            //dd($data);
            return view('admin.addProjectForm', $data);
        }

        

        public function createProjects(Request $request)
            {   

                
                
                
                $validatedData = $request->validate([
                    'name' => ['required'],
                    'url' => ['required'], 
                    'technology' => ['required'],
                    'started_on' => ['required'],
                    'due_date' => ['required'],
                    'technology' => ['required']
                ]);

              
                //$proj = new Projects;
                $developers = $request->assigned_to;
                $proj = isset($request->project_id) && !empty($request->project_id) ? Projects::find($request->project_id) : new Projects;
        
                $proj->company_id = $request->company_id;
                $proj->name = $request->name;
                $proj->url = $request->url;
                $proj->technology = $request->technology;
                $proj->drive_link = $request->drive_link;
                $proj->started_on = date('Y-m-d H:i:s', strtotime($request->started_on));
                $proj->due_date = date('Y-m-d H:i:s', strtotime($request->due_date));
                $proj->total_working_time = $request->total_working_time;
                $proj->wp_login_url = $request->wp_login_url;
                $proj->wp_user = $request->wp_user;
                $proj->wp_password = $request->wp_password;
                $proj->ftp_host = $request->ftp_host;
                $proj->ftp_user = $request->ftp_user;
                $proj->ftp_password = $request->ftp_password;
                $proj->ftp_port = $request->ftp_port;
                $proj->login_detail = $request->login_detail;
                
                isset($request->project_id) && !empty($request->project_id) ? $proj->update() : $proj->save();
                $ins_project_id = $proj->id;
                if(isset($request->project_id) && !empty($request->project_id))
                {   
                    
                     
                    
                    ProjectDeveloper::where('project_id', $request->project_id)->delete();
                   
                    $data = [];
                    foreach($developers as $developer)
                    {
                        $data[] = array(
                            'project_id'    => $request->project_id,
                            'user_id'    => $developer, 
                            'created_at'    => date("y-m-d H:i:s"),
                            'updated_at'    => date("y-m-d H:i:s"),
                        );
                    }

                    DB::table('project_developers')->insert($data);
                    
                    return redirect()->back()->with('success', 'Project Form  Has Been executed');
                }
                else
                {   
                    if(count($developers) > 0)
                    {   
                        $data = [];
                        foreach($developers as $developer)
                        {
                            $data[] = array(
                                'project_id'    => $ins_project_id,
                                'user_id'    => $developer, 
                                'created_at'    => date("y-m-d H:i:s"),
                                'updated_at'    => date("y-m-d H:i:s"),
                            );
                        }

                        DB::table('project_developers')->insert($data);
                    }
                    return redirect()->route('project')->with('success', 'Project Form  Has Been executed');
                }
            }

    public function deleteDeveloper($id)
        {
            Projects::find($id)->delete();
            return redirect()->route('home')->with('success','Project removed successfully');
        }
 
    public function deleteProject($id)
        {
            Projects::find($id)->delete();
            return redirect()->route('home')->with('success','Project Deleted successfully');
        }


    // Tasks functions
    
    
    public function tasks()
        {   
            $data = array();
            //$data['tasks'] = Tasks::paginate(15);
            $data['tasks'] = DB::table('tasks')
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->join('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('companies', 'companies.id', '=', 'tasks.company_id')
            ->select('users.name as developer', 'projects.name as projectName' , 'companies.name as CompanyName' , 'tasks.*')
            ->orderBy('tasks.id', 'desc')
            ->paginate(10);
            

            return view('admin.tasks', $data);
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
                ->orderBy('tasks.id', 'desc')
                ->paginate(10);
           }
        
            //dd($data);
        return view('admin.completedTasks', $data);
    }
 
    public function addTask($company, $project, $taskid)
    {   
        
        $data = Array();
        $data['companies'] = Company::get();
        $data['project_id'] = base64_decode($project);
        $data['company_id'] = base64_decode($company);
        //$data['task'] = Tasks::find($taskid);
        $data['task'] = Tasks::with('attachements')->find($taskid);
        if(base64_decode($company) != 0)
        {
            $data['projects'] =  Projects::get()->where('company_id', base64_decode($company));
        } 
        else
        {
            $data['projects'] =  Projects::get();
        }
        $data['developers'] =  User::get()->where('role', '=', 'developer');
        $data['discussions'] =  TaskDiscussion::get()->where('task_id', '=', $taskid);
        
        $taskatac = Tasks::with('attachements')->find($taskid);

        // echo "<pre>"; print_r($taskatac->toArray());
        // exit;

        return view('admin.forms.addTaskForm', $data);
    }

    public function createTask(Request $request)
    {   
       
        $validatedData = $request->validate([
            'company' => ['required'],
            'project' => ['required'], 
            'name' => ['required'],
            'due_date' => ['required']
        ]);

         

        $task = isset($request->task_id) && !empty($request->task_id) ? Tasks::find($request->task_id) : new Tasks;

        $task->company_id = $request->company;
        $task->project_id = $request->project;
        $task->user_id = $request->assigned_to;
        $task->task_name = $request->name;
        $task->description = $request->description;
        $task->priority = $request->priority;
        $task->drive_link = $request->drive_link;
        $task->trello_link = $request->trello_link;
        $task->due_date = date('Y-m-d H:i:s', strtotime($request->due_date));
        $task->status = $request->status;
        isset($request->task_id) && !empty($request->task_id) ? $task->update() : $task->save();
        if(isset($request->task_id) && !empty($request->task_id))
        {   
            //$this->CreateNotofication($request->assigned_to, $request->task_id, 'task' , 'Task have been Updated');
            return redirect()->back()->with('success', 'Task Form executed successfully');
        }
        else
        {   
            $this->CreateNotofication($request->assigned_to, $task->id, 'task' , 'New task is created for you');
            return redirect()->route('tasks')->with('success', 'Task Form executed successfully');
        }

        
    }

    public function CreateNotofication($user_id, $module_id, $moduleName, $notificationText)
    {
        $notification = new Notification;
        $notification->user_id = $user_id;
        $notification->module_id = $module_id;
        $notification->module = $moduleName;
        $notification->notification = $notificationText;
        $notification->status = 'Unread';
        $notification->save();

    }

    public function deleteTask($id)
        {
            Tasks::find($id)->delete();
            return redirect()->route('tasks')->with('success','Task Deleted successfully');
        }

    public function UploadTaskAttachemnt(Request $req)
        {   
            $attachemnt = New Attachments;
            if($req->file()) 
            {
                $fileName = time().'_'.$req->file->getClientOriginalName();
                $filePath = $req->file('file')->storeAs('taskattachements', $fileName, 'public');
               
                $attachemnt->user_id = Auth::user()->id;
                $attachemnt->task_id = $req->task_id;
                $attachemnt->file_name = time().'_'.$req->file->getClientOriginalName();
                $attachemnt->file_url =  $filePath;
                $attachemnt->save();
                $attachemnt_id = $attachemnt->id;

                echo json_encode(array('attachment_id'=>$attachemnt_id));
            }
        }
    
        public function RemoveTaskAttachment(Request $req)
        {    

            $attachment_id = $req->attachment_id;
            ///Attachments::get()->where('id', $attachment_id)->pluck('groupName');
            Attachments::find($attachment_id)->delete();
        }


        // discussion functions

        public function UpdateTaskDiscussion(Request $req)
        {   
            $disc = New TaskDiscussion;
            $task_id = $req->task_id;
            $chatext = $req->chatext;

            $disc->user_id = Auth::user()->id;
            $disc->task_id = $req->task_id;
            $disc->comment = $req->chatext;
            $disc->save();
            $disc_id = $disc->id;

            //TaskDiscussion::find($disc_id);

        }
        
}
