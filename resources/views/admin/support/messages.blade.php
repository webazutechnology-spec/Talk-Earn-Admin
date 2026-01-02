@extends('admin.layouts.app')

@section('content')
    <div class="chat-wrapper">
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <div class="d-flex align-items-center">
                    <div class="chat-user-online">
                        <img src="{{ asset('profile/' . auth()->user()->image) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" width="45" height="45" class="rounded-circle" alt="" />
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <p class="mb-0">{{ Auth::user()->name }} <br><small>{{Auth::user()->code}}</small></p>
                    </div>
                </div>
                <div class="mb-3"></div>
            </div>
            <div class="chat-sidebar-content">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-Chats">
                        <div class="chat-list">
                            <div class="list-group list-group-flush">
                                @foreach ($support as $svalue)
                                <a href="{{ route('ticket-reply',['id' => $svalue->id]) }}" class="list-group-item">
                                    <div class="d-flex">
                                        <div class="chat-user">
                                            <img src="{{ asset('profile/' . $svalue->user->image??'') }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" width="42" height="42" class="rounded-circle" alt="" />
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0 chat-title">{{ $svalue->user->name??'NA' }}</h6>
                                            <p class="mb-0 chat-msg">{{ $svalue->replies->first()->description ?? '' }}</p>
                                        </div>
                                        <div class="chat-time">{{ $svalue->replies->first()->created_at??'' }}</div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-header d-flex align-items-center">
            <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i>
            </div>
            <div>
                <h5 class="mb-1 font-weight-bold">{{ $data->subject }}</h5>
                <div class="list-inline d-sm-flex mb-0 d-none"> 
                    <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary"><small class='bx bxs-circle me-1 chart-online'></small>{{ $data->code }}</a>
                    <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">|</a>
                    <a href="javascript:;" class="list-inline-item d-flex align-items-center text-secondary">{{ $data->for }}</a>
                </div>
            </div>
            <div class="chat-top-header-menu ms-auto"> 
                {{-- <a href="javascript:;"><i class='bx bx-user-plus'></i></a> --}}
            </div>
        </div>
        <div class="chat-content">
            @include('admin.support.partials.messages-list') 
        </div>
        <div class="chat-footer d-flex align-items-center">
            @if($data->status != 'Closed')
            <div class="flex-grow-1 pe-2">
                <form action="{{ route('ticket-reply',['id' => $data->id]) }}" method="POST" id="replyForm" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="attachment" id="attachment" class="d-none" accept="image/*">

                    <div class="input-group">	
                        <textarea class="form-control" name="message" placeholder="Type a message" rows="1"></textarea>
                        <span class="input-group-text" id="sendBtn"><i class='bx bx-send'></i></span>
                    </div>
                </form>
            </div>
            <div class="chat-footer-menu"> 
                <a href="javascript:;" id="attachBtn"><i class='bx bx-file'></i></a>
                <div id="imagePreview" style="display:none;">
                    <img id="previewImg" src="" style="width:50px; border:1px solid #ccc; border-radius:6px;">
                    <i id="removeImage" style="margin-left: -5px;" class='fadeIn animated bx bx-x'></i>
                </div>
                                
            </div>
            @endif
        </div>
        <!--start chat overlay-->
        <div class="overlay chat-toggle-btn-mobile"></div>
        <!--end chat overlay-->
    </div>



    <!-- Common Modal for File Preview -->
    <div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Dynamic Content (Image or PDF) will be loaded here -->
                    <div id="filePreviewContainer">
                        <!-- Preview content goes here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="downloadLink" class="btn btn-outline-primary" download>
                        <i class="bx bx-download"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        // Initialize PerfectScrollbar
        const chatListPs = new PerfectScrollbar('.chat-list');
        const chatContent = document.querySelector('.chat-content');
        const chatPs = new PerfectScrollbar(chatContent, { wheelPropagation: true });

        // Auto scroll to bottom on page load
        function scrollToBottom() {
            chatContent.scrollTop = chatContent.scrollHeight;
            chatPs.update();
        }

        window.addEventListener('load', scrollToBottom);

        // File attachment logic
        const attachBtn = document.getElementById("attachBtn");
        const fileInput = document.getElementById("attachment");
        const imagePreview = document.getElementById("imagePreview");
        const previewImg = document.getElementById("previewImg");
        const removeImage = document.getElementById("removeImage");

        attachBtn.addEventListener("click", () => {
            fileInput.click();
        });

        fileInput.addEventListener("change", () => {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    previewImg.src = reader.result;
                    imagePreview.style.display = "block";
                    attachBtn.style.display = "none";
                };
                reader.readAsDataURL(file);
            }
        });

        removeImage.addEventListener("click", () => {
            previewImg.src = "";
            fileInput.value = "";
            imagePreview.style.display = "none";
            attachBtn.style.display = "inline-block";
        });

        // Click send icon → submit form
        document.getElementById('sendBtn').addEventListener('click', function() {
            document.getElementById('replyForm').submit();
            // Scroll to bottom immediately after sending
            setTimeout(scrollToBottom, 100); // slight delay to allow DOM update
        });

        // Infinite scroll for older messages
        let loading = false;

        chatContent.addEventListener('ps-scroll-up', function () {
            if (chatContent.scrollTop === 0 && !loading) {
                loading = true;

                // First message div (rightside or leftside)
                const firstMessage = chatContent.querySelector('.chat-content-rightside, .chat-content-leftside');
                const beforeId = firstMessage?.dataset?.id; // ensure data-id exists

                const oldScrollHeight = chatContent.scrollHeight;

                fetch(`{{ route('ticket-reply-store', ['id' => $data->id]) }}?before_id=${beforeId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.text())
                .then(data => {
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = data;

                    const newMessages = tempDiv.querySelectorAll('.chat-content-rightside, .chat-content-leftside');
                    newMessages.forEach(msg => {
                        chatContent.insertBefore(msg, chatContent.firstChild);
                    });

                    // Maintain scroll position after prepending messages
                    const newScrollHeight = chatContent.scrollHeight;
                    chatContent.scrollTop = newScrollHeight - oldScrollHeight;

                    chatPs.update();
                    loading = false;
                })
                .catch(() => loading = false);
            }
        });

    </script>

    <script>
        // Listen for modal show event
        $('#fileModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var fileUrl = button.data('file-url'); // Extract file URL
            var fileType = button.data('file-type'); // Extract file type (image/pdf)
            console.log(fileUrl, fileType);
            var previewContainer = $('#filePreviewContainer');
            var downloadLink = $('#downloadLink');

            if (fileType == 'image') {
                // Display image in the modal
                previewContainer.html('<img src="' + fileUrl + '" class="w-100">');
                downloadLink.attr('href', fileUrl); // Set download link for image
            } else if (fileType == 'pdf') {
                // Display PDF in the modal
                previewContainer.html('<embed src="' + fileUrl + '" type="application/pdf" width="100%" height="500px">');
                downloadLink.attr('href', fileUrl); // Set download link for PDF
            } else {
                previewContainer.html('<p>Unsupported file type</p>');
            }
        });
    </script>
@endpush