@extends('auth.master')
@section('content')
    <h1 class="d-flex justify-content-center mt-4 fw-bolder">Sign up</h1>
    <div class="card-body px-2 py-5 px-md-5">
        <form method="POST">
            @csrf
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row">
                <div class="col-md-6 w-100 mb-2">
                    <div class="form-outline">
                        <label class="form-label" for="form3Example2">Your name</label>
                        <input type="text" name="name" id="form3Example2" class="form-control"
                            value="{{ old('name') }}" />
                    </div>
                </div>
            </div>

            {{-- address --}}
            @if (!is_null(old('address')))
                <script>
                    const preAddressCode = {{ old('address') }};
                </script>
            @endif

            @if (!is_null(old('address2')))
                <script>
                    const preAddress2Code = {{ old('address2') }};
                </script>
            @endif
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="select_pro"> Tỉnh / thành </label>
                    <select name="address" class="w-100" id="select_pro">
                        <option data-code="null" value="null"> Chọn tỉnh / thành </option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="select_dis"> Quận / huyện </label>
                    <select name="address2" class="w-100" id="select_dis">
                        <option data-code="null" value="null"> Chọn quận / huyện </option>
                    </select>
                </div>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form3Example3">Email address</label>
                <input type="email" id="form3Example3" name="email" class="form-control" value="{{ old('email') }}" />

            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
                <label class="form-label" for="form3Example4">Password</label>
                <input type="password" id="form3Example4" class="form-control" name="password"
                    value="{{ old('password') }}" />
            </div>






            <!-- Submit button -->
            <div class="form-outline mb-4  d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-block mx-auto">
                    <span class="btn-inner--text">Sign up</span>
                </button>
            </div>

        </form>
        <!-- Register buttons -->
        <div class="text-center">
            <h5>or sign up with:</h5>
            @include('icons.social_media')
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/components/address2.js') }}"></script>
@endpush
