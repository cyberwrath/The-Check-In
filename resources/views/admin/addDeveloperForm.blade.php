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
                        Add new Friend
                    </h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 lg:col-span-6">
                        <!-- BEGIN: Form Layout -->
                        <div class="intro-y box p-5">
                        <form method="POST" action="{{ isset($user->id) ? route('createDeveloper',$user->id) : route('createDeveloper', 0) }}">
                          @csrf
                          <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                                
                                <div class="intro-x mt-2 text-gray-500 dark:text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your e-commerce accounts in one place</div>
                                <div class="intro-x mt-8">
                                    <input placeholder="Name" id="name" value="{{ isset($user->name) ? $user->name : '' }}" type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    
                                    <input id="email" placeholder="Email" type="email" value="{{ isset($user->email) ? $user->email : '' }}" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    <input id="phone" placeholder="Phone Number" type="text" value="{{ isset($user->phone) ? $user->phone : '' }}" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="off">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                     
                                </div>
                                
                                <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                    <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                            {{ isset($user->email) ? "Update Friend" : 'Create Friend' }}
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
