<?php

namespace App\Models;

use App\System\Model;

class MvcNoteModel extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'noteid';
    protected $allowedFields    = ['title', 'userid', 'content', 'date_added'];
}
