<?php

namespace App\Models;

use App\System\Model;

class TutorialModel extends Model
{
    protected $table = 'user_ci_tutorial';

    protected $allowedFields = ['user_id', 'type', 'email', 'password', 'date_added'];

    /**
     * @param false|string $slug
     *
     * @return array|null
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }

        return $this->where(['slug' => $slug])->first();
    }
}

