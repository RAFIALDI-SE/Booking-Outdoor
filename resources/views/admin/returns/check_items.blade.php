@extends('admin.layouts.dashboard')

@section('content')



<h2 class="mb-4">Detail Barang Dipinjam</h2>

<hr>


<div class="d-flex justify-content-start mb-4">

    <a href="{{ route('returns_index') }}"

       class="btn btn-sm btn-outline-secondary">

        Kembali ke Daftar

    </a>

</div>



<form id="return-form" action="{{ route('returns_process_check', $transaction->code) }}" method="POST">
  @csrf

  <div class="d-grid gap-4 mx-auto" style="max-width: 750px;">

    @foreach($transaction->items as $index => $item)

    <div class="card border-0 shadow-sm p-3" style="background-color: #80CEC7; border-radius: 1rem;">
      <div class="row align-items-center">

        <div class="col-2">
          <img src="{{ asset('storage/' . $item->product->image) }}" class="img-fluid rounded" alt="Item" style="height: 50px; width: 50px; object-fit: cover;">
        </div>

        <div class="col-10">
          <p class="fw-bold mb-1 fs-5 text-dark">{{ $item->product->name }} (x{{ $item->quantity }})</p>
          <input type="hidden" name="item_id[{{ $index }}]" value="{{ $item->id }}">


          <div class="d-flex gap-3 mt-2">
            @foreach(['aman', 'hilang', 'rusak'] as $condition)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="condition[{{ $index }}]"
                 id="cond-{{ $item->id }}-{{ $condition }}" value="{{ $condition }}" required>
              <label class="form-check-label text-dark" for="cond-{{ $item->id }}-{{ $condition }}">
                {{ ucfirst($condition) }}
              </label>
            </div>
            @endforeach
          </div>

        </div>
      </div>
    </div>
    @endforeach

    <div class="text-center mt-5">
      <button type="button" class="btn text-white fw-bold px-5 py-3"
          style="background-color:#016B61; border-radius: 12px;"
          data-bs-toggle="modal" data-bs-target="#confirmationModal">
        Simpan Pengembalian
      </button>
    </div>

  </div>
</form>


<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content p-4 border-0 shadow-lg" style="border-radius: 1.5rem;">
            <div class="modal-body text-center">
                <p class="h5 fw-bold mb-4">
                    Yakin Barang Yang <br> Dikembalikan sudah sesuai?
                </p>
                <div class="d-flex justify-content-center gap-3">

                    <button type="button" class="btn text-white fw-bold py-2"
                            style="background-color: #016B61; border-radius: 12px; width: 120px;"
                            onclick="document.getElementById('return-form').submit()">
                        Iya
                    </button>

                    <button type="button" class="btn text-white fw-bold py-2" data-bs-dismiss="modal"
                            style="background-color: #A33535; border-radius: 12px; width: 120px;">
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('return-form');
        const submitButton = form.querySelector('button[data-bs-toggle="modal"]');

        submitButton.addEventListener('click', function(event) {

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.classList.add('was-validated');
            } else {
                // Tampilkan modal jika form valid
                // Atribut data-bs-toggle="modal" sudah menangani ini
            }
        }, false);
    });
</script>
@endsection