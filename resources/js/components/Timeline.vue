<template>
    <div class="timeline-row">
        <div class="long-col" style="width: 100%;">
            <div class="Panel" id="controls" style="display: none">
                <div class="Row controls-wrapper">
                    <button class="Button controls-btn" id="prev-btn" @click="handleControlClick('prev')" style="background: url('files/prev.svg'); "></button>
                    <button class="Button controls-btn" id="play-btn" @click="handleControlClick('play')" style="background: url('files/play.svg');"></button>
                    <button class="Button controls-btn" id="next-btn" @click="handleControlClick('next')" style="background: url('files/next.svg');"></button>
                    <span class="Text timeline-time" id="time-text">0:00.00</span>
                    <span class="Text timeline-speed" id="rate-text">1.0x</span>
                    <button class="Button expand-btn controls-btn" style="background: url('files/fullscreen.svg'); "></button>
                </div>
            </div>
            <div class="timeline-wrap" style="max-height: 170px;">
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
        <div id="audio-container" style="display: none"></div>
        <div class="modal fade" id="popupVolumeModal" tabindex="-1" aria-labelledby="popupVolumeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content" style="background:#353B5A">
                    <div class="modal-header" style="border-bottom: none; padding:5px">
                        <h6 class="modal-title" id="popupVolumeModalLabel"><i class="fa fa-music"></i> Set volume</h6>
                        <button class="btn close-btn" data-bs-dismiss="modal">
                            <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
                        </button>
                    </div>
                    <div class="modal-body">        
                        <div class="popup-volume-slide-container">
                            <input type="range"  v-model="activeLayer.volume" min='0' max='1' step="0.01" @change="setAudioVolume(activeLayerIndex)" class="popup-volume-slider" id="myRange">
                        </div>   
                    </div>				
                </div>
            </div>
        </div>

        <div class="modal fade" id="trimAudioModal" tabindex="-1" aria-labelledby="trimAudioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content" style="background:#353B5A">
                    <div class="modal-header" style="border-bottom: none; padding:5px">
                        <h6 class="modal-title" id="trimAudioModalLabel"><i class="fa fa-music"></i> Trim audio</h6>
                        <button class="btn close-btn" data-bs-dismiss="modal">
                            <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
                        </button>
                    </div>
                    <div class="modal-body" style="padding:25px">        
                        <div class="popup-volume-slide-container" id="range-container">
                            <input id="range-slider" type="text" name="range" value="" />
                        </div> 
                        <div class="text-center mt-4">
                            <button class="btn btn-primary play-project" @click="trimAudioUpdate()" v-if="!trimPreviewIsPlaying">
                                Trim          
                            </button>
                            <button class="btn play-project" @click="playTrimPreview()" v-if="!trimPreviewIsPlaying">
                                <span class="icon" style="font-size: 1.7rem; color: #0dc8a0; line-height: 0;">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path><path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path></svg>
                                </span>          
                            </button>
                            <button class="btn play-project" v-if="trimPreviewIsPlaying" @click="stopTrimPreview()">
                                <span class="icon" style="font-size: 1.7rem; color: #0dc8a0; line-height: 0;">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path><path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path></svg>
                                </span> 
                            </button>
                        </div>  
                        
                    </div>				
                </div>
            </div>
        </div>
    </div>
      
        
</template>

