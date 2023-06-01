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
                    Payment Record
                    </h2>
                    
                </div>
                <!-- BEGIN: Invoice -->
                <div class="intro-y box overflow-hidden mt-1">
                    <form method="GET" action="">
                        <div class="flex flex-col lg:flex-row border-b px-5 sm:px-20 pt-10 pb-10 sm:pb-3 text-center sm:text-left" style="align-items: end;gap: 20px;">
                            <div style="width: 20%;">
                                <label for="regular-form-1" class="mt-4 form-label">Month</label>
                                <select name="month" id="month" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    <option value="">Choose month</option>
                                    @foreach ($months as $month)
                                    <option value="{{ $month }}" {{ isset($_month) &&  $_month == $month  ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div style="width: 20%;">
                                <label for="regular-form-1" class="mt-4 form-label">Year</label>
                                <select name="year" id="year" class="form-select form-select-md sm:mr-2 py-3 px-4 mb" aria-label=".form-select-lg example">
                                    @foreach ($years as $year)
                                    <option value="{{$year}}" {{ isset($_year) &&  $_year == $year  ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                            <label for="regular-form-1" class="mt-4 form-label"></label>
                            <button type="submit" class="btn btn-primary shadow-md mr-2">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="px-1 sm:px-16 py-10 sm:py-1">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Date</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Project</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Hours</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Remarks</th>
                                    <!-- <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Status</th> -->
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                $status = '';
                                    $paiddate = '';
                                    $total = 0;
                                    @endphp
                                    @if (count($records) > 0)
                                    
                                    @foreach($records as $record)
                                    @php
                                    $total += $record->amount;
                                    $status = $record->status;
                                    $paiddate = $record->paiddate;
                                    @endphp
                                    <tr>
                                       <td class="border-b whitespace-nowrap">{{$loop->iteration}}</td>
                                            
                                        <td class="border-b whitespace-nowrap">{{ date('d M, Y', strtotime($record->date)) }}</td>
                                        <td class="border-b whitespace-nowrap">{{$record->project}}</td>
                                        <td class="border-b whitespace-nowrap">{{$record->hours}}</td>
                                        <td class="border-b whitespace-nowrap">{!! $record->remarks !!}</td>
                                        <!-- <td class="border-b whitespace-nowrap">
                                        <div class="text-gray-600 text-xs whitespace-nowrap"><div title="{{ ($record->status == 'Paid') ? 'Paid on: '.date('d M, Y H:i A', strtotime($record->paiddate)) : '' }}" class="tooltip py-1 px-2 rounded-full text-xs text-white font-medium bg-theme-{{ ($record->status == 'Paid') ? '9' : '6'; }}"> {{$record->status}} </div></div>
                                        </td> -->
                                        <td class="border-b whitespace-nowrap">₹{{$record->amount}}</td>
                                        
                                    </tr>
                                @endforeach 
                                @else 
                                <tr>
                                    <td colspan="6">There is no Payment available </td>
                                </tr>
                                    
                                @endif  
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                        <div class="text-center sm:text-left mt-10 sm:mt-0">
                            <div class="text-base text-gray-600">Total Earned so far</div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-2">₹{{$totalearned}}</div>
                        </div>
                        <div class="text-center sm:text-right sm:ml-auto">
                            <div class="text-base text-gray-600">Total Amount</div>
                            <div class="text-xl text-theme-1 dark:text-theme-10 font-medium mt-2">₹{{$total}}</div> 
                            @if ($status && $_month)
                            <div class="text-gray-600 text-xs whitespace-nowrap"><div title="{{ ($status == 'Paid') ? 'Paid on: '.date('d M, Y H:i A', strtotime($paiddate)) : '' }}"  class="tooltip py-1 px-2 rounded-full text-xs text-white font-medium bg-theme-{{ ($status == 'Paid') ? '9' : '6'; }}"> {{$status}} </div></div>
                            @endif 
                        </div>
                    </div>
                </div>
                <!-- END: Invoice -->
              
            <!-- END: Content -->
        </div>
        
@endsection
