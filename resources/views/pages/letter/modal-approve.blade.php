<!-- Modal Approve -->
<div class="modal fade" id="modalApprove-{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/letter/approve/{{ $item->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title fs-5">Setujui Surat</h4>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group mb-3">
                <label for="admin_notes">Catatan (Opsional)</label>
                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" 
                    placeholder="Berikan catatan untuk warga..."></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="file">Upload File Surat (Opsional)</label>
                <input type="file" name="file" id="file" class="form-control">
                <small class="text-muted">Format: PDF, DOC, DOCX. Maks: 5MB</small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-success">Setujui</button>
          </div>
        </div>
    </form>
  </div>
</div>