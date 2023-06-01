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
                Add notice
            </h2>
        </div>
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="intro-y col-span-12 lg:col-span-6">
                <!-- BEGIN: Form Layout -->
                <div class="intro-y box p-5">
                    <form id="adtaskform" method="POST" action="{{ route('createNotice') }}">
                        @csrf
                        <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">

                           <div class="intro-x mt-8">
                                <label for="regular-form-1" class="form-label">Developer</label>
                                <select name="developer" id="developer" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="">Select Developer</option>
                                    @foreach ($developers as $developer)
                                    <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                                    @endforeach
                                </select>
                                
                                <br>
                                
                                <label for="regular-form-1" class="mt-4 form-label">Notice</label>
                                <textarea name="notice" id="editor1" rows="10" cols="80">
                                
                                </textarea>
                                @error('notice')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <script>
                                    CKEDITOR.replace('editor1');
                                </script>

                            <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                                <button type="submit" class="btn btn-primary py-3 px-4 w-full xl:w-32 xl:mr-3 align-top">
                                   Create
                                </button>
                            </div>

                        </div>
                </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- END: Content -->
</div>
@endsection