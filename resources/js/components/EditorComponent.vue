<template>
    <div class="main-col-content audio-editor-page" id="audio-editor">
        <div class="controls-wrap">
            <audio-settings></audio-settings>
            <audio-text></audio-text>            
        </div>

       
        <timeline-panel></timeline-panel>
        <timeline></timeline>

        

        

        
        
        
        
    </div>
</template>

<script>
    
    import AudioSettings from "./AudioSettingsComponent.vue";
    import AudioText from "./AudioTextComponent.vue";
    import TimelinePanel from "./TimelinePanel.vue";
    import Timeline from "./Timeline.vue";


    export default {
        components:{
            'audio-settings' : AudioSettings,
            'audio-text' : AudioText,
            'timeline-panel': TimelinePanel,
            'timeline': Timeline
        },
        data() {
            return {
                // languages: [],
                // languageIdError:"",
                // voiceIdError:"",
                // // selectedLanguageId: 0,
                // selectedLanguage: {},
                // isLoading: false,
                // loadingType: '',
                // edit_id:'',
                // edit_name: '',
                // voices: [],
                // selectedVoiceId: 0,
                // selectedVoice: {},
                // selectedFormat: 'mp3',
                // speech_text: '',
                // player : {},
                // signals: {},
                // scale: 12,
                // duration: 100,
                // prevScale:0,
                // layers:[],
                // scroller:{},
                // canvas:{},
                // loopMark:{},
                // timeMark:{},
                // playBtn:{},
                // timeText:{},
                // playbackRateText: {},
                // prevTime: 0,
                // currentInverval: {},
                // audioUploadName: '',
                // uploadedFile: {},
               
                // mediaRecorder: {},
                // audioChunks: [],
                // audioBlob:{},
                // audioUrl:{},
                // audio:{},
                // startTime: '',
                
                // audioTimeReader: '00:00',
                // refreshIntervalId: 0,
                
                // currentRange: 0,
                // rangeMaximum: 0,
                // currentPreviewRange: 0,
                // previewRangeMaximum: 0,
                // // prevAudio:{},
                // backgroundMusic: [],
                // backgroundSounds:[],
                // trackType: "0",
                // trackName: '',
                
                
                // trimPreviewAudio:{},
                // trimPreviewIsPlaying:false,
                // trimPreviewFrameId:0,
                // trimLastTime:null,
                // rangeSlider:{},
                // rangeSliderButtons:{},
                // prevKey:'',
                // url: {
                //     synthesize: '',
                //     storeRecord: '',
                //     storeAudioUpload: '',
                //     export: '',
                //     save:'',
                //     audioURL:'',
                //     backgroundMusicURL: '',
                //     backgroundSoundsURL:'',
                //     storeLibraryAudio: ''
                // },
                // aplayer :{
                //     isPlaying: false
                // },
                // voicePreviewIsPlaying: false,
                // prevSynthesizeAudioURL: '',
                // prevSynthesizePath: '',
                // activeTab: 'library',
                
                // activeLayer:{
                //     volume: 1,
                // },
                // activeLayerIndex: 0,

                
                

            }
        },
        created(){
            let url = {
                synthesize: '',
                storeRecord: '',
                storeAudioUpload: '',
                export: '',
                save:'',
                audioURL:'',
                backgroundMusicURL: '',
                backgroundSoundsURL:'',
                storeLibraryAudio: ''
            };
            url.synthesize = $("#synthesize-url").val();
            url.storeRecord = $("#store-record-url").val();
            url.storeAudioUpload = $("#store-upload-url").val();
            url.export = $("#export-audio-url").val();
            url.save = $("#save-config-url").val();
            url.audioURL = $("#audio-full-url").val() + "/";
            url.backgroundSoundsURL = $("#get-audio-sounds-url").val();
            url.backgroundMusicURL = $("#get-audio-music-url").val();
            url.storeLibraryAudio = $("#store-audio-music-url").val();
            url.masterpieceURL = $("#master-piece-url").val();

            let languages = JSON.parse($("#languages").val());
            let voices = JSON.parse($("#voices").val());
            let audio = JSON.parse($("#audio-details").val());
            
            let edit_id = audio.uuid;
            let edit_name = audio.audio_name;
            // this.selectedVoiceId = audio.voice_id;
            // this.selectedLanguageId = audio.voice_id;
            let layers = audio.layers;
            let speech_text = audio.speech_text;
            let player = new Player();
            

            let signals = editorSignals;

            this.$store.dispatch('setEditorState', Object.assign({},{
                url: url,
                voices: voices,
                languages: languages,
                edit_id: edit_id,
                edit_name: edit_name,
                layers:  layers,
                speech_text:  speech_text,
                player: player,
                signals: signals
            }));
        },
        computed: {
            // getVoices(){
            //     let voices = [];
            //     for(let key in this.voices){
            //         if(this.selectedLanguageId != 0){
            //             if(this.voices[key].language_code == this.selectedLanguage.language_code){
            //                 voices.push(Object.assign({}, this.voices[key]));
            //             }
            //         }
            //     }

            //     return voices;
            // },
            getvoicePath(){
                return voicePath;
            },
            backgroundMusicisInFirstPage () {
                return this.backgroundMusicCurrentPage === 1
            },
            backgroundMusicisInLastPage () {
                return this.backgroundMusicCurrentPage === this.backgroundMusicLastPage
            },

            backgroundSoundisInFirstPage () {
                return this.backgroundSoundCurrentPage === 1
            },
            backgroundSoundisInLastPage () {
                return this.backgroundSoundCurrentPage === this.backgroundSoundLastPage
            },
            
        },
    
        mounted() {
            

            
            
            

            

           

            

            


            // var previewRange = document.getElementById("preview-time-range");

            // var prevAudioListener = () => {
            //     window.requestAnimationFrame(() => {
            //         this.prevAudio.currentTime = previewRange.value
            //     });
            // };

            // previewRange.addEventListener("mousedown", function() {
            //     listener();
            //     previewRange.addEventListener("mousemove", prevAudioListener);
            // });
            // previewRange.addEventListener("mouseup", function() {
            //     previewRange.removeEventListener("mousemove", prevAudioListener);
            // });

            // include the following line to maintain accessibility
            // by allowing the listener to also be fired for
            // appropriate keyboard events
            // range.addEventListener("keydown", listener);
           

            
            
            
        },
        methods: {
            
            

            
            
            
            // setVoice(){
            //     this.prevAudio = document.getElementById('preview-audio');
            //     this.prevAudio.src = '';
            //     // source.stop();
            //     this.prevAudio.load();
            //     let voicePath = '';
            //     for(let key in this.voices){
            //         if(this.selectedVoiceId != 0){
            //             if(this.voices[key].voice_id == this.selectedVoiceId && (this.voices[key].language_code == this.selectedLanguage.language_code)){
            //                 this.selectedVoice = Object.assign({}, this.voices[key]);

            //                 let name = this.voices[key].voice;
            //                 capitalisedName =  name.charAt(0).toUpperCase() + name.slice(1);
            //                 voicePath = capitalisedName +" ("+ this.voices[key].gender + ").mp3";
            //                 this.prevAudio.src = '/voices/azure-new/' + voicePath;
            //                 this.prevAudio.load();
            //                 this.prevAudio.addEventListener("loadedmetadata", e => {
            //                     this.previewRangeMaximum = Math.floor(this.prevAudio.duration);
            //                 })
            //             }
            //         }
            //     }
            // },
            // setSelectedLanguage(){
            //     for(let key in this.languages){
            //         if(this.languages[key].id == this.selectedLanguageId){
            //             this.selectedLanguage = Object.assign({}, this.languages[key]);
            //         }
            //     }
            // },
            
            
            
            
            
            
            
            
            
            
            

            // handleControlClick(type){
            //     if(type == 'prev'){
            //         this.setTime( this.player.currentTime - 1 );
            //     }

            //     if(type == 'play'){
            //         this.player.isPlaying ? this.stop() : this.play();
            //     }

            //     if(type == 'next'){
            //         this.setTime( this.player.currentTime + 1 );
            //     }
            // },

            
            

            
            
            
            

            

            

            
            
            
           

            addVideoLayer(file){
                var objectUrl = URL.createObjectURL(file);
                var videoConatiner = document.getElementById("video-container");
                var newVideo = document.createElement("VIDEO");
                var videoID = 'video-'+ this.layers.length;
                newVideo.id       = videoID;
                newVideo.src      = objectUrl;
                newVideo.type     = file.type;
                newVideo.controls = 'controls';
                videoConatiner.appendChild(newVideo);
                newVideo = document.getElementById(videoID);
            },
            
            // addLayerToTimeLine(layerNumber){
            //     var layer = this.layers[layerNumber];
            //     let vueInstance = this;
                
            //     var layerContainer = document.createElement( 'div' );
            //     layerContainer.id = "layer-container-"+layerNumber;
            //     layerContainer.style.position = "relative";
            //     layerContainer.style.height = '30px';
            //     layerContainer.classList.add('layer-bar');
            //     // layerContainer.style.padding = '4px';
            //     // layerContainer.style.border = '1px solid #FFF';

            

            //     layerContainer.style.width = (this.duration * this.scale) +'px';

            //     var toolTip = document.createElement( 'div' );
            //     toolTip.id = "layer-tooltip-"+layerNumber;
            //     toolTip.className = 'layer-tooltip';
            //     toolTip.style.borderRadius = '5px 5px 5px 5px';
            //     toolTip.style.border = '1px solid #FFF';

            //     let toolTipContent = document.createElement( 'div' );
            //     toolTipContent.style.background = '#1d1f42';
            //     toolTipContent.style.display = 'flex';
            //     toolTipContent.style.width = '100%';
            //     toolTipContent.style.borderRadius = '5px 5px 5px 5px';
            //     toolTipContent.style.height = '100%';
            //     toolTipContent.innerHTML = `
            //         <button class="trim-btn" data-layer-index="${layerNumber}">
            //             <svg width="12" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                 <path d="M7.36842 3.68421C7.36842 1.65263 5.71579 0 3.68421 0C1.65263 0 0 1.65263 0 3.68421C0 5.71579 1.65263 7.36842 3.68421 7.36842C4.27718 7.3643 4.86012 7.21504 5.38211 6.93368L7.86316 9.59474L5.42316 12.0347C4.8907 11.7399 4.29284 11.5832 3.68421 11.5789C1.65263 11.5789 0 13.2316 0 15.2632C0 17.2947 1.65263 18.9474 3.68421 18.9474C5.71579 18.9474 7.36842 17.2947 7.36842 15.2632C7.36842 14.6305 7.19368 14.0442 6.91158 13.5242L9.3 11.1368L14.7368 16.9695C15.3289 17.5617 16.132 17.8946 16.9695 17.8947H20L6.68421 5.80842C7.11158 5.20632 7.36842 4.47684 7.36842 3.68421ZM3.68421 5.26316C2.81368 5.26316 2.10526 4.55474 2.10526 3.68421C2.10526 2.81368 2.81368 2.10526 3.68421 2.10526C4.55474 2.10526 5.26316 2.81368 5.26316 3.68421C5.26316 4.55474 4.55474 5.26316 3.68421 5.26316ZM3.68421 16.8421C2.81368 16.8421 2.10526 16.1337 2.10526 15.2632C2.10526 14.3926 2.81368 13.6842 3.68421 13.6842C4.55474 13.6842 5.26316 14.3926 5.26316 15.2632C5.26316 16.1337 4.55474 16.8421 3.68421 16.8421Z"/>
            //                 <path d="M14.7368 1.9779L10.8347 6.62421L12.3232 8.11263L20 1.05263H16.9695C16.132 1.05281 15.3289 1.38563 14.7368 1.9779Z"/>
            //             </svg>
            //             Trim
            //         </button>
            //         <button class="popup-btn-volume" data-layer-index="${layerNumber}">
            //             <svg width="12" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                 <path d="M8.58627 2.19836L5.03365 5.75019H0.958333C0.428854 5.75019 0 6.17904 0 6.70852V12.4585C0 12.9876 0.428854 13.4169 0.958333 13.4169H5.03365L8.58627 16.9687C9.18642 17.5688 10.2222 17.1472 10.2222 16.2911V2.87598C10.2222 2.01907 9.18563 1.599 8.58627 2.19836ZM17.9029 0.158709C17.4568 -0.133982 16.8575 -0.0105962 16.5648 0.436227C16.2717 0.882251 16.3963 1.48161 16.8423 1.7743C19.4885 3.51088 21.0678 6.4302 21.0678 9.58392C21.0678 12.7376 19.4885 15.657 16.8423 17.3935C16.3963 17.6858 16.2717 18.2856 16.5648 18.7312C16.8459 19.1589 17.4405 19.3126 17.9029 19.0087C21.0941 16.914 23 13.3901 23 9.58352C23 5.77694 21.0941 2.25347 17.9029 0.158709ZM19.1667 9.58352C19.1667 7.04673 17.8865 4.71439 15.7418 3.34477C15.295 3.05966 14.7024 3.19223 14.4193 3.64265C14.1362 4.09307 14.2684 4.68923 14.7152 4.97473C16.3024 5.98857 17.25 7.71118 17.25 9.58352C17.25 11.4559 16.3024 13.1785 14.7152 14.1923C14.2684 14.4774 14.1362 15.0736 14.4193 15.5244C14.6793 15.9381 15.2627 16.1289 15.7418 15.8223C17.8865 14.4527 19.1667 12.1207 19.1667 9.58352ZM13.5057 6.51406C13.0433 6.2613 12.4599 6.42781 12.2036 6.8914C11.9484 7.355 12.1173 7.93758 12.5809 8.19354C13.0964 8.47664 13.4167 9.00972 13.4167 9.58352C13.4167 10.1577 13.0964 10.6904 12.5813 10.9735C12.1177 11.2295 11.9488 11.812 12.204 12.2756C12.4607 12.7412 13.0445 12.9065 13.5061 12.653C14.6334 12.0321 15.3337 10.8561 15.3337 9.58312C15.3337 8.31013 14.6334 7.13458 13.5057 6.51406Z"/>
            //             </svg>
                    
            //             Volume
            //         </button>
            //         <button class="popup-btn-clone" data-layer-index="${layerNumber}">
            //             <svg width="12" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                 <path d="M21.85 0H6.9C6.59511 0.000342428 6.3028 0.121613 6.0872 0.337205C5.87161 0.552798 5.75034 0.845106 5.75 1.15V16.1C5.75034 16.4049 5.87161 16.6972 6.0872 16.9128C6.3028 17.1284 6.59511 17.2497 6.9 17.25H21.85C22.1549 17.2497 22.4472 17.1284 22.6628 16.9128C22.8784 16.6972 22.9997 16.4049 23 16.1V1.15C22.9997 0.845106 22.8784 0.552798 22.6628 0.337205C22.4472 0.121613 22.1549 0.000342428 21.85 0ZM21.4667 15.7167H7.28333V1.53333H21.4667V15.7167Z"/>
            //                 <path d="M15.7167 21.4667H1.53333V7.28333H4.21667V5.75H1.15C0.845106 5.75034 0.552798 5.87161 0.337205 6.0872C0.121613 6.3028 0.000342428 6.59511 0 6.9V21.85C0.000342428 22.1549 0.121613 22.4472 0.337205 22.6628C0.552798 22.8784 0.845106 22.9997 1.15 23H16.1C16.4049 22.9997 16.6972 22.8784 16.9128 22.6628C17.1284 22.4472 17.2497 22.1549 17.25 21.85V18.7833H15.7167V21.4667Z" />
            //             </svg>
                    
            //             Duplicate
            //         </button>
            //         <button class="popup-btn-delete" data-layer-index="${layerNumber}">
            //             <svg width="12" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            //                 <path d="M2.21363 3.74892L0.231919 1.76722C0.0792819 1.60341 -0.00381521 1.38675 0.000134626 1.16288C0.00408446 0.939018 0.0947729 0.725426 0.253094 0.567105C0.411415 0.408784 0.625008 0.318095 0.848873 0.314146C1.07274 0.310196 1.2894 0.393293 1.4532 0.54593L22.7681 21.8608C22.9207 22.0246 23.0038 22.2413 22.9999 22.4651C22.9959 22.689 22.9052 22.9026 22.7469 23.0609C22.5886 23.2192 22.375 23.3099 22.1511 23.3139C21.9273 23.3178 21.7106 23.2347 21.5468 23.0821L18.9049 20.4414L18.9014 20.4771C18.8281 21.2254 18.491 21.9232 17.9504 22.4458C17.4099 22.9684 16.7011 23.2817 15.9508 23.3298L15.748 23.3356H7.252C6.50018 23.3355 5.77286 23.0682 5.20002 22.5812C4.62719 22.0943 4.24617 21.4196 4.12505 20.6775L4.09855 20.4771L2.62264 5.47716H1.70668C1.49786 5.47715 1.29612 5.40153 1.13875 5.26428C0.981374 5.12703 0.879026 4.93743 0.850627 4.73056L0.842562 4.61304C0.842571 4.40423 0.918192 4.20248 1.05544 4.04511C1.19269 3.88774 1.38228 3.78539 1.58916 3.75699L1.70668 3.74892H2.21363ZM17.3241 18.8606L14.3804 15.9157V17.5748C14.3803 17.7937 14.2972 18.0045 14.1477 18.1645C13.9982 18.3244 13.7936 18.4217 13.5752 18.4366C13.3567 18.4516 13.1408 18.383 12.971 18.2448C12.8011 18.1067 12.6901 17.9092 12.6602 17.6923L12.6522 17.5748V14.1875L10.3478 11.8831V17.5748C10.3478 17.7937 10.2646 18.0045 10.1151 18.1645C9.96567 18.3244 9.76105 18.4217 9.54263 18.4366C9.3242 18.4516 9.10825 18.383 8.93841 18.2448C8.76858 18.1067 8.65752 17.9092 8.62768 17.6923L8.61961 17.5748V10.1549L4.40503 5.94147L5.81872 20.3089C5.85105 20.6398 5.99687 20.9493 6.23145 21.1849C6.46603 21.4206 6.77491 21.5678 7.10568 21.6016L7.252 21.6085H15.748C16.4393 21.6085 17.0257 21.1188 17.1594 20.454L17.1824 20.3089L17.3241 18.8617V18.8606Z" />
            //                 <path d="M12.6729 9.32075L14.3804 11.0282V9.5097L14.3723 9.39218C14.3449 9.19141 14.2477 9.00668 14.0978 8.87027C13.948 8.73387 13.7549 8.65448 13.5525 8.64597C13.35 8.63746 13.151 8.70037 12.9902 8.82372C12.8294 8.94706 12.7171 9.12299 12.6729 9.32075Z" />
            //                 <path d="M18.6399 5.47716L17.762 14.4098L19.3427 15.9906L20.3762 5.47716H21.2933L21.4108 5.46909C21.6277 5.43925 21.8252 5.32819 21.9634 5.15835C22.1015 4.98852 22.1701 4.77257 22.1552 4.55414C22.1402 4.33571 22.043 4.13109 21.883 3.98163C21.723 3.83216 21.5123 3.74899 21.2933 3.74892H15.2445L15.2387 3.53693C15.1847 2.56292 14.7526 1.64847 14.0345 0.988174C13.3165 0.327881 12.3691 -0.0261212 11.394 0.00150332C10.4188 0.0291278 9.493 0.436198 8.81347 1.13608C8.13393 1.83597 7.75434 2.77342 7.7555 3.74892H7.10107L8.8293 5.47716H18.6399ZM11.5 1.73265C12.613 1.73265 13.5163 2.63594 13.5163 3.74892H9.48373L9.49064 3.58301C9.53228 3.07871 9.76201 2.60851 10.1342 2.26573C10.5065 1.92295 10.994 1.73267 11.5 1.73265Z"/>
            //             </svg>
            //             Delete
            //         </button>`;

                

                

            //     /* String with HTML source code (so called DOMString) to HTMLElement */
            //     // let newContent = new DOMParser().parseFromString(stringToHtml, 'text/html');

            //     // const newContent = document.createTextNode("Tooltip");

            //     // add the text node to the newly created div
            //     toolTip.appendChild(toolTipContent);

            //     layerContainer.appendChild( toolTip );
                
            //     var dom = document.createElement( 'div' );
            //     dom.className = 'block';
            //     dom.id = "dom-"+layerNumber;
            //     dom.style.display = 'flex';
            //     dom.style.justifyContent = 'space-between';
            //     dom.style.position = "absolute";
            //     dom.style.height = '25px';
            //     dom.style.cursor = 'pointer';
            //     let scale = this.scale;

            //     // dom.addEventListener( 'click', function ( event ) {

            //     //     editor.selectAnimation( layer );

            //     // } );
            //     dom.addEventListener( 'mousedown', function ( event ) {

            //         var movementX = 0;
            //         var movementY = 0;
            
            //         function onMouseMove( event ) {
            
            //             movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;
            
            //             layer.start += movementX / scale;
            //             layer.end += movementX / scale;
            
            //             if ( layer.start < 0 ) {
            
            //                 var offset = - layer.start;
            
            //                 layer.start += offset;
            //                 layer.end += offset;
            
            //             }
            
            //             // movementY += event.movementY | event.webkitMovementY | event.mozMovementY | 0;
            
            //             // if ( movementY >= 30 ) {
            
            //             //     animation.layer = animation.layer + 1;
            //             //     movementY = 0;
            
            //             // }
            
            //             // if ( movementY <= -30 ) {
            
            //             //     animation.layer = Math.max( 0, animation.layer - 1 );
            //             //     movementY = 0;
            
            //             // }
            
            //             vueInstance.signals.animationModified.dispatch( layer );
            
            //         }
            
            //         function onMouseUp( event ) {
            
            //             document.removeEventListener( 'mousemove', onMouseMove );
            //             document.removeEventListener( 'mouseup', onMouseUp );
            
            //         }
            
            //         document.addEventListener( 'mousemove', onMouseMove, false );
            //         document.addEventListener( 'mouseup', onMouseUp, false );
            
            //     }, false );

            //     var resizeLeft = document.createElement( 'div' );
            //     // resizeLeft.style.position = 'absolute';
            //     resizeLeft.style.width = '6px';
            //     resizeLeft.style.height = '20px';
            //     resizeLeft.style.cursor = 'w-resize';
            //     resizeLeft.addEventListener( 'mousedown', function ( event ) {

            //         event.stopPropagation();

            //         var movementX = 0;

            //         function onMouseMove( event ) {

            //             movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;

            //             layer.start += movementX / scale;

            //             vueInstance.signals.animationModified.dispatch( layer );

            //         }

            //         function onMouseUp( event ) {

            //             if ( Math.abs( movementX ) < 2 ) {

            //                 // editor.selectAnimation( layer );

            //             }

            //             document.removeEventListener( 'mousemove', onMouseMove );
            //             document.removeEventListener( 'mouseup', onMouseUp );

            //         }

            //         document.addEventListener( 'mousemove', onMouseMove, false );
            //         document.addEventListener( 'mouseup', onMouseUp, false );

            //     }, false );
        
            //     dom.appendChild( resizeLeft );

            //     var name = document.createElement( 'div' );
            //     name.className = 'name';
            //     name.id = "name-"+layerNumber;
            //     name.style.flexGrow = 1;

                
                

            //     dom.appendChild( name );
                

            //     var resizeRight = document.createElement( 'div' );
            //     // resizeRight.style.position = 'absolute';
            //     resizeRight.style.right = '0px';
            //     resizeRight.style.top = '0px';
            //     resizeRight.style.width = '6px';
            //     resizeRight.style.height = '20px';
            //     resizeRight.style.cursor = 'e-resize';
            //     resizeRight.addEventListener( 'mousedown', function ( event ) {

            //         event.stopPropagation();

            //         var movementX = 0;

            //         function onresizeRightMouseMove( event ) {

            //             movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;

            //             layer.end += movementX / scale;

            //             vueInstance.signals.animationModified.dispatch( layer );

            //         }

            //         function onResizeRightMouseUp( event ) {

            //             if ( Math.abs( movementX ) < 2 ) {

            //                 // editor.selectAnimation( layer );

            //             }

            //             document.removeEventListener( 'mousemove', onresizeRightMouseMove );
            //             document.removeEventListener( 'mouseup', onResizeRightMouseUp );

            //         }

            //         document.addEventListener( 'mousemove', onresizeRightMouseMove, false );
            //         document.addEventListener( 'mouseup', onResizeRightMouseUp, false );

            //     }, false );
            //     dom.appendChild( resizeRight );
            //     layerContainer.appendChild(dom); 
            //     this.scroller.appendChild(layerContainer); 
            //     this.updateLayerSize(layer.layerNumber);
            //     var wavesurfer = WaveSurfer.create({
            //         container: "#"+ "name-"+layerNumber,
            //         // barWidth: 3,
            //         // barHeight: 1, 
            //         waveColor: '#FFF',
            //         progressColor: '#FFF',
            //         fillParent:true,
            //         minPxPerSec: 50,
            //         pixelRatio: 1,
            //         autocenter: true
            //     });
            //     wavesurfer.load(layer.url);
            //     // dom.style.left = ( layer.start * scale ) + 'px';
            //     // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
            //     // dom.style.width = ( ( layer.end - layer.start ) * scale ) + 'px';

            //     // name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            //     this.resetDuration();
            //     this.initTimeline();
            //     this.updateTimeMark();
                

            // },

            

            
            
            
            
            
            
            
            
            
            
            
            
            
            

            

            

            
        
            
        },
    }
</script>