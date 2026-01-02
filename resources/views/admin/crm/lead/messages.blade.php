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
                                <span class="list-group-item">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-1 chat-title">Source: {{ $data->source??'NA' }}</h6>
                                            <p class="mb-1 chat-msg">Name: {{ $data->user_name ?? '' }}</p>
                                            <p class="mb-1 chat-msg">Email: {{ $data->email ?? '' }}</p>
                                            <p class="mb-1 chat-msg">Phone: {{ $data->phone ?? '' }}</p>
                                            <p class="mb-1 chat-msg">Company: {{ $data->company_name ?? '' }}</p>
                                            <p class="mb-1 chat-msg">Address: {{ $data->address ?? '' }}, {{ $data->city->name ?? '' }}, {{ $data->state->name ?? '' }}, {{ $data->country->name ?? '' }}, {{ $data->zip_code ?? '' }}</p>
                                            <p class="mb-1 chat-msg">Description: {{ $data->source_description ?? '' }}</p>
                                            <div class="chat-time">Date: {{ $data->created_at??'' }}</div>
                                        </div>
                                    </div>
                                </span>
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
                <h5 class="mb-1 font-weight-bold">Follow Up</h5>
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
            @include('admin.crm.lead.partials.messages-list') 
        </div>
        <div class="chat-footer" style="height: 175px;">
            @if($data->status != 'Closed')
            <div class="flex-grow-1 pe-2">
                <form action="{{ route('lead-follow-up-reply',['id' => $data->id]) }}" method="POST" id="replyForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-2">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                <option selected disabled value="">Choose Type...</option>
                                <option value="Call">Call</option>
                                <option value="Email">Email</option>
                                <option value="Meeting">Meeting</option>
                                <option value="Visit">Visit</option>
                                <option value="Note">Note</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Enter date" value="{{ old('date') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="attachment" class="form-label">Attachment</label>
                            <input type="file" name="attachment" id="attachment" class="form-control @error('attachment') is-invalid @enderror" accept="image/*">
                            @error('attachment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="message" class="form-label">Message</label>
                            <textarea  class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Type a message" rows="1"></textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-info mt-4" id="sendBtn" style="margin-top: 28px !important;"><i class='bx bx-send'></i> Send</button>
                        </div>
                    </div>
                </form>
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

                fetch(`{{ route('lead-follow-up-reply', ['id' => $data->id]) }}?before_id=${beforeId}`, {
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