@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	
<div class="main-col-content" id="agency-index">
    <h1 class="page-title">Enterprise</h1>

    <div class="page-tab-nav">
      <div class="btn-group">
        <a href="{{ route('user.agency') }}" class="btn btn-primary active" aria-current="page">Assets</a>
        <a href="{{ route('user.agency.teams') }}" class="btn btn-primary">Teams</a>
      </div>
    </div>


    <div class="agency-assets">
      <a v-for="(asset, index) in assets" @click="setActiveAsset(index)" :key="asset.title" href="#" class="asset-item" data-bs-toggle="modal" data-bs-target="#agencyAssetDetailModal" @click.prevent>
        <div class="asset-image-wrap" style="background-size: contain;" v-bind:style="{'backgroundImage': 'url(' + asset.agency_url + ')'}"></div>
        <div class="asset-header">
          <h4 class="asset-title">@{{ asset.title }}</h4>
          <span class="asset-rating icon"><svg width="125" height="23" viewBox="0 0 125 23" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M12.5 0L15.3064 8.63729H24.3882L17.0409 13.9754L19.8473 22.6127L12.5 17.2746L5.15271 22.6127L7.95913 13.9754L0.611816 8.63729H9.6936L12.5 0Z" fill="#FFB800"></path><path d="M37.5 0L40.3064 8.63729H49.3882L42.0409 13.9754L44.8473 22.6127L37.5 17.2746L30.1527 22.6127L32.9591 13.9754L25.6118 8.63729H34.6936L37.5 0Z" fill="#FFB800"></path><path d="M62.5 0L65.3064 8.63729H74.3882L67.0409 13.9754L69.8473 22.6127L62.5 17.2746L55.1527 22.6127L57.9591 13.9754L50.6118 8.63729H59.6936L62.5 0Z" fill="#FFB800"></path><path d="M87.5 0L90.3064 8.63729H99.3882L92.0409 13.9754L94.8473 22.6127L87.5 17.2746L80.1527 22.6127L82.9591 13.9754L75.6118 8.63729H84.6936L87.5 0Z" fill="#FFB800"></path><path d="M112.5 0L115.306 8.63729H124.388L117.041 13.9754L119.847 22.6127L112.5 17.2746L105.153 22.6127L107.959 13.9754L100.612 8.63729H109.694L112.5 0Z" fill="#FFB800"></path></svg></span>
        </div>
        <div class="asset-description">
          @{{asset.description}}
        </div>
      </a>
    </div>

    <div class="modal fade" id="agencyAssetDetailModal" tabindex="-1" aria-labelledby="agencyAssetDetailModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <button class="btn close-btn" data-bs-dismiss="modal">
            X
          </button>
    
          <div class="modal-body">
            <div class="asset-detail-header">
              <h4 class="asset-detail-heading">Enterprise Asset Details</h4>
            </div>
    
            <div class="asset-detail-row">
              <div class="asset-detail-col">
                <div class="asset-image-wrap" style="background-size: contain;" v-bind:style="{'backgroundImage': 'url(' + activeAsset.popup_url + ')'}"></div>
              </div>
              <div class="asset-detail-col">
                <div class="asset-file-details">
                  <div class="file-details-label">
                    File Details
                  </div>
                  <div class="file-details-value">
                    @{{activeAsset.title}}
                  </div>
                </div>
                <div class="asset-file-details-buttons">
                  <a :href="activeAsset.preview_url" class="btn btn-primary px-4">
                    Preview Online
                  </a>
                  <a :href="activeAsset.download_url" class="btn btn-success text-white px-4">
                    Download
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>


<script src="{{ asset('js/app/agency-index.js') }}"></script>
@endsection