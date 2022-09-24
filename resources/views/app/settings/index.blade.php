@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	

<div class="main-col-content" id="whitelabel-app">
    <h1 class="page-title">User Details</h1>
    @csrf


    <div class="whitelabel-row">
      <div class="whitelable-col">
        <div class="whitelabel-box">
          <h4 class="section-heading">Details</h4>

          <form method="POST" @submit.prevent>
            <div class="row mb-3">
              <label for="appName" class="col-sm-5 col-form-label col-form-label-sm">Name</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="appName" v-model="user.name">
              </div>
            </div>
            <div class="row mb-3">
              <label for="customDomain" class="col-sm-5 col-form-label col-form-label-sm">Email</label>
              <div class="col-sm-7">
                <input type="text" style="background: #1d1f42;" class="form-control form-control-sm" id="customDomain" v-model="user.email" disabled>
              </div>
            </div>

            <div class="button-wrap">
              <button class="btn btn-primary btn-sm" type="button" @click="updateDetails" :disabled="isLoading">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
      <div class="whitelable-col">
        <div class="whitelabel-box">
          <h4 class="section-heading">Password</h4>

          <form method="POST" @submit.prevent>
            <div class="row mb-3">
              <label for="smtpHost" class="col-sm-5 col-form-label col-form-label-sm">New password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control form-control-sm" id="smtpHost" v-model="user.password">
              </div>
            </div>
            <div class="row mb-3">
              <label for="mailPort" class="col-sm-5 col-form-label col-form-label-sm">Confirm Password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control form-control-sm" id="mailPort" v-model="user.confirm_password">
              </div>
            </div>
            

            <div class="button-wrap">
              <button class="btn btn-primary btn-sm" type="button" @click="updatePassword" :disabled="isLoading">
                Save
              </button>
            </div>
          </form>
        </div>

        {{-- <div class="mt-4">
          <h4 class="section-heading">Welcome Email</h4>
          <form post="POST" @submit.prevent>
            <textarea id="emailEditor" class="form-control" v-model="whitelabelConfig.welcome_mail"></textarea>
            
            <div class="button-wrap">
              <button class="btn btn-primary btn-sm" :disabled="isLoading" @click="updateWelcomeEmail">
                Save
              </button>
            </div>
          </form>
        </div> --}}
      </div>
    </div>
</div>
<textarea style="display:none" id="update-details" cols="30" rows="10">{{ route('user.settings.details') }}</textarea>
<textarea style="display:none" id="update-password" cols="30" rows="10">{{ route('user.settings.password') }}</textarea>
{{-- <textarea style="display:none" id="update-welcome-email" cols="30" rows="10">{{ route('user.whitelabel.update-welcome-email') }}</textarea> --}}
{{-- <textarea style="display:none" id="update-logo" cols="30" rows="10">{{ route('user.whitelabel.update-logo') }}</textarea> --}}
<textarea style="display:none" id="user-details" cols="30" rows="10">{{json_encode(Auth::user())}}</textarea>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.0/tinymce.min.js"></script>

<script src="{{ asset('js/app/user-settings.js') }}"></script>

@endsection