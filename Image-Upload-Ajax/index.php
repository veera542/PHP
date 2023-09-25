<html>
<head>
    <title>Add Delete Image via jQuery AJAX</title>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#uploadForm").on('submit', (function (e) {
                e.preventDefault();
                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $("#targetLayer").html(data);
                    },
                    error: function () { }
                });
            }));

            function deleteImage(path) {
                $.ajax({
                    url: "delete.php",
                    type: "POST",
                    data: { 'path': path },
                    success: function (data) {
                        $("#targetLayer").html('<div class="no-image">No Image</div>');
                    },
                    error: function () { }
                });
            }
        });
    </script>
</head>
<body>
<div class="bgColor">
    <form id="uploadForm" action="upload.php" method="post">
        <div id="targetLayer"><div class="no-image">No Image</div></div>
        <div id="uploadFormLayer">
            <label>Upload Image File:</label><br/>
            <input name="userImage" type="file" class="inputFile" />
            <input type="submit" value="Submit" class="btnSubmit" />
        </div>
    </form>
</div>
</body>
</html>
