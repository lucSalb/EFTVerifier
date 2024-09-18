<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitDeleteForm'])) {
        if (!isset($_POST['SeriesNo'])) {
            $errors['NoSm'] = "No security module was selected.";
        } else {
            $securityModuleNo = $_POST['SeriesNo'];
            $response = removeSecurityModule($securityModuleNo);

            if (!$response['Success']) {
                $errors["ErrorOnRemove"] = $response['Error'];
            } else {
                echo '<script>';
                echo "$('#deleteSMModal').modal('hide');";
                echo '</script>';
                $_SESSION['Removed_SM'] = $response['Message'];
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }
    if (isset($_POST['submitEditForm'])) {
        if (!isset($_POST['SeriesNo'])) {
            $errors['NoSm'] = "No security module was selected.";
        } else {
            $SeriesNo = $_POST['SeriesNo'];
            $EditSMName = $_POST['EditSMName'];
            $StatusSMName = $_POST['StatusSMName'];
            $EditSMSeriesNo = $_POST['EditSMSeriesNo'];

            //$response = removeSecurityModule($securityModuleNo);
            if (!$response['Success']) {
                $errors["ErrorOnRemove"] = $response['Error'];
            } else {
                echo '<script>';
                echo "$('#deleteSMModal').modal('hide');";
                echo '</script>';
                $_SESSION['Removed_SM'] = $response['Message'];
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }
    if (isset($_POST['submitDeleteUserForm'])) {
        if (!isset($_POST['Username'])) {
            $errors['NoUser'] = "No security module was selected.";
        } else {
            $username = $_POST['Username'];
            $response = removeUser($username);
            if (!$response['Success']) {
                $errors["ErrorOnRemove"] = $response['Error'];
            } else {
                echo '<script>';
                echo "$('#deletetUserModal').modal('hide');";
                echo '</script>';
                $_SESSION['Removed_user'] = $response['Message'];
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }
}
?>
<?php if (!empty($errors)): ?>
    <div class="modal" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php foreach ($errors as $err): ?>
                        <p> <?php echo $err ?> </p>
                    <?php endforeach ?>
                </div>
                <form class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal" style="width:100px">ok</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#errorModal').modal('show');
        });
    </script>
<?php endif ?>
<?php if (!empty($server_messages)): ?>
    <div class="modal" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Information</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php foreach ($server_messages as $msg): ?>
                        <p> <?php echo $msg ?> </p>
                    <?php endforeach ?>
                </div>
                <form class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal" style="width:100px">ok</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#infoModal').modal('show');
        });
    </script>
<?php endif ?>
<?php
switch ($PageTitle) {
    case "Home":
        echo "<div class=\"modal fade\" id=\"deleteSMModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deletetModalLabel\" aria-hidden=\"true\">
                    <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <h5 class=\"modal-title\" id=\"deletetModalLabel\">Question</h5>
                                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\">×</span>
                                </button>
                            </div>
                            <div id=\"ContentTextRemoveModule\" class=\"modal-body\"></div>
                            <form class=\"modal-footer\" method=\"post\">
                                <input id=\"SMSNo\" name=\"SeriesNo\" hidden/>
                                <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                                <button  name=\"submitDeleteForm\" type=\"submit\" class=\"btn btn-primary\">Yes</button>
                            </form>
                        </div>
                    </div>
                 </div>";
        echo "<div class=\"modal fade\" id=\"EditSMModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"EditModalLabel\" aria-hidden=\"true\">
                 <div class=\"modal-dialog\" role=\"document\">
                     <form class=\"modal-content\" method=\"post\">
                         <input id='SMSNo' name='SeriesNo' hidden/>
                         <div class=\"modal-header\">
                             <h5 class=\"modal-title\" id=\"EditModalLabel\">Edit security module</h5>
                             <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                 <span aria-hidden=\"true\">×</span>
                             </button>
                         </div>
                         <div class=\"modal-body\">
                            <div class='col-12'>
                                <div class='row'>
                                    <h7>Security module name</h7>
                                    <input type='text' value=\"\" class=\"form-control form-control-user\" id=\"EditSMName\" name=\"EditSMName\" placeholder=\"Security module name\">
                                </div>
                                <div class='row'>
                                    <h7>Security module name</h7>
                                    <select value=\"\" class=\"form-control form-control-user\" id=\"StatusSMName\" name=\"StatusSMName\">
                                        <option value=\"Active\">Active</option>
                                        <option value=\"Deregistered\">Deregistered</option>
                                    </select>
                                </div>
                                <div class='row'>
                                    <h7>Security module series number</h7>
                                    <input type='text' value=\"\" class=\"form-control form-control-user\" id=\"EditSMSeriesNo\" name=\"EditSMSeriesNo\" placeholder=\"Security module series number\">
                                </div>
                            </div>
                         </div>
                         <div class=\"modal-footer\">
                            <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                            <button  name=\"submitEditForm\" type=\"submit\" class=\"btn btn-primary\">Confirm</button>
                         </div>
                     </form>
                 </div>
                </div>";
        break;
    case "Users":
        echo "<div class=\"modal fade\" id=\"deletetUserModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"deletetModalLabel\" aria-hidden=\"true\">
                    <div class=\"modal-dialog\" role=\"document\">
                        <div class=\"modal-content\">
                            <div class=\"modal-header\">
                                <h5 class=\"modal-title\" id=\"deletetModalLabel\">Question</h5>
                                <button class=\"close\" type=\"button\" data-dismiss=\"modal\" aria-label=\"Close\">
                                    <span aria-hidden=\"true\">×</span>
                                </button>
                            </div>
                            <div id=\"ContentTextRemoveUser\" class=\"modal-body\"></div>
                            <form class=\"modal-footer\" method=\"post\">
                                <input id=\"Username\" name=\"Username\" hidden/>
                                <button class=\"btn btn-secondary\" type=\"button\" data-dismiss=\"modal\">Cancel</button>
                                <button  name=\"submitDeleteUserForm\" type=\"submit\" class=\"btn btn-primary\">Yes</a>
                            </form>
                        </div>
                    </div>
                </div>";
        break;
}
?>