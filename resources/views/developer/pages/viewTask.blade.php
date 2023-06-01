@extends('layouts.app')

@section('content')

@include('developer.layouts.mobilemenu')
<!-- END: Mobile Menu -->
<div class="flex">
    <!-- BEGIN: Side Menu -->
    @include('layouts.sidebar')
    <!-- END: Side Menu -->
    <!-- BEGIN: Content -->
    <div class="content">
        <!-- BEGIN: Top Bar -->
        @include('developer.layouts.topbar')
        <!-- END: Top Bar -->
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9">
                <div class="intro-y box col-span-12 xxl:col-span-6 mt-5">
                <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="font-medium">{{ $task->task_name }}</a> 
                                    <div class="text-gray-600 text-xs mt-0.5">Due date: {{ date('M d, Y , H:i A', strtotime($task->due_date))}}</div>
                                </div>
                                
                            </div>
                            <div class="flex flex-wrap lg:flex-nowrap items-center justify-center p-5">
                            

                                <div class="w-full lg:w-1/2 mb-4 lg:mb-0 mr-auto">
                                    
                                   <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Project</strong></div>
                                        <div>{{ $task->projectName }}</div>
                                    </div>
                                    <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Description</strong></div>
                                        <div>{{ $task->description }}</div>
                                    </div>

                                    <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Priority</strong></div>
                                        <div>{{ $task->priority }}</div>
                                    </div>

                                    <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Drive link</strong></div>
                                        <div><a href="{{ $task->drive_link }}">{{ $task->drive_link }}</a> </div>
                                    </div>
 
                                    <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Trello link</strong></div>
                                        <div><a href="{{ $task->trello_link }}">{{ $task->trello_link }}</a> </div>
                                    </div>

                                    <div class="text-gray-600 text-xs mt-4">
                                        <div class="mr-auto"><strong>Status</strong></div>
                                        <div>{{ $task->status }}</div>
                                    </div>

                                    @if(count($attchemnets) > 0)
                                       
 
                                       <div class="text-gray-600 text-lg mt-4">
                                       
                                            <div class="mr-auto"><strong>Task attachements</strong></div>
                                            <!-- <div class="task_attachemtns">
                                                @foreach($attchemnets as $attachement)
                                                <img data-action="zoom" src="{{url('/')}}/storage\app\public/{{ $attachement->file_url }}">
                                                @endforeach
                                            </div> -->
                                            <div class="task_attachemtns">
                                                    @foreach($attchemnets as $attachement)
                                                        
                                                    @php
                                                    $imgs = array('jpg', 'jpeg', 'png', 'svg');
                                                    $ext = pathinfo($attachement->file_url, PATHINFO_EXTENSION);
                                                    if( in_array( $ext, $imgs ))
                                                            {   
                                                                @endphp
                                                                <div>
                                                                    <img data-action="zoom" src="{{url('/')}}/storage\app\public/{{ $attachement->file_url }}">
                                                                </div>
                                                            @php
                                                            } 
                                                            else
                                                            {  
                                                                @endphp
                                                                <div class="text-center">
                                                                    <a target="_blank" class="tooltip" title="{{basename($attachement->file_url);}}" href="{{url('/')}}/storage\app\public/{{ $attachement->file_url }}">
                                                                     <img class="w-60"  src="{{ asset('dist/images/file.png') }}" style="max-width: 85px;">
                                                                    </a>
                                                                </div>
                                                               @php
                                                            }  
                                                            @endphp
                                                        
                                                        @endforeach
                                                    </div>
                                            
                                        </div>
                                       

                                      
                                    @endif

                                    <div class="text-gray-600 text-xs mt-4">
                                    
                                        <button class="btn btn-outline-primary py-1 px-2 update_task_status" data-status="done" data-task_id="{{ $task->id }}">Mark as done</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>


        </div>
    </div>
    <!-- END: Content -->
</div>
@endsection