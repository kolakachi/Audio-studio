@extends('layouts.master')
@section('style')
<link href="/plugins/audio-player/green-audio-player.css" rel="stylesheet">

    <style>
        *, :after, :before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        *, :after, :before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        .dropdown-toggle:after {
            display: inline-block;
            margin-left: .255em;
            vertical-align: .255em;
            content: "";
            display: none;
            border-top: .3em solid;
            border-right: .3em solid transparent;
            border-bottom: 0;
            border-left: .3em solid transparent;
        }
        .record-audio-buttons .record-btn {
            margin-left: 20px;
            font-size: 1.1rem;
            padding: 0;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            background: red;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
        #listenModal .modal-content {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #1d1f42 !important;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 0.3rem;
            outline: 0;
        }
        #listenModal .modal-header {
            padding: 1rem 2rem;
            border-bottom: none;
        }
        #listenModal .modal-title {
            font-family: "Poppins", sans-serif;
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
        }
        #listenModal .modal-body {
            padding-bottom: 10px;
        }
        #listen-result-player .green-audio-player {
            padding-left: 10px !important;
            padding-right: 10px !important;
            height: 56px !important;
            box-shadow: none !important;
        }
        .green-audio-player .play-pause-btn svg {
            width: 12px;
            margin-left: 0.5rem;
            margin-right: 0.2rem;
        }
        .green-audio-player .controls {
            color: #1e1e2d;
            font-size: 10px;
            margin-left: 20px;
        }
        .green-audio-player {
            width: 100%;
            background: #1d1f42 !important;
        }
        #listenModal .modal-footer {
            justify-content: center;
        }

        #listenModal .modal-footer {
            padding: 0 10px 0 0;
            border-top: none;
        }
         .player-wrap .recording-btn {
            padding: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
            line-height: 0;
            width: 20.8px;
            height: 20.8px;
        }
        .player-wrap .recording-btn .record-icon {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: block;
            background-color: red;
            position: relative;
        }
        .player-wrap .recording-btn .record-icon:before {
            content: "";
            position: absolute;
            right: 50%;
            top: 50%;
            -webkit-transform: translate(50%,-50%);
            -ms-transform: translate(50%,-50%);
            transform: translate(50%,-50%);
            width: 7px;
            height: 7px;
            background-color: #1d1f42;
            border-radius: 4px;
        }
        input[type=range][orient=vertical] {
            writing-mode: bt-lr; /* IE */
            -webkit-appearance: slider-vertical; /* WebKit */
            width: 8px;
            height: 175px;
            padding: 0 5px;
        }
        #drp-menu{
            margin-left: 15px !important;
            transform: translate3d(74px, -145px, 0px) !important;
        }
        .dropdown .dropdown-menu{
            color: #FFF;
            background: #1d1f42;
        }
        .dropdown .dropdown-item{
            color: #FFF !important;
        }
        .dropdown .dropdown-item:hover{
            color: #000 !important;
        }
        wave{
            position: unset !important;
        }
        .audio-editor-page .controls-wrap .editor-col .editor-wrap .audio-textarea-wrap .audio-textarea-buttons {
            left: 0px !important;
            right: 0px !important;
            padding-left: 10px !important;
        }
    </style>
        <link rel="stylesheet" href="/css/custom.css">


@endsection

@section('side-bar')
	@include('includes.editor-side-bar')
@endsection

@section('content')	
			

