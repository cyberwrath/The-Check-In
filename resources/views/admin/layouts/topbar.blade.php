<div class="top-bar">
                    <!-- BEGIN: Breadcrumb -->
                    <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Application</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Dashboard</a> </div>
                    <!-- END: Breadcrumb -->
                    <!-- BEGIN: Search -->
                    <div class="intro-x relative mr-3 sm:mr-6">
                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                            <label class="form-check-label ml-0 sm:ml-2" for="show-example-6">
                            <a href="{{ url()->previous() }}" class="btn btn-danger shadow-md mr-2">Go Back</a>
                            </label>
                        </div>
                        
                    </div>
                    <!-- END: Search -->
                    
                    <!-- BEGIN: Account Menu -->
                    <div class="intro-x dropdown w-8 h-8">
                        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false">
                            <img alt="Midone Tailwind HTML Admin Template" src="{{ asset('dist/images/profile-6.jpg') }}">
                        </div>
                        <div class="dropdown-menu w-56">
                            <div class="dropdown-menu__content box bg-theme-33 dark:bg-dark-6 text-white">
                                <div class="p-2 border-t border-theme-34 dark:border-dark-3">
                                    <a href="{{ route('logout') }}" class="flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"> <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> {{ __('Logout') }} </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>    
                                 </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Account Menu -->
                </div>
                @if(session('success'))
                    <div class="alert alert-success show mb-2" role="alert">
                    {{ session('success') }}
                    </div>
                  @endif
                  @if(session('error'))
                    <div class="alert alert-danger show mb-2" role="alert">
                    {{ session('error') }}
                    </div>
                  @endif