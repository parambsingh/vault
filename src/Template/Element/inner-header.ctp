<div class="main-menu menu" >
      <nav class="nav-menu">
        <ul class="menu">
		 <li  class="add-memos menu-item dash-ico <?= $this->request->controller == 'Users' && $this->request->action == "dashboard" ? 'active' : '' ?>">
             <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']); ?>">Dashboard</a>
         </li>
            <li  class="add-memos menu-item add-ico <?= $this->request->controller == 'Memos' && $this->request->action == "add" ? 'active' : '' ?>">
                <a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>"> Add Memos™</a>
            </li>
            <li class="menu-item backup-ico <?= $this->request->controller == 'Users' && $this->request->action == "backupMemos" ? 'active' : '' ?>">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'backupMemos']); ?>">Backup Memos™</a>
            </li>
            <li class="menu-item export-ico <?= $this->request->controller == 'Users' && $this->request->action == "exportMemos" ? 'active' : '' ?>">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'exportMemos']); ?>">Export Memos™</a>
            </li>
            <li class="menu-item activity-ico <?= $this->request->controller == 'Activities' && $this->request->action == "index" ? 'active' : '' ?>">
                <a href="<?= $this->Url->build(['controller' => 'Activities', 'action' => 'index']); ?>">Your Memos™ Activity</a>
            </li>
        </ul>
    </nav>
</div>
