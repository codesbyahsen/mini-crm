@extends('layouts.app')
@section('title', 'Projects - Mini-CRM')

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
                                        <h3 class="nk-block-title page-title">Projects</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>You have total {{ $numberOfProjects ?? '' }} projects.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                                data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#add-project"
                                                                class="btn btn-icon btn-primary"><em
                                                                    class="icon ni ni-plus"></em></a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div>
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <table class="datatable-init nowrap table">
                                        <thead>
                                            <tr>
                                                <th>Project Name</th>
                                                <th>Client Name</th>
                                                <th>Deadline</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="user-avatar bg-primary" style="height: 28px; width: 28px;">
                                                        <span>AB</span>
                                                    </div>
                                                </td>
                                                <td>Tiger Nixon</td>
                                                <td>John</td>
                                                <td>10-10-2023</td>
                                                <td>
                                                    <ul class="nk-tb-actions gx-1">
                                                        <li>
                                                            <div class="drodown">
                                                                <a href="#"
                                                                    class="dropdown-toggle btn btn-icon btn-trigger"
                                                                    data-toggle="dropdown"><em
                                                                        class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#" data-toggle="modal"
                                                                                data-target="#show-project"><em
                                                                                    class="icon ni ni-edit"></em><span>Details</span></a>
                                                                        </li>
                                                                        <li><a href="#" data-toggle="modal"
                                                                                data-target="#edit-project"><em
                                                                                    class="icon ni ni-edit"></em><span>Edit</span></a>
                                                                        </li>
                                                                        <li><a href="#"><em
                                                                                    class="icon ni ni-trash"></em><span>Delete</span></a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .card-preview -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <!-- Add Project Modal Form -->
    <div class="modal fade" id="add-project">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.store') }}" class="form-validate is-alter" id="add-project-form">
                        <div class="form-group">
                            <label class="form-label" for="project-name">Project Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('name') error @enderror field-name"
                                    id="project-name" name="name" value="{{ old('name') }}" required />
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="project-detail">Project Detail</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control form-control-sm @error('detail') error @enderror field-detail" id="project-detail"
                                    name="detail" placeholder="Write your message"></textarea>
                            </div>
                            @error('detail')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="client-name">Client Name</label>
                            <div class="form-control-wrap">
                                <input type="text"
                                    class="form-control @error('client_name') error @enderror field-client-name"
                                    id="client-name" name="client_name" value="{{ old('client_name') }}" required />
                            </div>
                            @error('client_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="total-cost">Total Cost</label>
                            <div class="form-control-wrap">
                                <input type="text"
                                    class="form-control @error('total_cost') error @enderror field-total-cost"
                                    id="total-cost" name="total_cost" value="{{ old('total_cost') }}" required />
                            </div>
                            @error('total_cost')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="deadline">Deadline</label>
                            <div class="form-control-wrap">
                                <input type="date"
                                    class="form-control @error('deadline') error @enderror field-deadline" id="deadline"
                                    name="deadline" value="{{ old('deadline') }}" required />
                            </div>
                            @error('deadline')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-lg btn-light mr-1" data-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal Form -->
    <div class="modal fade" id="edit-project">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Project</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form action="#" class="form-validate is-alter" id="edit-project-form">
                        <div class="form-group">
                            <label class="form-label" for="project-name">Project Name</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('name') error @enderror field-name"
                                    id="project-name" name="name" value="{{ old('name') }}" required />
                            </div>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="project-detail">Project Detail</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control form-control-sm @error('detail') error @enderror field-detail" id="project-detail"
                                    name="detail" placeholder="Write your message"></textarea>
                            </div>
                            @error('detail')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="client-name">Client Name</label>
                            <div class="form-control-wrap">
                                <input type="text"
                                    class="form-control @error('client_name') error @enderror field-client-name"
                                    id="client-name" name="client_name" value="{{ old('client_name') }}" required />
                            </div>
                            @error('client_name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="total-cost">Total Cost</label>
                            <div class="form-control-wrap">
                                <input type="text"
                                    class="form-control @error('total_cost') error @enderror field-total-cost"
                                    id="total-cost" name="total_cost" value="{{ old('total_cost') }}" required />
                            </div>
                            @error('total_cost')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="deadline">Deadline</label>
                            <div class="form-control-wrap">
                                <input type="date"
                                    class="form-control @error('deadline') error @enderror field-deadline" id="deadline"
                                    name="deadline" value="{{ old('deadline') }}" required />
                            </div>
                            @error('deadline')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-lg btn-light mr-1" data-dismiss="modal"
                                aria-label="Close">Cancel</button>
                            <button type="submit" class="btn btn-lg btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
