<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="box-body">
        <div id="status"></div>
        {{method_field('PATCH')}}
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Division Name </label>
            <input type="text" class="form-control" id="division_name" name="division_name" value="{{ $division->division_name }}"
                   placeholder="" required>
            <span id="error_division_name" class="has-error"></span>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Division Area </label>
            <input type="text" class="form-control" id="division_area" name="division_area" value="{{ $division->division_area }}"
                   placeholder="" required>
            <span id="error_division_area" class="has-error"></span>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Division Address </label>
            <input type="text" class="form-control" id="division_address" name="division_address" value="{{ $division->division_address }}"
                   placeholder="" required>
            <span id="error_division_address" class="has-error"></span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-12">
            <input type="submit" id="submit" name="submit" value="Save" class="btn btn-primary">
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- /.box-body -->
</form>
<script>
    $(document).ready(function () {
        $('#loader').hide();
        $('#edit').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                username: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                first_name: {
                    required: 'নামের প্রথমাংশ প্রেরন করুন'
                },
                last_name: {
                    required: 'নামের শেষাংশ প্রেরন করুন'
                },
                email: {
                    required: 'ই-মেইল প্রেরন করুন'
                },
                username: {
                    required: 'লগইন নাম প্রেরন করুন'
                }
            },
            submitHandler: function (form) {

                var myData = new FormData($("#edit")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'divisions/' + '{{ $division->id }}',
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
                        notify_view(data.type, data.message);
                        reload_table();
                        $('#loader').hide();
                        $("#submit").prop('disabled', false); // disable button
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $('#myModal').modal('hide'); // hide bootstrap modal
                    }
                });
            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>