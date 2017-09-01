<div class="sidebar" data-background-color="black" data-active-color="danger">

    <!--
        Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
        Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
    -->

    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="/" class="simple-text">
                Mark System
            </a>
        </div>

        <ul class="nav">
            <?php $role = "systemadmin";

                if($role == "student"){
                    echo('
                        <li id="student_tab">
                            <a href="/">
                                <i class="ti-panel"></i>
                                <p>Student</p>
                            </a>
                        </li>
                    ');
                } else{
                    echo('
                        <li id="dashboard_tab" class="active">
                            <a href="/">
                                <i class="ti-panel"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    ');
                }
                if($role=="teachingassistant"){
                    echo('
                         <li id="ta_tab">
                             <a href="table.html">
                                 <i class="ti-panel"></i>
                                 <p>Teaching Assistant</p>
                             </a>
                         </li>
                    ');
                }

                if($role=="lecturer" || $role=="courseconvenor"){
                    echo('
                         <li id="lecturer_tab">
                             <a href="typography.html">
                                 <i class="ti-panel"></i>
                                 <p>Lecturer</p>
                             </a>
                         </li>
                    ');
                }

                if($role=="courseconvenor"){
                    echo('
                         <li id="convenor_tab">
                             <a href="icons.html">
                                 <i class="ti-panel"></i>
                                 <p>Course Convenor</p>
                             </a>
                         </li>
                    ');
                }

                if($role=="departmentadmin"){
                    echo('
                         <li id="department_admin_tab">
                             <a href="maps.html">
                                 <i class="ti-panel"></i>
                                 <p>Department Admin</p>
                             </a>
                         </li>
                    ');
                }

                if($role=="systemadmin"){
                    echo('
                         <li id="system_admin_tab">
                             <a href="notifications.html">
                                 <i class="ti-panel"></i>
                                 <p>Departments Portal</p>
                             </a>
                         </li>
                    ');

                    echo('
                         <li id="system_admin_tab">
                             <a href="notifications.html">
                                 <i class="ti-panel"></i>
                                 <p>System Admin</p>
                             </a>
                         </li>
                    ');
                }
            ?>




        </ul>
    </div>
</div>