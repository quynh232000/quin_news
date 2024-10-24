@extends('layouts.adminLayout')
@section('viewTitle')
    Quản trị người dùng
@endsection
@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Quản lý người dùng</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Quyền</th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số
                                        bài viết</th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Người theo dõi</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                        Tham gia</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div>
                                                    <img src="{{ $item->avatar }}"
                                                        class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                                </div>
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                                    <span class="text-sm">{{ $item->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->role == 1)
                                                <div class="badge badge-sm text-xxs bg-gradient-warning">Quản trị</div>
                                            @else
                                                <span class="badge badge-sm text-xxs bg-gradient-success">Người dùng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="text-xs  font-weight-bold">{{$item->news_count()}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="me-2 text-xs font-weight-bold ">{{$item->followers_count()}}</div>
                                            
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="me-2 text-xs font-weight-bold "> {{\Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</div>
                                            
                                        </td>
                                        
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{$data->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
