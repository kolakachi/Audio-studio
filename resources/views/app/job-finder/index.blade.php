@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	
<style>
    [v-cloak]{
        display: none;
    }
</style>
<div class="main-col-content" id="job-finder">
    <div class="container">
        @csrf
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="page-title mt-4">Job Finder</h1>
                <p style="color:#797FAE"><i>Seemlessly search for jobs, use Audiostudio to deliver them & get paid top Dollars.</i></p>
                <div class="form-group col-7 align-items-center" style=" margin: 0 auto;">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" v-model="searchQuery" 
                        style="border-bottom-left-radius: 1rem; border-top-left-radius: 1rem;"
                        placeholder="Search for jobs" aria-label="Search for jobs" aria-describedby="button-addon2">
                        <button @click="searchUser" style="background: #4F2ED0; border-color:#4F2ED0; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem;" class="btn btn-outline-secondary" type="button" id="button-addon2">
                            <svg width="38" height="35" viewBox="0 0 38 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.8883 22.6258C30.1879 19.7351 31.2179 16.1512 30.7722 12.591C30.3265 9.03084 28.4379 5.75697 25.4844 3.4244C22.5308 1.09182 18.7301 -0.127433 14.8426 0.0105538C10.955 0.148541 7.26742 1.6336 4.51747 4.16861C1.76753 6.70363 0.158046 10.1017 0.0110351 13.6829C-0.135976 17.2641 1.19032 20.7644 3.72459 23.4835C6.25885 26.2026 9.81418 27.9399 13.6793 28.348C17.5444 28.756 21.4342 27.8047 24.5706 25.6842H24.5682C24.6395 25.7717 24.7155 25.8549 24.801 25.9358L33.9444 34.3586C34.3897 34.7691 34.9938 34.9998 35.6238 35C36.2538 35.0002 36.858 34.7699 37.3037 34.3596C37.7493 33.9494 37.9998 33.3929 38 32.8126C38.0002 32.2323 37.7502 31.6756 37.3049 31.2651L28.1614 22.8424C28.0765 22.7632 27.9852 22.6922 27.8883 22.6258ZM28.5011 14.2162C28.5011 15.7963 28.1632 17.361 27.5068 18.8208C26.8503 20.2806 25.8882 21.6071 24.6753 22.7244C23.4624 23.8417 22.0224 24.728 20.4377 25.3327C18.8529 25.9374 17.1544 26.2487 15.4391 26.2487C13.7237 26.2487 12.0252 25.9374 10.4404 25.3327C8.85568 24.728 7.41574 23.8417 6.20282 22.7244C4.9899 21.6071 4.02776 20.2806 3.37133 18.8208C2.7149 17.361 2.37704 15.7963 2.37704 14.2162C2.37704 11.025 3.75322 7.96444 6.20282 5.70791C8.65242 3.45138 11.9748 2.18367 15.4391 2.18367C18.9033 2.18367 22.2257 3.45138 24.6753 5.70791C27.1249 7.96444 28.5011 11.025 28.5011 14.2162Z" fill="#FFB800"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 p-4" v-cloak>
                <div class="row">
                    <div class="col-4 mb-4" v-for="job in jobs" v-if="!requestIsLoading">
                        <div class="card" style="background:#1C1C43; border-color:#1C1C43; height:100%;">
                            <div class="card-body">
                                <h5 class="card-title">@{{job.title}}</h5>
                                <p class="card-text">@{{job.preview_description}}</p>
                                
                            </div>
                            <div class="card-footer">
                                <span class="card-link">Price Range: @{{job.currency.sign}}@{{job.budget.minimum}} - @{{job.currency.sign}}@{{job.budget.maximum}}</span>
                                <a :href="url.link + job.seo_url" target="_blank" class="card-link btn btn-primary" style="background:#FFB800; color:#000; border-color:#FFB800;">View Job</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mb-4" v-if="requestIsLoading">
                        <span class="spinner-border text-light" role="status" style="width: 50px; height:50px">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <textarea id="job-finder-url" style="display: none;">{{ route('user.job-finder.search')}}</textarea>
</div>
  
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>


<script src="{{ asset('js/app/job-finder-index.js') }}"></script>
@endsection