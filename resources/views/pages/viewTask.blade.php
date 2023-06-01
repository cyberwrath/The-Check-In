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
            <div class="col-span-12 xxl:col-span-6">
                <div class="intro-y box col-span-12 xxl:col-span-6 mt-5">
                <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                                 <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="text-heading">{{ $task->task_name }}</a><a style="position: absolute;top: 10px;" class="btn btn-secondary w-20 ml-2 get_task_detail tooltip" title="Fetch Project credentials" data-project_id="{{ $task->project_id }}"  data-mode="detail"  href="javascript:void(0)" data-toggle="modal" data-target="#header-footer-slide-over-preview">
                                               <i data-feather="database" class="block mx-auto"></i> 
                                           </a> 
                                    <div class="text-gray-600 text-lg mt-0.5">
                                        Due date: {{ date('M d, Y , H:i A', strtotime($task->due_date))}}
                                    </div>
                                    <div class="mt-1"> 
                                        <div class="grid grid-cols-3 gap-2">
                                            <div class="py-1 px-2 rounded-full text-xs bg-theme-6 text-white text-center cursor-pointer font-medium tooltip" title="Project">{{$task->projectName}}</div>
                                            <div class="py-1 px-2 rounded-full text-xs bg-theme-1 text-white text-center cursor-pointer font-medium tooltip" title="Task status">{{ $task->status }}</div>
                                            <div class="py-1 px-2 rounded-full text-xs bg-theme-9 text-white text-center cursor-pointer font-medium tooltip"  title="Priority">{{ $task->priority }}</div>

                                        </div>
                                    </div> 

                                </div>
                                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                        <label class="form-check-label ml-0 sm:ml-2" for="show-example-6">
                                        <a href="{{ url()->previous() }}" class="btn btn-danger shadow-md mr-2">Go Back</a>
                                        </label>
                                    </div>
                            </div>
                            <div class="flex flex-wrap lg:flex-nowrap items-center justify-center p-5">
                            

                                <div class="w-full lg:w-1 mb-4 lg:mb-0 mr-auto">
                                    
                                   <!-- <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Project</strong></div>
                                        <div>{{ $task->projectName }}</div>
                                    </div> -->

                                    <div class="text-gray-600 text-lg mt-4">
                                        <!-- <div class="mr-auto text-heading"><strong>Description</strong></div> -->
                                        <div>{!! $task->description !!}</div>
                                    </div>

                                    <!-- <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Priority</strong></div>
                                        <div>{{ $task->priority }}</div>
                                    </div> -->
                                    @if(filter_var($task->drive_link, FILTER_VALIDATE_URL) === TRUE)
                                    <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Drive link</strong></div>
                                        <div><a target="_blank" href="{{ $task->drive_link }}">{{ $task->drive_link }}</a> </div>
                                    </div>
                                    @endif

                                    @if(filter_var($task->trello_link, FILTER_VALIDATE_URL) === TRUE)
                                    <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Trello link</strong></div>
                                        <div><a target="_blank" href="{{ $task->trello_link }}">{{ $task->trello_link }}</a> </div>
                                    </div>
                                    @endif

                                    <!-- <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Status</strong></div>
                                        <div>{{ $task->status }}</div>
                                    </div> -->

                                    <!-- <div class="text-gray-600 text-lg mt-4">
                                        <div class="mr-auto"><strong>Project Credentials</strong></div>
                                        <div>{!! html_entity_decode($task->credentials) !!}</div>
                                    </div> -->

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

                                    @if($task->status == 'ToDo')
                                    <div class="text-gray-600 text-lg mt-4">
                                        <button class="btn btn-outline-primary py-1 px-2 update_task_status" data-status="done" data-task_id="{{ $task->id }}">Mark as done</button>
                                    </div>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>

            @if(isset($task->id))
            <div class="intro-y col-span-12 lg:col-span-6 mt-5">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                        <div class="flex items-center">
                            <div class="ml-3 mr-auto">
                                <div class="text-lg text-base">Task <span style="color:#1C3FAA">{{ $task->task_name }}</span>  Discussion</div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="overflow-y-scroll scrollbar-hidden px-5 pt-5 flex-1" id="chatdiv">
                        @if(count($discussions) > 0)

                        @foreach($discussions as $discussion)
 
                            @if(Auth::user()->id != $discussion->user_id)
                            <div>
                                <div  class="chat__box__text-box flex items-end float-left mb-4">
                                    <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                                        <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-2.jpg') }}">
                                    </div>
                                    <div class="bg-gray-200 dark:bg-dark-5 px-4 py-3 text-gray-700 dark:text-gray-300 rounded-r-md rounded-t-md">
                                        <div class="chat_comment">{!! nl2br($discussion->comment) !!}</div> 
                                        <div class="chat_date mt-1 text-sm text-gray-600">{{ date('d, M Y h:i A', strtotime($discussion->created_at)) }}</div>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                            </div> 
                            
                            @else
                            <div>
                                <div class="chat__box__text-box flex items-end float-right mb-4">
                                    <div class="skyblue-bg px-4 py-3 text-white rounded-l-md rounded-t-md">
                                    <div class="chat_comment">{!! nl2br($discussion->comment) !!}</div> 
                                        <div class="chat_date mt-1 text-sm text-theme-22">{{ date('d, M Y h:i A', strtotime($discussion->created_at)) }}</div>
                                    </div>
                                    <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                        <img alt="Midone Tailwind HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-1.jpg') }}">
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                            
                            @endif
                        
                          @endforeach
                        @else
                        <div class="chat__box__text-box flex items-end float-left mb-4">
                            No Comment Added yet
                        </div>
                        @endif
                     </div>
                    <div class="pt-4 pb-10 sm:py-4 flex items-center border-t border-gray-200 dark:border-dark-5">
                        <textarea id="chat_text" class="chat__box__input form-control dark:bg-dark-3 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:ring-0" rows="1" placeholder="Type your message..."></textarea>
                        <a id="sendchat" data-task_id="{{ $task->id }}" href="javascript:;" class="w-8 h-8 sm:w-10 sm:h-10 block bg-theme-1 text-white rounded-full flex-none flex items-center justify-center mr-5"> <i data-feather="send" class="w-4 h-4"></i> </a>
                    </div>
                </div>
            </div>
            @endif


        </div>
    </div>
    @include('snippets.slideover')
    <!-- END: Content -->
</div>
@endsection