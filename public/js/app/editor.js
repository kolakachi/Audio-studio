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
        backgroundMusic: [],
        backgroundSounds:[],
        trackType: "0",
        trackName: '',
        trackisLoading:false,
        libraryPreviewAudio: {},
        trimPreviewAudio:{},
        trimPreviewIsPlaying:false,
        trimPreviewFrameId:0,
        trimLastTime:null,
        rangeSlider:{},
        rangeSliderButtons:{},
        libraryPreviewAudioIsPlaying: false,
        prevKey:'',
        url: {
            synthesize: '',
            storeRecord: '',
            storeAudioUpload: '',
            export: '',
            save:'',
            audioURL:'',
            backgroundMusicURL: '',
            backgroundSoundsURL:'',
            storeLibraryAudio: ''
        },
        aplayer :{
            isPlaying: false
        },
        voicePreviewIsPlaying: false,
        prevSynthesizeAudioURL: '',
        prevSynthesizePath: '',
        activeTab: 'library',
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
        },
        activeLayer:{
            volume: 1,
        },
        activeLayerIndex: 0,

        backgroundMusicCurrentPage: 1,
        backgroundMusicLastPage:1,

        backgroundSoundCurrentPage: 1,
        backgroundSoundLastPage:1,
        

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
        this.url.synthesize = $("#synthesize-url").val();
        this.url.storeRecord = $("#store-record-url").val();
        this.url.storeAudioUpload = $("#store-upload-url").val();
        this.url.export = $("#export-audio-url").val();
        this.url.save = $("#save-config-url").val();
        this.url.audioURL = $("#audio-full-url").val() + "/";
        this.url.backgroundSoundsURL = $("#get-audio-sounds-url").val();
        this.url.backgroundMusicURL = $("#get-audio-music-url").val();
        this.url.storeLibraryAudio = $("#store-audio-music-url").val();
        this.url.masterpieceURL = $("#master-piece-url").val();

        this.player = new Player();
        this.languages = JSON.parse($("#languages").val());
        this.voices = JSON.parse($("#voices").val());
        let audio = JSON.parse($("#audio-details").val());
        this.edit_id = audio.uuid;
        this.edit_name = audio.audio_name;
        this.layers = audio.layers;
        this.speech_text = audio.speech_text;

        document.getElementById("audio-textarea").innerHTML = this.speech_text;

        this.signals = editorSignals;
        this.resetDuration();
        this.initTimeline();
        var range = document.getElementById("time-range");

        var modal = document.getElementById('addMusicTrackModal')
        modal.addEventListener('hidden.bs.modal',  (event) => {
            this.libraryPreviewAudioIsPlaying = false;
            if(Object.keys(this.libraryPreviewAudio).length != 0){
                this.libraryPreviewAudio.pause();
            }
        });

        var modal = document.getElementById('listenModal')
        modal.addEventListener('hidden.bs.modal',  (event) => {
            var audio = document.getElementById('listen-result');
            if(audio){
                audio.pause();
            }
        });

        var modal = document.getElementById('recordModal')
        modal.addEventListener('hidden.bs.modal',  (event) => {

            this.audio.pause();
        });

        var modal = document.getElementById('trimAudioModal')
        modal.addEventListener('hidden.bs.modal',  (event) => {

            if( this.rangeSlider.data){
                this.rangeSlider.data("ionRangeSlider").destroy();
            }
        });

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

        const target = document.querySelector('#audio-textarea');

        target.addEventListener('paste', (event) => {
            event.preventDefault();
            let parsedText = "";
            let pastedData = "";
            var sel, range;
            let types = event.clipboardData.types;
            if (((types instanceof DOMStringList) && types.contains("text/html")) || (types.indexOf && types.indexOf('text/html') !== -1)) {
            // Extract data and pass it to callback
                pastedData = event.clipboardData.getData('text/html');
            }else{
                pastedData = (event.clipboardData || window.clipboardData).getData('text');
                // var text = paste;//document.createTextNode(paste);
                // document.getElementById('audio-textarea').appendChild(text);
            }
            parsedText = this.cleanTextEditor(pastedData);
            var div = document.createElement('div');
            div.innerHTML = parsedText.trim();

            if (window.getSelection) {
                sel = window.getSelection();
                if (sel.getRangeAt && sel.rangeCount) {
                    range = sel.getRangeAt(0);
                    range.deleteContents();
                   

                    // Change this to div.childNodes to support multiple top-level nodes.
                    // return div.firstChild;
                    range.insertNode( div.firstChild );
                }
            } else if (document.selection && document.selection.createRange) {
                document.selection.createRange().insertNode( div.firstChild );
            }

            
        });

        document.addEventListener('keyup', (event) => {
            let keyCode = window.event.keyCode;
            if(this.prevKey == 39 && keyCode == 39){
                // console.log("right two times")
                this.prevKey = "";
            }else if (this.prevKey == 37 && keyCode == 37) {
                // console.log("left two times")
                this.prevKey = "";
            }else{
                this.prevKey = keyCode;
            }
            
            // console.log(this.prevKey, keyCode);
        });

       

        $(document).on("dblclick", '.layer-bar', function(e){
            $('.layer-tooltip').fadeOut();
            let offset = $(this).offset();
            $(this).find('.layer-tooltip').fadeIn().css(({
                left: e.pageX - offset.left,
                bottom: e.pageY - offset.bottom
            }));
        });

        let vueInstance = this;
        $(document).on("click", '.popup-btn-delete', function(e){
            let layerNumber = $(this).attr("data-layer-index");
            $('.layer-tooltip').fadeOut();
            console.log(layerNumber);
            vueInstance.deleteLayer(layerNumber);           
        });

        $(document).on("click", '.popup-btn-clone', function(e){
            let layerNumber = $(this).attr("data-layer-index");
            $('.layer-tooltip').fadeOut();
            vueInstance.cloneLayer(layerNumber);           
        });

        $(document).on("click", '.popup-btn-volume', function(e){
            let layerNumber = $(this).attr("data-layer-index");
            vueInstance.activeLayer = vueInstance.layers[layerNumber];
            vueInstance.activeLayerIndex = layerNumber;
            $("#popupVolumeModal").modal('show'); 
            e.stopPropagation();         
        });

        $(document).on("click", '.trim-btn', function(e){
            let layerNumber = $(this).attr("data-layer-index");
            vueInstance.activeLayer = vueInstance.layers[layerNumber];
            vueInstance.activeLayerIndex = layerNumber;
            $("#trimAudioModal").modal('show'); 
            vueInstance.initSlider();
            e.stopPropagation();         
        });

        $(document).on("click", '#timeline-wrapper', function(e){
            $('.layer-tooltip').fadeOut();           
        });

        const tip3 = new TextTip({
            scope: '.scope-four',
            iconFormat: 'font',
            buttons: [
                {
                    title: 'Copy and paste', 
                    iconFormat:'text', icon: 'far fa-copy', 
                    callback: function(message){
                        console.log("meee copy" + message);
                    }
                },
                {   title: 'Improve', 
                    iconFormat:'svgsprite', 
                    icon: `<svg width="22" height="15" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.7278 14.0606L11.669 11.0017L13.2709 9.3975L14.7278 10.8567L20.4015 5.19213L22 6.79747L14.7278 14.0606ZM10.1962 11.3291H0V9.06329H10.1962V11.3291ZM14.7278 6.79747H0V4.53164H14.7278V6.79747ZM14.7278 2.26582H0V0H14.7278V2.26582Z" />
                </svg>`, callback: this.improveText
                },
                {
                    title: 'Rephrase',
                    iconFormat:'svgsprite', 
                    icon: `<svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 12.4481H5.5325V13.8313H0V12.4481ZM14.1929 6.22407H0V7.60719H14.177C14.819 7.60719 15.4346 7.8622 15.8886 8.31613C16.3425 8.77006 16.5975 9.38571 16.5975 10.0277C16.5975 10.6696 16.3425 11.2853 15.8886 11.7392C15.4346 12.1931 14.819 12.4481 14.177 12.4481H10.2545L12.0429 10.6597L11.065 9.68188L7.60719 13.1397L11.065 16.5975L12.0429 15.6196L10.2545 13.8313H14.1999C15.2086 13.8303 16.1757 13.4287 16.8884 12.7148C17.6011 12.0008 18.0009 11.033 18 10.0242C17.9991 9.01543 17.5975 8.04833 16.8835 7.33567C16.1695 6.623 15.2017 6.22315 14.1929 6.22407ZM0 0H16.5975V1.38313H0V0Z" />
                </svg>`, callback: this.rephraseText
                },
                {
                    title: 'Expand', 
                    iconFormat:'svgsprite', 
                    icon: `<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.7705 0.00187292L12.9326 0.602785C12.7638 0.623242 12.6948 0.827808 12.8124 0.947991L14.2111 2.34671L10.286 6.27182C10.2479 6.31027 10.2266 6.36219 10.2266 6.4163C10.2266 6.4704 10.2479 6.52232 10.286 6.56077L11.4392 7.71401C11.5185 7.79328 11.6489 7.79328 11.7282 7.71401L15.6558 3.78634L17.0546 5.18506C17.0816 5.21204 17.1156 5.23086 17.1528 5.23937C17.19 5.24789 17.2288 5.24575 17.2649 5.23321C17.3009 5.22066 17.3327 5.19822 17.3565 5.16844C17.3804 5.13867 17.3954 5.10278 17.3998 5.06488L17.9981 0.229452C18.0024 0.198572 17.9994 0.167131 17.9895 0.13759C17.9795 0.108048 17.9629 0.081207 17.9408 0.0591671C17.9188 0.0371273 17.892 0.0204862 17.8624 0.0105466C17.8329 0.000606982 17.8014 -0.0023615 17.7705 0.00187292ZM6.56033 10.2864C6.52188 10.2484 6.46996 10.227 6.41586 10.227C6.36175 10.227 6.30983 10.2484 6.27138 10.2864L2.34627 14.2141L0.947551 12.8154C0.920565 12.7884 0.886524 12.7696 0.849332 12.7611C0.812139 12.7526 0.7733 12.7547 0.737267 12.7672C0.701234 12.7798 0.669465 12.8022 0.645602 12.832C0.621738 12.8618 0.606747 12.8977 0.602346 12.9356L0.0014334 17.771C-0.013909 17.904 0.096045 18.0139 0.229013 17.9986L5.067 17.3977C5.23577 17.3772 5.30481 17.1726 5.18718 17.0524L3.78846 15.6537L7.71613 11.7261C7.7954 11.6468 7.7954 11.5164 7.71613 11.4371L6.56033 10.2864Z" />
                </svg>`, callback: this.expandText
            
                },
                {
                    title: 'Shorten', 
                    iconFormat:'svgsprite', 
                    icon: `<svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.3661 9.01416H11.0175C10.3953 9.01416 9.89076 9.51874 9.89076 10.1409C9.89076 10.7631 10.3953 11.2677 11.0175 11.2677H14.3661C14.9883 11.2677 15.4929 10.7631 15.4929 10.1409C15.4929 9.51874 14.9894 9.01416 14.3661 9.01416ZM18.8732 0H11.0175C10.3953 0 9.89076 0.504582 9.89076 1.12677C9.89076 1.74896 10.3953 2.25354 11.0175 2.25354H18.8732C19.4954 2.25354 20 1.74896 20 1.12677C20 0.504582 19.4965 0 18.8732 0ZM12.1126 13.5212H10.9858C10.3637 13.5212 9.85907 14.0258 9.85907 14.648C9.85907 15.2702 10.3637 15.7748 10.9858 15.7748H12.1126C12.7348 15.7748 13.2077 15.2702 13.2077 14.648C13.2077 14.0258 12.7359 13.5212 12.1126 13.5212ZM16.6197 4.50708H11.0175C10.3953 4.50708 9.89076 5.01166 9.89076 5.63385C9.89076 6.25604 10.3953 6.76062 11.0175 6.76062H16.6197C17.2419 6.76062 17.7465 6.25604 17.7465 5.63385C17.7465 5.01166 17.2429 4.50708 16.6197 4.50708ZM6.49284 10.5177L5.35199 11.7642V1.12783C5.35199 0.504582 4.84846 0 4.22522 0C3.60197 0 3.09845 0.504582 3.09845 1.12783V11.7617L1.95759 10.5177C1.73534 10.2753 1.43153 10.1522 1.12625 10.1522C0.844402 10.1519 0.572764 10.2577 0.365325 10.4485C-0.0934821 10.8692 -0.124116 11.583 0.295993 12.0425L3.36292 15.426C3.78969 15.8929 4.59744 15.8929 5.02456 15.426L8.09148 12.0425C8.51191 11.583 8.48092 10.8696 8.02215 10.4485C7.62665 10.0283 6.91538 10.0599 6.49284 10.5177Z" />
                    </svg>
                    `, callback: this.shortenText
            
                },
                // {
                //     title: 'Plagiarism', 
                //     iconFormat:'svgsprite', 
                //     icon: `<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                //     <path d="M1.44502 7.957C0.578456 8.82246 0.0653657 9.97969 0.00582841 11.203C-0.0537089 12.4262 0.344577 13.6278 1.123 14.5733C1.90142 15.5189 3.00414 16.1405 4.21608 16.317C5.42802 16.4935 6.66225 16.2122 7.67802 15.528L11.934 19.785C12.0715 19.9255 12.2573 20.0085 12.4537 20.0169C12.6501 20.0253 12.8423 19.9585 12.9912 19.8302C13.1401 19.7019 13.2346 19.5217 13.2554 19.3262C13.2761 19.1308 13.2217 18.9347 13.103 18.778L13.028 18.691L8.81102 14.473C9.58225 13.4841 9.94739 12.2384 9.83203 10.9897C9.71667 9.74096 9.12949 8.58321 8.19015 7.75238C7.25081 6.92155 6.03002 6.48017 4.77655 6.51819C3.52308 6.55621 2.33227 7.07077 1.44502 7.957ZM10.03 0C5.27402 0 1.29402 3.319 0.279018 7.767C0.872019 7.01447 1.63903 6.41733 2.51402 6.027C3.46429 4.23392 5.02304 2.83864 6.91002 2.092L6.80302 2.266C6.26502 3.159 5.83202 4.277 5.52802 5.546C6.02702 5.596 6.51902 5.71 6.99302 5.886C7.62502 3.258 8.81602 1.501 10.03 1.501L10.145 1.506C11.411 1.622 12.633 3.624 13.201 6.502H8.20402C8.80774 6.90301 9.33304 7.41103 9.75402 8.001L13.428 8.002C13.6039 9.66732 13.5585 11.3486 13.293 13.002H10.647C10.5688 13.2898 10.4689 13.5713 10.348 13.844L10.219 14.116L10.097 14.345L10.255 14.502H12.97C12.767 15.251 12.52 15.92 12.238 16.487L13.344 17.594C13.836 16.736 14.235 15.686 14.522 14.504L17.245 14.502C16.3502 15.934 15.0507 17.0686 13.511 17.762L13.736 17.985L13.861 18.125C14.081 18.421 14.206 18.75 14.239 19.078C15.9695 18.275 17.4342 16.9939 18.4604 15.3858C19.4867 13.7777 20.0316 11.9097 20.031 10.002C20.031 4.478 15.553 0 10.03 0ZM7.31802 9.05C7.63404 9.36338 7.88505 9.73609 8.05666 10.1467C8.22826 10.5574 8.31708 10.9979 8.31801 11.4429C8.31894 11.888 8.23197 12.3288 8.06208 12.7402C7.8922 13.1516 7.64274 13.5253 7.32804 13.84C7.01334 14.1547 6.63958 14.4042 6.22822 14.5741C5.81686 14.7439 5.376 14.8309 4.93095 14.83C4.48589 14.8291 4.0454 14.7402 3.63476 14.5686C3.22411 14.397 2.8514 14.146 2.53802 13.83C1.90853 13.1952 1.55615 12.3369 1.55803 11.4429C1.5599 10.5489 1.91586 9.69212 2.548 9.05998C3.18014 8.42784 4.03697 8.07188 4.93095 8.07001C5.82493 8.06814 6.68324 8.42051 7.31802 9.05ZM14.936 8.002L18.294 8.001L18.302 8.031C18.452 8.664 18.532 9.323 18.532 10.001C18.533 11.0257 18.3484 12.0421 17.987 13.001L14.813 13.003C14.956 12.053 15.031 11.045 15.031 10.002C15.031 9.318 14.999 8.649 14.936 8.002ZM13.149 2.091L13.172 2.099C15.2192 2.91624 16.8705 4.49414 17.78 6.502H14.731C14.418 4.749 13.871 3.223 13.149 2.091Z" />
                //     </svg>
                //     `, callback: console.log
            
                // }
            ]
        });
        
    },
    methods: {
        setActiveTab(type){
            this.activeTab = type;
        },
        getfiles(){
            if(this.trackType == 'music'){
                if(this.backgroundMusic.length < 1){
                    this.getBackgroundMusic();
                }
            }
            if(this.trackType == 'sounds'){
                if(this.backgroundSounds.length < 1){
                    this.getBackgroundSounds();
                }
            }
        },
        getBackgroundMusic(){
            this.isLoading = true;
            this.loadingType = "background_music";
            axios.get(this.url.backgroundMusicURL + "?c_page="+ this.backgroundMusicCurrentPage)
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = "";
                    this.backgroundMusic = response.data.files.data;
                    this.backgroundMusicLastPage = response.data.files.last_page;
                })
                .catch((error) => {
                    this.isLoading = false;
                    this.loadingType = "";
                })
        },
        getBackgroundSounds(){
            this.isLoading = true;
            this.loadingType = "background_sounds";
            axios.get(this.url.backgroundSoundsURL + "?c_page="+ this.backgroundSoundCurrentPage)
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = "";
                    this.backgroundSounds = response.data.files.data;
                    this.backgroundSoundLastPage = response.data.files.last_page;

                })
                .catch((error) => {
                    this.isLoading = false;
                    this.loadingType = "";
                })
        },
        playSoundPreview(sound){
           
            if(sound.name != this.trackName){
                this.trackName = sound.name;
                this.trackisLoading = true;
                if(this.libraryPreviewAudioIsPlaying && this.libraryPreviewAudio){
                    this.libraryPreviewAudioIsPlaying = false;
                    this.libraryPreviewAudio.pause();
                }
                this.libraryPreviewAudio = new Audio(sound.src);
                this.libraryPreviewAudio.addEventListener('loadeddata', () => {
                    this.trackisLoading = false;
                    this.libraryPreviewAudio.play();
                    this.libraryPreviewAudioIsPlaying = true;
                    // The duration variable now holds the duration (in seconds) of the audio clip
                });
                this.libraryPreviewAudio.addEventListener("ended", function(){
                    this.libraryPreviewAudioIsPlaying = false;
               });
                
            }else{
                if(this.libraryPreviewAudioIsPlaying){
                    this.libraryPreviewAudioIsPlaying = false;
                    this.libraryPreviewAudio.pause();
                }else{
                    this.libraryPreviewAudioIsPlaying = true;
                    this.libraryPreviewAudio.play();
                }
            
                
            }
            let container = document.getElementById("library");


        },
        addLibraryAudioToTimeline(sound){
            const formData = new FormData();
            formData.append('_token', $('input[name=_token]').val());
            formData.append('sound_src', sound.src);
            this.isLoading = true;
            this.loadingType = "libraryAudioUpload";
            axios.post(this.url.storeLibraryAudio, formData)
                .then((response) => {
                    this.isLoading = false;
                    this.loadingType = "";

                    let path = response.data.path;
                    this.addTranslatedAudioToLayer(this.url.audioURL + path, path);
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
        },
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
                    let result = layer.playEnd - layer.playStart;
                    layer.end = result + layer.start;
                    if(layer.end > highestLayerDuration){
                        highestLayerDuration = layer.end;
                    }
                }
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
                this.resetDuration();
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
            this.scale = this.scale - 0.5;
            this.prevScale = this.scale;
            this.initTimeline();
            this.updateTimeMark();
            this.initLayers();
            
        },
        zoomIn(){
            this.scale =  this.scale + 0.5;
            this.prevScale = this.scale;
            this.initTimeline();
            this.updateTimeMark();
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

        trimAudioUpdate(){
            this.initTimeline();
            this.updateTimeMark();
            this.initLayers();
            $("#trimAudioModal").modal('hide');
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
                    playStart:0,
                    playEnd: newAudio.duration,
                    duration: newAudio.duration,
                    originalDuration: newAudio.duration,
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
                    playStart:0,
                    playEnd: seconds,
                    duration: seconds,
                    originalDuration: seconds,
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
                    playStart:0,
                    playEnd: seconds,
                    duration: seconds,
                    originalDuration: seconds,
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
            let vueInstance = this;
            
            var layerContainer = document.createElement( 'div' );
            layerContainer.id = "layer-container-"+layerNumber;
            layerContainer.style.position = "relative";
            layerContainer.style.height = '30px';
            layerContainer.classList.add('layer-bar');
            // layerContainer.style.padding = '4px';
            // layerContainer.style.border = '1px solid #FFF';

           

            layerContainer.style.width = (this.duration * this.scale) +'px';

            var toolTip = document.createElement( 'div' );
            toolTip.id = "layer-tooltip-"+layerNumber;
            toolTip.className = 'layer-tooltip';
            toolTip.style.borderRadius = '5px 5px 5px 5px';
            toolTip.style.border = '1px solid #FFF';

            let toolTipContent = document.createElement( 'div' );
            toolTipContent.style.background = '#1d1f42';
            toolTipContent.style.display = 'flex';
            toolTipContent.style.width = '100%';
            toolTipContent.style.borderRadius = '5px 5px 5px 5px';
            toolTipContent.style.height = '100%';
            toolTipContent.innerHTML = `
                <button class="trim-btn" data-layer-index="${layerNumber}">
                    <svg width="12" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.36842 3.68421C7.36842 1.65263 5.71579 0 3.68421 0C1.65263 0 0 1.65263 0 3.68421C0 5.71579 1.65263 7.36842 3.68421 7.36842C4.27718 7.3643 4.86012 7.21504 5.38211 6.93368L7.86316 9.59474L5.42316 12.0347C4.8907 11.7399 4.29284 11.5832 3.68421 11.5789C1.65263 11.5789 0 13.2316 0 15.2632C0 17.2947 1.65263 18.9474 3.68421 18.9474C5.71579 18.9474 7.36842 17.2947 7.36842 15.2632C7.36842 14.6305 7.19368 14.0442 6.91158 13.5242L9.3 11.1368L14.7368 16.9695C15.3289 17.5617 16.132 17.8946 16.9695 17.8947H20L6.68421 5.80842C7.11158 5.20632 7.36842 4.47684 7.36842 3.68421ZM3.68421 5.26316C2.81368 5.26316 2.10526 4.55474 2.10526 3.68421C2.10526 2.81368 2.81368 2.10526 3.68421 2.10526C4.55474 2.10526 5.26316 2.81368 5.26316 3.68421C5.26316 4.55474 4.55474 5.26316 3.68421 5.26316ZM3.68421 16.8421C2.81368 16.8421 2.10526 16.1337 2.10526 15.2632C2.10526 14.3926 2.81368 13.6842 3.68421 13.6842C4.55474 13.6842 5.26316 14.3926 5.26316 15.2632C5.26316 16.1337 4.55474 16.8421 3.68421 16.8421Z"/>
                        <path d="M14.7368 1.9779L10.8347 6.62421L12.3232 8.11263L20 1.05263H16.9695C16.132 1.05281 15.3289 1.38563 14.7368 1.9779Z"/>
                    </svg>
                    Trim
                </button>
                <button class="popup-btn-volume" data-layer-index="${layerNumber}">
                    <svg width="12" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.58627 2.19836L5.03365 5.75019H0.958333C0.428854 5.75019 0 6.17904 0 6.70852V12.4585C0 12.9876 0.428854 13.4169 0.958333 13.4169H5.03365L8.58627 16.9687C9.18642 17.5688 10.2222 17.1472 10.2222 16.2911V2.87598C10.2222 2.01907 9.18563 1.599 8.58627 2.19836ZM17.9029 0.158709C17.4568 -0.133982 16.8575 -0.0105962 16.5648 0.436227C16.2717 0.882251 16.3963 1.48161 16.8423 1.7743C19.4885 3.51088 21.0678 6.4302 21.0678 9.58392C21.0678 12.7376 19.4885 15.657 16.8423 17.3935C16.3963 17.6858 16.2717 18.2856 16.5648 18.7312C16.8459 19.1589 17.4405 19.3126 17.9029 19.0087C21.0941 16.914 23 13.3901 23 9.58352C23 5.77694 21.0941 2.25347 17.9029 0.158709ZM19.1667 9.58352C19.1667 7.04673 17.8865 4.71439 15.7418 3.34477C15.295 3.05966 14.7024 3.19223 14.4193 3.64265C14.1362 4.09307 14.2684 4.68923 14.7152 4.97473C16.3024 5.98857 17.25 7.71118 17.25 9.58352C17.25 11.4559 16.3024 13.1785 14.7152 14.1923C14.2684 14.4774 14.1362 15.0736 14.4193 15.5244C14.6793 15.9381 15.2627 16.1289 15.7418 15.8223C17.8865 14.4527 19.1667 12.1207 19.1667 9.58352ZM13.5057 6.51406C13.0433 6.2613 12.4599 6.42781 12.2036 6.8914C11.9484 7.355 12.1173 7.93758 12.5809 8.19354C13.0964 8.47664 13.4167 9.00972 13.4167 9.58352C13.4167 10.1577 13.0964 10.6904 12.5813 10.9735C12.1177 11.2295 11.9488 11.812 12.204 12.2756C12.4607 12.7412 13.0445 12.9065 13.5061 12.653C14.6334 12.0321 15.3337 10.8561 15.3337 9.58312C15.3337 8.31013 14.6334 7.13458 13.5057 6.51406Z"/>
                    </svg>
                
                    Volume
                </button>
                <button class="popup-btn-clone" data-layer-index="${layerNumber}">
                    <svg width="12" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21.85 0H6.9C6.59511 0.000342428 6.3028 0.121613 6.0872 0.337205C5.87161 0.552798 5.75034 0.845106 5.75 1.15V16.1C5.75034 16.4049 5.87161 16.6972 6.0872 16.9128C6.3028 17.1284 6.59511 17.2497 6.9 17.25H21.85C22.1549 17.2497 22.4472 17.1284 22.6628 16.9128C22.8784 16.6972 22.9997 16.4049 23 16.1V1.15C22.9997 0.845106 22.8784 0.552798 22.6628 0.337205C22.4472 0.121613 22.1549 0.000342428 21.85 0ZM21.4667 15.7167H7.28333V1.53333H21.4667V15.7167Z"/>
                        <path d="M15.7167 21.4667H1.53333V7.28333H4.21667V5.75H1.15C0.845106 5.75034 0.552798 5.87161 0.337205 6.0872C0.121613 6.3028 0.000342428 6.59511 0 6.9V21.85C0.000342428 22.1549 0.121613 22.4472 0.337205 22.6628C0.552798 22.8784 0.845106 22.9997 1.15 23H16.1C16.4049 22.9997 16.6972 22.8784 16.9128 22.6628C17.1284 22.4472 17.2497 22.1549 17.25 21.85V18.7833H15.7167V21.4667Z" />
                    </svg>
                 
                    Duplicate
                </button>
                <button class="popup-btn-delete" data-layer-index="${layerNumber}">
                    <svg width="12" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.21363 3.74892L0.231919 1.76722C0.0792819 1.60341 -0.00381521 1.38675 0.000134626 1.16288C0.00408446 0.939018 0.0947729 0.725426 0.253094 0.567105C0.411415 0.408784 0.625008 0.318095 0.848873 0.314146C1.07274 0.310196 1.2894 0.393293 1.4532 0.54593L22.7681 21.8608C22.9207 22.0246 23.0038 22.2413 22.9999 22.4651C22.9959 22.689 22.9052 22.9026 22.7469 23.0609C22.5886 23.2192 22.375 23.3099 22.1511 23.3139C21.9273 23.3178 21.7106 23.2347 21.5468 23.0821L18.9049 20.4414L18.9014 20.4771C18.8281 21.2254 18.491 21.9232 17.9504 22.4458C17.4099 22.9684 16.7011 23.2817 15.9508 23.3298L15.748 23.3356H7.252C6.50018 23.3355 5.77286 23.0682 5.20002 22.5812C4.62719 22.0943 4.24617 21.4196 4.12505 20.6775L4.09855 20.4771L2.62264 5.47716H1.70668C1.49786 5.47715 1.29612 5.40153 1.13875 5.26428C0.981374 5.12703 0.879026 4.93743 0.850627 4.73056L0.842562 4.61304C0.842571 4.40423 0.918192 4.20248 1.05544 4.04511C1.19269 3.88774 1.38228 3.78539 1.58916 3.75699L1.70668 3.74892H2.21363ZM17.3241 18.8606L14.3804 15.9157V17.5748C14.3803 17.7937 14.2972 18.0045 14.1477 18.1645C13.9982 18.3244 13.7936 18.4217 13.5752 18.4366C13.3567 18.4516 13.1408 18.383 12.971 18.2448C12.8011 18.1067 12.6901 17.9092 12.6602 17.6923L12.6522 17.5748V14.1875L10.3478 11.8831V17.5748C10.3478 17.7937 10.2646 18.0045 10.1151 18.1645C9.96567 18.3244 9.76105 18.4217 9.54263 18.4366C9.3242 18.4516 9.10825 18.383 8.93841 18.2448C8.76858 18.1067 8.65752 17.9092 8.62768 17.6923L8.61961 17.5748V10.1549L4.40503 5.94147L5.81872 20.3089C5.85105 20.6398 5.99687 20.9493 6.23145 21.1849C6.46603 21.4206 6.77491 21.5678 7.10568 21.6016L7.252 21.6085H15.748C16.4393 21.6085 17.0257 21.1188 17.1594 20.454L17.1824 20.3089L17.3241 18.8617V18.8606Z" />
                        <path d="M12.6729 9.32075L14.3804 11.0282V9.5097L14.3723 9.39218C14.3449 9.19141 14.2477 9.00668 14.0978 8.87027C13.948 8.73387 13.7549 8.65448 13.5525 8.64597C13.35 8.63746 13.151 8.70037 12.9902 8.82372C12.8294 8.94706 12.7171 9.12299 12.6729 9.32075Z" />
                        <path d="M18.6399 5.47716L17.762 14.4098L19.3427 15.9906L20.3762 5.47716H21.2933L21.4108 5.46909C21.6277 5.43925 21.8252 5.32819 21.9634 5.15835C22.1015 4.98852 22.1701 4.77257 22.1552 4.55414C22.1402 4.33571 22.043 4.13109 21.883 3.98163C21.723 3.83216 21.5123 3.74899 21.2933 3.74892H15.2445L15.2387 3.53693C15.1847 2.56292 14.7526 1.64847 14.0345 0.988174C13.3165 0.327881 12.3691 -0.0261212 11.394 0.00150332C10.4188 0.0291278 9.493 0.436198 8.81347 1.13608C8.13393 1.83597 7.75434 2.77342 7.7555 3.74892H7.10107L8.8293 5.47716H18.6399ZM11.5 1.73265C12.613 1.73265 13.5163 2.63594 13.5163 3.74892H9.48373L9.49064 3.58301C9.53228 3.07871 9.76201 2.60851 10.1342 2.26573C10.5065 1.92295 10.994 1.73267 11.5 1.73265Z"/>
                    </svg>
                    Delete
                </button>`;

            

            

            /* String with HTML source code (so called DOMString) to HTMLElement */
            // let newContent = new DOMParser().parseFromString(stringToHtml, 'text/html');

            // const newContent = document.createTextNode("Tooltip");

            // add the text node to the newly created div
            toolTip.appendChild(toolTipContent);

            layerContainer.appendChild( toolTip );
            
            var dom = document.createElement( 'div' );
            dom.className = 'block';
            dom.id = "dom-"+layerNumber;
            dom.style.display = 'flex';
            dom.style.justifyContent = 'space-between';
            dom.style.position = "absolute";
            dom.style.height = '25px';
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
            name.style.flexGrow = 1;

            
            

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
                container: "#"+ "name-"+layerNumber,
                // barWidth: 3,
                // barHeight: 1, 
                waveColor: '#FFF',
                progressColor: '#FFF',
                fillParent:true,
                minPxPerSec: 50,
                pixelRatio: 1,
                autocenter: true
            });
            wavesurfer.load(layer.url);
            // dom.style.left = ( layer.start * scale ) + 'px';
		    // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
		    // dom.style.width = ( ( layer.end - layer.start ) * scale ) + 'px';

		    // name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            this.resetDuration();
            this.initTimeline();
            this.updateTimeMark();
            

        },

        setAudioVolume(index){
            let layer = this.layers[index];
            let audioID  = layer.id;
            $("#" + audioID).prop("volume", layer.volume);

        },

        updateLayerSize(layerNumber){
            var layer = this.layers[layerNumber];
            var dom = document.getElementById("dom-"+layerNumber);//layer.dom;
            var name = document.getElementById("name-"+layerNumber);//layer.domName; 
            dom.style.left = ( layer.start * this.scale ) + 'px';
		    // dom.style.top = ( layer.layerNumber * 32 ) + 'px';
		    dom.style.width = ( ( layer.playEnd - layer.playStart ) * this.scale ) + 'px';

		    name.innerHTML = layer.name; //+ ' <span style="opacity:0.5">' + animation.effect.name + '</span>';
            // this.layerContainer.appendChild(dom); 
            this.timeMark.style.height = document.getElementById("timeline").offsetHeight - 18 + "px";
        },
        playAudios(){
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
                           
                            var audioIsPlaying = audio.currentTime > layer.playStart && !audio.paused && !audio.ended 
                            && audio.readyState > audio.HAVE_CURRENT_DATA;

                            if(audio.currentTime < layer.playStart){
                                audio.currentTime = layer.playStart;
                            }
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
            if(this.player.currentTime > highestLayerDuration || this.player.currentTime == highestLayerDuration){
                this.stop();
            }
        },
        updateAllPlays(){
            for(let i in this.layers){
                let layer = this.layers[i];
                if(layer.type == 'audio'){
                    let audio = document.getElementById('audio-'+ layer.layerNumber);
                    let audioTime = this.player.currentTime - layer.start;
                    if(audioTime <= 0){
                        audio.currentTime = layer.playStart;
                    }
                    if(layer.start <= this.player.currentTime && layer.end >= this.player.currentTime){
                        
                       
                        audioTime =parseFloat(parseFloat(audioTime).toFixed(7));
                        audio.currentTime = audioTime + layer.playStart;
                        // if(parseFloat(parseFloat(audio.currentTime).toFixed(3)) != parseFloat(parseFloat(audioTime).toFixed(3))){
                        //     audio.currentTime = audioTime;
                        // }
                        // if(audio && (audioTime > -1)){
                        //     audioTime =parseFloat(parseFloat(audioTime).toFixed(7));
                        //     if(parseFloat(parseFloat(audio.currentTime).toFixed(7)) != parseFloat(parseFloat(audioTime).toFixed(3))){
                        //         audio.currentTime = audioTime;
                        //         // let audioHandler = function() {
                        //         //     audio.currentTime = audioTime;
                        //         // };
                        //         // audio.addEventListener('canplay',audioHandler);

                        //         // //remove listener 
                        //         // audio.removeEventListener('canplay',audioHandler);
                        //     }

                            
                        //     // if($("#" + layer.id).prop("currentTime") > 0){
                        //     //     if(audioTime != $("#" + layer.id).prop("currentTime")){
                        //     //         audio.pause();
                        //     //         // audio.currentTime = audioTime;
                        //     //         $("#" + layer.id).prop("currentTime",audioTime);
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
             // "use strict";
            var selection = window.getSelection();
            
            for (var i = 0; i < 0; i += 1) {
              selection.modify('extend', 'backward', 'character');
            }
            let selectedText = selection.baseNode.data.substring(selection.baseOffset,selection.extentOffset);
            var replacement = openTag + selectedText + closeTag;
            document.execCommand('insertHTML', false, replacement);
            // window.getSelection().removeAllRanges()

        
            // var textarea = $('#audio-textarea');
            // var length = textarea.val().length;
            // var start = textarea[0].selectionStart;
            // var end = textarea[0].selectionEnd;
            // var selectedText = textarea.val().substring(start, end);
            // var replacement = openTag + selectedText + closeTag;
            // textarea.val(textarea.val().substring(0, start) + replacement + textarea.val().substring(end, length));
        },
        cleanTextEditor(textToClean = null) {
            let text = $("#audio-textarea").html();

            if(textToClean){
                text = textToClean;
            }

            let find = '<say-as';
            let re = new RegExp(find, 'g');
            text = text.replace(re, '<sayas');
            find = 'say-as>';
            re = new RegExp(find, 'g');
            text = text.replace(re, 'sayas>');

            let findInt = 'interpret-as';
            re = new RegExp(findInt, 'g');
            text = text.replace(re, 'interpretas');

            
            let newText = this.stripTags(text, "<prosody><break><sayas>");
            find = '<sayas';
            re = new RegExp(find, 'g');
            newText = newText.replace(re, '<say-as');

            find = 'sayas>';
            re = new RegExp(find, 'g');
            newText = newText.replace(re, 'say-as>');

            findInt = 'interpretas';
            re = new RegExp(findInt, 'g');
            newText = newText.replace(re, 'interpret-as');
            return newText;

        },

        stripTags(input, allowed){
            allowed = (((allowed || '') + '')
                .toLowerCase()
                .match(/<[a-z][a-z0-9]*>/g) || [])
                .join('');
            var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
                commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
            return input.replace(commentsAndPhpTags, '')
                .replace(tags, function($0, $1) {
                    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
            });
        },
        submitSynthesizeRequest(type) {
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
                            this.synthesize(type);
                        }
                        
                    }
                });
        },
        synthesize(type){
            const formData = new FormData();
            let textarea = this.cleanTextEditor().replaceAll('&nbsp;', ' ');

            formData.append('_token', $('input[name=_token]').val());
            // formData.append('textarea', $("#audio-textarea").val());
            formData.append('textarea', textarea);
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
            this.speech_text = document.getElementById("audio-textarea").innerHTML;
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
            console.log(index, this.layers);
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
                if(this.layers[key].playStart == undefined){
                    this.layers[key].playStart = 0;
                }
                if(this.layers[key].playEnd == undefined){
                    this.layers[key].playEnd = this.layers[key].duration;
                }
                if(this.layers[key].originalDuration == undefined){

                    this.layers[key].originalDuration = this.layers[key].duration;
                }
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
    
                    if (error.properties && error.properties.errors instanceof Array) {
                        const errorMessages = error.properties.errors.map(function (error) {
                            return error.properties.explanation;
                        }).join("\n");
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

        initSlider(){
            $("#range-container").html('');
            $("#range-container").html('<input id="range-slider" type="text" name="range" value="" />');
            let layer = this.layers[this.activeLayerIndex];
            var min = 0;
            var max_interval = this.activeLayer.duration;
            var step = 0.1;
            var from = this.activeLayer.playStart;
            var to = this.activeLayer.playEnd;
            var videotime = 0;

            this.trimPreviewAudio = new Audio(layer.url);
            this.trimPreviewAudio.currentTime = from;
            this.trimPreviewAudio.addEventListener("ended", (e) => {
                this.trimPreviewIsPlaying = false;
                cancelAnimationFrame(this.trimPreviewFrameId);
            }, false);
            this.trimPreviewAudio.addEventListener("pause", (e) => {
                this.trimPreviewIsPlaying = false;
                cancelAnimationFrame(this.trimPreviewFrameId);
            }, false);

            this.rangeSlider = $("#range-slider");
            this.rangeSliderButtons = $(".slider-controls");
            this.rangeSlider.ionRangeSlider({
                type: "double",
                skin: "modern",
                min: 0,
                max: this.activeLayer.originalDuration,
                // 40: 40,
                // step: 0.1,
                from: from,
                to: to,
                drag_interval: true,
                grid: true,
                grid_snap: true,
                prettify: this.hhmmsss_prettify,
                onStart: (data) => {
                    this.trimPreviewAudio.currentTime = data.from;
                    this.stopTrimPreview();
                    this.limit_filter(data)
                    $(".irs-bar").html('<span id="reader" style="width:0%; height:100%; background:red; position:absolute;"></span>')
                },
                onChange: (data) => {
                    this.trimPreviewAudio.currentTime = data.from;
                    this.stopTrimPreview();
                    $(".irs-bar").html('<span id="reader" style="width:0%; height:100%; background:red; position:absolute;"></span>');
                    this.limit_filter(data)
                },
                onFinish: (data) => {
                    if(data.to > data.from){
                        this.stopTrimPreview();
                        
                        this.activeLayer.playEnd = data.to;
                        this.activeLayer.playStart = data.from;
                        this.trimPreviewAudio.currentTime = data.from;
                        this.activeLayer.duration = data.to - data.from;
                        this.activeLayer.end = data.to - data.from;
                        
                        console.log(data.to, data.from, this.trimPreviewAudio.currentTime);
                    // player.loadVideoById({
                    //     videoId: player.getVideoData()['video_id'],
                    //     startSeconds: data.from,
                    //     endSeconds: data.to
                    // });
                    }
                },
                onUpdate: function (data) {
                }
            });

            var d5_instance = this.rangeSlider.data("ionRangeSlider")
            let duration = d5_instance.old_to - d5_instance.old_from

            console.log(d5_instance.old_to , d5_instance.old_from);


            let vueInstance = this;
            this.rangeSliderButtons.on("mousedown", function (e) {
                isHeldDown = true;
                (function loop (range) {
                    if (!isHeldDown) return
                    // if (1 == 2) {
                    //   player.loadVideoById({
                    //     videoId: player.getVideoData()['video_id'],
                    //     startSeconds: d5_instance.old_from,
                    //     endSeconds: d5_instance.old_to
                    //   });
                    // }
                    if (e.target.id == "slider-start-prev" && duration.toFixed(1) < 40) {
                        var from = d5_instance.old_from - step;
                        var to = d5_instance.old_to;
                        vueInstance.seek(from);
                    }

                    if (e.target.id == "slider-start-next" && duration.toFixed(1) <= 40) {
                        var from = d5_instance.old_from + step;
                        var to = d5_instance.old_to;
                        vueInstance.seek(from);
                    }

                    if (e.target.id == "slider-next" && duration.toFixed(1) < 40) {
                        var from = d5_instance.old_from;
                        var to = d5_instance.old_to + step;
                        vueInstance.seek(to);
                    }

                    if (e.target.id == "slider-end-prev" && duration.toFixed(1) <= 40) {
                        var from = d5_instance.old_from;
                        var to = d5_instance.old_to - step;
                        vueInstance.seek(to);
                    }

                    d5_instance.update({
                        from: from,
                        to: to
                    })

                    setTimeout(loop, 125)
                })();

            }).on("mouseup mouseleave", function () {
                isHeldDown = false;
            });
        },
        limit_filter(data) {
            let duration = data.to - data.from
          
            if(duration == 0) {
              $("#d-pscreen").css('opacity','1').css('cursor','pointer')
              $("#d-file").css('opacity','0.5').css('cursor','no-drop')
              $("#d-audio").css('opacity','0.5').css('cursor','no-drop')
              $("#d-gif").css('opacity','0.5').css('cursor','no-drop')
            } else {
              $("#d-pscreen").css('opacity','0.5').css('cursor','no-drop')
              $("#d-file").css('opacity','1').css('cursor','pointer')
              $("#d-audio").css('opacity','1').css('cursor','pointer')
              $("#d-gif").css('opacity','1').css('cursor','pointer')
            }
            
            if(duration >= 0.1 && duration <= 10) {
              $("#d-gif").css('opacity','1').css('cursor','pointer')
            } else {
              $("#d-gif").css('opacity','0.5').css('cursor','no-drop')
            }
            
            let percentage = duration / 40 * 100
            let color = this.hsl_col_perc(percentage, 0, 100)
            $("#ytduration").text(this.hhmmsss_prettify(duration)).css('color', color)
        },
        hhmmsss_prettify (n) {
            var sec_num = parseInt(n, 10); // don't forget the second param
            var hours   = Math.floor(sec_num / 3600);
            var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
            var seconds = sec_num - (hours * 3600) - (minutes * 60);
            var milisec = n;
        
            if (hours   < 10) {hours   = "0"+hours;}
            if (minutes < 10) {minutes = "0"+minutes;}
            if (seconds < 10) {seconds = "0"+seconds;}
            if (milisec < 10) {milisec = "0"+milisec;}
            return hours+':'+minutes+':'+seconds+'.'+(milisec % 1).toFixed(1).substring(2);
        },
        hsl_col_perc(percent, start, end) {
            var a = percent / 100,
                b = (start - end) * a,
                c = b + end;
            // Return a CSS HSL string
            return 'hsl('+c+', 100%, 50%)';
        },
        seek(from) {
            this.trimPreviewAudio.currentTime = from;
            console.log("from  ---" + from);
            if(player.getPlayerState() == 1) {
            //   player.pauseVideo()
            }
            if(player.getPlayerState() == 2) {
            //   player.seekTo(from);
            }  else {
              // player.pauseVideo();
            }
        },

        playTrimPreview(time){
            let fullTime = this.activeLayer.playEnd - this.activeLayer.playStart;
            let currentTime = this.trimPreviewAudio.currentTime - this.activeLayer.playStart;
            let timeInSecond = 0;
            console.log(this.trimPreviewAudio.currentTime);
            if(this.lastTime != null){
                timeInSecond = time - this.lastTime;
            }
            this.lastTime = time;
            if(this.trimPreviewAudio.currentTime > this.activeLayer.playEnd){
                this.stopTrimPreview();
            }else{
                this.trimPreviewAudio.play();
                // let result = this.activeLayer.playEnd - this.trimPreviewAudio.currentTime / 40 * 100
                
                let result = currentTime * 100 / fullTime;
                console.log([result, fullTime, currentTime]);
                $("#reader").css("width", `${result}%`);
                this.trimPreviewIsPlaying = true;
    
                this.trimPreviewFrameId = requestAnimationFrame( this.playTrimPreview );
            }
            
        },
        stopTrimPreview(){
            this.trimPreviewAudio.pause();
            this.trimPreviewIsPlaying = false;
            cancelAnimationFrame(this.trimPreviewFrameId);
        },

        nextBackgroundMusicPage(){
            this.backgroundMusicCurrentPage += 1;
            if(this.backgroundMusicCurrentPage > this.backgroundMusicLastPage){
                this.backgroundMusicCurrentPage = this.backgroundMusicLastPage;
            }
            this.getBackgroundMusic();
        },
        prevBackgroundMusicPage(){
            this.backgroundMusicCurrentPage -= 1;

            if(this.backgroundMusicCurrentPage < 1){
                this.backgroundMusicCurrentPage = 1;
            }
            this.getBackgroundMusic();
        },

        goToBackgroundMusicPage(){
            if(this.backgroundMusicCurrentPage < 1){
                this.backgroundMusicCurrentPage = 1;
            }

            if(this.backgroundMusicCurrentPage > this.backgroundMusicLastPage){
                this.backgroundMusicCurrentPage = this.backgroundMusicLastPage;
            }
            this.getBackgroundMusic();
        },



        nextBackgroundSoundPage(){
            this.backgroundSoundCurrentPage += 1;
            if(this.backgroundSoundCurrentPage > this.backgroundSoundLastPage){
                this.backgroundSoundCurrentPage = this.backgroundSoundLastPage;
            }
            this.getBackgroundSounds();
        },
        prevBackgroundSoundPage(){
            this.backgroundSoundCurrentPage -= 1;

            if(this.backgroundSoundCurrentPage < 1){
                this.backgroundSoundCurrentPage = 1;
            }
            this.getBackgroundSounds();
        },

        goToBackgroundMusicPage(){
            if(this.backgroundSoundCurrentPage < 1){
                this.backgroundSoundCurrentPage = 1;
            }

            if(this.backgroundSoundCurrentPage > this.backgroundSoundLastPage){
                this.backgroundSoundCurrentPage = this.backgroundSoundLastPage;
            }
            this.getBackgroundSounds();
        },
       

        improveText(text, button){
            if(!this.isLoading && text.length >= 30){
                var prevContent = button.innerHTML;
                button.innerHTML = `<span class="spinner-border text-light" role="status" style="width: 12px; height:12px">
                                        <span class="visually-hidden">Loading...</span>
                                    </span> Improve`;
                this.isLoading = true;
                this.loadingType = "improve_text";
                const formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('selected_text', text);
                formData.append('type', 'improve_text');
    
                axios.post(this.url.masterpieceURL, formData)
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                        let resultText = response.data.text;
                        var sel, range;
                        if (window.getSelection) {
                            sel = window.getSelection();
                            if (sel.rangeCount) {
                                range = sel.getRangeAt(0);
                                range.deleteContents();
                                range.insertNode(document.createTextNode(resultText));
                            }
                        } else if (document.selection && document.selection.createRange) {
                            range = document.selection.createRange();
                            range.text = resultText;
                        }
                        
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                    })
            }else{
                if(this.isLoading){
                    this.$notify({
                        title: 'Warning',
                        message: "Editor action in progress, please wait.",
                        type: 'warning'
                    });
                }

                if(text.length < 30){
                    this.$notify({
                        title: 'Warning',
                        message: "Please select 30 or more characters to proceed",
                        type: 'warning'
                    });
                }
               
            }          
        },
        rephraseText(text, button){
            if(!this.isLoading && text.length >= 30){
                var prevContent = button.innerHTML;
                button.innerHTML = `<span class="spinner-border text-light" role="status" style="width: 12px; height:12px">
                                        <span class="visually-hidden">Loading...</span>
                                    </span> Rephrase`;
                this.isLoading = true;
                this.loadingType = "rephrase_text";
                const formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('selected_text', text);
                formData.append('type', 'rephrase_text');
    
                axios.post(this.url.masterpieceURL, formData)
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                        let resultText = response.data.text;
                        var sel, range;
                        if (window.getSelection) {
                            sel = window.getSelection();
                            if (sel.rangeCount) {
                                range = sel.getRangeAt(0);
                                range.deleteContents();
                                range.insertNode(document.createTextNode(resultText));
                            }
                        } else if (document.selection && document.selection.createRange) {
                            range = document.selection.createRange();
                            range.text = resultText;
                        }
                        
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                    })
            }else{
                if(this.isLoading){
                    this.$notify({
                        title: 'Warning',
                        message: "Editor action in progress, please wait.",
                        type: 'warning'
                    });
                }

                if(text.length < 30){
                    this.$notify({
                        title: 'Warning',
                        message: "Please select 30 or more characters to proceed",
                        type: 'warning'
                    });
                }
               
            }
            
        },
        expandText(text, button){
            if(!this.isLoading && text.length >= 30){
                var prevContent = button.innerHTML;
                button.innerHTML = `<span class="spinner-border text-light" role="status" style="width: 12px; height:12px">
                                        <span class="visually-hidden">Loading...</span>
                                    </span> Expand`;
                this.isLoading = true;
                this.loadingType = "expand_text";
                const formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('selected_text', text);
                formData.append('type', 'expand_text');
    
                axios.post(this.url.masterpieceURL, formData)
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                        let resultText = response.data.text;
                        var sel, range;
                        if (window.getSelection) {
                            sel = window.getSelection();
                            if (sel.rangeCount) {
                                range = sel.getRangeAt(0);
                                range.deleteContents();
                                range.insertNode(document.createTextNode(resultText));
                            }
                        } else if (document.selection && document.selection.createRange) {
                            range = document.selection.createRange();
                            range.text = resultText;
                        }
                        
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                    })
            }else{
                if(this.isLoading){
                    this.$notify({
                        title: 'Warning',
                        message: "Editor action in progress, please wait.",
                        type: 'warning'
                    });
                }

                if(text.length < 30){
                    this.$notify({
                        title: 'Warning',
                        message: "Please select 30 or more characters to proceed",
                        type: 'warning'
                    });
                }
               
            }
            
        },
        shortenText(text, button){
            if(!this.isLoading && text.length >= 30){
                var prevContent = button.innerHTML;
                button.innerHTML = `<span class="spinner-border text-light" role="status" style="width: 12px; height:12px">
                                        <span class="visually-hidden">Loading...</span>
                                    </span> Shorten`;
                this.isLoading = true;
                this.loadingType = "shorten_text";
                const formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('selected_text', text);
                formData.append('type', 'shorten_text');
    
                axios.post(this.url.masterpieceURL, formData)
                    .then((response) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                        let resultText = response.data.text;
                        var sel, range;
                        if (window.getSelection) {
                            sel = window.getSelection();
                            if (sel.rangeCount) {
                                range = sel.getRangeAt(0);
                                range.deleteContents();
                                range.insertNode(document.createTextNode(resultText));
                            }
                        } else if (document.selection && document.selection.createRange) {
                            range = document.selection.createRange();
                            range.text = resultText;
                        }
                        
                    })
                    .catch((error) => {
                        this.isLoading = false;
                        this.loadingType = "";
                        button.innerHTML = prevContent;
                    })
            }else{
                if(this.isLoading){
                    this.$notify({
                        title: 'Warning',
                        message: "Editor action in progress, please wait.",
                        type: 'warning'
                    });
                }

                if(text.length < 30){
                    this.$notify({
                        title: 'Warning',
                        message: "Please select 30 or more characters to proceed",
                        type: 'warning'
                    });
                }
               
            }
        }
          
    },

    
});