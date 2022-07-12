<section id="breadcrumbs" class="breadcrumbs">
  <div class="breadcrumb-hero">
    <div class="container">
      <div class="breadcrumb-hero">
        <h2>{{ $page_title ?? '' }}</h2>
      </div>
    </div>
  </div>
  <div class="container">
    @yield("breadcrumb")
  </div>
</section>