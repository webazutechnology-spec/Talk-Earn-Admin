@foreach ($messages as $message)
     @php
        $file = '';
        $fileIcon = '';
        $fileUrl = asset('images/support_replies/' . $message->file);
        $fallbackImage = asset('images/missing-image.png');
        $dflex =  Auth::user()->id == $message->user_id? ' d-flex justify-content-end':'';           
       

        if(!empty($message->file) && in_array($message->file_type, ['jpg','jpeg','png'])) {
            // Image file (thumbnail and modal)
            $file = '<img src="' . $fileUrl . '" onerror="this.onerror=null;this.src=\'' . $fallbackImage . '\';" alt="user image" class="'.$dflex.'" style="width:100px !important;height:auto !important;margin-top: 5px;" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-type="image" data-file-url="' . $fileUrl . '">';
        } else if(!empty($message->file) && in_array($message->file_type, ['pdf'])) {
            // PDF file (icon and modal)
            $file = '<a href="' . $fileUrl . '" class="'.$dflex.'" data-bs-toggle="modal" data-bs-target="#fileModal" data-file-type="pdf" data-file-url="' . $fileUrl . '">
                        <img src="' . asset('images/download-pdf-icon.svg') . '" alt="user image" style="width:55px !important;height:auto !important;margin-top: 5px;" >
                    </a>';
        } else if(!empty($message->file) && in_array($message->file_type, ['doc', 'docx'])) {
            // Word document (icon with direct download)
            $file = '<a href="' . $fileUrl . '" class="'.$dflex.'" download>
                        <img src="' . asset('images/download-doc-icon.svg') . '" alt="user image" style="width:55px !important;height:auto !important;margin-top: 5px;" >
                    </a>';
        } else if(!empty($message->file)){
            // For unsupported file types, just show file name with direct download
            $file = '<a href="' . $fileUrl . '" class="'.$dflex.'" download>
                        <img src="' . asset('images/file-download-import-color-icon.svg') . '" alt="user image" style="width:55px !important;height:auto !important;margin-top: 5px;" >
                    </a>';
        }
    @endphp
    @if(Auth::user()->id == $message->user_id)
        <div class="chat-content-rightside" data-id="{{ $message->id }}">
            <div class="d-flex ms-auto">
                <div class="flex-grow-1 me-2">
                    <p class="mb-0 chat-time text-end">You, {{$message->created_at}}</p>
                    <p class="chat-right-msg">
                        {{$message->description}}
                        <br>
                        {!! $file !!}
                    </p>
                    {{-- {!! $file !!} --}}
                </div>
            </div>
        </div>
    @else
        <div class="chat-content-leftside" data-id="{{ $message->id }}">
            <div class="d-flex">
                <img src="{{ asset('profile/' . $data->user->image??'') }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" width="48" height="48" class="rounded-circle" alt="" />
                <div class="flex-grow-1 ms-2">
                    <p class="mb-0 chat-time">{{ Auth::user()->name }}, {{$message->created_at}}</p>
                    <p class="chat-left-msg">
                        {{$message->description}}
                        <br>
                        {!! $file !!}
                    </p>
                    {{-- {!! $file !!} --}}
                </div>
            </div>
        </div>
    @endif
@endforeach
