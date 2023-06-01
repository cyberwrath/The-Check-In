@extends('layouts.app')

@section('content')
 
@include('admin.layouts.mobilemenu')
 <!-- END: Mobile Menu -->
        <div class="flex">
            <!-- BEGIN: Side Menu -->
            @include('layouts.sidebar')
            <!-- END: Side Menu -->
            <!-- BEGIN: Content -->
            <div class="content">
                <!-- BEGIN: Top Bar -->
                @include('admin.layouts.topbar')
                <!-- END: Top Bar -->
                <h2 class="intro-y text-lg font-medium mt-10">
                    Tasks List
                </h2>
                <div class="z-index-99999">
                                    <div class="mt-2">
                                        
                                        <select data-search="true" data-view="tasks" data-area="developer" class="tail-select w-full projects_filter">
                                        <option value="">Select Project</option>
                                        @if (count($projectsFilter) > 0)
                                            @foreach($projectsFilter as $project)
                                            <option value="{{$project->id}}" {{ isset($_GET['project']) && @$_GET['project'] == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                                            @endforeach 
                                            @endif
                                        </select>
                                        </div>
                                    </div>

                <div class="intro-y box col-span-12 xxl:col-span-6 mt-5">
                                <div class="flex items-center px-5 py-5 sm:py-0 border-b border-gray-200 dark:border-dark-5 bg-theme-1">
                                    <h2 class="font-medium text-base mr-auto py-5 text-white">
                                        Completed Tasks
                                    </h2>
                                    
                                    
                                </div>
                                <div class="p-5">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="latest-tasks-new" role="tabpanel" aria-labelledby="latest-tasks-new-tab">

                                        @if (count($tasks) > 0)
                                           @foreach($tasks as $task)
                                            <div class="flex items-center mt-4">
                                                <div class="border-l-2 border-theme-1 pl-4 task_{{$task->priority}}">
                                                    <a href="{{route('viewtaskdetail',[base64_encode(base64_encode($task->id))])}}" class="font-medium">{{$task->task_name}}</a> 
                                                    <div class="text-gray-600">Due date: {{ date('M d, Y , H:i A', strtotime($task->due_date))}}</div>
                                                    <div class="text-gray-600">Completed date: {{ date('M d, Y , h:i A', strtotime($task->completed_date))}}</div>
                                                </div>
                                                <div class=" pl-4 ml-auto">
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
                                                
                                                
                                            </div>
                                            
                                        @endforeach 
                                        @else 
                                            There is no task completed
                                        @endif  
                                        </div>
                                    </div>
                                </div>
                            </div>
              @include('snippets.slideover')
               <!-- BEGIN: Responsive Table -->
               {{ $tasks->links() }}
            <!-- END: Content -->
        </div>
        
@endsection
