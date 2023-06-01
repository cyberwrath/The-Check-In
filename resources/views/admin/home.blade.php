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
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
               Groups
            </h2>
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a href="{{ route('addGroups') }}" data-toggle="modal" data-target="#new-order-modal" class="btn btn-primary shadow-md mr-2">Add New Group</a> 
                
            </div>
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
                    <!-- BEGIN: Item List -->
                    <div class="intro-y col-span-12 lg:col-span-12">
                        
                        <div class="grid grid-cols-12 gap-5 mt-5">
                           @foreach($groups as $group)
                           
                            <div class="col-span-12 sm:col-span-4 xxl:col-span-3 box p-5 cursor-pointer zoom-in">
                                <a href="{{ route('GroupDetail', base64_encode($group->id)) }}">
                                    <div class="font-medium text-base">{{ $group->group_name }}</div>
                                    <div class="text-gray-600">{{ $group->users_count }} friends</div>
                                </a>
                            </div>
                            
                           @endforeach
                        
                        </div>
                         
                    </div>
                    <!-- END: Item List -->
                    <!-- BEGIN: Ticket -->
                     
                    <!-- END: Ticket -->
                </div>
    </div>
    <!-- END: Content -->
</div>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/themes/smoothness/jquery-ui.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>

@endsection