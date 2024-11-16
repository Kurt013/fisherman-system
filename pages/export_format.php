<!-- Export Modal -->
<div id="exportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="exportModalLabel">Export Confirmation</h4>
      </div>
      <div class="modal-body">
        <p>Choose export format:</p>
        <!-- Form for exporting -->
        <form method="post" action="../resident/export.php">
        <div class="form-group">
            <label for="export-format">Export Format:</label>
            <select name="export_format" id="export_format" class="form-control">
            <option value="pdf">PDF</option>
            <option value="excel">Excel</option>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
            <input type="submit" class="btn btn-primary btn-sm" name="export" value="Export">
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
