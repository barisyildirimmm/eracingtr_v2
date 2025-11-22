@extends('adminPanel.layouts.main')

@section('css')
<style>
    .hero-slider-page {
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
    .upload-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .slider-list-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
    }
    .slider-item {
        background: #f8f9fa;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        cursor: move;
    }
    .slider-item:hover {
        border-color: #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.2);
    }
    .slider-item img {
        width: 100%;
        max-width: 300px;
        height: auto;
        border-radius: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-upload {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
    }
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
    }
    .info-box {
        background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        border-left: 4px solid #0ea5e9;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .info-box strong {
        color: #0369a1;
    }
</style>
@endsection

@section('content')
<div class="hero-slider-page">
    <div class="container">
        <div class="page-header-card">
            <h1 class="mb-0">
                <i class="fas fa-images me-2"></i>
                Hero Slider Yönetimi
            </h1>
            <p class="mb-0 mt-2 opacity-90">Anasayfa hero bölümünde gösterilecek slider fotoğraflarını yönetin</p>
        </div>

        <div class="upload-card">
            <h3 class="mb-3">
                <i class="fas fa-upload me-2 text-danger"></i>
                Yeni Fotoğraf Ekle
            </h3>
            
            <div class="info-box">
                <strong><i class="fas fa-info-circle me-2"></i>Fotoğraf Boyut Bilgisi:</strong>
                <ul class="mb-0 mt-2">
                    <li>Önerilen boyut: <strong>1200x400px</strong> (3:1 oran)</li>
                    <li>Minimum genişlik: <strong>800px</strong></li>
                    <li>Maksimum dosya boyutu: <strong>5MB</strong></li>
                    <li>Desteklenen formatlar: <strong>JPG, PNG</strong></li>
                    <li>Maksimum fotoğraf sayısı: <strong>4 adet</strong></li>
                </ul>
            </div>

            <form action="{{ route('admin.heroSlider.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Fotoğraf Seç</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg" required>
                    @error('image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-upload">
                    <i class="fas fa-upload me-2"></i>
                    Fotoğraf Yükle
                </button>
            </form>
        </div>

        <div class="slider-list-card">
            <h3 class="mb-3">
                <i class="fas fa-list me-2 text-danger"></i>
                Slider Fotoğrafları ({{ count($sliders) }}/4)
            </h3>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(count($sliders) == 0)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Henüz fotoğraf eklenmemiş. Yukarıdaki formdan fotoğraf ekleyebilirsiniz.
                </div>
            @else
                <div id="slider-list" class="row">
                    @foreach($sliders as $slider)
                        <div class="col-md-6 col-lg-3 mb-3" data-id="{{ $slider->id }}">
                            <div class="slider-item">
                                <div class="text-center mb-3">
                                    <img src="{{ asset('assets/img/hero_slider/' . $slider->image) }}" alt="Slider {{ $slider->order }}" class="img-fluid">
                                </div>
                                <div class="text-center">
                                    <p class="mb-2">
                                        <small class="text-muted">Sıra: <strong>{{ $slider->order }}</strong></small>
                                    </p>
                                    <form action="{{ route('admin.heroSlider.destroy', $slider->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu fotoğrafı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete btn-sm">
                                            <i class="fas fa-trash me-1"></i>
                                            Sil
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    @if(count($sliders) > 0)
    var el = document.getElementById('slider-list');
    var sortable = Sortable.create(el, {
        animation: 150,
        onEnd: function(evt) {
            var orders = [];
            el.querySelectorAll('[data-id]').forEach(function(item, index) {
                orders.push(item.getAttribute('data-id'));
            });
            
            $.ajax({
                url: '{{ route("admin.heroSlider.updateOrder") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    orders: orders
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
    @endif
</script>
@endsection

