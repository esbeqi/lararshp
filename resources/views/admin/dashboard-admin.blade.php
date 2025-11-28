@extends('layouts.lte.main')

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
    <div class="container-fluid">
        <!--begin::Row Widgets-->
        <div class="row">
            <!-- Widget 1 -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                    <img src="{{ asset('assets/img/shopping-cart.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!-- Widget 2 -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>53<sup class="fs-5">%</sup></h3>
                        <p>Bounce Rate</p>
                    </div>
                    <img src="{{ asset('assets/img/chart-bar.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!-- Widget 3 -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>44</h3>
                        <p>User Registrations</p>
                    </div>
                    <img src="{{ asset('assets/img/user-plus.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
            <!-- Widget 4 -->
            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>65</h3>
                        <p>Unique Visitors</p>
                    </div>
                    <img src="{{ asset('assets/img/globe.svg') }}" class="small-box-icon" alt="icon" />
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--end::Row Widgets-->

        <!--begin::Row Charts & Chat-->
        <div class="row">
            <!-- Left Col -->
            <div class="col-lg-7 connectedSortable">
                <!-- Sales Chart -->
                <div class="card mb-4">
                    <div class="card-header"><h3 class="card-title">Sales Value</h3></div>
                    <div class="card-body">
                        <div id="revenue-chart" style="height: 300px;"></div>
                    </div>
                </div>

                <!-- Direct Chat -->
                <div class="card direct-chat direct-chat-primary mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Direct Chat</h3>
                        <div class="card-tools">
                            <span class="badge text-bg-primary">3</span>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="chat-pane">
                                <i class="bi bi-chat-text-fill"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Messages -->
                        <div class="direct-chat-messages">
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-start">Alexander Pierce</span>
                                    <span class="direct-chat-timestamp float-end">23 Jan 2:00 pm</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('assets/img/user1-128x128.jpg') }}" alt="User Image">
                                <div class="direct-chat-text">Is this template really for free? That's unbelievable!</div>
                            </div>
                            <div class="direct-chat-msg end">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-end">Sarah Bullock</span>
                                    <span class="direct-chat-timestamp float-start">23 Jan 2:05 pm</span>
                                </div>
                                <img class="direct-chat-img" src="{{ asset('assets/img/user3-128x128.jpg') }}" alt="User Image">
                                <div class="direct-chat-text">You better believe it!</div>
                            </div>
                        </div>

                        <!-- Contacts -->
                        <div class="direct-chat-contacts">
                            <ul class="contacts-list">
                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="{{ asset('assets/img/user1-128x128.jpg') }}" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Count Dracula
                                                <small class="contacts-list-date float-end">2/28/2023</small>
                                            </span>
                                            <span class="contacts-list-msg">How have you been? I was...</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img class="contacts-list-img" src="{{ asset('assets/img/user7-128x128.jpg') }}" alt="User Avatar">
                                        <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                                Sarah Doe
                                                <small class="contacts-list-date float-end">2/23/2023</small>
                                            </span>
                                            <span class="contacts-list-msg">I will be waiting for...</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post">
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control" />
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary">Send</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Right Col -->
            <div class="col-lg-5 connectedSortable">
                <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                    <div class="card-header border-0">
                        <h3 class="card-title">Sales Value</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="world-map" style="height: 220px;"></div>
                    </div>
                    <div class="card-footer border-0">
                        <div class="row text-center">
                            <div class="col-4">
                                <div id="sparkline-1" class="text-dark"></div>
                                <div class="text-white">Visitors</div>
                            </div>
                            <div class="col-4">
                                <div id="sparkline-2" class="text-dark"></div>
                                <div class="text-white">Online</div>
                            </div>
                            <div class="col-4">
                                <div id="sparkline-3" class="text-dark"></div>
                                <div class="text-white">Sales</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row Charts & Chat-->
    </div>
</div>
<!--end::App Content-->
@endsection