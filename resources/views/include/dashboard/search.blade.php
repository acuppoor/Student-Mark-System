<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="content">
                <div class="row">
                    {{--<div style="padding-left: 2%">
                        <p>
                            <strong><h5>Filters</h5></strong>
                        </p>
                    </div>--}}
                    <div class="col-lg-4 col-sm-6">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div class="numbers" style="text-align: left">
                                        <p>Select Year</p>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div class="numbers" style="text-align: left">
                                        <p>Select Faculty</p>
                                        <select class="form-control" style="border: solid 1px black" disabled>
                                            <option selected>Faculty of Science</option>
                                            <option>Faculty of Humanities</option>
                                            <option>Faculty of Engineering</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div class="numbers" style="text-align: left">
                                        <p>Select Department</p>
                                        <select class="form-control" style="border: solid 1px black" disabled>
                                            <option selected>Computer Science</option>
                                            <option>Biochemistry</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <div class="numbers" style="text-align: left">
                                        <p>Student Number/Employee ID</p>
                                        <input type="text" class="form-control" style="border: solid 1px black">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="content">
                            <div class="row">
                                <div class="col-xs-8">
                                    <div class="numbers" style="text-align: center">
                                        <p>&nbsp;</p>
                                        <button id="search_btn" class="btn btn-danger btn-xl" type="submit">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="result_div" class="row" hidden>
            @include('include.dashboard.results_eg')
        </div>
    </div>
</div>