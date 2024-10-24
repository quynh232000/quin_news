@extends('layouts.appLayout')
@section('viewTitle')
    Trang chủ | Quin News
@endsection

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between mb-3">
                    <h6>Danh sách tin tức của tôi</h6>
                    <a href="{{ route('addnews') }}" class="btn btn-primary btn-sm">Tạo tin mới</a>
                </div>

                {{-- <div class="px-4 border-top border-bottom py-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="">Danh mục</label>
                            <select name="" class="form-select form-sm" id="">
                                <option value="">--chọn--</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Trạng thái</label>
                            <select name="" class="form-select form-sm" id="">
                                <option value="">--chọn--</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Ngày tạo</label>
                            <select name="" class="form-select form-sm" id="">
                                <option value="">--chọn--</option>
                                <option value="">Mới nhất</option>
                                <option value="">Cũ nhất</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-flex  align-items-end">
                            <button class="btn btn-success mb-0"><i class="fa-solid fa-filter me-2"></i>Lọc</button>
                        </div>
                    </div>
                </div> --}}
                <div class="card-body px-0 pt-0 pb-2 mt-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr style="background-color: rgb(241, 236, 236);">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tiêu đề
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Loại</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Trạng thái</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ngày tạo</th>
                                    <th
                                        class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1 align-items-center">
                                                <span class="text-secondary "
                                                    style="min-width: 34px">#{{ $item->id }}</span>
                                                <div>
                                                    <img src={{ asset('storage/' . $item->image) }}
                                                        class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class=" flex-1">
                                                    <h6 style=" width:260px; "
                                                        class="mb-0 text-sm card-title overflow-hidden line-clame-1">
                                                        {{ $item->title }}</h6>
                                                    <p class="text-xs text-secondary mb-0">#thethao</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->category->name }}</p>
                                        </td>
                                        <td
                                            class="align-middle text-center text-sm d-flex flex-column gap-2 align-items-center">
                                            @if ($item->status == 'pending')
                                                <span class="badge badge-sm w-fit bg-gradient-info">
                                                    Chờ duyệt
                                                </span>
                                            @endif
                                            @if ($item->status == 'active')
                                                <span class="badge badge-sm w-fit bg-gradient-primary">
                                                    Hoạt động
                                                </span>
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
                                                <span class="badge badge-sm w-fit bg-gradient-danger cursor-pointer"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="Bad words({{ $item->reason_deny()->bad_words_total??0 }}): {{ $text }}">Từ
                                                    chối</span>
                                            @endif
                                            {{-- @if ($item->status == 'deny')
                                                <span class="badge badge-sm w-fit bg-gradient-danger">
                                                    Từ chối
                                                </span>
                                            @endif --}}
                                            @if ($item->is_show)
                                                <span class="badge badge-sm w-fit bg-gradient-success">Hiện</span>
                                            @else
                                                <span class="badge badge-sm w-fit bg-gradient-danger">Ẩn</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="align-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('updatenews', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-primary px-4"><i
                                                        class="fa-solid fa-pen-to-square"></i></a>
                                                <a href="{{ route('deletenews', ['id' => $item->id]) }}"
                                                    onclick="return confirm('Bạn có muốn xóa chứ?')"
                                                    class="btn btn-sm btn-danger px-4"><i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr aria-colspan="5">
                                        <td colspan="5" class="text-center text-danger py-5">Chưa có bài viết nào!</td>
                                    </tr>
                                @endforelse



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
