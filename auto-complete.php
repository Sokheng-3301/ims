
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<input type="text" id="autocomplete" placeholder="Enter a fruit">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<!-- <script src="script.js"></script> -->
<script>
    $(function() {
    $('input#autocomplete').autocomplete({
        source: function(request, response) {
            $.getJSON('autocomplete.php', {
                term: request.term
            }, response);
        }
    });
});
</script>
</body>
</html>

