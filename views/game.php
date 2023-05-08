    <div class="container bg-dark text-light rounded">
        <div class="row">
            <h4 class="text-warning">Profile</h4>
            <div class="col-md-6">
                Balance:  <span id="user-balance"><?php echo $balance;?>$</span>
            </div>
            <div class="col-md-6">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-success text-light">Add to balance<i class="fa fa-plus"></i></button>
            </div>
        </div>
    <hr>
        <div class="row">
            <div class="col-md-3">
                Make your bet!
            </div>
            <div class="col-md-3">
                <button data-bet="1" class="btn btn-warning bet">1$</button>
            </div>
            <div class="col-md-3">
                <button data-bet="5" class="btn btn-warning bet">5$</button>
            </div>
            <div class="col-md-3">
                <button data-bet="10" class="btn btn-warning bet">10$</button>
            </div>
        </div>
    <hr>
        <div class="row">
            <div id="message" class="col md-12 text-light">
                There Will be your results, <span class="text-warning">Good Luck!</span>
            </div>
        </div>


        <div class="modal fade text-dark" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add to blance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   How much? <input type="number" id="add-input" class="">$
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id = "add-button">Add</button>
                </div>
                </div>
            </div>
        </div>

    </div>




