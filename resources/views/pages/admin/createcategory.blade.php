@extends('layouts.adminLayout')
@section('viewTitle')
    Tạo danh mục mới
@endsection
@section('main')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 m-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="">
                            <p class="mb-0 fw-bold fs-5 text-primary">{{isset($category)?'Sửa danh mục':'Tạo danh mục mới'}}</p>
                            <div>
                                @if (session('success'))
                                    <div class="alert alert-success py-2 text-white">{{ session('success') }}</div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-error py-2 text-white">{{ session('error') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="{{isset($category)?route('admin._editcategory',['id'=>$category->id]):''}}" class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 border-bottom pb-4 d-flex flex-column gap-3 align-items-center">
                                <label for="image" class="rounded-circle border shadow imgthumnail"
                                    style="width:120px;height:120px">
                                    <img width="120" height="120" id="img_preview"
                                        class="rounded-circle object-fit-cover "
                                        src='{{isset($category)?asset('storage/'.$category->icon_url):"https://www.creativefabrica.com/wp-content/uploads/2021/04/05/Photo-Image-Icon-Graphics-10388619-1-1-580x386.jpg"}}'
                                        alt="">
                                </label>
                                @error('icon_url')
                                    <small class="text-danger text-sm">{{ $message }}</small>
                                @enderror
                                <input name="icon_url" type="file" hidden id="image">
                                <label for="image" class="btn btn-outline-primary btn-sm mb-0"
                                    >Chọn ảnh</label>
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Tên</label>
                                    <input class="form-control" name="name"
                                        value="{{ isset($category) ? $category->name : (old('name') ? old('name') : '') }}"
                                        type="text" placeholder="Tên danh mục..">
                                    @error('name')
                                        <small class="text-danger text-sm">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Thứ tự</label>
                                    <input name="priority"
                                        value="{{ isset($priority) ? $category->priority : (old('priority') ? old('priority') : '1') }}"
                                        class="form-control" type="number" value="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ps-5">
                                    <label for="example-text-input" class="form-control-label">Trạng thái</label>
                                    <div class="form-check form-switch">
                                        <input name="is_show" class="form-check-input"
                                            checked="{{ isset($category) ? $category->is_show : ( (old('is_show') == 'on' ?true:false) ) }}"
                                            type="checkbox" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Hiện</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary">{{isset($category)?'Cập nhật':'Tạo mới'}}</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
@endsection
