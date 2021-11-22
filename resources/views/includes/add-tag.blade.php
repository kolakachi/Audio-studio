<button  style="color:#FFF" class="btn btn-success add-timeline-btn mb-4" data-bs-toggle="modal" data-bs-target="#add-tag">
    <span class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>                    
    Add Tag
</button>
<div class="table-wrap">
    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">Name</th>
            </tr>
        </thead> 
        <tbody>
            <tr v-for="(tag, index) in tags">
                <td>@{{ tag.name }}</td>
                <td class="actions">
                    <button class="btn" @click="selectTag(index)" data-bs-toggle="modal" data-bs-target="#edit-tag">
                        <span class="icon">
                            <svg height="512pt" viewBox="0 0 512 511" width="512pt" xmlns="http://www.w3.org/2000/svg" class=""><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"></path><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"></path><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"></path></svg>
                        </span>
                    </button>
                    <button class="btn">
                        <span class="icon">
                            <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M3.10911 15.0411L4.15781 13.9997C3.00953 12.9687 2.10733 11.6931 1.51773 10.267C3.00644 6.54885 7.11322 3.66677 11 3.66677C12.0002 3.67997 12.9914 3.85838 13.9334 4.19479L15.0701 3.05075C13.7814 2.50611 12.399 2.21719 11 2.20006C8.60964 2.28995 6.29802 3.07829 4.35083 4.46766C2.40363 5.85702 0.906232 7.7865 0.0436893 10.0176C-0.0145631 10.1787 -0.0145631 10.3552 0.0436893 10.5163C0.695089 12.2448 1.74538 13.7951 3.10911 15.0411Z" fill="white"></path><path d="M8.06658 10.069C8.11758 9.36619 8.41983 8.70526 8.91807 8.20703C9.4163 7.70879 10.0772 7.40654 10.78 7.35554L12.1074 6.02084C11.3636 5.82499 10.5814 5.82754 9.83892 6.02822C9.09642 6.2289 8.41948 6.6207 7.87561 7.16457C7.33174 7.70844 6.93994 8.38538 6.73926 9.12788C6.53858 9.87039 6.53603 10.6525 6.73188 11.3963L8.06658 10.069Z" fill="white"></path><path d="M21.9563 10.0176C21.1154 7.82724 19.6522 5.93065 17.7469 4.56146L21.267 1.03403L20.2329 0L0.733042 19.4999L1.76707 20.5339L5.50718 16.7938C7.17473 17.7721 9.06691 18.3026 11 18.3339C13.3904 18.244 15.702 17.4556 17.6492 16.0663C19.5964 14.6769 21.0938 12.7474 21.9563 10.5163C22.0146 10.3552 22.0146 10.1787 21.9563 10.0176ZM13.9334 10.267C13.9303 10.7804 13.7925 11.284 13.5338 11.7275C13.2751 12.171 12.9045 12.5388 12.4591 12.7941C12.0137 13.0495 11.509 13.1835 10.9956 13.1827C10.4822 13.1819 9.97793 13.0464 9.53329 12.7897L13.5227 8.80025C13.7864 9.24446 13.9281 9.75042 13.9334 10.267ZM11 16.8671C9.46147 16.8403 7.9521 16.4428 6.59988 15.7084L8.46259 13.8457C9.30987 14.4336 10.3367 14.7052 11.3638 14.6132C12.391 14.5211 13.3531 14.0712 14.0823 13.342C14.8115 12.6128 15.2615 11.6506 15.3535 10.6235C15.4456 9.59633 15.174 8.56949 14.5861 7.72222L16.6908 5.61749C18.3736 6.77251 19.6895 8.38622 20.4823 10.267C18.9936 13.9851 14.8868 16.8671 11 16.8671Z" fill="white"></path></svg>
                        </span>
                    </button>
                    <button class="btn" @click="deleteTag(index)">
                        <span class="icon">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.92129 3.25383L0.201292 1.53383C0.0688118 1.39166 -0.00331137 1.20361 0.000116847 1.00931C0.00354506 0.81501 0.0822571 0.629625 0.21967 0.492212C0.357083 0.354799 0.542468 0.276087 0.736769 0.272659C0.93107 0.269231 1.11912 0.341354 1.26129 0.473834L19.7613 18.9738C19.8938 19.116 19.9659 19.3041 19.9625 19.4984C19.959 19.6927 19.8803 19.878 19.7429 20.0155C19.6055 20.1529 19.4201 20.2316 19.2258 20.235C19.0315 20.2384 18.8435 20.1663 18.7013 20.0338L16.4083 17.7418L16.4053 17.7728C16.3416 18.4223 16.049 19.028 15.5799 19.4815C15.1107 19.9351 14.4955 20.2071 13.8443 20.2488L13.6683 20.2538H6.29429C5.64175 20.2538 5.01048 20.0218 4.5133 19.5991C4.01611 19.1765 3.68541 18.5909 3.58029 17.9468L3.55729 17.7728L2.27629 4.75383H1.48129C1.30005 4.75383 1.12495 4.68819 0.988361 4.56907C0.851773 4.44994 0.76294 4.28539 0.738292 4.10583L0.731292 4.00383C0.731299 3.8226 0.796934 3.64749 0.916059 3.5109C1.03518 3.37431 1.19974 3.28548 1.37929 3.26083L1.48129 3.25383H1.92129ZM15.0363 16.3698L12.4813 13.8138V15.2538C12.4812 15.4439 12.409 15.6268 12.2793 15.7656C12.1496 15.9045 11.972 15.9889 11.7824 16.0019C11.5928 16.0148 11.4054 15.9553 11.258 15.8354C11.1106 15.7155 11.0142 15.5441 10.9883 15.3558L10.9813 15.2538V12.3138L8.98129 10.3138V15.2538C8.98123 15.4439 8.90905 15.6268 8.77932 15.7656C8.64959 15.9045 8.47199 15.9889 8.28241 16.0019C8.09283 16.0148 7.9054 15.9553 7.75799 15.8354C7.61059 15.7155 7.51419 15.5441 7.48829 15.3558L7.48129 15.2538V8.81383L3.82329 5.15683L5.05029 17.6268C5.07835 17.914 5.20492 18.1827 5.40852 18.3872C5.61212 18.5917 5.88021 18.7195 6.16729 18.7488L6.29429 18.7548H13.6683C14.2683 18.7548 14.7773 18.3298 14.8933 17.7528L14.9133 17.6268L15.0363 16.3708V16.3698Z" fill="#FF0000"></path><path d="M10.9993 8.08983L12.4813 9.57183V8.25383L12.4743 8.15183C12.4504 7.97758 12.3661 7.81724 12.2361 7.69885C12.106 7.58046 11.9384 7.51155 11.7627 7.50417C11.587 7.49678 11.4143 7.55139 11.2747 7.65844C11.1352 7.7655 11.0377 7.91819 10.9993 8.08983Z" fill="#FF0000"></path><path d="M16.1783 4.75383L15.4163 12.5068L16.7883 13.8788L17.6853 4.75383H18.4813L18.5833 4.74683C18.7715 4.72093 18.9429 4.62454 19.0629 4.47713C19.1828 4.32973 19.2423 4.1423 19.2293 3.95271C19.2164 3.76313 19.1319 3.58553 18.9931 3.45581C18.8542 3.32608 18.6713 3.25389 18.4813 3.25383H13.2313L13.2263 3.06983C13.1794 2.22446 12.8044 1.43077 12.1811 0.857674C11.5579 0.28458 10.7356 -0.0226716 9.88926 0.00130479C9.04292 0.0252812 8.23934 0.378593 7.64955 0.986051C7.05975 1.59351 6.73029 2.40715 6.73129 3.25383H6.16329L7.66329 4.75383H16.1783ZM9.98129 1.50383C10.9473 1.50383 11.7313 2.28783 11.7313 3.25383H8.23129L8.23729 3.10983C8.27343 2.67213 8.47283 2.26402 8.7959 1.96651C9.11897 1.669 9.5421 1.50385 9.98129 1.50383Z" fill="#FF0000"></path></svg>
                        </span>
                    </button>
                </td>
            </tr> 
        </tbody>
    </table>
