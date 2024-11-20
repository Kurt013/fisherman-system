<!-- Export Modal -->
<div id="exportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="exportModalLabel">Export Confirmation</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
         <form method="post" action="../activity/export.php"> 
            <label for="export-month">Select Month:</label>
            <select name="export_month" id="export_month" class="form-control">
              <option value="all">All</option>
              <option value="01">January</option>
              <option value="02">February</option>
              <option value="03">March</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">August</option>
              <option value="09">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
        <!-- Form for exporting -->
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
