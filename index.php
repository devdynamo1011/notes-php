<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="container">

        <div class="form-floating">
            <textarea class="form-control note mt-5" placeholder="Leave a comment here"
                style="height: 100px"></textarea>
            <label for="floatingTextarea2">Comments</label>
        </div>
        <button class="btn btn-primary add-btn mt-2">Add</button>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="notes"></tbody>
            </table>
        </div>
        
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('.add-btn').click(function () {
            $.ajax({
                url: "/notes/add-note-api.php",
                method: "POST",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                    note: $('.note').val()
                }),
                success: function (data, textStatus) {
                    if (textStatus == "success") {
                        $('.note').val("");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                }
            });
        });
    });


</script>

</html>