<div class="main-col-content audio-editor-page" id="audio-editor">
    <div class="controls-wrap">
        <div class="params-col">
            <h6>Audio settings</h6>

            <div class="col-box">
                <div class="row mb-4">
                    <label for="language" class="col-sm-3 col-form-label">Audio Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                        v-validate="'required'" name="edit_name" data-vv-as="Name"
                        v-model="edit_name" class="form-control" id="">
                        <template v-if="errors.has('edit_name')">
                            <span class="small text-danger">
                                @{{ errors.first('edit_name') }}
                            </span>
                        </template>
                    </div>
                </div>
            <div class="row mb-4">
                <label for="language" class="col-sm-3 col-form-label">Select Language</label>
                <div class="col-sm-9">
                <div class="form-select-wrap">
                    <img v-if="selectedLanguageId != 0" :src="selectedLanguage.language_flag" alt="US" class="form-select-icon">
                    <select id="language" class="form-select" 
                    v-validate="'required'" name="selectedLanguageId" data-vv-as="Language"
                    v-model="selectedLanguageId" @change="setSelectedLanguage">
                        <option value="0" disabled selected>Select Language</option>
                        <option v-for="(language, index) in languages" :value="language.id">@{{language.language}}</option>
                        {{-- <option value="1">English [US]</option> --}}
                    </select>
                    <template v-if="languageIdError != '' ">
                        <span class="small text-danger">
                            @{{ languageIdError }}
                        </span>
                    </template>
                </div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="voice" class="col-sm-3 col-form-label">Choose Voice</label>
                <div class="col-sm-9">
                <div class="form-select-wrap">
                    <img v-if="selectedLanguageId != 0" :src="selectedLanguage.language_flag" alt="US" class="form-select-icon">
                    {{-- <img src="/assets/img/flags/us.png" alt="US" class="form-select-icon"> --}}
                    <select id="voice" class="form-select" 
                    v-validate="'required'" name="selectedVoiceId" data-vv-as="Voice"
                    v-model="selectedVoiceId" @change="setVoice()">
                        <option value="0" disabled selected>Select Voice</option>
                        <option v-for="(voice, index) in getVoices" :value="voice.voice_id">@{{voice.voice}} [@{{ voice.gender }}]</option>
                    </select>
                    <template v-if="voiceIdError != '' ">
                        <span class="small text-danger">
                            @{{ voiceIdError }}
                        </span>
                    </template>
                </div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="preview" class="col-sm-3 col-form-label">Preview</label>
                <audio controls="controls" src="" id="preview-audio" style="display: none"></audio>

                <div class="col-sm-9">
                    <div class="preview-voice">
                        <div class="btn preview-btn" @click="playPreview">
                            <span class="icon"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path><path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path></svg></span>
                        </div>

                        <div id="preview" class="progress">
                            <input type="range" min="0" :max="previewRangeMaximum" v-model="currentPreviewRange" style="width: 100%" id="preview-time-range">

                            {{-- <div class="progress-bar" role="progressbar" style="width: 5%" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="output-formats" class="col-sm-3 col-form-label">Select Output</label>
                <div class="col-sm-9">
                <div id="output-formats">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="mp3" :checked="selectedFormat == 'mp3'" @click="setFormat('mp3')">
                    <label class="form-check-label" for="mp3">
                        MP3
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="ogg" :checked="selectedFormat == 'ogg'" @click="setFormat('ogg')">
                    <label class="form-check-label" for="ogg">
                        OGG
                    </label>
                    </div>

                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="webm" :checked="selectedFormat == 'webm'" @click="setFormat('webm')">
                    <label class="form-check-label" for="webm">
                        WEBM
                    </label>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="editor-col">
            <h6>Audio Text</h6>
            <div class="col-box">
            <div class="editor-wrap">
                <div class="editor-buttons" style="width: 68%;">
                    {{-- <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="m-voiceEffects" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Voice Effects') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="#m-voiceEffects">
                            <button class="dropdown-item" type="button" id="soft_effect">Speak Softly</button>
                            <button class="dropdown-item" type="button" id="breathing_effect">Sound of Breathing</button>
                            <button class="dropdown-item" type="button" id="whispered_effect">Whispered</button>
                            <button class="dropdown-item" type="button" id="drc_effect">DRC Effect</button>
                            <button style="display: none" class="dropdown-item" type="button" id="conversational_effect">Conversational</button>
                            <button style="display: none" class="dropdown-item" type="button" id="newscaster_effect">Newscaster</button>
                        </div>
                    </div> --}}
                    <div class="dropdown">
                        <button style="color: #7456FE" class="btn dropdown-toggle" type="button" id="sayAs" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('Say as') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="sayAs">
                            <button class="dropdown-item" type="button" id="characters_sayas" @click="sayAs('characters')">Characters</button>
                            {{-- <button style="display: none" class="dropdown-item" type="button" id="verbatim_sayas" @click="sayAs('characters')">Verbatim</button> --}}
                            {{-- <button style="display: none" class="dropdown-item" type="button" id="bleep_sayas">Bleep</button> --}}
                            <button class="dropdown-item" type="button" id="cardinal_sayas" @click="sayAs('cardinal')">Cardinal</button>
                            <button class="dropdown-item" type="button" id="ordinal_sayas" @click="sayAs('ordinal')">Ordinal</button>
                            <button class="dropdown-item" type="button" id="digits_sayas" @click="sayAs('digits')">Digits</button>
                            <button class="dropdown-item" type="button" id="fraction_sayas" @click="sayAs('fraction')">Fraction</button>
                            {{-- <button class="dropdown-item" type="button" id="unit_sayas">Unit</button> --}}
                            <button class="dropdown-item" type="button" id="time_sayas" @click="sayAs('time')">Time</button>
                            {{-- <button style="display: none" class="dropdown-item" type="button" id="gcp_time_sayas">Time</button> --}}
                            <button class="dropdown-item" type="button" id="address_sayas" @click="sayAs('address')">Address</button>
                            {{-- <button class="dropdown-item" type="button" id="expletive_sayas">Beep Out</button> --}}
                            {{-- <button style="display: none" class="dropdown-item" type="button" id="telephone_sayas">Telephone</button> --}}
                        </div>
                    </div>
                    {{--<div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="emphasis" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Emphasis') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="emphasis">
                            <button class="dropdown-item" type="button" id="reduced_emphasis">Reduced</button>
                            <button class="dropdown-item" type="button" id="moderate_emphasis">Moderate</button>
                            <button class="dropdown-item" type="button" id="strong_emphasis">Strong</button>
                        </div>
                    </div> --}}
                    <div class="dropdown">
                        <button style="color: #FFB800" class="btn dropdown-toggle" type="button" id="volume" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Volume') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="volume">
                            <button class="dropdown-item" type="button" id="silent_volume" @click="setVolume('silent')">Silent</button>
                            <button class="dropdown-item" type="button" id="x_soft_volume" @click="setVolume('x-soft')">x-Soft</button>
                            <button class="dropdown-item" type="button" id="soft_volume" @click="setVolume('soft')">Soft</button>
                            <button class="dropdown-item" type="button" id="medium_volume" @click="setVolume('medium')">Medium</button>
                            <button class="dropdown-item" type="button" id="loud_volume" @click="setVolume('loud')">Loud</button>
                            <button class="dropdown-item" type="button" id="x_loud_volume" @click="setVolume('x-loud')">x-Loud</button>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="color: #FF005C" class="btn dropdown-toggle" type="button" id="speed" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Speed') }}
                        </button>
                            <div class="dropdown-menu" aria-labelledby="speed">
                            <button class="dropdown-item" type="button" id="x_slow_speed" @click="setSpeed('x-slow')">x-Slow</button>
                            <button class="dropdown-item" type="button" id="slow_speed" @click="setSpeed('slow')">Slow</button>
                            <button class="dropdown-item" type="button" id="medium_speed" @click="setSpeed('medium')">Medium</button>
                            <button class="dropdown-item" type="button" id="fast_speed" @click="setSpeed('fast')">Fast</button>
                            <button class="dropdown-item" type="button" id="x_fast_speed" @click="setSpeed('x-fast')">x-Fast</button>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="color: #23A617" class="btn dropdown-toggle" type="button" id="pitch" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Pitch') }}
                        </button>
                            <div class="dropdown-menu" aria-labelledby="pitch">
                            <button class="dropdown-item" type="button" id="x_low_pitch" @click="setSpeed('x-low')">x-Low</button>
                            <button class="dropdown-item" type="button" id="low_pitch" @click="setSpeed('low')">Low</button>
                            <button class="dropdown-item" type="button" id="medium_pitch" @click="setSpeed('medium')">Medium</button>
                            <button class="dropdown-item" type="button" id="high_pitch" @click="setSpeed('high')">High</button>
                            <button class="dropdown-item" type="button" id="x_high_pitch" @click="setSpeed('x-high')">x-High</button>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="color: #00E0FF" class="btn dropdown-toggle" type="button" id="pause" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Pauses') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="pause">
                            <button class="dropdown-item" type="button" id="zero_pause" @click="setPause('0s')">0 second</button>
                            <button class="dropdown-item" type="button" id="one_pause" @click="setPause('1s')">1 second</button>
                            <button class="dropdown-item" type="button" id="two_pause" @click="setPause('2s')">2 seconds</button>
                            <button class="dropdown-item" type="button" id="three_pause" @click="setPause('3s')">3 seconds</button>
                            <button class="dropdown-item" type="button" id="four_pause" @click="setPause('4s')">4 seconds</button>
                            <button class="dropdown-item" type="button" id="five_pause" @click="setPause('5s')">5 seconds</button>
                            {{-- <button class="dropdown-item" type="button" id="six_pause">6 seconds</button> --}}
                            {{-- <button class="dropdown-item" type="button" id="seven_pause">7 seconds</button> --}}
                            {{-- <button class="dropdown-item" type="button" id="eight_pause">8 seconds</button> --}}
                            {{-- <button class="dropdown-item" type="button" id="nine_pause">9 seconds</button> --}}
                            {{-- <button class="dropdown-item" type="button" id="ten_pause">10 seconds</button> --}}
                            <button class="dropdown-item" type="button" id="paragraph_pause" @click="setParagraphPause()">Paragraph</button>
                            <button class="dropdown-item" type="button" id="sentence_pause" @click="setSentencePause()">Sentence</button>
                        </div>
                    </div>
                {{-- <button type="button" class="btn">Emphasis</button>
                <button type="button" class="btn">Volume</button>
                <button type="button" class="btn">Speed</button>
                <button type="button" class="btn">Pitch</button>
                <button type="button" class="btn">Pauses</button> --}}
                <button type="button" class="btn">Language</button>
                </div>
                <div class="audio-textarea-wrap">
                <textarea class="audio-textarea form-control" id="audio-textarea">{{ Session::get('user_text') }}</textarea>

                <div class="audio-textarea-buttons">
                    <button type="button" class="btn api-btn">
                        <span class="icon"><svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M59.5332 54.1817C59.5244 54.1979 59.5095 54.2222 59.4999 54.238C58.6919 56.3549 56.6573 57.8907 54.256 57.8907H5.48898C5.30605 57.8907 5.13613 57.7735 4.95754 57.7735H4.88664C4.86824 57.7735 4.85348 57.7645 4.83508 57.7623C3.66027 57.624 2.60277 57.1422 1.76406 56.3941C1.74836 56.3801 1.7275 56.3735 1.71168 56.3595L1.72164 56.352C1.52383 56.1717 1.31863 55.9984 1.14801 55.7913C0.744191 55.3014 0.426402 54.7465 0.208164 54.1503C0.205063 54.1461 0.202394 54.1415 0.200195 54.1367L0.210508 54.1324C0.20043 54.1049 0.234414 54.0368 0.351602 53.9326V22.5712C0.35141 21.8855 0.47721 21.2057 0.722734 20.5654L0.676211 20.5289C0.676211 20.5289 1.17977 19.0347 1.9259 18.3718C2.67203 17.7089 4.08437 17.103 5.28074 16.9759L54.4805 16.9741C55.6804 17.103 56.6632 16.9741 57.8389 18.3718C59.0144 19.7695 59.0998 20.5603 59.0998 20.5603L59.0542 20.596C59.2924 21.2273 59.4144 21.8964 59.4142 22.5711V53.9661L59.3312 53.9029C59.4599 54.0374 59.5295 54.1241 59.5175 54.1565L59.5332 54.1817Z" fill="white"></path><path d="M55.729 26.4372H45.0708V20.3018H55.729V26.4372Z" fill="#F4F3EF"></path><path d="M46.7151 34.2112H13.0601C12.5747 34.2112 12.1812 33.8178 12.1812 33.3323C12.1812 32.8468 12.5747 32.4534 13.0601 32.4534H46.715C47.2005 32.4534 47.5939 32.8468 47.5939 33.3323C47.5939 33.8178 47.2005 34.2112 46.7151 34.2112ZM47.594 40.2367C47.594 39.7512 47.2006 39.3578 46.7151 39.3578H13.0601C12.5747 39.3578 12.1812 39.7512 12.1812 40.2367C12.1812 40.7222 12.5747 41.1156 13.0601 41.1156H46.715C46.8304 41.1157 46.9448 41.0929 47.0514 41.0488C47.158 41.0046 47.2549 40.9399 47.3366 40.8583C47.4182 40.7766 47.4829 40.6797 47.5271 40.5731C47.5713 40.4665 47.594 40.3522 47.594 40.2367ZM47.594 47.1414C47.594 46.6559 47.2006 46.2625 46.7151 46.2625H13.0601C12.5747 46.2625 12.1812 46.6559 12.1812 47.1414C12.1812 47.6269 12.5747 48.0203 13.0601 48.0203H46.715C46.8304 48.0203 46.9448 47.9976 47.0514 47.9535C47.158 47.9093 47.2549 47.8446 47.3366 47.7629C47.4182 47.6813 47.4829 47.5844 47.5271 47.4778C47.5713 47.3711 47.594 47.2568 47.594 47.1414Z" fill="#597B91"></path><path d="M56.3486 21.5224C56.3498 21.6045 56.3346 21.6859 56.304 21.7621C56.2734 21.8382 56.2279 21.9075 56.1703 21.9659C56.1126 22.0243 56.044 22.0707 55.9683 22.1024C55.8926 22.1341 55.8113 22.1504 55.7293 22.1504C55.6472 22.1504 55.5659 22.1341 55.4902 22.1024C55.4145 22.0707 55.3459 22.0243 55.2882 21.9659C55.2306 21.9075 55.1852 21.8382 55.1545 21.7621C55.1239 21.6859 55.1087 21.6045 55.1099 21.5224C55.1121 21.3596 55.1783 21.2042 55.2943 21.0899C55.4102 20.9756 55.5664 20.9115 55.7293 20.9115C55.8921 20.9115 56.0483 20.9756 56.1643 21.0899C56.2802 21.2042 56.3464 21.3596 56.3486 21.5224ZM55.7292 24.6725C55.6471 24.6714 55.5657 24.6866 55.4895 24.7172C55.4134 24.7478 55.3441 24.7933 55.2857 24.8509C55.2273 24.9085 55.1809 24.9772 55.1492 25.0529C55.1175 25.1286 55.1012 25.2099 55.1012 25.2919C55.1012 25.374 55.1175 25.4552 55.1492 25.5309C55.1809 25.6066 55.2273 25.6753 55.2857 25.7329C55.3441 25.7906 55.4134 25.836 55.4895 25.8666C55.5657 25.8973 55.6471 25.9124 55.7292 25.9113C55.892 25.9091 56.0474 25.8428 56.1617 25.7269C56.276 25.611 56.3401 25.4547 56.3401 25.2919C56.3401 25.1291 56.276 24.9728 56.1617 24.8569C56.0474 24.741 55.892 24.6748 55.7292 24.6725ZM55.7292 22.7499C55.5649 22.7499 55.4073 22.8152 55.2912 22.9314C55.175 23.0475 55.1097 23.2051 55.1097 23.3694C55.1097 23.5337 55.175 23.6912 55.2912 23.8074C55.4073 23.9236 55.5649 23.9888 55.7292 23.9888C55.8935 23.9888 56.051 23.9236 56.1672 23.8074C56.2834 23.6912 56.3486 23.5337 56.3486 23.3694C56.3486 23.2051 56.2834 23.0475 56.1672 22.9314C56.051 22.8152 55.8935 22.7499 55.7292 22.7499ZM45.0711 20.9029C44.9888 20.9014 44.907 20.9162 44.8304 20.9466C44.7539 20.977 44.6842 21.0224 44.6254 21.0801C44.5666 21.1377 44.5199 21.2066 44.488 21.2825C44.4561 21.3584 44.4397 21.44 44.4397 21.5223C44.4397 21.6047 44.4561 21.6862 44.488 21.7622C44.5199 21.8381 44.5666 21.9069 44.6255 21.9646C44.6843 22.0223 44.754 22.0676 44.8305 22.098C44.9071 22.1284 44.9889 22.1432 45.0713 22.1416C45.2334 22.1385 45.3879 22.0718 45.5014 21.956C45.615 21.8402 45.6786 21.6844 45.6786 21.5222C45.6786 21.36 45.615 21.2043 45.5014 21.0885C45.3878 20.9727 45.2333 20.9061 45.0711 20.9029ZM45.0711 24.6725C44.9888 24.6709 44.907 24.6858 44.8304 24.7162C44.7539 24.7466 44.6842 24.792 44.6254 24.8496C44.5666 24.9073 44.5199 24.9761 44.488 25.0521C44.4561 25.128 44.4397 25.2096 44.4397 25.2919C44.4397 25.3743 44.4561 25.4558 44.488 25.5317C44.5199 25.6077 44.5666 25.6765 44.6255 25.7342C44.6843 25.7918 44.754 25.8372 44.8305 25.8676C44.9071 25.898 44.9889 25.9128 45.0713 25.9112C45.2334 25.908 45.3879 25.8414 45.5014 25.7256C45.615 25.6097 45.6786 25.454 45.6786 25.2918C45.6786 25.1296 45.615 24.9739 45.5014 24.8581C45.3878 24.7423 45.2333 24.6757 45.0711 24.6725ZM45.0711 22.7499C44.9069 22.7499 44.7493 22.8152 44.6332 22.9314C44.517 23.0475 44.4517 23.2051 44.4517 23.3693C44.4517 23.5336 44.517 23.6912 44.6332 23.8073C44.7493 23.9235 44.9069 23.9887 45.0711 23.9887C45.1532 23.9899 45.2347 23.9747 45.3108 23.9441C45.3869 23.9134 45.4562 23.868 45.5147 23.8104C45.5731 23.7527 45.6195 23.6841 45.6511 23.6084C45.6828 23.5326 45.6991 23.4514 45.6991 23.3693C45.6991 23.2873 45.6828 23.206 45.6511 23.1303C45.6195 23.0546 45.5731 22.9859 45.5147 22.9283C45.4562 22.8707 45.3869 22.8252 45.3108 22.7946C45.2347 22.764 45.1532 22.7488 45.0711 22.7499Z" fill="#545454"></path><path d="M22.8559 28.8233L18.1873 21.616L19.039 19.7294L19.0304 19.7209L19.0486 19.7027C19.0518 19.6939 19.0569 19.6858 19.0635 19.6792C19.0702 19.6726 19.0782 19.6675 19.087 19.6643L20.031 18.7203C20.0341 18.7115 20.0392 18.7034 20.0459 18.6968C20.0525 18.6901 20.0606 18.6851 20.0694 18.6819L20.154 18.5973L20.1937 18.637L21.9826 17.8206L29.1899 22.4892C29.2335 22.5148 29.2716 22.5489 29.3021 22.5893C29.3325 22.6298 29.3546 22.6758 29.3672 22.7249L31.0849 29.4115C31.1251 29.5678 30.9333 29.6772 30.8191 29.5631L26.7038 25.4477C26.5198 25.2637 26.4335 24.9992 26.4881 24.7448C26.6118 24.1691 26.45 23.5443 26.0026 23.0969C25.2714 22.3657 24.0662 22.3971 23.3756 23.1913C22.7981 23.8555 22.7931 24.8594 23.3646 25.5289C23.8113 26.052 24.4789 26.2508 25.0936 26.1253C25.3549 26.072 25.6256 26.1485 25.8142 26.337L29.9296 30.4524C30.0437 30.5666 29.9343 30.7584 29.7779 30.7182L23.0913 29.0005C23.0423 28.9879 22.9963 28.9658 22.9559 28.9354C22.9155 28.905 22.8815 28.8669 22.8559 28.8233Z" fill="#545454"></path><path d="M21.0639 20.7002C19.501 22.2631 17.8217 23.1555 17.1583 22.8094L17.1417 22.8261L16.1314 21.8158L1.16316 6.84743C1.01242 6.69667 0.927734 6.49221 0.927734 6.27901C0.927734 6.06582 1.01242 5.86135 1.16316 5.71059L6.07742 0.79622C6.22818 0.645477 6.43264 0.560791 6.64584 0.560791C6.85903 0.560791 7.0635 0.645477 7.21426 0.79622L19.8948 13.4767L22.1825 15.7645L23.1928 16.7747L23.1731 16.7944C23.5193 17.4579 22.6269 19.1372 21.0639 20.7002Z" fill="#445056"></path><path d="M6.85595 0.511444C7.13438 0.789882 6.01384 2.36195 4.35306 4.02273C2.69227 5.68352 1.12032 6.80406 0.841767 6.52562C0.563329 6.24719 1.68388 4.67512 3.34466 3.01434C5.00544 1.35355 6.57751 0.233007 6.85595 0.511444ZM13.539 7.12047L7.48782 13.1717L8.58012 14.264L14.6313 8.21277L13.539 7.12047Z" fill="#A1AAAD"></path></svg></span>                    
                    </button>
                    <button type="button" class="btn record-btn" data-bs-toggle="modal" data-bs-target="#recordModal">
                        <span class="icon"><svg width="28" height="39" viewBox="0 0 28 39" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M14 23.7576C17.9836 23.7576 21.2121 20.5673 21.2121 16.6303V7.12727C21.2121 3.1903 17.9836 0 14 0C10.0164 0 6.78788 3.1903 6.78788 7.12727V16.6303C6.78788 20.5673 10.0164 23.7576 14 23.7576ZM28 16.5455C28 16.3588 27.8473 16.2061 27.6606 16.2061H25.1152C24.9285 16.2061 24.7758 16.3588 24.7758 16.5455C24.7758 22.4976 19.9521 27.3212 14 27.3212C8.04788 27.3212 3.22424 22.4976 3.22424 16.5455C3.22424 16.3588 3.07152 16.2061 2.88485 16.2061H0.339394C0.152727 16.2061 0 16.3588 0 16.5455C0 23.7024 5.37091 29.6079 12.303 30.4436V34.7879H6.13879C5.55758 34.7879 5.09091 35.3945 5.09091 36.1455V37.6727C5.09091 37.8594 5.2097 38.0121 5.35394 38.0121H22.6461C22.7903 38.0121 22.9091 37.8594 22.9091 37.6727V36.1455C22.9091 35.3945 22.4424 34.7879 21.8612 34.7879H15.5273V30.4648C22.54 29.7012 28 23.7618 28 16.5455Z" fill="white"></path></svg></span>                    
                    </button>
                </div>
                </div>

                <div class="text-center mt-3">
                    <button class="btn btn-primary listen-btn" @click="submitSynthesizeRequest('listen')" :disabled="isLoading">
                        <span class="spinner-border text-light" role="status" v-if="loadingType == 'listen'" style="width: 12px; height:12px">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span class="icon" v-if="loadingType != 'listen'"><svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg></span>                    
                        Listen
                    </button>
                    <button class="btn btn-success add-timeline-btn" @click="submitSynthesizeRequest('add_to_timeline')" :disabled="isLoading">
                        <span class="spinner-border text-light" role="status" v-if="loadingType == 'add_to_timeline'" style="width: 12px; height:12px">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span class="icon" v-if="loadingType != 'add_to_timeline'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>                    
                        Add to Timeline
                    </button>
                </div>
            </div>

            <div class="char-counter">0/1000</div>
            </div>
        </div>
    </div>

    <div class="actions-row mt-5">
        <div class="short-col">
            <button class="btn add-track-btn" data-bs-toggle="modal" data-bs-target="#addMusicTrackModal" style="font-size:.9rem">
            + Music Track
            </button>
            <div class="btn-group timeline-actions" role="group">
                {{-- <button type="button" class="btn">
                    <span class="icon"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M9.21053 4.60526C9.21053 2.06579 7.14474 0 4.60526 0C2.06579 0 0 2.06579 0 4.60526C0 7.14474 2.06579 9.21053 4.60526 9.21053C5.34648 9.20538 6.07515 9.01881 6.72763 8.66711L9.82895 11.9934L6.77895 15.0434C6.11337 14.6749 5.36605 14.479 4.60526 14.4737C2.06579 14.4737 0 16.5395 0 19.0789C0 21.6184 2.06579 23.6842 4.60526 23.6842C7.14474 23.6842 9.21053 21.6184 9.21053 19.0789C9.21053 18.2882 8.99211 17.5553 8.63947 16.9053L11.625 13.9211L18.4211 21.2118C19.1612 21.9522 20.165 22.3682 21.2118 22.3684H25L8.35526 7.26053C8.88947 6.50789 9.21053 5.59605 9.21053 4.60526ZM4.60526 6.57895C3.51711 6.57895 2.63158 5.69342 2.63158 4.60526C2.63158 3.51711 3.51711 2.63158 4.60526 2.63158C5.69342 2.63158 6.57895 3.51711 6.57895 4.60526C6.57895 5.69342 5.69342 6.57895 4.60526 6.57895ZM4.60526 21.0526C3.51711 21.0526 2.63158 20.1671 2.63158 19.0789C2.63158 17.9908 3.51711 17.1053 4.60526 17.1053C5.69342 17.1053 6.57895 17.9908 6.57895 19.0789C6.57895 20.1671 5.69342 21.0526 4.60526 21.0526Z" fill="#797FAE"></path><path d="M18.4211 2.47237L13.5434 8.28026L15.4039 10.1408L25 1.31579H21.2118C20.165 1.31601 19.1612 1.73204 18.4211 2.47237Z" fill="#797FAE"></path></svg></span>            
                </button>
                <button type="button" class="btn">
                    <span class="icon"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M23.75 0H7.5C7.16859 0.000372204 6.85087 0.132188 6.61653 0.366528C6.38219 0.600867 6.25037 0.918594 6.25 1.25V17.5C6.25037 17.8314 6.38219 18.1491 6.61653 18.3835C6.85087 18.6178 7.16859 18.7496 7.5 18.75H23.75C24.0814 18.7496 24.3991 18.6178 24.6335 18.3835C24.8678 18.1491 24.9996 17.8314 25 17.5V1.25C24.9996 0.918594 24.8678 0.600867 24.6335 0.366528C24.3991 0.132188 24.0814 0.000372204 23.75 0ZM23.3333 17.0833H7.91667V1.66667H23.3333V17.0833Z" fill="#797FAE"></path><path d="M17.0833 23.3333H1.66667V7.91667H4.58333V6.25H1.25C0.918594 6.25037 0.600867 6.38219 0.366528 6.61653C0.132188 6.85087 0.000372204 7.16859 0 7.5V23.75C0.000372204 24.0814 0.132188 24.3991 0.366528 24.6335C0.600867 24.8678 0.918594 24.9996 1.25 25H17.5C17.8314 24.9996 18.1491 24.8678 18.3835 24.6335C18.6178 24.3991 18.7496 24.0814 18.75 23.75V20.4167H17.0833V23.3333Z" fill="#797FAE"></path></svg></span>            
                </button>
                <button type="button" class="btn">
                    <span class="icon"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.92129 3.25383L0.201292 1.53383C0.0688118 1.39166 -0.00331137 1.20361 0.000116847 1.00931C0.00354506 0.81501 0.0822571 0.629625 0.21967 0.492212C0.357083 0.354799 0.542468 0.276087 0.736769 0.272659C0.93107 0.269231 1.11912 0.341354 1.26129 0.473834L19.7613 18.9738C19.8938 19.116 19.9659 19.3041 19.9625 19.4984C19.959 19.6927 19.8803 19.878 19.7429 20.0155C19.6055 20.1529 19.4201 20.2316 19.2258 20.235C19.0315 20.2384 18.8435 20.1663 18.7013 20.0338L16.4083 17.7418L16.4053 17.7728C16.3416 18.4223 16.049 19.028 15.5799 19.4815C15.1107 19.9351 14.4955 20.2071 13.8443 20.2488L13.6683 20.2538H6.29429C5.64175 20.2538 5.01048 20.0218 4.5133 19.5991C4.01611 19.1765 3.68541 18.5909 3.58029 17.9468L3.55729 17.7728L2.27629 4.75383H1.48129C1.30005 4.75383 1.12495 4.68819 0.988361 4.56907C0.851773 4.44994 0.76294 4.28539 0.738292 4.10583L0.731292 4.00383C0.731299 3.8226 0.796934 3.64749 0.916059 3.5109C1.03518 3.37431 1.19974 3.28548 1.37929 3.26083L1.48129 3.25383H1.92129ZM15.0363 16.3698L12.4813 13.8138V15.2538C12.4812 15.4439 12.409 15.6268 12.2793 15.7656C12.1496 15.9045 11.972 15.9889 11.7824 16.0019C11.5928 16.0148 11.4054 15.9553 11.258 15.8354C11.1106 15.7155 11.0142 15.5441 10.9883 15.3558L10.9813 15.2538V12.3138L8.98129 10.3138V15.2538C8.98123 15.4439 8.90905 15.6268 8.77932 15.7656C8.64959 15.9045 8.47199 15.9889 8.28241 16.0019C8.09283 16.0148 7.9054 15.9553 7.75799 15.8354C7.61059 15.7155 7.51419 15.5441 7.48829 15.3558L7.48129 15.2538V8.81383L3.82329 5.15683L5.05029 17.6268C5.07835 17.914 5.20492 18.1827 5.40852 18.3872C5.61212 18.5917 5.88021 18.7195 6.16729 18.7488L6.29429 18.7548H13.6683C14.2683 18.7548 14.7773 18.3298 14.8933 17.7528L14.9133 17.6268L15.0363 16.3708V16.3698Z" fill="#FF0000"></path><path d="M10.9993 8.08983L12.4813 9.57183V8.25383L12.4743 8.15183C12.4504 7.97758 12.3661 7.81724 12.2361 7.69885C12.106 7.58046 11.9384 7.51155 11.7627 7.50417C11.587 7.49678 11.4143 7.55139 11.2747 7.65844C11.1352 7.7655 11.0377 7.91819 10.9993 8.08983Z" fill="#FF0000"></path><path d="M16.1783 4.75383L15.4163 12.5068L16.7883 13.8788L17.6853 4.75383H18.4813L18.5833 4.74683C18.7715 4.72093 18.9429 4.62454 19.0629 4.47713C19.1828 4.32973 19.2423 4.1423 19.2293 3.95271C19.2164 3.76313 19.1319 3.58553 18.9931 3.45581C18.8542 3.32608 18.6713 3.25389 18.4813 3.25383H13.2313L13.2263 3.06983C13.1794 2.22446 12.8044 1.43077 12.1811 0.857674C11.5579 0.28458 10.7356 -0.0226716 9.88926 0.00130479C9.04292 0.0252812 8.23934 0.378593 7.64955 0.986051C7.05975 1.59351 6.73029 2.40715 6.73129 3.25383H6.16329L7.66329 4.75383H16.1783ZM9.98129 1.50383C10.9473 1.50383 11.7313 2.28783 11.7313 3.25383H8.23129L8.23729 3.10983C8.27343 2.67213 8.47283 2.26402 8.7959 1.96651C9.11897 1.669 9.5421 1.50385 9.98129 1.50383Z" fill="#FF0000"></path></svg></span>            
                </button> --}}
            </div>
        </div>
        <div class="long-col">
            <div class="project-actions player-wrap">
                <button class="btn play-project" @click="zoomOut()" v-if="!aplayer.isPlaying">
                    <span class="icon">
                        -
                    </span>            
                </button>
                <button class="btn play-project" @click="zoomIn()" v-if="!aplayer.isPlaying">
                    <span class="icon">
                        +
                    </span>            
                </button>
                <button class="btn play-project" @click="play()" v-if="!aplayer.isPlaying">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                            <path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path>
                            <path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path>
                        </svg>
                    </span>            
                </button>
            {{-- <div v-if="!recordingDone && isRecording" class="recording-wrap"> --}}
                <button class="btn recording-btn" v-if="aplayer.isPlaying" @click="stop">
                  <span class="record-icon"></span>
                </button>
            {{-- </div> --}}
            {{-- <button class="btn play-project" @click="stop()" v-if="aplayer.isPlaying"> --}}
                
                {{-- <span class="icon"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path><path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path></svg></span>             --}}
            {{-- </button> --}}
            <button class="btn save-project" @click="makeSaveRequest" :disabled="isLoading">
                <span class="spinner-border text-light" role="status" v-if="loadingType == 'save'" style="width: 12px; height:12px">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span class="icon" v-if="loadingType != 'save'"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M19.5325 4.5325L15.4675 0.4675C15.1675 0.1675 14.76 0 14.335 0H0.8C0.3575 0 0 0.3575 0 0.8V19.2C0 19.6425 0.3575 20 0.8 20H19.2C19.6425 20 20 19.6425 20 19.2V5.6625C20 5.2375 19.8325 4.8325 19.5325 4.5325ZM6.8 1.6H13.2V4.4H6.8V1.6ZM10 15.45C8.0125 15.45 6.4 13.8375 6.4 11.85C6.4 9.8625 8.0125 8.25 10 8.25C11.9875 8.25 13.6 9.8625 13.6 11.85C13.6 13.8375 11.9875 15.45 10 15.45ZM10 9.85C8.895 9.85 8 10.745 8 11.85C8 12.955 8.895 13.85 10 13.85C11.105 13.85 12 12.955 12 11.85C12 10.745 11.105 9.85 10 9.85Z" fill="white"></path></svg></span>                
                Save
            </button>
            <button class="btn export-project" @click="makeExportRequest" :disabled="isLoading">
                <span class="spinner-border text-light" role="status" v-if="loadingType == 'export'" style="width: 12px; height:12px">
                    <span class="visually-hidden">Loading...</span>
                </span>
                <span class="icon" v-if="loadingType != 'export'"><svg width="20" height="23" viewBox="0 0 20 23" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M8.88889 15.5556H11.1111V5.55556H14.4444L10 0L5.55556 5.55556H8.88889V15.5556Z" fill="white"></path><path d="M2.22222 22.2222H17.7778C19.0033 22.2222 20 21.2256 20 20V10C20 8.77444 19.0033 7.77778 17.7778 7.77778H13.3333V10H17.7778V20H2.22222V10H6.66667V7.77778H2.22222C0.996667 7.77778 0 8.77444 0 10V20C0 21.2256 0.996667 22.2222 2.22222 22.2222Z" fill="white"></path></svg></span>                
                Export
            </button>
            </div>
        </div>
    </div>

    <div class="timeline-row">
        <div class="short-col">
            <div class="timeline-tracks-wrap">
                <div class="timeline-tracks">
                    <div class="track-item" v-for="(layer, index) in layers">
                        <div class="track-name">@{{ layer.name }}</div>
                        <div class="btn dropup track-mute">
                            <button type="button" class="btn me-0 dropdown-toggle" data-bs-toggle="dropdown"  data-bs-auto-close="outside" aria-expanded="false" data-bs-offset="-7,1">
                                            <span class="icon"><svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M17.8152 30.9224H12.1873C11.8347 30.9224 11.4926 30.8019 11.2179 30.5809C10.9432 30.3599 10.7522 30.0516 10.6768 29.7071L10.0475 26.7942C9.20803 26.4264 8.41205 25.9665 7.67419 25.4228L4.83397 26.3273C4.49779 26.4345 4.13505 26.4235 3.80599 26.2961C3.47693 26.1687 3.20135 25.9326 3.02501 25.6269L0.204893 20.7551C0.0304066 20.4492 -0.0350914 20.0931 0.0191153 19.7451C0.073322 19.3971 0.244024 19.0778 0.503294 18.8395L2.70651 16.8295C2.60632 15.919 2.60632 15.0003 2.70651 14.0898L0.503294 12.0845C0.243657 11.846 0.0727227 11.5264 0.0185071 11.1781C-0.0357085 10.8298 0.0300107 10.4734 0.204893 10.1673L3.01883 5.29236C3.19517 4.98672 3.47075 4.75059 3.79981 4.62318C4.12886 4.49578 4.4916 4.48477 4.82779 4.59197L7.66801 5.49645C8.04526 5.21815 8.43797 4.9584 8.84306 4.72339C9.23423 4.50384 9.63622 4.30439 10.0475 4.12659L10.6783 1.2168C10.7534 0.872316 10.944 0.56385 11.2184 0.342541C11.4929 0.121231 11.8347 0.000371016 12.1873 0H17.8152C18.1678 0.000371016 18.5096 0.121231 18.7841 0.342541C19.0585 0.56385 19.2491 0.872316 19.3242 1.2168L19.9612 4.12814C20.8002 4.49596 21.5956 4.95592 22.3329 5.49954L25.1747 4.59506C25.5107 4.48825 25.8731 4.49947 26.2018 4.62685C26.5305 4.75424 26.8058 4.99014 26.9821 5.29546L29.7961 10.1704C30.1548 10.7996 30.0311 11.5959 29.4977 12.086L27.2944 14.096C27.3946 15.0065 27.3946 15.9252 27.2944 16.8357L29.4977 18.8456C30.0311 19.3373 30.1548 20.132 29.7961 20.7613L26.9821 25.6362C26.8058 25.9418 26.5302 26.178 26.2011 26.3054C25.8721 26.4328 25.5093 26.4438 25.1732 26.3366L22.3329 25.4321C21.5957 25.9753 20.8002 26.4348 19.9612 26.802L19.3242 29.7071C19.2488 30.0513 19.0581 30.3594 18.7837 30.5804C18.5092 30.8014 18.1675 30.9221 17.8152 30.9224ZM8.22925 21.9997L9.49707 22.9274C9.7831 23.1377 10.08 23.3309 10.3892 23.5072C10.6798 23.6757 10.9767 23.8272 11.2844 23.9648L12.7269 24.5972L13.4335 27.8301H16.5721L17.2787 24.5957L18.7212 23.9633C19.3505 23.685 19.9488 23.3402 20.5039 22.9336L21.7717 22.0059L24.9289 23.0109L26.4982 20.2928L24.0507 18.0618L24.2238 16.4971C24.3012 15.8122 24.3012 15.121 24.2238 14.4377L24.0507 12.873L26.4997 10.6373L24.9289 7.91767L21.7732 8.92265L20.5039 7.99498C19.9485 7.58633 19.3509 7.23851 18.7212 6.95753L17.2787 6.32517L16.5721 3.09224H13.4335L12.7223 6.32672L11.2844 6.95753C10.6538 7.23368 10.056 7.57904 9.5017 7.98725L8.23234 8.91492L5.07826 7.90994L3.50586 10.6373L5.95336 12.8653L5.7802 14.4315C5.70289 15.1164 5.70289 15.8075 5.7802 16.4909L5.95336 18.0556L3.50586 20.2866L5.07517 23.0047L8.22925 21.9997ZM14.9951 21.6457C13.3548 21.6457 11.7818 20.9941 10.622 19.8343C9.46217 18.6745 8.81059 17.1014 8.81059 15.4612C8.81059 13.821 9.46217 12.2479 10.622 11.0881C11.7818 9.92829 13.3548 9.27671 14.9951 9.27671C16.6353 9.27671 18.2083 9.92829 19.3681 11.0881C20.528 12.2479 21.1795 13.821 21.1795 15.4612C21.1795 17.1014 20.528 18.6745 19.3681 19.8343C18.2083 20.9941 16.6353 21.6457 14.9951 21.6457ZM14.9951 12.3689C14.3895 12.3696 13.7975 12.5479 13.2924 12.882C12.7874 13.216 12.3915 13.6909 12.1539 14.2479C11.9163 14.8049 11.8475 15.4194 11.956 16.0151C12.0644 16.6108 12.3454 17.1616 12.7641 17.5991C13.1827 18.0366 13.7206 18.3415 14.311 18.4761C14.9014 18.6107 15.5183 18.5689 16.0852 18.3561C16.6521 18.1432 17.144 17.7686 17.4999 17.2787C17.8558 16.7889 18.0601 16.2052 18.0873 15.6003V16.2188V15.4612C18.0873 14.6411 17.7615 13.8545 17.1816 13.2746C16.6017 12.6947 15.8152 12.3689 14.9951 12.3689Z" fill="white"></path></svg></span>

                                          
                            </button>
                            <div class="dropdown-menu volume-dropup-menu" style="width: 120px">
                                <div class="btn-group timeline-actions" role="group" style="width: 100%">
                                    {{-- <button type="button" class="btn">
                                        <span class="icon"><svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M9.21053 4.60526C9.21053 2.06579 7.14474 0 4.60526 0C2.06579 0 0 2.06579 0 4.60526C0 7.14474 2.06579 9.21053 4.60526 9.21053C5.34648 9.20538 6.07515 9.01881 6.72763 8.66711L9.82895 11.9934L6.77895 15.0434C6.11337 14.6749 5.36605 14.479 4.60526 14.4737C2.06579 14.4737 0 16.5395 0 19.0789C0 21.6184 2.06579 23.6842 4.60526 23.6842C7.14474 23.6842 9.21053 21.6184 9.21053 19.0789C9.21053 18.2882 8.99211 17.5553 8.63947 16.9053L11.625 13.9211L18.4211 21.2118C19.1612 21.9522 20.165 22.3682 21.2118 22.3684H25L8.35526 7.26053C8.88947 6.50789 9.21053 5.59605 9.21053 4.60526ZM4.60526 6.57895C3.51711 6.57895 2.63158 5.69342 2.63158 4.60526C2.63158 3.51711 3.51711 2.63158 4.60526 2.63158C5.69342 2.63158 6.57895 3.51711 6.57895 4.60526C6.57895 5.69342 5.69342 6.57895 4.60526 6.57895ZM4.60526 21.0526C3.51711 21.0526 2.63158 20.1671 2.63158 19.0789C2.63158 17.9908 3.51711 17.1053 4.60526 17.1053C5.69342 17.1053 6.57895 17.9908 6.57895 19.0789C6.57895 20.1671 5.69342 21.0526 4.60526 21.0526Z" fill="#797FAE"></path><path d="M18.4211 2.47237L13.5434 8.28026L15.4039 10.1408L25 1.31579H21.2118C20.165 1.31601 19.1612 1.73204 18.4211 2.47237Z" fill="#797FAE"></path></svg></span>            
                                    </button> --}}
                                    <button type="button" class="btn" @click="cloneLayer(index)">
                                        <span class="icon"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M23.75 0H7.5C7.16859 0.000372204 6.85087 0.132188 6.61653 0.366528C6.38219 0.600867 6.25037 0.918594 6.25 1.25V17.5C6.25037 17.8314 6.38219 18.1491 6.61653 18.3835C6.85087 18.6178 7.16859 18.7496 7.5 18.75H23.75C24.0814 18.7496 24.3991 18.6178 24.6335 18.3835C24.8678 18.1491 24.9996 17.8314 25 17.5V1.25C24.9996 0.918594 24.8678 0.600867 24.6335 0.366528C24.3991 0.132188 24.0814 0.000372204 23.75 0ZM23.3333 17.0833H7.91667V1.66667H23.3333V17.0833Z" fill="#797FAE"></path><path d="M17.0833 23.3333H1.66667V7.91667H4.58333V6.25H1.25C0.918594 6.25037 0.600867 6.38219 0.366528 6.61653C0.132188 6.85087 0.000372204 7.16859 0 7.5V23.75C0.000372204 24.0814 0.132188 24.3991 0.366528 24.6335C0.600867 24.8678 0.918594 24.9996 1.25 25H17.5C17.8314 24.9996 18.1491 24.8678 18.3835 24.6335C18.6178 24.3991 18.7496 24.0814 18.75 23.75V20.4167H17.0833V23.3333Z" fill="#797FAE"></path></svg></span>            
                                    </button>
                                    <button type="button" class="btn" @click="deleteLayer(index)">
                                        <span class="icon"><svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.92129 3.25383L0.201292 1.53383C0.0688118 1.39166 -0.00331137 1.20361 0.000116847 1.00931C0.00354506 0.81501 0.0822571 0.629625 0.21967 0.492212C0.357083 0.354799 0.542468 0.276087 0.736769 0.272659C0.93107 0.269231 1.11912 0.341354 1.26129 0.473834L19.7613 18.9738C19.8938 19.116 19.9659 19.3041 19.9625 19.4984C19.959 19.6927 19.8803 19.878 19.7429 20.0155C19.6055 20.1529 19.4201 20.2316 19.2258 20.235C19.0315 20.2384 18.8435 20.1663 18.7013 20.0338L16.4083 17.7418L16.4053 17.7728C16.3416 18.4223 16.049 19.028 15.5799 19.4815C15.1107 19.9351 14.4955 20.2071 13.8443 20.2488L13.6683 20.2538H6.29429C5.64175 20.2538 5.01048 20.0218 4.5133 19.5991C4.01611 19.1765 3.68541 18.5909 3.58029 17.9468L3.55729 17.7728L2.27629 4.75383H1.48129C1.30005 4.75383 1.12495 4.68819 0.988361 4.56907C0.851773 4.44994 0.76294 4.28539 0.738292 4.10583L0.731292 4.00383C0.731299 3.8226 0.796934 3.64749 0.916059 3.5109C1.03518 3.37431 1.19974 3.28548 1.37929 3.26083L1.48129 3.25383H1.92129ZM15.0363 16.3698L12.4813 13.8138V15.2538C12.4812 15.4439 12.409 15.6268 12.2793 15.7656C12.1496 15.9045 11.972 15.9889 11.7824 16.0019C11.5928 16.0148 11.4054 15.9553 11.258 15.8354C11.1106 15.7155 11.0142 15.5441 10.9883 15.3558L10.9813 15.2538V12.3138L8.98129 10.3138V15.2538C8.98123 15.4439 8.90905 15.6268 8.77932 15.7656C8.64959 15.9045 8.47199 15.9889 8.28241 16.0019C8.09283 16.0148 7.9054 15.9553 7.75799 15.8354C7.61059 15.7155 7.51419 15.5441 7.48829 15.3558L7.48129 15.2538V8.81383L3.82329 5.15683L5.05029 17.6268C5.07835 17.914 5.20492 18.1827 5.40852 18.3872C5.61212 18.5917 5.88021 18.7195 6.16729 18.7488L6.29429 18.7548H13.6683C14.2683 18.7548 14.7773 18.3298 14.8933 17.7528L14.9133 17.6268L15.0363 16.3708V16.3698Z" fill="#FF0000"></path><path d="M10.9993 8.08983L12.4813 9.57183V8.25383L12.4743 8.15183C12.4504 7.97758 12.3661 7.81724 12.2361 7.69885C12.106 7.58046 11.9384 7.51155 11.7627 7.50417C11.587 7.49678 11.4143 7.55139 11.2747 7.65844C11.1352 7.7655 11.0377 7.91819 10.9993 8.08983Z" fill="#FF0000"></path><path d="M16.1783 4.75383L15.4163 12.5068L16.7883 13.8788L17.6853 4.75383H18.4813L18.5833 4.74683C18.7715 4.72093 18.9429 4.62454 19.0629 4.47713C19.1828 4.32973 19.2423 4.1423 19.2293 3.95271C19.2164 3.76313 19.1319 3.58553 18.9931 3.45581C18.8542 3.32608 18.6713 3.25389 18.4813 3.25383H13.2313L13.2263 3.06983C13.1794 2.22446 12.8044 1.43077 12.1811 0.857674C11.5579 0.28458 10.7356 -0.0226716 9.88926 0.00130479C9.04292 0.0252812 8.23934 0.378593 7.64955 0.986051C7.05975 1.59351 6.73029 2.40715 6.73129 3.25383H6.16329L7.66329 4.75383H16.1783ZM9.98129 1.50383C10.9473 1.50383 11.7313 2.28783 11.7313 3.25383H8.23129L8.23729 3.10983C8.27343 2.67213 8.47283 2.26402 8.7959 1.96651C9.11897 1.669 9.5421 1.50385 9.98129 1.50383Z" fill="#FF0000"></path></svg></span>            
                                    </button>
                                    <button type="button" class="btn me-0 dropdown-toggle" data-bs-toggle="dropdown"  data-bs-auto-close="outside" aria-expanded="false" data-bs-offset="-7,1">
                                        <span class="icon"><svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M9.3329 2.38952L5.47135 6.2502H1.04167C0.466146 6.2502 0 6.71635 0 7.29187V13.5419C0 14.117 0.466146 14.5835 1.04167 14.5835H5.47135L9.3329 18.4442C9.98524 19.0966 11.1111 18.6382 11.1111 17.7077V3.12607C11.1111 2.19465 9.98438 1.73805 9.3329 2.38952ZM19.4596 0.17251C18.9748 -0.145632 18.3233 -0.0115176 18.0052 0.47416C17.6866 0.958969 17.822 1.61044 18.3069 1.92859C21.1832 3.81617 22.8997 6.98935 22.8997 10.4173C22.8997 13.8453 21.1832 17.0184 18.3069 18.906C17.822 19.2237 17.6866 19.8756 18.0052 20.36C18.3108 20.8249 18.957 20.992 19.4596 20.6617C22.9284 18.3848 25 14.5545 25 10.4169C25 6.27928 22.9284 2.44942 19.4596 0.17251ZM20.8333 10.4169C20.8333 7.65949 19.4418 5.12433 17.1107 3.63562C16.625 3.32572 15.9809 3.46982 15.6732 3.9594C15.3654 4.44899 15.5091 5.09699 15.9948 5.40732C17.7201 6.50932 18.75 8.38171 18.75 10.4169C18.75 12.452 17.7201 14.3244 15.9948 15.4264C15.5091 15.7363 15.3654 16.3843 15.6732 16.8743C15.9557 17.324 16.5898 17.5315 17.1107 17.1981C19.4418 15.7094 20.8333 13.1747 20.8333 10.4169ZM14.6801 7.0805C14.1775 6.80576 13.5434 6.98675 13.2648 7.49065C12.9874 7.99456 13.171 8.62781 13.6749 8.90602C14.2352 9.21374 14.5833 9.79317 14.5833 10.4169C14.5833 11.041 14.2352 11.62 13.6753 11.9277C13.1714 12.2059 12.9878 12.8392 13.2652 13.3431C13.5443 13.8492 14.1788 14.0288 14.6806 13.7532C15.9058 13.0783 16.6671 11.8001 16.6671 10.4164C16.6671 9.03275 15.9058 7.75498 14.6801 7.0805Z" fill="#797FAE"></path></svg></span>                    
                                    </button>
                                    <div class="dropdown-menu volume-dropup-menu" id="drp-menu">
                                        <div class="volume-slide" style="background-color: inherit">
                                            <div class="volume-progress" style="border-radius: 10px; background-color: inherit; height:100%">
                                                <div class="volume-slide-content" style="margin-bottom: -7px;">
                                                    <input type="range" orient="vertical" style="height: 130px; margin-bottom: -100px;" v-model="layer.volume" min='0' max='1' step="0.01" @change="setAudioVolume(index)"/>
                                                    <div class="volume-handle" style="background-color: inherit;"></div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                {{-- <div class="volume-slide" style="background-color: inherit">
                                    <div class="volume-progress" style="border-radius: 10px; background-color: inherit; height:100%">
                                        <div class="volume-slide-content" style="margin-bottom: -7px;">
                                            <input type="range" orient="vertical" style="height: 130px; margin-bottom: -100px;" v-model="layer.volume" min='0' max='1' step="0.01" @change="setAudioVolume(index)"/>
                                            <div class="volume-handle" style="background-color: inherit;"></div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="track-item">
                        <div class="track-name">Music Track</div>
                        <button class="btn track-mute">
                            <span class="icon"><svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M9.3329 2.38952L5.47135 6.2502H1.04167C0.466146 6.2502 0 6.71635 0 7.29187V13.5419C0 14.117 0.466146 14.5835 1.04167 14.5835H5.47135L9.3329 18.4442C9.98524 19.0966 11.1111 18.6382 11.1111 17.7077V3.12607C11.1111 2.19465 9.98438 1.73805 9.3329 2.38952ZM19.4596 0.17251C18.9748 -0.145632 18.3233 -0.0115176 18.0052 0.47416C17.6866 0.958969 17.822 1.61044 18.3069 1.92859C21.1832 3.81617 22.8997 6.98935 22.8997 10.4173C22.8997 13.8453 21.1832 17.0184 18.3069 18.906C17.822 19.2237 17.6866 19.8756 18.0052 20.36C18.3108 20.8249 18.957 20.992 19.4596 20.6617C22.9284 18.3848 25 14.5545 25 10.4169C25 6.27928 22.9284 2.44942 19.4596 0.17251ZM20.8333 10.4169C20.8333 7.65949 19.4418 5.12433 17.1107 3.63562C16.625 3.32572 15.9809 3.46982 15.6732 3.9594C15.3654 4.44899 15.5091 5.09699 15.9948 5.40732C17.7201 6.50932 18.75 8.38171 18.75 10.4169C18.75 12.452 17.7201 14.3244 15.9948 15.4264C15.5091 15.7363 15.3654 16.3843 15.6732 16.8743C15.9557 17.324 16.5898 17.5315 17.1107 17.1981C19.4418 15.7094 20.8333 13.1747 20.8333 10.4169ZM14.6801 7.0805C14.1775 6.80576 13.5434 6.98675 13.2648 7.49065C12.9874 7.99456 13.171 8.62781 13.6749 8.90602C14.2352 9.21374 14.5833 9.79317 14.5833 10.4169C14.5833 11.041 14.2352 11.62 13.6753 11.9277C13.1714 12.2059 12.9878 12.8392 13.2652 13.3431C13.5443 13.8492 14.1788 14.0288 14.6806 13.7532C15.9058 13.0783 16.6671 11.8001 16.6671 10.4164C16.6671 9.03275 15.9058 7.75498 14.6801 7.0805Z" fill="#797FAE"></path></svg></span>                
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="long-col">
            <div class="Panel" id="controls" style="display: none">
                <div class="Row controls-wrapper">
                    <button class="Button controls-btn" id="prev-btn" @click="handleControlClick('prev')" style="background: url('files/prev.svg'); "></button>
                    <button class="Button controls-btn" id="play-btn" @click="handleControlClick('play')" style="background: url('files/play.svg');"></button>
                    <button class="Button controls-btn" id="next-btn" @click="handleControlClick('next')"style="background: url('files/next.svg');"></button>
                    <span class="Text timeline-time" id="time-text">0:00.00</span>
                    <span class="Text timeline-speed" id="rate-text">1.0x</span>
                    <button class="Button expand-btn controls-btn" style="background: url('files/fullscreen.svg'); "></button>
                </div>
            </div>
            <div class="timeline-wrap">
                <div class="Panel" id="timeline">
                    <div class="Panel" id="timeline-wrapper" @wheel="handleTimelineWrapperWheelEvent" style="width: 5000%">
                        <canvas height="32" id="timeline-canvas"></canvas>
                        <div id="scroller">
                            <!-- <div id="layer-container" style="width:3000px;height: 100%; background: linear-gradient(blue 1px, transparent 1px) 0% 0% / 32px 32px repeat;">

                            </div> -->
                        </div>
                        <div id="loop-mark"></div>
                        <div id="time-mark">
                            <canvas height="16" id="timeline-mark-canvas" width="16" style="position: absolute;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Music Track Modal -->
    <div class="modal fade" id="addMusicTrackModal" tabindex="-1" aria-labelledby="addMusicTrackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-pills nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                <button class="nav-link active" id="library-tab" data-bs-toggle="tab" data-bs-target="#library" type="button" role="tab" aria-controls="library" aria-selected="true">Music Library</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Upload</button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="library" role="tabpanel" aria-labelledby="library-tab">
                    <select class="form-select category-select">
                        <option selected>Music Category</option>
                        <option>Category 1</option>
                        <option>Category 2</option>
                    </select>

                    <div class="track-list-wrap">
                        <div class="track-list">
                        <div v-for="num in 8" :key="num" class="track-item" :class="{ active: num === 4 }">
                            <div class="icon-wrap">
                            <span class="icon" v-if="num === 4"><svg width="25" height="29" viewBox="0 0 25 29" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M4.6875 0C5.9307 0 7.12299 0.49386 8.00206 1.37294C8.88114 2.25201 9.375 3.4443 9.375 4.6875V23.4375C9.375 24.6807 8.88114 25.873 8.00206 26.7521C7.12299 27.6311 5.9307 28.125 4.6875 28.125C3.4443 28.125 2.25201 27.6311 1.37294 26.7521C0.49386 25.873 2.61985e-08 24.6807 0 23.4375V4.6875C0 3.4443 0.49386 2.25201 1.37294 1.37294C2.25201 0.49386 3.4443 0 4.6875 0ZM20.3125 0C21.5557 0 22.748 0.49386 23.6271 1.37294C24.5061 2.25201 25 3.4443 25 4.6875V23.4375C25 24.6807 24.5061 25.873 23.6271 26.7521C22.748 27.6311 21.5557 28.125 20.3125 28.125C19.0693 28.125 17.877 27.6311 16.9979 26.7521C16.1189 25.873 15.625 24.6807 15.625 23.4375V4.6875C15.625 3.4443 16.1189 2.25201 16.9979 1.37294C17.877 0.49386 19.0693 0 20.3125 0Z" fill="white"></path></svg></span>
                            <span class="icon" v-else ><svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg></span>
                            
                            </div>
                            <a href="#" class="track-title" @click.prevent>
                            On The Form Track
                            </a>
                            <div class="track-duration">
                            03:25
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                    <div class="upload-wrap">
                        <div class="upload-content">
                            <input type="file" @change="getMediaUploaded" id="media-file" style="display: none;">

                            <div class="upload-label">Upload Audio File</div>
                            <div class="upload-box">
                                <span class="upload-icon icon"><svg width="50" height="56" viewBox="0 0 50 56" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M27.7688 49.9839H8.33065C7.59417 49.9839 6.88786 49.6913 6.3671 49.1706C5.84633 48.6498 5.55377 47.9435 5.55377 47.207V8.33065C5.55377 7.59417 5.84633 6.88786 6.3671 6.3671C6.88786 5.84633 7.59417 5.55377 8.33065 5.55377H22.2151V13.8844C22.2151 16.0938 23.0928 18.2128 24.6551 19.7751C26.2174 21.3374 28.3363 22.2151 30.5457 22.2151H38.8764V27.7688C38.8764 28.5053 39.1689 29.2116 39.6897 29.7324C40.2105 30.2532 40.9168 30.5457 41.6533 30.5457C42.3897 30.5457 43.096 30.2532 43.6168 29.7324C44.1376 29.2116 44.4301 28.5053 44.4301 27.7688V19.2716C44.4012 19.0165 44.3454 18.7652 44.2635 18.5218V18.2719C44.13 17.9864 43.9519 17.7239 43.7359 17.4944L27.0746 0.833065C26.8451 0.617068 26.5826 0.438972 26.2971 0.305457C26.2142 0.293683 26.1301 0.293683 26.0472 0.305457C25.7651 0.143679 25.4535 0.0398322 25.1308 0H8.33065C6.12122 0 4.00229 0.877691 2.43999 2.43999C0.877691 4.00229 0 6.12122 0 8.33065V47.207C0 49.4164 0.877691 51.5354 2.43999 53.0977C4.00229 54.66 6.12122 55.5377 8.33065 55.5377H27.7688C28.5053 55.5377 29.2116 55.2451 29.7324 54.7243C30.2532 54.2036 30.5457 53.4973 30.5457 52.7608C30.5457 52.0243 30.2532 51.318 29.7324 50.7972C29.2116 50.2765 28.5053 49.9839 27.7688 49.9839ZM27.7688 9.46917L34.961 16.6613H30.5457C29.8092 16.6613 29.1029 16.3687 28.5822 15.848C28.0614 15.3272 27.7688 14.6209 27.7688 13.8844V9.46917ZM13.8844 16.6613C13.1479 16.6613 12.4416 16.9539 11.9209 17.4746C11.4001 17.9954 11.1075 18.7017 11.1075 19.4382C11.1075 20.1747 11.4001 20.881 11.9209 21.4017C12.4416 21.9225 13.1479 22.2151 13.8844 22.2151H16.6613C17.3978 22.2151 18.1041 21.9225 18.6249 21.4017C19.1456 20.881 19.4382 20.1747 19.4382 19.4382C19.4382 18.7017 19.1456 17.9954 18.6249 17.4746C18.1041 16.9539 17.3978 16.6613 16.6613 16.6613H13.8844ZM30.5457 27.7688H13.8844C13.1479 27.7688 12.4416 28.0614 11.9209 28.5822C11.4001 29.1029 11.1075 29.8092 11.1075 30.5457C11.1075 31.2822 11.4001 31.9885 11.9209 32.5093C12.4416 33.03 13.1479 33.3226 13.8844 33.3226H30.5457C31.2822 33.3226 31.9885 33.03 32.5093 32.5093C33.03 31.9885 33.3226 31.2822 33.3226 30.5457C33.3226 29.8092 33.03 29.1029 32.5093 28.5822C31.9885 28.0614 31.2822 27.7688 30.5457 27.7688ZM49.1786 42.4585L43.6248 36.9048C43.3607 36.652 43.0493 36.4538 42.7085 36.3216C42.0324 36.0439 41.2741 36.0439 40.598 36.3216C40.2572 36.4538 39.9458 36.652 39.6817 36.9048L34.1279 42.4585C33.605 42.9814 33.3112 43.6906 33.3112 44.4301C33.3112 45.1696 33.605 45.8788 34.1279 46.4017C34.6508 46.9246 35.36 47.2184 36.0995 47.2184C36.839 47.2184 37.5482 46.9246 38.0711 46.4017L38.8764 45.5687V52.7608C38.8764 53.4973 39.1689 54.2036 39.6897 54.7243C40.2105 55.2451 40.9168 55.5377 41.6533 55.5377C42.3897 55.5377 43.096 55.2451 43.6168 54.7243C44.1376 54.2036 44.4301 53.4973 44.4301 52.7608V45.5687L45.2354 46.4017C45.4936 46.662 45.8007 46.8686 46.1391 47.0096C46.4775 47.1505 46.8404 47.2231 47.207 47.2231C47.5736 47.2231 47.9366 47.1505 48.2749 47.0096C48.6133 46.8686 48.9205 46.662 49.1786 46.4017C49.4389 46.1436 49.6455 45.8364 49.7864 45.4981C49.9274 45.1597 50 44.7967 50 44.4301C50 44.0636 49.9274 43.7006 49.7864 43.3622C49.6455 43.0238 49.4389 42.7167 49.1786 42.4585ZM24.992 44.4301C25.7284 44.4301 26.4347 44.1376 26.9555 43.6168C27.4763 43.096 27.7688 42.3897 27.7688 41.6533C27.7688 40.9168 27.4763 40.2105 26.9555 39.6897C26.4347 39.1689 25.7284 38.8764 24.992 38.8764H13.8844C13.1479 38.8764 12.4416 39.1689 11.9209 39.6897C11.4001 40.2105 11.1075 40.9168 11.1075 41.6533C11.1075 42.3897 11.4001 43.096 11.9209 43.6168C12.4416 44.1376 13.1479 44.4301 13.8844 44.4301H24.992Z"></path></svg></span>
            
                                <div class="upload-description" v-if="audioUploadName == ''">
                                Drag and drop or <a href="#" @click="activateFileUploader">browse</a> your file
                                </div>
                                <div class="upload-description" v-if="audioUploadName != ''">
                                    @{{audioUploadName}} 
                                    <br />
                                    <a href="#" @click="cancelFileUploader">cancel</a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-4" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" @click="addUploadedAudioToTimeline" :disabled="audioUploadName == '' || isLoading">
                <span class="spinner-border text-light" role="status" v-if="loadingType == 'audioUpload'" style="width: 12px; height:12px">
                    <span class="visually-hidden">Loading...</span>
                </span>
                Insert</button>
            </div>
        </div>
        </div>
    </div>
    <div id="audio-container" style="display: none"></div>

    <!-- LISTEN MODAL -->
	<div class="modal fade" id="listenModal" tabindex="-1" aria-labelledby="listenModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><i class="fa fa-music"></i> {{ __('Listen Synthesized Text') }}</h4>
					<button class="btn close-btn" data-bs-dismiss="modal">
                        <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
                    </button>
				</div>
				<div class="modal-body" id="listen-result-player">        
					<div class="text-center listen-result-player">
						<audio class="voice-audio" id="listen-result" autoplay>
							<source id="listen-source">
						</audio>	
					</div>    
				</div>
				<div class="modal-footer pr-0">
                    <button  style="color:#FFF" class="btn btn-success add-timeline-btn mb-4" data-bs-dismiss="modal" @click="addPreviewToTimeLine()" :disabled="isLoading">
                        <span class="spinner-border text-light" role="status" v-if="loadingType == 'addpreviewtotimeline'" style="width: 12px; height:12px">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span class="icon" v-if="loadingType != 'addpreviewtotimeline'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>                    
                        Add to Timeline
                    </button>
					{{-- <button type="button" class="btn btn-primary mb-4" data-dismiss="modal" id="listen-close">{{ __('Close') }}</button> --}}
				</div>				
			</div>
		</div>
	</div>
	<!-- END LISTEN MODAL -->

  <!-- Record Modal -->
  <div class="modal fade" id="recordModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered bd-example-modal-lg" style="max-width: 750px;">
      <div class="modal-content modal-lg">
        <button class="btn close-btn" data-bs-dismiss="modal">
            <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
        </button>
        <div class="modal-body">
          <div class="record-audio-wrap">
            <div class="record-audio-content">
              <div class="record-audio-label" style="margin-bottom: 10px;">Record Your Audio</div>
              <div v-if="!recordingDone || !isRecording" class="recording-wrap" style="width: 100%; margin-bottom: 10px;">
                <div style="width: 100%; text-align: center;width: 100%;" class="upload-file-content" v-if="teleprompter.currentStep == 1">
                    <div class="upload-file-content" style="display: flex; flex-flow: column; align-items: center;">
                        <div class="upload-file-box" style="width: 80%; padding: 20px; border-radius: 10px; border: 2px dotted #c4c4c4;">
                            <span class="upload-file-icon icon" style="    font-size: 3.5rem; color: #c4c4c4;">
                                <svg width="50" height="56" viewBox="0 0 50 56" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                                    <path
                                        d="M27.7688 49.9839H8.33065C7.59417 49.9839 6.88786 49.6913 6.3671 49.1706C5.84633 48.6498 5.55377 47.9435 5.55377 47.207V8.33065C5.55377 7.59417 5.84633 6.88786 6.3671 6.3671C6.88786 5.84633 7.59417 5.55377 8.33065 5.55377H22.2151V13.8844C22.2151 16.0938 23.0928 18.2128 24.6551 19.7751C26.2174 21.3374 28.3363 22.2151 30.5457 22.2151H38.8764V27.7688C38.8764 28.5053 39.1689 29.2116 39.6897 29.7324C40.2105 30.2532 40.9168 30.5457 41.6533 30.5457C42.3897 30.5457 43.096 30.2532 43.6168 29.7324C44.1376 29.2116 44.4301 28.5053 44.4301 27.7688V19.2716C44.4012 19.0165 44.3454 18.7652 44.2635 18.5218V18.2719C44.13 17.9864 43.9519 17.7239 43.7359 17.4944L27.0746 0.833065C26.8451 0.617068 26.5826 0.438972 26.2971 0.305457C26.2142 0.293683 26.1301 0.293683 26.0472 0.305457C25.7651 0.143679 25.4535 0.0398322 25.1308 0H8.33065C6.12122 0 4.00229 0.877691 2.43999 2.43999C0.877691 4.00229 0 6.12122 0 8.33065V47.207C0 49.4164 0.877691 51.5354 2.43999 53.0977C4.00229 54.66 6.12122 55.5377 8.33065 55.5377H27.7688C28.5053 55.5377 29.2116 55.2451 29.7324 54.7243C30.2532 54.2036 30.5457 53.4973 30.5457 52.7608C30.5457 52.0243 30.2532 51.318 29.7324 50.7972C29.2116 50.2765 28.5053 49.9839 27.7688 49.9839ZM27.7688 9.46917L34.961 16.6613H30.5457C29.8092 16.6613 29.1029 16.3687 28.5822 15.848C28.0614 15.3272 27.7688 14.6209 27.7688 13.8844V9.46917ZM13.8844 16.6613C13.1479 16.6613 12.4416 16.9539 11.9209 17.4746C11.4001 17.9954 11.1075 18.7017 11.1075 19.4382C11.1075 20.1747 11.4001 20.881 11.9209 21.4017C12.4416 21.9225 13.1479 22.2151 13.8844 22.2151H16.6613C17.3978 22.2151 18.1041 21.9225 18.6249 21.4017C19.1456 20.881 19.4382 20.1747 19.4382 19.4382C19.4382 18.7017 19.1456 17.9954 18.6249 17.4746C18.1041 16.9539 17.3978 16.6613 16.6613 16.6613H13.8844ZM30.5457 27.7688H13.8844C13.1479 27.7688 12.4416 28.0614 11.9209 28.5822C11.4001 29.1029 11.1075 29.8092 11.1075 30.5457C11.1075 31.2822 11.4001 31.9885 11.9209 32.5093C12.4416 33.03 13.1479 33.3226 13.8844 33.3226H30.5457C31.2822 33.3226 31.9885 33.03 32.5093 32.5093C33.03 31.9885 33.3226 31.2822 33.3226 30.5457C33.3226 29.8092 33.03 29.1029 32.5093 28.5822C31.9885 28.0614 31.2822 27.7688 30.5457 27.7688ZM49.1786 42.4585L43.6248 36.9048C43.3607 36.652 43.0493 36.4538 42.7085 36.3216C42.0324 36.0439 41.2741 36.0439 40.598 36.3216C40.2572 36.4538 39.9458 36.652 39.6817 36.9048L34.1279 42.4585C33.605 42.9814 33.3112 43.6906 33.3112 44.4301C33.3112 45.1696 33.605 45.8788 34.1279 46.4017C34.6508 46.9246 35.36 47.2184 36.0995 47.2184C36.839 47.2184 37.5482 46.9246 38.0711 46.4017L38.8764 45.5687V52.7608C38.8764 53.4973 39.1689 54.2036 39.6897 54.7243C40.2105 55.2451 40.9168 55.5377 41.6533 55.5377C42.3897 55.5377 43.096 55.2451 43.6168 54.7243C44.1376 54.2036 44.4301 53.4973 44.4301 52.7608V45.5687L45.2354 46.4017C45.4936 46.662 45.8007 46.8686 46.1391 47.0096C46.4775 47.1505 46.8404 47.2231 47.207 47.2231C47.5736 47.2231 47.9366 47.1505 48.2749 47.0096C48.6133 46.8686 48.9205 46.662 49.1786 46.4017C49.4389 46.1436 49.6455 45.8364 49.7864 45.4981C49.9274 45.1597 50 44.7967 50 44.4301C50 44.0636 49.9274 43.7006 49.7864 43.3622C49.6455 43.0238 49.4389 42.7167 49.1786 42.4585ZM24.992 44.4301C25.7284 44.4301 26.4347 44.1376 26.9555 43.6168C27.4763 43.096 27.7688 42.3897 27.7688 41.6533C27.7688 40.9168 27.4763 40.2105 26.9555 39.6897C26.4347 39.1689 25.7284 38.8764 24.992 38.8764H13.8844C13.1479 38.8764 12.4416 39.1689 11.9209 39.6897C11.4001 40.2105 11.1075 40.9168 11.1075 41.6533C11.1075 42.3897 11.4001 43.096 11.9209 43.6168C12.4416 44.1376 13.1479 44.4301 13.8844 44.4301H24.992Z"
                                    ></path>
                                </svg>
                            </span>
                            <div class="upload-file-description" style="margin-top: 10px;
                            color: #fff;">Drag and drop or <a href="#" @click="openFileExplorer()">browse</a> your file</div>
                            <input type="file" name="" id="doc-upload" @change="fileonUpload($event)" style="display: none">

                        </div>
                        <div class="upload-file-buttons mt-4">
                            <button v-if="!isLoading" @click="uploadFile()" class="btn btn-primary btn-upload">
                                Upload
                            </button>
                            <button v-if="isLoading" disabled class="btn btn-primary btn-upload" style="
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                "><span role="status" class="spinner-border text-light" style="
                                    width: 15px;
                                    height: 15px;
                                    margin-right: 5px;
                                "><span class="visually-hidden">Loading...</span></span>
                                Loading
                            </button>
                        </div>
                    </div>
                </div>
                <div style="width: 100%" v-if="teleprompter.currentStep == 2">
                    <div class="audio-textarea form-control" style="position:relative;overflow:hidden;max-height:300px; min-height:300px">
                        <div contentEditable="true" class="" style="resize: none; position:relative;left:0;top:0" id="prompter-content" :style="{fontSize: teleprompter.fontSize + 'px'}">
                            @{{ teleprompter.text }}
                        </div>
                    </div>
                    <div style="width: 100%" class="container">
                        <div class="row">
                            <div style="width: 70px; height: 28px; border: 1px solid #797FAE; box-sizing: border-box; border-radius: 5px; display: flex; justify-content: space-around; margin-top: 10px; padding: 5px;">
                                <img src="/assets/img/play-prompter.svg" style="height: 15px; cursor:pointer;" alt="" class="record-audio-wave" @click="teleprompterScrolldown">
                                <img src="/assets/img/pause-prompter.svg" style="height: 15px; cursor:pointer;" alt="" class="record-audio-wave" @click="teleprompterStop">
        
                            </div>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="col-12" style="font-size: 13px;">Speed</label>
                                        <span style="font-size: 13px;">Slow</span> <input type="range" min="1" max="16" @change="setspeed" v-model="teleprompter.speedSize" name="" id=""><span style="font-size: 13px;">Fast</span>
                                    </div>
                                    <div class="col-5">
                                        <label class="col-12" style="font-size: 13px;">Font size</label>
                                        <span style="font-size: 13px;">Small</span><input type="range" min="14" max="50" name="" id="" v-model="teleprompter.fontSize"><span style="font-size: 13px;">Large</span>
                                    </div>
                                    <div class="col-2">
                                        <button style="width: 128px; height: 31px; border: 1px solid #797FAE; box-sizing: border-box; border-radius: 5px; background: transparent; color: #FFF; margin-top: 10px;" @click="resetTeleprompter">Reset Default</button>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                  {{-- <textarea name="" id="" cols="30" rows="10" class="col-12 form-control"></textarea> --}}
              </div>
              
              <div class="record-audio-wave-wrap">
                {{-- <div class="slider">
                    <p id="rangeValue">10</p>
                  </div> --}}
                <template v-show="recordingDone">
                    
                  <div class="progress" v-show="recordingDone">
                    <input type="range" min="0" :max="rangeMaximum" v-model="currentRange" style="width: 100%" id="time-range">

                    {{-- <div class="progress-bar" role="progressbar" style="width: 2%" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100">
                      <div class="slide-handle"></div>
                    </div> --}}
                  </div>
                  <div class="recording-duration">@{{ audioTimeReader }}</div>
                </template>
                <img v-show="!recordingDone" src="/assets/img/waveform.svg" alt="" class="record-audio-wave">
              </div>
              <div class="record-audio-buttons">
                <div v-if="!recordingDone && isRecording" class="recording-wrap">
                  <button class="btn recording-btn" @click="stopRecording">
                    <span class="record-icon"></span>
                  </button>

                  <div class="recording-duration">@{{ timeDisplay }}</div>
                </div>

                <button v-if="!isRecording" class="btn play-recording-btn" @click="startRecording">
                    <span class="icon"><svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg></span>                
                </button>

                <button v-if="recordingDone" class="btn play-recording-btn" @click="playRecording">
                    <span class="icon"><svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg></span>                
                </button>

                <button v-if="recordingDone" class="btn btn-success recording-add-timeline-btn" @click="addRecordedAudio()" :disabled="isLoading">
                    <span class="spinner-border text-light" role="status" v-if="loadingType == 'addRecordedAudio'" style="width: 12px; height:12px">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span class="icon" v-if="loadingType != 'addRecordedAudio'"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>
                  Add to Timeline
                </button>
                <button v-if="recordingDone" class="btn record-btn" @click="clearRecording">
                    <span class="icon"><svg width="28" height="39" viewBox="0 0 28 39" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M14 23.7576C17.9836 23.7576 21.2121 20.5673 21.2121 16.6303V7.12727C21.2121 3.1903 17.9836 0 14 0C10.0164 0 6.78788 3.1903 6.78788 7.12727V16.6303C6.78788 20.5673 10.0164 23.7576 14 23.7576ZM28 16.5455C28 16.3588 27.8473 16.2061 27.6606 16.2061H25.1152C24.9285 16.2061 24.7758 16.3588 24.7758 16.5455C24.7758 22.4976 19.9521 27.3212 14 27.3212C8.04788 27.3212 3.22424 22.4976 3.22424 16.5455C3.22424 16.3588 3.07152 16.2061 2.88485 16.2061H0.339394C0.152727 16.2061 0 16.3588 0 16.5455C0 23.7024 5.37091 29.6079 12.303 30.4436V34.7879H6.13879C5.55758 34.7879 5.09091 35.3945 5.09091 36.1455V37.6727C5.09091 37.8594 5.2097 38.0121 5.35394 38.0121H22.6461C22.7903 38.0121 22.9091 37.8594 22.9091 37.6727V36.1455C22.9091 35.3945 22.4424 34.7879 21.8612 34.7879H15.5273V30.4648C22.54 29.7012 28 23.7618 28 16.5455Z" fill="white"></path></svg></span>                    
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@csrf
</div>
<textarea name="" id="speech_text" cols="30" rows="10" style="display: none">{{ Session::get('user_text') }}</textarea>
<textarea id="upload-text-url" style="display: none">{{ route('user.upload-text')}}</textarea>
<textarea style="display:none" id="languages">{!! json_encode($languages) !!}</textarea>
<textarea style="display:none" id="voices">{!! json_encode($voices) !!}</textarea>
<textarea style="display:none" id="synthesize-url" cols="30" rows="10">{{ route('user.tts.listen') }}</textarea>
<textarea style="display:none" id="store-record-url" cols="30" rows="10">{{ route('user.tts.store-record') }}</textarea>
<textarea style="display:none" id="store-upload-url" cols="30" rows="10">{{ route('user.tts.store-upload') }}</textarea>
<textarea style="display:none" id="export-audio-url" cols="30" rows="10">{{ route('user.tts.export-audio') }}</textarea>
<textarea style="display:none" id="save-config-url" cols="30" rows="10">{{ route('user.tts.save-config') }}</textarea>
<textarea style="display:none" id="audio-full-url" cols="30" rows="10">{{ route('user.fetch-audio') }}</textarea>
<textarea style="display:none" id="audio-details">{!! json_encode($audio) !!}</textarea>

			

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

<script src="{{ asset('js/app/vendors/axios.js') }}"></script>
<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script src="/js/libs/signals.min.js"></script>
<script src="/js/app/utils.js"></script>
<script src="/plugins/audio-player/green-audio-player.js"></script>
<script src="/js/app/editor.js?v=4.6"></script>
<script>
    document.addEventListener( 'dragover', function ( event ) {

        event.preventDefault();
        event.dataTransfer.dropEffect = 'copy';

    }, false );
</script>
    {{-- <script type="module" src="{{ asset('js/Interactor/ThreadViewModel.js')}}"> </script> --}}

@endsection