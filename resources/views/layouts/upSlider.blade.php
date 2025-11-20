  <!-- Hero Unit
  ================================================== -->
  <div class="hero-unit">
      <div class="container hero-unit__container">
          <div class="hero-unit__content hero-unit__content--left-center"
              style="background: rgba(0, 0, 0, 0.800); padding:50px; border-radius:5px; border:4px solid #CCC">
              <span class="hero-unit__decor">
                  <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                      class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </span>
              <h5 class="hero-unit__subtitle">{{ __('common.new_season_starting') }}</h5>
              <h1 class="hero-unit__title">{{ __('common.eracing_turkey') }}</h1>
              @if (!session('driverInfo'))
                  <div class="hero-unit__desc">{{ __('common.application_desc') }}</div>
                  <a href="#"
                      class="btn btn-inverse btn-xl btn-outline btn-icon-right btn-condensed hero-unit__btn bg-light text-dark"
                      data-toggle="modal" data-target="#modal-login-register">
                      {{ __('common.join') }}
                      <i class="fas fa-user-plus fa-xl text-primary"></i>
                  </a>
              @endif
          </div>

          {{-- <figure class="hero-unit__img">
              <img src="assets/images/samples/header_player.png" alt="Hero Unit Image">
          </figure> --}}
      </div>
  </div>
