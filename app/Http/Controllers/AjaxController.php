<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projects;
use App\Models\Tasks;
use App\Models\Notification;
use App\Models\DeveloperNotices;
use App\Models\paymentRecords;
use App\Models\paymentNotifications;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }
    
    public function getProjectsOfCompany(Request $request)
    {
        $company_id = $request->company_id;
        $projects = Projects::get()->where('company_id', $company_id);

        $projectsHtml = '';
        if(count($projects) > 0)
        {
            foreach($projects as $project)
            {
                $projectsHtml .= '<option value="'.$project->id.'">'.$project->name.'</option>';
            }
        }
        
        return $projectsHtml;
    }


    public function getTaskDetail(Request $request)
    {
        $projectid = $request->project_id;
        $project = Projects::find($projectid);
        
        $html = '<div class="sidebar_wraper">';
        $html .= '<p><strong>Project Name: </strong>'.$project->name.'</p>';
        $html .= '<p><strong>wp login url: </strong>'.$project->wp_login_url.'</p>';
        $html .= '<p><strong>wp user: </strong>'.$project->wp_user.'</p>';
        $html .= '<p><strong>wp Password: </strong>'.$project->wp_password.'</p>';
        $html .= '<p><strong>FTP/SFTP host: </strong>'.$project->ftp_host.'</p>';
        $html .= '<p><strong>FTP User: </strong>'.$project->ftp_user.'</p>';
        $html .= '<p><strong>FTP Password: </strong>'.$project->ftp_password.'</p>';
        $html .= '<p><strong>FTP Port: </strong>'.$project->ftp_port.'</p>';
        $html .= '<p><strong>Detail: </strong>'.$project->login_detail.'</p>';
        $html .= '</div>';
        echo $html;

        //return $project->login_detail;
    }

    public function getTaskDetailField(Request $request)
    {
        $projectid = $request->project_id;
        $project = Projects::find($projectid);
        
        $html = '<div class="sidebar_wraper">';
        $html .= '<p><strong>Detail: </strong>'.$project->login_detail.'</p>';
        $html .= '</div>';
        echo $html;

        //return $project->login_detail;
    }

    public function UpdateTaskStatus(Request $request)
    {
        $taskid = $request->task_id;
        $status = $request->status;
        if($status == 'Completed')
        {
            Tasks::where('id', $taskid)->update(array('status' => $status, 'completed_date' => date('Y-m-d H:i:s')));
        }
        else
        {
            Tasks::where('id', $taskid)->update(array('status' => $status));
        }
        
        
    }

    

    public function UpdateNotificationAsRead(Request $request)
    {
        $notification_id = $request->notification_id;

        Notification::where('user_id', $notification_id)->update(array('status' => 'Read'));
        
    }

    public function UpdateNoticeAsDismiss(Request $request)
    {
        $notice_id = $request->notice_id;

        DeveloperNotices::where('id', $notice_id)->update(array('status' => 'Dismiss'));
        
    }


    public function getSIngleProject(Request $request)
    {
        $project_id = $request->project_id;

        $project = Projects::find($project_id);
        
    }

    
    public function UpdatePaymentStatus(Request $request)
    {
        $month = $request->month;
        $status = $request->status;
        $user_id = $request->user_id;
        if($status == 'Paid')
        {
            paymentRecords::where('month', $month)->update(array('status' => 'Unpaid'));
        }
        else
        {
            paymentRecords::where('month', $month)->update(array('status' => 'Paid', 'paiddate' => date('Y-m-d H:i:s')));
            $notification = new paymentNotifications();
            $notification->user_id = $user_id;
            $notification->notification = 'Your payment for month of '.$month.' has been paid';
            $notification->status = 'Unread';
            $notification->save();
        }
        
    }

    public function UpdateToDosOrder(Request $request)
    {
        $position = $request->position;
        $i=1;
        
         foreach($position as $k=>$v){

            Tasks::where('id', $v)->update(array('sort' => $i));
            $i++;
        }
        
    }


    public function UpdatePaymentNotificationAsRead(Request $request)
    {
        $notification_id = $request->notification_id;

        paymentNotifications::where('user_id', $notification_id)->update(array('status' => 'Read'));
        
    }

    public function UpdatePaymentNoticeAsDismiss(Request $request)
    {
        $notice_id = $request->notice_id;

        paymentNotifications::where('id', $notice_id)->update(array('status' => 'Dismiss'));
        
    }


    

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
