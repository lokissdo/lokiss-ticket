@extends('auth.master')
@section('content')
    <h1 class="d-flex justify-content-center mt-4 fw-bolder">Sign up</h1>
    <div class="card-body px-2 py-5 px-md-5">
        <form>
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="form-outline">
                        <input type="text" id="form3Example1" class="form-control" />
                        <label class="form-label" for="form3Example1">First name</label>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="form-outline">
                        <input type="text" id="form3Example2" class="form-control" />
                        <label class="form-label" for="form3Example2">Last name</label>
                    </div>
                </div>
            </div>

            {{-- address --}}

          <div class="row">
            <div class="col-md-6 mb-2">
              <label  for="select_pro"> Tỉnh / thành </label>
              <select name="shipping_province" class="w-100" id="select_pro">
                  <option data-code="null" value="null"> Chọn tỉnh / thành </option>
              </select>
            </div>
            <div class="col-md-6 mb-2">
                 <label for="select_dis"> Quận / huyện </label>
                <select name="shipping_districts" class="w-100" id="select_dis">
                    <option data-code="null" value="null"> Chọn quận / huyện </option>
                </select>
            </div>
        </div>

            <!-- Email input -->
            <div class="form-outline mb-2">
                <input type="email" id="form3Example3" class="form-control" />
                <label class="form-label" for="form3Example3">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
                <input type="password" id="form3Example4" class="form-control" />
                <label class="form-label" for="form3Example4">Password</label>
            </div>

            




            <!-- Submit button -->
            <div class="form-outline mb-4  d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-block mx-auto">
                    <span class="btn-inner--text">Sign up</span>
                </button>
            </div>
            <!-- Register buttons -->
            <div class="text-center">
                <h5>or sign up with:</h5>
                @include('components.icons')
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/auth/register.js') }}"></script>
@endpush
