@extends('layouts.appLayout')
@section('viewTitle')
    Quin | {{ $author->name }}
@endsection

@section('main')
    <div>
        <div class="row">
            <div class="col-md-4 border rounded-2 p-3 bg-white shadow " style="height: fit-content;">
                <div class="d-flex gap-3 align-items-center border-bottom pb-3 mb-3">
                    <div class="rounded-circle border shadow" style="width: 84px; height: 84px">
                        <img class="object-fit-cover rounded-circle" width="84px" height="84px" src={{ $author->avatar }}
                            alt="" />
                    </div>
                    <div>
                        <div class="fw-bold">{{ $author->name }}</div>
                        <small>{{ $author->email }}</small>
                        <div>{{ $author->followers_count() }} theo dõi</div>
                    </div>
                </div>
                <div>
                    <div>Bài viết: <strong>{{ $author->news_count }}</strong></div>
                    <div>Ý kiến: <strong>{{ $author->count_comments() }}</strong></div>

                    <div>
                        @if (auth()->check() && auth()->id() == $author->id)
                            <a href="" class="btn btn-outline-secondary w-100 mt-3">Chỉnh sửa sồ sơ</a>
                        @else
                            @if ($author->is_followed())
                                <a href="{{ route('follow_user', ['user_id' => $author->id]) }}"
                                    class="btn btn-warning w-100 mt-3">Bỏ theo dõi</a>
                            @else
                                <a href="{{ route('follow_user', ['user_id' => $author->id]) }}"
                                    class="btn btn-primary w-100 mt-3">Theo dõi</a>
                            @endif
                        @endif

                    </div>

                </div>
            </div>
            <div class="col-md-8 ps-4">
                <div class="border p-4 rounded-2 bg-white shadow">
                    <div class="fw-bold fs-5">Đã đóng góp ý kiến</div>

                    <div class="d-flex flex-column gap-2 mt-4">
                        @forelse ($comments as $item)
                            <div class="border-bottom pb-2">
                                <div class="d-flex justify-content-between text-sm text-warning">
                                    <div>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</div>
                                    <div class="text-primary fw-bold">{{$item->likes()}}<i class="fa-regular fa-thumbs-up ms-2"></i></div>
                                </div>
                                <div>
                                    <p>
                                       {{$item->comment}}
                                    </p>
                                    <div>
                                        <a href="{{route('detail',['slug_news'=>$item->news()->slug.'#comment'])}}" class="text-primary text-underline">Xem thảo luận</a>
                                    </div>
                                </div>
                            </div>
                           

                        @empty
                            <div class="text-center text-danger py-5">Chưa có bình luận nào!</div>
                        @endforelse
                        <div class="mt-2">
                            {{$comments->links()}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" border-top mt-5">
        <div class="fs-5 mt-3">
            Bài viết của <strong>{{$author->name}}</strong>
        </div>
        <div>
            <div>
                <div>
                    <div for="">Sắp xếp theo</div>
                    <form id="form-select">
                        <select name="sort" class="form-select w-20" id="select-sort">
                            <option value="all" {{ request()->sort == 'all' ? 'selected' : '' }}>--Tất cả--</option>
                            <option value="view" {{ request()->sort == 'view' ? 'selected' : '' }}>Lượt xem nhiều nhất
                            </option>
                            <option value="latest" {{ request()->sort == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                        </select>
                        <input type="text" name="show" hidden value="1#show">
                        <script>
                            $('#select-sort').on('change', function(e) {
                                window.location.href = "?sort=" + $(this).val() + "#show";
                            })
                        </script>
                    </form>
                </div>
            </div>

            <div class="mt-4" id="show">
                <div class="row">
                    @forelse ($data as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div class="w-100" style="height: 194px">
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        class="card-img-top w-100 object-fit-cover h-100" alt="..." />
                                </div>
                                <div class="card-body my-0 px-3 pt-0">
                                    <div class="d-flex justify-content-between my-2">
                                        <div class="text-sm">
                                            {{ $item->category->name }}
                                        </div>
                                        <div class="text-sm">
                                            {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</div>
                                    </div>
                                    <a href="{{ route('detail', ['slug_news' => $item->slug]) }}">
                                        <h5 class="card-title card-name" style="height: 56px">
                                            {{ $item->title }}
                                        </h5>
                                    </a>
                                    <p class="card-text card-name" style="height: 56px">
                                        {{ $item->subtitle }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('author', ['uuid' => $item->user->uuid]) }}"
                                            class="d-flex gap-1 align-items-center">
                                            <img src={{ $item->user->avatar }} class="rounded-circle object-fit-cover"
                                                width="24" height="24" alt="" />
                                            <div class="text-sm">{{ $item->user->name }}</div>
                                        </a>
                                        <div class="d-flex align-items-center gap-2 text-sm">
                                            <i class="fa-regular fa-eye"></i>
                                            <span>{{ $item->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-danger py-5 fw-bold">Không tin thấy tin nào!</div>
                    @endforelse
                </div>
                <div class="mt-5 mb-5">
                    <nav aria-label="Page navigation example " id="custom-pagination">
                        {{ $data->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
