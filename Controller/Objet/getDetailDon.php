<?php
require ROOT . '/Model/DonsActifsModel.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $item = get_object_by_id($id);

?>
    <h2><?php $item['nomObjet'] ?></h2>
<?php
}
