@extends('layouts.adminLayout')
@section('viewTitle')
    Thống kê
@endsection
@section('main')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between pb-3">
                        <h6>Tất cả danh mục</h6>
                        <a href="{{ route('admin.createcategory') }}" class="btn btn-sm btn-primary"><i
                                class="fa-solid fa- ms-2"></i>Tạo danh mục</a>
                    </div>
                    <div>
                        @if (session('success'))
                            <div class="alert alert-success py-2 text-white">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger py-2 text-white">{{ session('error') }}</div>
                        @endif
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
                                            Thứ tự</th>
                                        <th
                                            class="text-uppercase text-secondary text-center text-xxs font-weight-bolder opacity-7 ps-2">
                                            Trang thái</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder text-end opacity-7 ps-2">
                                            Hành động</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr class="py-1">
                                            <td>
                                                <div class="d-flex px-2 align-items-center">
                                                    <div class="" style="min-width: 28px">#{{$item->id}}</div>
                                                    <div>
                                                        <img src={{asset('storage/'.$item->icon_url)}}
                                                            class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                    </div>
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-sm">{{$item->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-sm font-weight-bold mb-0">{{$item->slug}}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-xs font-weight-bold">{{$item->priority}}</div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @if ($item->is_show)
                                                        
                                                    <span class="badge badge-sm bg-gradient-success ">Hiện</span>
                                                    @else
                                                    <span class="badge badge-sm bg-gradient-secondary ">Ẩn</span>
                                                        
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="align-middle d-flex justify-content-end gap-2 align-items-center">
                                                <div>
                                                    <a href="{{route('admin.editcategory',['id'=>$item->id])}}" class="btn btn-sm btn-outline-primary ">Sửa</a>
                                                    <a href="{{route('admin.deletecategory',['id'=>$item->id])}}" onclick="return confirm('Bạn có chắc là muốn xóa chứ?')" class="btn btn-sm btn-outline-danger">Xóa</a>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                   
                                    
                                    





                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
