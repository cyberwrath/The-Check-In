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
                    Credentials List
                </h2>

                <!-- BEGIN: Responsive Table -->
                <div class="intro-y box mt-5">
                            
                            <div class="p-5" id="responsive-table">
                                <div class="preview">
                                    <div class="overflow-x-auto">
                                        <table id="datatable" class="table">
                                            <thead>
                                                <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Project name</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Wp login URL</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Password</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">FTP/SFTP Host</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Password</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Port</th>
                                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Other Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($projects) > 0)
                                              @foreach($projects as $project)
                                                <tr>
                                                    <td class="border-b whitespace-nowrap">{{$loop->iteration}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->name}}</td>
                                                    <td class="border-b whitespace-nowrap"><a href="{{$project->wp_login_url}}" target="_blank">{{$project->wp_login_url}}</a></td>
                                                    <td class="border-b whitespace-nowrap">{{$project->wp_user}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->wp_password}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->ftp_host}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->ftp_user}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->ftp_password}}</td>
                                                    <td class="border-b whitespace-nowrap">{{$project->ftp_port}}</td>
                                                    <td class="border-b whitespace-nowrap"><a href="javascript:void(0)" class="view_text" data-project_id="{{$project->id}}">View text </a></td>
                                                </tr>
                                                @endforeach 
                                                @else 
                                                    <tr>
                                                    <td class="border-b whitespace-nowrap">No credentials added yet</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="source-code hidden">
                                    <button data-target="#copy-responsive-table" class="copy-code btn py-1 px-2 btn-outline-secondary"> <i data-feather="file" class="w-4 h-4 mr-2"></i> Copy example code </button>
                                    <div class="overflow-y-auto mt-3 rounded-md">
                                        <pre class="source-preview" id="copy-responsive-table"> <code class="text-xs p-0 rounded-md html pl-5 pt-8 pb-4 -mb-10 -mt-10"> HTMLOpenTagdiv class=&quot;overflow-x-auto&quot;HTMLCloseTag HTMLOpenTagtable class=&quot;table&quot;HTMLCloseTag HTMLOpenTagtheadHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTag#HTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagFirst NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagLast NameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagUsernameHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagEmailHTMLOpenTag/thHTMLCloseTag HTMLOpenTagth class=&quot;border-b-2 dark:border-dark-5 whitespace-nowrap&quot;HTMLCloseTagAddressHTMLOpenTag/thHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/theadHTMLCloseTag HTMLOpenTagtbodyHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag1HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagAngelinaHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagJolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag@angelinajolieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagangelinajolie@gmail.comHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag260 W. Storm Street New York, NY 10025.HTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag2HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagBradHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagPittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag@bradpittHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagbradpitt@gmail.comHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag47 Division St. Buffalo, NY 14241.HTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTagtrHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag3HTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagCharlieHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagHunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag@charliehunnamHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTagcharliehunnam@gmail.comHTMLOpenTag/tdHTMLCloseTag HTMLOpenTagtd class=&quot;border-b whitespace-nowrap&quot;HTMLCloseTag8023 Amerige Street Harriman, NY 10926.HTMLOpenTag/tdHTMLCloseTag HTMLOpenTag/trHTMLCloseTag HTMLOpenTag/tbodyHTMLCloseTag HTMLOpenTag/tableHTMLCloseTag HTMLOpenTag/divHTMLCloseTag </code> </pre>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                        <!-- END: Responsive Table -->
              @include('snippets.viewCredentialsModal')
               <!-- BEGIN: Responsive Table -->
              
            <!-- END: Content -->
        </div>
        
@endsection
