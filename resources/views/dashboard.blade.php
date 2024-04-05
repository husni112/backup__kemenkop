@extends('layouts.user_type.auth')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-9 col-3">
            <h6>Item Pagu</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-info" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1">{{$totalData}}</span> data
            </p>
          </div>
          <div class="col-lg-3">
            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" name="search" id="search" class="form-control" placeholder="Cari Item Pagu">
            </div>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-2" id="data-wrapper">
        @include('data')
      </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function () {
        // Function to handle AJAX requests
        function fetchData(query, page = 1) {
            $.ajax({
                url: '{{ route('dashboard') }}',
                type: 'GET',
                data: { search_term: query, page: page },
                success: function (data) {
                    $('#data-wrapper').html(data);
                }
            });
        }

        // Initial page load
        fetchData('');

        // Handle input changes
        $('#search').on('input', function () {
            var query = $(this).val();
            fetchData(query);
        });

        // Handle pagination clicks
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var query = $('#search').val();
            fetchData(query, page);
        });
    });
</script>

@endsection
@push('dashboard')
@endpush

