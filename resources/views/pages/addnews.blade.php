@extends('layouts.appLayout')
@section('viewTitle')
    Trang chủ | Quin News
@endsection
@push('js1')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush
@push('css')
    <style>
        .tag-close {
            /* display: none; */
            top: -15px;
            right: 0px;
            border-radius: 50%;
            transition: .3s ease
        }

        .tag-close:hover {
            color: red
        }

        .tag-body:hover .tag-close {
            display: inline-block;
        }
    </style>
@endpush
@section('main')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 fw-bold fs-5 text-primary">
                                {{ isset($news) ? 'Cập nhật tin tức' : 'Thêm tin tức mới' }}</p>
                            {{-- <button class="btn btn-primary btn-sm ms-auto">Settings</button> --}}
                        </div>

                    </div>
                    <div>
                        @if (session('success'))
                            <div class="alert alert-success py-2 text-white">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-error py-2 text-white">{{ session('error') }}</div>
                        @endif
                    </div>
                    <div class="card-body border-top">
                        <p class="text-uppercase text-sm">Thông tin tin tức</p>
                        <form method="post" enctype="multipart/form-data"
                            action="{{ isset($news) ? route('updatenews', ['id' => $news->id]) : '' }}" class="row" id="form-add">
                            @csrf
                            <div class="col-md-6 d-flex">
                                <label for="image">
                                    <div class="" style="width:140px;height:140px">
                                        <img id="img_preview" class=" object-fit-cover img-thumbnail w-100 h-100"
                                            src={{ isset($news) ? asset('storage/' . $news->image) : 'https://www.creativefabrica.com/wp-content/uploads/2021/04/05/Photo-Image-Icon-Graphics-10388619-1-1-580x386.jpg' }}
                                            alt="">
                                    </div>
                                </label>
                                <input id="image" type="file" name="image" hidden>
                                <div class="d-flex flex-1 flex-column justify-content-center align-items-center">
                                    <label class="btn btn-outline-secondary" for="image"><i
                                            class="fa-solid fa-upload me-2"></i>Tải lên</label>
                                    @error('image')
                                        <small class="text-danger mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                                <script>
                                    $("#image").change(function(e) {
                                        const [file] = e.target.files
                                        if (file) {
                                            const url = URL.createObjectURL(file)
                                            $("#img_preview").attr('src', url)

                                        }
                                    })
                                </script>
                            </div>
                            <div class="col-md-6 border-start">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Trạng thái</label>
                                    <div class="form-check form-switch">
                                        @if (isset($news))
                                            <input class="form-check-input" {{ $news->is_show ? 'checked' : '' }}
                                                name="is_show" type="checkbox" id="rememberMe">
                                        @else
                                            <input class="form-check-input" {{ old('is_show') ? 'checked' : '' }}
                                                name="is_show" type="checkbox" id="rememberMe">
                                        @endif
                                        <label class="form-check-label" for="rememberMe">Hiện</label>
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="example-text-input" name="title" class="form-control-label">Tiêu
                                        đề</label>
                                    <input class="form-control" name="title" type="text" placeholder="Tiêu đề"
                                        value="{{ isset($news) ? $news->title : (old('title') ? old('title') : '') }}">

                                    @error('title')
                                        <small class="text-danger mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" name="title" class="form-control-label">Danh
                                        mục</label>
                                    <select name="category_id" id="" class="form-select">
                                        <option value="">--Chọn--</option>
                                        @foreach ($categories as $item)
                                            @if (isset($news))
                                                <option {{ $news->category_id == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @else
                                                <option {{ old('category_id') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <small class="text-danger mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" name="subtitle" class="form-control-label">Subtitle
                                        </label>
                                    <textarea name="subtitle" placeholder="Sub title"
                                        rows="3" class="form-control">{{ isset($news) ? $news->subtitle : (old('subtitle') ? old('subtitle') : '') }}</textarea>


                                    @error('subtitle')
                                        <small class="text-danger mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>


                            {{-- <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="" class="form-label">Tags</label>
                                            <select name="tag" id="" class="form-select">
                                                <option value="">--select--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-9 d-flex align-items-end gap-3 pb-4">
                                        <div class="position-relative tag-body">
                                            <span class="text-xs border p-2 rounded-2 text-primary">
                                                #thethao</span>
                                            <a href="" class="position-absolute tag-close"><i
                                                    class="fa-regular fa-circle-xmark"></i></a>
                                        </div>
                                        <div class="position-relative tag-body">
                                            <span class="text-xs border p-2 rounded-2 text-primary">
                                                #thethao</span>
                                            <a href="" class="position-absolute tag-close"><i
                                                    class="fa-regular fa-circle-xmark"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Nội dung</label>
                                    <div>
                                        <div id="editor" class="w-100" style="min-height: 240px">{!! isset($news) ? $news->content : '' !!}
                                        </div>

                                        <input type="hidden"
                                            value="{{ isset($news) ? $news->content : (old('description') ? old('description') : '') }}"
                                            name="description" id="description">
                                        @error('description')
                                            <small class="text-danger mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-center">
                                <button class="btn btn-primary "
                                    type="submit">{{ isset($news) ? 'Cập nhật tin tức' : 'Thêm tin tức mới' }}</button>
                            </div>
                        </form>



                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js2')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        const quill = new Quill('#editor', {
            theme: 'snow'
        });
        var form = document.querySelector('#form-add');
        form.onsubmit = function(e) {
            // e.preventDefault();
            var contentInput = document.querySelector('#description');
           
            contentInput.value = quill.root.innerHTML;
        };
    </script>
@endpush
