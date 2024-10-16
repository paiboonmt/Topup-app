@extends('admin.layout')

@section('title', 'Trainer page')

@section('content')

    <div class="row py-2">
        <h1>Form Update Trainer</h1>
    </div>

    <div class="row py-2">
        <div class="col-12">
            <div class="card p-1">
                <form action="{{ route('admin.trainer_update', $data->id) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- Data input --}}
                        <div class="col-6">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Code</span>
                                </div>
                                <input type="number" class="form-control" name="code" value="{{ $data->code }}">
                            </div>

                            @error('code')
                                <div class="input-group">
                                    <div class="my-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Name</span>
                                </div>
                                <input type="text" class="form-control" name="name" value="{{ $data->name }}">
                            </div>

                            @error('name')
                                <div class="input-group">
                                    <div class="my-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Phone</span>
                                </div>
                                <input type="number" class="form-control" name="phone" value="{{ $data->phone }}">
                            </div>

                            @error('phone')
                                <div class="input-group">
                                    <div class="my-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Create At</span>
                                </div>
                                <input type="text" class="form-control" name="created_at" value="{{ $data->created_at }}">
                            </div>

                            <button type="submit" class="btn btn-warning mt-5 col-12">UPDATE DATA</button>

                        </div>

                        {{-- Image --}}
                        <div class="col-6">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload Image</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="image" id="imageUpload" accept="image/*">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                            </div>

                            {{-- Show image --}}
                            <div id="imagePreview">
                                <img id="preview" src="{{ asset('images/trainer/'.$data->image) }}" width="50%">
                            </div>

                            {{-- Old --}}
                            <input type="hidden" name="oldImage" value="{{ $data->image }}">

                        </div>
                    </div> <!-- end row -->
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('update'))
        <script>
            Swal.fire({
                title: "Good job!",
                text: "{{ session('update') }}",
                icon: "success"
            });
        </script>
    @endif

    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        });
    </script>

@endsection

