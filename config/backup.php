<?php

return [
    'dir'=> env('BACKUP_DIR', '/data/backup/data'),
    'warning_duration'=> env('BACKUP_WARNING_DURATION', 3600),
    'warning_contact'=> env('BACKUP_WARNING_CONTACT', '17kong.dev@geneegroup.com'),
];
