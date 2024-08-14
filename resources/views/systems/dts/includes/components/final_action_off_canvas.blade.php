<div class="offcanvas offcanvas-end" style="width: 50%" tabindex="-1" id="offcanvasExample"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h3 class="offcanvas-title"></h3>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="forward_form">
            <div class="form-row mb-2">
                <input type="hidden" value="{{session('user_id')}}" name="user_id">
                <input type="hidden" name="id">
                <input type="hidden" name="t_number">
                <div class="form-group col-md-12 mb-2">
                    <label for="inputEmail4">Final Action </label>
                    <select class="form-control" name="final_action_taken" required>
                        <option value="">Select..</option>
                        <?php  foreach ($final_actions as $row) : ?>
                        <option value="{{$row->action_id}}">{{$row->action_name}} </option>
                        <?php endforeach; ?>`

                    </select>
                    </select>
                </div>

                <div class="form-group col-md-12 mb-2">
                    <label for="inputEmail4">Remarks</label>
                    <textarea class="form-control" name="remarks1"></textarea>
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
</div>