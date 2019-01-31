<div class='row'>
    {!! Form::model($role, ['method' => 'PATCH','id'=>'edit']) !!}
    <div class="col-xs-12 col-sm-12 col-md-12">
        {{ Form::label('name', 'Role Name') }}
        {{ Form::text('name', null, array('class' => 'form-control')) }}
    </div>
    <div class="clearfix"></div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <label for="all_permission">Assign Permissions </label>
            <br/> <br/>
            @foreach($permissions as $permission)
            <span class="col-md-4">
                {{Form::checkbox('permissions[]',  $permission->id, $role->permissions, array('class'=>'data-check', 'id'=>'all_permission')) }}
                {{Form::label($permission->name, ucfirst($permission->name)) }}
            </span>
            @endforeach
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-md-12"><br/> <br/>
        {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
    <div class="clearfix"></div>
</div>
<script>
    $(document).ready(function () {
        $('#loader').hide();
        $('#edit').validate({// <- attach '.validate()' to your form
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

                    var myData = new FormData($("#edit")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);
                    // myData.append('permissions', list_id);


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
                            url: 'roles/' + '{{ $role->id }}',
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