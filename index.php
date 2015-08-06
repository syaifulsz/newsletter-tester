<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Newsletter Tester - Syaiful Shah Zinan</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="nt-progress-bar controller--nt-progress-bar hide">
    <div class="progress">
        <div class="progress-bar progress-bar-danger" role="progressbar">
            <span class="sr-only">60% Complete</span>
        </div>
    </div>
</div><!-- .nt-progress-bar -->

<div class="nt-body">
    <div class="nt-body-row">
        <div class="nt-body-col nt-body-col--sidebar nt-sidebar">

            <form class="nt-form controller--nt-form" method="get" action="newsletter-tester.php">
                <div class="form-group">
                    <label for="email" class="form-label">Your E-mail</label>
                    <input type="text" class="controller--nt-form--email form-control input-lg" name="email" id="email" placeholder="username@gmail.com" />
                    <div class="help-block hide"></div>
                </div><!-- .form-group -->
                <div class="form-group">
                    <label for="password" class="form-label">Your Password</label>
                    <input type="password" class="controller--nt-form--password form-control input-lg" name="password" id="password" placeholder="password" />
                    <div class="help-block hide"></div>
                </div><!-- .form-group -->

                <div class="nt-form-divider"></div>

                <div class="form-group">
                    <label for="send_to_1" class="form-label">E-mail 1</label>
                    <input type="text" class="form-control input-lg" name="send_to[]" id="send_to_1" placeholder="username@gmail.com" />
                </div><!-- .form-group -->

                <div class="controller--additional-email" data-count="1"></div>

                <div class="form-group">
                    <button type="button" class="btn btn-success btn-block controller--additional-email--trigger">Add Additional E-mail</button>
                </div><!-- .form-group -->

                <div class="nt-form-divider"></div>

                <div class="form-group">
                    <label for="nt_index" class="form-label">Newsletter Index</label>
                    <input type="text" class="form-control input-lg controller--nt-form--index" name="nt_index" id="nt_index" placeholder="sample" />
                    <div class="help-block hide"></div>
                </div><!-- .form-group -->

                <div class="nt-form-divider"></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Send</button>
                    <button type="reset" class="btn btn-link btn-block">Reset</button>
                </div><!-- .form-group -->

            </form><!-- .nt-form -->

        </div><!-- .nt-sidebar -->
        <div class="nt-body-col nt-body-col--content nt-content controller--nt-content">
            <div class="alert alert-info">Please fill in Newsletter Tester setting details</div>
        </div>
    </div><!-- .nt-body-row -->
</div><!-- .nt-body -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/js-cookie/src/js.cookie.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

        var progressBar = $('.controller--nt-progress-bar');

        var additionalEmail = $('.controller--additional-email');
        var additionalEmail_trigger = $('.controller--additional-email--trigger');
        var ntForm = $('.controller--nt-form');
        var ntContent = $('.controller--nt-content');

        var ntFormReqUsername = $('.controller--nt-form--email');
        var ntFormReqPassword = $('.controller--nt-form--password');
        var ntFormReqIndex = $('.controller--nt-form--index');

        function ntForm_disabled() {
            ntForm.find('input').attr('disabled', 'disabled');
            ntForm.find('.btn').addClass('disabled');
        }

        function ntForm_enabled() {
            ntForm.find('input').removeAttr('disabled');
            ntForm.find('.btn').removeClass('disabled');
        }

        $(document).on('click', '.controller--additional-email--trigger', function(e) {
            e.preventDefault();

            var additionalEmail_id = parseInt(additionalEmail.attr('data-count')) + 1;
            var additionalEmail_html = '<div class="form-group">' +
                '<label for="send_to_'+ additionalEmail_id +'" class="form-label">E-mail '+ additionalEmail_id +'</label>' +
                '<input type="text" class="form-control input-lg" name="send_to[]" id="send_to_'+ additionalEmail_id +'" placeholder="username@gmail.com" />' +
                '</div><!-- .form-group -->';

            additionalEmail.append(additionalEmail_html);
        });

        if (Cookies.get('ntFormEmail')) {
            $('.controller--nt-form--email').val(Cookies.get('ntFormEmail'));
        }

        $(document).on('keyup', '.controller--nt-form--email', function() {
            Cookies.set('ntFormEmail', $(this).val(), { expires: 7, path: '/' });
        });

        ntForm.on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serializeArray();
            var ntFormReqUsernameCheck = false;
            var ntFormReqPasswordCheck = false;
            var ntFormReqIndexCheck = false;

            if (ntFormReqUsername.val() == '') {
                ntFormReqUsername.parent().addClass('has-error');
                ntFormReqUsername.parent().find('.help-block').removeClass('hide').html('Username is required!');
                ntFormReqUsername.parent().find('.help-block').removeClass('hide').html('Username is required!');
            } else {
                ntFormReqUsernameCheck = true;
                ntFormReqUsername.parent().removeClass('has-error');
                ntFormReqUsername.parent().find('.help-block').addClass('hide');
            }

            if (ntFormReqPassword.val() == '') {
                ntFormReqPassword.parent().addClass('has-error');
                ntFormReqPassword.parent().find('.help-block').removeClass('hide').html('Password is required!');
            } else {
                ntFormReqPasswordCheck = true;
                ntFormReqPassword.parent().removeClass('has-error');
                ntFormReqPassword.parent().find('.help-block').addClass('hide');
            }

            if (ntFormReqIndex.val() == '') {
                ntFormReqIndex.parent().addClass('has-error');
                ntFormReqIndex.parent().find('.help-block').removeClass('hide').html('Index name is required!');
            } else {
                ntFormReqIndexCheck = true;
                ntFormReqIndex.parent().removeClass('has-error');
                ntFormReqIndex.parent().find('.help-block').addClass('hide');
            }

            if (ntFormReqUsernameCheck && ntFormReqPasswordCheck && ntFormReqIndexCheck) {

                progressBar.removeClass('hide');
                progressBar.find('.progress-bar').css('width', 0 + '%');

                ntForm_disabled();

                progressBar.find('.progress-bar').css('width', 20 + '%');

                ntContent.html('<div class="alert alert-info">Sending your newsletter now...</div>');

                var ajaxNT = $.ajax({
                    type: 'GET',
                    url: 'newsletter-tester.php',
                    data: formData
                });

                progressBar.find('.progress-bar').css('width', 30 + '%');

                ajaxNT.done(function() {
                    ntForm_enabled();
                    ntContent.html('<div class="alert alert-success">Done!</div>');
                    progressBar.find('.progress-bar').css('width', 50 + '%');
                });

                ajaxNT.success(function(output) {

                    progressBar.find('.progress-bar').css('width', 100 + '%');

                    setTimeout(function() {
                        progressBar.addClass('hide');
                    }, 1000);

                    if (output.status == 'success') {
                        ntContent.html('<div class="alert alert-success">Newsletter successfully send!</div>');
                        ntContent.append(output.content);
                    } else {
                        ntContent.html('<div class="alert alert-danger">Oop! Something went wrong. '+ output.message +'</div>');
                    }
                });
            } else {
                ntContent.html('<div class="alert alert-danger">Duh!</div>');
            }

        });
    });
</script>
</body>
</html>