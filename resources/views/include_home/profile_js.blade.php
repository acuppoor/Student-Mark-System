    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            $('#updateUserInfoButton').click(function () {
                var firstName = $('#firstName').val();
                var lastName = $('#lastName').val();
                var studentNumber = $('#studentNumber').val();
                var employeeId = $('#employeeId').val();
                var email = $('#emailAddress').val();
                var userId = $(this).data('id');

                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/updatepersonalinfo',
                    data: {
                        firstName: firstName,
                        lastName: lastName,
                        studentNumber: studentNumber,
                        employeeID: employeeId,
                        email: email,
                        userId: userId
                    },
                    success: function (data) {
                        successOperation(thisElement, false);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                })
            });

            $('#updatePasswordButton').click(function () {
                var oldPassword = $('#oldPassword').val();
                var newPasswordOne = $('#newPasswordOne').val();
                var newPasswordTwo = $('#newPasswordTwo').val();
                var userId = $(this).data('id');

                if(newPasswordOne != newPasswordTwo){
                    $('#newPasswordOne').val('');
                    $('#newPasswordTwo').val('');
                    alert('Passwords do not match. Please enter Again');
                    $('#newPasswordOne').focus();
                }

                var thisElement = $(this);

                $.ajax({
                    type: 'POST',
                    url: '/changepassword',
                    data: {
                        oldPassword: oldPassword,
                        newPasswordOne: newPasswordOne,
                        newPasswordTwo: newPasswordTwo,
                        userId: userId
                    },
                    success: function (data) {
                        $('#oldPassword').val('');
                        $('#newPasswordOne').val('');
                        $('#newPasswordTwo').val('');
                        successOperation(thisElement, false);
                    },
                    error: function (data) {
                        failOperation(thisElement);
                    }
                })
            });

            function successOperation(element, showReload) {
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-check-circle"></i>');
                if (showReload) {
                    document.getElementById('reloadPageButton').style.display = 'block';
                }
            }

            function failOperation(element) {
                element.children('.spinnerPlaceholder').replaceWith('<i class="spinnerPlaceholder fa fa-times-circle"></i>');
            }
        });


    </script>
