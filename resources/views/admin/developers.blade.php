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
                    Friends's List
                </h2>
                
                <div class="grid grid-cols-12 gap-6 mt-5">
                  
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        <a href="{{ route('addDeveloper', 0) }}" class="btn btn-primary shadow-md mr-2">Add New Friend</a>
                        
                        <div class="hidden md:block mx-auto text-gray-600">Showing 1 to {{ $developers->count(); }} of 150 entries</div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            <div class="w-56 relative text-gray-700 dark:text-gray-300">
                                <input type="text" class="form-control w-56 box pr-10 placeholder-theme-13" placeholder="Search...">
                                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-feather="search"></i> 
                            </div>
                        </div>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Name</th>
                                    <th class="text-center whitespace-nowrap">Email</th>
                                    <th class="text-center whitespace-nowrap">Phone</th>
                                    <th class="text-center whitespace-nowrap">Status</th>
                                    <th class="text-center whitespace-nowrap">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($developers as $developer)
                                    <tr class="intro-x">
                                        <td>
                                            <a href="" class="font-medium whitespace-nowrap">{{ $developer->name; }}</a> 
                                            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">.</div>
                                        </td>
                                        
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-theme-6">  {{ $developer->email; }} </div>
                                        </td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-theme-6">  {{ $developer->phone; }} </div>
                                        </td>
                                        <td class="w-40">
                                            <div class="flex items-center justify-center text-theme-6"> <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $developer->status; }} </div>
                                        </td>

                                        <td class="table-report__action w-56">
                                            <div class="flex justify-center items-center">
                                                <a class="flex items-center mr-3" href="{{ route('addDeveloper', $developer->id) }}"> Edit </a>
                                                <form action="{{route('deleteDeveloper',[$developer->id])}}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="flex items-center text-theme-6" type="submit"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i></button>               
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->
                    <!-- BEGIN: Pagination -->
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                      {{ $developers->links() }}
                     </div>
                    <!-- END: Pagination -->
                </div>
            </div>
            <!-- END: Content -->
        </div>
@endsection
