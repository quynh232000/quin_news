@extends('layouts.appLayout')
@section('viewTitle')
    Quin | {{ $viewTitle }}
@endsection

@section('main')
    <div>
        <div>
            <div>
                <div for="">Sắp xếp theo</div>
                <form id="form-sort">
                    <select name="sort" class="form-select w-20" id="select-sort">
                        <option value="all">--Tất cả--</option>
                        <option value="view">
                            Lượt xem nhiều nhất
                        </option>
                        <option value="latest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                    </select>
                    <script>
                        $("#select-sort").on('change',function(){
                            window.location.href = '?sort='+$(this).val()+"#show";
                        })
                    </script>
                </form>
            </div>
        </div>
        <div class="mt-5" id="show">
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
@endsection
