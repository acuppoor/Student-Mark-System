<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-md-3">

                                        <p>Student/Employee #</p>
                                        <input type="text" class="form-control" style="border: solid 1px black">
                    </div>

                    <div class="col-md-2">

                                        <p>Year</p>
                                        <select class="form-control" style="border: 1px solid black">
                                            <option selected>Any</option>
                                            <?php
                                            $currentYear = (int) date("Y");
                                            for ($i = $currentYear; $i >= 2010; $i--){
                                                echo('<option>'.$i.'</option>');
                                            }
                                            ?>
                                        </select>
                    </div>
                    <div class="col-md-2">

                                        <p>Faculty</p>
                                        <select class="form-control" style="border: solid 1px black" disabled>
                                            <option selected>Science</option>
                                            <option>Faculty of Humanities</option>
                                            <option>Faculty of Engineering</option>
                                        </select>
                    </div>
                    <div class="col-md-3">
                                        <p>Department</p>
                                        <select class="form-control" style="border: solid 1px black" disabled>
                                            <option selected>Computer Science</option>
                                            <option>Biochemistry</option>
                                        </select>
                    </div>
                    <div class="col-md-1">
                                        <p>&nbsp;</p>
                                        <button id="search_btn" class="btn btn-danger btn-xl" type="submit">Search</button>
                    </div>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
        <div id="result_div" class="row" hidden>
            @include('include.dashboard.results_eg')
        </div>
    </div>
</div>