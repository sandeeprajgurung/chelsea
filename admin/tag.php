<?php
include_once '../config/partials/display_errors.php';
?>
<!DOCTYPE html>
<html>

<head>
    <?php
    include_once "./partials/head.php";
    ?>
</head>

<body>
    <?php
    include_once "./partials/navbar.php";
    // echo $_SERVER['REQUEST_URI'];die;
    ?>
    <div class="page-content">
        <?php
        include_once "./partials/top_navbar.php";
        ?>
        <div class="container-fluid px-6 py-4">
            <h4 class="mb-4">Tag</h4>
            <div class="card my-4">
                <div class="card-body">
                    <form class="needs-validation tag-form" novalidate>
                        <div class="row g-3 align-items-center py-3">
                            <div class="col-auto m-0">
                                <label for="name" class="col-form-label">New tag</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                                <em id="name-error" class="error help-block"></em>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary js-submit-tag">Submit</button>
                    </form>
                </div>
            </div>

            <div class="card my-4">
                <div class="card-body">
                    <table class="table table-success table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="tag-table-body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include_once "./partials/alert_msg.php"; ?>
    </div>
    <?php
    include_once "./partials/script.php";
    ?>
    <script src="./assets/js/tag.js"></script>
    <script>
        feather.replace()
    </script>
</body>

</html>