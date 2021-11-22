@extends('layouts.master')

@section('side-bar')
	@include('includes.side-bar')
@endsection

@section('content')	
<link rel="stylesheet" href="{{ asset('js/select2/css/select2.min.css') }}" type="text/css">
<style>
  .select2-container--open{
    background: rgb(29, 31, 66);
    z-index: 999999;
  }
  .select2-dropdown--below{
    background: #1d1f42;
    border: 1px solid #1d1f42;
  }
</style>
					
  <div class="main-col-content" id="app-id">
	  @csrf
    <h1 class="create-card-label">Select One of these options</h1>

    <div class="recent-audio-books">
        <ul class="nav nav-tabs nav-pills nav-fill mb-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="library-tab" data-bs-toggle="tab" data-bs-target="#library" type="button" role="tab" aria-controls="library" aria-selected="true">Tags</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Templates</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="library" role="tabpanel" aria-labelledby="library-tab">
                @include('includes.add-tag')
            </div>
            <div class="tab-pane" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                @include('includes.add-template')
            </div>
        </div>
	</div>
  </div>
  <textarea id="upload-text-url" style="display: none">{{ route('user.upload-text')}}</textarea>

  <textarea style="display:none" id="objective" cols="30" rows="10">{{ json_encode($objective) }}</textarea>
  <textarea style="display:none" id="tags" cols="30" rows="10">{{ json_encode($tags) }}</textarea>
  <textarea style="display:none" id="templates" cols="30" rows="10">{{ json_encode($templates) }}</textarea>

  {{-- <textarea style="display:none" id="objectives" cols="30" rows="10">{{ json_encode($objectives) }}</textarea> --}}
<textarea style="display:none" id="create-tag-url" cols="30" rows="10">{{ route('admin.writer.tags.create') }}</textarea>
<textarea style="display:none" id="update-tag-url" cols="30" rows="10">{{ route('admin.writer.tags.update') }}</textarea>
<textarea style="display:none" id="delete-tag-url" cols="30" rows="10">{{ route('admin.writer.tags.delete') }}</textarea>
			
<textarea style="display:none" id="create-template-url" cols="30" rows="10">{{ route('admin.writer.templates.create') }}</textarea>
<textarea style="display:none" id="update-template-url" cols="30" rows="10">{{ route('admin.writer.templates.update') }}</textarea>
<textarea style="display:none" id="delete-template-url" cols="30" rows="10">{{ route('admin.writer.templates.delete') }}</textarea>

@endsection

@section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.25.3/docxtemplater.js"></script>
<script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.9.359/build/pdf.min.js"></script>
{{-- <script src="https://unpkg.com/element-ui/lib/index.js"></script> --}}
<script src="{{ asset('js/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="https://unpkg.com/vue-multiselect@2.1.0"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="{{ asset('js/app/templates.js') }}"></script>
	
@endsection