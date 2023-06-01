@extends('layouts.app')

@section('content')

@include('developer.layouts.mobilemenu')
<!-- END: Mobile Menu -->
<style>
    .expandable_tr {

        display: none;
        width: 100%;

    }

    a.expandicon {
        background: #2271b1;
        padding: 3px;
        color: #ffffff;
        font-weight: 900;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        justify-content: center;
        align-items: end;
        line-height: 19px;
        font-size: 20px;

    }
</style>
<div class="flex">
    <!-- BEGIN: Side Menu -->
    @include('layouts.sidebar')
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('developer.layouts.topbar')
        <!-- END: Top Bar -->

        <!-- task in progress -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-12">


                              <div class="intro-y box col-span-12 xxl:col-span-6 mt-5">
                                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5 bg-theme-1">
                                    <h2 class="font-medium text-base mr-auto py-5 text-white">
                                        ToDo's List
                                    </h2>
                                </div>
                                <div class="p-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="latest-tasks-new" role="tabpanel" aria-labelledby="latest-tasks-new-tab">

                                        @if (count($tasks->InProgressTasks) > 0)
                                         @foreach($tasks->InProgressTasks as $task)
                                            <div class="flex flex-wraper items-center mt-4">
                                            <div class="first-coulmn border-l-2 border-theme-1 task_{{$task->priority}}">
                                                    <a href="{{route('viewtaskdetail',[base64_encode(base64_encode($task->id))])}}" class="font-medium">{{$task->task_name}}</a> 
                                                    <div class="text-gray-600">Due date: {{ date('M d, Y , H:i A', strtotime($task->due_date))}}</div>
                                                </div>
                                                <div class=" ml-auto second-coulmn">
                                                    <div class="grid grid-cols-2">
                                                        <div>
                                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                                <a class="btn btn-secondary w-20 ml-2 tooltip" title="View Task detail and discussion"  href="{{route('viewtaskdetail',[base64_encode(base64_encode($task->id))])}}">
                                                                    <i data-feather="eye" class="block mx-auto"></i>
                                                                </a>
                                                             </div>
                                                        </div>
                                                        <div>
                                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                               <a class="btn btn-secondary w-20 ml-2 get_task_detail tooltip" title="Fetch Project credentials" data-project_id="{{ $task->project_id }}"  data-mode="detail"  href="javascript:void(0)" data-toggle="modal" data-target="#header-footer-slide-over-preview">
                                                                 <i data-feather="database" class="block mx-auto"></i> 
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ml-auto third-coulmn">
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <div class="py-1 px-2 rounded-full text-xs bg-theme-1 text-white text-center cursor-pointer font-medium tooltip" title="Company">{{$task->company->name}}</div>
                                                        <div class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white text-center cursor-pointer font-medium tooltip"  title="Project">{{$task->project->name}}</div>
                                                    </div>
                                                </div>
                                                <input class="fourth-coulmn form-check-switch ml-auto update_task_status tooltip" data-status="done" data-task_id="{{ $task->id }}" type="checkbox" title="Mark task as done" >
                                            </div>
                                            
                                        @endforeach 
                                        @else 
                                            There is no task in ToDo's list
                                        @endif  
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="intro-y box col-span-12 xxl:col-span-6 mt-5">
                                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5 bg-theme-9">
                                    <h2 class="font-medium text-base mr-auto py-5 text-white">
                                      Tasks Done
                                    </h2>
                                </div>
                                <div class="p-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="latest-tasks-new" role="tabpanel" aria-labelledby="latest-tasks-new-tab">

                                           @if (count($tasks->DoneTasks) > 0)
                                            @foreach($tasksdone->DoneTasks as $task)
                                            <div class="flex flex-wraper items-center mt-4">
                                                <div class="first-coulmn border-l-2 border-theme-1 task_{{$task->priority}}">
                                                    <a href="{{route('viewtaskdetail',[base64_encode(base64_encode($task->id))])}}" class="font-medium">{{$task->task_name}}</a> 
                                                    <div class="text-gray-600">Due date: {{ date('M d, Y , H:i A', strtotime($task->due_date))}}</div>
                                                </div>
                                                <div class="second-coulmn ml-auto">
                                                    <div class="grid grid-cols-2">
                                                        <div>
                                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                                <a class="btn btn-secondary w-20 ml-2 tooltip" title="View Task detail and discussion"  href="{{route('viewtaskdetail',[base64_encode(base64_encode($task->id))])}}">
                                                                    <i data-feather="eye" class="block mx-auto"></i>
                                                                </a>
                                                             </div>
                                                        </div>
                                                        <div>
                                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2 xl:col-span-1">
                                                               <a class="btn btn-secondary w-20 ml-2 get_task_detail tooltip" title="Fetch Project credentials" data-project_id="{{ $task->project_id }}"  data-mode="detail"  href="javascript:void(0)" data-toggle="modal" data-target="#header-footer-slide-over-preview">
                                                                 <i data-feather="database" class="block mx-auto"></i> 
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="third-coulmn ml-auto">
                                                    <div class="grid grid-cols-3 gap-2">
                                                        <div class="py-1 px-2 rounded-full text-xs bg-theme-1 text-white text-center cursor-pointer font-medium tooltip" title="Company">{{$task->company->name}}</div>
                                                        <div class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white text-center cursor-pointer font-medium tooltip"  title="Project">{{$task->project->name}}</div>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            
                                        @endforeach 
                                        @else 
                                            There is no task mark as done
                                        @endif  
                                        </div>
                                    </div>
                                </div>
                            </div>

                          
            </div>
            <div class="col-span-12 xxl:col-span-3">
                <div class="xxl:border-l border-theme-5 -mb-10 pb-10">
                    <div class="xxl:pl-6 grid grid-cols-12 gap-6">

                        


                    </div>
                </div>
            </div>
            @include('snippets.slideover')
        </div>

         <!-- task done -->
        

    </div>
    <!-- END: Content -->
</div>
<script>
    jQuery('.expandicon').on('click', function()

        {

            jQuery(".expandicon").html("+");

            var obj = jQuery(this);

            obj.html("-");

            var id = obj.closest('tr').data('id');

            jQuery(".expandable_tr").hide();

            jQuery("#expandable_tr_" + id).css('display', 'table-cell');



        });
</script>
@endsection