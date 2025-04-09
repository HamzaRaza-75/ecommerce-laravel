@php
    use Carbon\Carbon;

    // Filter the collection for requests within the last 36 hours
    $todaysRequests = $store->filter(function ($item) {
        return $item->created_at >= Carbon::now()->subHours(36);
    });

    // Filter the collection for requests older than 36 hours
    $earlierRequests = $store->filter(function ($item) {
        return $item->created_at < Carbon::now()->subHours(36);
    });

    $countrequests = $store
        ->filter(function ($item) {
            return $item->status == 'pending';
        })
        ->count();
@endphp

@extends('layouts.admin')
@section('main')
    <!-- Page Heading -->
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <h1 class="mb-0 text-gray-800 h3"> Stores Requests </h1>
        <span class="shadow-sm d-none d-sm-inline-block btn btn-sm btn-primary p-2 px-4 "> {{ $countrequests }}</span>
    </div>
    <div class="container">
        @if ($todaysRequests->isNotEmpty())
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Today</h6>
                </div>
                @foreach ($todaysRequests as $storeItem)
                    <div class="box-body p-0">
                        <div class="p-3 d-flex align-items-center osahan-post-header">
                            <div class="request-profile-image mr-3">
                                <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                    alt="" />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <div class="mb-2 text-truncate">
                                    Hi {{ auth()->user()->name }} ,
                                    <span class="text-primary underline-hover">{{ $storeItem->user->name }}</span>
                                    is requesting for his new store
                                    <span class="text-info underline-hover">{{ $storeItem->name }}</span>
                                </div>
                                @if ($storeItem->status == 'pending')
                                    <a href={{ route('superadmin.store.approve', ['storeid' => $storeItem->id]) }}
                                        class="btn btn-outline-success btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 448 512">
                                            <path
                                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                        </svg>
                                        Approve</a>
                                    <a href={{ route('superadmin.store.reject', ['storeid' => $storeItem->id]) }}
                                        class="btn btn-outline-danger btn-sm" type="button"><i class="fa fa-trash"></i>
                                        Reject</a>
                                @elseif ($storeItem->status == 'approved')
                                    <div class="small text-success"><i class="fa fa-check-circle"></i> You have approved
                                        this store </div>
                                @elseif ($storeItem->status == 'rejected')
                                    <div class="small text-danger"><i class="fa fa-times-circle"></i> You have rejected this
                                        store</div>
                                @endif
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="text-right text-muted pt-1">{{ $storeItem->created_at->diffForHumans() }}</div>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


        <div class="box-body p-0">
            @if ($earlierRequests->isNotEmpty())
                <div class="box shadow-sm rounded bg-white mb-3">
                    <div class="box-title border-bottom p-3">
                        <h6 class="m-0">Earlier</h6>
                    </div>
                    @foreach ($earlierRequests as $storeItem)
                        <div class="box-body p-0">
                            <div class="p-3 d-flex align-items-center osahan-post-header">
                                <div class="request-profile-image mr-3">
                                    <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                        alt="" />
                                </div>
                                <div class="font-weight-bold mr-3">
                                    <div class="mb-2 text-truncate">
                                        Hi {{ auth()->user()->name }} ,
                                        <span class="text-primary underline-hover">{{ $storeItem->user->name }}</span>
                                        is requesting for his new store
                                        <span class="text-info underline-hover">{{ $storeItem->name }}</span>

                                    </div>
                                    @if ($storeItem->status == 'pending')
                                        <a href={{ route('superadmin.store.approve', ['storeid' => $storeItem->id]) }}
                                            class="btn btn-outline-success btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" viewBox="0 0 448 512">
                                                <path
                                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                                            </svg>
                                            Approve</a>
                                        <a href={{ route('superadmin.store.reject', ['storeid' => $storeItem->id]) }}
                                            class="btn btn-outline-danger btn-sm" type="button"><i class="fa fa-trash"></i>
                                            Reject</a>
                                    @elseif ($storeItem->status == 'approved')
                                        <div class="small text-success"><i class="fa fa-check-circle"></i> You Have Approved
                                            The Store</div>
                                    @elseif ($storeItem->status == 'rejected')
                                        <div class="small text-danger"><i class="fa fa-times-circle"></i> You have rejected
                                            the store</div>
                                    @endif
                                </div>
                                <span class="ml-auto mb-auto">
                                    <div class="text-right text-muted pt-1">
                                        {{ $storeItem->created_at->diffForHumans() }}</div>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
