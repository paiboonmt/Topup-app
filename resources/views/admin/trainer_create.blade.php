@extends('admin.layout')

@section('title', 'Trainer page')

@section('content')

    <div class="row py-1">
        <h1>Form Create Trainer</h1>
    </div>

    <div class="row py-1">
        <div class="col-12">
            <div class="card p-1">
                <form action="{{ route('admin.trainer_store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        {{-- Data input --}}
                        <div class="col-6">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Code</span>
                                </div>
                                <input type="number" class="form-control" name="code" placeholder="Only Input number.">
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
                                <input type="text" class="form-control" name="name">
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
                                <input type="number" class="form-control" name="phone" placeholder="Only Input number.">
                            </div>

                            @error('phone')
                                <div class="input-group">
                                    <div class="my-1">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-success col-12">SAVE</button>

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
                                <img id="preview" src="#" style="display:none;" width="50%">
                            </div>



                        </div>
                    </div> <!-- end row -->
                </form>
            </div>
        </div>
    </div>

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

