<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Review Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Field Name</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Id</td>
                <td id="id">{{$data->id}}</td>
            </tr>
            <tr>
                <td>Review By</td>
                <td id="reviewer">{{$data->review_by_name}}</td>
            </tr>
            <tr>
                <td>Review For</td>
                <td id="user">{{$data->review_for_name}}</td>
            </tr>
            <tr>
                <td>Overall Rating</td>
                <td id="overall_rating"><div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="{{ $data->overall_rating }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div></td>
            </tr>
            <tr>
                <td>Attentiveness</td>
                <td id="attentiveness"><div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="{{ $data->attentiveness }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div></td>
            </tr>
            <tr>
                <td>Communication</td>
                <td id="communication"><div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="{{ $data->communication }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div></td>
            </tr>
            <tr>
                <td>Active Listening</td>
                <td id="active_listening"><div class="rateYo ps-0" data-rateyo-read-only="true" data-rateyo-rating="{{ $data->active_listening }}" data-rateyo-star-width="18px" data-rateyo-spacing="1px"></div></td>
            </tr>
            <tr>
                <td>Review</td>
                <td id="review">{{$data->review}}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
