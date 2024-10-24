@extends('layouts.adminLayout')
@section('viewTitle')
    Thống kê
@endsection
@section('main')
    <div>

        <div class="row">

            <div class="col-12">
                <div class="card mb-4">

                    <div>
                        <div class="card-header pb-0 d-flex justify-content-between pb-3">
                            <h6>Tạo thẻ mới</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2 px-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Tên thẻ</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-success">Tạo mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <div class="card-header pb-0 d-flex justify-content-between pb-3">
                        <h6>Tất cả thẻ</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tên</th>
                                        <th
                                            class="text-uppercase text-secondary text-start text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                            Slug</th>

                                        <th
                                            class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">
                                            Ngày tạo</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-end opacity-7 ps-2">
                                            Hành động</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="py-1">
                                        <td>
                                            <div class="d-flex px-2 align-items-center">
                                                <div class="" style="min-width: 28px">#1</div>

                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Thể thao</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-weight-bold mb-0">#theothao</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-xs font-weight-bold">24/12/20224</div>
                                        </td>

                                        <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="py-1">
                                        <td>
                                            <div class="d-flex px-2 align-items-center">
                                                <div class="" style="min-width: 28px">#1</div>

                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Thể thao</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-weight-bold mb-0">#theothao</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-xs font-weight-bold">24/12/20224</div>
                                        </td>

                                        <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="py-1">
                                        <td>
                                            <div class="d-flex px-2 align-items-center">
                                                <div class="" style="min-width: 28px">#1</div>

                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Thể thao</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-weight-bold mb-0">#theothao</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-xs font-weight-bold">24/12/20224</div>
                                        </td>

                                        <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="py-1">
                                        <td>
                                            <div class="d-flex px-2 align-items-center">
                                                <div class="" style="min-width: 28px">#1</div>

                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Thể thao</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-weight-bold mb-0">#theothao</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-xs font-weight-bold">24/12/20224</div>
                                        </td>

                                        <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="py-1">
                                        <td>
                                            <div class="d-flex px-2 align-items-center">
                                                <div class="" style="min-width: 28px">#1</div>

                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">Thể thao</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-sm font-weight-bold mb-0">#theothao</div>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-xs font-weight-bold">24/12/20224</div>
                                        </td>

                                        <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>

                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
