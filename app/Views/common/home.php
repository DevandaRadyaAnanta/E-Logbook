<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<?php if(isset($user['role_id']) && $user['role_id'] == 1) { ?>
<div class="row">
    <div class="col-6">
        <div class="card ">
            <div class="card-body d-flex justify-content-center">
                <div class="chart_container">

                    <canvas id="chartCanvas3" width="400" height="400">
                        Your web-browser does not support the HTML 5 canvas element.
                    </canvas>

                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card ">
            <div class="card-header">
                <h5 class="card-title mb-0">Table Statistik Bimbingan</h5>
            </div>
            <div class="card-body pt-0">

                <div class="table-responsive">
                    <?php $babs = [1, 2, 3, 4, 5] ?>
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <?php foreach ($babs as $bab) { ?>
                                    <th colspan="2">Bab <?= $bab ?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <?php foreach ($babs as $bab) { ?>
                                    <th>ACC</th>
                                    <th>Revisi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach ($babs as $bab) { ?>
                                    <td><?= $statistik["$bab" . "ACC"] ?? 0 ?></td>
                                    <td><?= $statistik["$bab" . "Revisi"] ?? 0 ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Ganti Kata Sandi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('home/changePassword'); ?>" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputPassword" class="col-form-label">Password:</label>
                        <input type="password" class="form-control" name="inputPassword" id="inputPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ganti Nanti</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('document').ready(function() {
        var myModal = new bootstrap.Modal(document.getElementById('changePasswordModal'), {
            keyboard: false,
            show: true
        })
        <?php if(isset($user['change_password']) && $user['change_password'] == 1) { ?>
        myModal.show()
        <?php } ?>

    })
</script>

<script>
    var xValues = <?= json_encode(array_column($chart, 'bab')) ?>;
    var yValues = <?= json_encode(array_column($chart, 'jumlah')) ?>;
    var barColors = ['#006CFF', '#FF6600', '#34A038', '#945D59', '#93BBF4', '#F493B8'];

    new Chart("chartCanvas3", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "Statistik Bimbingan"
            }
        }
    });
</script>
<?= $this->endSection(); ?>