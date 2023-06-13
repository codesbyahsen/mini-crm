@extends('layouts.app')
@section('title', 'Companies - Mini-CRM')

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
                                        <h3 class="nk-block-title page-title">Companies</h3>
                                        <div class="nk-block-des text-soft">
                                            <p id="total-companies-url"
                                                data-total-companies-url="{{ route('companies.total') }}">You have total
                                                <span class="total-companies"></span> companies.
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
                                                                data-target="#create-company"
                                                                class="btn btn-icon btn-primary"><em
                                                                    class="icon ni ni-plus"></em></a>
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
                                    <table class="nowrap table" id="init-company-datatable"
                                        data-url="{{ route('companies.index') }}">
                                        <thead>
                                            <tr>
                                                <th>Company Logo</th>
                                                <th>Company Name</th>
                                                <th>Email</th>
                                                <th>Website</th>
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
    <!-- Add Company Modal Form -->
    <div class="modal fade" id="create-company" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Company</h5>
                    <a href="#" class="close cancel-create-company-form" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('companies.store') }}" class="form-validate is-alter"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <div class="form-control-wrap">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input field-logo" name="logo"
                                        id="company-logo" accept="image/png,image/jpeg,image/gif" />
                                    <label class="custom-file-label" for="company-logo">Choose file</label>
                                </div>
                                <span class="text-danger small error-logo"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company-name">Company Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control field-name" id="company-name" name="name"
                                    value="{{ old('name') }}" />
                            </div>
                            <span class="text-danger small error-name"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email-address">Email Address</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control field-email" id="email-address" name="email"
                                    value="{{ old('email') }}" />
                            </div>
                            <span class="text-danger small error-email"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="website-url">Website URL</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control field-website" id="website-url" name="website"
                                    value="{{ old('website') }}" />
                            </div>
                            <span class="text-danger small error-website"></span>
                        </div>
                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-lg btn-light mr-1 cancel-create-company-form"
                                data-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Company Modal Form -->
    <div class="modal fade" id="edit-company">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <a href="#" class="close cancel-edit-company-form" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form class="form-validate is-alter" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">Logo</label>
                            <div class="form-control-wrap">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input field-logo" name="logo"
                                        id="company-logo" accept="image/png,image/jpeg,image/gif" />
                                    <label class="custom-file-label" for="company-logo">Choose file</label>
                                </div>
                                <span class="text-danger small error-logo"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company-name">Company Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control field-name" id="company-name" name="name"
                                    value="{{ old('name') }}" />
                            </div>
                            <span class="text-danger small error-name"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email-address">Email Address</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control field-email" id="email-address" name="email"
                                    value="{{ old('email') }}" />
                            </div>
                            <span class="text-danger small error-email"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="website-url">Website URL</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control field-website" id="website-url" name="website"
                                    value="{{ old('website') }}" />
                            </div>
                            <span class="text-danger small error-website"></span>
                        </div>
                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-lg btn-light mr-1 cancel-edit-company-form"
                                data-dismiss="modal" aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
