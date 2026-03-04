<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <!-- Flash Message -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Event Management</h4>
            <small class="text-muted">Manage and upload event records</small>
        </div>

        <button class="btn btn-primary rounded-3 shadow-sm px-4"
                data-bs-toggle="modal"
                data-bs-target="#addEventModal">
            <i class="bi bi-calendar-plus me-2"></i> Add Event
        </button>
    </div>

    <!-- TABLE -->
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-white border-0">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-calendar-event me-2 text-primary"></i> Event List
            </h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-3">
                <table id="eventTable" class="table align-middle mb-0 text-center modern-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>S'O Number</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Preview</th>
                            <th width="140">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if(!empty($events)): ?>
                        <?php $no=1; foreach($events as $row): ?>
                            <?php $ext = strtolower(pathinfo($row['event_file'], PATHINFO_EXTENSION)); ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-semibold text-primary"><?= esc($row['so_number']); ?></td>
                                <td><?= esc($row['event_name']); ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                        <?= esc($row['event_date']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(in_array($ext,['jpg','jpeg','png'])): ?>
                                        <img src="<?= base_url('uploads/events/' . esc($row['event_file'])); ?>"
                                             width="70"
                                             class="img-thumbnail rounded-3 shadow-sm">
                                    <?php elseif($ext === 'pdf'): ?>
                                        <a href="<?= base_url('uploads/events/' . esc($row['event_file'])); ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-danger rounded-3">
                                           <i class="bi bi-file-earmark-pdf"></i> View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">Unsupported</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary rounded-3 me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal<?= $row['id']; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <a href="<?= base_url('delete-event/' . $row['id']); ?>"
                                       class="btn btn-sm btn-outline-danger rounded-3"
                                       onclick="return confirm('Delete this event?');">
                                       <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <!-- EDIT MODAL -->
                            <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow-lg">

                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">Edit Event</h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <form action="<?= base_url('update-event/' . $row['id']); ?>"
                                                  method="post"
                                                  enctype="multipart/form-data">

                                                <?= csrf_field(); ?>

                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <input type="number"
                                                               name="so_number"
                                                               value="<?= esc($row['so_number']); ?>"
                                                               class="form-control rounded-3"
                                                               required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <input type="text"
                                                               name="event_name"
                                                               value="<?= esc($row['event_name']); ?>"
                                                               class="form-control rounded-3"
                                                               required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <input type="date"
                                                               name="event_date"
                                                               value="<?= esc($row['event_date']); ?>"
                                                               class="form-control rounded-3"
                                                               required>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <input type="file"
                                                               name="event_file"
                                                               class="form-control rounded-3">
                                                    </div>
                                                </div>

                                                <div class="mt-4 text-end">
                                                    <button class="btn btn-primary px-4 rounded-3">
                                                        Update Event
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-5 text-muted">
                                No events found.
                            </td>
                        </tr>
                    <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ADD MODAL (UNCHANGED) -->
<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Add New Event</h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('save-event'); ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field(); ?>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <input type="number" name="so_number"
                                   class="form-control rounded-3"
                                   placeholder="S'O Number" required>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="event_name"
                                   class="form-control rounded-3"
                                   placeholder="Event Name" required>
                        </div>

                        <div class="col-md-4">
                            <input type="date" name="event_date"
                                   class="form-control rounded-3"
                                   required>
                        </div>

                        <div class="col-md-12">
                            <input type="file" name="event_file"
                                   class="form-control rounded-3"
                                   required>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button class="btn btn-primary px-4 rounded-3">
                            Save Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DATATABLES -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    $('#eventTable').DataTable({
        pageLength: 5,
        lengthChange: false,  
        info: false,          
        ordering: true,
        searching: true,
        responsive: true,
        language: {
            search: "",
            searchPlaceholder: "Search by  Event Name "
        }
    });

    // Style search input
    $('.dataTables_filter input')
        .attr('placeholder', 'Search by  Event Name ')
        .addClass('form-control rounded-3 shadow-sm')
        .css({
            'width': '250px',
            'display': 'inline-block',
            'margin-left': '8px'
        });
});
</script>

<?= $this->endSection(); ?>