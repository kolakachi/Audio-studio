function Pdf2TextClass(){
    var self = this;
    this.complete = 0;

    this.pdfToText = function(data, callbackPageDone, callbackAllDone){
        console.assert( data  instanceof ArrayBuffer  || typeof data == 'string' );
        var loadingTask = pdfjsLib.getDocument(data);
        loadingTask.promise.then(function(pdf) {


            var total = pdf._pdfInfo.numPages;
            //callbackPageDone( 0, total );        
            var layers = {};       
            for (i = 1; i <= total; i++){
                pdf.getPage(i).then( function(page){
                    var n = page.pageNumber;
                    page.getTextContent().then( function(textContent){
                    
                        if( null != textContent.items ){
                            var page_text = "";
                            var last_block = null;
                            for( var k = 0; k < textContent.items.length; k++ ){
                                var block = textContent.items[k];
                                if( last_block != null && last_block.str[last_block.str.length-1] != ' '){
                                    if( block.x < last_block.x )
                                        page_text += "\r\n"; 
                                    else if ( last_block.y != block.y && ( last_block.str.match(/^(\s?[a-zA-Z])$|^(.+\s[a-zA-Z])$/) == null ))
                                        page_text += ' ';
                                }
                                page_text += block.str;
                                last_block = block;
                            }

                            // textContent != null && console.log("page " + n + " finished."); //" content: \n" + page_text);
                            layers[n] =  page_text + "\n\n";
                        }
                        ++ self.complete;
                        //callbackPageDone( self.complete, total );
                        if (self.complete == total){
                            callbackPageDone(layers);

                        // window.setTimeout(function(){
                        //     var full_text = "";
                        //     var num_pages = Object.keys(layers).length;
                        //     for( var j = 1; j <= num_pages; j++)
                        //         full_text += layers[j] ;
                        //     // console.log(full_text);
                        // }, 1000);              
                        }
                    }); // end  of page.getTextContent().then
                }); // end of page.then
            } // of for
        });
    }; // end of pdfToText()
};
Vue.use(VeeValidate, {events: 'change|blur'});

