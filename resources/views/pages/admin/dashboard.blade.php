@extends('layouts.adminLayout')
@section('viewTitle')
    Thống kê
@endsection
@section('main')
    <div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Tổng tin</p>
                                    <h5 class="font-weight-bolder">
                                        {{$data['news_active']}}
                                    </h5>
                                    
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Tin chờ xác nhận</p>
                                    <h5 class="font-weight-bolder">
                                        {{$data['news_pending']}}
                                    </h5>
                                   
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Tin từ chối</p>
                                    <h5 class="font-weight-bolder">
                                        {{$data['news_deny']}}
                                    </h5>
                                    
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Người dùng</p>
                                    <h5 class="font-weight-bolder">
                                        {{$data['user']}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Tin chờ duyệt</h6>
                        </div>
                    </div>
                    <div class="table-responsive pb-5">
                        <table class="table align-items-center ">
                            <tbody>
                                @forelse ($news_pending as $item)
                                <tr>
                                    <td class="w-30">
                                        <div class="d-flex px-2 py-1 align-items-center">
                                            <div class="" style="width: 72px;height:56px">
                                                <img width="72" height="56" class=" object-fit-cover rounded-xl" src="{{asset('storage/'.$item->image)}}" alt="Country flag">
                                            </div>
                                            <div class="ms-4">
                                                <h6 class="text-sm mb-0">{{$item->title}}</h6>
                                                <p class="text-xs font-weight-bold mb-0">Tác giả: {{$item->user->email}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <a href="#" class="text-xs font-weight-bold mb-0 text-primary" title="Xem chi tiết"><i class="fa-regular fa-eye"></i></a>
                                        </div>
                                    </td>
                                   
                                </tr> 
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-danger py-5">Không có tin nào mới!</td>
                                    </tr>
                                @endforelse
                                
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Danh mục</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @foreach ($categories as $item)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class=" me-3  text-center" style="width:38px">
                                            <img src="{{asset('storage/'.$item->icon_url)}}" class="rounded-circle img-thumbnail" width="38" alt="">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{$item->name}}</h6>
                                            <span class="text-xs">{{$item->slug}}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{route('admin.editcategory',['id'=>$item->id])}}"
                                            class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i
                                                class="ni ni-bold-right" aria-hidden="true"></i></a>
                                    </div>
                                </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
