@extends('layouts.master')
@section('style')
    <link href="/plugins/audio-player/green-audio-player.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/editor.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
@endsection

@section('side-bar')
	@include('includes.editor-side-bar')
@endsection

@section('content')	
@csrf
<div id="editor">
    <editor-component></editor-component>
 </div>
    <textarea name="" id="speech_text" cols="30" rows="10" style="display: none">{{ Session::get('user_text') }}</textarea>
    <textarea id="upload-text-url" style="display: none">{{ route('user.upload-text')}}</textarea>
    <textarea style="display:none" id="languages">{!! json_encode($languages) !!}</textarea>
    <textarea style="display:none" id="user-access">{!! json_encode($userAccess) !!}</textarea>

    <textarea style="display:none" id="voices">{!! json_encode($voices) !!}</textarea>
    <textarea style="display:none" id="synthesize-url" cols="30" rows="10">{{ route('user.tts.listen') }}</textarea>
    <textarea style="display:none" id="store-record-url" cols="30" rows="10">{{ route('user.tts.store-record') }}</textarea>
    <textarea style="display:none" id="store-upload-url" cols="30" rows="10">{{ route('user.tts.store-upload') }}</textarea>
    <textarea style="display:none" id="export-audio-url" cols="30" rows="10">{{ route('user.tts.export-audio') }}</textarea>
    <textarea style="display:none" id="save-config-url" cols="30" rows="10">{{ route('user.tts.save-config') }}</textarea>
    <textarea style="display:none" id="audio-full-url" cols="30" rows="10">{{ route('user.fetch-audio') }}</textarea>
    <textarea style="display:none" id="audio-details">{!! json_encode($audio) !!}</textarea>

    <textarea style="display:none" id="get-audio-sounds-url" cols="30" rows="10">{{ route('user.get-sounds') }}</textarea>
    <textarea style="display:none" id="get-audio-music-url" cols="30" rows="10">{{ route('user.get-music') }}</textarea>
    <textarea style="display:none" id="store-audio-music-url" cols="30" rows="10">{{ route('user.store-music') }}</textarea>
    <textarea style="display:none" id="master-piece-url" cols="30" rows="10">{{ route('user.master-piece') }}</textarea>

			

@endsection

@section('js')
<script src="https://unpkg.com/wavesurfer.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.25.3/docxtemplater.js"></script>
<script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.js"></script>
<script src="https://unpkg.com/pizzip@3.0.6/dist/pizzip-utils.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.9.359/build/pdf.min.js"></script>

<script src="{{ asset('js/app/vendors/vue.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="/js/libs/signals.min.js"></script>
<script src="/js/app/utils.js"></script>
<script src="/plugins/audio-player/green-audio-player.js"></script>
<script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script> --}}
{{-- <script src="/js/app/editor.js?v=8.0"></script> --}}
<script src="{{ mix('/js/app.js') .'?v='.mt_rand(1, 100)  }}"></script>
<script>
    document.addEventListener( 'dragover', function ( event ) {

        event.preventDefault();
        event.dataTransfer.dropEffect = 'copy';

    }, false );
</script>
    {{-- <script type="module" src="{{ asset('js/Interactor/ThreadViewModel.js')}}"> </script> --}}

@endsection