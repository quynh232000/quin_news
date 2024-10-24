@extends('layouts.appLayout')
@section('viewTitle')
    {{ $news->title }}
@endsection
@push('css')
<style>
    .bg-ok{
        background-color: rgb(251, 246, 247)
    }    
</style>    
@endpush
@push('js1')
    <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
@endpush

@section('main')
    <div class="py-3">
        <div class="row">
            <div class="col-md-8">
                <a href="{{ asset('collection', ['slug_cate' => $news->category->slug]) }}">{{ $news->category->name }}</a>
                <div>
                    <h1 class="fs-3 py-2">
                        {{ $news->title }}
                    </h1>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('author', ['uuid' => $news->user->uuid]) }}"
                                    class="d-flex gap-2 align-items-center">
                                    <img width="28" height="28" class="object-fit-cover rounded-circle"
                                        src="{{ $news->user->avatar }}" alt="" />
                                    <div class="text-sm fw-bold">{{ $news->user->name }}</div>
                                </a>
                                <span class="px-1">·</span>
                                <div class="text-sm">{{ \Carbon\Carbon::parse($news->updated_at)->format('d/m/Y') }}</div>
                            </div>
                            <div class="d-flex gap-2">
                                <div>
                                    <span>{{ $news->views }}</span>
                                    <i class="fa-regular fa-eye"></i>
                                </div>
                                <span class="px-1">·</span>
                                <div class="d-flex gap-3">
                                    <div>{{ $news->reactions_type() }}</div>
                                    <div class="border border-primary rounded-2 px-2 bg-primary text-white">
                                        Like <i class="fa-regular fa-thumbs-up"></i>
                                        <!-- <i class="fa-solid fa-thumbs-up"></i> -->
                                    </div>
                                    <a href="{{ route('save_news', ['id' => $news->id]) }}"
                                        class="d-flex gap-2 align-items-center">
                                        @if ($news->is_saved())
                                            <i class="fa-solid fa-bookmark text-primary fs-4"></i>
                                            <span>Bỏ lưu</span>
                                        @else
                                            <i class="fa-regular fa-bookmark fs-4"></i>
                                            <span>Lưu</span>
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- content -->
                        <div class="py-3">
                            <div class="row">
                                <div class="col-md-12 px-4 m-auto pt-2">
                                    <i>
                                        "{{ $news->subtitle }}""
                                    </i>
                                </div>
                            </div>
                            <hr />
                            <style>
                                #content-body img {
                                    width: 100%;
                                }
                            </style>
                            <div id="content-body">
                                {!! $news->content !!}
                            </div>
                        </div>

                        <style>
                            .reaction-item {
                                background-color: pink;

                            }

                            .reaction-item i {
                                font-size: 20px;
                                cursor: pointer;
                                transform: scale(1.6)
                            }

                            .icon-hover i {
                                transition: .3s ease
                            }

                            .icon-hover i:hover {
                                transform: scale(1.6) !important;
                            }
                        </style>
                        <div class="border-top py-3" id="like">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div>Bài viết hay? Ấn để tương tác</div>
                                    <div class="mt-2 d-flex gap-3 icon-reaction">
                                        <a href="{{ route('like', ['id' => $news->id, 'type' => 'love']) }}"
                                            class="border w-fit px-2 rounded-lg {{ $news->is_reaction('love') ? ' reaction-item' : '' }}">
                                            <span class="text-danger icon-hover"><i class="fa-solid fa-heart"></i></span>
                                            <span class="ms-1">{{ $news->reactions_type('love') }}</span>
                                        </a>
                                        <a href="{{ route('like', ['id' => $news->id, 'type' => 'like']) }}"
                                            class="border w-fit px-2 rounded-lg {{ $news->is_reaction('like') ? ' reaction-item' : '' }}">
                                            <span class="text-primary icon-hover"><i
                                                    class="fa-solid fa-thumbs-up"></i></span>
                                            <span class="ms-1">{{ $news->reactions_type('like') }}</span>
                                        </a>
                                        <a href="{{ route('like', ['id' => $news->id, 'type' => 'angry']) }}"
                                            class="border w-fit px-2 rounded-lg {{ $news->is_reaction('angry') ? ' reaction-item' : '' }}">
                                            <span class="text-success icon-hover"><i
                                                    class="fa-solid fa-face-smile"></i></span>
                                            <span class="ms-1">{{ $news->reactions_type('angry') }}</span>
                                        </a>
                                        <a href="{{ route('like', ['id' => $news->id, 'type' => 'unlike']) }}"
                                            class="border w-fit px-2 rounded-lg {{ $news->is_reaction('unlike') ? ' reaction-item' : '' }}">
                                            <span class="text-warning icon-hover"><i
                                                    class="fa-solid fa-face-angry"></i></span>
                                            <span class="ms-1">{{ $news->reactions_type('unlike') }}</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="border-top" id="comment">
                            <div class="fw-bold fs-5 my-3">
                                Ý kiến <span>({{$total_comment}})</span>
                            </div>
                            <form method="POST" action="{{ route('comment', ['id' => $news->id, 'from' => 'news']) }}">
                                @csrf
                                <textarea name="comment" placeholder="Chia sẻ ý kiến của bạn" class="form-control" rows="3" id=""></textarea>
                                <div class="mt-2 d-flex justify-content-end">
                                    <button class="btn btn-primary btn-sm px-5">Gửi</button>
                                </div>
                            </form>
                            <div id="comment">
                                <div class="border-bottom">
                                    <div class="text-danger fw-bold py-2 border-bottom border-danger w-fit border-2 px-2">
                                        Mới nhất
                                    </div>
                                </div>
                            </div>
                           
                            <div class="d-flex flex-column py-3 gap-3 mt-4">
                                <div id="list-comments" class="d-flex flex-column  gap-3">

                                </div>
                                @forelse ($comments as $item)
                                    <div class="d-flex gap-2">
                                        <div>
                                            <img class="rounded-circle object-fit-cover" width="42" height="42"
                                                src="{{ $item->user->avatar }}" alt="" />
                                        </div>
                                        <div class="flex-1 comment-item-body{{ $item->id }}">
                                            <div>
                                                <div>
                                                    <a
                                                        href="{{ route('author', ['uuid' => $item->user->uuid]) }}"><strong>{{ $item->user->name }}</strong></a><span
                                                        class="ms-2">{{ $item->comment }}.</span>
                                                </div>
                                                <div
                                                    class="d-flex gap-2 justify-content-between align-items-center py-2 text-sm">
                                                    <div class="d-flex gap-4">
                                                        @if ($item->is_like())
                                                            <a href="{{ route('like', ['id' => $item->id, 'type' => 'like', 'from' => 'comment']) }}"
                                                                class="d-flex gap-1 align-items-center">
                                                                <i class="fa-solid fa-thumbs-up text-primary"></i>
                                                                <span class="ms-1">Bỏ thích</span>
                                                                <span>{{ $item->likes() }}</span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('like', ['id' => $item->id, 'type' => 'like', 'from' => 'comment']) }}"
                                                                class="d-flex gap-1 align-items-center">
                                                                <i class="fa-regular fa-thumbs-up"></i>
                                                                <span class="ms-1">{{ $item->likes() }}</span>

                                                                <span>Thích</span>
                                                            </a>
                                                        @endif
                                                        @if (auth()->check())
                                                            <div class="cursor-pointer btn-reply"
                                                                data-comment="{{ $item->id }}">
                                                                ({{ $item->replies_count() }})
                                                                Trả lời</div>
                                                        @else
                                                            <a href="{{ route('login') }}"
                                                                class="cursor-pointer ">({{ $item->replies_count() }})Trả
                                                                lời</a>
                                                        @endif
                                                    </div>
                                                    <div class="text-sm">
                                                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if (count($item->replies()) > 0)
                                                {{-- <a href=""
                                                    class="text-primary text-sm d-flex gap-2 align-items-center">Trả
                                                    lời <i class="fa-solid fa-reply"></i></a> --}}
                                                @foreach ($item->replies() as $child)
                                                    <div class="d-flex gap-2 border-start ps-3 mb-2 pt-2 border-top">
                                                        <div>
                                                            <img class="rounded-circle object-fit-cover" width="42"
                                                                height="42" src="{{ $child->user->avatar }}"
                                                                alt="" />
                                                        </div>
                                                        <div class="flex-1 comment-item-body{{ $child->id }}">
                                                            <div>
                                                                <div>
                                                                    <a
                                                                        href="{{ route('author', ['uuid' => $child->user->uuid]) }}"><strong>{{ $child->user->name }}</strong></a><span
                                                                        class="ms-2">{{ $child->comment }}.</span>
                                                                </div>
                                                                <div
                                                                    class="d-flex gap-2 justify-content-between align-items-center py-2 text-sm">
                                                                    <div class="d-flex gap-4">
                                                                        @if ($child->is_like())
                                                                            <a href="{{ route('like', ['id' => $child->id, 'type' => 'like', 'from' => 'comment']) }}"
                                                                                class="d-flex gap-1 align-items-center">
                                                                                <i
                                                                                    class="fa-solid fa-thumbs-up text-primary"></i>
                                                                                <span class="ms-1">Bỏ thích</span>
                                                                                <span>{{ $child->likes() }}</span>
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ route('like', ['id' => $child->id, 'type' => 'like', 'from' => 'comment']) }}"
                                                                                class="d-flex gap-1 align-items-center">
                                                                                <i class="fa-regular fa-thumbs-up"></i>
                                                                                <span
                                                                                    class="ms-1">{{ $child->likes() }}</span>

                                                                                <span>Thích</span>
                                                                            </a>
                                                                        @endif
                                                                        @if (auth()->check())
                                                                            <div class="cursor-pointer btn-reply"
                                                                                data-comment="{{ $child->id }}">
                                                                                ({{ $child->replies_count() }})
                                                                                Trả lời
                                                                            </div>
                                                                        @else
                                                                            <a href="{{ route('login') }}"
                                                                                class="cursor-pointer ">({{ $child->replies_count() }})
                                                                                Trả
                                                                                lời</a>
                                                                        @endif
                                                                    </div>
                                                                    <div class="text-sm">
                                                                        {{ \Carbon\Carbon::parse($child->created_at)->diffForHumans() }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (count($child->replies()) > 0)
                                                                <div class="see-more">
                                                                    <div data-id="{{ $child->id }}"
                                                                        class="text-secondary cursor-pointer text-sm btn-see-more d-flex gap-2 align-items-center">
                                                                        Xem
                                                                        thêm <i class="fa-solid fa-reply"></i></div>

                                                                    <div class="see-more-body">

                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="show-form-reply{{ $child->id }}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="show-form-reply{{ $item->id }}">

                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-danger py-5 text-center">
                                        Chưa có bình luận nào!
                                    </div>
                                @endforelse
                            </div>
                            <div class="border-top mt-3 pt-3">

                                <nav aria-label="Page navigation example">
                                    {{ $news->comments()->paginate(5) }}
                                </nav>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 ps-4">
                <div class="card">
                    <div class="card-body">
                        <div class="fw-bold fs-5">Tin tức nổi bật</div>
                        <div class="mt-4 d-flex flex-column gap-2">
                            @foreach ($news_hot as $item)
                                <div class="row d-flex align-items-start border-top py-3">
                                    <div class="col-md-4 px-0 rounded-2 border">
                                        <img class="w-100  object-fit-cover rounded-2" style="height: 56px"
                                            src="{{ asset('storage/' . $item->image) }}" alt="">
                                    </div>
                                    <div class="col-md-8 ">
                                        <a href="{{ route('detail', ['slug_news' => $item->slug]) }}">
                                            <h4 class="card-name overflow-hidden fw-bold text-sm">{{ $item->title }}</h4>
                                        </a>
                                        <div class="d-flex justify-content-between text-sm mt-1">
                                            <div class="text-sm">{{ $item->views }} Xem</div>
                                            <div>{{ $item->reactions_type() }} thích</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js2')
    <script>
        function replyForm() {
            $('.btn-reply').on('click', function() {
                const entity_id = $(this).attr('data-comment')
                const show_form = $(this).closest('.comment-item-body' + entity_id).find('.show-form-reply' +
                    entity_id)

                if (show_form) {

                    show_form.html(`
                    <form method="POST" class="position-relative" action="/author/comment/${entity_id}?from=reply" >
                        @csrf
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                        <button type="submit"
                            class="btn btn-sm btn-primary position-absolute end-1 "
                            style="bottom:5px">Gửi</button>
                    </form>
                `)
                }
            })
        }
        replyForm()
        // seemore 
        $('.btn-see-more').on('click', function() {
            const id = $(this).attr('data-id');
            $.ajax('/api/child_comments/' + id)
                .done(data => {
                    const el = $(this).siblings()
                    const html = data.map(item => {
                        return `
                                <div class="d-flex gap-2 border-start ps-3 mb-2 pt-2 border-top">
                                    <div>
                                        <img class="rounded-circle object-fit-cover" width="42"
                                            height="42" src="${item.user.avatar}"
                                            alt="" />
                                    </div>
                                    <div class="flex-1 comment-item-body${item.user.id}">
                                        <div>
                                            <div>
                                                <a
                                                    href="/user/${item.user.uuid}"><strong>${item.user.name}</strong></a><span
                                                    class="ms-2">${item.comment}.</span>
                                            </div>
                                            <div
                                                class="d-flex gap-2 justify-content-between align-items-center py-2 text-sm">
                                                <div class="d-flex gap-4">
                                                    ${item.is_like ?  `<a href="/author/like/${item.id}?type=like&from=comment"
                                                                                        class="d-flex gap-1 align-items-center">
                                                                                        <i
                                                                                            class="fa-solid fa-thumbs-up text-primary"></i>
                                                                                        <span class="ms-1">Bỏ thích</span>
                                                                                        <span>${item.likes}</span>
                                                                                    </a>`:`<a href="/author/like/${item.id}?type=like&from=comment"
                                                                                        class="d-flex gap-1 align-items-center">
                                                                                        <i class="fa-regular fa-thumbs-up"></i>
                                                                                        <span
                                                                                            class="ms-1">${item.likes}</span>

                                                                                        <span>Thích</span>
                                                                                    </a>`}
                                                        <div class="cursor-pointer btn-reply"
                                                                data-comment="${item.id}">
                                                              (${item.replies_count})
                                                                Trả lời
                                                        </div>                                                   
                                                </div>
                                                <div class="text-sm">
                                                    ${item?.created_at?.split('T')[0]}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="show-form-reply${item.id}">

                                        </div>
                                    </div>
                                </div>
                        `
                    }).join('')


                    $(el).html(html)
                    replyForm()

                })

        })
    </script>
    <script>
        const news_id = {{ $news->id }} + ""
        var pusher = new Pusher("a8e442a1795eb4a97f74", {
            cluster: "ap1",
        });
        
        var channel = pusher.subscribe("news." + news_id);
        
        channel.bind("comment", (data) => {
            const item = data.comment
            const html =`
                 <div class="d-flex gap-2  px-3 mb-2 pt-2 bg-ok">
                    <div>
                        <img class="rounded-circle object-fit-cover" width="42"
                            height="42" src="${item.user.avatar}"
                            alt="" />
                    </div>
                    <div class="flex-1 comment-item-body${item.user.id}">
                        <div>
                            <div>
                                <a
                                    href="/user/${item.user.uuid}"><strong>${item.user.name}</strong></a><span
                                    class="ms-2">${item.comment}.</span>
                            </div>
                            <div
                                class="d-flex gap-2 justify-content-between align-items-center py-2 text-sm">
                                <div class="d-flex gap-4">
                                    ${item.is_like ?  `<a href="/author/like/${item.id}?type=like&from=comment"
                                                                        class="d-flex gap-1 align-items-center">
                                                                        <i
                                                                            class="fa-solid fa-thumbs-up text-primary"></i>
                                                                        <span class="ms-1">Bỏ thích</span>
                                                                        <span>0</span>
                                                                    </a>`:`<a href="/author/like/${item.id}?type=like&from=comment"
                                                                        class="d-flex gap-1 align-items-center">
                                                                        <i class="fa-regular fa-thumbs-up"></i>
                                                                        <span
                                                                            class="ms-1">0</span>

                                                                        <span>Thích</span>
                                                                    </a>`}
                                        <div class="cursor-pointer btn-reply"
                                                data-comment="${item.id}">
                                                (0)
                                                Trả lời
                                        </div>                                                   
                                </div>
                                <div class="text-sm">
                                    vừa xong
                                </div>
                            </div>
                        </div>
                        <div class="show-form-reply${item.id}">

                        </div>
                    </div>
                </div>
            `
            $('#list-comments').html(html +$('#list-comments').html())
            
        });
    </script>
@endpush
