<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<h1 class="h3 mb-3"><strong><?= $title; ?></strong> List Menu </h1>
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0"> Log Book List
            <?php if (in_array($user['role_id'], [1,3])) { ?>
            <button class="btn btn-primary btn-sm float-end btnAdd" data-bs-toggle="modal" data-bs-target="#formModal">Create New</button>
            <?php } ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>#</th>

                        <th>Tanggal</th>

                        <th>Uraian</th>
                        <th>BAB</th>

                        <th>Status</th>
                        <th>Checklist</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($log_books as $key => $item) : ?>
                        <tr>
                            <td><?= $key + 1 ?> </td>
                            <td><?= date('d F Y', strtotime($item['tanggal'])); ?></td>
                            <td><?= $item['uraian'] ?> </td>
                            <td><?= $item['bab_terakhir'] ?> </td>
                            <td><?= $item['status'] ?> </td>
                            <td>
                                <input 
                                    type="checkbox" 
                                    name="checklist" 
                                    value="<?= $item['checklist'] ?>" 
                                    data-id="<?= $item['id'] ?>"
                                    <?= $item['checklist'] == 1 ? 'checked' : ''  ?>
                                    <?= in_array($user['role_id'], [3]) ? 'disabled' : '' ?> 
                                >
                                <form id="checklistForm<?= $item['id'] ?>" action="<?= base_url('bimbingan/logBookChecklist/' . $item['id']); ?>" method="post" class="d-inline">
                                </form>
                            </td>

                            <td>
                                <?php if (in_array($user['role_id'], [1,2])) { ?>
                                <a href="#" class="edit btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#formModal" data-id="<?= $item['id'] ?>" data-tanggal="<?= $item['tanggal'] ?>" data-uraian="<?= $item['uraian'] ?>" data-bab_terakhir="<?= $item['bab_terakhir'] ?>" data-status="<?= $item['status'] ?>">Edit</a>

                                <form action="<?= base_url('bimbingan/logBookDelete/' . $bimbingan_id . '/' . $item['id']); ?>" method="post" class="d-inline">
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
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('bimbingan/logBookCreate/'.$bimbingan_id); ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="bimbingan_id" id="bimbingan_id" value="<?= $bimbingan_id; ?>">
                        
                        <div class="mb-3">
                            <label for="tanggal" class="col-form-label">Tanggal Bimbingan:</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label for="uraian" class="col-form-label">Uraian:</label>
                            <textarea class="form-control" name="uraian" id="uraian" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="bab_terakhir" class="col-form-label">Bab Terakhir:</label>
                            <!-- <input type="number" class="form-control" name="bab_terakhir" id="bab_terakhir" required> -->
                            <select name="bab_terakhir" id="bab_terakhir" class="form-select" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="col-form-label">Status:</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="ACC">ACC</option>
                                <option value="Revisi">Revisi</option>
                                <option value="Lanjutan">Lanjut</option>
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
        let fields = [
            'id',
            // 'bimbingan_id',
            'tanggal',
            'uraian',
            'bab_terakhir',
            'status',
            'checklist',
        ];

        $(".btnAdd").click(function() {
            $('#modalTitle').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Simpan');
            $('.modal-content form').attr('action', '<?= base_url('bimbingan/logBookCreate/'.$bimbingan_id); ?>');

            for (const field of fields) {
                $(`#${field}`).val(``);
                if(field =='password') {
                    $(`#${field}`).attr('required', true);
                }
            }
            
        });
        // $(".btnEdit").click(function() {
            
        //     $('#modalTitle').html('form Edit Data');
        //     $('.modal-footer button[type=submit]').html('Edit Data');
        //     $('.modal-content form').attr('action', '<?= base_url('students/update') ?>');

        //     for (const field of fields) {
        //         $(`#${field}`).val(
        //             $(this).data(`${field}`)
        //         );
        //         if(field =='password') {
        //             $(`#${field}`).attr('required', false);
        //         }
        //     }
        // });

        $('input[name=checklist]').on('click', function() {
            $('#checklistForm'+$(this).data(`id`)).submit()
        })

        $('tbody tr td .edit').on('click', function(e) {
            e.preventDefault();
            const dataset = e.currentTarget.dataset;
            
            $('#modalTitle').html('form Edit Data');
            $('.modal-footer button[type=submit]').html('Edit Data');
            $('.modal-content form').attr('action', `<?= base_url('bimbingan/logBookUpdate'); ?>/${dataset.id}/<?= $bimbingan_id ?>`);

            for (const field of fields) {
                if (dataset[field]) {
                    $(`#${field}`).val(dataset[field]);
                    if(field =='password') {
                        $(`#${field}`).attr('required', false);
                    }
                }
            }
        })
    });
</script>
<?= $this->endSection(); ?>