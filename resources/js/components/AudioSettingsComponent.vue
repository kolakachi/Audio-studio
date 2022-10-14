<template>
    <!-- <div> -->
        <div class="params-col">
            <h6>Audio settings</h6>

            <div class="col-box">
                <div class="row mb-4">
                    <label for="language" class="col-sm-3 col-form-label">Audio Name</label>
                    <div class="col-sm-9">
                        <input type="text" 
                        v-validate="'required'" name="edit_name" data-vv-as="Name"
                        v-model="edit_name" class="form-control" id="">
                        <div v-if="editNameError != '' ">
                            <span class="small text-danger">
                                {{ editNameError }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label for="language" class="col-sm-3 col-form-label">Select Language</label>
                    <div class="col-sm-9">
                    <div class="form-select-wrap">
                        <img v-if="selectedLanguageId != 0" :src="selectedLanguage.language_flag" alt="US" class="form-select-icon">
                        <select id="language" class="form-select" 
                        v-validate="'required'" name="selectedLanguageId" data-vv-as="Language"
                        v-model="selectedLanguageId">
                            <option value="0" disabled selected>Select Language</option>
                            <option v-for="(language, index) in languages" :value="language.id" :key="index">{{language.language}}</option>
                        </select>
                        <div v-if="languageIdError != '' ">
                            <span class="small text-danger">
                                {{languageIdError }}
                            </span>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="voice" class="col-sm-3 col-form-label">Choose Voice</label>
                    <div class="col-sm-9">
                    <div class="form-select-wrap">
                        <img v-if="selectedLanguageId != 0" :src="selectedLanguage.language_flag" alt="US" class="form-select-icon">
                        <select id="voice" class="form-select" 
                        v-validate="'required'" name="selectedVoiceId" data-vv-as="Voice"
                        v-model="selectedVoiceId" @change="setVoice()">
                            <option value="0" disabled selected>Select Voice</option>
                            <option v-for="(voice, index) in getVoices" :key="index" :value="voice.voice_id">{{voice.voice}} [{{voice.gender }}]</option>
                        </select>
                        <div v-if="voiceIdError != '' ">
                            <span class="small text-danger">
                                {{voiceIdError }}
                            </span>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label for="preview" class="col-sm-3 col-form-label">Preview</label>
                    <audio controls="controls" src="" id="preview-audio" style="display: none"></audio>

                    <div class="col-sm-9">
                        <div class="preview-voice">
                            <div class="btn preview-btn" @click="playPreview()">
                                <span class="icon"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path><path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path></svg></span>
                            </div>

                            <div id="preview" class="progress">
                                <input type="range" min="0" :max="previewRangeMaximum" v-model="currentPreviewRange" style="width: 100%" id="preview-time-range">

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

                        <div class="form-check" v-if="userAccess.number_of_audio_output > 1">
                            <input class="form-check-input" type="checkbox" value="" id="ogg" :checked="selectedFormat == 'ogg'" @click="setFormat('ogg')">
                            <label class="form-check-label" for="ogg">
                                OGG
                            </label>
                        </div>

                        <div class="form-check" v-if="userAccess.number_of_audio_output > 1">
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
    <!-- </div> -->
</template>

<script>
    export default {
        data(){
            return {
                prevAudio: {},
                voices:[],
                // selectedVoiceId:0,
                selectedVoice:{},
                previewRangeMaximum:0,
                currentPreviewRange:0
            }
        },
        mounted() {

            this.prevAudio = document.getElementById('preview-audio');
            var previewRange = document.getElementById("preview-time-range");

            var prevAudioListener = () => {
                window.requestAnimationFrame(() => {
                    this.prevAudio.currentTime = previewRange.value
                });
            };
            previewRange.addEventListener("mousedown", function() {
                prevAudioListener();
                previewRange.addEventListener("mousemove", prevAudioListener);
            });
            previewRange.addEventListener("mouseup", function() {
                previewRange.removeEventListener("mousemove", prevAudioListener);
            });
        },
        computed: {
            edit_name: {
                get () {
                    return this.$store.state.edit_name
                },
                set (value) {
                    this.$store.commit('updateProjectName', value)
                }
            },
            editNameError:{
                get () {
                    return this.$store.state.editNameError
                },
                set (value) {
                    this.$store.commit('updateEditNameError', value)
                }
            },
            languages() {
                return this.$store.state.languages
            },
            userAccess() {
                return this.$store.state.userAccess
            },
            selectedLanguageId:{
                get () {
                    return this.$store.state.selectedLanguageId
                },
                set (value) {
                    this.$store.commit('updateSelectedLanguageId', value)
                }
            },
            languageIdError:{
                get () {
                    return this.$store.state.languageIdError
                },
                set (value) {
                    this.$store.commit('updateLanguageIdError', value)
                }
            },
            selectedLanguage:{
                get () {
                    return this.$store.state.selectedLanguage
                }
            },
            getVoices(){
                return this.$store.getters.getvoices
            },
            voiceIdError:{
                get(){
                    return this.$store.state.voiceIdError
                },
                set (value) {
                    this.$store.commit('updateVoiceIdError', value)
                }
            },
            selectedVoiceId:{
                get () {
                    return this.$store.state.selectedVoiceId
                },
                set (value) {
                    this.$store.commit('updateSelectedVoiceId', value)
                }
            },
            selectedFormat:{
                get () {
                    return this.$store.state.selectedFormat
                }
            }
        },
        methods:{
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
            setVoice() {
                this.prevAudio = document.getElementById('preview-audio');
                
                this.prevAudio.src = '';
                this.prevAudio.load();
                let voicePath = '';
                this.voices = this.$store.state.voices;
                for(let key in this.voices){
                    if(this.selectedVoiceId != 0){
                        if(this.voices[key].voice_id == this.selectedVoiceId && (this.voices[key].language_code == this.selectedLanguage.language_code)){
                            this.selectedVoice = Object.assign({}, this.voices[key]);

                            let name = this.voices[key].voice;
                            let capitalisedName =  name.charAt(0).toUpperCase() + name.slice(1);
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
            setFormat(value) {
                this.$store.commit('setFormat', value)
            }
        }
    }
</script>
