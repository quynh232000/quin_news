@extends('layouts.adminLayout')
@section('viewTitle')
    Thống kê
@endsection
@section('main')
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    {{-- <div class="card-header pb-0">
                        <h6>Bộ lọc</h6>
                    </div> --}}
                    {{-- <div class="row px-4">
                        <div class="col-md-2">
                            <label for="">Tìm kiếm</label>
                            <input type="text" class="form-control" placeholder="Tên tin, tên tác giả, tag">
                        </div>
                        <div class="col-md-2">
                            <label for="">Theo danh mục</label>
                            <select name="" id="" class="form-select">
                                <option value="">--Chọn--</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Theo ngày tạo</label>
                            <select name="" id="" class="form-select">
                                <option value="">--Chọn--</option>
                                <option value="">Mới nhất</option>
                                <option value="">Cũ nhất</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Theo trạng thái</label>
                            <select name="" id="" class="form-select">
                                <option value="">--Chọn--</option>
                                <option value="">Hoạt động</option>
                                <option value="">Chờ duyệt</option>
                                <option value="">Từ chối</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button class="btn btn-warning">Tìm kiếm</button>
                        </div>
                    </div> --}}
                    <div class="card-header pb-0">
                        <h6>Quản lý tin tức</h6>
                    </div>
                    <hr class="horizontal dark">
                    <div>
                        @if (session('success'))
                            <div class="alert alert-success py-2 text-white">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-error py-2 text-white">{{ session('error') }}</div>
                        @endif
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên
                                        </th>
                                        <th
                                            class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tác giả</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Ngày tạo</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Trạng thái</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Hành động</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1 align-items-center">
                                                    <div class=" min-width:28px me-2">#{{ $item->id }}</div>
                                                    <div class="position-relative me-2 border rounded-2 p-1"
                                                        style="width: 56px;height:56px">
                                                        @if ($item->type == 'hot')
                                                            <span class="position-absolute text-danger "
                                                                style="right:-12px;top:-8px"><i
                                                                    class="fa-solid fa-fire"></i></span>
                                                        @endif
                                                        <img src="{{ asset('storage/' . $item->image) }}"
                                                            class=" me-3 h-100 w-100 object-fit-cover rounded-2"
                                                            alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center cursor-pointer"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $item->id }}">
                                                        <h6 class="mb-0 text-sm overflow-hidden" style="width: 320px;">
                                                            {{ $item->title }}</h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $item->category->name }}
                                                        </p>
                                                    </div>
                                                    {{-- modal --}}
                                                    <div class="modal fade " id="exampleModal{{ $item->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel{{ $item->id }}"
                                                        aria-hidden="false">
                                                        <div class="modal-dialog modal-dialog-scrollable modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="card-name fs-5 "
                                                                        id="exampleModalLabel{{ $item->id }}">
                                                                        {{ $item->title }}</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body w-100">
                                                                    <div class="pb-4">
                                                                        <i>
                                                                            {{$item->subtitle}}
                                                                        </i>
                                                                    </div>
                                                                    <div>
                                                                        {!!$item->content!!}
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        Đóng</button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- end modal --}}


                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-2">
                                                    <p class="text-xs text-secondary mb-0">
                                                        <img src="{{ $item->user->avatar }}" class="avatar avatar-sm"
                                                            alt="">
                                                    </p>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $item->user->email }}</p>
                                                </div>
                                            </td>

                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($item->status == 'pending')
                                                    <span class="badge badge-sm bg-gradient-info">Chờ duyệt</span>
                                                @endif
                                                @if ($item->status == 'active')
                                                    <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                                @endif
                                                @if ($item->status == 'deny')
                                                    @php
                                                        $text = '';
                                                    if ($item->reason_deny()) {
                                                        foreach ($item->reason_deny()->bad_words_list as $resason) {
                                                            $text .= $resason->word . ', ';
                                                        }
                                                        rtrim($text);
                                                    }
                                                    
                                                    @endphp
                                                    <span class="badge badge-sm bg-gradient-danger cursor-pointer"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Bad words({{ $item->reason_deny()->bad_words_total??0 }}): {{ $text }}">Từ
                                                        chối</span>
                                                @endif
                                            </td>
                                            <td class="">
                                                <div class="d-flex align-items-end justify-content-center dropdown">

                                                    <button class="btn btn-danger px-3 btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="true"><i
                                                            class="fa-solid fa-gear"></i></button>

                                                    <ul class="dropdown-menu d-flex flex-column gap-2 px-2">
                                                        <li><a href="{{ route('admin.status_news', ['id' => $item->id, 'type' => 'active']) }}"
                                                                class="dropdown-item bg-success btn btn-sm btn-success text-white text-center"
                                                                href="#">Duyệt</a></li>
                                                        <li><a href="{{ route('admin.status_news', ['id' => $item->id, 'type' => 'deny']) }}"
                                                                class="dropdown-item bg-warning btn btn-sm btn-warning text-white text-center"
                                                                href="#">Hủy</a></li>
                                                        <li><a href="{{ route('admin.status_news', ['id' => $item->id, 'type' => 'delete']) }}"
                                                                class="dropdown-item bg-danger btn btn-sm btn-danger text-white text-center"
                                                                href="#">Xóa</a>
                                                        </li>
                                                        <li><a href="{{ route('admin.status_news', ['id' => $item->id, 'type' => 'hot']) }}"
                                                                class="dropdown-item bg-primary btn btn-sm btn-primary text-white text-center"
                                                                href="#">Tin nổi bật</a>
                                                        </li>

                                                    </ul>



                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 pt-2">
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
