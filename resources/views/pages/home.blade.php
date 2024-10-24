@extends('layouts.appLayout')
@section('viewTitle')
    Trang chủ | Quin News
@endsection

@section('main')
    <div class="mb-5 pb-5">
        <div class="fw-bold fs-4">Tin nổi bật</div>
        @if (count($news_hot) > 0)
            <div class="row my-2">

                <div class="col-md-5  bg-white">
                    <div>
                        <img class="w-100 rounded-3" src="{{ asset('storage/' . $news_hot[0]->image) }}" alt="" />
                    </div>
                    <div class="d-flex flex-column gap-2 ">
                        <div class="d-flex align-items-center justify-content-between mt-2 ">
                            <div class="text-sm">
                                {{ $news_hot[0]->category->name }}
                            </div>
                            <div class="text-sm">
                                {{ \Carbon\Carbon::parse($news_hot[0]->updated_at)->diffForHumans() }}</div>
                        </div>
                        <a href="{{ route('detail', ['slug_news' => $news_hot[0]->slug]) }}">
                            <h2 class="fw-bold fs-4">
                                {{ $news_hot[0]->title }}
                            </h2>
                        </a>
                        <p class="">
                            {{ $news_hot[0]->subtitle }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{route('author',['uuid'=>$news_hot[0]->user->uuid])}}" class="d-flex gap-2 align-items-center">
                                <img width="24" height="24" class="rounded-circle"
                                    src="{{ $news_hot[0]->user->avatar }}" alt="" />
                                <div class="text-sm">{{ $news_hot[0]->user->name }}</div>
                            </a>
                            <div class="d-flex align-items-center gap-2 text-sm">
                                <i class="fa-regular fa-eye"></i>
                                <span>{{ $news_hot[0]->views }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 flex flex-column gap-2 ">
                    @foreach ($news_hot as $key => $item)
                        @if ($key > 0)
                            <div class="border-bottom mb-2 pb-2">
                                <div class="row d-flex ">
                                    <div class="col-4 d-flex">
                                        <img class="w-100 rounded-3 object-fit-cover" height="160"
                                            src={{ asset('storage/' . $item->image) }} alt="{{ $item->title }}" />
                                    </div>
                                    <div class="col-8 d-flex flex-column justify-content-between ">
                                        <div>
                                            <a href="{{ route('detail', ['slug_news' => $item->slug]) }}"
                                                class="fs-5 text-hover-primary">
                                                <h4 class="fs-5 ">
                                                    {{ $item->title }}
                                                </h4>
                                            </a>
                                            <p>
                                                {{ $item->subtitle }}
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-between ">
                                            <div class="text-sm">
                                                {{ $item->category->name }}
                                            </div>
                                            <div class="text-sm d-flex align-items-center gap-2">
                                                {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="d-flex gap-1 align-items-center">
                                            <img src={{ $item->user->avatar }} class="rounded-circle object-fit-cover"
                                                width="24" height="24" alt="" />
                                            <a  class="" href="{{route('author',['uuid'=>$item->user->uuid])}}">{{ $item->user->name }}</a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-sm">
                                            <i class="fa-regular fa-eye"></i>
                                            <span>{{ $item->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
        @endif

        <div class="fw-bold fs-4 pt-5 d-flex justify-content-between align-items-center">
            <div>Tin mới</div>
            <div class="text-sm text-primary">Xem thêm</div>
        </div>
        <div class="d-flex flex-column gap-2">
            @foreach ($news_new as $item)
                <div class="border-bottom py-3">
                    <div class="row d-flex">
                        <div class="col-4 d-flex">
                            <img class="w-100 rounded-3" src={{ asset('storage/' . $item->image) }} alt="" />
                        </div>
                        <div class="d-flex flex-column col-8">
                            <a href="{{ route('detail', ['slug_news' => $item->slug]) }}">
                                <h4 class="fs-5">
                                    {{ $item->title }}
                                </h4>
                            </a>
                            <p>
                                {{ $item->subtitle }}
                            </p>
                            <div class="d-flex justify-content-between my-2">
                                <div class="text-sm">
                                    {{ $item->category->name }}
                                </div>
                                <div class="text-sm">
                                    {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</div>
                            </div>
                            <div class="d-flex justify-content-between my-2">
                                <div class="d-flex gap-1">
                                    <img src={{ $item->user->avatar }} class="rounded-circle" width="24" height="24"
                                        alt="" />
                                    <a href="{{route('author',['uuid'=>$item->user->uuid])}}">{{ $item->user->name }}</a>
                                </div>
                                <div class="d-flex align-items-center gap-2 text-sm">
                                    <i class="fa-regular fa-eye"></i>
                                    <span>{{ $item->views }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="">
            <div class="fw-bold fs-4 pt-5 d-flex justify-content-between align-items-center">
                <div>Tin xem nhiều</div>
                <div class="text-sm text-primary">Xem thêm</div>
            </div>
            <div class="row py-3">
                @foreach ($news_views as $item)
                    <div class="col-md-4 position-relative item-news">
                        <div class="w-100 object-fit-cover" style="height: 230px">
                            <img class="w-100 h-100 object-fit-cover rounded-3"
                                src="{{ asset('storage/' . $item->image) }}" alt="" />
                        </div>
                        <div class="position-absolute bg-white w-80 rounded-3 item-label-news shadow"
                            style="top: 80%; border-top-left-radius: 0 !important">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold px-3 py-1 text-sm my-4 mb-2"
                                    style="background-color: rgb(255, 232, 232);width: fit-content;">
                                    {{ $item->category->name }}
                                </div>
                                <div class="d-flex align-items-center gap-2 text-sm me-2 text-secondary">
                                    <i class="fa-regular fa-eye"></i>
                                    <span>{{ $item->views }}</span>
                                </div>
                            </div>
                            <a href="{{route('detail',['slug_news'=>$item->slug])}}" class="pb-2">
                                <h2 class="fw-bold card-name text-title mb-2 px-2 fs-6 pb-3" style="height: 40px">
                                    {{$item->title}}
                                </h2>
                            </a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>

        <div class="pb-5">
            <div class="fw-bold fs-4 d-flex justify-content-between align-items-center">
                <div>Tin tức về thời sự</div>
                <div class="text-sm text-primary">Xem thêm</div>
            </div>

            <div class="py-3">
                <div class="row">
                    @foreach ($news_thoisu as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-lg">
                                <div class=" w-100" style="height: 194px;">
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        class="card-img-top w-100 object-fit-cover h-100" alt="...">
                                </div>
                                <div class="card-body my-0 px-3 pt-0">
                                    <div class="d-flex justify-content-between align-items-center mt-2 mb-2">
                                        <div class="text-sm">
                                            {{ $item->category->name }}
                                        </div>
                                        <span
                                            class="text-sm">{{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}</span>
                                    </div>

                                    <a href="{{ route('detail', ['slug_news' => $item->slug]) }}">
                                        <h5 class="card-title card-name" style="height: 52px">
                                            {{ $item->title }}</h5>
                                    </a>
                                    <p class="card-text card-name" style="height: 52px">
                                        {{ $item->subtitle }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex gap-1">
                                            <img src={{ $item->user->avatar }} class="rounded-circle" width="24"
                                                height="24" alt="" />
                                            <a href="{{route('author',['uuid'=>$item->user->uuid])}}">{{ $item->user->name }}</a>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-sm">
                                            <i class="fa-regular fa-eye"></i>
                                            <span>{{ $item->views }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
