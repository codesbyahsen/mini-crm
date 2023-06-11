@extends('layouts.app')
@section('title', 'Employees - Mini-CRM')

@section('page-content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="components-preview wide-md mx-auto">
                        <div class="nk-block nk-block-lg">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Employees</h3>
                                        <div class="nk-block-des text-soft">
                                            <p id="total-employees-url"
                                                data-total-employees-url="{{ route('employees.total') }}">You have total
                                                <span class="total-employees"></span> employees.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                                data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#create-employee"
                                                                class="btn btn-icon btn-primary"><em
                                                                    class="icon ni ni-plus"></em>
                                                            </a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <table class="nowrap table" id="init-employee-datatable"
                                        data-url="{{ route('employees.index') }}">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Company <span class="small">&#40;Employed at&#41;</span></th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Create Employee Modal Form -->
    <div class="modal fade" id="create-employee" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Employee</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('employees.store') }}" class="form-validate is-alter">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="first-name">First Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-first-name" id="first-name"
                                            name="first_name" value="{{ old('first_name') }}" />
                                    </div>
                                    <span class="text-danger small error-first-name"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="last-name">Last Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-last-name" id="last-name"
                                            name="last_name" value="{{ old('last_name') }}" />
                                    </div>
                                    <span class="text-danger small error-last-name"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="email-address">Email Address</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control field-email" id="email-address"
                                            name="email" value="{{ old('email') }}" />
                                    </div>
                                    <span class="text-danger small error-email"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="phone-number">Phone Number</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-phone" id="phone-number"
                                            name="phone" value="{{ old('phone') }}" />
                                    </div>
                                    <span class="text-danger small error-phone"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Company <span class="text-muted small">&#40;Employed
                                            at&#41;</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select field-company" data-search="on" name="company_id">
                                            <option value="" selected>Select company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company?->id }}">{{ $company?->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger small error-company"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group float-right">
                                    <button type="reset" class="btn btn-lg btn-light mr-1 cancel-create-employee-form"
                                        data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Employee Modal Form -->
    <div class="modal fade" id="edit-employee">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter edit-employee" id="edit-employee-form">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="first-name">First Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-first-name" id="first-name"
                                            name="first_name" value="{{ old('first_name') }}" />
                                    </div>
                                    <span class="text-danger small error-first-name"></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label class="form-label" for="last-name">Last Name</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-last-name" id="last-name"
                                            name="last_name" value="{{ old('last_name') }}" />
                                    </div>
                                    <span class="text-danger small error-last-name"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="email-address">Email Address</label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control field-email" id="email-address"
                                            name="email" value="{{ old('email') }}" />
                                    </div>
                                    <span class="text-danger small error-email"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="phone-number">Phone Number</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control field-phone" id="phone-number"
                                            name="phone" value="{{ old('phone') }}" />
                                    </div>
                                    <span class="text-danger small error-phone"></span>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class="form-label">Company <span class="text-muted small">&#40;Employed
                                            at&#41;</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select field-company" data-search="on" name="company_id">
                                            <option value="">Select company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company?->id }}">
                                                    {{ $company?->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger small error-company"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group float-right">
                                    <button type="reset" class="btn btn-lg btn-light mr-1 cancel-edit-employee-form"
                                        data-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
