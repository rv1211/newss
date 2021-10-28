<div class="page-container">
    <div class="page-content">
        <div class="content-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                    <h2 class="text-danger">Note :- Please change you php.ini setting if you flooding larger amount of data</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="margin-top: 5px;">
                                <h4 class="panel-title">Fake Data Insetion</h4><br><br>
                                <div class="col-md-3" style="display: grid;margin-top: 10px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="<?= base_url('flood') ?>" method="post">
                                                <div class="form-group">
                                                    <label for="">Enter Table Name :</label>
                                                    <input type="text" name="table_name" class="form-control">
                                                </div>  
                                                <div class="form-group">
                                                    <label for="">Enter No Of Rows</label>
                                                    <input type="text" name="table_rows" class="form-control">
                                                </div>
                                                <input type="submit" value="submit" class="btn btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>