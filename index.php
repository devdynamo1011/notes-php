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

    <div class="modal fade centered" tabindex="-1" id="exampleModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <textarea class="form-control update-note" placeholder="Leave a comment here"
                            style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Comments</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-note-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="form-floating">
            <textarea class="form-control note mt-5" placeholder="Leave a comment here"
                style="height: 100px"></textarea>
            <label for="floatingTextarea2">Comments</label>
        </div>

        <nav class="navbar bg-body-tertiary">
            <div class="container-fluid">
                <button class="btn btn-primary add-btn mt-2">Add</button>
                <div class="d-flex">
                    <input class="form-control me-2 search-keyword" type="search" placeholder="Search" aria-label="Search"/>
                </div>
            </div>
        </nav>

        <div class="table-responsive mt-2">
            <table class="table table-primary table-hover">
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

        function setModal(note){
            $('.update-note').val(note.note);
           
            $('.update-note-btn').click(function(){
                $.ajax({
                    url: "/notes/update-note-api.php",
                    method: "PATCH",
                    contentType: "application/json",
                    dataType: "json",
                    data: JSON.stringify({
                        id: note.id,
                        note: $('.update-note').val()
                    }),
                    success: function (data, textStatus) {
                        if (textStatus == "success") {
                            $("#exampleModal").removeClass("show");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                    }
                });
            });

        }

        function addNewRow(note){
            let $tr = $("<tr></tr>"); 
            let $td1 = $("<td></td>");
            let $td2 = $("<td></td>");
            let $ediBtn = $("<button>Edit</button>");
            let $deleteBtn = $("<button>Delete</button>");
            
            $deleteBtn.click(function(){
                $.ajax({
                    url: "/notes/delete-note-api.php",
                    method: "DELETE",
                    contentType: "application/json",
                    dataType: "json",
                    data: JSON.stringify({
                        id: note.id
                    }),
                    success: function (data, textStatus) {
                        if (textStatus == "success") {
                            $deleteBtn.parent().parent().remove();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                    }
                });
            });

            $ediBtn.attr("data-bs-toggle","modal");
            $ediBtn.attr("data-bs-target","#exampleModal");

            $ediBtn.click(function(){
                setModal(note);
            });

            $td1.text(note.note);
            $td2.append($ediBtn);
            $td2.append($deleteBtn);

            $tr.append($td1);
            $tr.append($td2);
            $('.notes').append($tr);
        }
        
        function loadData(data, textStatus) {
            if (textStatus == "success") {
                $('.notes').empty();
                data.notes.forEach((note)=>{
                    addNewRow(note);
                })
            }
        }

        $.ajax({
            url: "/notes/notes-api.php",
            method: "GET",
            contentType: "application/json",
            success: loadData
        });

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
                        console.log(data);
                        addNewRow({
                            id:data.last_id,
                            note:$('.note').val()
                        });
                        $('.note').val("");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                }
            });
        });
    
        $('.search-keyword').on("input",function(){
            
            $.ajax({
                url: "/notes/search-note-api.php",
                method: "POST",
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                    search: $('.search-keyword').val()
                }),
                success: function (data, textStatus) {
                    if (textStatus == "success") {
                        loadData(data, textStatus);
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
