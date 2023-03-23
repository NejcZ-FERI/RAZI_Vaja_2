<div>
    <h3>Seznam vseh oglasov</h3>
    <a href="?controller=users&action=create"><button>Dodaj</button></a>
    <table>
        <thead>
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
                    <a href='?controller=ads&action=edit&id=<?php echo $user->id; ?>'><button>Uredi</button></a>
                    <a href='?controller=ads&action=delete&id=<?php echo $user->id; ?>'><button>Izbriši</button></a>
                <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>