<div class="main-menu menu " >
    <style type="text/css">
    
    </style>
    <nav class="nav-menu">
        <ul class="menu">
            <li  class="add-memos menu-item"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']); ?>">Dashboard</a></li>
            <li  class="add-memos menu-item"><a href="<?= $this->Url->build(['controller' => 'Memos', 'action' => 'add']); ?>">Add Memos™</a></li>
            <li class="menu-item"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'backupMemos']); ?>">Backup Memos™</a></li>
            <li class="menu-item"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'exportMemos']); ?>">Export Memos™</a></li>
            <li class="menu-item"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'yourActivity']); ?>">Your Activity</a></li>
            <li class="menu-item customer-support">
                <a target="_blank" href="https://www.celebrium.com/contact/">CUSTOMER SUPPORT</a>
            </li>
            <li class="support-btn menu-item">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']); ?>">Logout</a>
            </li>
        </ul>
    </nav>
</div>
