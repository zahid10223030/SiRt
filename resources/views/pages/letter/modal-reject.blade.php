<!-- Modal Reject -->
<div class="modal fade" id="modalReject-{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/letter/reject/{{ $item->id }}" method="post">
        @csrf
        @method('POST')
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title fs-5">Tolak Surat</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
                <label for="admin_notes">Alasan Penolakan</label>
                <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" 
                    rows="4" placeholder="Berikan alasan penolakan..." required></textarea>
                @error('admin_notes')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Tolak</button>
          </div>
        </div>
    </form>
  </div>
</div>