<script>
    export default {
        mounted() {
            this.$store.dispatch('resetDuration');
            this.$store.dispatch('initTimeline');
            this.$store.dispatch('initLayers');

            var modal = document.getElementById('trimAudioModal')
            modal.addEventListener('hidden.bs.modal',  (event) => {

                if( this.$store.state.rangeSlider.data){
                    this.$store.state.rangeSlider.data("ionRangeSlider").destroy();
                }
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
                vueInstance.$store.dispatch('deleteLayer', layerNumber);        
            });

            $(document).on("click", '.popup-btn-clone', function(e){
                let layerNumber = $(this).attr("data-layer-index");
                $('.layer-tooltip').fadeOut();
                vueInstance.$store.dispatch('cloneLayer', layerNumber);        
           
            });

            $(document).on("click", '.popup-btn-volume', function(e){
                let layerNumber = $(this).attr("data-layer-index");
                vueInstance.$store.state.activeLayer = vueInstance.$store.state.layers[layerNumber];
                vueInstance.$store.state.activeLayerIndex = layerNumber;
                $("#popupVolumeModal").modal('show'); 
                e.stopPropagation();         
            });

            $(document).on("click", '.trim-btn', function(e){
                let layerNumber = $(this).attr("data-layer-index");
                vueInstance.$store.state.activeLayer = vueInstance.$store.state.layers[layerNumber];
                vueInstance.$store.state.activeLayerIndex = layerNumber;
                $("#trimAudioModal").modal('show'); 
                vueInstance.initSlider();
                e.stopPropagation();         
            });

            $(document).on("click", '#timeline-wrapper', function(e){
                $('.layer-tooltip').fadeOut();           
            });
        },
        computed:{
            activeLayer: {
                get(){
                    return this.$store.state.activeLayer;
                }
            },
            trimPreviewIsPlaying: {
                get(){
                    return this.$store.state.trimPreviewIsPlaying;
                }
            },
            activeLayerIndex: {
                get(){
                    return this.$store.state.activeLayerIndex;
                }
            }
        },
        methods: {
            handleTimelineWrapperWheelEvent(event){
                if ( event.altKey === true ) {

                    event.preventDefault();
            
                    this.$store.state.scale = Math.max( 2, this.$store.state.scale + ( event.deltaY / 10 ) );
            
                    this.$store.state.signals.timelineScaled.dispatch( this.$store.state.scale );
            
                }
            },
            initSlider(){
                $("#range-container").html('');
                $("#range-container").html('<input id="range-slider" type="text" name="range" value="" />');
                let layer = this.$store.state.layers[this.activeLayerIndex];
                var min = 0;
                var max_interval = this.$store.state.activeLayer.duration;
                var step = 0.1;
                var from = this.$store.state.activeLayer.playStart;
                var to = this.$store.state.activeLayer.playEnd;
                var videotime = 0;

                this.$store.state.trimPreviewAudio = new Audio(layer.url);
                this.$store.state.trimPreviewAudio.currentTime = from;
                this.$store.state.trimPreviewAudio.addEventListener("ended", (e) => {
                    this.$store.state.trimPreviewIsPlaying = false;
                    cancelAnimationFrame(this.$store.state.trimPreviewFrameId);
                }, false);
                this.$store.state.trimPreviewAudio.addEventListener("pause", (e) => {
                    this.$store.state.trimPreviewIsPlaying = false;
                    cancelAnimationFrame(this.$store.state.trimPreviewFrameId);
                }, false);

                this.$store.state.rangeSlider = $("#range-slider");
                this.$store.state.rangeSliderButtons = $(".slider-controls");
                this.$store.state.rangeSlider.ionRangeSlider({
                    type: "double",
                    skin: "modern",
                    min: 0,
                    max: this.$store.state.activeLayer.originalDuration,
                    // 40: 40,
                    // step: 0.1,
                    from: from,
                    to: to,
                    drag_interval: true,
                    grid: true,
                    grid_snap: true,
                    prettify: this.hhmmsss_prettify,
                    onStart: (data) => {
                        this.$store.state.trimPreviewAudio.currentTime = data.from;
                        this.stopTrimPreview();
                        this.limit_filter(data)
                        $(".irs-bar").html('<span id="reader" style="width:0%; height:100%; background:red; position:absolute;"></span>')
                    },
                    onChange: (data) => {
                        this.$store.state.trimPreviewAudio.currentTime = data.from;
                        this.stopTrimPreview();
                        $(".irs-bar").html('<span id="reader" style="width:0%; height:100%; background:red; position:absolute;"></span>');
                        this.limit_filter(data)
                    },
                    onFinish: (data) => {
                        if(data.to > data.from){
                            this.stopTrimPreview();
                            
                            this.$store.state.activeLayer.playEnd = data.to;
                            this.$store.state.activeLayer.playStart = data.from;
                            this.$store.state.trimPreviewAudio.currentTime = data.from;
                            this.$store.state.activeLayer.duration = data.to - data.from;
                            this.$store.state.activeLayer.end = data.to - data.from;
                            
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

                var d5_instance = this.$store.state.rangeSlider.data("ionRangeSlider")
                let duration = d5_instance.old_to - d5_instance.old_from



                let vueInstance = this;
                this.$store.state.rangeSliderButtons.on("mousedown", function (e) {
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
                return hours+':'+minutes+':'+seconds;
                // return hours+':'+minutes+':'+seconds+'.'+(milisec % 1).toFixed(1).substring(2);
            },
            hsl_col_perc(percent, start, end) {
                var a = percent / 100,
                    b = (start - end) * a,
                    c = b + end;
                // Return a CSS HSL string
                return 'hsl('+c+', 100%, 50%)';
            },
            seek(from) {
                this.$store.state.trimPreviewAudio.currentTime = from;
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
                let fullTime = this.$store.state.activeLayer.playEnd - this.$store.state.activeLayer.playStart;
                let currentTime = this.$store.state.trimPreviewAudio.currentTime - this.$store.state.activeLayer.playStart;
                let timeInSecond = 0;
                if(this.$store.state.lastTime != null){
                    timeInSecond = time - this.$store.state.lastTime;
                }
                this.$store.state.lastTime = time;
                if(this.$store.state.trimPreviewAudio.currentTime > this.$store.state.activeLayer.playEnd){
                    this.stopTrimPreview();
                }else{
                    this.$store.state.trimPreviewAudio.play();
                    // let result = this.activeLayer.playEnd - this.trimPreviewAudio.currentTime / 40 * 100
                    
                    let result = currentTime * 100 / fullTime;
                    $("#reader").css("width", `${result}%`);
                    this.$store.state.trimPreviewIsPlaying = true;
        
                    this.$store.state.trimPreviewFrameId = requestAnimationFrame( this.playTrimPreview );
                }
                
            },
            stopTrimPreview(){
                this.$store.state.trimPreviewAudio.pause();
                this.$store.state.trimPreviewIsPlaying = false;
                cancelAnimationFrame(this.$store.state.trimPreviewFrameId);
            },

            trimAudioUpdate(){
                this.$store.dispatch('initTimeline');
                this.$store.dispatch('updateTimeMark');
                this.$store.dispatch('initLayers');
                $("#trimAudioModal").modal('hide');
            },
            setAudioVolume(index){
                let layer = this.$store.state.layers[index];
                let audioID  = layer.id;
                $("#" + audioID).prop("volume", layer.volume);

            },
        }
    }
</script>
