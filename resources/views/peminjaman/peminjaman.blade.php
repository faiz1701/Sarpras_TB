@extends('layoutnya')
@section('judul','Peminjaman')
@section('isi')
@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<style>
  table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before {
    right: 1em;
    font-size: 20px !important;
}

table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
    right: 0.5em;
    font-size: 20px !important;
}
</style>
@endpush
<div class="card">
    <div class="card-body">
        <button class="btn btn-flat btn-warning btn-refresh mb-4"><i class="fa fa-refresh"></i> Refresh</button>
        <a href="{{ url('peminjaman/create') }}" class="btn btn-icon icon-left btn-primary mb-4"><i
            class="fas fa-plus"></i><span class="px-2">Tambah</span></a>
        <table class="table table-hover table-bordered dataTable" id="peminjaman-table">
            <thead style="font-size: 13px">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kode Barang</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Nama Peminjam</th>
                    <th scope="col">Status Peminjam</th>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Jumlah Pinjam</th>
                    <th scope="col">Status</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Nama Operator</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="alldatainventory">
                @foreach ( $data as $index => $item )
                <tr>
                    <th scope="row">{{ $index + $data->firstItem() }}</th>
                    <td>{{ $item->barang->kode_barang }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->nama_peminjam }}</td>
                    <td>{{ $item->status_peminjam }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    <td>{{ $item->jumlah_pinjam }}</td>
                    <td>
                        <div class="btn {{ ($item -> status == 'Dipinjam')? 'btn-info' : 'btn-success' }} text-white" style="cursor:auto;">{{ $item->status }}</div>
                    </td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->operator_id }}</td>
                    <td class="d-flex">
                        <a href="{{ url('/peminjaman/detail/'.$item->id) }}" class="btn btn-icon btn-info" ><i class="fas fa-eye"></i></a>
                        <a href="{{ url('peminjaman/'.$item->id.'/edit') }}" title="Edit" class="btn btn-icon btn-warning ms-1"><i class="fas fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xU+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            // btn refresh
            $('.btn-refresh').click(function(e){
                e.preventDefault();
                $('.preloader').fadeIn();
                location.reload();
            })

        })
    </script>
    <script>
            
      $('.delete').click(function(event) {
      var form =  $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();
      swal({
          title: `Are you sure you want to delete ${name}?`,
          text: "If you delete this, it will be gone forever.",
          icon: "warning",
          buttons: true,
          dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
          swal("Data berhasil di hapus", {
                icon: "success",
                });
        }else 
        {
          swal("Data tidak jadi dihapus");
        }
      });
  });
    </script>

<script>
    $(function() {
        $('#peminjaman-table').DataTable({
            columnDefs: [
              {
                paging: true,
                scrollX: true,
                lengthChange : true,
                searching: true,
                ordering: true,
                  targets: [1, 2, 3, 4],
              },
          ],
      });
   
      $('button').click(function () {
          var data = table.$('input, select','button','form').serialize();
          return false;
      });
      table.columns().iterator('column', function (ctx, idx) {
          $(table.column(idx).header()).prepend('<span class="sort-icon"/>');
      });
    });
  </script>
  
<script>
    @if (Session:: has('success'))
    toastr.success("{{ Session::get('success') }}")
    @endif
</script>

@endpush