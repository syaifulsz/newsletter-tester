<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Newsletter Tester - Syaiful Shah Zinan</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="nt-body">
    <div class="nt-body-row">
        <div class="nt-body-col nt-body-col--sidebar nt-sidebar">

            <form class="nt-form controller--nt-form" method="get" action="newsletter-tester.php">
                <div class="form-group">
                    <label for="email" class="form-label">Your E-mail</label>
                    <input type="text" class="controller--nt-form--email form-control input-lg" name="email" id="email" placeholder="username@gmail.com" />
                </div><!-- .form-group -->
                <div class="form-group">
                    <label for="password" class="form-label">Your Password</label>
                    <input type="password" class="form-control input-lg" name="password" id="password" placeholder="password" />
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
                    <input type="text" class="form-control input-lg" name="nt_index" id="nt_index" placeholder="email-1/index.html" />
                </div><!-- .form-group -->

                <div class="nt-form-divider"></div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Send</button>
                    <button type="reset" class="btn btn-link btn-block">Reset</button>
                </div><!-- .form-group -->

            </form><!-- .nt-form -->

        </div><!-- .nt-sidebar -->
        <div class="nt-body-col nt-body-col--content nt-content controller--nt-content">
            <div class="alert alert-info">Please fill in NewsletterTestr setting details</div>
        </div>
    </div><!-- .nt-body-row -->
</div><!-- .nt-body -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/js-cookie/src/js.cookie.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {

        var additionalEmail = $('.controller--additional-email');
        var additionalEmail_trigger = $('.controller--additional-email--trigger');
        var ntForm = $('.controller--nt-form');
        var ntContent = $('.controller--nt-content');

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

            ntContent.html('<div class="alert alert-info">Sending your newsletter now...</div>');

            var ajaxNT = $.ajax({
                type: 'GET',
                url: 'newsletter-tester.php',
                data: formData
            });

            ajaxNT.done(function() {
                ntContent.html('<div class="alert alert-success">Done!</div>');
            });

            ajaxNT.success(function(output) {

                if (output.status == 'success') {
                    ntContent.html('<div class="alert alert-success">Newsletter successfully send!</div>');
                } else {
                    ntContent.html('<div class="alert alert-danger">Oop! Something went wrong. '+ output.message +'</div>');
                }
            });

        });
    });
</script>
</body>
</html>