<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Bimbingan Mahasiswa List 
            <?php if (!in_array($user['role_id'], [2,3])) { ?>
            <button class="btn btn-primary btn-sm float-end btnAdd" data-bs-toggle="modal" data-bs-target="#formModal">Create New</button>
            <?php } ?>
        </h5>
    </div>
    <div class="card-body pt-0">
        <?php if (count($data) && in_array($user['role_id'], [2,3])) { ?>
        <table class="table table-bordered" style="width: 30%">
            <tr>
                <td>Nama Dosbing</td>
                <td>:</td>
                <td><?= $data[0]['teacher_name'] ?></td>
            </tr>
            <tr>
                <td>NPP</td>
                <td>:</td>
                <td><?= $data[0]['teacher_npp'] ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><?= $data[0]['teacher_email'] ?></td>
            </tr>
        </table>
        <?php } else { ?>
            <form id="filter_form" action="" method="GET">
                <div class="mb-3">
                    <label for="filter_teacher_id" class="col-form-label">Pilih Dosbing:</label>
                    <select name="filter_teacher_id" id="filter_teacher_id" class="form-select">
                        <option value="">Pilih Dosbing</option>
                        <?php foreach ($teachers as $teacher) : ?>
                            <option value="<?= $teacher['id'] ?>" <?= isset($_GET['filter_teacher_id']) ? ($_GET['filter_teacher_id'] == $teacher['id'] ? 'selected' : 'a') : 'b' ?> ><?= $teacher['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </form>
        <?php } ?>

        <?php if ((isset($_GET['filter_teacher_id']) && $_GET['filter_teacher_id'] !== '') || in_array($user['role_id'], [2,3])) { ?>
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>

                        <th>Dosbing</th>
                        <th>NPP</th>
                        <th>Email</th>

                        <th>Nim</th>
                        <th>Name</th>

                        <th>TA 1</th>
                        <th>TA 2</th>
                        <th>BAB</th>
                        <th>Status</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $key => $item) : ?>

                        <tr>
                            <td><?= $key + 1 ?> </td>
                            <td><?= $item['teacher_name'] ?> </td>
                            <td><?= $item['teacher_npp'] ?> </td>
                            <td><?= $item['teacher_email'] ?> </td>
                            <td><?= $item['student_nim'] ?> </td>
                            <td><?= $item['student_name'] ?> </td>
                            <td><?= strtoupper($item['ta_1']) ?> </td>
                            <td><?= strtoupper($item['ta_2']) ?> </td>
                            <td><?= $item['bab_terakhir'] ?? 0 ?> </td>
                            <td><?= $item['status_terakhir'] ?? '-' ?> </td>

                            <td>
                                <a href="<?= base_url('bimbingan/logBook/' . $item['id']); ?>">
                                    <button class="btn btn-primary btn-sm">Log Book</button>
                                </a>

                                <?php if (!in_array($user['role_id'], [2,3])) { ?>
                                <a href="<?= base_url('bimbingan/setUpdate/' . $item['id']) . '/' . $_GET['filter_teacher_id'] . '?ta_1=y'; ?>" <?= $item['ta_1'] === 'y' ? 'hidden' : '' ?>>
                                    <button class="btn btn-success btn-sm">Set TA 1</button>
                                </a>
                                <a href="<?= base_url('bimbingan/setUpdate/' . $item['id']) . '/' . $_GET['filter_teacher_id'] . '?ta_2=y'; ?>" <?= $item['ta_2'] === 'y' ? 'hidden' : '' ?>>
                                    <button class="btn btn-success btn-sm">Set TA 2</button>
                                </a>
                                <a href="<?= base_url('bimbingan/setUpdate/' . $item['id']) . '/' . $_GET['filter_teacher_id'] . '?ta_1=n'; ?>" <?= $item['ta_1'] === 'n' ? 'hidden' : '' ?>>
                                    <button class="btn btn-warning btn-sm">Batalkan TA 1</button>
                                </a>
                                <a href="<?= base_url('bimbingan/setUpdate/' . $item['id']) . '/' . $_GET['filter_teacher_id'] . '?ta_2=n'; ?>" <?= $item['ta_2'] === 'n' ? 'hidden' : '' ?>>
                                    <button class="btn btn-warning btn-sm">Batalkan TA 2</button>
                                </a>
                                
                                <form action="<?= base_url('bimbingan/delete/' . $item['id']); ?>" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure delete ?')">Delete</button>
                                </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('bimbingan/create'); ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="teacher_id" class="col-form-label">Dosbing:</label>
                            <!-- <input type="text" class="form-control" name="teacher_id" id="teacher_id" required> -->
                            <select name="teacher_id" id="teacher_id" class="form-select">
                                <?php foreach ($teachers as $teacher) : ?>
                                    <option value="<?= $teacher['id'] ?>"><?= $teacher['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="student_id" class="col-form-label">Mahasiswa:</label>
                            <!-- <input type="text" class="form-control" name="student_id" id="student_id" required> -->
                            <select name="student_id" id="student_id" class="form-select select2">
                                <?php foreach ($students as $student) : ?>
                                    <option value="<?= $student['id'] ?>"><?= $student['nim'] ?> | <?= $student['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send message</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#filter_teacher_id').on('change', function() {
            $('#filter_form').submit()
        })

        $('.select2').select2({
            dropdownParent: $('#formModal')
        });
    })
</script>
<?= $this->endSection(); ?>