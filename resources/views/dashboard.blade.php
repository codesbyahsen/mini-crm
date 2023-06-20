@extends('layouts.app')

@section('page-content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <p>Welcome to the Mini-CRM</p>
                    <h3>Dashboard</h3>

                    @role(['admin', 'sub-admin'])
                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-md-4">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="subtitle">Total Companies</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                        data-placement="left" title="Total Companies"></em>
                                                </div>
                                            </div>
                                            <span class=""> {{ $totalCompanies ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="subtitle">Total Employees</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                        data-placement="left" title="Total Employees"></em>
                                                </div>
                                            </div>
                                            <span class=""> {{ $totalEmployees ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group align-start mb-0">
                                                <div class="card-title">
                                                    <h6 class="subtitle">Total Projects</h6>
                                                </div>
                                                <div class="card-tools">
                                                    <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip"
                                                        data-placement="left" title="Total Projects"></em>
                                                </div>
                                            </div>
                                            <span class=""> {{ $totalProjects ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
@endsection
