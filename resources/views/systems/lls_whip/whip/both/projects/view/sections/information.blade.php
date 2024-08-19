<div class="card flex-fill p-3">
    <div class="card-header">
        <h5 class="card-title mb-0">Project Information</h5>
        <button class="btn btn-primary edit-information" disabled>Edit Info</button>
        <button class="btn btn-danger cancel-edit hidden">Cancel Edit</button>
        <button class="btn btn-success submit hidden">Submit</button>
    </div>
    <input type="hidden" name="contractor_id" value="{{$row->project_id}}">
    <table class="table table-hover table-striped table-information " id="table-information" style="width: 100%; ">
        <tr>
            <td>Contractor Name</td>
            <td class="text-start">
                <span class="title1">{{$row->contractor_name}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Project Title</td>
            <td class="text-start">
                <span class="title1">{{$row->project_title}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Project Nature</td>
            <td class="text-start">
                <span class="title1">{{$row->project_nature}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Project Cost</td>
            <td class="text-start">
                <span class="title1">{{$row->project_cost}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Barangay</td>
            <td class="text-start">
                <span class="title1">{{$row->barangay}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Street</td>
            <td class="text-start">
                <span class="title1">{{$row->street}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Date Started</td>
            <td class="text-start">
                <span class="title1">{{$row->date_started}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Date Completed</td>
            <td class="text-start">
                <span class="title1">{{$row->date_completed}}</span>
                <input type="hidden" class="form-control" name="contractor_name" value="">
            </td>
        </tr>
        <tr>
            <td>Project Status</td>
            <td class="text-start">
                <span class="title1">{{ ucfirst($row->project_status)}}</span>
                <select class="form-control" name="status" hidden>
                    <option value="">Select Status</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                </select>
        </tr>


    </table>
</div>