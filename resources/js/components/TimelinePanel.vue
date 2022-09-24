<template>
    <!-- <div> -->
        <div class="actions-row mt-5">
            <div class="short-col">
                <button class="btn add-track-btn" data-bs-toggle="modal" data-bs-target="#addMusicTrackModal" style="font-size:.9rem">
                + Music Track
                </button>
                <div class="btn-group timeline-actions" role="group">
                    
                </div>
            </div>
            <div class="long-col">
                <div class="project-actions player-wrap">
                    <button class="btn play-project" @click="zoomOut()" v-if="!player.isPlaying">
                        <span class="icon">
                            -
                        </span>            
                    </button>
                    <button class="btn play-project" @click="zoomIn()" v-if="!player.isPlaying">
                        <span class="icon">
                            +
                        </span>            
                    </button>
                    <button class="btn play-project" @click="play()" v-if="!player.isPlaying">
                        <span class="icon">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg" class="">
                                <path d="M7.07143 16.5C6.86305 16.5 6.6632 16.4172 6.51585 16.2699C6.3685 16.1225 6.28572 15.9227 6.28572 15.7143V6.28571C6.28579 6.15183 6.32007 6.02019 6.3853 5.90328C6.45054 5.78637 6.54456 5.68807 6.65846 5.6177C6.77235 5.54734 6.90234 5.50724 7.03608 5.50121C7.16982 5.49519 7.30289 5.52344 7.42265 5.58328L16.8512 10.2976C16.9816 10.3629 17.0911 10.4632 17.1677 10.5872C17.2443 10.7113 17.2849 10.8542 17.2849 11C17.2849 11.1458 17.2443 11.2887 17.1677 11.4128C17.0911 11.5368 16.9816 11.6371 16.8512 11.7024L7.42265 16.4167C7.31361 16.4713 7.19338 16.4998 7.07143 16.5ZM7.85715 7.557V14.443L14.7431 11L7.85715 7.557Z"></path>
                                <path d="M11 1.57143C12.8648 1.57143 14.6877 2.1244 16.2382 3.16043C17.7888 4.19645 18.9972 5.66899 19.7109 7.39184C20.4245 9.11469 20.6112 11.0105 20.2474 12.8394C19.8836 14.6684 18.9856 16.3484 17.667 17.667C16.3484 18.9856 14.6684 19.8836 12.8394 20.2474C11.0105 20.6112 9.11469 20.4245 7.39185 19.7109C5.669 18.9972 4.19646 17.7888 3.16043 16.2382C2.12441 14.6877 1.57143 12.8648 1.57143 11C1.57143 8.49939 2.5648 6.10119 4.333 4.33299C6.1012 2.56479 8.49939 1.57143 11 1.57143ZM11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476611 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3165 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C22 8.08262 20.8411 5.28472 18.7782 3.22182C16.7153 1.15892 13.9174 0 11 0Z"></path>
                            </svg>
                        </span>            
                    </button>
                    <button class="btn recording-btn" v-if="player.isPlaying" @click="stop">
                    <span class="record-icon"></span>
                    </button>
                
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

            <!-- Add Music Track Modal -->
            <div class="modal fade" id="addMusicTrackModal" tabindex="-1" aria-labelledby="addMusicTrackModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-pills nav-fill" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="library-tab" data-bs-toggle="tab" @click="setActiveTab('library')" data-bs-target="#library" type="button" role="tab" aria-controls="library" aria-selected="true">Music Library</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="upload-tab" data-bs-toggle="tab" @click="setActiveTab('upload')" data-bs-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Upload</button>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="library" role="tabpanel" aria-labelledby="library-tab" style="height: 500px; overflow-y:scroll">
                                <select class="form-select category-select" v-model="trackType" @change="getfiles()">
                                    <option selected value="0">Music Category</option>
                                    <option value="music">Music</option>
                                    <option value="sounds">Sounds</option>
                                </select>
                                <span class="spinner-border text-light" role="status" v-if="loadingType == 'background_sounds' || loadingType == 'background_music'" style="width: 12px; height:12px">
                                    <span class="visually-hidden">Loading...</span>
                                </span>

                                <div class="track-list-wrap" v-if="trackType == 'sounds'">
                                    <div class="track-list">
                                        <div v-for="(sound, index) in backgroundSounds" :key="index" class="track-item">
                                            <div class="icon-wrap" @click="playSoundPreview(sound)">
                                                <span class="icon" v-if="trackName == sound.name && libraryPreviewAudioIsPlaying">
                                                    <svg width="25" height="29" viewBox="0 0 25 29" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M4.6875 0C5.9307 0 7.12299 0.49386 8.00206 1.37294C8.88114 2.25201 9.375 3.4443 9.375 4.6875V23.4375C9.375 24.6807 8.88114 25.873 8.00206 26.7521C7.12299 27.6311 5.9307 28.125 4.6875 28.125C3.4443 28.125 2.25201 27.6311 1.37294 26.7521C0.49386 25.873 2.61985e-08 24.6807 0 23.4375V4.6875C0 3.4443 0.49386 2.25201 1.37294 1.37294C2.25201 0.49386 3.4443 0 4.6875 0ZM20.3125 0C21.5557 0 22.748 0.49386 23.6271 1.37294C24.5061 2.25201 25 3.4443 25 4.6875V23.4375C25 24.6807 24.5061 25.873 23.6271 26.7521C22.748 27.6311 21.5557 28.125 20.3125 28.125C19.0693 28.125 17.877 27.6311 16.9979 26.7521C16.1189 25.873 15.625 24.6807 15.625 23.4375V4.6875C15.625 3.4443 16.1189 2.25201 16.9979 1.37294C17.877 0.49386 19.0693 0 20.3125 0Z" fill="white"></path></svg>
                                                </span>
                                                <span class="icon" v-else>
                                                    <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg>
                                                </span>
                                                
                                            </div>
                                            <a href="#" class="track-title" @click="playSoundPreview(sound)">
                                                {{sound.name}}
                                            </a>
                                            <div class="track-duration">
                                                <span v-if="trackisLoading && trackName == sound.name"><i>please wait..</i></span>
                                                <span v-else style="cursor: pointer;" @click="addLibraryAudioToTimeline(sound)">Use</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pagination col-12">
                                        <ul class="pagination">
                                            <li class="pagination-item">
                                            <a href="#" @click="prevBackgroundSoundPage" >Previous</a>
                                            </li>
                                            <li class="pagination-item">
                                                <input v-model="backgroundSoundCurrentPage"  type="number" value="backgroundSoundCurrentPage" min="1" :max="backgroundSoundLastPage" @keyup.enter="goToBackgroundMusicPage()">
                                            </li>
                                            <li class="pagination-item">
                                            <a href="#" @click="nextBackgroundSoundPage">Next</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="track-list-wrap" v-if="trackType == 'music'">
                                    <div class="track-list">
                                        <div v-for="(music, index) in backgroundMusic" :key="index" class="track-item">
                                            <div class="icon-wrap" @click="playSoundPreview(music)">
                                                <span class="icon" v-if="trackName == music.name && libraryPreviewAudioIsPlaying">
                                                    <svg width="25" height="29" viewBox="0 0 25 29" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M4.6875 0C5.9307 0 7.12299 0.49386 8.00206 1.37294C8.88114 2.25201 9.375 3.4443 9.375 4.6875V23.4375C9.375 24.6807 8.88114 25.873 8.00206 26.7521C7.12299 27.6311 5.9307 28.125 4.6875 28.125C3.4443 28.125 2.25201 27.6311 1.37294 26.7521C0.49386 25.873 2.61985e-08 24.6807 0 23.4375V4.6875C0 3.4443 0.49386 2.25201 1.37294 1.37294C2.25201 0.49386 3.4443 0 4.6875 0ZM20.3125 0C21.5557 0 22.748 0.49386 23.6271 1.37294C24.5061 2.25201 25 3.4443 25 4.6875V23.4375C25 24.6807 24.5061 25.873 23.6271 26.7521C22.748 27.6311 21.5557 28.125 20.3125 28.125C19.0693 28.125 17.877 27.6311 16.9979 26.7521C16.1189 25.873 15.625 24.6807 15.625 23.4375V4.6875C15.625 3.4443 16.1189 2.25201 16.9979 1.37294C17.877 0.49386 19.0693 0 20.3125 0Z" fill="white"></path></svg>
                                                </span>
                                                <span class="icon" v-else>
                                                    <svg width="18" height="22" viewBox="0 0 18 22" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M18 10.8019C18 11.3401 17.451 11.7271 17.451 11.7271L2.0412 21.2725C0.918 22.0087 0 21.4633 0 20.0683V1.53374C0 0.135137 0.918 -0.406663 2.043 0.327737L17.4528 9.87674C17.4528 9.87674 18 10.2637 18 10.8019Z"></path></svg>
                                                </span>
                                                
                                            </div>
                                            <a href="#" class="track-title" @click="playSoundPreview(music)">
                                                {{music.name}}
                                            </a>
                                            <div class="track-duration">
                                                <span v-if="trackisLoading && trackName == music.name"><i>please wait..</i></span>
                                                <span v-else style="cursor: pointer;" @click="addLibraryAudioToTimeline(music)">Use</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pagination col-12">
                                        <ul class="pagination">
                                            <li class="pagination-item">
                                            <a href="#" @click="prevBackgroundMusicPage" >Previous</a>
                                            </li>
                                            
                                            
                                            <li class="pagination-item">
                                                <input v-model="backgroundMusicCurrentPage"  type="number" value="backgroundMusicCurrentPage" min="1" :max="backgroundMusicLastPage" @keyup.enter="goToBackgroundMusicPage()">
                                            </li>
                                            
                                            <li class="pagination-item">
                                            <a href="#" @click="nextBackgroundMusicPage">Next</a>
                                            </li>
                                        </ul>
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
                                                {{audioUploadName}} 
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
                        <button type="button" class="btn btn-success" v-if="activeTab != 'library'" @click="addUploadedAudioToTimeline" :disabled="audioUploadName == '' || isLoading">
                            <span class="spinner-border text-light" role="status" v-if="loadingType == 'audioUpload'" style="width: 12px; height:12px">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                            Insert</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Add Music Track Modal -->
        </div>
    <!-- </div> -->
    
    
</template>

<script>
    import { Notification } from 'element-ui'
    export default {
        data(){
            return {
                trackisLoading:false,
                trackName:'',
                activeTab: 'library',
                trackType: "0",
                audioUploadName:'',
                libraryPreviewAudio: {},
                libraryPreviewAudioIsPlaying: false,

                backgroundMusicCurrentPage: 1,
                backgroundSoundCurrentPage: 1,
            }
        },
        mounted() {
            var modal = document.getElementById('addMusicTrackModal');
            modal.addEventListener('hidden.bs.modal',  (event) => {
                this.libraryPreviewAudioIsPlaying = false;
                if(Object.keys(this.libraryPreviewAudio).length != 0){
                    this.libraryPreviewAudio.pause();
                }
            });
        },
        computed: {
            player: {
                get(){
                    return this.$store.state.aPlayer
                },
            },
            isLoading:{
                get(){
                    return this.$store.state.isLoading
                },
                set (value) {
                    this.$store.commit('updateIsLoading', value)
                }
            },
            loadingType:{
                get(){
                    return this.$store.state.loadingType
                },
                set (value) {
                    this.$store.commit('updateLoadingType', value)
                }
                
            },
            backgroundSounds:{
                get(){
                    return this.$store.state.backgroundSounds
                }
            },
            backgroundMusic:{
                get(){
                    return this.$store.state.backgroundMusic
                }
            },
            backgroundSoundLastPage: {
                get(){
                    return this.$store.state.backgroundSoundLastPage
                },
                set (value) {
                    this.$store.commit('updateBackgroundSoundLastPage', value)
                }
            },
            backgroundMusicLastPage: {
                get(){
                    return this.$store.state.backgroundMusicLastPage
                },
                set (value) {
                    this.$store.commit('updateBackgroundMusicLastPage', value)
                }
            }
        },
        methods:{
            zoomOut(){
                this.$store.dispatch('zoomOut');
            },
            zoomIn(){
                this.$store.dispatch('zoomIn');
            },
            play(){
                this.$store.dispatch('play');
            },
            stop(){
                this.$store.dispatch('stop');
            },
            makeSaveRequest(){
                this.$store.dispatch('makeSaveRequest');
            },
            makeExportRequest(){
                this.$store.dispatch('makeExportRequest');
            },
            setActiveTab(type){
                this.activeTab = type;
            },
            getfiles(){
                if(this.trackType == 'music'){
                    if(this.backgroundMusic.length < 1){
                        this.$store.dispatch('getBackgroundMusic',this.backgroundMusicCurrentPage);
                    }
                }
                if(this.trackType == 'sounds'){
                    if(this.backgroundSounds.length < 1){
                        this.$store.dispatch('getBackgroundSounds', this.backgroundSoundCurrentPage);
                    }
                }
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
                    this.libraryPreviewAudio.addEventListener("ended", () => {
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
            },
            addLibraryAudioToTimeline(sound){
                this.$store.dispatch('addLibraryAudioToTimeline', sound);
            },

            nextBackgroundMusicPage(){
                this.backgroundMusicCurrentPage += 1;
                if(this.backgroundMusicCurrentPage > this.backgroundMusicLastPage){
                    this.backgroundMusicCurrentPage = this.backgroundMusicLastPage;
                }
                this.$store.dispatch('getBackgroundMusic', this.backgroundMusicCurrentPage);
            },
            prevBackgroundMusicPage(){
                this.backgroundMusicCurrentPage -= 1;

                if(this.backgroundMusicCurrentPage < 1){
                    this.backgroundMusicCurrentPage = 1;
                }
                this.$store.dispatch('getBackgroundMusic', this.backgroundMusicCurrentPage);
            },

            goToBackgroundMusicPage(){
                if(this.backgroundMusicCurrentPage < 1){
                    this.backgroundMusicCurrentPage = 1;
                }

                if(this.backgroundMusicCurrentPage > this.backgroundMusicLastPage){
                    this.backgroundMusicCurrentPage = this.backgroundMusicLastPage;
                }
                this.$store.dispatch('getBackgroundMusic', this.backgroundMusicCurrentPage);
            },



            nextBackgroundSoundPage(){
                this.backgroundSoundCurrentPage += 1;
                if(this.backgroundSoundCurrentPage > this.backgroundSoundLastPage){
                    this.backgroundSoundCurrentPage = this.backgroundSoundLastPage;
                }
                this.$store.dispatch('getBackgroundSounds', this.backgroundSoundCurrentPage);
            },
            prevBackgroundSoundPage(){
                this.backgroundSoundCurrentPage -= 1;

                if(this.backgroundSoundCurrentPage < 1){
                    this.backgroundSoundCurrentPage = 1;
                }
                this.$store.dispatch('getBackgroundSounds', this.backgroundSoundCurrentPage);
            },

            goToBackgroundMusicPage(){
                if(this.backgroundSoundCurrentPage < 1){
                    this.backgroundSoundCurrentPage = 1;
                }

                if(this.backgroundSoundCurrentPage > this.backgroundSoundLastPage){
                    this.backgroundSoundCurrentPage = this.backgroundSoundLastPage;
                }
                this.$store.dispatch('getBackgroundSounds', this.backgroundSoundCurrentPage);
            },

            activateFileUploader(){
                $("#media-file").click();
            },

            getMediaUploaded(event){
                this.uploadedFile = event.currentTarget.files[0];
                this.audioUploadName = this.uploadedFile.name;
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
                    axios.post(this.$store.state.url.storeAudioUpload, formData)
                        .then((response) => {
                            this.isLoading = false;
                            this.loadingType = "";

                            let path = response.data.path;
                            this.$store.dispatch('addAudioLayer', {
                                file: this.uploadedFile,
                                path: path
                            });
                            this.uploadedFile = {}
                            this.audioUploadName = "";
                            $("#addMusicTrackModal").modal('hide');
                        
                            
                            Notification({
                                title: 'Success',
                                message: response.data.message,
                                type: 'success'
                            });
                        })
                        .catch((error) => {
                            this.isLoading = false;
                            this.loadingType = "";

                            Notification({
                                title: 'Error',
                                type: 'error',
                                message: error.response.data.message
                            });
                        })

                    

                }
            },
        }
    }
</script>
