<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="box-body">
        <div id="status"></div>
        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Role Name </label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label for="all_permission">Assign Permissions <strong>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Select All : <input type="checkbox"
                                                                           name="all_permission"
                                                                           value="ALL"/></strong></label>
                <br/> <br/>
                @foreach($permission as $value)
                    <span class="col-md-4">
                        <input type="checkbox" name="all_permission" class="data-check"
                               value="{{$value->id}}" id="all_permission"/>
                        {{ $value->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-12"><br/> <br/>
            <input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary">
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.box-body -->
</form>
<script>
    $(function () {
        $('input[name=all_permission]').click(function () {

            //If the ALL option was selected
            if ($(this).val() == "ALL") {
                //Checks all of the non-"ALL" options
                $('input[name=all_permission]').not('[value=ALL]').each(function () {
                    $(this)[0].checked = $("input[name=all_permission][value=ALL]")[0].checked;
                });
            }
            //Otherwise - determine if all should be
            else {
                //Checks the "ALL" option accordingly
                var othersChecked = $('input[name=all_permission]:checked').not('[value=ALL]').length == $('input[name=all_permission]').not('[value=ALL]').length;

                $("input[name=all_permission][value=ALL]")[0].checked = othersChecked;
            }
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#loader').hide();
        $('#create').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                name: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Enter Role Name'
                }
            },
            submitHandler: function (form) {

                var list_id = [];
                $(".data-check:checked").each(function () {
                    list_id.push(this.value);
                });
                if (list_id.length > 0) {

                    //  var title = $("#msg_title").val();
                    //  var details = $("#msg_details").val();

                    var myData = new FormData($("#create")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);
                    myData.append('permissions', list_id);


                    swal({
                        title: "Confirm to assign " + list_id.length + " permissions",
                        text: "Assign permission with that role!",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Assign!"
                    }, function () {

                        $.ajax({
                            url: 'roles',
                            type: 'POST',
                            data: myData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $('#loader').show();
                                $("#submit").prop('disabled', true); // disable button
                            },
                            success: function (data) {

                                if (data.type === 'success') {
                                    swal("Done!", "It was succesfully done!", "success");
                                    reload_table();
                                    notify_view(data.type, data.message);
                                    $('#loader').hide();
                                    $("#submit").prop('disabled', false); // disable button
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    $('#myModal').modal('hide'); // hide bootstrap modal

                                } else if (data.type === 'error') {
                                    if (data.errors) {
                                        $.each(data.errors, function (key, val) {
                                            $('#error_' + key).html(val);
                                        });
                                    }
                                    $("#status").html(data.message);
                                    $('#loader').hide();
                                    $("#submit").prop('disabled', false); // disable button
                                    swal("Error sending!", "Please try again", "error");

                                }

                            }
                        });
                    });

                }
                else {
                    swal("", "No Permission Have Selected!", "warning");
                }

            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>