@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	
<div class="main-col-content">
    <h1 class="page-title">Agency</h1>

    <div class="page-tab-nav">
      <div class="btn-group">
        <a href="{{ route('user.agency') }}" class="btn btn-primary active" aria-current="page">Assets</a>
        <a href="{{ route('user.agency.teams') }}" class="btn btn-primary">Teams</a>
      </div>
    </div>


    <div class="agency-assets">
      <a v-for="asset in assets" :key="asset.title" href="#" class="asset-item" data-bs-toggle="modal" data-bs-target="#agencyAssetDetailModal" @click.prevent>
        <div class="asset-image-wrap"></div>
        <div class="asset-header">
          <h4 class="asset-title">@{{ asset.title }}</h4>
          <svg-icon name="five-star" class="asset-rating"></svg-icon>
        </div>
        <div class="asset-description">
          We have created an editable high converting Agency website for you by our team of experts designers and writers, so you’ll no longer have to pay or hire a web designer any more. All you need to do is to add your logo and contact information to suit your marketing goals. This Agency website is rated 5 start by our early users.
        </div>
      </a>
    </div>
  </div>
  <div class="modal fade" id="agencyAssetDetailModal" tabindex="-1" aria-labelledby="agencyAssetDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <button class="btn close-btn" data-bs-dismiss="modal">
          X
        </button>
  
        <div class="modal-body">
          <div class="asset-detail-header">
            <h4 class="asset-detail-heading">Agency Asset Details</h4>
          </div>
  
          <div class="asset-detail-row">
            <div class="asset-detail-col">
              <div class="asset-image-wrap"></div>
            </div>
            <div class="asset-detail-col">
              <div class="asset-file-details">
                <div class="file-details-label">
                  File Details
                </div>
                <div class="file-details-value">
                  DFY Agency Website
                </div>
              </div>
              <div class="asset-file-details-buttons">
                <button class="btn btn-primary px-4">
                  Preview Online
                </button>
                <button class="btn btn-success text-white px-4">
                  Download
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection