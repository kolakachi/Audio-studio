<template>
    <div class="editor-col">
        <h6>Audio Text</h6>
        <div class="col-box">
            <div class="editor-wrap">
                <div class="editor-buttons" style="width: 54%;margin: 0px auto;margin-bottom: 10px;">
                        
                    <div class="dropdown">
                        <button style="color: #7456FE; " class="btn dropdown-toggle" type="button" id="sayAs" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Say as
                        </button>
                        <div class="dropdown-menu" aria-labelledby="sayAs">
                            <button class="dropdown-item" type="button" id="characters_sayas" @click="sayAs('characters')">Characters</button>
                        
                            <button class="dropdown-item" type="button" id="cardinal_sayas" @click="sayAs('cardinal')">Cardinal</button>
                            <button class="dropdown-item" type="button" id="ordinal_sayas" @click="sayAs('ordinal')">Ordinal</button>
                            <button class="dropdown-item" type="button" id="digits_sayas" @click="sayAs('digits')">Digits</button>
                            <button class="dropdown-item" type="button" id="fraction_sayas" @click="sayAs('fraction')">Fraction</button>
                            <button class="dropdown-item" type="button" id="time_sayas" @click="sayAs('time')">Time</button>
                            <button class="dropdown-item" type="button" id="address_sayas" @click="sayAs('address')">Address</button>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="color: #FFB800; " class="btn dropdown-toggle" type="button" id="volume" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Volume
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
                        <button style="color: #FF005C; " class="btn dropdown-toggle" type="button" id="speed" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Speed
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
                        <button style="color: #23A617; " class="btn dropdown-toggle" type="button" id="pitch" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pitch
                        </button>
                        <div class="dropdown-menu" aria-labelledby="pitch">
                            <button class="dropdown-item" type="button" id="x_low_pitch" @click="setPitch('x-low')">x-Low</button>
                            <button class="dropdown-item" type="button" id="low_pitch" @click="setPitch('low')">Low</button>
                            <button class="dropdown-item" type="button" id="medium_pitch" @click="setPitch('medium')">Medium</button>
                            <button class="dropdown-item" type="button" id="high_pitch" @click="setPitch('high')">High</button>
                            <button class="dropdown-item" type="button" id="x_high_pitch" @click="setPitch('x-high')">x-High</button>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button style="color: #00E0FF; " class="btn dropdown-toggle" type="button" id="pause" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pauses
                        </button>
                        <div class="dropdown-menu" aria-labelledby="pause">
                            <button class="dropdown-item" type="button" id="zero_pause" @click="setPause('0s')">0 second</button>
                            <button class="dropdown-item" type="button" id="one_pause" @click="setPause('1s')">1 second</button>
                            <button class="dropdown-item" type="button" id="two_pause" @click="setPause('2s')">2 seconds</button>
                            <button class="dropdown-item" type="button" id="three_pause" @click="setPause('3s')">3 seconds</button>
                            <button class="dropdown-item" type="button" id="four_pause" @click="setPause('4s')">4 seconds</button>
                            <button class="dropdown-item" type="button" id="five_pause" @click="setPause('5s')">5 seconds</button>
                            <button class="dropdown-item" type="button" id="paragraph_pause" @click="setParagraphPause()">Paragraph</button>
                            <button class="dropdown-item" type="button" id="sentence_pause" @click="setSentencePause()">Sentence</button>
                        </div>
                    </div>
                    <!-- <button type="button" class="btn">Language</button> -->
                </div>
                <div class="audio-textarea-wrap">
                    <div id="selection-ref"></div>
                    <div class="audio-textarea form-control scope-four" id="audio-textarea" contenteditable="true"></div>
                    

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
                                    <div v-if="fileName == '' " class="upload-file-description" style="margin-top: 10px;
                                    color: #fff;"><a href="#" @click="openFileExplorer()">Browse</a> your file</div>
                                    <div v-if="fileName != '' " class="upload-file-description" style="margin-top: 10px;
                                    color: #fff;">{{fileName}}<br> <a href="#" @click="clearUpload()">Change</a> file</div>
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
                                    {{teleprompter.text }}
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
                    </div>
                    
                    <div class="record-audio-wave-wrap">
                        
                        <div v-show="recordingDone">
                            
                        <div class="progress" v-show="recordingDone">
                            <input type="range" min="0" :max="rangeMaximum" v-model="currentRange" style="width: 100%" id="time-range">

                            
                        </div>
                        <div class="recording-duration">{{audioTimeReader }}</div>
                        </div>
                        <img v-show="!recordingDone" src="/assets/img/waveform.svg" alt="" class="record-audio-wave">
                    </div>
                    <div class="record-audio-buttons">
                        <div v-if="!recordingDone && isRecording" class="recording-wrap">
                        <button class="btn recording-btn" @click="stopRecording">
                            <span class="record-icon"></span>
                        </button>

                        <div class="recording-duration">{{timeDisplay }}</div>
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
        <!-- End Record Modal -->

        <!-- LISTEN MODAL -->
        <div class="modal fade" id="listenModal" tabindex="-1" aria-labelledby="listenModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-music"></i> Listen Synthesized Text</h4>
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
                    </div>				
                </div>
            </div>
        </div>
        <!-- END LISTEN MODAL -->
    </div>
</template>

