<!-- Begin Page Content -->
<div class="container-fluid">

 <!-- Page Heading -->
 <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>


 <div class="row">
  <div class="col-lg">
   <?php if (validation_errors()): ?>
   <div class="alert alert-danger font-weight-bold" role="alert">
    <?= validation_errors(), $this->session->unset_userdata("new") ?>
   </div>
   <?php endif; ?>

   <?= $this->session->flashdata("new"),
   	$this->session->unset_userdata("new") ?>

   <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New SubMenu</a>
   <table class="table table-hover">
    <thead>
     <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Menu</th>
      <th scope="col">Url</th>
      <th scope="col">Active</th>
      <th scope="col">Action</th>
     </tr>
    </thead>
    <tbody>
     <?php $i = 1; ?>
     <?php foreach ($subMenu as $sm): ?>
     <tr>
      <th scope="row"><?= $i ?></th>
      <td><?= $sm["title"] ?></td>
      <td><?= $sm["menu"] ?></td>
      <td><?= $sm["url"] ?></td>
      <td><?= $sm["icon"] ?></td>
      <td><?= $sm["is_actived"] ?></td>
      <td>
       <a href="" class="badge badge-success">Edit</a>
       <a href="" class="badge badge-danger">Delete</a>
      </td>
     </tr>
     <?php $i++; ?>
     <?php endforeach; ?>
    </tbody>
   </table>
  </div>
 </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
   </div>
   <form action="<?= base_url("menu/submenu") ?>" method="post">
    <div class="modal-body">
     <form>
      <div class="form-group">
       <input type="text" class="form-control" id="title" name="title" placeholder="SubMenu title">
      </div>
      <div class="form-group">
       <select name="menu_id" id="menu_id" class="form-control">
        <option value="">SELECT MENU</option>
        <?php foreach ($menu as $m): ?>
        <option value="<?= $m["id"] ?>"><?= $m["menu"] ?></option>
        <?php endforeach; ?>
       </select>
      </div>
      <div class="form-group">
       <input type="text" class="form-control" id="url" name="url" placeholder="SubMenu Url">
      </div>
      <div class="form-group">
       <input type="text" class="form-control" id="icon" name="icon" placeholder="SubMenu Icon">
      </div>
      <div class="form-group">
       <div class="form-check">
        <input class="form-check-input" type="checkbox" value="1" id="is_actived" name="is_actived" checked>
        <label class="form-check-label" for="is_actived">
         Active ?
        </label>
       </div>
      </div>
    </div>
    <div class="modal-footer">
     <button type="submit" class="btn btn-primary">Add</button>
    </div>
   </form>
  </div>
 </div>
</div>