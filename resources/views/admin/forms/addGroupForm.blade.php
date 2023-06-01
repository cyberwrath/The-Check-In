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
                     Create Group
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                       


                                <form method="POST" action="{{ route('createGroup') }}">
                                        @csrf
                                        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                                                
                                                <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                                                <div class="intro-x mt-8">
                                                    <label>Group Name</label>
                                                <input type="text"  class="form-control mb-4" name="group_name" id="group_name" placeholder="">
                                                    @error('group_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    <label class="mt-4 ">Assign Friends to Group</label>
                                                    <select name="friends[]" class="tail-select w-full" data-placeholder="Choose friends" aria-label=".form-select-lg example" data-search="true" multiple>
                                                       @foreach ($friends as $developer)
                                                        <option value="{{ $developer->id }}" {{ isset($task->user_id) &&  $task->user_id == $developer->id ? 'selected' : '' }}>{{ $developer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('friends[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror

                                                    
                                                </div>
                                                
                                                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                                        Create Group
                                                        </button>
                                                </div>
                                            </div>
                                        </div>
                          </form>
                        </div>
                        <!-- END: Form Layout -->
                    </div>
                </div>
            </div>
            <!-- END: Content -->
        </div>
@endsection
