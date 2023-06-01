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
        <div class="intro-y flex items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                {{ isset($task->id) ? "Update" : 'Add' }} Task
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <form id="adtaskform" method="POST" action="{{ route('createTask') }}">
                        @csrf
                        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                            <input type="hidden" name="task_id" value="{{ isset($task->id) ? $task->id : '' }}">
                            <div class="intro-x mt-8">
                                <label for="regular-form-1" class="form-label">Company</label> <label class="form-check-label ml-0 sm:ml-2" for="show-example-6">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#header-footer-modal-preview" class="btn btn-danger shadow-md mr-2 py-0">+</a>
                                </label>
                                <select name="company" id="taskcompany" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ ( $company->id == $company_id) ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <br>

                                <label for="regular-form-1" class="mt-4 form-label">Project</label> <label class="form-check-label ml-0 sm:ml-2" for="show-example-6">
                                    <a href="{{ route('addProject', ['id' => base64_encode(0), 'projectid' => 0]) }}" class="btn btn-danger shadow-md mr-2 py-0">+</a>
                                </label>
                                <select name="project" id="taskproject" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}" {{ ( $project->id == $project_id) ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>

                                @error('project')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <input id="task_name" placeholder="Task Name *" type="text" value="{{ isset($task->task_name) ? $task->task_name : '' }}" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="regular-form-1" class="mt-4 form-label">Description</label>
                                <textarea name="description" id="editor1" rows="10" cols="80">
                                {{ isset($task->description) ? $task->description : '' }} {{ old('description') }}
                                </textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <script>
                                    CKEDITOR.replace('editor1');
                                </script>

                                <label for="regular-form-1" class="mt-4 form-label">Priority</label>
                                <select name="priority" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="normal" {{ isset($task->priority) &&  $task->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="medium" {{ isset($task->priority) &&  $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ isset($task->priority) &&  $task->priority == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                <input id="drive_link" placeholder="Drive Link *" value="{{ isset($task->drive_link) ? $task->drive_link : '' }}" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" name="drive_link" value="{{ old('drive_link') }}">
                                @error('drive_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> 
                                @enderror

                                <input id="trello_link" placeholder="Trello Link *" value="{{ isset($task->trello_link) ? $task->trello_link : '' }}" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" name="trello_link" value="{{ old('trello_link') }}">
                                @error('trello_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="regular-form-1" class="mt-4 form-label">Assigned to</label>
                                <select name="assigned_to" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="">Select Developer</option>
                                    @foreach ($developers as $developer)
                                    <option value="{{ $developer->id }}" {{ isset($task->user_id) &&  $task->user_id == $developer->id ? 'selected' : '' }}>{{ $developer->name }}</option>
                                    @endforeach
                                </select>

                                <label for="regular-form-1" class="mt-4 form-label">Due date</label>
                                <input id="due_date" placeholder="Due date *" value="{{ isset($task->due_date) ? $task->due_date : '' }}" type="text" class=" datepicker intro-x login__input form-control py-3 px-4 border-gray-300 block" data-single-mode="true" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                <label for="regular-form-1" class="mt-4 form-label">Status</label>
                                <select name="status" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="ToDo" {{ isset($task->status) &&  $task->status == 'ToDo' ? 'selected' : '' }}>ToDo</option>
                                    <option value="Done" {{ isset($task->status) &&  $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                                    <option value="Completed" {{ isset($task->status) &&  $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="OnHold" {{ isset($task->status) &&  $task->status == 'OnHold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                                @if(isset($task->id))
                                <label for="regular-form-1" class="mt-4 form-label">Task attachments</label>
                                <div class="dz-clickable myDrop" id="myDrop">
                                    <div class="dz-default dz-message " data-dz-message="">
                                        <span>Upload file here</span>
                                    </div>
                                </div>
                                    @if(count($task->attachements) > 0)
                                       
                                       
                                       <div class="task_attachemtns">
                                       @foreach($task->attachements as $attachement)
                                          
                                       @php
                                       $imgs = array('jpg', 'jpeg', 'png', 'svg');
                                       $ext = pathinfo($attachement->file_url, PATHINFO_EXTENSION);
                                       if( in_array( $ext, $imgs ))
                                            {   
                                                @endphp
                                                <div>
                                                        <img data-action="zoom" src="{{url('/')}}/storage\app\public/{{ $attachement->file_url }}">
                                                        <a href="javascript:void(0);" class="delete_attachment" data-attachment_id="{{ $attachement->id }}">Delete</a>
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
                                                    <a href="javascript:void(0);" class="delete_attachment" data-attachment_id="{{ $attachement->id }}">Delete</a>
                                                </div>
                                                        @php
                                            }  
                                            @endphp
                                          
                                         @endforeach
                                       </div>
 
                                       
                                    @endif

                                @endif
                            </div>

                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                    {{ isset($task->id) ? "Update" : 'Create' }}
                                </button>
                            </div>

                        </div>
                </div>
                </form>
            </div>
            @if(isset($task->id))
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <div class="flex flex-col sm:flex-row border-b border-gray-200 dark:border-dark-5 px-5 py-4">
                        <div class="flex items-center">
                            <div class="ml-3 mr-auto">
                                <div class="font-medium text-base">Task <span style="color:#1C3FAA">{{ $task->task_name }}</span>  Discussion</div>
                                
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
                                    {{ $discussion->comment }}
                                        <div class="mt-1 text-xs text-gray-600">{{ date('d, M Y h:i A', strtotime($discussion->created_at)) }}</div>
                                    </div>
                                </div>
                                <div class="clear-both"></div>
                            </div>
                            
                            @else
                            <div>
                                <div class="chat__box__text-box flex items-end float-right mb-4">
                                    <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                    {{ $discussion->comment }}
                                        <div class="mt-1 text-xs text-theme-22">{{ date('d, M Y h:i A', strtotime($discussion->created_at)) }}</div>
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
            <!-- END: Form Layout -->

            <!-- BEGIN: company Modal Content -->
            <div class="modal" id="header-footer-modal-preview" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('createCompany') }}">
                                    @csrf
                                    <!-- BEGIN: Modal Header -->
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Add company</h2>
                                     </div> <!-- END: Modal Header -->
                                    <!-- BEGIN: Modal Body -->
                                    <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                                        <div class="col-span-12 sm:col-span-6"> <label for="modal-form-1" class="form-label">Company Name</label> <input type="text" class="form-control" name="name" id="comp_name" placeholder="">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-span-12 sm:col-span-6"> <label for="modal-form-2" class="form-label">Contact Person Name</label> <input type="text" class="form-control" name="contact_person_name" id="contact_person" placeholder=""> </div>
                                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-3" class="form-label">Started Date</label> <input class="datepicker form-control w-100 block mx-auto" data-single-mode="true" name="started_date" id="started_date"> </div>
                                        <div class="col-span-12 sm:col-span-6"> <label for="modal-form-4" class="form-label">Location </label> <input type="text" class="form-control" id="modal-form-4" name="location" id="location" placeholder=""> </div>
                                        <div class="col-span-12 sm:col-span-6"> <label for="modal-form-5" class="form-label">TimeZone </label> <input type="text" class="form-control" id="modal-form-5" name="timezone" id="comp_timezone" placeholder=""> </div>
                                        <div class="col-span-12 sm:col-span-12"> <label for="modal-form-6" class="form-label">Additional Info</label> <textarea class="form-control" name="additional_info" id="additional_info" cols="30" rows="10"></textarea> </div>
                                    </div> <!-- END: Modal Body -->
                                    <!-- BEGIN: Modal Footer -->
                                    <div class="modal-footer text-right"> <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button> <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                            {{ __('Submit') }}
                                        </button></div> <!-- END: Modal Footer -->
                                </form>
                            </div>
                        </div>
                    </div> <!-- END: company Modal Content -->
        </div>
    </div>
</div>
<!-- END: Content -->
</div>
@endsection