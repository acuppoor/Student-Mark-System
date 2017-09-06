<div class="main-panel">
    @include('include.dashboard.nav')
    <div class="row" style="background-color: whitesmoke">
        <div class="card">
            <div class="col-md-10">
                / <a href="">My Marks</a>
            </div>
        </div>
    </div>
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
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <div class="numbers" style="text-align: left">
                                            <p>Select Year</p>
                                            <select class="form-control" style="border: 1px solid black">
                                                <option selected><?php echo(date("Y"));?></option>
                                                <?php
                                                $currentYear = (int) date("Y");
                                                for ($i = $currentYear-1; $i >= 2010; $i--){
                                                    echo('<option>'.$i.'</option>');
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
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
                        <div class="col-lg-3 col-sm-6">
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
                        <div class="col-lg-3 col-sm-6">
                            <div class="content">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <div class="numbers" style="text-align: center">
                                            <p>&nbsp;</p>
                                            <button class="btn btn-danger btn-xl" type="submit">Apply Filters</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="course" class="card panel" style="border: 1px solid black">
                        <div id="panel-heading" class="panel-heading">
                            <h3 class="title">1. CSC1016S</h3>
                            <p class="category"><i>Click to show marks</i></p>
                        </div>
                        <div class="panel-wrapper collapse">
                            <div id="course_content" class="content panel-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Year Mark: 45%</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Class Mark: 90%</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Marks Breakdown:</h4>
                                            </div>
                                            <div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Tests</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">Test 1: 30/35</div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Section A: 15/20<br/>
                                                                                Section B: 15/15
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel-heading">Test 2: 35/35</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Assignments</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 1: 95%
                                                                        </div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Question 1: 25/25<br/>
                                                                                Question 2: 25/25<br/>
                                                                                Question 3: 20/25<br/>
                                                                                Question 4: 25/25
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 2: 95%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 3: 95%
                                                                        </div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Question 1: 25/25<br/>
                                                                                Question 2: 25/25<br/>
                                                                                Question 3: 20/25<br/>
                                                                                Question 4: 25/25
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 4: 95%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Query Marks</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" style="border: solid 1px black"></textarea>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <button type="submit" class="btn btn-danger">Submit Query</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="course" class="card panel" style="border: 1px solid black">
                        <div id="panel-heading" class="panel-heading">
                            <h3 class="title">2. CSC1015F</h3>
                            <p class="category"><i>Click to show marks</i></p>
                        </div>
                        <div class="panel-wrapper collapse">
                            <div id="course_content" class="content panel-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Year Mark: 45%</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Class Mark: 90%</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="header">
                                                <h4 class="title">Marks Breakdown:</h4>
                                            </div>
                                            <div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Tests</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">Test 1: 30/35</div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Section A: 15/20<br/>
                                                                                Section B: 15/15
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel-heading">Test 2: 35/35</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Assignments</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 1: 95%
                                                                        </div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Question 1: 25/25<br/>
                                                                                Question 2: 25/25<br/>
                                                                                Question 3: 20/25<br/>
                                                                                Question 4: 25/25
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 2: 95%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 3: 95%
                                                                        </div>
                                                                        <div class="panel-wrapper collapse">
                                                                            <div class="panel-body">
                                                                                Question 1: 25/25<br/>
                                                                                Question 2: 25/25<br/>
                                                                                Question 3: 20/25<br/>
                                                                                Question 4: 25/25
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <div class="card">
                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            Assignment 4: 95%
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{--<div class="panel" style="border: 1px solid black">
                                                <div class="panel-heading">
                                                    <h6>Query Marks</h6>
                                                </div>
                                                <div class="panel-wrapper collapse">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control" style="border: solid 1px black"></textarea>
                                                            </div>
                                                        </div>
                                                        <br/>
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <button type="submit" class="btn btn-danger">Submit Query</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>--}}
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
    @include('include.dashboard.footer')
</div>