</div>

<div class="modal fade" id="add-tag" tabindex="-1" data-bs-backdrop="static" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background:#1d1f42">
        <button class="btn close-btn" data-bs-dismiss="modal">
            <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
        </button>
        <div class="modal-body">
          <div class="record-audio-wrap">
            <div class="record-audio-content">
              <div class="record-audio-label">
                  <label for="">Enter Tag name</label>
                  <input type="text" class="form-control mt-2" v-model="tag.name">
              </div>
              <div class="text-center">
                <button  style="color:#FFF" class="btn btn-success add-timeline-btn mb-4 mt-4" @click="addTag()">
                    <span class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>                    
                    Create Tag
                </button>
              </div>
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="edit-tag" tabindex="-1" data-bs-backdrop="static" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="background:#1d1f42">
        <button class="btn close-btn" data-bs-dismiss="modal">
            <span class="icon"><svg width="19" height="21" viewBox="0 0 19 21" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M1.35 21C1.19 21 1.04 20.94 0.9 20.82C0.78 20.7 0.72 20.56 0.72 20.4C0.72 20.26 0.76 20.13 0.84 20.01L7.71 10.32L1.17 0.989998C1.11 0.889998 1.08 0.759999 1.08 0.6C1.08 0.439999 1.14 0.299999 1.26 0.18C1.38 0.059999 1.52 -1.43051e-06 1.68 -1.43051e-06H3.48C3.78 -1.43051e-06 4.05 0.169999 4.29 0.509999L9.57 8.01L14.82 0.509999C15.02 0.169999 15.28 -1.43051e-06 15.6 -1.43051e-06H17.31C17.47 -1.43051e-06 17.61 0.059999 17.73 0.18C17.85 0.299999 17.91 0.439999 17.91 0.6C17.91 0.78 17.87 0.909999 17.79 0.989998L11.34 10.35L18.18 20.01C18.26 20.13 18.3 20.26 18.3 20.4C18.3 20.56 18.24 20.7 18.12 20.82C18 20.94 17.85 21 17.67 21H15.84C15.54 21 15.27 20.83 15.03 20.49L9.45 12.72L3.9 20.49C3.7 20.83 3.44 21 3.12 21H1.35Z"></path></svg></span>        
        </button>
        <div class="modal-body">
          <div class="record-audio-wrap">
            <div class="record-audio-content">
              <div class="record-audio-label">
                  <label for="">Enter Tag name</label>
                  <input type="text" class="form-control mt-2" v-model="tagEdit.name">
              </div>
              <div class="text-center">
                <button  style="color:#FFF" class="btn btn-success add-timeline-btn mb-4 mt-4" @click="updateTag()">
                    <span class="icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class=""><path d="M0 4C0 2.93913 0.421427 1.92172 1.17157 1.17157C1.92172 0.421427 2.93913 0 4 0H16C17.0609 0 18.0783 0.421427 18.8284 1.17157C19.5786 1.92172 20 2.93913 20 4V16C20 17.0609 19.5786 18.0783 18.8284 18.8284C18.0783 19.5786 17.0609 20 16 20H4C2.93913 20 1.92172 19.5786 1.17157 18.8284C0.421427 18.0783 0 17.0609 0 16V4ZM9 9H5C4.73478 9 4.48043 9.10536 4.29289 9.29289C4.10536 9.48043 4 9.73478 4 10C4 10.2652 4.10536 10.5196 4.29289 10.7071C4.48043 10.8946 4.73478 11 5 11H9V15C9 15.2652 9.10536 15.5196 9.29289 15.7071C9.48043 15.8946 9.73478 16 10 16C10.2652 16 10.5196 15.8946 10.7071 15.7071C10.8946 15.5196 11 15.2652 11 15V11H15C15.2652 11 15.5196 10.8946 15.7071 10.7071C15.8946 10.5196 16 10.2652 16 10C16 9.73478 15.8946 9.48043 15.7071 9.29289C15.5196 9.10536 15.2652 9 15 9H11V5C11 4.73478 10.8946 4.48043 10.7071 4.29289C10.5196 4.10536 10.2652 4 10 4C9.73478 4 9.48043 4.10536 9.29289 4.29289C9.10536 4.48043 9 4.73478 9 5V9ZM17 22C18.3261 22 19.5979 21.4732 20.5355 20.5355C21.4732 19.5979 22 18.3261 22 17V2.536C22.6081 2.88706 23.113 3.392 23.4641 4.00006C23.8151 4.60811 24 5.29787 24 6V17C24 18.8565 23.2625 20.637 21.9497 21.9497C20.637 23.2625 18.8565 24 17 24H6C5.29787 24 4.60811 23.8151 4.00006 23.4641C3.392 23.113 2.88706 22.6081 2.536 22H17Z" fill="white"></path></svg></span>                    
                    Update Tag
                </button>
              </div>
              
              
            </div>
          </div>
        </div>
      </div>
    </div>
</div>