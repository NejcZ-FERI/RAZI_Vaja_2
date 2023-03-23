<div class="container p-4 my-5 bg-white border rounded-3">
    <h3 class="mb-4">Seznam vseh uporabnikov</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Uporabniško ime</th>
                    <th>Ime</th>
                    <th>Priimek</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user->username; ?></td>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->surname; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo ($user->admin == 1) ? 'true' : 'false'; ?></td>
                    <td>
                    <?php if ($user->admin != 1) { ?>
                        <a href='?controller=users&action=edit&id=<?php echo $user->id; ?>'><button class="btn btn-primary">Uredi</button></a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal-<?php echo $user->id; ?>">Izbriši</button>
                        <div class="modal fade" id="delete-modal-<?php echo $user->id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Brisanje uporabnika</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Ali ste prepričani da želite izbrisati uporabnika <?php echo $user->username; ?>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zapri</button>
                                        <a href='?controller=users&action=delete&id=<?php echo $user->id; ?>'><button type="button" class="btn btn-primary">Potrdi</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="text-end">
            <a href="?controller=users&action=create"><button class="btn btn-primary">Dodaj</button></a>
        </div>
    </div>
</div>