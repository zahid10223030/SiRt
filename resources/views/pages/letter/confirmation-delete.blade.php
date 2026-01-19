<!-- Modal Delete -->
<div class="modal fade" id="confirmationDelete-{{ $item->id }}" tabindex="-1" aria-labelledby="confirmationDeleteLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/letter/{{ $item->id }}" method="post">
        @csrf
        @method('DELETE')
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title fs-5" id="confirmationDeleteLabel">Batalkan Pengajuan</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <span>Apakah anda yakin ingin membatalkan pengajuan surat ini?</span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Ya, batalkan!</button>
          </div>
        </div>
    </form>
  </div>
</div>