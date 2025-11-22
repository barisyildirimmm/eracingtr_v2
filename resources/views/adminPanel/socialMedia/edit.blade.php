@extends('adminPanel.layouts.main')

@section('css')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .social-media-page {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }
    .page-header-card {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
        color: white;
    }
    .form-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .image-upload-area {
        border: 2px dashed #dc3545;
        border-radius: 0.5rem;
        padding: 2rem;
        text-align: center;
        background: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .image-upload-area:hover {
        background: #e9ecef;
        border-color: #c82333;
    }
    .image-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 1rem;
    }
    .image-preview-item {
        position: relative;
        width: 150px;
        height: 150px;
    }
    .image-preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px solid #e9ecef;
    }
    .image-preview-item .remove-image {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .platform-checkbox {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 2px solid #e9ecef;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .platform-checkbox:hover {
        border-color: #dc3545;
        background: #fff5f5;
    }
    .platform-checkbox input[type="checkbox"] {
        margin-right: 1rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }
    .platform-checkbox label {
        margin: 0;
        cursor: pointer;
        flex: 1;
        display: flex;
        align-items: center;
    }
    .platform-checkbox i {
        margin-right: 0.5rem;
        font-size: 1.5rem;
    }
    .platform-facebook i { color: #1877f2; }
    .platform-instagram i { color: #e4405f; }
    .platform-x i { color: #000000; }
    .platform-youtube i { color: #ff0000; }
    #editor {
        min-height: 200px;
    }
    .btn-submit {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }
</style>
@endsection

@section('content')
<div class="social-media-page">
    <div class="container">
        <div class="page-header-card">
            <h1 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                Sosyal Medya Paylaşımını Düzenle
            </h1>
            <p class="mb-0 mt-2 opacity-90">Paylaşım bilgilerini güncelleyin</p>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.socialMedia.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-card">
                <h3 class="mb-3">
                    <i class="fas fa-edit me-2 text-danger"></i>
                    İçerik
                </h3>
                <div id="editor"></div>
                <input type="hidden" name="content" id="content">
            </div>

            <div class="form-card">
                <h3 class="mb-3">
                    <i class="fas fa-images me-2 text-danger"></i>
                    Fotoğraflar
                </h3>
                <div class="mb-3">
                    <strong>Mevcut Fotoğraflar:</strong>
                    <div class="image-preview-container" id="existingImages">
                        @foreach($post->images as $image)
                        <div class="image-preview-item">
                            <img src="{{ asset('assets/img/social_media/' . $image) }}" alt="Existing Image">
                            <button type="button" class="remove-image" onclick="removeExistingImage('{{ $image }}')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="image-upload-area" onclick="document.getElementById('images').click()">
                    <i class="fas fa-cloud-upload-alt fa-3x text-danger mb-3"></i>
                    <p class="mb-0">Yeni fotoğraf eklemek için tıklayın</p>
                </div>
                <input type="file" id="images" name="images[]" multiple accept="image/*,video/*" style="display: none;" onchange="previewImages(this)">
                <div class="image-preview-container" id="imagePreview"></div>
            </div>

            <div class="form-card">
                <h3 class="mb-3">
                    <i class="fas fa-share-alt me-2 text-danger"></i>
                    Platformlar
                </h3>
                <div class="platform-checkbox platform-instagram">
                    <input type="checkbox" id="platform_instagram" name="platforms[]" value="instagram" {{ in_array('instagram', $post->platforms) ? 'checked' : '' }}>
                    <label for="platform_instagram">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram (Fotoğraf)</span>
                    </label>
                </div>
                <div class="platform-checkbox platform-instagram-reels">
                    <input type="checkbox" id="platform_instagram_reels" name="platforms[]" value="instagram_reels" {{ in_array('instagram_reels', $post->platforms) ? 'checked' : '' }}>
                    <label for="platform_instagram_reels">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram Reels (Video)</span>
                    </label>
                </div>
                <div class="platform-checkbox platform-instagram-story">
                    <input type="checkbox" id="platform_instagram_story" name="platforms[]" value="instagram_story" {{ in_array('instagram_story', $post->platforms) ? 'checked' : '' }}>
                    <label for="platform_instagram_story">
                        <i class="fab fa-instagram"></i>
                        <span>Instagram Story</span>
                    </label>
                </div>
                <div class="platform-checkbox platform-youtube">
                    <input type="checkbox" id="platform_youtube" name="platforms[]" value="youtube_shorts" {{ in_array('youtube_shorts', $post->platforms) ? 'checked' : '' }}>
                    <label for="platform_youtube">
                        <i class="fab fa-youtube"></i>
                        <span>YouTube Shorts</span>
                    </label>
                </div>
            </div>

            <div class="form-card">
                <h3 class="mb-3">
                    <i class="fas fa-clock me-2 text-danger"></i>
                    Paylaşım Zamanı
                </h3>
                <div class="mb-3">
                    <label for="scheduled_at" class="form-label">Tarih ve Saat</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" value="{{ \Carbon\Carbon::parse($post->scheduled_at)->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.socialMedia.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Geri Dön
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>
                    Güncelle
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'color': [] }, { 'background': [] }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Set existing content
    quill.root.innerHTML = {!! json_encode($post->content) !!};

    let selectedImages = [];
    let deletedImages = [];

    function previewImages(input) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        selectedImages = [];

        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'image-preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-image" onclick="removeImage(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    preview.appendChild(div);
                    selectedImages.push(file);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function removeImage(index) {
        selectedImages.splice(index, 1);
        const input = document.getElementById('images');
        const dt = new DataTransfer();
        selectedImages.forEach(file => dt.items.add(file));
        input.files = dt.files;
        previewImages(input);
    }

    function removeExistingImage(imageName) {
        if (confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) {
            deletedImages.push(imageName);
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'deleted_images[]';
            hiddenInput.value = imageName;
            document.querySelector('form').appendChild(hiddenInput);
            
            const item = event.target.closest('.image-preview-item');
            if (item) {
                item.remove();
            }
        }
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const content = quill.root.innerHTML;
        document.getElementById('content').value = content;
    });
</script>
@endsection

