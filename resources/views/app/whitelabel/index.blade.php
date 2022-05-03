@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	

<div class="main-col-content" id="whitelabel-app">
    <h1 class="page-title">Whitelabel</h1>
    @csrf

    <div class="page-tab-nav">
      <div class="btn-group">
        <a href="{{ route('user.whitelabel')}}" class="btn btn-primary active" aria-current="page">Settings</a>
        <a href="{{ route('user.whitelabel.users')}}" class="btn btn-primary">Users</a>
      </div>
    </div>


    <div class="whitelabel-row">
      <div class="whitelable-col">
        <div class="whitelabel-box">
          <h4 class="section-heading">Whitelabel Details</h4>

          <form method="POST" @submit.prevent>
            <div class="row mb-3">
              <label for="appName" class="col-sm-5 col-form-label col-form-label-sm">App name</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="appName" v-model="whitelabelConfig.app_name">
              </div>
            </div>
            <div class="row mb-3">
              <label for="customDomain" class="col-sm-5 col-form-label col-form-label-sm">Custom Domain</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="customDomain" v-model="whitelabelConfig.domain">
              </div>
            </div>
            <div class="row mb-3">
              <label for="primaryColor" class="col-sm-5 col-form-label col-form-label-sm">App Primary Color</label>
              <div class="col-sm-7">
                <input type="color" value="#1a0f37" class="form-control form-control-sm" id="primaryColor" v-model="whitelabelConfig.color">
              </div>
            </div>
            <div class="row mb-3">
              <label for="secondaryColor" class="col-sm-5 col-form-label col-form-label-sm">App Secondary Color</label>
              <div class="col-sm-7">
                <input type="color" value="#4f2ed0" class="form-control form-control-sm" id="secondaryColor" v-model="whitelabelConfig.secondary_color">
              </div>
            </div>
            <div class="row mb-3">
              <label for="supportAddress" class="col-sm-5 col-form-label col-form-label-sm">Support Address</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="supportAddress" v-model="whitelabelConfig.email">
              </div>
            </div>
            <div class="row mb-3">
              <label for="supportURL" class="col-sm-5 col-form-label col-form-label-sm">Support URL</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="supportURL" v-model="whitelabelConfig.support_url">
              </div>
            </div>
            <div class="row mb-3">
              <label for="appLogo" class="col-sm-5 col-form-label col-form-label-sm">App Logo</label>
              <div class="col-sm-7">
                <div class="upload-file-wrap" style="cursor: pointer; text-align:center;"@click="openFileInput">
                    <div v-if="whitelabelConfig.media_path == ''">
                        <svg width="30" height="39" viewBox="0 0 30 39" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M29.5994 9.57102L20.429 0.400568C20.1733 0.144886 19.8281 0 19.4659 0H1.36364C0.609375 0 0 0.609375 0 1.36364V36.8182C0 37.5724 0.609375 38.1818 1.36364 38.1818H28.6364C29.3906 38.1818 30 37.5724 30 36.8182V10.5384C30 10.1761 29.8551 9.8267 29.5994 9.57102ZM26.8551 11.1648H18.8352V3.14489L26.8551 11.1648ZM26.9318 35.1136H3.06818V3.06818H15.9375V12.2727C15.9375 12.7474 16.1261 13.2026 16.4617 13.5383C16.7974 13.8739 17.2526 14.0625 17.7273 14.0625H26.9318V35.1136ZM16.3636 17.3864C16.3636 17.1989 16.2102 17.0455 16.0227 17.0455H13.9773C13.7898 17.0455 13.6364 17.1989 13.6364 17.3864V21.9886H9.03409C8.84659 21.9886 8.69318 22.142 8.69318 22.3295V24.375C8.69318 24.5625 8.84659 24.7159 9.03409 24.7159H13.6364V29.3182C13.6364 29.5057 13.7898 29.6591 13.9773 29.6591H16.0227C16.2102 29.6591 16.3636 29.5057 16.3636 29.3182V24.7159H20.9659C21.1534 24.7159 21.3068 24.5625 21.3068 24.375V22.3295C21.3068 22.142 21.1534 21.9886 20.9659 21.9886H16.3636V17.3864Z" fill="white"></path></svg>                  
                        <div class="upload-file-description">
                            <a href="#" @click.prevent>Browse</a> your file
                        </div>
                    </div>
                    <div class="col-12" v-if="whitelabelConfig.media_path">
                        <div class="form-group">
                            <img :src="whitelabelConfig.media_path" class="img-thumbnail" width="150" height="150" alt="logo">
                        </div>
                    </div>
                    
                    <input type="file" id="logo-input" style="display: none"
                        class="form-control-file" @change="readImage">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label for="appDescription" class="col-sm-5 col-form-label col-form-label-sm">App Description</label>
              <div class="col-sm-7">
                <textarea class="form-control" id="appDescription" v-model="whitelabelConfig.description"></textarea>
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
          <h4 class="section-heading">SMTP Details</h4>

          <form method="POST" @submit.prevent>
            <div class="row mb-3">
              <label for="smtpHost" class="col-sm-5 col-form-label col-form-label-sm">SMTP Host</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="smtpHost" v-model="whitelabelConfig.mail_host">
              </div>
            </div>
            <div class="row mb-3">
              <label for="mailPort" class="col-sm-5 col-form-label col-form-label-sm">Mail Port</label>
              <div class="col-sm-7">
                <input type="number" class="form-control form-control-sm" id="mailPort" v-model="whitelabelConfig.mail_port">
              </div>
            </div>
            <div class="row mb-3">
              <label for="smtpUsername" class="col-sm-5 col-form-label col-form-label-sm">SMTP Username</label>
              <div class="col-sm-7">
                <input type="email" class="form-control form-control-sm" id="smtpUsername" v-model="whitelabelConfig.mail_username">
              </div>
            </div>
            <div class="row mb-3">
              <label for="smtpPassword" class="col-sm-5 col-form-label col-form-label-sm">SMTP Password</label>
              <div class="col-sm-7">
                <input type="password" class="form-control form-control-sm" id="smtpPassword" v-model="whitelabelConfig.mail_password">
              </div>
            </div>
            <div class="row mb-3">
              <label for="smtpFromName" class="col-sm-5 col-form-label col-form-label-sm">SMTP From Name</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="smtpFromName" v-model="whitelabelConfig.mail_from_name">
              </div>
            </div>
            <div class="row mb-3">
              <label for="smtpFromAddress" class="col-sm-5 col-form-label col-form-label-sm">SMTP From Address</label>
              <div class="col-sm-7">
                <input type="email" class="form-control form-control-sm" id="smtpFromAddress" v-model="whitelabelConfig.mail_from_address">
              </div>
            </div>
            <div class="row mb-3">
              <label for="ssl" class="col-sm-5 col-form-label col-form-label-sm">Encryption</label>
              <div class="col-sm-7">
                <select id="ssl" class="form-select form-select-sm" v-model="whitelabelConfig.encryption">
                  <option value="none">None</option>
                  <option value="ssl">SSL</option>
                  <option value="tls">TLS</option>
                </select>
              </div>
            </div>

            <div class="button-wrap">
              <button class="btn btn-primary btn-sm" type="button" @click="updateSMTPDetails" :disabled="isLoading">
                Save
              </button>
            </div>
          </form>
        </div>

        <div class="mt-4">
          <h4 class="section-heading">Welcome Email</h4>
          <form post="POST" @submit.prevent>
            <textarea id="emailEditor" class="form-control" v-model="whitelabelConfig.welcome_mail"></textarea>
            
            <div class="button-wrap">
              <button class="btn btn-primary btn-sm" :disabled="isLoading" @click="updateWelcomeEmail">
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
<textarea style="display:none" id="update-details" cols="30" rows="10">{{ route('user.whitelabel.update-details') }}</textarea>
<textarea style="display:none" id="update-smtp-details" cols="30" rows="10">{{ route('user.whitelabel.update-smtp-details') }}</textarea>
<textarea style="display:none" id="update-welcome-email" cols="30" rows="10">{{ route('user.whitelabel.update-welcome-email') }}</textarea>
<textarea style="display:none" id="update-logo" cols="30" rows="10">{{ route('user.whitelabel.update-logo') }}</textarea>
<textarea style="display:none" id="white-label-config" cols="30" rows="10">{{ ($config) ? json_encode($config) : "null" }}</textarea>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.0.0/tinymce.min.js"></script>

<script src="{{ asset('js/app/whitelabel-index.js') }}"></script>

@endsection