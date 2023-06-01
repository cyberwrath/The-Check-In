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

            </h2>
            
        </div>
        <div class="pos intro-y grid grid-cols-12 gap-5 mt-5">
            <!-- BEGIN: Item List -->
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Table Head Options -->
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">
                            {{ $groupName->group_name }}
                        </h2>
                    </div> 
                    <div class="p-5" id="head-options-table">
                        <div class="preview">
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <thead>
                                        <tr class="bg-gray-700 dark:bg-dark-1 text-white">
                                            
                                            <th class="whitespace-nowrap">Name</th>
                                            <th class="whitespace-nowrap">Email</th>
                                            <th class="whitespace-nowrap">Phone</th>
                                            <th class="whitespace-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($group_friends as $gf)
                                        <tr>
                                            
                                            <td class="border-b dark:border-dark-5">{{ $gf->name }}</td>
                                            <td class="border-b dark:border-dark-5">{{ $gf->email }}</td>
                                            <td class="border-b dark:border-dark-5">{{ $gf->phone }}</td>
                                            <td class="border-b dark:border-dark-5">
                                            <form action="{{ route('deleteAssignedFriend',['user_id' => $gf->id,  'group_id' => $gf->group_id]) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="flex items-center text-theme-6" type="submit"><i data-feather="trash-2" class="w-4 h-4 mr-1"></i></button>               
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="intro-y box mt-4" style="z-index: 99999">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">
                            Assign Friends to Group
                        </h2>
                    </div>
                    <div class="p-5" id="head-options-table">
                        <div class="preview">
                            
                                <form method="POST" action="{{ route('assignFriends') }}">
                                    @csrf
                                    
                                            
                                        <div class="intro-x">
                                                    @php
                                                    $assinged = array();
                                                    @endphp
                                                    @foreach($group_friends as $gff)
                                                        @php
                                                          $assinged[] = $gff->id;
                                                        @endphp
                                                    @endforeach
                                                 
                                                <select name="friends[]" class="tail-select w-full" data-placeholder="Choose friends" aria-label=".form-select-lg example" data-search="true" multiple>
                                                @foreach ($friends as $developer)
                                                    @php
                                                       if(in_array($developer->id, $assinged))
                                                       {
                                                         continue;
                                                       }
                                                    @endphp
                                                    <option value="{{ $developer->id }}" {{ isset($task->user_id) &&  $task->user_id == $developer->id ? 'selected' : '' }}>{{ $developer->name }}</option>
                                                 @endforeach
                                                </select>
                                                <input type="hidden" name="group" value="{{ $groupName->id }}"> 
                                                @error('friends[]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
 
                                                
                                            </div>
                                            
                                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                                    Assign Friends
                                                    </button>
                                            </div>
                                  
                                </form>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END: Item List -->


            <!-- BEGIN: Random group -->
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Table Head Options -->
                @foreach($pairs as $index => $pair)
                <div class="mb-2 intro-y box pair-box {{ ($index == $currentweek) ? 'active' : ''; }}">
                    <div class="pair-head flex flex-col sm:flex-row items-center p-5 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto">
                            Group Pairs - Week {{ $index }}
                        </h2>
                    </div>

                    <div class="{{ ($index == 0) ? 'show-pair' : 'hide-pair'; }} pair-body grid grid-cols-12 gap-5 pt-5 border-t border-theme-5 p-4" style="display:none">
                       @foreach($pair as $pas)
                        <a href="javascript:;" data-toggle="modal" data-target="#add-item-modal" class="intro-y block col-span-12 sm:col-span-4 xxl:col-span-4">
                            <div class="box pairs-box rounded-md p-3 relative zoom-in">
                                 <div class="block font-medium text-center truncate py-4">
                                 @php
                                    $name = '';
                                    foreach($pas as $pa)
                                        {
                                            $contact = explode('—', $pa);
                                            $name .= $contact[0].' and ';
                                            $phones[] = $contact[1];
                                        }
                                        $part = " and";
                                       $pairName = implode( $part, array_slice( explode( $part, $name ), 0, -1 ) );
                                 @endphp
                                    {{ $pairName }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            <!-- END: Random group -->

        </div>
    </div>
    <!-- END: Content -->
</div>

@endsection