<script>
    import Pdf2TextClass from '../utilities/PDFToText.js';

    export default {
        data(){
            return {
                 recordingDone: false,
                 isRecording: false,
                 objectUrl:'',
                 fileType:'',
                 fileName:'',
                 timeDisplay: '00:00',
                 currentRange: 0,
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
                currentRange:0,

                mediaRecorder:{},
                audioChunks:[],
                audioBlob:{},
                audioUrl:{},
                audio:{},
                startTime:'',
                audioTimeReader:'00:00',
                refreshIntervalId: 0,
                rangeMaximum:0,
            }
        },
        mounted() {

            var modal = document.getElementById('listenModal')
            modal.addEventListener('hidden.bs.modal',  (event) => {
                var audio = document.getElementById('listen-result');
                if(audio){
                    audio.pause();
                }
            });

            var modal = document.getElementById('recordModal')
            modal.addEventListener('hidden.bs.modal',  (event) => {
                if(Object.keys(this.audio).length != 0){
                    this.audio.pause();
                }
            });

            document.getElementById("audio-textarea").innerHTML = this.speech_text;

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

            // document.addEventListener('keyup', (event) => {
            //     let keyCode = window.event.keyCode;
            //     if(this.prevKey == 39 && keyCode == 39){
            //         // console.log("right two times")
            //         this.prevKey = "";
            //     }else if (this.prevKey == 37 && keyCode == 37) {
            //         // console.log("left two times")
            //         this.prevKey = "";
            //     }else{
            //         this.prevKey = keyCode;
            //     }
                
            //     // console.log(this.prevKey, keyCode);
            // });

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

            GreenAudioPlayer.init({
                selector: '.listen-result-player', // inits Green Audio Player on each audio container that has class "player"
                stopOthersOnPlay: false,
                showDownloadButton: false,
                showTooltips: true
            });

        

        },
        computed: {
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
            selectedLanguageId:{
                get () {
                    return this.$store.state.selectedLanguageId
                },
                set (value) {
                    this.$store.commit('updateSelectedLanguageId', value)
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
            voiceIdError:{
                get(){
                    return this.$store.state.voiceIdError
                },
                set (value) {
                    this.$store.commit('updateVoiceIdError', value)
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
            editNameError:{
                get () {
                    return this.$store.state.editNameError
                },
                set (value) {
                    this.$store.commit('updateEditNameError', value)
                }
            },
            edit_name: {
                 get () {
                    return this.$store.state.edit_name
                },
            },
            speech_text:{
                get () {
                    return this.$store.state.speech_text
                },
                set (value) {
                    this.$store.commit('updateSpeechText', value)
                }
            }
        },
        methods:{
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

                var selection = window.getSelection();
                
                for (var i = 0; i < 0; i += 1) {
                    selection.modify('extend', 'backward', 'character');
                }
                let selectedText = selection.baseNode.data.substring(selection.baseOffset,selection.extentOffset);
                var replacement = openTag + selectedText + closeTag;
                document.execCommand('insertHTML', false, replacement);
                
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

            stopRecording(){
                this.recordingDone = true;
                this.mediaRecorder.stop();
                clearInterval(this.refreshIntervalId);
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
            
            updateDateTime() {
                var sec;
                sec = this.recordingTime() | 0;
                this.rangeMaximum = sec;
                this.timeDisplay = "" + (this.minSecStr(sec / 60 | 0)) + ":" + (this.minSecStr(sec % 60));
            },
            minSecStr(n) {
                return (n < 10 ? "0" : "") + n;
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

            openFileExplorer(){
                $("#doc-upload").click();
            },
            fileonUpload(event){
                var file = event.currentTarget.files[0];
                this.objectUrl = URL.createObjectURL(file);
                this.fileType = file.type;
                this.fileName = event.currentTarget.files[0].name;
            },
            clearUpload(){
                this.objectUrl = '';
                this.fileType = '';
                this.fileName = '';
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
            teleprompterScrolldown() {
                this.teleprompter.status = 2
                var contentobj = document.getElementById("prompter-content");
                var contentheight = contentobj.offsetHeight;
                if(window.scrolltimerup){
                    clearTimeout(window.scrolltimerup)
                }
                if(parseInt(contentobj.style.top)>=(contentheight*(-1)+100)){
                    
                    let prompterTop =parseInt(contentobj.style.top) - this.teleprompter.step;
                    contentobj.style.top = prompterTop + 'px';
                }
                window.scrolltimerdown = setTimeout(this.teleprompterScrolldown, this.teleprompter.scspeed)
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
                    clearTimeout(window.scrolltimerup)
                }
                if(window.scrolltimerdown){
                    clearTimeout(window.scrolltimerdown)
                }
            },
            resetTeleprompter(){
                console.log(this.teleprompter);
                this.teleprompter.speedSize = 1;
                this.teleprompter.fontSize =14;
                this.setspeed();
                console.log(this.teleprompter);
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

            addRecordedAudio(){
                this.$store.dispatch('addRecordedAudio', this);
            },

            submitSynthesizeRequest(type) {
                let error = false;
                if(this.edit_name == ""){
                    error = true;
                    this.editNameError = "Name is required";
                }
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
            },
            synthesize(type){
                let textarea = this.cleanTextEditor().replaceAll('&nbsp;', ' ');
                this.speech_text = textarea;
                console.log(this.speech_text);
                this.$store.dispatch('synthesize', type);
            },

            addPreviewToTimeLine(){
                let audio = document.getElementById('listen-result');
                audio.pause();
                audio.src = "";

                this.addTranslatedAudioToLayer(this.prevSynthesizeAudioURL, this.prevSynthesizePath);

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
            improveText(text, button){
                this.$store.dispatch('improveText', {
                    text:text,
                    button: button
                })
            },
            rephraseText(text, button){
                this.$store.dispatch('rephraseText', {
                    text:text,
                    button: button
                })
            },
            expandText(text, button){
                this.$store.dispatch('expandText', {
                    text:text,
                    button: button
                })
            },
            shortenText(text, button){
                this.$store.dispatch('shortenText', {
                    text:text,
                    button: button
                })
            }

            
        }
    }
</script>
