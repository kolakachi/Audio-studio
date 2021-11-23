new Vue({
    el: '#audio-editor',
    data: {
        languages: [],
        selectedLanguageId: 0,
        selectedLanguage: {},
        isLoading: false,
        loadingType: '',

        voices: [],
        selectedVoiceId: 0,
        selectedVoice: {},
        selectedFormat: 'mp3',

        player : {},
        signals: {},
        scale: 32,
        duration: 3600,
        prevScale:0,
        layers:[],
        scroller:{},
        canvas:{},
        loopMark:{},
        timeMark:{},
        playBtn:{},
        timeText:{},
        playbackRateText: {},
        prevTime: 0,
        currentInverval: {},
        audioUploadName: '',
        uploadedFile: {},
        recordingDone: false,
        mediaRecorder: {},
        audioChunks: [],
        audioBlob:{},
        audioUrl:{},
        audio:{},
        startTime: '',
        timeDisplay: '00:00',
        audioTimeReader: '00:00',
        refreshIntervalId: 0,
        isRecording: false,
        currentRange: 0,
        rangeMaximum: 0,
        currentPreviewRange: 0,
        previewRangeMaximum: 0,
        prevAudio:{},
        url: {
            synthesize: '',
            storeRecord: '',
            storeAudioUpload: '',
            export: ''
        },
        aplayer :{
            isPlaying: false
        },
        voicePreviewIsPlaying: false,
        prevSynthesizeAudioURL: '',
        prevSynthesizePath: ''

    },
    computed: {
        getVoices(){
            let voices = [];
            for(let key in this.voices){
                if(this.selectedLanguageId != 0){
                    if(this.voices[key].language_code == this.selectedLanguage.language_code){
                        voices.push(Object.assign({}, this.voices[key]));
                    }
                }
            }

            return voices;
        },
        getvoicePath(){
            

            return voicePath;
        }
         
    },
    
    mounted() {
        this.url.synthesize = $("#synthesize-url").val();
        this.url.storeRecord = $("#store-record-url").val();
        this.url.storeAudioUpload = $("#store-upload-url").val();
        this.url.export = $("#export-audio-url").val();
        this.player = new Player();
        this.languages = JSON.parse($("#languages").val());
        this.voices = JSON.parse($("#voices").val());
        this.selec
        this.signals = editorSignals;
        this.initTimeline();
        var range = document.getElementById("time-range");

        var listener = () => {
            window.requestAnimationFrame(() => {
                this.audio.currentTime = range.value
                // console.log(range.value);
            });
        };

        range.addEventListener("mousedown", function() {
            listener();
            range.addEventListener("mousemove", listener);
        });
        range.addEventListener("mouseup", function() {
            range.removeEventListener("mousemove", listener);
        });


        var previewRange = document.getElementById("preview-time-range");

        var prevAudioListener = () => {
            window.requestAnimationFrame(() => {
                this.prevAudio.currentTime = previewRange.value
                // console.log(range.value);
            });
        };

        previewRange.addEventListener("mousedown", function() {
            listener();
            previewRange.addEventListener("mousemove", prevAudioListener);
        });
        previewRange.addEventListener("mouseup", function() {
            previewRange.removeEventListener("mousemove", prevAudioListener);
        });

        // include the following line to maintain accessibility
        // by allowing the listener to also be fired for
        // appropriate keyboard events
        // range.addEventListener("keydown", listener);
        GreenAudioPlayer.init({
            selector: '.listen-result-player', // inits Green Audio Player on each audio container that has class "player"
            stopOthersOnPlay: false,
            showDownloadButton: false,
            showTooltips: true
        });

        
    },
    methods: {
        setFormat(type){
            this.selectedFormat = type;
        },
        playPreview(){
            this.prevAudio.addEventListener('timeupdate', (event) => {
                const currentTime = Math.floor(this.prevAudio.currentTime);
                const duration = Math.floor(this.prevAudio.duration);
                let newDuration = duration - currentTime;
                this.currentPreviewRange = currentTime;
            }, false);

            this.prevAudio.addEventListener('ended', (event) => {
                this.currentPreviewRange = this.prevAudio.duration;
            });
            if(this.voicePreviewIsPlaying){
                this.voicePreviewIsPlaying = false;
                this.prevAudio.pause();
            }else{
                this.voicePreviewIsPlaying = true
                this.prevAudio.play();

            }
        },
        setVoice(){
            this.prevAudio = document.getElementById('preview-audio');
            this.prevAudio.src = '';
            // source.stop();
            this.prevAudio.load();
            let voicePath = '';
            for(let key in this.voices){
                if(this.selectedVoiceId != 0){
                    if(this.voices[key].voice_id == this.selectedVoiceId && (this.voices[key].language_code == this.selectedLanguage.language_code)){
                        this.selectedVoice = Object.assign({}, this.voices[key]);

                        let name = this.voices[key].voice;
                        capitalisedName =  name.charAt(0).toUpperCase() + name.slice(1);
                        voicePath = capitalisedName +" ("+ this.voices[key].gender + ").mp3";
                        this.prevAudio.src = '/voices/azure-new/' + voicePath;
                        this.prevAudio.load();
                        this.prevAudio.addEventListener("loadedmetadata", e => {
                            this.previewRangeMaximum = Math.floor(this.prevAudio.duration);
                        })
                    }
                }
            }
        },
        setSelectedLanguage(){
            for(let key in this.languages){
                if(this.languages[key].id == this.selectedLanguageId){
                    this.selectedLanguage = Object.assign({}, this.languages[key]);
                }
            }
        },
        startRecording(){
            navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                this.mediaRecorder = new MediaRecorder(stream);
                this.isRecording = true;
                this.mediaRecorder.start();
                this.startTime=Date.now();
                this.refreshIntervalId = window.setInterval(this.updateDateTime, 200);
                this.mediaRecorder.addEventListener("dataavailable", event => {
                    this.audioChunks.push(event.data);
                });

                this.mediaRecorder.addEventListener("stop", () => {
                    this.audioBlob = new Blob(this.audioChunks, { 'type': 'audio/webm;' });
                    this.audioUrl = URL.createObjectURL(this.audioBlob);
                    $("#audio-id").attr('src', this.audioUrl);
                    this.audio = new Audio(this.audioUrl);
                    
                });
                
            });
            
        },
        stopRecording(){
            this.recordingDone = true;
            this.mediaRecorder.stop();
            clearInterval(this.refreshIntervalId);
        },
        updateDateTime() {
            var sec;
            sec = this.recordingTime() | 0;
            this.rangeMaximum = sec;
            this.timeDisplay = "" + (this.minSecStr(sec / 60 | 0)) + ":" + (this.minSecStr(sec % 60));
        },
        minSecStr(n) {
            return (n < 10 ? "0" : "") + n;
        },
        recordingTime(){
            return this.recordingDone != true? (Date.now()-this.startTime) * .001 : null
        },
        playRecording(){
            this.audio.addEventListener('timeupdate', (event) => {
                const currentTime = Math.floor(this.audio.currentTime);
                const duration = Math.floor(this.audio.duration);
                let newDuration = duration - currentTime;
                this.currentRange = currentTime;

                let sec = Math.floor( currentTime );
                let min = Math.floor( sec / 60 );
                min = min >= 10 ? min : '0' + min;
                sec = Math.floor( sec % 60 );
                sec = sec >= 10 ? sec : '0' + sec;
                this.audioTimeReader = min + ":"+ sec;
            }, false);

            this.audio.addEventListener('ended', (event) => {
                this.currentRange = this.audio.duration;
            });
            this.audio.play();
        },
        initTimeline(){
            var keysDown = {};
            document.addEventListener( 'keydown', function ( event ) { keysDown[ event.keyCode ] = true; } );
            document.addEventListener( 'keyup',   function ( event ) { keysDown[ event.keyCode ] = false; } );
            this.scale = 32;
            this.prevScale = this.scale;
            this.loopMark = document.getElementById("loop-mark");
            this.timeMark = document.getElementById("time-mark");
            this.scroller = document.getElementById("scroller");
            this.canvas = document.getElementById("timeline-canvas");
            this.playBtn = document.getElementById("play-btn");
            this.timeText = document.getElementById("time-text");
            this.playbackRateText = document.getElementById("rate-text");
            this.layerContainer = document.getElementById("layer-container");

            this.initTimelineCanvas();
            this.createTimeMarkImage();
            this.initScroller();
            this.updateMarks();
            requestAnimationFrame( this.animate );
            this.initTimelineSignals();

            // $("#media-file").change(this.getMediaUploaded);


        },
        handleTimelineWrapperWheelEvent(event){
            if ( event.altKey === true ) {

                event.preventDefault();
        
                this.scale = Math.max( 2, this.scale + ( event.deltaY / 10 ) );
        
                this.signals.timelineScaled.dispatch( this.scale );
        
            }
        },
        initTimelineCanvas(){
            var vueInstance = this;
            this.canvas.addEventListener( 'mousedown', function ( event ) {

                event.preventDefault();

                function onMouseMove( event ) {
                    vueInstance.setTime( ( event.offsetX + vueInstance.scroller.scrollLeft ) / vueInstance.scale );

                }

                function onMouseUp( event ) {

                    onMouseMove( event );

                    document.removeEventListener( 'mousemove', onMouseMove );
                    document.removeEventListener( 'mouseup', onMouseUp );

                }

                document.addEventListener( 'mousemove', onMouseMove, false );
                document.addEventListener( 'mouseup', onMouseUp, false );

            }, false );
        },
        initScroller(){
            this.scroller.addEventListener( 'scroll',  ( event ) => {
                this.updateMarks();
                this.updateTimeMark();

            }, false );
        },
        updateMarks() {
            this.canvas.width = this.scroller.clientWidth;
        
            var context = this.canvas.getContext( '2d', { alpha: false } );
        
            context.fillStyle = '#141532';
            context.fillRect( 0, 0, this.canvas.width, this.canvas.height );
        
            context.strokeStyle = '#797fae';
            context.beginPath();
        
            context.translate( - this.scroller.scrollLeft, 0 );
        
            // var duration = 100;//editor.duration;
            var width = this.duration * this.scale;
            var scale4 = this.scale / 4;
        
            for ( var i = 0.5; i <= width; i += this.scale ) {
                context.moveTo( i + ( scale4 * 0 ), 18 ); context.lineTo( i + ( scale4 * 0 ), 26 );
        
                if ( this.scale > 16 ) context.moveTo( i + ( scale4 * 1 ), 22 ), context.lineTo( i + ( scale4 * 1 ), 26 );
                if ( this.scale >  8 ) context.moveTo( i + ( scale4 * 2 ), 22 ), context.lineTo( i + ( scale4 * 2 ), 26 );
                if ( this.scale > 16 ) context.moveTo( i + ( scale4 * 3 ), 22 ), context.lineTo( i + ( scale4 * 3 ), 26 );
        
            }
        
            context.stroke();
        
            context.font = '10px Arial';
            context.fillStyle = '#888'
            context.textAlign = 'center';
        
            var step = Math.max( 1, Math.floor( 64 / this.scale ) );
        
            for ( var i = 0; i < this.duration; i += step ) {
        
                var minute = Math.floor( i / 60 );
                var second = Math.floor( i % 60 );
        
                var text = ( minute > 0 ? minute + ':' : '' ) + ( '0' + second ).slice( - 2 );
        
                context.fillText( text, i * this.scale, 13 );
        
            }
        
        },
        updateTimeMark() {

            
            var offsetLeft = ( this.player.currentTime * this.scale ) - this.scroller.scrollLeft - 8;
        
            this.timeMark.style.left = offsetLeft + 'px';
        
            var loop = this.player.getLoop();
        
            if ( Array.isArray( loop ) ) {
        
                var loopStart = loop[ 0 ] * this.scale;
                var loopEnd = loop[ 1 ] * this.scale;
        
                this.loopMark.style.display = '';
                this.loopMark.style.left = ( loopStart - this.scroller.scrollLeft ) + 'px';
                this.loopMark.style.width = ( loopEnd - loopStart ) + 'px';
        
            } else {
        
                this.loopMark.style.display = 'none';
        
            }
        
        },
        createTimeMarkImage() {

            var markCanvas = document.getElementById("timeline-mark-canvas");
        
            var context = markCanvas.getContext( '2d' );
            context.fillStyle = '#f00';
            context.beginPath();
            context.moveTo( 2, 0 );
            context.lineTo( 14, 0 );
            context.lineTo( 14, 10 );
            context.lineTo( 8, 16 );
            context.lineTo( 2, 10 );
            context.lineTo( 2, 0 );
            context.fill();
        
            // return canvas;
        
        },
        initTimelineSignals(){
            this.signals.timeChanged.add(  () => {

                this.updateTimeMark();
            
            });

            this.signals.timelineScaled.add(  ( value ) => {

                this.scale = value;
            
                this.scroller.scrollLeft = ( this.scroller.scrollLeft * value ) / this.prevScale;
            
                this.updateMarks();
                this.updateTimeMark();
                this.updateContainers();
            
                this.prevScale = value;
            
            } );

            this.signals.windowResized.add(  () => {

                this.updateMarks();
                this.updateContainers();
            
            } );

            this.signals.playingChanged.add( ( isPlaying ) => {

                this.playBtn.style.background = isPlaying ? 'url(files/pause.svg)' : 'url(files/play.svg)';
                if(isPlaying){
                    
                    this.currentInverval  = setInterval(() =>{
                          this.playAudios();
                        
                    }, 1);
                }else{
                    this.stopAllPlays();
                }
            
            } );

            this.signals.timeChanged.add(  ( value ) => {

                this.updateTimeText( value );
            
            } );
            this.signals.playbackRateChanged.add(  ( value ) => {

                this.updatePlaybackRateText( value );
            
            } );

            this.signals.animationModified.add( (layer) => {
                this.updateLayerSize(layer.layerNumber);
                this.updateMarks();
                this.updateTimeMark();
                
            })
        },

        handleControlClick(type){
            if(type == 'prev'){
                this.setTime( this.player.currentTime - 1 );
            }

            if(type == 'play'){
                this.player.isPlaying ? this.stop() : this.play();
            }

            if(type == 'next'){
                this.setTime( this.player.currentTime + 1 );
            }
        },

        updateTimeText( value ) {

            var minutes = Math.floor( value / 60 );
            var seconds = value % 60;
            var padding = seconds < 10 ? '0' : '';
        
            this.timeText.innerHTML =  minutes + ':' + padding + seconds.toFixed( 2 ) ;
        
        },
        updatePlaybackRateText( value ) {

            this.playbackRateText.innerHTML = value.toFixed( 1 ) + 'x' ;
        
        },

        setTime ( time ) {

            this.player.currentTime = Math.max( 0, time );
            this.signals.timeChanged.dispatch( this.player.currentTime );
        
        },
        
        play () {
            this.player.play();
            this.aplayer.isPlaying = true
            this.signals.playingChanged.dispatch( true );
        
        },
        
        stop () {
            this.player.pause();
            this.aplayer.isPlaying = false
            this.signals.playingChanged.dispatch( false );
        
        },

        animate( time ) {

            this.player.tick( time - this.prevTime );
    
            if ( this.player.isPlaying ) {
    
                this.signals.timeChanged.dispatch( this.player.currentTime );
    
            }
    
            this.prevTime = time;
    
            requestAnimationFrame( this.animate );
    
        },

        activateFileUploader(){
            $("#media-file").click();
        },

        getMediaUploaded(event){
            this.uploadedFile = event.currentTarget.files[0];
            this.audioUploadName = this.uploadedFile.name;
            // if(file.type.includes("video")){
            //     this.addVideoLayer(file);
            // }
               
            
            
        },
        cancelFileUploader(){
            this.uploadedFile = {}
            this.audioUploadName = ""
        },
        addUploadedAudioToTimeline(){
            if(this.uploadedFile.type.includes("audio")){
                const formData = new FormData();

                formData.append('_token', $('input[name=_token]').val());
                formData.append('uploaded_audio', this.uploadedFile);
                this.isLoading = true;
                this.loadingType = "audioUpload";
                axios.post(this.url.storeAudioUpload, formData)
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";

                        let path = response.data.path;
                        this.addAudioLayer(this.uploadedFile, path);
                        this.uploadedFile = {}
                        this.audioUploadName = "";
                        $("#addMusicTrackModal").modal('hide');
                    
                        
                        this.$notify({
                            title: 'Success',
                            message: response.data.message,
                            type: 'success'
                        });
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";

                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                    })

                

            }
        },
        addRecordedAudio(){
            const formData = new FormData();

            formData.append('_token', $('input[name=_token]').val());
            formData.append('recorded_audio', this.audioBlob);

            this.isLoading = true;
            this.loadingType = "addRecordedAudio"
            axios.post(this.url.storeRecord, formData)
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = ""

                    let path = response.data.path;
                    // console.log(response.data)
                    $("#recordModal").modal('hide');
                    this.addAudioRecorderToLayer(this.audioBlob, path);
                    this.clearRecording();
                
                    
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.loadingType = ""

                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                })
            // var myModal = new bootstrap.Modal(document.getElementById("recordModal"), {});
            // document.onreadystatechange = function () {
            //     myModal.hide();
            // };
            // $("#recordModal").modal('hide');
            // this.addAudioRecorderToLayer(this.audioBlob);
            // this.clearRecording();
        },
        clearRecording(){
            this.recordingDone = false;
            this.mediaRecorder = {};
            this.audioChunks = [];
            this.audioBlob = {};
            this.audioUrl = {};
            this.audio = {};
            this.startTime = '';
            this.timeDisplay = '00:00';
            this.audioTimeReader = '00:00';
            this.refreshIntervalId = 0;
            this.isRecording = false;
            this.currentRange = 0;
            this.rangeMaximum = 0;
        },
        addTranslatedAudioToLayer(link, path){
            var objectUrl = link;
            var audioConatiner = document.getElementById("audio-container");
            var newAudio = document.createElement("AUDIO");
            var audioID = 'audio-'+ this.layers.length;
            newAudio.id       = audioID;
            newAudio.src      = objectUrl;
            newAudio.type     = 'audio/mp3';//file.type;
            newAudio.controls = 'controls';
            audioConatiner.appendChild(newAudio);
            newAudio = document.getElementById(audioID);
            $("#"+audioID).on("loadedmetadata", (e) =>{
                var seconds = newAudio.duration;
                let layer = {
                    type : "audio",
                    name : "recording-" + audioID,
                    url: objectUrl,
                    id: audioID,
                    path: path,
                    duration: newAudio.duration,
                    start: this.player.currentTime,
                    end: seconds,
                    layerNumber: this.layers.length
    
                }
                // if(!this.layers[this.layers.length]){
                    this.layers.push(layer);
                    this.addLayerToTimeLine(layer.layerNumber);
                // }
                
            });
            
            
        },
        addAudioRecorderToLayer(file, path){
            var objectUrl = URL.createObjectURL(file);
            var audioConatiner = document.getElementById("audio-container");
            var newAudio = document.createElement("AUDIO");
            var audioID = 'audio-'+ this.layers.length;
            newAudio.id       = audioID;
            newAudio.src      = objectUrl;
            newAudio.type     = file.type;
            newAudio.controls = 'controls';
            audioConatiner.appendChild(newAudio);
            newAudio = document.getElementById(audioID);
            $("#"+audioID).on("loadedmetadata", (e) =>{
                var seconds = e.currentTarget.duration;
                let layer = {
                    type : "audio",
                    name : "recording-" + audioID,
                    url: objectUrl,
                    id: audioID,
                    path: path,
                    duration: seconds,
                    start: this.player.currentTime,
                    end: seconds,
                    layerNumber: this.layers.length
    
                }
                // if(!this.layers[this.layers.length]){
                    this.layers.push(layer);
                    this.addLayerToTimeLine(layer.layerNumber);
                // }
                
            });
            
            
        },
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
        addAudioLayer(file, path){
            var objectUrl = URL.createObjectURL(file);
            var audioConatiner = document.getElementById("audio-container");
            var newAudio = document.createElement("AUDIO");
            var audioID = 'audio-'+ this.layers.length;
            newAudio.id       = audioID;
            newAudio.src      = objectUrl;
            newAudio.type     = file.type;
            newAudio.controls = 'controls';
            audioConatiner.appendChild(newAudio);
            newAudio = document.getElementById(audioID);
            $("#"+audioID).on("loadedmetadata", (e) =>{
                var seconds = e.currentTarget.duration;
                let layer = {
                    type : "audio",
                    name : (file.name == 0)? "recording-" : file.name,
                    id: audioID,
                    url: objectUrl,
                    path: path,
                    duration: seconds,
                    start: this.player.currentTime,
                    end: seconds,
                    layerNumber: this.layers.length
    
                }
                // if(!this.layers[this.layers.length]){
                    this.layers.push(layer);
                    this.addLayerToTimeLine(layer.layerNumber);
                // }
                
            });
            
            
        },
        addLayerToTimeLine(layerNumber){
            var layer = this.layers[layerNumber];
            let vueInstance = this;
            
            var layerContainer = document.createElement( 'div' );
            layerContainer.id = "layer-container-"+layerNumber;
            layerContainer.style.position = "relative";
            layerContainer.style.height = '23px';
            // layerContainer.style.padding = '4px';
            layerContainer.style.border = '1px solid #FFF';

            layerContainer.style.width = '3000px';
            
            var dom = document.createElement( 'div' );
            dom.className = 'block';
            dom.id = "dom-"+layerNumber;
            dom.style.display = 'flex';
            dom.style.justifyContent = 'space-between';
            dom.style.position = "absolute";
            dom.style.height = '20px';
            dom.style.cursor = 'pointer';
            let scale = this.scale;
            // dom.addEventListener( 'click', function ( event ) {

            //     editor.selectAnimation( layer );

            // } );
            dom.addEventListener( 'mousedown', function ( event ) {

                var movementX = 0;
                var movementY = 0;
        
                function onMouseMove( event ) {
        
                    movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;
        
                    layer.start += movementX / scale;
                    layer.end += movementX / scale;
        
                    if ( layer.start < 0 ) {
        
                        var offset = - layer.start;
        
                        layer.start += offset;
                        layer.end += offset;
        
                    }
        
                    // movementY += event.movementY | event.webkitMovementY | event.mozMovementY | 0;
        
                    // if ( movementY >= 30 ) {
        
                    //     animation.layer = animation.layer + 1;
                    //     movementY = 0;
        
                    // }
        
                    // if ( movementY <= -30 ) {
        
                    //     animation.layer = Math.max( 0, animation.layer - 1 );
                    //     movementY = 0;
        
                    // }
        
                    vueInstance.signals.animationModified.dispatch( layer );
        
                }
        
                function onMouseUp( event ) {
        
                    document.removeEventListener( 'mousemove', onMouseMove );
                    document.removeEventListener( 'mouseup', onMouseUp );
        
                }
        
                document.addEventListener( 'mousemove', onMouseMove, false );
                document.addEventListener( 'mouseup', onMouseUp, false );
        
            }, false );

            var resizeLeft = document.createElement( 'div' );
            // resizeLeft.style.position = 'absolute';
            resizeLeft.style.width = '6px';
            resizeLeft.style.height = '20px';
            resizeLeft.style.cursor = 'w-resize';
            resizeLeft.addEventListener( 'mousedown', function ( event ) {

		        event.stopPropagation();

		        var movementX = 0;

                function onMouseMove( event ) {

                    movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;

                    layer.start += movementX / scale;

                    vueInstance.signals.animationModified.dispatch( layer );

                }

                function onMouseUp( event ) {

                    if ( Math.abs( movementX ) < 2 ) {

                        // editor.selectAnimation( layer );

                    }

                    document.removeEventListener( 'mousemove', onMouseMove );
                    document.removeEventListener( 'mouseup', onMouseUp );

                }

                document.addEventListener( 'mousemove', onMouseMove, false );
                document.addEventListener( 'mouseup', onMouseUp, false );

            }, false );
	
            dom.appendChild( resizeLeft );

	        var name = document.createElement( 'div' );
	        name.className = 'name';
            name.id = "name-"+layerNumber;

	        dom.appendChild( name );

            var resizeRight = document.createElement( 'div' );
            // resizeRight.style.position = 'absolute';
            resizeRight.style.right = '0px';
            resizeRight.style.top = '0px';
            resizeRight.style.width = '6px';
            resizeRight.style.height = '20px';
            resizeRight.style.cursor = 'e-resize';
            resizeRight.addEventListener( 'mousedown', function ( event ) {

		        event.stopPropagation();

		        var movementX = 0;

                function onresizeRightMouseMove( event ) {

                    movementX = event.movementX | event.webkitMovementX | event.mozMovementX | 0;

                    layer.end += movementX / scale;

                    vueInstance.signals.animationModified.dispatch( layer );

                }

                function onResizeRightMouseUp( event ) {

                    if ( Math.abs( movementX ) < 2 ) {

                        // editor.selectAnimation( layer );

                    }

                    document.removeEventListener( 'mousemove', onresizeRightMouseMove );
                    document.removeEventListener( 'mouseup', onResizeRightMouseUp );

                }

                document.addEventListener( 'mousemove', onresizeRightMouseMove, false );
                document.addEventListener( 'mouseup', onResizeRightMouseUp, false );

	        }, false );
	        dom.appendChild( resizeRight );
            layerContainer.appendChild(dom); 
            this.scroller.appendChild(layerContainer); 
            this.updateLayerSize(layer.layerNumber);
            // dom.style.left = ( layer.start * scale ) + 'px';
		    // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
		    // dom.style.width = ( ( layer.end - layer.start ) * scale ) + 'px';

		    // name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            

        },

        updateLayerSize(layerNumber){
            var layer = this.layers[layerNumber];
            var dom = document.getElementById("dom-"+layerNumber);//layer.dom;
            var name = document.getElementById("name-"+layerNumber);//layer.domName; 
            dom.style.left = ( layer.start * this.scale ) + 'px';
		    // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
		    dom.style.width = ( ( layer.end - layer.start ) * this.scale ) + 'px';

		    name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            // this.layerContainer.appendChild(dom); 
                this.timeMark.style.height = document.getElementById("timeline").offsetHeight - 18 + "px";
        },
        playAudios(){
            let duration = this.duration;
            let highestLayerDuration = 0;
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.end > highestLayerDuration){
                    highestLayerDuration = layer.end;
                }
                if(layer.type == 'audio'){

                    if(layer.start <= this.player.currentTime && layer.end >= this.player.currentTime){
                        let audio = document.getElementById('audio-'+ layer.layerNumber);
                        if(audio){
                            if(audio.paused && !audio.ended){
                                let audioTime = this.player.currentTime - layer.start;
                                audio.currentTime = audioTime;
                                audio.play();
                            }
                        }
                    }else{
                        let audio = document.getElementById('audio-'+ layer.layerNumber);
                        if(audio){
                            audio.pause();
                        }
                    }
                }
            }
            if(this.player.currentTime > highestLayerDuration){
                this.stop();
            }
        },
        stopAllPlays(){
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.type == 'audio'){
                    let audio = document.getElementById('audio-'+ layer.layerNumber);
                    if(audio){
                        audio.pause();
                        clearInterval(this.currentInverval);
                    }
                }
            }
        },
        sayAs(type){
            this.ssmlText(`<say-as interpret-as='${type}'>`, "</say-as>");
        },
        setVolume(type){
            this.ssmlText(`<prosody volume='${type}'>`, "</prosody>");
        },

        setSpeed(type){
            this.ssmlText(`<prosody rate='${type}'>`, "</prosody>");
        },

        setPitch(type){
            this.ssmlText(`<prosody pitch='${type}'>`, "</prosody>");
        },

        setPause(type){
            this.ssmlText(`<break time='${type}'>`, "");
        },
        setParagraphPause(){
            this.ssmlText(`<p>`, "</p>");
        },
        setSentencePause(){
            this.ssmlText(`<s>`, "</s>");
        },

        ssmlText(openTag, closeTag) {

            "use strict";
        
            var textarea = $('#audio-textarea');
            var length = textarea.val().length;
            var start = textarea[0].selectionStart;
            var end = textarea[0].selectionEnd;
            var selectedText = textarea.val().substring(start, end);
            var replacement = openTag + selectedText + closeTag;
            textarea.val(textarea.val().substring(0, start) + replacement + textarea.val().substring(end, length));
        },
        synthesize(type){
            const formData = new FormData();

            formData.append('_token', $('input[name=_token]').val());
            formData.append('textarea', $("#audio-textarea").val());
            formData.append('title', "new-title");
            formData.append('voice', this.selectedVoice.voice_id);
            formData.append('format', this.selectedFormat);
            formData.append('language', this.selectedLanguage.language_code);

            this.isLoading = true;
            this.loadingType = type;
            
            axios.post(this.url.synthesize, formData)
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = '';
                    let audioURL = response.data.url;
                    let path = response.data.path;
                    if(type == 'listen'){
                        var audio = document.getElementById('listen-result');
                        var source = document.getElementById('listen-source');
                        audio.src = audioURL;
                        this.prevSynthesizeAudioURL = audioURL;
                        this.prevSynthesizePath = path;
                        // source.type= data['audio_type'];
                        $("#listenModal").modal('show');
                    }else{
                        this.addTranslatedAudioToLayer(audioURL, path);
                    }
                   
                    
                    this.$notify({
                        title: 'Success',
                        message: response.data.message,
                        type: 'success'
                    });
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.loadingType = '';

                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                })
        },
        addPreviewToTimeLine(){
            this.addTranslatedAudioToLayer(this.prevSynthesizeAudioURL, this.prevSynthesizePath);

        },
        exportAudio(){
            if(this.layers.length > 0){
                const formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('layers', JSON.stringify(this.layers));
                this.isLoading = true;
                this.loadingType = "export";
                axios.post(this.url.export, formData, {responseType: 'blob'})
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";

                        let blob = new Blob([response.data], { type: 'audio/mp3' })
                        let link = document.createElement('a')
                        link.href = window.URL.createObjectURL(blob)
                        link.download = 'download.mp3'
                        link.click()

                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";

                        console.log(error);
                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                    })
            }

            
            
        },
    },

    
});