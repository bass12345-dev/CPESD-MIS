<div class="card flex-fill ">
    @include('components.dts.filter_by_month')
   <div class="card-header">
      <h5 class="card-title mb-2">Documents</h5>
      <button class="btn btn-danger" id="delete"> Delete</button>
      <button class="btn btn-warning" id="cancel"> Cancel</button>
      <button class="btn btn-primary" id="print_slips1"> Print Tracking Slip</button>
   </div>

   <table class="table table-hover table-striped m-2 " id="datatable_with_select" style="width: 100%; ">
      <thead>
         <tr>
            <th></th>
            <th>#</th>
            <th>Tracking Number</th>
            <th>Document Name</th>
            <th>Document Type</th>
            <th>Created</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </thead>
      <tfoot>
         <tr>
            <th></th>
            <th>#</th>
            <th>Tracking Number</th>
            <th>Document Name</th>
            <th>Document Type</th>
            <th>Created</th>
            <th>Status</th>
            <th>Actions</th>
         </tr>
      </tfoot>
   </table>
</div>