new Vue({
    el: '#audio-editor',
    data: {
        languages: [],
        languageIdError:"",
        voiceIdError:"",
        selectedLanguageId: 0,
        selectedLanguage: {},
        isLoading: false,
        loadingType: '',
        edit_id:'',
        edit_name: '',
        voices: [],
        selectedVoiceId: 0,
        selectedVoice: {},
        selectedFormat: 'mp3',
        speech_text: '',
        player : {},
        signals: {},
        scale: 12,
        duration: 100,
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
            export: '',
            save:'',
            audioURL:''
        },
        aplayer :{
            isPlaying: false
        },
        voicePreviewIsPlaying: false,
        prevSynthesizeAudioURL: '',
        prevSynthesizePath: '',
        teleprompter: {
            currentStep:1,
            step : 1,
            scspeed : 20,
            status :1,
            spind :4,
            fontSize: 14,
            speedSize:1,
            text: `At Railslove, we can look back on a long tradition of projects that have at least always had something to do with payment transactions. In addition to credit card payments, wallets and Bitcoin, direct bank integrations are also repeatedly requested. There are two standards that enable programmatic access to bank accounts: HBCI/FinTS and EBICS . To introduce a very rough distinction: the former is more popular in the area of ​​home banking software, while the latter is more tailored to the needs of business customers.

            "Banking is hard"
            
            Random dude on the street
            With EBICS, for example, account statements in different formats ( MT940 , CAMT) can be called up automatically, but the submission of SEPA direct debits and SEPA transfers is also made possible through EBICS access. Unfortunately, not all banks offer their customers EBICS access, and most banks also charge a one-time or monthly fee.
            
            Another point which, in our opinion, has made EBICS unattractive, especially for start-ups and smaller companies, is the integration of EBICS into new web applications, since the landscape of EBICS implementations is very much dominated by commercial offers and usually Java - and/or Windows systems served. Unfortunately, the existing libraries for Ruby are just as sparse, so two months ago we set ourselves the goal of developing THE EBICS implementation for Ruby. The entire standard is freely available, but there is no reliable reference implementation. With the exception of 350 pages of PDF and a few XML examples, you are largely on your own.
            
            Actually, I would have expected to be overwhelmed by strange proprietary solutions and idiosyncratic formats, but the opposite was actually the case :-). Sure, it seems as if the associated committee has once driven the shopping cart through a large standard shopping mall, but nevertheless everything fits together to form a thoroughly sensible overall picture. Among other things, AES encryption, RSA signature procedures and XMLSIG are used.
            
            So what remains is a lot of hard work and a lot of trial and error . The most difficult part proved to be the necessary signature of the order data: Although RSA is used for this, the OpenSSL implementation of Ruby does not (yet) support RSA-EMSA-PSS. This part still had to be implemented.
            
            The basic functions of the standard can already be addressed with our EPICS Gem , the next big item is the "distributed signature" on the program, which I think is a very interesting feature, in which order data must be digitally signed by several participants before they processed by the bank. Complex scenarios such as a "four-eyes principle" are thus built directly into the standard. Interestingly, a very similar function (both technically and conceptually) was included in the Bitcoin protocol in the form of multi signature addresses .
            
            Based on the EBICS client, we offer different solutions that make it even easier to connect an existing application to the EBICS system. Would you like to find out more? Talk to us!
            
            Take a look at: https://github.com/railslove/epics
            
            Railslove is a full-service Web Development Agency for all things Ruby and Rails, with a heavy focus on financial applications`
        }

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
        this.url.save = $("#save-config-url").val();
        this.url.audioURL = $("#audio-full-url").val() + "/";
        this.player = new Player();
        this.languages = JSON.parse($("#languages").val());
        this.voices = JSON.parse($("#voices").val());
        let audio = JSON.parse($("#audio-details").val());
        this.edit_id = audio.uuid;
        this.edit_name = audio.audio_name;
        this.layers = audio.layers;
        this.speech_text = audio.speech_text;

        this.signals = editorSignals;
        this.resetDuration();
        this.initTimeline();
        var range = document.getElementById("time-range");

        var listener = () => {
            window.requestAnimationFrame(() => {
                this.audio.currentTime = range.value
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
        this.initLayers();

        
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
        resetDuration(){
            if(this.layers.length > 0 ){
                let highestLayerDuration = 0;
                for(let i in this.layers){
                    let layer = this.layers[i];
                    if(layer.end > highestLayerDuration){
                        highestLayerDuration = layer.end;
                    }
                }
                console.log(this.duration, highestLayerDuration);
                this.duration = highestLayerDuration;
            }
        },
        initTimeline(){
            var keysDown = {};
            document.addEventListener( 'keydown', function ( event ) { keysDown[ event.keyCode ] = true; } );
            document.addEventListener( 'keyup',   function ( event ) { keysDown[ event.keyCode ] = false; } );
            // this.scale = 16;
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
                console.log(this.player.isPlaying);

                if(!isPlaying){
                    this.stopAllPlays();
                }else{
                    this.playAudios();
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
            this.updateAllPlays();
            this.signals.timeChanged.dispatch( this.player.currentTime );
            
        
        },
        zoomOut(){
            this.scale = this.scale - 4;
            this.prevScale = this.scale;
            this.initTimeline();
            this.initLayers();
        },
        zoomIn(){
            this.scale =  this.scale + 4;
            this.prevScale = this.scale;
            this.initTimeline();
            this.initLayers();
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
                this.playAudios();
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
                    $("#recordModal").modal('hide');
                    let duration = this.rangeMaximum;
                    this.addAudioRecorderToLayer(this.audioBlob, path, duration - 1);
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
                    volume: 1,
                    layerNumber: this.layers.length
    
                }
                // if(!this.layers[this.layers.length]){
                    this.layers.push(layer);
                    this.addLayerToTimeLine(layer.layerNumber);
                // }
                
            });
            
            
        },
        addAudioRecorderToLayer(file, path, duration){
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
                var seconds = duration;//e.currentTarget.duration;
                let layer = {
                    type : "audio",
                    htmlType: file.type,
                    name : "recording-" + audioID,
                    url: objectUrl,
                    id: audioID,
                    path: path,
                    duration: seconds,
                    start: this.player.currentTime,
                    end: seconds,
                    volume: 1,
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
                    htmlType: file.type,
                    name : (file.name == 0)? "recording-" : file.name,
                    id: audioID,
                    url: objectUrl,
                    path: path,
                    duration: seconds,
                    start: this.player.currentTime,
                    end: seconds,
                    volume: 1,
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
            console.log(layer);
            let vueInstance = this;
            
            var layerContainer = document.createElement( 'div' );
            layerContainer.id = "layer-container-"+layerNumber;
            layerContainer.style.position = "relative";
            layerContainer.style.height = '30px';
            // layerContainer.style.padding = '4px';
            // layerContainer.style.border = '1px solid #FFF';

            layerContainer.style.width = (this.duration * this.scale) +'px';
            
            var dom = document.createElement( 'div' );
            dom.className = 'block';
            dom.id = "dom-"+layerNumber;
            dom.style.display = 'flex';
            dom.style.justifyContent = 'space-between';
            dom.style.position = "absolute";
            dom.style.height = '25px';
            dom.style.cursor = 'pointer';
            let scale = this.scale;
            console.log(dom);

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
            var wavesurfer = WaveSurfer.create({
                container: "#"+ dom.id,
                barWidth: 3,
                barHeight: 1, 
                waveColor: '#FFF',
                progressColor: '#FFF'
            });
            wavesurfer.load(layer.url);
            // dom.style.left = ( layer.start * scale ) + 'px';
		    // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
		    // dom.style.width = ( ( layer.end - layer.start ) * scale ) + 'px';

		    // name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            

        },

        setAudioVolume(index){
            let layer = this.layers[index];
            console.log(layer)
            let audioID  = layer.id;
            $("#" + audioID).prop("volume", layer.volume);

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
            let highestLayerDuration = this.duration;
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.end > highestLayerDuration){
                    highestLayerDuration = layer.end;
                }
                if(layer.type == 'audio'){
                    if(layer.start <= this.player.currentTime && layer.end >= this.player.currentTime){
                        let audio = document.getElementById('audio-'+ layer.layerNumber);
                        if(audio){
                           
                            var audioIsPlaying = audio.currentTime > 0 && !audio.paused && !audio.ended 
                            && audio.readyState > audio.HAVE_CURRENT_DATA;
                            if (!audioIsPlaying && this.player.isPlaying) {
                                audio.play();
                            }
                        }
                    }else{
                        let audio = document.getElementById('audio-'+ layer.layerNumber);
                        if(audio){
                            audio.pause();
                            // audio.currentTime = 0;
                        }
                    }
                }
            }
            if(this.player.currentTime > highestLayerDuration){
                this.stop();
            }
        },
        updateAllPlays(){
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.type == 'audio'){
                    let audio = document.getElementById('audio-'+ layer.layerNumber);
                    let audioTime = this.player.currentTime - layer.start;
                    if(audioTime < 0){
                        audio.currentTime = 0;
                    }
                    console.log([audio.currentTime, audioTime, this.player.currentTime, layer.start])
                    if(layer.start <= this.player.currentTime && layer.end >= this.player.currentTime){
                        
                       
                        audioTime =parseFloat(parseFloat(audioTime).toFixed(7));
                        if(parseFloat(parseFloat(audio.currentTime).toFixed(3)) != parseFloat(parseFloat(audioTime).toFixed(3))){
                            audio.currentTime = audioTime;
                            console.log([audio.currentTime, audioTime])
                        }
                        // if(audio && (audioTime > -1)){
                        //     audioTime =parseFloat(parseFloat(audioTime).toFixed(7));
                        //     if(parseFloat(parseFloat(audio.currentTime).toFixed(7)) != parseFloat(parseFloat(audioTime).toFixed(3))){
                        //         audio.currentTime = audioTime;
                        //         // let audioHandler = function() {
                        //         //     audio.currentTime = audioTime;
                        //         //     console.log(audioTime);
                        //         // };
                        //         // audio.addEventListener('canplay',audioHandler);

                        //         // //remove listener 
                        //         // audio.removeEventListener('canplay',audioHandler);
                        //     }

                            
                        //     // console.log(audio.get(0).currentTime);
                        //     // console.log($("#" + layer.id).prop("currentTime"));
                        //     // if($("#" + layer.id).prop("currentTime") > 0){
                        //     //     if(audioTime != $("#" + layer.id).prop("currentTime")){
                        //     //         audio.pause();
                        //     //         // audio.currentTime = audioTime;
                        //     //         $("#" + layer.id).prop("currentTime",audioTime);
                        //     //         console.log($("#" + layer.id).prop("currentTime"), audioTime);
                        //     //         // audio.currentTime = audioTime;
                                   
                        //     //     }
                        //     // }
                        
                        // }
                    }
                }
            }
        },
        stopAllPlays(){
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.type == 'audio'){
                    let audio = document.getElementById('audio-'+ layer.layerNumber);
                    if(audio){
                        audio.pause();
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
        submitSynthesizeRequest() {
            this.$validator.validate()
                .then(isValid => {
                    if (isValid) {
                        let error = false;
                        if(this.selectedVoiceId == 0){
                            error = true;
                            this.voiceIdError = "Voice is required";
                        }
                        if(this.selectedLanguageId == 0){
                            error = true;
                            this.languageIdError = "Language is required";
                        }
                        if(!error){
                            this.synthesize();
                        }
                        
                    }
                });
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
            let audio = document.getElementById('listen-result');
            audio.pause();
            audio.src = "";

            this.addTranslatedAudioToLayer(this.prevSynthesizeAudioURL, this.prevSynthesizePath);

        },
        makeExportRequest() {
            this.$validator.validate()
                .then(isValid => {
                    if (isValid) {
                        this.exportAudio();
                        
                    }
                });
        },
        exportAudio(){
            if(this.layers.length > 0){
                const formData = new FormData();
                formData.append('edit_id', this.edit_id);
                formData.append('edit_name', this.edit_name);

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

                        this.$notify.error({
                            title: 'Error',
                            message: error.response.data.message
                        });
                    })
            }

            
            
        },
        
        makeSaveRequest() {
            this.$validator.validate()
                .then(isValid => {
                    if (isValid) {
                        this.storeEditorState();
                        
                    }
                });
        },
        storeEditorState(){
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('layers', JSON.stringify(this.layers));
            formData.append('edit_id', this.edit_id);
            formData.append('edit_name', this.edit_name);
            formData.append('speech_text', this.speech_text);
            this.isLoading = true;
            this.loadingType = "save";
            axios.post(this.url.save, formData, {responseType: 'blob'})
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = "";
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
        },
        deleteLayer(index){
            let layer = this.layers[index];
            let layerId = "layer-container-"+ layer.layerNumber;
            $( "#"+layer.id ).remove();
            $( "#"+layerId ).remove();
            this.layers.splice(index, 1);
        },
        cloneLayer(index){
            let layer = Object.assign({},this.layers[index]);
            var audioConatiner = document.getElementById("audio-container");
            var newAudio = document.createElement("AUDIO");
            var audioID = 'audio-'+ this.layers.length;
            newAudio.id       = audioID;
            newAudio.src      = layer.url;
            newAudio.type     = layer.htmlType;
            newAudio.controls = 'controls';
            audioConatiner.appendChild(newAudio);
            $("#" + audioID).prop("volume", layer.volume);
            layer.id       = audioID;
            layer.name     = "clone-" + layer.name;


            newAudio = document.getElementById(audioID);
            $("#"+audioID).on("loadedmetadata", (e) =>{
                layer.layerNumber = this.layers.length;
                this.layers.push(layer);
                this.addLayerToTimeLine(layer.layerNumber);                
            });
        },
        initLayers(){
            $('#scroller').html('');
            for(key in this.layers){
                let layer = this.layers[key];
                layer.url = this.url.audioURL + layer.path;
                var audioConatiner = document.getElementById("audio-container");
                var newAudio = document.createElement("AUDIO");
                var audioID = 'audio-'+ layer.layerNumber;
                var audio = document.getElementById(audioID);
                if(audio != null){
                    $("#" + audioID).prop("volume", layer.volume);
                    this.addLayerToTimeLine(layer.layerNumber);
                    
                }else{
                    newAudio.id       = audioID;
                    newAudio.src      = layer.url;
                    newAudio.type     = layer.htmlType;
                    newAudio.controls = 'controls';
                    audioConatiner.appendChild(newAudio);
                    $("#" + audioID).prop("volume", layer.volume);
                    newAudio = document.getElementById(audioID);
                    $("#"+audioID).on("loadedmetadata", (e) =>{
                        this.addLayerToTimeLine(layer.layerNumber);
                    });
                }
                
               
            }
        },

        teleprompterScrolldown() {
	        this.teleprompter.status = 2
            var contentobj = document.getElementById("prompter-content");
	        var contentheight = contentobj.offsetHeight;
            if(window.scrolltimerup){
                clearTimeout(scrolltimerup)
            }
            if(parseInt(contentobj.style.top)>=(contentheight*(-1)+100)){
                
                let prompterTop =parseInt(contentobj.style.top) - this.teleprompter.step;
                contentobj.style.top = prompterTop + 'px';
            }
            scrolltimerdown = setTimeout(this.teleprompterScrolldown, this.teleprompter.scspeed)
        },
        setspeed() {

            if (this.teleprompter.speedSize<1) this.teleprompter.speedSize = 1;
            if (this.teleprompter.speedSize>16) this.teleprompter.speedSize = 16;
        
            switch (parseInt(this.teleprompter.speedSize))	{
                case 1 : this.teleprompter.step = 1; this.teleprompter.scspeed = 50; 
                break;
                case 2 : this.teleprompter.step = 2; this.teleprompter.scspeed = 40; 
                break;
                case 3 : this.teleprompter.step = 2; this.teleprompter.scspeed = 30; 
                break;
                case 4 : this.teleprompter.step = 2; this.teleprompter.scspeed = 25; 
                break;	
                case 5 : this.teleprompter.step = 2; this.teleprompter.scspeed = 20; 
                break;	
                case 6 : this.teleprompter.step = 3; this.teleprompter.scspeed = 40; 
                break;	
                case 7 : this.teleprompter.step = 3; this.teleprompter.scspeed = 30; 
                break;
                case 8 : this.teleprompter.step = 3; this.teleprompter.scspeed = 22; 
                break;
                case 9 : this.teleprompter.step = 3; this.teleprompter.scspeed = 15; 
                break;
                case 10 : this.teleprompter.step = 3; this.teleprompter.scspeed = 10; 
                break;
                case 11 : this.teleprompter.step = 4; this.teleprompter.scspeed = 15; 
                break;
                case 12 : this.teleprompter.step = 5; this.teleprompter.scspeed = 10; 
                break;	
                case 13 : this.teleprompter.step = 5; this.teleprompter.scspeed = 5; 
                break;
                case 14 : this.teleprompter.step = 7; this.teleprompter.scspeed = 5; 
                break;
                case 15 : this.teleprompter.step = 10; this.teleprompter.scspeed = 5; 
                break;	
                case 16 : this.teleprompter.step = 10; this.teleprompter.scspeed = 2; 
                break;
            }
        },
        teleprompterStop() {
            this.teleprompter.status = 1
            if(window.scrolltimerup){
                clearTimeout(scrolltimerup)
            }
            if(window.scrolltimerdown){
                clearTimeout(scrolltimerdown)
            }
        },
        resetTeleprompter(){
            this.teleprompter.speedSize = 1;
            this.teleprompter.fontSize =14;
            this.setspeed();
        },
        openFileExplorer(){
            $("#doc-upload").click();
        },

        fileonUpload(event){
            var file = event.currentTarget.files[0];
            this.objectUrl = URL.createObjectURL(file);
            this.fileType = file.type;
        },

        uploadFile(){
            this.isLoading = true;
            var ext = $("#doc-upload").val().split('.').pop();
            if(this.fileType.includes("text")){
                this.readTextFile();
            }

            if(this.fileType.includes("pdf")){
                this.readPDFFile();
            }

            if(ext == 'doc' || ext == 'docx'){
                this.generateDocxText();
            }
            this.isLoading = false;
        },

        readTextFile() {
            var rawFile = new XMLHttpRequest();
            let vueInstance = this
            rawFile.open("GET", this.objectUrl, false);
            rawFile.onreadystatechange = function ()
            {
                if(rawFile.readyState === 4)
                {
                    if(rawFile.status === 200 || rawFile.status == 0)
                    {
                        var allText = rawFile.responseText;
                        vueInstance.teleprompter.currentStep = 2;
                        vueInstance.teleprompter.text = allText;
                    }
                }
            }
            rawFile.send(null);
        },

        readPDFFile() {
            var pdff = new Pdf2TextClass();
            pdff.pdfToText(this.objectUrl, this.getPDFText);
        },

        getPDFText(layers){
            var full_text = "";
            var num_pages = Object.keys(layers).length;
            for( var j = 1; j <= num_pages; j++){
                full_text += layers[j] ;
            }
            this.teleprompter.currentStep = 2;
            this.teleprompter.text = full_text;
            // for( var j = 1; j <= num_pages; j++)
                
            
        },
        loadFile(url,callback){
            PizZipUtils.getBinaryContent(url,callback);
        },
        generateDocxText() {
            let vueInstance = this
            this.loadFile(this.objectUrl,function(error,content){
                if (error) { throw error };
    
                // The error object contains additional information when logged with JSON.stringify (it contains a properties object containing all suberrors).
                function replaceErrors(key, value) {
                    if (value instanceof Error) {
                        return Object.getOwnPropertyNames(value).reduce(function(error, key) {
                            error[key] = value[key];
                            return error;
                        }, {});
                    }
                    return value;
                }
    
                function errorHandler(error) {
                    console.log(JSON.stringify({error: error}, replaceErrors));
    
                    if (error.properties && error.properties.errors instanceof Array) {
                        const errorMessages = error.properties.errors.map(function (error) {
                            return error.properties.explanation;
                        }).join("\n");
                        console.log('errorMessages', errorMessages);
                        // errorMessages is a humanly readable message looking like this:
                        // 'The tag beginning with "foobar" is unopened'
                    }
                    throw error;
                }
    
                var zip = new PizZip(content);
                var doc = new window.docxtemplater(zip, { paragraphLoop: true, linebreaks: true });
                var text= doc.getFullText();

                vueInstance.teleprompter.currentStep = 2;
                vueInstance.teleprompter.text = text;
            })
        },
    },

    
});