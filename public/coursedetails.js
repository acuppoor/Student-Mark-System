$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){

    $('.selectSubminimumCourseworkDropdown').change(function () {
       var subminName = $(this).data('subminnameid');
       var selectedCoursework = $(this).val();
        var courseId = $('#courseId').val();

       var subcourseworkDropdown = $('#'+subminName+'subcourseworkdropdown');/*document.getElementById(subminName+'subcourseworkdropdown')*/;
        subcourseworkDropdown.empty();

        $.ajax({
            type: 'POST',
            url: '/getsubcourseworks',
            data:{
                coursework: selectedCoursework,
                courseId: courseId
            },
            success:function(data){
                var option = document.createElement('option');
                option.value=-1;
                option.text = "";
                subcourseworkDropdown.append(option);

                for(var i = 0; i < data.length; i++){
                    var option = document.createElement('option');
                    option.value = data[i].id;
                    option.text = data[i].name;
                    subcourseworkDropdown.append(option);
                }
            }
        });

    });

    $('#exportDPListButton').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/downloaddplist',
            data:{
                courseId: courseId,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
            }
        });
    });

    $('#exportStudentsListButton').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudents',
            data:{
                courseId: courseId,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
            }
        });
    });

    $('#exportFinalGradeButton').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/downloadfinalgrade',
            data:{
                courseId: courseId,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
            }
        });
    });

    $('#exportSubcourseworkMarkButton').click(function(){
        var courseworkId = $('#subcourseworkCourseworkDropdown').val();
        var subcourseworkId = $('#subcourseworkSubcourseworkDropdown').val();
        var studentNumber = $('#subcourseworkSearchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#subcourseworkSearchPageLimit').val()=='Max'?-1:$('#subcourseworkSearchPageOffset').val()-1);
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudentssubcourseworkmarks',
            data:{
                courseworkId: courseworkId,
                subcourseworkId: subcourseworkId,
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
            }
        });
    });

    $('#exportCourseworkMarkButton').click(function(){
        var courseworkId = $('#courseworkSearchDropdown').val();
        var studentNumber = $('#courseworkSearchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#courseworkSearchPageLimit').val()=='Max'?-1:$('#courseworkSearchPageOffset').val()-1);
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudentscourseworkmarks',
            data:{
                courseworkId: courseworkId,
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.saveRowButton').click(function(){
        var rowId = $(this).data('rowid');
        var rowName = $(this).data('rowname');
        var thisElement = $(this);

        var coursework = "";
        var subcoursework = '';
        var weighting = '';

        var elements = $('.'+ rowName);
        for(var i = 0; i < elements.length; i++){
            if(elements[i].getAttribute('data-type')=='coursework'){coursework = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='subcoursework'){subcoursework = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='weighting'){weighting = elements[i].value;}
        }
        $.ajax({
            type: 'POST',
            url: '/updatesubminimumrow',

            data:{
                rowId: rowId,
                coursework: coursework,
                subcoursework: subcoursework,
                weighting: weighting
            },
            success:function(data){
                successOperation(thisElement, false);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.saveSubminimumButton').click(function(){
        var subminimumId = $(this).data('subminimumid');
        var subminimumName = $(this).data('subminimumname');
        var thisElement = $(this);

        var type = "";
        var name = '';
        var threshold = '';

        var elements = $('.'+subminimumName);
        for(var i = 0; i < elements.length; i++){
            if(elements[i].getAttribute('data-type')=='type'){type = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='threshold'){threshold = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
        }
        $.ajax({
            type: 'POST',
            url: '/updatesubminimum',

            data:{
                subminimumId: subminimumId,
                name: name,
                threshold: threshold,
                type: type
            },
            success:function(data){
                successOperation(thisElement), false;
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.saveSectionButton').click(function(){
        var sectionId = $(this).data('sectionid');
        var sectionName = $(this).data('sectionname');
        var thisElement = $(this);

        var name = "";
        var maxMarks = '';

        var elements = $('.'+sectionName);
        for(var i = 0; i < elements.length; i++){
            if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='maxmarks'){maxMarks = elements[i].value;}
        }
        $.ajax({
            type: 'POST',
            url: '/updatesection',

            data:{
                sectionId: sectionId,
                name: name,
                maxMarks: maxMarks
            },
            success:function(data){
                successOperation(thisElement, false);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.saveSubcoursework').click(function(){
        var subcourseworkId = $(this).data('subcourseworkid');
        var subcourseworkName = $(this).data('subcourseworkname');
        var thisElement = $(this);

        var name = "";
        var releaseDate = '';
        var displayPercentage = '';
        var displayMarks = '';
        var maxMarks = '';
        var weightingCourse = '';

        var elements = $('.'+subcourseworkName);
        for(var i = 0; i < elements.length; i++){
            if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='displaypercentage'){displayPercentage = elements[i].checked?1:0;}
            if(elements[i].getAttribute('data-type')=='displaymarks'){displayMarks =  elements[i].checked?1:0;}
            if(elements[i].getAttribute('data-type')=='weightingcourse'){weightingCourse = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='releasedate'){releaseDate = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='maxmarks'){maxMarks = elements[i].value;}
        }
        $.ajax({
            type: 'POST',
            url: '/updatesubcoursework',

            data:{
                subcourseworkId: subcourseworkId,
                name: name,
                displayPercentage: displayPercentage,
                displayMarks: displayMarks,
                weightingCourse: weightingCourse,
                maxMarks: maxMarks,
                releaseDate: releaseDate
            },
            success:function(data){
                successOperation(thisElement, false);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });


    });

    $('.saveCourseworkButton').click(function(){
        var courseworkId = $(this).data('courseworkid');
        var courseworkName = $(this).data('courseworkname');
        var thisElement = $(this);

        var name = "";
        var type = '';
        var weightingYear = '';
        var weightingClass = '';
        var releaseDate = '';

        var elements = $('.'+courseworkName);
        for(var i = 0; i < elements.length; i++){
            if(elements[i].getAttribute('data-type')=='name'){name = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='type'){type = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='weightingyear'){weightingYear = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='weightingclass'){weightingClass = elements[i].value;}
            if(elements[i].getAttribute('data-type')=='releasedate'){releaseDate = elements[i].value;}
        }
        $.ajax({
            type: 'POST',
            url: '/updatecoursework',

            data:{
                courseworkId: courseworkId,
                name: name,
                type: type,
                weightingYear: weightingYear,
                weightingClass: weightingClass,
                releaseDate: releaseDate
            },
            success:function(data){
                successOperation(thisElement, false);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });

    });

    $('#approveTAsButton').click(function(){
        var userIds = [];
        var count = 0;
        var thisElement = $(this);

        var checkboxes = $('.TAsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/approveusers',

            data:{
                userIds:userIds
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshTAsList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#approveStudentsButton').click(function(){
        var userIds = [];
        var count = 0;
        var thisElement = $(this);

        var checkboxes = $('.studentsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/approveusers',

            data:{
                userIds:userIds
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshStudentsList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#approveLecturersButton').click(function(){
        var userIds = [];
        var count = 0;
        var thisElement = $(this);

        var checkboxes = $('.lecturersListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/approveusers',

            data:{
                userIds:userIds
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshLecturersList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#approveConvenorsButton').click(function(){
        var userIds = [];
        var count = 0;
        var thisElement = $(this);

        var checkboxes = $('.convenorsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/approveusers',

            data:{
                userIds:userIds
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshConvenorsList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.TAsAccessButton').click(function(){
        var userIds = [];
        var count = 0;
        var access = $(this).data('access');
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        var checkboxes = $('.TAsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/tasaccess',

            data:{
                userIds:userIds,
                access: access,
                courseId: courseId
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshTAsList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#checkAllTAsList').click(function(){
        var checkboxes = $('.TAsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            checkboxes[i].checked = $(this).is(':checked');
        }
    });

    $('#checkAllStudentsList').click(function(){
        var checkboxes = $('.studentsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            checkboxes[i].checked = $(this).is(':checked');
        }
    });

    $('.lecturersAccessButton').click(function(){
        var userIds = [];
        var count = 0;
        var access = $(this).data('access');
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        var checkboxes = $('.lecturersListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/lecturersaccess',

            data:{
                userIds:userIds,
                access: access,
                courseId: courseId
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshLecturersList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#checkAllLecturersList').click(function(){
        var checkboxes = $('.lecturersListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            checkboxes[i].checked = $(this).is(':checked');
        }
    });

    $('.convenorsAccessButton').click(function(){
        var userIds = [];
        var count = 0;
        var access = $(this).data('access');
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        var checkboxes = $('.convenorsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/convenorsaccess',

            data:{
                userIds:userIds,
                access: access,
                courseId: courseId
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#refreshConvenorsList').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#checkAllConvenorsList').click(function(){
        var checkboxes = $('.convenorsListCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            checkboxes[i].checked = $(this).is(':checked');
        }
    });

    $('#approveParticipantsButton').click(function(){
        var userIds = [];
        var count = 0;
        var thisElement = $(this);

        var checkboxes = $('.searchParticipantsResultsCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            if(checkboxes[i].checked){
                userIds[count++] = checkboxes[i].getAttribute('data-userid');
            }
        }

        $.ajax({
            type: 'POST',
            url: '/approveusers',

            data:{
                userIds:userIds
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#searchParticipantsButton').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#checkAllSearchParticipantsResults').click(function(){
        var checkboxes = $('.searchParticipantsResultsCheckbox');
        for(var i = 0; i < checkboxes.length; i++){
            checkboxes[i].checked = $(this).is(':checked');
        }
    });

    $('.updateSectionMarksButton').click(function(){
        var inputBoxes = $('.sectionMarkInput');
        var sections = [];
        var thisElement = $(this);

        for(var i = 0; i < inputBoxes.length; i++){
            var section = {
                section_id: inputBoxes[i].getAttribute('data-sectionid'),
                student_number: inputBoxes[i].getAttribute('data-studentnumber'),
                marks: inputBoxes[i].value
            };
            sections[i] = section;
        }
        $.ajax({
            type: 'POST',
            url: '/updatesectionmarks',

            data:{
                data:sections
            },
            success:function(data){
                successOperation(thisElement, false);
                $('#searchSubcourseworkMarkButton').click();
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#searchSubcourseworkMarkButton').click(function(){
        var courseworkId = $('#subcourseworkCourseworkDropdown').val();
        var subcourseworkId = $('#subcourseworkSubcourseworkDropdown').val();
        var studentNumber = $('#subcourseworkSearchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#subcourseworkSearchPageLimit').val()=='Max'?-1:$('#subcourseworkSearchPageOffset').val()-1);
        var thisElement = $(this);

        var valid = $(this).data('valid');

        $.ajax({
            type: 'POST',
            url: '/getstudentssubcourseworkmarks',
            data:{
                courseworkId: courseworkId,
                subcourseworkId: subcourseworkId,
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset
            },
            success:function(data){
                $('#subcourseworkSearchResultsTable').parent().parent().parent().show();
                var dataString =    '<table id="subcourseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">'+
                    '<thead>'+
                    '<tr class="headings">'+
                    '<th class="column-title">Student #</th>'+
                    '<th class="column-title">Employee #</th>';
                for(var i = 0; i < data.columns.length; i++){
                    dataString += '<th class="column-title">'+data.columns[i]+'</th>';
                }
                if(data.columns.length <=0){
                    dataString += '<th class="column-title"><i>(No Section Found)</i></th>';
                }
                dataString += '<th class="column-title">Total Marks</th>';
                dataString += '<th class="column-title">Total Marks(%)</th>';
                dataString += '<th class="column-title">Weighted Marks</th>';
                dataString += '</tr></thead>';
                dataString += '<tbody id="courseworkSearchResultsBody">';
                for(var i = 0; i < data.marks.length; i++){
                    var record = data.marks[i];
                    dataString += '<tr class="even pointer">';
                    dataString +=  '<td>'+record.student_number+'</td>';
                    dataString +=  '<td>'+record.employee_id+'</td>';
                    for(var j = 0; j < record.sections.length; j++) {
                        if (valid) {
                            dataString += '<td>'+record.sections[j].numerator + ' / ' + record.sections[j].denominator +'</td>';
                        } else {
                            dataString += '<td><input type="number" min="0" max="' + record.sections[j].denominator + '" data-studentnumber="' + record.student_number + '" data-sectionid="' + record.sections[j].id + '" style="width:50px"class="sectionMarkInput" value="' + record.sections[j].numerator + '"> / ' + record.sections[j].denominator + '</td>';
                        }
                    }
                    if(record.sections.length <= 0 ){
                        dataString += '<td><i>No Section Found</i></td>';
                    }
                    dataString +=  '<td>'+record.total_num + ' / ' + record.total_den +'</td>';
                    dataString +=  '<td>'+record.percentage +'</td>';
                    dataString +=  '<td>'+record.weighted_marks +'</td>';
                    dataString +=  '</tr>';
                }
                dataString += '</tbody>';

                $('#subcourseworkSearchResultsTable').replaceWith(dataString);
                $('#subcourseworkSearchResultsTable').show();
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
//                        $('#courseworkSearchResultsBody').hide();
            }
        });
    });

    $('#subcourseworkCourseworkDropdown').change(function(){
        var subcourseworkDropdown = $('#subcourseworkSubcourseworkDropdown');
        subcourseworkDropdown.empty();

        var selectedCoursework = $(this).val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();

        $.ajax({
            type: 'POST',
            url: '/getsubcourseworks',
            data:{
                _token:token,
                coursework: selectedCoursework,
                courseId: courseId
            },
            success:function(data){
                var option = document.createElement('option');
                option.value=-1;
                option.text = "";
                subcourseworkDropdown.append(option);

                for(var i = 0; i < data.length; i++){
                    var option = document.createElement('option');
                    option.value = data[i].id;
                    option.text = data[i].name;
                    subcourseworkDropdown.append(option);
                }
            }
        });
    });

    $('#searchCourseworkMarkButton').click(function(){
        var courseworkId = $('#courseworkSearchDropdown').val();
        var studentNumber = $('#courseworkSearchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#courseworkSearchPageLimit').val()=='Max'?-1:$('#courseworkSearchPageOffset').val()-1);
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudentscourseworkmarks',
            data:{
                courseworkId: courseworkId,
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset
            },
            success:function(data){
                $('#courseworkSearchResultsTable').parent().parent().parent().show();
                var dataString =    '<table id="courseworkSearchResultsTable" class="table table-striped jambo_table bulk_action">'+
                    '<thead>'+
                    '<tr class="headings">'+
                    '<th class="column-title">Student #</th>'+
                    '<th class="column-title">Employee #</th>';
                for(var i = 0; i < data.columns.length; i++){
                    dataString += '<th class="column-title">'+data.columns[i]+'</th>';
                }
                dataString += '<th class="column-title">Total</th></tr></thead>';
                dataString += '<tbody id="courseworkSearchResultsBody">';
                for(var i = 0; i < data.marks.length; i++){
                    var record = data.marks[i];
                    dataString += '<tr class="even pointer">';
                    dataString +=  '<td>'+record.student_number+'</td>';
                    dataString +=  '<td>'+record.employee_id+'</td>';
                    for(var j = 0; j < record.subcourseworks.length; j++){
                        dataString +=  '<td>'+record.subcourseworks[j]+'</td>';
                    }
                    dataString +=  '<td>'+record.total_marks+'</td>';
                    dataString +=  '</tr>';
                }
                dataString += '</tbody>';

                $('#courseworkSearchResultsTable').replaceWith(dataString);
                $('#courseworkSearchResultsTable').show();
                successOperation(thisElement, false);
            },
            error: function(data) {
                failOperation(thisElement);
                $('#courseworkSearchResultsTable').hide();
            }
        });
    });

    $('.deleteSubminimumButton').click(function(){
        var rowId = $(this).data('subminimumid');
        var thisElement = $(this);

        var confirmation = confirm('Are you sure you want to delete the subminimum? This may affect the DP calculation.');
        if(confirmation) {
            $.ajax({
                type: 'POST',
                url: '/deletesubminimum',
                data: {
                    id: rowId
                },
                success: function (data) {
                    successOperation(thisElement, true);
                },
                error: function (data) {
                    failOperation(thisElement);
                }
            });
        } else {
            nullOperation(thisElement);
        }
    });

    $('.deleteRowButton').click(function(){
        var rowId = $(this).data('rowid');
        var thisElement = $(this);

        var confirmation = confirm('Are you sure you want to delete the subminimum row? This may affect the DP calculation.');

        if(confirmation) {
            $.ajax({
                type: 'POST',
                url: '/deletesubminimumrow',
                data: {
                    id: rowId
                },
                success: function (data) {
                    successOperation(thisElement, true);
                },
                error: function (data) {
                    failOperation(thisElement);
                }
            });
        } else {
            nullOperation(thisElement);
        }
    });

    $('#newRowButton').click(function(){
        $('#subminimumId').val($(this).data('subminimumid'));
    });

    $('#createSubminimumButtonModal').click(function(){
        var subminimumId = $('#subminimumId').val();
        var coursework = $('#courseworkSubminimumDropdown').val();
        var subcoursework = $('#subcourseworkSubminimumDropdown').val();
        var weighting = $('#subminimumRowWeighting').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/createsubminimumrow',
            data:{
                subminimumId: subminimumId,
                coursework: coursework,
                subcoursework: subcoursework,
                weighting: weighting
            },
            success:function(data){
                $('#courseworkSubminimumDropdown').val('');
                $('#subcourseworkSubminimumDropdown').val('');
                $('#subminimumRowWeighting').val('');
                successOperation(thisElement, true);
            },
            error: function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#courseworkSubminimumDropdown').change(function() {
        var subcourseworkDropdown = $('#subcourseworkSubminimumDropdown').empty();
        var selectedCoursework = $(this).val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();

        $.ajax({
            type: 'POST',
            url: '/getsubcourseworks',
            data: {
                _token: token,
                coursework: selectedCoursework,
                courseId: courseId
            },
            success: function (data) {
                var option = document.createElement('option');
                option.text = "";
                option.value = -1;
                subcourseworkDropdown.append(option);

                for (var i = 0; i < data.length; i++) {
                    var option = document.createElement('option');
                    option.value = data[i].id;
                    option.text = data[i].name;
                    subcourseworkDropdown.append(option);
                }
            }
        });
    });

    $('#refreshTAsList').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getteachingassistants',
            data:{
                courseId: courseId
            },
            success: function(data){
                var dataString = '<tbody id="TAsListResultsBody">';
                for(var i = 0; i < data.length; i++){
                    var element = data[i];
                    dataString += '<tr class="even pointer">' +
                        '<td class="a-center ">' +
                        '<input type="checkbox" class="TAsListCheckbox" data-userid='+element.id+'>' +
                        '</td>' +
                        '<td class=" ">' + element.first_name + '</td>' +
                        '<td class=" ">' + element.last_name + '</td>' +
                        '<td class=" ">' + element.staff_number + '</td>' +
                        '<td class=" ">' + element.employee_id + '</td>' +
                        '<td class=" ">' + element.email + '</td>' +
                        '<td class=" ">' + element.access + '</td>' +
                        '<td class=" ">' + element.approved + '</td>' +
                        '</tr>';
                }
                dataString += '</tbody>';
                $('#TAsListResultsBody').replaceWith(dataString);
                refreshDone(thisElement);
            },
            error: function(data){
                refreshDone(thisElement);
            }
        });
    });

    $('#refreshStudentsList').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudents',
            data:{
                courseId: courseId
            },
            success: function(data){
                var dataString = '<tbody id="studentsListResultsBody">';
                for(var i = 0; i < data.length; i++){
                    var element = data[i];
                    dataString += '<tr class="even pointer">' +
                        '<td class="a-center ">' +
                        '<input type="checkbox" class="studentsListCheckbox" data-userid='+element.id+'>' +
                        '</td>' +
                        '<td class=" ">' + element.first_name + '</td>' +
                        '<td class=" ">' + element.last_name + '</td>' +
                        '<td class=" ">' + element.staff_number + '</td>' +
                        '<td class=" ">' + element.employee_id + '</td>' +
                        '<td class=" ">' + element.email + '</td>' +
                        '<td class=" ">' + element.access + '</td>' +
                        '<td class=" ">' + element.approved + '</td>' +
                        '</tr>';
                }
                dataString += '</tbody>';
                $('#studentsListResultsBody').replaceWith(dataString);
                refreshDone(thisElement);
            },
            error: function(data){
                refreshDone(thisElement);
            }
        });
    });

    $('#refreshLecturersList').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getlecturers',
            data:{
                courseId: courseId
            },
            success: function(data){
                var dataString = '<tbody id="lecturersListResultsBody">';
                for(var i = 0; i < data.length; i++){
                    var element = data[i];
                    dataString += '<tr class="even pointer">' +
                        '<td class="a-center ">' +
                        '<input type="checkbox" class="lecturersListCheckbox" data-userid="'+element.id+'">' +
                        '</td>' +
                        '<td class=" ">' + element.first_name + '</td>' +
                        '<td class=" ">' + element.last_name + '</td>' +
                        '<td class=" ">' + element.staff_number + '</td>' +
                        '<td class=" ">' + element.employee_id + '</td>' +
                        '<td class=" ">' + element.email + '</td>' +
                        '<td class=" ">' + element.access + '</td>' +
                        '<td class=" ">' + element.approved + '</td>' +
                        '</tr>';
                }
                dataString += '</tbody>';
                $('#lecturersListResultsBody').replaceWith(dataString);
                refreshDone(thisElement);
            },
            error: function(data){
                refreshDone(thisElement);
            }
        });

    });

    $('.refreshSpin').click(function(){
        $(this).children('#refreshPlaceholder').replaceWith('<i id="refreshPlaceholder" class="glyphicon glyphicon-refresh fa-spin"></i>');
    });

    function refreshDone(element){
        element.children('#refreshPlaceholder').replaceWith('<i id="refreshPlaceholder" class="fa fa-check-circle"></i>');
    }

    $('#refreshConvenorsList').click(function(){
        var courseId = $('#courseId').val();
        var thisElement = $(this);
        $('#checkAllConvenorsList').attr('checked', false);

        $.ajax({
            type: 'POST',
            url: '/getconvenors',
            data:{
                courseId: courseId
            },
            success: function(data){
                var dataString = '<tbody id="convenorsListResultsBody">';
                for(var i = 0; i < data.length; i++){
                    var element = data[i];
                    dataString += '<tr class="even pointer">' +
                        '<td class="a-center ">' +
                        '<input type="checkbox" class="convenorsListCheckbox" data-userid='+element.id+'>' +
                        '</td>' +
                        '<td class=" ">' + element.first_name + '</td>' +
                        '<td class=" ">' + element.last_name + '</td>' +
                        '<td class=" ">' + element.staff_number + '</td>' +
                        '<td class=" ">' + element.employee_id + '</td>' +
                        '<td class=" ">' + element.email + '</td>' +
                        '<td class=" ">' + element.access + '</td>' +
                        '<td class=" ">' + element.approved + '</td>' +
                        '</tr>';
                }
                dataString += '</tbody>';
                $('#convenorsListResultsBody').replaceWith(dataString);
                refreshDone(thisElement);
            },
            error: function(data){
                refreshDone(thisElement);
            }
        });
    });

    $('.spinnerNeeded').click(function(){
        $(this).children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-spinner fa-spin"></i>');

    });

    $('.deleteCourseworkButton').click(function(){
        var courseworkid = $(this).data('courseworkid');
        var thisElement = $(this);

        var confirmation = confirm('Are you sure you want to delete the coursework? All the assosciated contents such as ' +
            'subcoursework, sections and marks will be deleted and this is not reversible.')

        if(confirmation) {
            $.ajax({
                type: 'POST',
                url: '/deletecoursework',
                data: {
                    courseworkId: courseworkid,
                },
                success: function (data) {
                    successOperation(thisElement, true);
                },
                error: function (data) {
                    failOperation(thisElement);
                }
            });
        } else {
            nullOperation(thisElement);
        }
    });

    $('#createSectionButtonModal').click(function(){
        var maxMarks = $('#sectionMaxMarks').val();
        var name = $('#sectionName').val();
        var subcourseworkId = $('#subcourseworkId').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/createsection',
            data:{
                name: name,
                maxMarks: maxMarks,
                subcourseworkId: subcourseworkId
            },
            success:function(data){
                successOperation(thisElement, true);
                $('#sectionMaxMarks').val("");
                $('#sectionName').val("");
                $('#subcourseworkId').val("");
            },
            error: function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.newSectionButton').click(function(){
        $('#subcourseworkId').val($(this).data('subcourseworkid'));
    });

    $('.deleteSection').click(function(){
        var sectionid = $(this).data('sectionid');
        var thisElement = $(this);

        var confirmation = confirm('Are you sure you want to delete the section? All students\' marks assosciated to that' +
            ' will be lost.');

        if(confirmation) {
            $.ajax({
                type: 'POST',
                url: '/deletesection',
                data: {
                    sectionId: sectionid,
                },
                success: function (data) {
                    successOperation(thisElement, true);
                },
                error: function (data) {
                    failOperation(thisElement);
                }
            });
        } else {
            nullOperation(this);
        }
    });

    $('.deleteSubcoursework').click(function(){
        var subcourseworkid = $(this).data('subcourseworkid');
        var thisElement = $(this);

        var confirmation = confirm('Are you sure you want to delete the subcoursework? All assosciated contents will be deleted.');

        if(confirmation) {
            $.ajax({
                type: 'POST',
                url: '/deletesubcoursework',
                data: {
                    subcourseworkId: subcourseworkid,
                },
                success: function (data) {
                    successOperation(thisElement, true);
                },
                error: function (data) {
                    failOperation(thisElement);
                }
            });
        } else {
            nullOperation(this);
        }
    });

    $('#createSubcourseworkButtonModal').click(function(){
        var courseworkId = $('#modalCourseworkId').val();
        var name = $('#subcourseworkName').val();
        var releaseDate = $('#subcourseworkReleaseDate').val();
        var maxMarks = $('#subcourseworkMaxMarks').val();
        var weighting = $('#subcourseworkWeighting').val();
        var displayMarks = $('#subcourseworkDisplayMarks').is(':checked')?1:0;
        var displayPercentage = $('#subcourseworkDisplayPercentage').is(':checked')? 1:0;
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/createsubcoursework',
            data:{
                courseworkId: courseworkId,
                name: name,
                releaseDate: releaseDate,
                maxMarks: maxMarks,
                weighting: weighting,
                displayMarks: displayMarks,
                displayPercentage: displayPercentage
            },
            success:function(data){
                $('#modalCourseworkId').val("");
                $('#subcourseworkName').val("");
                $('#subcourseworkMaxMarks').val("");
                $('#subcourseworkWeighting').val("");
                $('#subcourseworkDisplayMarks').val("");
                $('#subcourseworkDisplayPercentage').val("");
                successOperation(thisElement, true);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('.createSubcourseworkButton').click(function(){
        var courseworkId = $(this).data('courseworkid');
        $('#modalCourseworkId').val(courseworkId);
    });

    $('#updateFinalGradeButton').click(function(){
        var elements = $('.studentFinalGradeDropdown');
        var updates = [];
        var courseId = $('#courseId').val();
        var thisElement = $(this);

        for(var i = 0; i < elements.length; i++){
            element = elements[i];
            var userId = element.getAttribute('data-userid');
            var value = element.value;
            var row = [];
            row[0] = userId; row[1] = value;
            updates[i] = row;
        }
        $.ajax({
            type: 'POST',
            url: '/updatefinalgrade',

            data: {
                values: updates,
                courseId: courseId
            },
            success:function(data){
                successOperation(thisElement, false);
            },
            error:function(data){
                failOperation(thisElement);
            }

        });
    });

    $('#searchMarkButton').click(function(){
        var studentNumber = $('#searchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#searchResultsPageLimit').val()=='Max'?-1:$('#searchResultsPageOffset').val()-1);
        var thisElement = $(this);


        $.ajax({
            type: 'POST',
            url: '/getstudentsmarks',
            data:{
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset
            },
            success:function(data){
                var originalData = data;
                var types = data[1];
                data = data[0];

                var dataString = '<tbody id="searchMarkResultsBody">';
                for(var i = 0; i < data.length; i++){
                    var optionString = '';
                    for(var j = 1; j < types.length; j++){
                        optionString += '<option value="'+types[j].id+'" '+(data[i].final_grade==types[j].name?'selected':'')+'>'+types[j].name+'</option>';
                    }

                    dataString += '<tr class="even pointer">';
                    dataString +=  '<td>'+data[i].student_number+'</td>';
                    dataString +=  '<td>'+data[i].employee_id+'</td>';
                    dataString +=  '<td>'+data[i].class_mark+'</td>';
                    dataString +=  '<td>'+data[i].year_mark+'</td>';
                    dataString +=  '<td>'+data[i].dp_status+'</td>';
                    dataString +=  '<td>'+
                        '<select class="studentFinalGradeDropdown" data-index="'+i+'" data-userid="'+data[i].id+'">' +
                        '<option value="1">'+data[i].year_mark+'</option>'+
                        optionString+
                        '</select>'+
                        '</td>';
                    dataString +=  '</tr>';
                }
                dataString += '</tbody>';

                $('#searchMarkResultsBody').replaceWith(dataString);
                $('#searchResultsBody').show();
                successOperation(thisElement, false);

                var elements = $('.studentFinalGradeDropdown');
                for(var i = 0; i < elements.length; i++){
                    var index = elements[i].getAttribute('data-index');
                    elements.value = 5;
                }

            },
            error: function(data){
                failOperation(thisElement);
                $('#searchResultsBody').hide();

            }
        });
    });

    $('#exportMarkButton').click(function(){
        var studentNumber = $('#searchStudentNumber').val();
        var courseId = $('#courseId').val();
        var offset = ($('#searchResultsPageLimit').val()=='Max'?-1:$('#searchResultsPageOffset').val()-1);
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/getstudentsmarks',
            data:{
                courseId: courseId,
                studentNumber: studentNumber,
                offset: offset,
                download:true
            },
            success:function(data){
                window.open($('#assetPath').val()+data,'_blank');
                successOperation(thisElement, false);
            },
            error: function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#uploadSubcourseworkDropdown').change(function(){
        var sectionDropdown = $('#uploadSectionDropdown').empty();
        var selectedSubcoursework = $(this).val();
        var token = $('#_token').val();

        $.ajax({
            type: 'POST',
            url: '/getsections',
            data:{
                _token:token,
                subcoursework: selectedSubcoursework
            },
            success:function(data){
                var option = document.createElement('option');
                option.text = "";
                option.value = -1;
                sectionDropdown.append(option);
                for(var i = 0; i < data.length; i++){
                    var option = document.createElement('option');
                    option.text = data[i].name;
                    option.value = data[i].id;
                    sectionDropdown.append(option);
                }
            }
        });
    });

    $('#uploadCourseworkDropdown').change(function() {
        var subcourseworkDropdown = $('#uploadSubcourseworkDropdown').empty();
        $('#uploadSectionDropdown').empty();
        var selectedCoursework = $(this).val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();

        if(selectedCoursework == 0){
            subcourseworkDropdown.prop('disabled', true);
            $('#uploadSectionDropdown').prop('disabled', true);
        } else {
            subcourseworkDropdown.prop('disabled', false);
            $('#uploadSectionDropdown').prop('disabled', false);
            $.ajax({
                type: 'POST',
                url: '/getsubcourseworks',
                data: {
                    _token: token,
                    coursework: selectedCoursework,
                    courseId: courseId
                },
                success: function (data) {
                    var option = document.createElement('option');
                    option.text = "";
                    option.value = -1;
                    subcourseworkDropdown.append(option);

                    for (var i = 0; i < data.length; i++) {
                        var option = document.createElement('option');
                        option.text = data[i].name;
                        option.value = data[i].id;
                        subcourseworkDropdown.append(option);
                    }
                }
            });
        }
    });

    $('#createSubminimumButton').click(function(){
        var courseId = $('#courseId').val();
        var token = $('#_token').val();
        var name = $('#subminimumName').val();
        var type = $('#subminimumType').val();
        var threshold = $('#subminimumThreshold').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/createsubminimum',
            data:{
                _token:token,
                name: name,
                type: type,
                threshold: threshold,
                courseId: courseId
            },
            success:function(data){
                $('#subminimumName').val('');
                $('#subminimumType').val('');
                $('#subminimumThreshold').val('');
                successOperation(thisElement, true);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#createCourseworkButton').click(function(){
        var name = $('#courseworkName').val();
        var type = $('#courseworkType').val();
        var releaseDate = $('#courseworkReleaseDate').val();
        var classWeighting = $('#courseworkClassWeighting').val();
        var yearWeighting = $('#courseworkYearWeighting').val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();
        var thisElement = $(this);


        $.ajax({
            type: 'POST',
            url: '/createcoursework',
            data:{
                _token:token,
                name: name,
                type: type,
                releaseDate:releaseDate,
                classWeighting: classWeighting,
                yearWeighting: yearWeighting,
                courseId: courseId
            },
            success:function(data){
                $('#courseworkName').val("");
                $('#courseworkType').val("");
                $('#courseworkClassWeighting').val("");
                $('#courseworkYearWeighting').val("");
                successOperation(thisElement, true);
            },
            error:function(data){
                failOperation(thisElement);
            }
        });
    });

    $('#searchParticipantsButton').click(function(){
        var studentNumber = $('#participantsStudentNumber').val();
        var emailAddress = $('#participantsEmail').val();
        var limit = $('#participantsPageLimit').val();
        var offset = $('#participantsPageOffset').val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/participantslist',
            data: {
                _token: token,
                limit: limit,
                offset: offset,
                studentNumber: studentNumber,
                emailAddress: emailAddress,
                courseId: courseId
            },
            success: function (data) {
                var dataString ='<tbody id="searchParticipantsResultsBody">';
                for(var i = 0; i < data.length; i++) {
                    dataString += '<tr class="even pointer">' +
                        '<td class="a-center table-row">' +
                        '<input type="checkbox" class="searchParticipantsResultsCheckbox" data-userid="' + data[i].id + '">' +
                        '</td>' +
                        '<td class="table-row">' + data[i].firstName + '</td>' +
                        '<td class="table-row">' + data[i].lastName + '</td>' +
                        '<td class="table-row">' + data[i].studentNumber + '</td>' +
                        '<td class="table-row">' + data[i].employeeId + '</td>' +
                        '<td class="table-row">' + data[i].email + '</td>' +
                        '<td class="table-row">' + data[i].role + '</td>' +
                        '<td class="table-row">' + data[i].status + '</td>' +
                        '<td class="table-row">' + data[i].approved + '</td>' +
                        '</tr>';
                }
                dataString += '</tbody>';
                $('#searchParticipantsResultsBody').replaceWith(dataString);
                successOperation(thisElement, false);
            },
            error: function(data){
                failOperation(thisElement);
            }
        });
        $('#searchParticipantsPanel').show();
    });

    $('#updateInfoButton').click(function(){
        var courseName = $('#courseName').val();
        var courseCode = $('#courseCode').val();
        var courseType = $('#courseType').val();
        var startDate = $('#courseStartDate').val();
        var endDate = $('#courseEndDate').val();
        var courseDescription = $('#courseDescription').val();
        var courseTerm = $('#courseTerm').val();
        var courseId = $('#courseId').val();
        var token = $('#_token').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/updatecourse',
            data: {
                courseId: courseId,
                name: courseName,
                code: courseCode,
                type: courseType,
                startDate: startDate,
                endDate: endDate,
                description: courseDescription,
                term: courseTerm
            },
            success: function (data) {
                successOperation(thisElement, false);
            },
            error: function (data){
                failOperation(thisElement);
            }
        });
    });

    function successOperation(element, showReload){
        element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
        if(showReload){
            document.getElementById('reloadPageButton').style.display = 'block';
        }
    }

    function failOperation(element){
        element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
    }

    $('#addConvenorButton').click(function(){
        var convenorEmailAddress = $('#convenorEmailAddress').val();
        var courseId = $('#courseId').val();
        var convenorInvitationCheckbox = $('#convenorInvitationCheckbox').is(':checked')?1:0;
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/addconvenor',
            data: {
                courseId: courseId,
                email: convenorEmailAddress,
                invitation: convenorInvitationCheckbox
            },
            success: function (data) {
                successOperation(thisElement, true);
                $('#convenorEmailAddress').val('')
            },
            error: function(data){
                failOperation(thisElement);
            }
        });

    });

    $('#addLecturerButton').click(function(){
        var lecturerEmailAddress = $('#lecturerEmailAddress').val();
        var courseId = $('#courseId').val();
        var lecturerInvitationCheckbox = $('#lecturerInvitationCheckbox').is(':checked')?1:0;
        var token = $('#_token').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/addlecturer',
            data: {
                courseId: courseId,
                email: lecturerEmailAddress,
                invitation: lecturerInvitationCheckbox
            },
            success: function (data) {
                successOperation(thisElement, true);
                $('#lecturerEmailAddress').val('');
            },
            error: function(data){
                failOperation(thisElement);
            }
        });

    });

    $('#addTAButton').click(function(){
        var taEmailAddress = $('#taEmailAddress').val();
        var courseId = $('#courseId').val();
        var taInvitationCheckbox = $('#taInvitationCheckbox').is(':checked')?1:0;
        var token = $('#_token').val();
        var thisElement = $(this);

        $.ajax({
            type: 'POST',
            url: '/addta',
            data: {
                courseId: courseId,
                email: taEmailAddress,
                invitation: taInvitationCheckbox
            },
            success: function (data) {
                successOperation(thisElement, true);
                $('#taEmailAddress').val('');
            },
            error: function(data){
                failOperation(thisElement);
            }
        });

    });

    function nullOperation(element){
        element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder"></i>');
    }
})